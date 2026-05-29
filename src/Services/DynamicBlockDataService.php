<?php

namespace LaraGrape\Services;

use LaraGrape\Support\TechStackRegistry;
use DOMDocument;
use DOMElement;
use DOMXPath;
use Illuminate\Support\Facades\Log;

class DynamicBlockDataService
{
    /**
     * Extract dynamic data from GrapesJS content for animated blocks
     */
    public function extractDynamicData(array $grapesjsData, string $blockId): array
    {
        $html = $grapesjsData['html'] ?? '';

        // Extract data based on block type
        switch ($blockId) {
            case 'animated-pricing':
                return $this->extractPricingData($html);
            case 'animated-faq':
                return $this->extractFaqData($html);
            case 'animated-testimonials':
                return $this->extractTestimonialsData($html);
            case 'animated-timeline':
                return $this->extractTimelineData($html);
            case 'animated-cards':
                return $this->extractCardsData($html);
            case 'animated-stats':
                return $this->extractStatsData($html);
            case 'animated-progress-bars':
                return $this->extractProgressData($html);
            case 'animated-portfolio':
                return $this->extractAnimatedPortfolioData($html);
            case 'animated-hero':
            case 'animated-full-image-hero':
                return $this->extractHeroBlocksData($html);
            case 'animated-tech-stack':
                return $this->extractAnimatedTechStackData($html);
            default:
                return [];
        }
    }

    /**
     * Extract animated tech stack data from GrapesJS HTML.
     */
    private function extractAnimatedTechStackData(string $html): array
    {
        $dom = new DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);
        $registry = app(\LaraGrape\Support\TechStackRegistry::class);

        $defaultTitle = 'Our Tech Stack';
        $defaultSubtitle = 'Technologies we work with';

        $root = $xpath->query("//*[@data-laragrape-block='animated-tech-stack']")->item(0);
        $context = $root instanceof DOMElement ? $root : null;

        $title = $defaultTitle;
        if ($context !== null) {
            $titleNodes = $xpath->query(".//*[@data-gjs-name='tech-stack-title']", $context);
        } else {
            $titleNodes = $xpath->query("//*[@data-gjs-name='tech-stack-title']");
        }
        if ($titleNodes->length > 0) {
            $n = $titleNodes->item(0);
            if ($n instanceof DOMElement) {
                $t = $this->extractTextFromDomElement($n);
                if ($t !== '') {
                    $title = $t;
                }
            } else {
                $text = trim($titleNodes->item(0)->textContent ?? '');
                if ($text !== '') {
                    $title = $text;
                }
            }
        }

        $subtitle = $defaultSubtitle;
        if ($context !== null) {
            $subtitleNodes = $xpath->query(".//*[@data-gjs-name='tech-stack-subtitle']", $context);
        } else {
            $subtitleNodes = $xpath->query("//*[@data-gjs-name='tech-stack-subtitle']");
        }
        if ($subtitleNodes->length > 0) {
            $n = $subtitleNodes->item(0);
            if ($n instanceof DOMElement) {
                $t = $this->extractTextFromDomElement($n);
                if ($t !== '') {
                    $subtitle = $t;
                }
            } else {
                $text = trim($subtitleNodes->item(0)->textContent ?? '');
                if ($text !== '') {
                    $subtitle = $text;
                }
            }
        }

        [$title, $subtitle] = $this->mergeTechStackTitleSubtitleRegexFallbacks(
            $html,
            $title,
            $subtitle,
            $defaultTitle,
            $defaultSubtitle
        );

        $defaultKeys = $registry->defaultKeys();
        $cards = $xpath->query("//*[@data-gjs-type='animated-tech-item' or @data-tech-key]");
        $items = [];

        if ($cards->length > 0) {
            foreach ($cards as $index => $card) {
                if (! $card instanceof DOMElement) {
                    continue;
                }

                $nameNode = $xpath->query(".//*[@data-gjs-name='tech-name-".($index + 1)."']", $card);
                $name = '';
                if ($nameNode->length > 0) {
                    $name = trim($nameNode->item(0)->textContent ?? '');
                }
                if ($name === '') {
                    $headings = $xpath->query('.//h3', $card);
                    if ($headings->length > 0) {
                        $name = trim($headings->item(0)->textContent ?? '');
                    }
                }
                $normalizedName = strtolower($name);
                if (in_array($normalizedName, ['technology', 'techonoly', 'tech'], true)) {
                    $name = '';
                }

                $techKey = $registry->normalizeKey(trim($card->getAttribute('data-tech-key')));
                if ($techKey === '' && $name !== '') {
                    $techKey = $registry->inferKeyFromName($name);
                }
                if ($techKey === '') {
                    $techKey = $defaultKeys[$index] ?? ($defaultKeys[0] ?? 'nuxt');
                }

                $items[] = [
                    'techKey' => $techKey,
                    'name' => $name,
                    'delay' => $index * 140,
                ];
            }
        }

        if ($items === []) {
            for ($i = 1; $i <= 3; $i++) {
                $nodes = $xpath->query("//*[@data-gjs-name='tech-name-{$i}']");
                $name = '';
                if ($nodes->length > 0) {
                    $name = trim($nodes->item(0)->textContent ?? '');
                }
                $normalizedName = strtolower($name);
                if (in_array($normalizedName, ['technology', 'techonoly', 'tech'], true)) {
                    $name = '';
                }
                $techKey = $name !== '' ? $registry->inferKeyFromName($name) : '';
                if ($techKey === '') {
                    $techKey = $defaultKeys[$i - 1] ?? ($defaultKeys[0] ?? 'nuxt');
                }
                $items[] = [
                    'techKey' => $techKey,
                    'name' => $name,
                    'delay' => ($i - 1) * 140,
                ];
            }
        }

        while (count($items) < 3) {
            $index = count($items);
            $items[] = [
                'techKey' => $defaultKeys[$index] ?? ($defaultKeys[$index % max(count($defaultKeys), 1)] ?? 'nuxt'),
                'name' => '',
                'delay' => $index * 140,
            ];
        }

        foreach ($items as $index => $item) {
            if (($item['name'] ?? '') === '') {
                $meta = $registry->resolve((string) ($item['techKey'] ?? ''));
                $items[$index]['name'] = (string) ($meta['label'] ?? 'Technology');
            }
            if (($item['techKey'] ?? '') === '') {
                $items[$index]['techKey'] = $defaultKeys[$index] ?? ($defaultKeys[0] ?? 'nuxt');
            }
        }

        $techItems = [];
        foreach ($items as $index => $item) {
            $meta = $registry->resolve((string) ($item['techKey'] ?? ''));
            $iconNode = $xpath->query("//*[@data-gjs-name='tech-icon-".($index + 1)."']");
            $iconText = '';
            if ($iconNode->length > 0) {
                $iconText = trim($iconNode->item(0)->textContent ?? '');
            }
            $icon = $iconText !== '' ? $iconText : (string) ($meta['icon'] ?? '⚙️');
            $techItems[] = [
                'name' => (string) ($item['name'] ?? $meta['label'] ?? 'Technology'),
                'icon' => $icon,
                'visible' => false,
                'delay' => (int) ($item['delay'] ?? $index * 100),
            ];
        }

