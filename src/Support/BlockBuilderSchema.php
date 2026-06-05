<?php

namespace LaraGrape\Support;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;

class BlockBuilderSchema
{
    /**
     * Re-render block previews when block content fields change.
     *
     * @param  array<int, Component>  $fields
     * @return array<int, Component>
     */
    protected static function withLive(array $fields): array
    {
        return array_map(function (Component $field): Component {
            if (method_exists($field, 'live')) {
                return $field->live(debounce: 300);
            }

            return $field;
        }, $fields);
    }

    /**
     * Central block capability registry (schema, live patch, dynamic blade, normalizers).
     *
     * @return array<string, array{dynamic_blade: bool, live_patch: bool, schema: ?string, normalizer: ?string}>
     */
    public static function blockRegistry(): array
    {
        return [
            'animated-testimonials' => ['dynamic_blade' => true, 'live_patch' => true, 'schema' => 'testimonialsFields', 'normalizer' => null],
            'animated-faq' => ['dynamic_blade' => true, 'live_patch' => true, 'schema' => 'faqFields', 'normalizer' => null],
            'animated-pricing' => ['dynamic_blade' => true, 'live_patch' => true, 'schema' => 'pricingFields', 'normalizer' => 'pricing'],
            'animated-pricing-clean' => ['dynamic_blade' => true, 'live_patch' => true, 'schema' => 'pricingFields', 'normalizer' => 'pricing'],
            'animated-cards' => ['dynamic_blade' => true, 'live_patch' => true, 'schema' => 'cardsFields', 'normalizer' => null],
            'animated-stats' => ['dynamic_blade' => true, 'live_patch' => true, 'schema' => 'statsFields', 'normalizer' => null],
            'simple-animated-counter' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'simpleCounterFields', 'normalizer' => null],
            'animated-timeline' => ['dynamic_blade' => true, 'live_patch' => true, 'schema' => 'timelineFields', 'normalizer' => null],
            'animated-progress-bars' => ['dynamic_blade' => true, 'live_patch' => true, 'schema' => 'progressBarsFields', 'normalizer' => null],
            'animated-portfolio' => ['dynamic_blade' => true, 'live_patch' => true, 'schema' => 'portfolioFields', 'normalizer' => 'portfolio'],
            'animated-hero' => ['dynamic_blade' => true, 'live_patch' => true, 'schema' => 'animatedHeroFields', 'normalizer' => null],
            'animated-full-image-hero' => ['dynamic_blade' => true, 'live_patch' => true, 'schema' => 'animatedHeroFields', 'normalizer' => null],
            'animated-tech-stack' => ['dynamic_blade' => true, 'live_patch' => true, 'schema' => 'techStackFields', 'normalizer' => null],
            'hero' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'heroFields', 'normalizer' => null],
            'button' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'buttonFields', 'normalizer' => null],
            'text' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'textFields', 'normalizer' => null],
            'heading' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'headingFields', 'normalizer' => null],
            'portfolio-grid' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'portfolioGridFields', 'normalizer' => null],
            'portfolio-teaser' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'portfolioTeaserFields', 'normalizer' => null],
            'service-showcase' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'serviceShowcaseFields', 'normalizer' => null],
            'interactive-pricing' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'pricingFields', 'normalizer' => 'pricing'],
            'technology-stack' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'technologyStackShowcaseFields', 'normalizer' => null],
            'pricing' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'basicPricingFields', 'normalizer' => 'pricing'],
            'card' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'cardFields', 'normalizer' => null],
            'alert' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'alertFields', 'normalizer' => null],
            'testimonial' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'singleTestimonialFields', 'normalizer' => null],
            'image' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'imageFields', 'normalizer' => null],
            'video' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'videoFields', 'normalizer' => null],
            'gallery' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'galleryFields', 'normalizer' => null],
            'icon' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'iconFields', 'normalizer' => null],
            'spacer' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'spacerFields', 'normalizer' => null],
            'divider' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'dividerFields', 'normalizer' => null],
            'list' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'listFields', 'normalizer' => null],
            'quote' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'quoteFields', 'normalizer' => null],
            'section' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'sectionFields', 'normalizer' => null],
            'grid' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'gridFields', 'normalizer' => null],
            'columns' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'columnsFields', 'normalizer' => null],
            'container' => ['dynamic_blade' => false, 'live_patch' => true, 'schema' => 'containerFields', 'normalizer' => null],
        ];
    }

    /**
     * @return array{dynamic_blade: bool, live_patch: bool, schema: ?string, normalizer: ?string}|null
     */
    public static function capability(string $blockId): ?array
    {
        return static::blockRegistry()[$blockId] ?? null;
    }

    /**
     * Block ids that render from structured {@see $dynamicData} in Blade (not static preview).
     *
     * @return list<string>
     */
    public static function dynamicBladeBlocks(): array
    {
        return array_keys(array_filter(
            static::blockRegistry(),
            fn (array $cap): bool => $cap['dynamic_blade'],
        ));
    }

    public static function supportsDynamicData(string $blockId): bool
    {
        $cap = static::capability($blockId);

        return $cap !== null && ($cap['dynamic_blade'] ?? false) === true;
    }

    public static function supportsLivePreviewPatch(string $blockId): bool
    {
        $cap = static::capability($blockId);

        return $cap !== null && ($cap['live_patch'] ?? false) === true;
    }

    /**
     * Ensure Livewire has keys for generic block fields before entangle binds.
     *
     * @return array<string, mixed>
     */
    public static function defaultDynamicData(?string $blockId): array
    {
        if (! filled($blockId)) {
            return [];
        }

        return match ($blockId) {
            'text' => ['body' => ''],
            'hero', 'heading', 'button' => [],
            default => static::usesGenericContentFields($blockId)
                ? ['title' => '', 'body' => '', 'button_text' => '', 'custom_html' => '']
                : [],
        };
    }

    /**
     * Normalize pricing plan data for live Alpine rendering (string features, clean price/period).
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function normalizePricingPlans(array $data): array
    {
        if (! isset($data['plans']) || ! is_array($data['plans'])) {
            return $data;
        }

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

            $price = preg_replace('/[^0-9.]/', '', (string) ($plan['price'] ?? ''));
            $period = ltrim(trim((string) ($plan['period'] ?? 'month')), '/');

            $plans[] = array_merge($plan, [
                'price' => $price !== '' ? $price : (string) ($plan['price'] ?? ''),
                'period' => $period !== '' ? $period : 'month',
                'features' => $features,
            ]);
        }

        $data['plans'] = $plans;

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    /**
     * Flatten Filament repeater items shaped as {text: "..."} into plain strings.
     *
     * @return list<string>
     */
    public static function flattenRepeaterTextItems(mixed $items, string $textKey = 'text'): array
    {
        if (! is_array($items)) {
            return [];
        }

        $out = [];
        foreach ($items as $item) {
            if (is_array($item)) {
                $text = trim((string) ($item[$textKey] ?? ''));
                if ($text !== '') {
                    $out[] = $text;
                }
            } elseif (is_string($item) && trim($item) !== '') {
                $out[] = trim($item);
            }
        }

        return $out;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function normalizeNestedRepeaterShapes(array $data): array
    {
        if (isset($data['plans']) && is_array($data['plans'])) {
            $data['plans'] = array_map(function (mixed $plan): mixed {
                if (! is_array($plan)) {
                    return $plan;
                }
                if (isset($plan['features'])) {
                    $plan['features'] = static::flattenRepeaterTextItems($plan['features']);
                }

                return $plan;
            }, $data['plans']);
        }

        if (isset($data['projects']) && is_array($data['projects'])) {
            $data['projects'] = array_map(function (mixed $project): mixed {
                if (! is_array($project)) {
                    return $project;
                }
                if (isset($project['tags'])) {
                    $project['tags'] = static::flattenRepeaterTextItems($project['tags']);
                }

                return $project;
            }, $data['projects']);
        }

        foreach (['features', 'tags', 'items'] as $listKey) {
            if (isset($data[$listKey]) && is_array($data[$listKey])) {
                $first = reset($data[$listKey]);
                if (is_array($first) && array_key_exists('text', $first)) {
                    $data[$listKey] = static::flattenRepeaterTextItems($data[$listKey]);
                }
            }
        }

        return $data;
    }

    public static function normalizeDynamicDataForLiveRender(string $blockId, array $data): array
    {
        $cap = static::capability($blockId);
        $normalizer = $cap !== null ? ($cap['normalizer'] ?? null) : null;

        if ($normalizer === 'pricing' || in_array($blockId, ['animated-pricing', 'animated-pricing-clean', 'interactive-pricing', 'pricing'], true)) {
            $data = static::normalizePricingPlans($data);
        }

        if ($normalizer === 'portfolio' || $blockId === 'animated-portfolio') {
            $data = static::normalizeNestedRepeaterShapes($data);
        }

        return static::normalizeNestedRepeaterShapes($data);
    }

    public static function usesGenericContentFields(string $blockId): bool
    {
        $cap = static::capability($blockId);

        return $cap === null || $cap['schema'] === null;
    }

    /**
     * @return array<int, Component>
     */
    public static function fieldsFor(?string $blockId): array
    {
        if (! filled($blockId)) {
            return [];
        }

        $cap = static::capability($blockId);
        $schemaMethod = $cap !== null ? ($cap['schema'] ?? null) : null;

        $fields = $schemaMethod !== null && method_exists(static::class, $schemaMethod)
            ? static::{$schemaMethod}()
            : static::genericContentFields();

        return static::withLive($fields);
    }

    /**
     * @return array<int, Component>
     */
    protected static function testimonialsFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Section title')
                ->default('What Our Clients Say')
                ->maxLength(255),
            Repeater::make('testimonials')
                ->label('Testimonials')
                ->schema(static::withLive([
                    Textarea::make('text')
                        ->label('Quote')
                        ->rows(3)
                        ->required(),
                    TextInput::make('name')
                        ->label('Name')
                        ->required(),
                    TextInput::make('title')
                        ->label('Role / company')
                        ->required(),
                ]))
                ->defaultItems(3)
                ->minItems(1)
                ->maxItems(6)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'Testimonial'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function faqFields(): array
    {
        return [
            Repeater::make('faqs')
                ->label('Questions')
                ->schema(static::withLive([
                    TextInput::make('question')
                        ->label('Question')
                        ->required(),
                    Textarea::make('answer')
                        ->label('Answer')
                        ->rows(2)
                        ->required(),
                ]))
                ->defaultItems(4)
                ->minItems(1)
                ->maxItems(8)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['question'] ?? 'FAQ'),
            TextInput::make('ctaButton')
                ->label('CTA button text')
                ->default('Contact Us'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function pricingFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Section title')
                ->default('Choose Your Plan')
                ->maxLength(255),
            Repeater::make('plans')
                ->label('Pricing plans')
                ->live(debounce: 300)
                ->schema([
                    TextInput::make('name')
                        ->label('Plan name')
                        ->required()
                        ->live(debounce: 300),
                    TextInput::make('price')
                        ->label('Price (e.g. 99 or $100)')
                        ->required()
                        ->live(debounce: 300),
                    TextInput::make('period')
                        ->label('Billing period')
                        ->default('month')
                        ->placeholder('month')
                        ->live(debounce: 300),
                    Textarea::make('description')
                        ->label('Description')
                        ->rows(2)
                        ->live(debounce: 300),
                    Repeater::make('features')
                        ->label('Features')
                        ->live(debounce: 300)
                        ->schema([
                            TextInput::make('text')
                                ->label('Feature')
                                ->required()
                                ->live(debounce: 300),
                        ])
                        ->defaultItems(3)
                        ->maxItems(10)
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['text'] ?? 'Feature'),
                ])
                ->default([
                    [
                        'name' => 'Starter',
                        'price' => '99',
                        'period' => 'month',
                        'features' => [
                            ['text' => 'Basic Features'],
                            ['text' => 'Email Support'],
                            ['text' => '5GB Storage'],
                        ],
                    ],
                    [
                        'name' => 'Professional',
                        'price' => '199',
                        'period' => 'month',
                        'features' => [
                            ['text' => 'All Starter Features'],
                            ['text' => 'Priority Support'],
                            ['text' => '25GB Storage'],
                        ],
                    ],
                    [
                        'name' => 'Enterprise',
                        'price' => '399',
                        'period' => 'month',
                        'features' => [
                            ['text' => 'All Professional Features'],
                            ['text' => '24/7 Phone Support'],
                            ['text' => 'Unlimited Storage'],
                        ],
                    ],
                ])
                ->defaultItems(3)
                ->minItems(1)
                ->maxItems(4)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'Plan'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function cardsFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Section title')
                ->default('Our Services')
                ->maxLength(255),
            Repeater::make('cards')
                ->label('Cards')
                ->live(debounce: 300)
                ->schema(static::withLive([
                    TextInput::make('title')
                        ->label('Title')
                        ->required(),
                    Textarea::make('description')
                        ->label('Description')
                        ->rows(2),
                    TextInput::make('icon')
                        ->label('Icon (emoji or text)'),
                ]))
                ->defaultItems(3)
                ->minItems(1)
                ->maxItems(6)
                ->collapsible(),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function statsFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Section title')
                ->default('Our Impact')
                ->maxLength(255),
            TextInput::make('subtitle')
                ->label('Subtitle')
                ->default('Numbers that speak for our success and expertise')
                ->maxLength(500),
            Repeater::make('stats')
                ->label('Statistics')
                ->schema(static::withLive([
                    TextInput::make('value')
                        ->label('Number (e.g. 150 or 99%)')
                        ->required(),
                    TextInput::make('suffix')
                        ->label('Suffix (optional, e.g. + or %)')
                        ->maxLength(8),
                    TextInput::make('label')
                        ->label('Label')
                        ->required(),
                ]))
                ->default([
                    ['value' => '150', 'suffix' => '+', 'label' => 'Projects Completed'],
                    ['value' => '50', 'suffix' => '+', 'label' => 'Happy Clients'],
                    ['value' => '5', 'suffix' => '+', 'label' => 'Years Experience'],
                    ['value' => '99', 'suffix' => '%', 'label' => 'Client Satisfaction'],
                ])
                ->defaultItems(4)
                ->minItems(1)
                ->maxItems(8)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['label'] ?? 'Stat'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function simpleCounterFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Section title')
                ->default('Our Numbers')
                ->maxLength(255),
            Repeater::make('counters')
                ->label('Counters')
                ->schema(static::withLive([
                    TextInput::make('value')
                        ->label('Number (e.g. 150+)')
                        ->required(),
                    TextInput::make('label')
                        ->label('Label')
                        ->required(),
                ]))
                ->default([
                    ['value' => '150+', 'label' => 'Projects Completed'],
                    ['value' => '50+', 'label' => 'Happy Clients'],
                    ['value' => '5+', 'label' => 'Years Experience'],
                ])
                ->defaultItems(3)
                ->minItems(1)
                ->maxItems(6)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['label'] ?? 'Counter'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function animatedHeroFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Headline')
                ->maxLength(500),
            Textarea::make('description')
                ->label('Description')
                ->rows(3),
            TextInput::make('primary_button_text')
                ->label('Primary button'),
            TextInput::make('secondary_button_text')
                ->label('Secondary button'),
            TextInput::make('image_src')
                ->label('Image URL')
                ->url(),
            TextInput::make('image_alt')
                ->label('Image alt text'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function techStackFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Title')
                ->default('Our Tech Stack'),
            TextInput::make('subtitle')
                ->label('Subtitle')
                ->default('Technologies we work with'),
            Repeater::make('items')
                ->label('Technologies')
                ->schema(static::withLive([
                    TextInput::make('key')
                        ->label('Tech key (e.g. laravel)')
                        ->required(),
                    TextInput::make('label')
                        ->label('Label'),
                ]))
                ->defaultItems(3)
                ->minItems(1)
                ->maxItems(12)
                ->collapsible(),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function timelineFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Section title')
                ->default('Our Development Process')
                ->maxLength(255),
            TextInput::make('subtitle')
                ->label('Subtitle')
                ->default('A proven methodology that ensures successful project delivery')
                ->maxLength(255),
            Repeater::make('steps')
                ->label('Timeline steps')
                ->schema(static::withLive([
                    TextInput::make('title')
                        ->label('Step title')
                        ->required(),
                    Textarea::make('description')
                        ->label('Description')
                        ->rows(2)
                        ->required(),
                    TextInput::make('duration')
                        ->label('Duration')
                        ->default('1-2 weeks'),
                ]))
                ->defaultItems(5)
                ->minItems(1)
                ->maxItems(5)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'Step'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function progressBarsFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Section title')
                ->default('Our Skills & Expertise')
                ->maxLength(255),
            Textarea::make('summary')
                ->label('Summary')
                ->rows(2)
                ->default("We're experts in modern web technologies and always learning new skills."),
            TextInput::make('button_text')
                ->label('Button text')
                ->default('View Our Work')
                ->maxLength(255),
            Repeater::make('skills')
                ->label('Skills')
                ->schema(static::withLive([
                    TextInput::make('name')
                        ->label('Skill name')
                        ->required(),
                    TextInput::make('percentage')
                        ->label('Percentage (0–100)')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->required(),
                ]))
                ->defaultItems(4)
                ->minItems(1)
                ->maxItems(4)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'Skill'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function heroFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Title')
                ->default('Hero Title'),
            TextInput::make('subtitle')
                ->label('Subtitle')
                ->default('Add your hero subtitle or description here.'),
            TextInput::make('button_text')
                ->label('Button text')
                ->default('Get Started'),
            TextInput::make('background')
                ->label('Background image URL')
                ->url(),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function buttonFields(): array
    {
        return [
            TextInput::make('label')
                ->label('Button label')
                ->default('Button (edit me)'),
            TextInput::make('tooltip')
                ->label('Tooltip'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function textFields(): array
    {
        return [
            Textarea::make('body')
                ->label('Text')
                ->rows(4)
                ->default('Text block (edit me)'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function headingFields(): array
    {
        return [
            TextInput::make('heading')
                ->label('Heading')
                ->default('Your Heading Here')
                ->maxLength(255),
            Textarea::make('subtitle')
                ->label('Subtitle')
                ->rows(2)
                ->default('Add a subtitle or description for your section here.'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function portfolioGridFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Section title')
                ->default('Portfolio')
                ->maxLength(255),
            TextInput::make('subtitle')
                ->label('Subtitle')
                ->default('All projects')
                ->maxLength(255),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function portfolioTeaserFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Section title')
                ->default('Featured work')
                ->maxLength(255),
            Textarea::make('subtitle')
                ->label('Subtitle')
                ->rows(2)
                ->default('A selection of recent projects'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function portfolioFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Section title')
                ->default('Featured work')
                ->maxLength(255),
            TextInput::make('subtitle')
                ->label('Subtitle')
                ->default('A selection of recent projects')
                ->maxLength(500),
            Repeater::make('projects')
                ->label('Portfolio cards')
                ->schema(static::withLive([
                    TextInput::make('project_id')
                        ->label('Portfolio project ID')
                        ->placeholder('e.g. 1 or project slug'),
                    TextInput::make('title')
                        ->label('Card title (override)'),
                    Textarea::make('description')
                        ->label('Description (override)')
                        ->rows(2),
                    TextInput::make('link')
                        ->label('Link URL')
                        ->url(),
                    Repeater::make('tags')
                        ->label('Tags')
                        ->schema([
                            TextInput::make('text')
                                ->label('Tag')
                                ->required(),
                        ])
                        ->defaultItems(1)
                        ->maxItems(4)
                        ->collapsible(),
                ]))
                ->defaultItems(3)
                ->minItems(1)
                ->maxItems(6)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['title'] ?? $state['project_id'] ?? 'Project'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function serviceShowcaseFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Section title')
                ->default('Our Services')
                ->maxLength(255),
            TextInput::make('subtitle')
                ->label('Subtitle')
                ->default('Comprehensive software development solutions tailored to your needs')
                ->maxLength(500),
            Repeater::make('services')
                ->label('Services')
                ->schema(static::withLive([
                    TextInput::make('title')
                        ->label('Service title')
                        ->required(),
                    Textarea::make('description')
                        ->label('Description')
                        ->rows(2)
                        ->required(),
                    TextInput::make('button')
                        ->label('Button label')
                        ->default('Learn More'),
                ]))
                ->defaultItems(3)
                ->minItems(1)
                ->maxItems(6)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'Service'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function technologyStackShowcaseFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Title')
                ->default('Our Technology Stack')
                ->maxLength(255),
            TextInput::make('subtitle')
                ->label('Subtitle')
                ->default('Cutting-edge technologies we use to build exceptional software solutions')
                ->maxLength(500),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function basicPricingFields(): array
    {
        return static::pricingFields();
    }

    /**
     * @return array<int, Component>
     */
    protected static function cardFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Card title')
                ->default('Card Title')
                ->maxLength(255),
            Textarea::make('body')
                ->label('Description')
                ->rows(3)
                ->default('Card description goes here.'),
            TextInput::make('button_text')
                ->label('Button label')
                ->default('Learn More'),
            TextInput::make('image_src')
                ->label('Image URL')
                ->url(),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function alertFields(): array
    {
        return [
            Textarea::make('body')
                ->label('Alert message')
                ->rows(2)
                ->default('This is an alert message.'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function singleTestimonialFields(): array
    {
        return [
            Textarea::make('body')
                ->label('Quote')
                ->rows(3)
                ->default('This product changed my life!'),
            TextInput::make('title')
                ->label('Author name')
                ->default('Jane Doe'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function imageFields(): array
    {
        return [
            TextInput::make('src')
                ->label('Image URL')
                ->url()
                ->default('https://placehold.co/600x400'),
            TextInput::make('alt')
                ->label('Alt text'),
            TextInput::make('caption')
                ->label('Caption'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function videoFields(): array
    {
        return [
            TextInput::make('src')
                ->label('Video URL')
                ->url(),
            TextInput::make('title')
                ->label('Title'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function galleryFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Gallery title')
                ->maxLength(255),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function iconFields(): array
    {
        return [
            TextInput::make('icon')
                ->label('Icon class or emoji')
                ->default('fa-star'),
            TextInput::make('title')
                ->label('Label'),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function spacerFields(): array
    {
        return [
            TextInput::make('height')
                ->label('Height (px)')
                ->numeric()
                ->default('64')
                ->minValue(8)
                ->maxValue(400),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function dividerFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Optional label')
                ->maxLength(255),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function listFields(): array
    {
        return [
            TextInput::make('title')
                ->label('List title')
                ->maxLength(255),
            Repeater::make('items')
                ->label('Items')
                ->schema([
                    TextInput::make('text')
                        ->label('Item')
                        ->required(),
                ])
                ->defaultItems(3)
                ->maxItems(12)
                ->collapsible(),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function quoteFields(): array
    {
        return [
            Textarea::make('body')
                ->label('Quote')
                ->rows(3),
            TextInput::make('title')
                ->label('Attribution')
                ->maxLength(255),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function sectionFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Section title')
                ->maxLength(255),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function gridFields(): array
    {
        return [
            TextInput::make('columns')
                ->label('Columns')
                ->numeric()
                ->default('3')
                ->minValue(1)
                ->maxValue(6),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function columnsFields(): array
    {
        return [
            TextInput::make('columns')
                ->label('Number of columns')
                ->numeric()
                ->default('2')
                ->minValue(1)
                ->maxValue(4),
        ];
    }

    /**
     * @return array<int, Component>
     */
    protected static function containerFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Container label')
                ->maxLength(255),
        ];
    }

    /**
     * Blocks with dedicated Filament fields + HTML patcher for live admin preview.
     *
     * @return list<string>
     */
    public static function blocksWithLivePreviewPatch(): array
    {
        return array_keys(array_filter(
            static::blockRegistry(),
            fn (array $cap): bool => $cap['live_patch'],
        ));
    }

    /**
     * Default editable fields for blocks without a dedicated schema.
     *
     * @return array<int, Component>
     */
    protected static function genericContentFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Title')
                ->maxLength(255),
            Textarea::make('body')
                ->label('Text / description')
                ->rows(3),
            TextInput::make('button_text')
                ->label('Button label')
                ->maxLength(255),
            Section::make('Advanced')
                ->description('Override the entire block HTML. Leave empty to use the fields above.')
                ->collapsed()
                ->schema([
                    Textarea::make('custom_html')
                        ->label('Custom HTML')
                        ->rows(6),
                ]),
        ];
    }
}
