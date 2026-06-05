<?php

namespace LaraGrape\Services;

use DOMDocument;
use DOMElement;
use DOMXPath;
use LaraGrape\Support\TechStackRegistry;

class BlockHtmlPatcher
{
    public function __construct(
        protected TechStackRegistry $techStackRegistry,
    ) {}

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
            'animated-stats' => $this->patchAnimatedStatsBuilder($html, $dynamicData),
            'simple-animated-counter' => $this->patchSimpleCounterBuilder($html, $dynamicData),
            'animated-pricing', 'animated-pricing-clean' => $this->patchAnimatedPricingBuilder($html, $dynamicData),
            'animated-faq' => $this->patchAnimatedFaqBuilder($html, $dynamicData),
            'animated-cards' => $this->patchAnimatedCardsBuilder($html, $dynamicData),
            'animated-timeline' => $this->patchTimelineBuilder($html, $dynamicData),
            'animated-progress-bars' => $this->patchProgressBarsBuilder($html, $dynamicData),
            'animated-hero', 'animated-full-image-hero' => $this->patchAnimatedHeroBuilder($html, $dynamicData),
            'animated-tech-stack' => $this->patchTechStackBuilder($html, $dynamicData),
            'animated-portfolio' => $this->patchPortfolioBuilder($html, $dynamicData),
            'service-showcase' => $this->patchServiceShowcaseBuilder($html, $dynamicData),
            'interactive-pricing' => $this->patchAnimatedPricingBuilder($html, $dynamicData),
            'technology-stack' => $this->patchTechnologyStackShowcaseBuilder($html, $dynamicData),
            'pricing' => $this->patchBasicPricingBuilder($html, $dynamicData),
            'card' => $this->patchCardBuilder($html, $dynamicData),
            'alert' => $this->patchByGjsNames($html, [
                'body' => (string) ($dynamicData['body'] ?? ''),
            ], [
                'body' => 'alert-text',
            ]),
            'testimonial' => $this->patchByGjsNames($html, [
                'body' => (string) ($dynamicData['body'] ?? ''),
                'title' => (string) ($dynamicData['title'] ?? ''),
            ], [
                'body' => 'testimonial-quote',
                'title' => 'testimonial-author',
            ]),
            'image' => $this->patchImageBuilder($html, $dynamicData),
            'video' => $this->patchVideoBuilder($html, $dynamicData),
            'spacer' => $this->patchSpacerBuilder($html, $dynamicData),
            'list' => $this->patchListBuilder($html, $dynamicData),
            'quote' => $this->patchByGjsNames($html, [
                'body' => (string) ($dynamicData['body'] ?? ''),
                'title' => (string) ($dynamicData['title'] ?? ''),
            ], [
                'body' => 'quote-text',
                'title' => 'quote-author',
            ]),
            'portfolio-teaser' => $this->patchByGjsNames($html, [
                'title' => (string) ($dynamicData['title'] ?? ''),
                'subtitle' => (string) ($dynamicData['subtitle'] ?? ''),
            ], [
                'title' => 'teaser-title',
                'subtitle' => 'teaser-subtitle',
            ]),
            default => $this->patchGenericBuilderFields($html, $dynamicData),
        };
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchTimelineBuilder(string $html, array $dynamicData): string
    {
        $html = $this->patchByGjsNames($html, [
            'title' => (string) ($dynamicData['title'] ?? ''),
            'subtitle' => (string) ($dynamicData['subtitle'] ?? ''),
        ], [
            'title' => 'timeline-title',
            'subtitle' => 'timeline-subtitle',
        ]);

        $steps = $dynamicData['steps'] ?? [];
        if (! is_array($steps)) {
            return $html;
        }

        $position = 0;
        foreach ($steps as $step) {
            if (! is_array($step)) {
                continue;
            }

            $position++;
            if ($position > 5) {
                break;
            }

            $html = $this->patchByGjsNames($html, [
                'title' => (string) ($step['title'] ?? ''),
                'description' => (string) ($step['description'] ?? ''),
                'duration' => (string) ($step['duration'] ?? ''),
            ], [
                'title' => "timeline-title-{$position}",
                'description' => "timeline-description-{$position}",
                'duration' => "timeline-duration-{$position}",
            ]);
        }

        return $html;
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchProgressBarsBuilder(string $html, array $dynamicData): string
    {
        $html = $this->patchByGjsNames($html, [
            'title' => (string) ($dynamicData['title'] ?? ''),
            'summary' => (string) ($dynamicData['summary'] ?? ''),
            'button' => (string) ($dynamicData['button_text'] ?? $dynamicData['buttonText'] ?? ''),
        ], [
            'title' => 'progress-title',
            'summary' => 'progress-summary',
            'button' => 'progress-button',
        ]);

        $skills = $dynamicData['skills'] ?? [];
        if (! is_array($skills)) {
            return $html;
        }

        $position = 0;
        foreach ($skills as $skill) {
            if (! is_array($skill)) {
                continue;
            }

            $position++;
            if ($position > 4) {
                break;
            }

            $percentage = preg_replace('/\D+/', '', (string) ($skill['percentage'] ?? ''));
            $html = $this->patchByGjsNames($html, [
                'name' => (string) ($skill['name'] ?? ''),
                'percentage' => $percentage !== '' ? $percentage.'%' : '',
            ], [
                'name' => "skill-name-{$position}",
                'percentage' => "skill-percentage-{$position}",
            ]);
        }

        return $html;
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchAnimatedHeroBuilder(string $html, array $dynamicData): string
    {
        $hero = is_array($dynamicData['hero'] ?? null) ? $dynamicData['hero'] : [];

        $html = $this->patchByGjsNames($html, [
            'title' => (string) ($dynamicData['title'] ?? $hero['title'] ?? ''),
            'description' => (string) ($dynamicData['description'] ?? $hero['description'] ?? ''),
            'primary' => (string) ($dynamicData['primary_button_text'] ?? $hero['primaryButton']['text'] ?? ''),
            'secondary' => (string) ($dynamicData['secondary_button_text'] ?? $hero['secondaryButton']['text'] ?? ''),
        ], [
            'title' => 'hero-title',
            'description' => 'hero-description',
            'primary' => 'hero-button-primary',
            'secondary' => 'hero-button-secondary',
        ]);

        $imageSrc = trim((string) ($dynamicData['image_src'] ?? $hero['image']['src'] ?? ''));
        if ($imageSrc !== '') {
            $html = $this->patchAttributeByGjsName($html, 'hero-image', 'src', $imageSrc);
            $alt = trim((string) ($dynamicData['image_alt'] ?? $hero['image']['alt'] ?? ''));
            if ($alt !== '') {
                $html = $this->patchAttributeByGjsName($html, 'hero-image', 'alt', $alt);
            }
        }

        return $html;
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchTechStackBuilder(string $html, array $dynamicData): string
    {
        $html = $this->patchByGjsNames($html, [
            'title' => (string) ($dynamicData['title'] ?? ''),
            'subtitle' => (string) ($dynamicData['subtitle'] ?? ''),
        ], [
            'title' => 'tech-stack-title',
            'subtitle' => 'tech-stack-subtitle',
        ]);

        $items = $dynamicData['items'] ?? [];
        if (! is_array($items)) {
            return $html;
        }

        $position = 0;
        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $key = trim((string) ($item['key'] ?? ''));
            if ($key === '') {
                continue;
            }

            $position++;
            if ($position > 12) {
                break;
            }

            $meta = $this->techStackRegistry->resolve($key);
            $html = $this->patchByGjsNames($html, [
                'name' => (string) ($item['label'] ?? $meta['label'] ?? $key),
                'icon' => (string) ($meta['icon'] ?? '⚙️'),
            ], [
                'name' => "tech-name-{$position}",
                'icon' => "tech-icon-{$position}",
            ]);
        }

        return $html;
    }

    public function patchAttributeByGjsName(string $html, string $gjsName, string $attribute, string $value): string
    {
        if (trim($html) === '' || trim($value) === '') {
            return $html;
        }

        $dom = new DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);
        $nodes = $xpath->query("//*[@data-gjs-name='{$gjsName}']");
        if ($nodes->length === 0) {
            return $html;
        }

        $node = $nodes->item(0);
        if (! $node instanceof DOMElement) {
            return $html;
        }

        $node->setAttribute($attribute, $value);
        $output = $dom->saveHTML();
        if ($output === false) {
            return $html;
        }

        return preg_replace('/^<\?xml[^>]*>\s*/u', '', $output) ?? $html;
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchSimpleCounterBuilder(string $html, array $dynamicData): string
    {
        $html = $this->patchByGjsNames($html, [
            'title' => (string) ($dynamicData['title'] ?? ''),
        ], [
            'title' => 'counter-title',
        ]);

        $items = $dynamicData['counters'] ?? [];
        if (! is_array($items)) {
            return $html;
        }

        $position = 0;
        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $position++;
            if ($position > 6) {
                break;
            }

            $html = $this->patchByGjsNames($html, [
                'value' => (string) ($item['value'] ?? ''),
                'label' => (string) ($item['label'] ?? ''),
            ], [
                'value' => "counter-value-{$position}",
                'label' => "counter-label-{$position}",
            ]);
        }

        return $html;
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchAnimatedStatsBuilder(string $html, array $dynamicData): string
    {
        $html = $this->patchByGjsNames($html, [
            'title' => (string) ($dynamicData['title'] ?? ''),
            'subtitle' => (string) ($dynamicData['subtitle'] ?? ''),
        ], [
            'title' => 'stats-title',
            'subtitle' => 'stats-subtitle',
        ]);

        $items = $dynamicData['stats'] ?? [];
        if (! is_array($items)) {
            return $html;
        }

        $position = 0;
        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $position++;
            if ($position > 8) {
                break;
            }

            [$number, $suffix] = $this->parseStatValue($item);

            $html = $this->patchByGjsNames($html, [
                'number' => $number,
                'suffix' => $suffix,
                'label' => (string) ($item['label'] ?? ''),
            ], [
                'number' => "stat-number-{$position}",
                'suffix' => "stat-suffix-{$position}",
                'label' => "stat-label-{$position}",
            ]);
        }

        return $html;
    }

    /**
     * @param  array<string, mixed>  $item
     * @return array{0: string, 1: string}
     */
    protected function parseStatValue(array $item): array
    {
        $value = trim((string) ($item['value'] ?? ''));
        $suffix = trim((string) ($item['suffix'] ?? ''));

        if ($value !== '' && preg_match('/^(\d+(?:\.\d+)?)(.*)$/u', $value, $matches)) {
            $parsedSuffix = trim((string) ($matches[2] ?? ''));

            return [
                (string) $matches[1],
                $parsedSuffix !== '' ? $parsedSuffix : ($suffix !== '' ? $suffix : '+'),
            ];
        }

        $number = trim((string) ($item['number'] ?? $value));

        if ($number === '' && $value !== '') {
            $number = preg_replace('/\D+/', '', $value) ?? '';
        }

        if ($suffix === '' && $value !== '' && preg_match('/(\+|%|k|M)$/iu', $value, $suffixMatch)) {
            $suffix = $suffixMatch[1];
        }

        return [$number, $suffix !== '' ? $suffix : '+'];
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

        $position = 0;
        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $position++;
            if ($position > 6) {
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
                'text' => "testimonial-text-{$position}",
                'name' => "client-name-{$position}",
                'title' => "client-title-{$position}",
                'initials' => "client-initials-{$position}",
            ]);
        }

        return $html;
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchAnimatedPricingBuilder(string $html, array $dynamicData): string
    {
        $html = $this->patchByGjsNames($html, [
            'title' => (string) ($dynamicData['title'] ?? ''),
        ], [
            'title' => 'pricing-title',
        ]);

        $plans = $dynamicData['plans'] ?? [];
        if (! is_array($plans)) {
            return $html;
        }

        $planPosition = 0;
        foreach ($plans as $plan) {
            if (! is_array($plan)) {
                continue;
            }

            $planPosition++;
            if ($planPosition > 4) {
                break;
            }

            $priceDigits = preg_replace('/[^0-9.]/', '', (string) ($plan['price'] ?? '')) ?: '';

            $html = $this->patchByGjsNames($html, [
                'name' => (string) ($plan['name'] ?? ''),
                'price' => $priceDigits,
                'period' => $this->normalizePricingPeriod($plan),
            ], [
                'name' => "plan-name-{$planPosition}",
                'price' => "plan-price-{$planPosition}",
                'period' => "plan-period-{$planPosition}",
            ]);

            $features = $plan['features'] ?? [];
            if (! is_array($features)) {
                continue;
            }

            $featurePosition = 0;
            foreach ($features as $feature) {
                $featurePosition++;
                if ($featurePosition > 10) {
                    break;
                }

                $text = is_array($feature)
                    ? trim((string) ($feature['text'] ?? ''))
                    : trim((string) $feature);

                if ($text === '') {
                    continue;
                }

                $html = $this->patchByGjsNames($html, [
                    'text' => $text,
                ], [
                    'text' => "feature-{$planPosition}-{$featurePosition}",
                ]);
            }
        }

        return $html;
    }

    /**
     * @param  array<string, mixed>  $plan
     */
    protected function normalizePricingPeriod(array $plan): string
    {
        $period = trim((string) ($plan['period'] ?? ''));
        if ($period === '') {
            return '/month';
        }

        return str_starts_with($period, '/') ? $period : '/'.$period;
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchAnimatedFaqBuilder(string $html, array $dynamicData): string
    {
        $html = $this->patchByGjsNames($html, [
            'ctaButton' => (string) ($dynamicData['ctaButton'] ?? ''),
        ], [
            'ctaButton' => 'faq-cta-button',
        ]);

        $faqs = $dynamicData['faqs'] ?? [];
        if (! is_array($faqs)) {
            return $html;
        }

        $position = 0;
        foreach ($faqs as $faq) {
            if (! is_array($faq)) {
                continue;
            }

            $position++;
            if ($position > 8) {
                break;
            }

            $html = $this->patchByGjsNames($html, [
                'question' => (string) ($faq['question'] ?? ''),
                'answer' => (string) ($faq['answer'] ?? ''),
            ], [
                'question' => "faq-question-{$position}",
                'answer' => "faq-answer-{$position}",
            ]);
        }

        return $html;
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchAnimatedCardsBuilder(string $html, array $dynamicData): string
    {
        $html = $this->patchByGjsNames($html, [
            'title' => (string) ($dynamicData['title'] ?? ''),
        ], [
            'title' => 'cards-title',
        ]);

        $cards = $dynamicData['cards'] ?? [];
        if (! is_array($cards)) {
            return $html;
        }

        $position = 0;
        foreach ($cards as $card) {
            if (! is_array($card)) {
                continue;
            }

            $position++;
            if ($position > 6) {
                break;
            }

            $html = $this->patchByGjsNames($html, [
                'title' => (string) ($card['title'] ?? ''),
                'description' => (string) ($card['description'] ?? ''),
            ], [
                'title' => "card-title-{$position}",
                'description' => "card-description-{$position}",
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
            'title' => ['title', 'heading-title', 'section-title', 'grid-title', 'card-title', 'cards-title', 'faq-title', 'list-title', 'quote-text', 'teaser-title', 'timeline-title', 'progress-title', 'tech-stack-title', 'stats-title', 'counter-title', 'pricing-title'],
            'body' => ['body', 'text-content', 'content', 'subtitle', 'grid-subtitle', 'description', 'timeline-subtitle', 'tech-stack-subtitle', 'stats-subtitle', 'teaser-subtitle'],
            'button_text' => ['button_text', 'hero-button', 'cta-button', 'faq-cta-button', 'progress-button'],
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

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchPortfolioBuilder(string $html, array $dynamicData): string
    {
        $html = $this->patchByGjsNames($html, [
            'title' => (string) ($dynamicData['title'] ?? ''),
            'subtitle' => (string) ($dynamicData['subtitle'] ?? ''),
        ], [
            'title' => 'portfolio-title',
            'subtitle' => 'portfolio-subtitle',
        ]);

        $projects = $dynamicData['projects'] ?? [];
        if (! is_array($projects)) {
            return $html;
        }

        $position = 0;
        foreach ($projects as $project) {
            if (! is_array($project)) {
                continue;
            }

            $position++;
            if ($position > 6) {
                break;
            }

            $html = $this->patchByGjsNames($html, [
                'title' => (string) ($project['title'] ?? ''),
                'description' => (string) ($project['description'] ?? ''),
                'link' => (string) ($project['link'] ?? ''),
            ], [
                'title' => "project-title-{$position}",
                'description' => "project-description-{$position}",
                'link' => "project-link-{$position}",
            ]);

            $projectId = trim((string) ($project['project_id'] ?? ''));
            if ($projectId !== '') {
                $html = $this->patchPortfolioCardAttribute($html, $position, 'data-portfolio-project-id', $projectId);
            }

            $tags = $project['tags'] ?? [];
            if (! is_array($tags)) {
                continue;
            }

            $tagPosition = 0;
            foreach ($tags as $tag) {
                $tagPosition++;
                if ($tagPosition > 4) {
                    break;
                }

                $text = is_array($tag)
                    ? trim((string) ($tag['text'] ?? ''))
                    : trim((string) $tag);

                if ($text === '') {
                    continue;
                }

                $html = $this->patchByGjsNames($html, [
                    'text' => $text,
                ], [
                    'text' => "project-tag-{$position}-{$tagPosition}",
                ]);
            }
        }

        return $html;
    }

    public function patchPortfolioCardAttribute(string $html, int $position, string $attribute, string $value): string
    {
        if (trim($html) === '' || $position < 1) {
            return $html;
        }

        $dom = new DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);
        $nodes = $xpath->query('.//*[@data-gjs-type="animated-portfolio-item"]');
        if ($nodes->length < $position) {
            $nodes = $xpath->query('.//div[contains(concat(" ", normalize-space(@class), " "), " portfolio-item ")]');
        }

        $node = $nodes->item($position - 1);
        if (! $node instanceof DOMElement) {
            return $html;
        }

        $node->setAttribute($attribute, $value);
        $output = $dom->saveHTML();

        return $output === false ? $html : (preg_replace('/^<\?xml[^>]*>\s*/u', '', $output) ?? $html);
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchServiceShowcaseBuilder(string $html, array $dynamicData): string
    {
        $html = $this->patchByGjsNames($html, [
            'title' => (string) ($dynamicData['title'] ?? ''),
            'subtitle' => (string) ($dynamicData['subtitle'] ?? ''),
        ], [
            'title' => 'services-title',
            'subtitle' => 'services-subtitle',
        ]);

        $services = $dynamicData['services'] ?? [];
        if (! is_array($services)) {
            return $html;
        }

        $position = 0;
        foreach ($services as $service) {
            if (! is_array($service)) {
                continue;
            }

            $position++;
            if ($position > 6) {
                break;
            }

            $html = $this->patchByGjsNames($html, [
                'title' => (string) ($service['title'] ?? ''),
                'description' => (string) ($service['description'] ?? ''),
                'button' => (string) ($service['button'] ?? $service['button_text'] ?? ''),
            ], [
                'title' => "service-{$position}-title",
                'description' => "service-{$position}-description",
                'button' => "service-{$position}-button",
            ]);
        }

        return $html;
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchTechnologyStackShowcaseBuilder(string $html, array $dynamicData): string
    {
        return $this->patchByGjsNames($html, [
            'title' => (string) ($dynamicData['title'] ?? ''),
            'subtitle' => (string) ($dynamicData['subtitle'] ?? ''),
        ], [
            'title' => 'tech-stack-title',
            'subtitle' => 'tech-stack-subtitle',
        ]);
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchBasicPricingBuilder(string $html, array $dynamicData): string
    {
        $html = $this->patchByGjsNames($html, [
            'title' => (string) ($dynamicData['title'] ?? ''),
        ], [
            'title' => 'pricing-title',
        ]);

        $plans = $dynamicData['plans'] ?? [];
        if (! is_array($plans)) {
            return $html;
        }

        $planPosition = 0;
        foreach ($plans as $plan) {
            if (! is_array($plan)) {
                continue;
            }

            $planPosition++;
            if ($planPosition > 4) {
                break;
            }

            $priceDigits = preg_replace('/[^0-9.]/', '', (string) ($plan['price'] ?? '')) ?: '';

            $html = $this->patchByGjsNames($html, [
                'name' => (string) ($plan['name'] ?? ''),
                'price' => $priceDigits !== '' ? '$'.$priceDigits : (string) ($plan['price'] ?? ''),
                'period' => $this->normalizePricingPeriod($plan),
            ], [
                'name' => "plan-name-{$planPosition}",
                'price' => "plan-price-{$planPosition}",
                'period' => "plan-period-{$planPosition}",
            ]);

            $features = $plan['features'] ?? [];
            if (! is_array($features)) {
                continue;
            }

            $featurePosition = 0;
            foreach ($features as $feature) {
                $featurePosition++;
                if ($featurePosition > 10) {
                    break;
                }

                $text = is_array($feature)
                    ? trim((string) ($feature['text'] ?? ''))
                    : trim((string) $feature);

                if ($text === '') {
                    continue;
                }

                $html = $this->patchByGjsNames($html, [
                    'text' => $text,
                ], [
                    'text' => "plan-feature-{$planPosition}-{$featurePosition}",
                ]);
            }
        }

        return $html;
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchCardBuilder(string $html, array $dynamicData): string
    {
        $html = $this->patchByGjsNames($html, [
            'title' => (string) ($dynamicData['title'] ?? ''),
            'body' => (string) ($dynamicData['body'] ?? ''),
            'button_text' => (string) ($dynamicData['button_text'] ?? ''),
        ], [
            'title' => 'card-title',
            'body' => 'card-description',
            'button_text' => 'card-button',
        ]);

        $imageSrc = trim((string) ($dynamicData['image_src'] ?? ''));
        if ($imageSrc !== '') {
            $html = $this->patchAttributeByGjsName($html, 'card-image', 'src', $imageSrc);
        }

        return $html;
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchImageBuilder(string $html, array $dynamicData): string
    {
        $src = trim((string) ($dynamicData['src'] ?? ''));
        if ($src !== '') {
            $html = $this->patchAttributeByGjsName($html, 'image-src', 'src', $src);
        }

        $alt = trim((string) ($dynamicData['alt'] ?? ''));
        if ($alt !== '') {
            $html = $this->patchAttributeByGjsName($html, 'image-src', 'alt', $alt);
        }

        $caption = trim((string) ($dynamicData['caption'] ?? ''));
        if ($caption !== '') {
            $html = $this->patchByGjsNames($html, ['caption' => $caption], ['caption' => 'image-caption']);
        }

        return $html;
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchVideoBuilder(string $html, array $dynamicData): string
    {
        $src = trim((string) ($dynamicData['src'] ?? ''));
        if ($src !== '') {
            $html = $this->patchAttributeByGjsName($html, 'video-src', 'src', $src);
        }

        return $this->patchByGjsNames($html, [
            'title' => (string) ($dynamicData['title'] ?? ''),
        ], [
            'title' => 'video-title',
        ]);
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchSpacerBuilder(string $html, array $dynamicData): string
    {
        $height = preg_replace('/\D+/', '', (string) ($dynamicData['height'] ?? ''));
        if ($height === '') {
            return $html;
        }

        return $this->patchByGjsNames($html, [
            'label' => "Spacer ({$height}px)",
        ], [
            'label' => 'spacer-label',
        ]);
    }

    /**
     * @param  array<string, mixed>  $dynamicData
     */
    public function patchListBuilder(string $html, array $dynamicData): string
    {
        $html = $this->patchByGjsNames($html, [
            'title' => (string) ($dynamicData['title'] ?? ''),
        ], [
            'title' => 'list-title',
        ]);

        $items = $dynamicData['items'] ?? [];
        if (! is_array($items)) {
            return $html;
        }

        $position = 0;
        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $position++;
            if ($position > 12) {
                break;
            }

            $text = trim((string) ($item['text'] ?? ''));
            if ($text === '') {
                continue;
            }

            $html = $this->patchByGjsNames($html, [
                'text' => $text,
            ], [
                'text' => "list-item-{$position}",
            ]);
        }

        return $html;
    }
}
