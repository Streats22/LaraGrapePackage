<?php

namespace LaraGrape\Services;

use DOMDocument;
use DOMXPath;
use Illuminate\Support\Str;
use LaraGrape\Support\TechStackRegistry;

class BlockLayoutService
{
    public function __construct(
        protected BlockService $blockService,
        protected GrapesJsConverterService $converterService,
        protected DynamicBlockDataService $dynamicBlockDataService,
        protected TechStackRegistry $techStackRegistry,
    ) {}

    /**
     * @param  list<array{block_id?: string, instance_key?: string, dynamic_data?: array<string, mixed>, custom_html?: string}>  $blockLayout
     * @return array{html: string, css: string}
     */
    public function compileToGrapesJsInput(array $blockLayout): array
    {
        $htmlParts = [];
        $instanceCounters = [];

        foreach ($blockLayout as $row) {
            $blockId = trim((string) ($row['block_id'] ?? ''));
            if ($blockId === '') {
                continue;
            }

            $instanceIndex = $instanceCounters[$blockId] ?? 0;
            $instanceCounters[$blockId] = $instanceIndex + 1;
            $instanceKey = $row['instance_key'] ?? $this->buildInstanceKey($blockId, $instanceIndex);

            $blockHtml = $this->compileBlockHtml($blockId, $row);
            if ($blockHtml === null || trim($blockHtml) === '') {
                continue;
            }

            $htmlParts[] = $this->ensureBlockMarker($blockId, $blockHtml, $instanceKey);
        }

        return [
            'html' => implode("\n", $htmlParts),
            'css' => '',
        ];
    }

    /**
     * @param  array<string, mixed>  $row
     */
    protected function compileBlockHtml(string $blockId, array $row): ?string
    {
        return $this->renderBlockPreviewHtml($blockId, $row);
    }

    /**
     * @return list<array{block_id: string, instance_key: string, dynamic_data: array<string, mixed>}>
     */
    public function decompileFromHtml(string $html): array
    {
        if (trim($html) === '') {
            return [];
        }

        $fragments = $this->collectBlockFragments($html);
        $rows = [];

        foreach ($fragments as $fragment) {
            $blockId = $fragment['block_id'];
            $instanceIndex = $fragment['instance_index'];
            $fragmentHtml = $fragment['html'];

            $dynamicData = $this->dynamicBlockDataService->extractDynamicData(
                ['html' => $fragmentHtml],
                $blockId,
            );

            if ($dynamicData === [] && $blockId === 'hero') {
                $dynamicData = $this->extractHeroLayoutFields($fragmentHtml);
            }

            $rows[] = [
                'block_id' => $blockId,
                'instance_key' => $this->buildInstanceKey($blockId, $instanceIndex),
                'dynamic_data' => $dynamicData,
            ];
        }

        return $rows;
    }

    /**
     * @return array<string, string>
     */
    protected function extractHeroLayoutFields(string $html): array
    {
        $dom = new DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);

        $read = function (string $gjsName) use ($xpath): string {
            $nodes = $xpath->query("//*[@data-gjs-name='{$gjsName}']");
            if ($nodes->length === 0) {
                return '';
            }

            return trim($nodes->item(0)?->textContent ?? '');
        };