        return [
            'title' => $title,
            'subtitle' => $subtitle,
            'techItems' => $techItems,
            'items' => array_values($items),
        ];
    }

    /**
     * Plain text from a DOM node (inner HTML first, then textContent) for GrapesJS text components.
     */
    private function extractTextFromDomElement(DOMElement $el): string
    {
        $raw = $this->domElementInnerHtml($el);
        if ($raw === '') {
            $raw = trim($el->textContent ?? '');
        }
        if ($raw === '') {
            return '';
        }
        $decoded = html_entity_decode($raw, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = trim(preg_replace('/\s+/', ' ', strip_tags($decoded)) ?? '');

        return $text;
    }

    /**
     * When loadHTML or nesting drops nodes, recover title/subtitle from raw editor HTML.
     *
     * @return array{0: string, 1: string}
     */
    private function mergeTechStackTitleSubtitleRegexFallbacks(
        string $html,
        string $title,
        string $subtitle,
        string $defaultTitle,
        string $defaultSubtitle
    ): array {
        if ($title === $defaultTitle || $title === '') {
            if (preg_match(
                '/<h2\b[^>]*\bdata-gjs-name=["\']tech-stack-title["\'][^>]*>(.*?)<\/h2>/is',
                $html,
                $m
            )) {
                $t = trim(html_entity_decode(strip_tags($m[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                if ($t !== '') {
                    $title = $t;
                }
            }
        }

        if ($subtitle === $defaultSubtitle || $subtitle === '') {
            if (preg_match(
                '/<p\b[^>]*\bdata-gjs-name=["\']tech-stack-subtitle["\'][^>]*>(.*?)<\/p>/is',
                $html,
                $m
            )) {
                $t = trim(html_entity_decode(strip_tags($m[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                if ($t !== '') {
                    $subtitle = $t;
                }
            }
        }

        return [$title, $subtitle];
    }

    /**
     * Hero blocks (two-column animated hero + full-bleed image hero): same GrapesJS data-gjs-name contract.
     */
    private function extractHeroBlocksData(string $html): array
    {
        $dom = new DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);

        $hero = [];

        $titleNodes = $xpath->query("//*[@data-gjs-name='hero-title']");
        if ($titleNodes->length > 0) {
            $n = $titleNodes->item(0);
            if ($n instanceof DOMElement) {
                $titleHtml = $this->domElementInnerHtml($n);
                if ($titleHtml === '') {
                    $titleHtml = trim($n->textContent ?? '');
                }
                if ($titleHtml !== '') {
                    $hero['title'] = $titleHtml;
                }
            }
        }

        $descNodes = $xpath->query("//*[@data-gjs-name='hero-description']");
        if ($descNodes->length > 0) {
            $text = trim($descNodes->item(0)->textContent ?? '');
            if ($text !== '') {
                $hero['description'] = $text;
            }
        }

        $primaryNodes = $xpath->query("//*[@data-gjs-name='hero-button-primary']");
        if ($primaryNodes->length > 0) {
            $btn = $primaryNodes->item(0);
            if ($btn instanceof DOMElement) {
                $label = $this->extractHeroButtonLabel($btn);
                if ($label !== '') {
                    $hero['primaryButton'] = ['text' => $label];
                }
            }
        }

        $secondaryNodes = $xpath->query("//*[@data-gjs-name='hero-button-secondary']");
        if ($secondaryNodes->length > 0) {
            $btn = $secondaryNodes->item(0);
            if ($btn instanceof DOMElement) {
                $label = $this->extractHeroButtonLabel($btn);
                if ($label !== '') {
                    $hero['secondaryButton'] = ['text' => $label];
                }
            }
        }

        $imgEl = null;
        $bg = $xpath->query("//img[@data-gjs-name='hero-background-image']")->item(0);
        if ($bg instanceof DOMElement) {
            $imgEl = $bg;
        } else {
            $side = $xpath->query("//img[@data-gjs-name='hero-image']")->item(0);
            if ($side instanceof DOMElement) {
                $imgEl = $side;
            }
        }
        if ($imgEl !== null) {
            $src = trim($imgEl->getAttribute('src'));
            if ($src === '') {
                $src = trim($imgEl->getAttribute('data-src'));
            }
            if ($src !== '') {
                $alt = trim($imgEl->getAttribute('alt'));

                $hero['image'] = [
                    'src' => $src,
                    'alt' => $alt !== '' ? $alt : 'Hero',
                ];
            }
        }

        $hero = $this->mergeHeroStructureFallbacks($xpath, $hero);
        $hero = $this->mergeHeroRegexFallbacks($html, $hero);

        if ($hero === []) {
            return [];
        }

        return ['hero' => $hero];
    }

    /**
     * Structural fallback when GrapesJS strips data-gjs-name attributes after edits.
     *
     * @param  array<string, mixed>  $hero
     * @return array<string, mixed>
     */
    private function mergeHeroStructureFallbacks(DOMXPath $xpath, array $hero): array
    {
        $titleNode = $xpath->query('//h1')->item(0);
        if ($titleNode instanceof DOMElement) {
            if (empty($hero['title'] ?? null)) {
                $title = $this->domElementInnerHtml($titleNode);
                if ($title === '') {
                    $title = trim($titleNode->textContent ?? '');
                }
                if ($title !== '') {
                    $hero['title'] = $title;
                }
            }
            $class = trim($titleNode->getAttribute('class'));
            if ($class !== '') {
                $hero['titleClass'] = $class;
            }
            $style = trim($titleNode->getAttribute('style'));
            if ($style !== '') {
                $hero['titleStyle'] = $style;
            }
        }

        $descNode = $xpath->query('//p')->item(0);
        if ($descNode instanceof DOMElement) {
            if (empty($hero['description'] ?? null)) {
                $description = trim($descNode->textContent ?? '');
                if ($description !== '') {
                    $hero['description'] = $description;
                }
            }
            $class = trim($descNode->getAttribute('class'));
            if ($class !== '') {
                $hero['descriptionClass'] = $class;
            }
            $style = trim($descNode->getAttribute('style'));
            if ($style !== '') {
                $hero['descriptionStyle'] = $style;
            }
        }

        $buttons = $xpath->query('//button');
        if ($buttons->length > 0) {
            $primary = $buttons->item(0);
            if ($primary instanceof DOMElement) {
                if (empty($hero['primaryButton']['text'] ?? null)) {
                    $text = $this->extractHeroButtonLabel($primary);
                    if ($text !== '') {
                        $hero['primaryButton'] = ['text' => $text];
                    }
                }
                $class = trim($primary->getAttribute('class'));
                if ($class !== '') {
                    $hero['primaryButtonClass'] = $class;
                }
                $style = trim($primary->getAttribute('style'));
                if ($style !== '') {
                    $hero['primaryButtonStyle'] = $style;
                }
            }
        }
        if ($buttons->length > 1) {
            $secondary = $buttons->item(1);
            if ($secondary instanceof DOMElement) {
                if (empty($hero['secondaryButton']['text'] ?? null)) {
                    $text = $this->extractHeroButtonLabel($secondary);
                    if ($text !== '') {
                        $hero['secondaryButton'] = ['text' => $text];
                    }
                }
                $class = trim($secondary->getAttribute('class'));
                if ($class !== '') {
                    $hero['secondaryButtonClass'] = $class;
                }
                $style = trim($secondary->getAttribute('style'));
                if ($style !== '') {
                    $hero['secondaryButtonStyle'] = $style;
                }
            }
        }

        $imageNode = $xpath->query('//img')->item(0);
        if ($imageNode instanceof DOMElement) {
            if (empty($hero['image']['src'] ?? null)) {
                $src = trim($imageNode->getAttribute('src'));
                if ($src === '') {
                    $src = trim($imageNode->getAttribute('data-src'));
                }
                if ($src !== '') {
                    $hero['image'] = $hero['image'] ?? [];
                    $hero['image']['src'] = $src;
                }
                $alt = trim($imageNode->getAttribute('alt'));
                if ($alt !== '') {
                    $hero['image'] = $hero['image'] ?? [];
                    $hero['image']['alt'] = $alt;
                }
            }
            $class = trim($imageNode->getAttribute('class'));
            if ($class !== '') {
                $hero['imageClass'] = $class;
            }
            $style = trim($imageNode->getAttribute('style'));
            if ($style !== '') {
                $hero['imageStyle'] = $style;
            }
        }

        return $hero;
    }

    /**
     * When DOMDocument drops or mangles nodes (Alpine attributes, editor quirks), recover fields from raw HTML.
     *
     * @param  array<string, mixed>  $hero
     * @return array<string, mixed>
     */
    private function mergeHeroRegexFallbacks(string $html, array $hero): array
    {
        if (! isset($hero['title']) || $hero['title'] === '') {
            if (preg_match('/<h1\b[^>]*\bdata-gjs-name=["\']hero-title["\'][^>]*>(.*?)<\/h1>/is', $html, $m)) {
                $hero['title'] = trim(html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            }
        }

        if (! isset($hero['description']) || $hero['description'] === '') {
            if (preg_match('/<p\b[^>]*\bdata-gjs-name=["\']hero-description["\'][^>]*>(.*?)<\/p>/is', $html, $m)) {
                $hero['description'] = trim(html_entity_decode(strip_tags($m[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            }
        }

        if (empty($hero['primaryButton']['text'] ?? null)) {
            if (preg_match('/<button\b[^>]*\bdata-gjs-name=["\']hero-button-primary["\'][^>]*>(.*?)<\/button>/is', $html, $m)) {
                $text = $this->extractHeroButtonTextFromHtml($m[1]);
                if ($text !== '') {
                    $hero['primaryButton'] = ['text' => $text];
                }
            }
        }

        if (empty($hero['secondaryButton']['text'] ?? null)) {
            if (preg_match('/<button\b[^>]*\bdata-gjs-name=["\']hero-button-secondary["\'][^>]*>(.*?)<\/button>/is', $html, $m)) {
                $text = $this->extractHeroButtonTextFromHtml($m[1]);
                if ($text !== '') {
                    $hero['secondaryButton'] = ['text' => $text];
                }
            }
        }

        if (empty($hero['image']['src'] ?? null)) {
            if (preg_match('/<img\b[^>]*\bdata-gjs-name=["\']hero-background-image["\'][^>]*>/i', $html, $imgTag)
                || preg_match('/<img\b[^>]*\bdata-gjs-name=["\']hero-image["\'][^>]*>/i', $html, $imgTag)) {
                $src = '';
                if (preg_match('/\bsrc=["\']([^"\']+)["\']/', $imgTag[0], $sm)) {
                    $src = $sm[1];
                } elseif (preg_match('/\bdata-src=["\']([^"\']+)["\']/', $imgTag[0], $dm)) {
                    $src = $dm[1];
                }
                if ($src !== '') {
                    $hero['image'] = $hero['image'] ?? [];
                    $hero['image']['src'] = html_entity_decode($src, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    if (preg_match('/\balt=["\']([^"\']*)["\']/', $imgTag[0], $am)) {
                        $alt = trim(html_entity_decode($am[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                        if ($alt !== '') {
                            $hero['image']['alt'] = $alt;
                        }
                    }
                    $hero['image']['alt'] = $hero['image']['alt'] ?? 'Hero';
                }
            }
        }

        return $hero;
    }

    private function extractHeroButtonLabel(DOMElement $button): string
    {
        foreach ($button->getElementsByTagName('span') as $span) {
            $t = trim($span->textContent ?? '');
            if ($t !== '') {
                return $t;
            }
        }

        return trim($button->textContent ?? '');
    }

    private function extractHeroButtonTextFromHtml(string $buttonInnerHtml): string
    {
        $decoded = html_entity_decode($buttonInnerHtml, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = trim(strip_tags($decoded));

        return preg_replace('/\s+/', ' ', $text) ?? '';
    }

    private function domElementInnerHtml(DOMElement $element): string
    {
        $doc = $element->ownerDocument;
        if (! $doc) {
            return '';
        }
        $html = '';
        foreach ($element->childNodes as $child) {
            $html .= $doc->saveHTML($child);
        }

        return trim($html);
    }

    /**
     * Extract pricing data from GrapesJS HTML
     */
    private function extractPricingData(string $html): array
    {
        $plans = [];

        // Use DOMDocument for more reliable extraction (handles nested tags)
        $dom = new DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);

        // Find all pricing cards first
        $pricingCards = $xpath->query("//div[contains(@class, 'pricing-card')]");

        // Extract plan data using XPath (handles nested tags)
        for ($i = 1; $i <= 3; $i++) {
            $planIndex = $i - 1;

            // Try to get the card by index if we found pricing cards
            $card = null;
            if ($pricingCards->length >= $i) {
                $card = $pricingCards->item($planIndex);
            }

            // Extract name - first try data-gjs-name, then try h3 in the card
            $name = 'Plan '.$i;
            $nameNodes = $xpath->query("//*[@data-gjs-name='plan-name-{$i}']");
            if ($nameNodes->length > 0) {
                $nameText = trim($nameNodes->item(0)->textContent);
                if (! empty($nameText)) {
                    $name = $nameText;
                }
            } elseif ($card) {
                // Fallback: look for h3 in the pricing card
                $h3Nodes = $xpath->query('.//h3', $card);
                if ($h3Nodes->length > 0) {
                    $nameText = trim($h3Nodes->item(0)->textContent);
                    if (! empty($nameText) && $nameText !== 'Plan '.$i) {
                        $name = $nameText;
                    }
                }
            }

            // Extract price - first try data-gjs-name, then try span with $ in the card
            $price = '99';
            $priceNodes = $xpath->query("//*[@data-gjs-name='plan-price-{$i}']");
            if ($priceNodes->length > 0) {
                $priceText = trim($priceNodes->item(0)->textContent);
                // Clean up price (remove any non-numeric characters except .)
                $priceText = preg_replace('/[^0-9.]/', '', $priceText);
                if (! empty($priceText)) {
                    $price = $priceText;
                }
            } elseif ($card) {
                // Fallback: look for price in the card (span with $ or number)
                $priceSpans = $xpath->query(".//span[contains(text(), '$') or contains(text(), '99') or contains(text(), '199') or contains(text(), '299') or contains(text(), '399')]", $card);
                if ($priceSpans->length > 0) {
                    $priceText = trim($priceSpans->item(0)->textContent);
                    // Clean up price (remove $ and other non-numeric except .)
                    $priceText = preg_replace('/[^0-9.]/', '', $priceText);
                    if (! empty($priceText)) {
                        $price = $priceText;
                    }
                } else {
                    // Try to find any span with numbers in the price area
                    $priceArea = $xpath->query(".//div[contains(@class, 'text-3xl')]//span", $card);
                    foreach ($priceArea as $span) {
                        $text = trim($span->textContent);
                        // Check if it looks like a price (contains numbers)
                        if (preg_match('/\d+/', $text)) {
                            $priceText = preg_replace('/[^0-9.]/', '', $text);
                            if (! empty($priceText)) {
                                $price = $priceText;
                                break;
                            }
                        }
                    }
                }
            }

            // Extract period
            $periodNodes = $xpath->query("//*[@data-gjs-name='plan-period-{$i}']");
            $period = 'month';
            if ($periodNodes->length > 0) {
                $periodText = trim($periodNodes->item(0)->textContent);
                // Remove leading slash if present
                $periodText = ltrim($periodText, '/');
                $period = ! empty($periodText) ? $periodText : $period;
            }

            // Extract features - look for data-gjs-name first, then fallback to li items in the card
            $planFeatures = [];
            $foundFeaturesByIndex = [];

            // First pass: try to get features by data-gjs-name (preserves order)
            // Search within the card context if available for better accuracy
            for ($j = 1; $j <= 7; $j++) {
                // Try searching in card context first (more accurate)
                if ($card) {
                    $featureNodes = $xpath->query(".//*[@data-gjs-name='feature-{$i}-{$j}']", $card);
                } else {
                    $featureNodes = $xpath->query("//*[@data-gjs-name='feature-{$i}-{$j}']");
                }

                if ($featureNodes->length > 0) {
                    $featureElement = $featureNodes->item(0);
                    $featureText = trim($featureElement->textContent);

                    // If the element has x-text, the textContent should still contain the fallback text
                    // But we need to be careful - textContent includes all text nodes
                    if (empty($featureText) || preg_match('/plans\[/', $featureText)) {
                        // Look for direct text child nodes (not Alpine.js expressions)
                        $textNodes = $xpath->query('.//text()[normalize-space()]', $featureElement);
                        foreach ($textNodes as $textNode) {
                            $text = trim($textNode->textContent);
                            // Skip if it looks like an Alpine.js expression
                            if (! empty($text) &&
                                ! preg_match('/^\s*x-text/', $text) &&
                                ! preg_match('/plans\[/', $text) &&
                                ! preg_match('/^\s*$/', $text)) {
                                $featureText = $text;
                                break;
                            }
                        }
                    }

                    // Clean up the text - remove Alpine.js patterns
                    $featureText = trim($featureText);
                    $featureText = preg_replace('/plans\[.*?\]/s', '', $featureText);
                    $featureText = preg_replace('/\s*x-text="[^"]*"\s*/', '', $featureText);
                    $featureText = trim($featureText);

                    // Only add if it's not empty and doesn't look like an Alpine expression
                    if (! empty($featureText) &&
                        ! preg_match('/^\s*$/', $featureText) &&
                        ! preg_match('/plans\[/', $featureText) &&
                        ! preg_match('/^\?\s*:/', $featureText)) {
                        $foundFeaturesByIndex[$j] = $featureText;
                    }
                }
            }

            Log::info("[DynamicBlockDataService] After data-gjs-name extraction for plan {$i}", [
                'plan_index' => $i,
                'features_found' => count($foundFeaturesByIndex),
                'features_by_index' => $foundFeaturesByIndex,
            ]);

            // Sort by index and add to planFeatures
            ksort($foundFeaturesByIndex);
            $planFeatures = array_values($foundFeaturesByIndex);

            // Fallback: if we didn't find all features by data-gjs-name, try to extract from li items in the card
            // This helps when some features are missing data-gjs-name attributes
            if ($card && count($planFeatures) < 3) {
                $liNodes = $xpath->query('.//ul//li', $card);
                $extractedFromLi = [];

                foreach ($liNodes as $liIndex => $liNode) {
                    // Find the span with the feature text
                    $featureSpan = $xpath->query(".//span[contains(@class, 'text-primary-700') or @data-gjs-type='text']", $liNode);
                    if ($featureSpan->length > 0) {
                        $liSpan = $featureSpan->item(0);
                        $featureText = trim($liSpan->textContent);

                        // Get the actual text, not Alpine.js expressions
                        if (empty($featureText) || preg_match('/x-text/', $liSpan->getAttribute('x-text') ?? '')) {
                            // Try to get text from child nodes
                            $childText = '';
                            foreach ($liSpan->childNodes as $child) {
                                if ($child->nodeType === XML_TEXT_NODE) {
                                    $childText .= $child->textContent.' ';
                                }
                            }
                            $featureText = trim($childText) ?: $featureText;
                        }

                        // Clean up Alpine.js patterns
                        $featureText = preg_replace('/plans\[.*?\]/s', '', $featureText);
                        $featureText = trim($featureText);

                        // Only add if it's not empty and doesn't look like an Alpine expression
                        if (! empty($featureText) &&
                            ! preg_match('/^x-text=/', $featureText) &&
                            ! preg_match('/plans\[/', $featureText) &&
                            ! preg_match('/^\?\s*:/', $featureText)) {
                            // Check if we already have this feature from data-gjs-name extraction
                            // If not, add it at the correct position
                            $featureIndex = $liIndex + 1; // liIndex is 0-based, feature index is 1-based
                            if (! isset($foundFeaturesByIndex[$featureIndex])) {
                                $foundFeaturesByIndex[$featureIndex] = $featureText;
                            }
                        }
                    }
                }

                // Re-sort and update planFeatures
                ksort($foundFeaturesByIndex);
                $planFeatures = array_values($foundFeaturesByIndex);

                Log::info("[DynamicBlockDataService] After li fallback extraction for plan {$i}", [
                    'plan_index' => $i,
                    'features_found' => count($planFeatures),
                    'features' => $planFeatures,
                    'features_by_index' => $foundFeaturesByIndex,
                ]);
            }

            // Use default features if still none found
            if (empty($planFeatures)) {
                $defaultFeatures = [
                    1 => ['Basic Features', 'Email Support', '5GB Storage'],
                    2 => ['All Starter Features', 'Priority Support', '25GB Storage'],
                    3 => ['All Professional Features', '24/7 Phone Support', 'Unlimited Storage'],
                ];
                $planFeatures = $defaultFeatures[$i] ?? [];
            }

            // Extract button text - look for button element or span with button-text data-gjs-name
            $buttonText = 'Get Started';

            // First try to find button-text-{$i} span
            $buttonTextNodes = $xpath->query("//*[@data-gjs-name='button-text-{$i}']");
            if ($buttonTextNodes->length > 0) {
                $buttonTextContent = trim($buttonTextNodes->item(0)->textContent);
                if (! empty($buttonTextContent) && $buttonTextContent !== 'Get Started' && $buttonTextContent !== 'Selected') {
                    $buttonText = $buttonTextContent;
                }
            }

            // Fallback: try button-{$i} element
            if ($buttonText === 'Get Started') {
                $buttonNodes = $xpath->query("//*[@data-gjs-name='button-{$i}']");
                if ($buttonNodes->length > 0) {
                    $buttonElement = $buttonNodes->item(0);
                    // Get text from button or inner span
                    $buttonTextContent = trim($buttonElement->textContent);

                    // Check for span inside button (common structure)
                    $buttonSpan = $xpath->query('.//span', $buttonElement);
                    if ($buttonSpan->length > 0) {
                        foreach ($buttonSpan as $span) {
                            $spanText = trim($span->textContent);
                            // Skip Alpine.js expressions and default text
                            if (! empty($spanText) &&
                                $spanText !== 'Get Started' &&
                                $spanText !== 'Selected' &&
                                ! preg_match('/x-text/', $span->getAttribute('x-text') ?? '') &&
                                ! preg_match('/plans\[/', $spanText)) {
                                $buttonText = $spanText;
                                break;
                            }
                        }
                    }

                    // If still default, try the button's direct text content
                    if ($buttonText === 'Get Started' && ! empty($buttonTextContent) &&
                        $buttonTextContent !== 'Get Started' &&
                        $buttonTextContent !== 'Selected' &&
                        ! preg_match('/x-text/', $buttonElement->getAttribute('x-text') ?? '')) {
                        $buttonText = $buttonTextContent;
                    }
                }
            }

            // Also try to find button in the card context
            if ($buttonText === 'Get Started' && $card) {
                $cardButtons = $xpath->query('.//button', $card);
                if ($cardButtons->length > 0) {
                    $cardButton = $cardButtons->item(0);
                    $cardButtonText = trim($cardButton->textContent);
                    // Check span inside
                    $cardButtonSpan = $xpath->query('.//span', $cardButton);
                    if ($cardButtonSpan->length > 0) {
                        $spanText = trim($cardButtonSpan->item(0)->textContent);
                        if (! empty($spanText) && $spanText !== 'Get Started' && $spanText !== 'Selected') {
                            $buttonText = $spanText;
                        }
                    } elseif (! empty($cardButtonText) && $cardButtonText !== 'Get Started' && $cardButtonText !== 'Selected') {
                        $buttonText = $cardButtonText;
                    }
                }
            }

            $plans[$planIndex] = [
                'name' => $name,
                'price' => $price,
                'period' => $period,
                'features' => $planFeatures,
                'popular' => $i === 2, // Middle plan is popular
                'buttonText' => $buttonText,
            ];
        }

        Log::info('[DynamicBlockDataService] Extracted pricing data from HTML', [
            'plans_count' => count($plans),
            'plans' => $plans,
            'plan_names' => array_column($plans, 'name'),
            'plan_prices' => array_column($plans, 'price'),
        ]);

        return ['plans' => $plans];
    }

    /**
     * Extract FAQ data from GrapesJS HTML
     */
    private function extractFaqData(string $html): array
    {
        $faqs = [];

        // Use DOMDocument for more reliable extraction (handles nested tags)
        $dom = new DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);

        // Find all FAQ items first
        $faqItems = $xpath->query("//div[contains(@class, 'faq-item')]");

        // Extract FAQ data using XPath
        for ($i = 1; $i <= 4; $i++) {
            $faqIndex = $i - 1;

            // Try to get the FAQ item by index if we found FAQ items
            $item = null;
            if ($faqItems->length >= $i) {
                $item = $faqItems->item($faqIndex);
            }

            // Extract question - first try data-gjs-name, then try h3 in the item
            $question = 'Question '.$i;
            $questionNodes = $xpath->query("//*[@data-gjs-name='faq-question-{$i}']");
            if ($questionNodes->length > 0) {
                $questionText = trim($questionNodes->item(0)->textContent);
                if (! empty($questionText)) {
                    $question = $questionText;
                }
            } elseif ($item) {
                // Fallback: look for h3 in the FAQ item
                $h3Nodes = $xpath->query('.//h3', $item);
                if ($h3Nodes->length > 0) {
                    $questionText = trim($h3Nodes->item(0)->textContent);
                    if (! empty($questionText) && $questionText !== 'Question '.$i) {
                        $question = $questionText;
                    }
                }
            }

            // Extract answer - first try data-gjs-name, then try p in the item
            $answer = 'Answer '.$i;
            $answerNodes = $xpath->query("//*[@data-gjs-name='faq-answer-{$i}']");
            if ($answerNodes->length > 0) {
                $answerText = trim($answerNodes->item(0)->textContent);
                if (! empty($answerText)) {
                    $answer = $answerText;
                }
            } elseif ($item) {
                // Fallback: look for p in the FAQ item
                $pNodes = $xpath->query('.//p', $item);
                if ($pNodes->length > 0) {
                    $answerText = trim($pNodes->item(0)->textContent);
                    if (! empty($answerText) && $answerText !== 'Answer '.$i) {
                        $answer = $answerText;
                    }
                }
            }

            $faqs[] = [
                'question' => $question,
                'answer' => $answer,
                'open' => false,
                'visible' => false,
                'delay' => ($i - 1) * 100,
            ];
        }

        // Extract CTA button text
        $ctaButtonText = 'Contact Us';
        $ctaButtonNodes = $xpath->query("//*[@data-gjs-name='faq-cta-button']");

        // Fallback: find button within FAQ block by structure (if data-gjs-name not found)
        if ($ctaButtonNodes->length === 0) {
            // Find the FAQ block container
            $faqBlock = $xpath->query("//div[contains(@class, 'faq-block')]");
            if ($faqBlock->length > 0) {
                // Look for button in the CTA section (after FAQ items, in a centered div)
                $ctaSection = $xpath->query(".//div[contains(@class, 'text-center')]//button", $faqBlock->item(0));
                if ($ctaSection->length > 0) {
                    $ctaButtonNodes = $ctaSection;
                }
            }
        }

        if ($ctaButtonNodes->length > 0) {
            $ctaButtonElement = $ctaButtonNodes->item(0);
            $ctaButtonTextValue = trim($ctaButtonElement->textContent);

            // First, try to get text from direct child text nodes (the actual edited content)
            $directText = '';
            foreach ($ctaButtonElement->childNodes as $childNode) {
                if ($childNode->nodeType === XML_TEXT_NODE) {
                    $text = trim($childNode->textContent);
                    if (! empty($text) && strlen($text) > 2) {
                        $directText = $text;
                        break;
                    }
                }
            }

            // If we found direct text, use it
            if (! empty($directText) && $directText !== 'Contact Us') {
                $ctaButtonText = $directText;
            } else {
                // Check for span inside button (common structure)
                $ctaButtonSpan = $xpath->query('.//span', $ctaButtonElement);
                if ($ctaButtonSpan->length > 0) {
                    foreach ($ctaButtonSpan as $span) {
                        $spanText = trim($span->textContent);
                        if (! empty($spanText) && $spanText !== 'Contact Us' && strlen($spanText) > 2) {
                            $ctaButtonText = $spanText;
                            break;
                        }
                    }
                } elseif (! empty($ctaButtonTextValue) && $ctaButtonTextValue !== 'Contact Us' && strlen($ctaButtonTextValue) > 2) {
                    $ctaButtonText = $ctaButtonTextValue;
                }
            }

            Log::info('[DynamicBlockDataService] Extracted CTA button text', [
                'button_text' => $ctaButtonText,
                'direct_text' => $directText,
                'text_content' => $ctaButtonTextValue,
                'has_span' => $xpath->query('.//span', $ctaButtonElement)->length > 0,
                'found_by_data_gjs_name' => $xpath->query("//*[@data-gjs-name='faq-cta-button']")->length > 0,
            ]);
        }

        // Also extract CTA text if available
        $ctaText = 'Still have questions? We\'re here to help!';
        $ctaTextNodes = $xpath->query("//*[@data-gjs-name='faq-cta-text']");

        // Fallback: find CTA text within FAQ block by structure (if data-gjs-name not found)
        if ($ctaTextNodes->length === 0) {
            // Find the FAQ block container
            $faqBlock = $xpath->query("//div[contains(@class, 'faq-block')]");
            if ($faqBlock->length > 0) {
                // Look for paragraph in the CTA section (before the button, in a centered div)
                $ctaSection = $xpath->query(".//div[contains(@class, 'text-center')]//p[contains(@class, 'text-lg')]", $faqBlock->item(0));
                if ($ctaSection->length > 0) {
                    $ctaTextNodes = $ctaSection;
                }
            }
        }

        if ($ctaTextNodes->length > 0) {
            $ctaTextElement = $ctaTextNodes->item(0);
            $ctaTextValue = trim($ctaTextElement->textContent);

            // First, try to get text from direct child text nodes (the actual edited content)
            $directText = '';
            foreach ($ctaTextElement->childNodes as $childNode) {
                if ($childNode->nodeType === XML_TEXT_NODE) {
                    $text = trim($childNode->textContent);
                    if (! empty($text) && strlen($text) > 5) {
                        $directText = $text;
                        break;
                    }
                }
            }

            // Use direct text if found, otherwise use textContent
            if (! empty($directText) && $directText !== 'Still have questions? We\'re here to help!') {
                $ctaText = $directText;
            } elseif (! empty($ctaTextValue) && $ctaTextValue !== 'Still have questions? We\'re here to help!' && strlen($ctaTextValue) > 5) {
                $ctaText = $ctaTextValue;
            }

            Log::info('[DynamicBlockDataService] Extracted CTA text', [
                'cta_text' => $ctaText,
                'direct_text' => $directText,
                'text_content' => $ctaTextValue,
                'found_by_data_gjs_name' => $xpath->query("//*[@data-gjs-name='faq-cta-text']")->length > 0,
            ]);
        }

        Log::info('[DynamicBlockDataService] Extracted FAQ data from HTML', [
            'faqs_count' => count($faqs),
            'questions' => array_column($faqs, 'question'),
            'cta_button_text' => $ctaButtonText,
            'cta_text' => $ctaText,
            'cta_button_nodes_found' => $ctaButtonNodes->length,
            'cta_text_nodes_found' => $ctaTextNodes->length,
        ]);

        return [
            'faqs' => $faqs,
            'ctaButton' => $ctaButtonText,
            'ctaText' => $ctaText,
        ];
    }

    /**
     * Extract testimonials data from GrapesJS HTML
     */
    private function extractTestimonialsData(string $html): array
    {
        $testimonials = [];

        // Use DOMDocument for more reliable extraction (handles nested tags)
        $dom = new DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);

        // First, find the testimonials-block container to scope our queries
        // Prefer the one that's NOT in the editor preview (has x-data attribute or is in @else section)
        $testimonialsBlocks = $xpath->query("//div[contains(@class, 'testimonials-block')]");

        $testimonialsBlock = null;
        // Prefer block with x-data (live version) over editor preview
        foreach ($testimonialsBlocks as $block) {
            if ($block->hasAttribute('x-data')) {
                $testimonialsBlock = $block;
                break;
            }
        }
        // If no live version found, use the first one
        if (! $testimonialsBlock && $testimonialsBlocks->length > 0) {
            $testimonialsBlock = $testimonialsBlocks->item(0);
        }

        if (! $testimonialsBlock) {
            Log::warning('[DynamicBlockDataService] Testimonials block container not found');

            return ['testimonials' => []];
        }

        // Find all testimonial cards within the testimonials-block
        // Only get cards that are direct children or in the main container, not nested duplicates
        $testimonialCards = $xpath->query(".//div[contains(@class, 'testimonial-card')][not(ancestor::div[contains(@class, 'testimonial-card')])]", $testimonialsBlock);

        // Extract testimonial data using XPath, scoped to testimonials-block
        for ($i = 1; $i <= 3; $i++) {
            $testimonialIndex = $i - 1;

            // Try to get the testimonial card by index if we found cards
            $card = null;
            if ($testimonialCards->length > $testimonialIndex) {
                $card = $testimonialCards->item($testimonialIndex);
            }

            // Extract text - scoped to testimonials-block, first try data-gjs-name
            $text = 'Testimonial '.$i;
            $textNodes = $xpath->query(".//*[@data-gjs-name='testimonial-text-{$i}']", $testimonialsBlock);
            if ($textNodes->length > 0) {
                $textValue = trim($textNodes->item(0)->textContent);
                // Clean Alpine.js patterns
                $textValue = preg_replace('/x-text=["\'][^"\']*["\']/', '', $textValue);
                $textValue = preg_replace('/testimonials\s*&&\s*testimonials\[\d+\]\s*\?[^:]*:\s*["\']?[^"\']*["\']?/', '', $textValue);
                $textValue = trim($textValue);
                if (! empty($textValue) && $textValue !== 'Testimonial '.$i) {
                    $text = $textValue;
                }
            } elseif ($card) {
                // Fallback: look for p or blockquote in the testimonial card
                $textElements = $xpath->query('.//p | .//blockquote', $card);
                if ($textElements->length > 0) {
                    $textValue = trim($textElements->item(0)->textContent);
                    // Clean Alpine.js patterns
                    $textValue = preg_replace('/x-text=["\'][^"\']*["\']/', '', $textValue);
                    $textValue = preg_replace('/testimonials\s*&&\s*testimonials\[\d+\]\s*\?[^:]*:\s*["\']?[^"\']*["\']?/', '', $textValue);
                    $textValue = trim($textValue);
                    if (! empty($textValue) && $textValue !== 'Testimonial '.$i) {
                        $text = $textValue;
                    }
                }
            }

            // Extract name - scoped to testimonials-block, first try data-gjs-name
            $name = 'Client '.$i;
            $nameNodes = $xpath->query(".//*[@data-gjs-name='client-name-{$i}']", $testimonialsBlock);
            if ($nameNodes->length > 0) {
                $nameValue = trim($nameNodes->item(0)->textContent);
                // Clean Alpine.js patterns
                $nameValue = preg_replace('/x-text=["\'][^"\']*["\']/', '', $nameValue);
                $nameValue = preg_replace('/testimonials\s*&&\s*testimonials\[\d+\]\s*\?[^:]*:\s*["\']?[^"\']*["\']?/', '', $nameValue);
                $nameValue = trim($nameValue);
                if (! empty($nameValue) && $nameValue !== 'Client '.$i) {
                    $name = $nameValue;
                }
            } elseif ($card) {
                // Fallback: look for h4 or strong in the card
                $nameElements = $xpath->query('.//h4 | .//strong', $card);
                if ($nameElements->length > 0) {
                    $nameValue = trim($nameElements->item(0)->textContent);
                    // Clean Alpine.js patterns
                    $nameValue = preg_replace('/x-text=["\'][^"\']*["\']/', '', $nameValue);
                    $nameValue = preg_replace('/testimonials\s*&&\s*testimonials\[\d+\]\s*\?[^:]*:\s*["\']?[^"\']*["\']?/', '', $nameValue);
                    $nameValue = trim($nameValue);
                    if (! empty($nameValue) && $nameValue !== 'Client '.$i) {
                        $name = $nameValue;
                    }
                }
            }

            // Extract title - scoped to testimonials-block, first try data-gjs-name
            $title = 'Position '.$i;
            $titleNodes = $xpath->query(".//*[@data-gjs-name='client-title-{$i}']", $testimonialsBlock);
            if ($titleNodes->length > 0) {
                $titleValue = trim($titleNodes->item(0)->textContent);
                // Clean Alpine.js patterns
                $titleValue = preg_replace('/x-text=["\'][^"\']*["\']/', '', $titleValue);
                $titleValue = preg_replace('/testimonials\s*&&\s*testimonials\[\d+\]\s*\?[^:]*:\s*["\']?[^"\']*["\']?/', '', $titleValue);
                $titleValue = trim($titleValue);
                if (! empty($titleValue) && $titleValue !== 'Position '.$i) {
                    $title = $titleValue;
                }
            } elseif ($card) {
                // Fallback: look for p or span with title-like text
                $titleElements = $xpath->query(".//p[contains(@class, 'text-sm')] | .//span[contains(@class, 'text-sm')]", $card);
                if ($titleElements->length > 0) {
                    $titleValue = trim($titleElements->item(0)->textContent);
                    // Clean Alpine.js patterns
                    $titleValue = preg_replace('/x-text=["\'][^"\']*["\']/', '', $titleValue);
                    $titleValue = preg_replace('/testimonials\s*&&\s*testimonials\[\d+\]\s*\?[^:]*:\s*["\']?[^"\']*["\']?/', '', $titleValue);
                    $titleValue = trim($titleValue);
                    if (! empty($titleValue) && $titleValue !== 'Position '.$i) {
                        $title = $titleValue;
                    }
                }
            }

            $initials = $this->getInitials($name);

            $testimonials[] = [
                'text' => $text,
                'name' => $name,
                'title' => $title,
                'initials' => $initials,
                'visible' => false,
                'delay' => ($i - 1) * 200,
            ];
        }

        // Deduplicate testimonials - remove any duplicates based on name and text
        $uniqueTestimonials = [];
        $seen = [];
        foreach ($testimonials as $testimonial) {
            $key = md5($testimonial['name'].'|'.$testimonial['text']);
            if (! isset($seen[$key])) {
                $seen[$key] = true;
                $uniqueTestimonials[] = $testimonial;
            }
        }

        // Ensure we have exactly 3 testimonials (fill with defaults if needed)
        while (count($uniqueTestimonials) < 3) {
            $index = count($uniqueTestimonials);
            $uniqueTestimonials[] = [
                'text' => 'Testimonial '.($index + 1),
                'name' => 'Client '.($index + 1),
                'title' => 'Position '.($index + 1),
                'initials' => $this->getInitials('Client '.($index + 1)),
                'visible' => false,
                'delay' => $index * 200,
            ];
        }

        // Limit to 3 testimonials
        $uniqueTestimonials = array_slice($uniqueTestimonials, 0, 3);

        Log::info('[DynamicBlockDataService] Extracted testimonials data from HTML', [
            'original_count' => count($testimonials),
            'unique_count' => count($uniqueTestimonials),
            'names' => array_column($uniqueTestimonials, 'name'),
        ]);

        return ['testimonials' => $uniqueTestimonials];
    }

    /**
     * Extract timeline data from GrapesJS HTML
     */
    private function extractTimelineData(string $html): array
    {
        $steps = [];

        // Use DOMDocument for more reliable extraction (handles nested tags)
        $dom = new DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);

        // Find all timeline steps first
        $timelineSteps = $xpath->query("//div[contains(@class, 'timeline-step') or contains(@class, 'step')]");

        // Extract timeline data using XPath
        for ($i = 1; $i <= 5; $i++) {
            $stepIndex = $i - 1;

            // Try to get the step by index if we found steps
            $step = null;
            if ($timelineSteps->length >= $i) {
                $step = $timelineSteps->item($stepIndex);
            }

            // Extract title - first try data-gjs-name, then try h3 or h4 in the step
            $title = 'Step '.$i;
            $titleNodes = $xpath->query("//*[@data-gjs-name='timeline-title-{$i}']");
            if ($titleNodes->length > 0) {
                $titleText = trim($titleNodes->item(0)->textContent);
                if (! empty($titleText)) {
                    $title = $titleText;
                }
            } elseif ($step) {
                // Fallback: look for h3 or h4 in the step
                $headingNodes = $xpath->query('.//h3 | .//h4', $step);
                if ($headingNodes->length > 0) {
                    $titleText = trim($headingNodes->item(0)->textContent);
                    if (! empty($titleText) && $titleText !== 'Step '.$i) {
                        $title = $titleText;
                    }
                }
            }

            // Extract description - first try data-gjs-name, then try p in the step
            $description = 'Description '.$i;
            $descriptionNodes = $xpath->query("//*[@data-gjs-name='timeline-description-{$i}']");
            if ($descriptionNodes->length > 0) {
                $descriptionText = trim($descriptionNodes->item(0)->textContent);
                if (! empty($descriptionText)) {
                    $description = $descriptionText;
                }
            } elseif ($step) {
                // Fallback: look for p in the step
                $pNodes = $xpath->query('.//p', $step);
                if ($pNodes->length > 0) {
                    $descriptionText = trim($pNodes->item(0)->textContent);
                    if (! empty($descriptionText) && $descriptionText !== 'Description '.$i) {
                        $description = $descriptionText;
                    }
                }
            }

            // Extract duration - first try data-gjs-name, then try span or small in the step
            $duration = '1 week';
            $durationNodes = $xpath->query("//*[@data-gjs-name='timeline-duration-{$i}']");
            if ($durationNodes->length > 0) {
                $durationText = trim($durationNodes->item(0)->textContent);
                if (! empty($durationText)) {
                    $duration = $durationText;
                }
            } elseif ($step) {
                // Fallback: look for span or small with duration-like text
                $durationElements = $xpath->query(".//span[contains(@class, 'text-sm')] | .//small", $step);
                if ($durationElements->length > 0) {
                    $durationText = trim($durationElements->item(0)->textContent);
                    if (! empty($durationText) && $durationText !== '1 week') {
                        $duration = $durationText;
                    }
                }
            }

            $steps[] = [
                'title' => $title,
                'description' => $description,
                'duration' => $duration,
                'icon' => $this->getTimelineIcon($i),
                'visible' => false,
                'delay' => ($i - 1) * 200,
            ];
        }

        Log::info('[DynamicBlockDataService] Extracted timeline data from HTML', [
            'steps_count' => count($steps),
            'titles' => array_column($steps, 'title'),
        ]);

        return ['steps' => $steps];
    }

    /**
     * Extract cards data from GrapesJS HTML
     */
    private function extractCardsData(string $html): array
    {
        $cards = [];

        // Use DOMDocument for more reliable extraction (handles nested tags)
        $dom = new DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);

        // Find the cards-block container first to scope our search
        $cardsBlock = $xpath->query("//div[contains(@class, 'cards-block')]");

        // Find all card elements within the cards-block (not pricing cards)
        $cardElements = null;
        if ($cardsBlock->length > 0) {
            // Search within cards-block to avoid conflicts with pricing cards
            $cardElements = $xpath->query(".//div[contains(@class, 'card') and contains(@class, 'relative')]", $cardsBlock->item(0));
        } else {
            // Fallback: search globally but exclude pricing cards
            $cardElements = $xpath->query("//div[contains(@class, 'card') and contains(@class, 'relative') and not(ancestor::div[contains(@class, 'pricing-block')])]");
        }

        // Extract card data using XPath
        for ($i = 1; $i <= 3; $i++) {
            $cardIndex = $i - 1;

            // Try to get the card by index if we found cards
            $card = null;
            if ($cardElements && $cardElements->length >= $i) {
                $card = $cardElements->item($cardIndex);
            }

            // Extract title - first try data-gjs-name within card context, then globally
            $title = 'Service '.$i;

            // Try searching in card context first (more accurate and avoids conflicts)
            if ($card) {
                $titleNodes = $xpath->query(".//*[@data-gjs-name='card-title-{$i}']", $card);
            } else {
                $titleNodes = $xpath->query("//*[@data-gjs-name='card-title-{$i}']");
            }

            if ($titleNodes->length > 0) {
                $titleText = trim($titleNodes->item(0)->textContent);
                if (! empty($titleText)) {
                    $title = $titleText;
                }
            } elseif ($card) {
                // Fallback: look for h3 in the card
                $h3Nodes = $xpath->query('.//h3', $card);
                if ($h3Nodes->length > 0) {
                    $titleText = trim($h3Nodes->item(0)->textContent);
                    if (! empty($titleText) && $titleText !== 'Service '.$i) {
                        $title = $titleText;
                    }
                }
            }

            // Extract description - first try data-gjs-name, then try p in the card
            $description = 'Description '.$i;

            // Try searching in card context first (more accurate)
            if ($card) {
                $descriptionNodes = $xpath->query(".//*[@data-gjs-name='card-description-{$i}']", $card);
            } else {
                $descriptionNodes = $xpath->query("//*[@data-gjs-name='card-description-{$i}']");
            }

            if ($descriptionNodes->length > 0) {
                $descriptionElement = $descriptionNodes->item(0);

                // Get the actual text content - prioritize direct text child nodes
                // This gets the text between the tags (the fallback text), not Alpine.js expressions
                $descriptionText = '';

                // First, try to get text from direct child text nodes (the actual content)
                // This is what GrapesJS saves when the user edits the text
                foreach ($descriptionElement->childNodes as $childNode) {
                    if ($childNode->nodeType === XML_TEXT_NODE) {
                        $text = trim($childNode->textContent);
                        // Only use if it's actual text (not Alpine.js expressions)
                        if (! empty($text) &&
                            ! preg_match('/cards\[/', $text) &&
                            ! preg_match('/x-text/', $text) &&
                            ! preg_match('/^\?\s*:/', $text) &&
                            strlen($text) > 5) {
                            $descriptionText = $text;
                            break; // Use the first meaningful text node
                        }
                    }
                }

                // If we found text from child nodes, use it (this is the edited text)
                if (! empty($descriptionText) &&
                    ! preg_match('/^\s*$/', $descriptionText) &&
                    ! preg_match('/cards\[/', $descriptionText) &&
                    $descriptionText !== 'Description '.$i &&
                    strlen($descriptionText) > 5) {
                    $description = $descriptionText;
                } else {
                    // Fallback: if no direct text node found, use textContent and clean it
                    $descriptionText = trim($descriptionElement->textContent);

                    // Clean up Alpine.js patterns more aggressively
                    $descriptionText = preg_replace('/cards\[.*?\]/s', '', $descriptionText);
                    $descriptionText = preg_replace('/\s*x-text="[^"]*"\s*/', '', $descriptionText);
                    $descriptionText = preg_replace('/\?\s*:/', '', $descriptionText);
                    $descriptionText = preg_replace('/\s*:\s*\'[^\']*\'/', '', $descriptionText); // Remove : 'fallback text'
                    $descriptionText = preg_replace('/\&\&\s*cards\[.*?\s*\?/', '', $descriptionText); // Remove && cards[...] ?
                    $descriptionText = trim($descriptionText);

                    // Only use if it's meaningful text (not just Alpine expressions or placeholders)
                    if (! empty($descriptionText) &&
                        ! preg_match('/^\s*$/', $descriptionText) &&
                        ! preg_match('/cards\[/', $descriptionText) &&
                        ! preg_match('/^\?\s*:/', $descriptionText) &&
                        $descriptionText !== 'Description '.$i &&
                        strlen($descriptionText) > 5) {
                        $description = $descriptionText;
                    } else {
                        // Last resort: try to extract from the x-text attribute's fallback
                        // The x-text might be: cards && cards[0] ? cards[0].description : 'Actual Description Text'
                        $xTextAttr = $descriptionElement->getAttribute('x-text');
                        if ($xTextAttr) {
                            // Try to extract the fallback text from x-text (the part after the colon)
                            // Pattern: ... : 'fallback text'
                            if (preg_match('/:\s*[\'"]([^\'"]+)[\'"]/', $xTextAttr, $matches)) {
                                $fallbackText = $matches[1];
                                if (! empty($fallbackText) &&
                                    $fallbackText !== 'Description '.$i &&
                                    strlen($fallbackText) > 5 &&
                                    ! preg_match('/cards\[/', $fallbackText)) {
                                    $description = $fallbackText;
                                }
                            }
                        }
                    }
                }

                Log::info("[DynamicBlockDataService] Extracted description for card {$i}", [
                    'card_index' => $i,
                    'description' => $description,
                    'raw_textContent' => trim($descriptionElement->textContent),
                    'has_x_text' => ! empty($descriptionElement->getAttribute('x-text')),
                    'x_text_attr' => $descriptionElement->getAttribute('x-text'),
                    'descriptionText_after_cleaning' => $descriptionText ?? 'empty',
                    'child_nodes_count' => $descriptionElement->childNodes->length,
                ]);
            } elseif ($card) {
                // Fallback: look for p in the card
                $pNodes = $xpath->query(".//p[contains(@class, 'text-primary-700') or @data-gjs-type='text']", $card);
                if ($pNodes->length > 0) {
                    $pElement = $pNodes->item(0);
                    $descriptionText = trim($pElement->textContent);

                    // Clean up Alpine.js patterns
                    $descriptionText = preg_replace('/cards\[.*?\]/s', '', $descriptionText);
                    $descriptionText = trim($descriptionText);

                    if (! empty($descriptionText) &&
                        $descriptionText !== 'Description '.$i &&
                        ! preg_match('/cards\[/', $descriptionText)) {
                        $description = $descriptionText;
                    }
                }
            }

            // Extract button text - first try data-gjs-name, then try button text
            // IMPORTANT: Use card context to avoid conflicts with pricing buttons (button-1, button-2, etc.)
            $buttonText = 'Learn More';

            // Try searching in card context first (more accurate and avoids conflicts)
            if ($card) {
                $buttonNodes = $xpath->query(".//*[@data-gjs-name='card-button-{$i}']", $card);
            } else {
                $buttonNodes = $xpath->query("//*[@data-gjs-name='card-button-{$i}']");
            }

            if ($buttonNodes->length > 0) {
                $buttonElement = $buttonNodes->item(0);
                $buttonTextValue = trim($buttonElement->textContent);

                // Check for span inside button (common structure with Alpine.js)
                $buttonSpan = $xpath->query('.//span', $buttonElement);
                if ($buttonSpan->length > 0) {
                    foreach ($buttonSpan as $span) {
                        $spanText = trim($span->textContent);
                        // Skip Alpine.js expressions and default text
                        if (! empty($spanText) &&
                            $spanText !== 'Learn More' &&
                            ! preg_match('/x-text/', $span->getAttribute('x-text') ?? '') &&
                            ! preg_match('/cards\[/', $spanText)) {
                            $buttonText = $spanText;
                            break;
                        }
                    }
                } elseif (! empty($buttonTextValue) && $buttonTextValue !== 'Learn More') {
                    $buttonText = $buttonTextValue;
                }
            } elseif ($card) {
                // Fallback: look for button in the card (but make sure it's not a pricing button)
                $buttonElements = $xpath->query(".//button[not(@data-gjs-name='button-1') and not(@data-gjs-name='button-2') and not(@data-gjs-name='button-3')]", $card);
                if ($buttonElements->length > 0) {
                    $buttonElement = $buttonElements->item(0);
                    $buttonTextValue = trim($buttonElement->textContent);

                    // Check span inside
                    $buttonSpan = $xpath->query('.//span', $buttonElement);
                    if ($buttonSpan->length > 0) {
                        $spanText = trim($buttonSpan->item(0)->textContent);
                        if (! empty($spanText) && $spanText !== 'Learn More' && ! preg_match('/cards\[/', $spanText)) {
                            $buttonText = $spanText;
                        }
                    } elseif (! empty($buttonTextValue) && $buttonTextValue !== 'Learn More') {
                        $buttonText = $buttonTextValue;
                    }
                }
            }

            $cards[] = [
                'icon' => $this->getCardIcon($i),
                'title' => $title,
                'description' => $description,
                'buttonText' => $buttonText,
                'visible' => false,
                'delay' => ($i - 1) * 200,
            ];
        }

        Log::info('[DynamicBlockDataService] Extracted cards data from HTML', [
            'cards_count' => count($cards),
            'titles' => array_column($cards, 'title'),
        ]);

        return ['cards' => $cards];
    }

    /**
     * Helper method to find match value
     */
    private function findMatchValue(array $matches, int $index, string $default): string
    {
        if (isset($matches[1]) && isset($matches[2])) {
            for ($i = 0; $i < count($matches[1]); $i++) {
                if ($matches[1][$i] == $index) {
                    return trim($matches[2][$i]);
                }
            }
        }

        return $default;
    }

    /**
     * Get initials from name
     */
    private function getInitials(string $name): string
    {
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        return substr($initials, 0, 2);
    }

    /**
     * Get timeline icon for step
     */
    private function getTimelineIcon(int $step): string
    {
        $icons = [
            'M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
            'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z',
            'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4',
            'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'M5 13l4 4L19 7',
        ];

        return $icons[$step - 1] ?? $icons[0];
    }

    /**
     * Get card icon for service
     */
    private function getCardIcon(int $card): string
    {
        $icons = ['🚀', '🎨', '⚡'];

        return $icons[$card - 1] ?? '🚀';
    }

    /**
     * Extract stats data from GrapesJS HTML
     */
    private function extractStatsData(string $html): array
    {
        $stats = [];

        // Use DOMDocument for more reliable extraction
        $dom = new DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);

        // Find the stats block container
        $statsBlock = $xpath->query("//div[contains(@class, 'animated-stats-block')]");

        // Extract title and subtitle
        $title = 'Our Impact';
        $titleNodes = $xpath->query("//*[@data-gjs-name='stats-title']");
        if ($titleNodes->length > 0) {
            $titleText = trim($titleNodes->item(0)->textContent);
            if (! empty($titleText)) {
                $title = $titleText;
            }
        } elseif ($statsBlock->length > 0) {
            $h2Nodes = $xpath->query('.//h2', $statsBlock->item(0));
            if ($h2Nodes->length > 0) {
                $titleText = trim($h2Nodes->item(0)->textContent);
                if (! empty($titleText) && $titleText !== 'Our Impact') {
                    $title = $titleText;
                }
            }
        }

        $subtitle = 'Numbers that speak for our success and expertise';
        $subtitleNodes = $xpath->query("//*[@data-gjs-name='stats-subtitle']");
        if ($subtitleNodes->length > 0) {
            $subtitleText = trim($subtitleNodes->item(0)->textContent);
            if (! empty($subtitleText)) {
                $subtitle = $subtitleText;
            }
        } elseif ($statsBlock->length > 0) {
            $pNodes = $xpath->query(".//p[contains(@class, 'text-lg')]", $statsBlock->item(0));
            if ($pNodes->length > 0) {
                $subtitleText = trim($pNodes->item(0)->textContent);
                if (! empty($subtitleText) && $subtitleText !== 'Numbers that speak for our success and expertise') {
                    $subtitle = $subtitleText;
                }
            }
        }

        // Find all stat cards
        $statCards = $xpath->query("//div[contains(@class, 'stat-card')]");

        // Extract stats data
        for ($i = 1; $i <= 4; $i++) {
            $statIndex = $i - 1;

            // Try to get the stat card by index
            $card = null;
            if ($statCards->length >= $i) {
                $card = $statCards->item($statIndex);
            }

            // Extract number - use default if not found
            $defaultNumbers = [150, 50, 5, 99];
            $number = $defaultNumbers[$statIndex] ?? 0;

            $numberNodes = $xpath->query("//*[@data-gjs-name='stat-number-{$i}']");
            if ($numberNodes->length > 0) {
                $numberText = trim($numberNodes->item(0)->textContent);
                // Extract numeric value (remove suffix if present)
                $numberText = preg_replace('/[^0-9]/', '', $numberText);
                if (! empty($numberText) && (int) $numberText > 0) {
                    $number = (int) $numberText;
                }
            } elseif ($card) {
                // Fallback: look for number in the card (span with large text)
                $numberSpans = $xpath->query(".//span[contains(@class, 'text-4xl') or contains(@class, 'text-3xl')]", $card);
                if ($numberSpans->length > 0) {
                    $numberText = trim($numberSpans->item(0)->textContent);
                    $numberText = preg_replace('/[^0-9]/', '', $numberText);
                    if (! empty($numberText) && (int) $numberText > 0) {
                        $number = (int) $numberText;
                    }
                }
            }

            // Extract suffix - use defaults
            $defaultSuffixes = ['+', '+', '+', '%'];
            $suffix = $defaultSuffixes[$statIndex] ?? '+';

            $suffixNodes = $xpath->query("//*[@data-gjs-name='stat-suffix-{$i}']");
            if ($suffixNodes->length > 0) {
                $suffixText = trim($suffixNodes->item(0)->textContent);
                if (! empty($suffixText) && in_array($suffixText, ['+', '%', 'k', 'M'])) {
                    $suffix = $suffixText;
                }
            } elseif ($card) {
                // Fallback: look for suffix after the number
                $suffixSpans = $xpath->query(".//span[contains(@class, 'text-2xl')]", $card);
                if ($suffixSpans->length > 0) {
                    $suffixText = trim($suffixSpans->item(0)->textContent);
                    if (in_array($suffixText, ['+', '%', 'k', 'M'])) {
                        $suffix = $suffixText;
                    }
                }
            }

            // Extract label - use defaults
            $defaultLabels = ['Projects Completed', 'Happy Clients', 'Years Experience', 'Client Satisfaction'];
            $label = $defaultLabels[$statIndex] ?? 'Stat '.$i;

            $labelNodes = $xpath->query("//*[@data-gjs-name='stat-label-{$i}']");
            if ($labelNodes->length > 0) {
                $labelText = trim($labelNodes->item(0)->textContent);
                if (! empty($labelText) && strlen($labelText) > 2) {
                    $label = $labelText;
                }
            } elseif ($card) {
                // Fallback: look for label in the card
                $labelSpans = $xpath->query(".//span[contains(@class, 'text-lg') or contains(@class, 'font-semibold')]", $card);
                if ($labelSpans->length > 0) {
                    $labelText = trim($labelSpans->item(0)->textContent);
                    if (! empty($labelText) && $labelText !== 'Stat '.$i && strlen($labelText) > 2) {
                        $label = $labelText;
                    }
                }
            }

            // Default icon (can be customized later if needed)
            $icons = [
                'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                'M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
            ];

            $stats[] = [
                'number' => $number,
                'suffix' => $suffix,
                'label' => $label,
                'icon' => $icons[$statIndex] ?? $icons[0],
            ];
        }

        Log::info('[DynamicBlockDataService] Extracted stats data from HTML', [
            'stats_count' => count($stats),
            'title' => $title,
            'subtitle' => $subtitle,
            'numbers' => array_column($stats, 'number'),
            'labels' => array_column($stats, 'label'),
        ]);

        return [
            'title' => $title,
            'subtitle' => $subtitle,
            'stats' => $stats,
        ];
    }

    /**
     * Extract progress bars data from GrapesJS HTML
     */
    private function extractProgressData(string $html): array
    {
        $skills = [];

        // Use DOMDocument for more reliable extraction
        $dom = new DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);

        // Find the progress block container
        $progressBlock = $xpath->query("//div[contains(@class, 'progress-block')]");

        // Extract title
        $title = 'Our Skills & Expertise';
        $titleNodes = $xpath->query("//*[@data-gjs-name='progress-title']");
        if ($titleNodes->length > 0) {
            $titleText = trim($titleNodes->item(0)->textContent);
            if (! empty($titleText)) {
                $title = $titleText;
            }
        } elseif ($progressBlock->length > 0) {
            $h2Nodes = $xpath->query('.//h2', $progressBlock->item(0));
            if ($h2Nodes->length > 0) {
                $titleText = trim($h2Nodes->item(0)->textContent);
                if (! empty($titleText) && $titleText !== 'Our Skills & Expertise') {
                    $title = $titleText;
                }
            }
        }

        // Extract summary
        $summary = "We're experts in modern web technologies and always learning new skills.";
        $summaryNodes = $xpath->query("//*[@data-gjs-name='progress-summary']");
        if ($summaryNodes->length > 0) {
            $summaryText = trim($summaryNodes->item(0)->textContent);
            if (! empty($summaryText)) {
                $summary = $summaryText;
            }
        } elseif ($progressBlock->length > 0) {
            $pNodes = $xpath->query(".//p[contains(@class, 'text-lg')]", $progressBlock->item(0));
            if ($pNodes->length > 0) {
                $summaryText = trim($pNodes->item(0)->textContent);
                if (! empty($summaryText) && $summaryText !== $summary) {
                    $summary = $summaryText;
                }
            }
        }

        // Extract button text
        $buttonText = 'View Our Work';
        $buttonNodes = $xpath->query("//*[@data-gjs-name='progress-button']");
        if ($buttonNodes->length > 0) {
            $buttonTextContent = trim($buttonNodes->item(0)->textContent);
            if (! empty($buttonTextContent)) {
                $buttonText = $buttonTextContent;
            }
        } elseif ($progressBlock->length > 0) {
            $buttonElements = $xpath->query('.//button', $progressBlock->item(0));
            if ($buttonElements->length > 0) {
                $buttonTextContent = trim($buttonElements->item(0)->textContent);
                if (! empty($buttonTextContent) && $buttonTextContent !== $buttonText) {
                    $buttonText = $buttonTextContent;
                }
            }
        }

        // Find all progress items
        $progressItems = $xpath->query("//div[contains(@class, 'progress-item')]");

        // Extract skills data
        for ($i = 1; $i <= 4; $i++) {
            $skillIndex = $i - 1;

            // Try to get the progress item by index
            $item = null;
            if ($progressItems->length >= $i) {
                $item = $progressItems->item($skillIndex);
            }

            // Extract skill name - use defaults
            $defaultNames = ['Web Development', 'UI/UX Design', 'Mobile Development', 'DevOps & Cloud'];
            $name = $defaultNames[$skillIndex] ?? 'Skill '.$i;

            $nameNodes = $xpath->query("//*[@data-gjs-name='skill-name-{$i}']");
            if ($nameNodes->length > 0) {
                $nameText = trim($nameNodes->item(0)->textContent);
                if ($nameText !== '') {
                    $name = $nameText;
                }
            } elseif ($item) {
                // Fallback: look for h3 in the item
                $h3Nodes = $xpath->query('.//h3', $item);
                if ($h3Nodes->length > 0) {
                    $nameText = trim($h3Nodes->item(0)->textContent);
                    if ($nameText !== '' && $nameText !== 'Skill '.$i) {
                        $name = $nameText;
                    }
                }
            }

            // Extract percentage - use defaults
            $defaultPercentages = [95, 88, 92, 85];
            $percentage = $defaultPercentages[$skillIndex] ?? 0;

            $percentageNodes = $xpath->query("//*[@data-gjs-name='skill-percentage-{$i}']");
            if ($percentageNodes->length > 0) {
                $percentageText = trim($percentageNodes->item(0)->textContent);
                // Extract numeric value (remove % if present)
                $percentageText = preg_replace('/[^0-9]/', '', $percentageText);
                if (! empty($percentageText) && (int) $percentageText > 0 && (int) $percentageText <= 100) {
                    $percentage = (int) $percentageText;
                }
            } elseif ($item) {
                // Fallback: look for percentage in the item (span with percentage)
                $percentageSpans = $xpath->query(".//span[contains(@class, 'text-sm') or contains(@class, 'font-medium')]", $item);
                if ($percentageSpans->length > 0) {
                    $percentageText = trim($percentageSpans->item(0)->textContent);
                    $percentageText = preg_replace('/[^0-9]/', '', $percentageText);
                    if (! empty($percentageText) && (int) $percentageText > 0 && (int) $percentageText <= 100) {
                        $percentage = (int) $percentageText;
                    }
                }
                // Also check the style attribute of the progress bar
                $progressBars = $xpath->query(".//div[contains(@class, 'bg-accent')]", $item);
                if ($progressBars->length > 0) {
                    $styleAttr = $progressBars->item(0)->getAttribute('style');
                    if (preg_match('/width:\s*(\d+)%/', $styleAttr, $matches)) {
                        $percentage = (int) $matches[1];
                    }
                }
            }

            $skills[] = [
                'name' => $name,
                'percentage' => $percentage,
            ];
        }

        Log::info('[DynamicBlockDataService] Extracted progress data from HTML', [
            'skills_count' => count($skills),
            'title' => $title,
            'summary' => $summary,
            'button_text' => $buttonText,
            'skill_names' => array_column($skills, 'name'),
            'percentages' => array_column($skills, 'percentage'),
        ]);

        return [
            'title' => $title,
            'summary' => $summary,
            'buttonText' => $buttonText,
            'skills' => $skills,
        ];
    }

    /**
     * Read data-portfolio-project-ids / data-portfolio-project-slugs from the block root (set in the page builder).
     *
     * @return array<string, string>
     */
    private function extractAnimatedPortfolioData(string $html): array
    {
        $dom = new DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);
        $nodes = $xpath->query("//*[@data-laragrape-block='animated-portfolio']");
        if ($nodes->length === 0) {
            return [];
        }

        $el = $nodes->item(0);
        if (! $el instanceof DOMElement) {
            return [];
        }

        $out = [];

        $cardNodes = $xpath->query('.//*[@data-gjs-type="animated-portfolio-item"]', $el);
        if ($cardNodes->length === 0) {
            $cardNodes = $xpath->query('.//div[contains(concat(" ", normalize-space(@class), " "), " portfolio-item ")]', $el);
        }

        if ($cardNodes->length > 0) {
            $slots = [];
            foreach ($cardNodes as $card) {
                if (! $card instanceof DOMElement) {
                    continue;
                }
                $slots[] = trim($card->getAttribute('data-portfolio-project-id'));
            }
            if ($slots !== []) {
                $out['project_slot_ids'] = $slots;
            }
        }

        $ids = trim($el->getAttribute('data-portfolio-project-ids'));
        if ($ids !== '') {
            $out['project_ids'] = $ids;
        }
        $slugs = trim($el->getAttribute('data-portfolio-project-slugs'));
        if ($slugs !== '') {
            $out['project_slugs'] = $slugs;
        }

        return $out;
    }
}
