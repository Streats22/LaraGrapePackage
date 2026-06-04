<?php

namespace LaraGrape\Services;

use DOMDocument;
use DOMXPath;

class BlockHtmlPatcher
{
    /**
     * Apply simple field values to elements matched by data-gjs-name.
     *
     * @param  array<string, string>  $fieldToGjsName
     */
    public function patchByGjsNames(string $html, array $values, array $fieldToGjsName): string
    {
        if (trim($html) === '' || $values === []) {
            return $html;
        }

        $dom = new DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);
        $changed = false;

        foreach ($fieldToGjsName as $field => $gjsName) {
            $value = $values[$field] ?? null;
            if (! is_string($value) || trim($value) === '') {
                continue;
            }

            $nodes = $xpath->query("//*[@data-gjs-name='{$gjsName}']");
            if ($nodes->length === 0) {
                continue;
            }

            $node = $nodes->item(0);
            if ($node === null) {
                continue;
            }

            while ($node->firstChild) {
                $node->removeChild($node->firstChild);
            }
            $node->appendChild($dom->createTextNode($value));
            $changed = true;
        }

        if (! $changed) {
            return $html;
        }

        $output = $dom->saveHTML();
        if ($output === false) {
            return $html;
        }

        return preg_replace('/^<\?xml[^>]*>\s*/u', '', $output) ?? $html;
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchHeroLayout(string $html, array $dynamicData): string
    {
        return $this->patchByGjsNames($html, [
            'title' => (string) ($dynamicData['title'] ?? ''),
            'subtitle' => (string) ($dynamicData['subtitle'] ?? ''),
            'button_text' => (string) ($dynamicData['button_text'] ?? ''),
        ], [
            'title' => 'hero-title',
            'subtitle' => 'hero-subtitle',
            'button_text' => 'hero-button',
        ]);
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchTestimonialsTitle(string $html, array $dynamicData): string
    {
        $title = (string) ($dynamicData['title'] ?? '');
        if ($title === '') {
            return $html;
        }

        return $this->patchByGjsNames($html, ['title' => $title], ['title' => 'testimonials-title']);
    }

    /**
     * Apply block-builder form values to the static editor-preview HTML (no Alpine).
     *
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchForBlockBuilder(string $blockId, string $html, array $dynamicData): string
    {
        if (trim($html) === '' || $dynamicData === []) {
            return $html;
        }

        return match ($blockId) {
            'animated-testimonials' => $this->patchTestimonialsBuilder($html, $dynamicData),
            'hero' => $this->patchHeroLayout($html, $dynamicData),
            'button' => $this->patchByGjsNames($html, [
                'label' => (string) ($dynamicData['label'] ?? ''),
            ], [
                'label' => 'button-label',
            ]),
            'heading' => $this->patchByGjsNames($html, [
                'heading' => (string) ($dynamicData['heading'] ?? $dynamicData['title'] ?? ''),
            ], [
                'heading' => 'heading-text',
            ]),
            'text' => $this->patchByGjsNames($html, [
                'body' => (string) ($dynamicData['body'] ?? ''),
            ], [
                'body' => 'text-content',
            ]),
            'portfolio-grid' => $this->patchByGjsNames($html, [
                'title' => (string) ($dynamicData['title'] ?? ''),
                'subtitle' => (string) ($dynamicData['subtitle'] ?? ''),
            ], [
                'title' => 'grid-title',
                'subtitle' => 'grid-subtitle',
            ]),
            default => $this->patchGenericBuilderFields($html, $dynamicData),
        };
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchTestimonialsBuilder(string $html, array $dynamicData): string
    {
        $html = $this->patchTestimonialsTitle($html, $dynamicData);

        $items = $dynamicData['testimonials'] ?? [];
        if (! is_array($items)) {
            return $html;
        }

        foreach ($items as $index => $item) {
            if (! is_array($item)) {
                continue;
            }

            $n = $index + 1;
            if ($n > 6) {
                break;
            }

            $name = (string) ($item['name'] ?? '');
            $initials = '';
            if ($name !== '') {
                foreach (preg_split('/\s+/', trim($name)) ?: [] as $word) {
                    $initials .= strtoupper(substr($word, 0, 1));
                }
                $initials = substr($initials, 0, 2);
            }

            $html = $this->patchByGjsNames($html, [
                'text' => (string) ($item['text'] ?? ''),
                'name' => $name,
                'title' => (string) ($item['title'] ?? ''),
                'initials' => $initials,
            ], [
                'text' => "testimonial-text-{$n}",
                'name' => "client-name-{$n}",
                'title' => "client-title-{$n}",
                'initials' => "client-initials-{$n}",
            ]);
        }

        return $html;
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchGenericBuilderFields(string $html, array $dynamicData): string
    {
        if (trim((string) ($dynamicData['custom_html'] ?? '')) !== '') {
            return (string) $dynamicData['custom_html'];
        }

        $values = [];
        $names = [];

        foreach ([
            'title' => ['title', 'heading-title', 'section-title', 'grid-title', 'card-title'],
            'body' => ['body', 'text-content', 'content', 'subtitle', 'grid-subtitle', 'description'],
            'button_text' => ['button_text', 'hero-button', 'cta-button'],
            'heading' => ['heading-text', 'heading'],
        ] as $field => $gjsNames) {
            $value = trim((string) ($dynamicData[$field] ?? ''));
            if ($value === '') {
                continue;
            }

            foreach ($gjsNames as $gjsName) {
                $values[$field.'_'.$gjsName] = $value;
                $names[$field.'_'.$gjsName] = $gjsName;
            }
        }

        return $this->patchByGjsNames($html, $values, $names);
    }
}