        return array_filter([
            'title' => $read('hero-title'),
            'subtitle' => $read('hero-subtitle'),
            'button_text' => $read('hero-button'),
        ]);
    }

    /**
     * Process block layout into page save attributes (grapesjs_data, blade_content).
     *
     * @param  list<array<string, mixed>>  $blockLayout
     * @return array{grapesjs_data: array<string, mixed>, blade_content: string, grapesjs_html: ?string, grapesjs_css: ?string}
     */
    public function processBlockLayoutForSave(array $blockLayout): array
    {
        $grapesjsInput = $this->compileToGrapesJsInput($blockLayout);
        $processedData = $this->converterService->processForSaving($grapesjsInput);
        $processedData['original_grapesjs'] = $grapesjsInput;

        return [
            'grapesjs_data' => $processedData,
            'blade_content' => $this->converterService->convertToBlade($processedData),
            'grapesjs_html' => $processedData['html'] ?? null,
            'grapesjs_css' => $processedData['css'] ?? null,
        ];
    }

    public function buildInstanceKey(string $blockId, int $instanceIndex): string
    {
        return $blockId.'__'.$instanceIndex;
    }

    /**
     * @param  array<string, mixed>  $row
     */
    public function renderBlockPreviewHtml(string $blockId, array $row = []): ?string
    {
        if (trim($blockId) === '') {
            return null;
        }

        $dynamicData = is_array($row['dynamic_data'] ?? null) ? $row['dynamic_data'] : [];
        $dynamicData = $this->normalizeDynamicData($blockId, $dynamicData);
        $customHtml = trim((string) ($row['custom_html'] ?? ''));

        $html = $this->blockService->renderBlockPreviewForBuilder($blockId, [
            'dynamic_data' => $dynamicData,
            'custom_html' => $customHtml,
            'is_block_builder_preview' => true,
        ]);

        if ($html === null || trim($html) === '') {
            return null;
        }

        return $html;
    }

    /**
     * @param  list<array<string, mixed>>  $blockLayout
     * @return list<array{block_id: string, label: string, html: string}>
     */
    public function buildPreviewStack(array $blockLayout): array
    {
        $labelMap = [];
        foreach ($this->blockService->getGrapesJsBlocks() as $block) {
            $id = $block['id'] ?? '';
            if ($id !== '') {
                $labelMap[$id] = $block['label'] ?? $id;
            }
        }

        $stack = [];

        foreach ($blockLayout as $row) {
            if (! is_array($row)) {
                continue;
            }

            $blockId = trim((string) ($row['block_id'] ?? ''));
            if ($blockId === '') {
                continue;
            }

            $html = $this->renderBlockPreviewHtml($blockId, $row);
            if ($html === null) {
                continue;
            }

            $stack[] = [
                'block_id' => $blockId,
                'label' => $labelMap[$blockId] ?? $blockId,
                'html' => $html,
            ];
        }

        return $stack;
    }

    protected function ensureBlockMarker(string $blockId, string $html, string $instanceKey): string
    {
        if (preg_match('/\sdata-laragrape-block="/', $html)) {
            return $html;
        }

        $trimmed = trim($html);
        if (preg_match('/^<([a-zA-Z][a-zA-Z0-9]*)(\s[^>]*)?>/', $trimmed, $matches, PREG_OFFSET_CAPTURE)) {
            $tag = $matches[1][0];
            $insertAt = $matches[0][1] + strlen($matches[0][0]) - 1;
            $attrs = ' data-laragrape-block="'.e($blockId, false).'" data-laragrape-instance="'.e($instanceKey, false).'"';

            return substr_replace($trimmed, $attrs, $insertAt, 0);
        }

        return '<div data-laragrape-block="'.e($blockId, false).'" data-laragrape-instance="'.e($instanceKey, false).'">'.$trimmed.'</div>';
    }

    /**
     * @return list<array{block_id: string, instance_index: int, html: string}>
     */
    protected function collectBlockFragments(string $html): array
    {
        $fragments = [];
        $instanceCounters = [];
        $pattern = '/<([a-zA-Z][a-zA-Z0-9]*)[^>]*\sdata-laragrape-block="([a-zA-Z0-9_-]+)"[^>]*>(.*)$/s';
        $offset = 0;

        while (preg_match($pattern, $html, $matches, PREG_OFFSET_CAPTURE, $offset)) {
            $tagName = $matches[1][0];
            $blockId = $matches[2][0];
            $matchStart = $matches[0][1];
            $contentStart = $matches[3][1];
            $elementEnd = $this->findMatchingClosingTag($html, $tagName, $contentStart);

            if ($elementEnd === null) {
                $offset = $contentStart;
                continue;
            }

            $instanceIndex = $instanceCounters[$blockId] ?? 0;
            $instanceCounters[$blockId] = $instanceIndex + 1;

            $fragments[] = [
                'block_id' => $blockId,
                'instance_index' => $instanceIndex,
                'html' => substr($html, $matchStart, $elementEnd - $matchStart),
            ];

            $offset = $elementEnd;
        }

        return $fragments;
    }

    protected function findMatchingClosingTag(string $html, string $tagName, int $contentStart): ?int
    {
        $voidElements = ['area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'source', 'track', 'wbr'];
        if (in_array(strtolower($tagName), $voidElements, true)) {
            $close = strpos($html, '>', $contentStart);

            return $close !== false ? $close + 1 : null;
        }

        $depth = 1;
        $pos = $contentStart;
        $openPattern = '/<'.$tagName.'(?:\s[^>]*)?>/i';
        $closePattern = '/<\/'.$tagName.'>/i';

        while ($depth > 0 && $pos < strlen($html)) {
            $nextOpen = preg_match($openPattern, $html, $openMatch, PREG_OFFSET_CAPTURE, $pos)
                ? $openMatch[0][1]
                : PHP_INT_MAX;
            $nextClose = preg_match($closePattern, $html, $closeMatch, PREG_OFFSET_CAPTURE, $pos)
                ? $closeMatch[0][1]
                : PHP_INT_MAX;

            if ($nextClose === PHP_INT_MAX) {
                return null;
            }

            if ($nextOpen < $nextClose) {
                $depth++;
                $pos = $nextOpen + strlen($openMatch[0][0]);
            } else {
                $depth--;
                $pos = $nextClose + strlen($closeMatch[0][0]);
                if ($depth === 0) {
                    return $pos;
                }
            }
        }

        return null;
    }

    /**
     * Map flat Filament form state to the structure each block Blade expects.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function normalizeDynamicData(string $blockId, array $data): array
    {
        if ($data === []) {
            return [];
        }

        if (in_array($blockId, ['animated-hero', 'animated-full-image-hero'], true)) {
            if (isset($data['hero']) && is_array($data['hero'])) {
                return $data;
            }

            $hero = array_filter([
                'title' => $data['title'] ?? null,
                'description' => $data['description'] ?? null,
                'primaryButton' => filled($data['primary_button_text'] ?? null)
                    ? ['text' => $data['primary_button_text']]
                    : null,
                'secondaryButton' => filled($data['secondary_button_text'] ?? null)
                    ? ['text' => $data['secondary_button_text']]
                    : null,
                'image' => filled($data['image_src'] ?? null)
                    ? [
                        'src' => $data['image_src'],
                        'alt' => $data['image_alt'] ?? 'Hero',
                    ]
                    : null,
            ]);

            return $hero === [] ? [] : ['hero' => $hero];
        }

        if ($blockId === 'animated-tech-stack') {
            if (isset($data['techItems'])) {
                return $data;
            }

            $items = is_array($data['items'] ?? null) ? $data['items'] : [];
            $techItems = [];

            foreach ($items as $index => $item) {
                if (! is_array($item)) {
                    continue;
                }
                $key = (string) ($item['key'] ?? '');
                if ($key === '') {
                    continue;
                }
                $meta = $this->techStackRegistry->resolve($key);
                $techItems[] = [
                    'name' => (string) ($item['label'] ?? $meta['label'] ?? $key),
                    'icon' => (string) ($meta['icon'] ?? '⚙️'),
                    'visible' => false,
                    'delay' => $index * 100,
                ];
            }

            return array_filter([
                'title' => $data['title'] ?? 'Our Tech Stack',
                'subtitle' => $data['subtitle'] ?? 'Technologies we work with',
                'techItems' => $techItems,
                'items' => $items,
            ]);
        }

        if (in_array($blockId, ['animated-pricing', 'animated-pricing-clean'], true) && isset($data['plans']) && is_array($data['plans'])) {
            $plans = [];
            foreach ($data['plans'] as $plan) {
                if (! is_array($plan)) {
                    continue;
                }
                $features = [];
                foreach ($plan['features'] ?? [] as $feature) {
                    if (is_array($feature)) {
                        $text = trim((string) ($feature['text'] ?? ''));
                        if ($text !== '') {
                            $features[] = $text;
                        }
                    } elseif (is_string($feature) && trim($feature) !== '') {
                        $features[] = trim($feature);
                    }
                }
                $plan['features'] = $features;
                $plans[] = $plan;
            }
            $data['plans'] = $plans;
        }

        return $data;
    }

    /**
     * @return array<string, string>
     */
    public function blockSelectOptions(): array
    {
        $options = [];

        foreach ($this->blockService->getGrapesJsBlocks() as $block) {
            $id = $block['id'] ?? '';
            if ($id === '') {
                continue;
            }
            $category = Str::title(str_replace(['-', '_'], ' ', (string) ($block['category'] ?? 'blocks')));
            $label = $block['label'] ?? $id;
            $options[$category][$id] = $label;
        }

        return $options;
    }
}
