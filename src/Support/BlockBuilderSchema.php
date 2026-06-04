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
     * Block ids that render from structured {@see $dynamicData} in Blade (not static preview).
     *
     * @return list<string>
     */
    public static function dynamicBladeBlocks(): array
    {
        return [
            'animated-testimonials',
            'animated-faq',
            'animated-pricing',
            'animated-pricing-clean',
            'animated-timeline',
            'animated-cards',
            'animated-stats',
            'animated-progress-bars',
            'animated-portfolio',
            'animated-hero',
            'animated-full-image-hero',
            'animated-tech-stack',
        ];
    }

    public static function supportsDynamicData(string $blockId): bool
    {
        return in_array($blockId, static::dynamicBladeBlocks(), true);
    }

    /**
     * @return array<int, Component>
     */
    public static function fieldsFor(?string $blockId): array
    {
        if (! filled($blockId)) {
            return [];
        }

        $fields = match ($blockId) {
            'animated-testimonials' => static::testimonialsFields(),
            'animated-faq' => static::faqFields(),
            'animated-pricing', 'animated-pricing-clean' => static::pricingFields(),
            'animated-cards' => static::cardsFields(),
            'animated-stats' => static::statsFields(),
            'simple-animated-counter' => static::simpleCounterFields(),
            'animated-hero', 'animated-full-image-hero' => static::animatedHeroFields(),
            'animated-tech-stack' => static::techStackFields(),
            'hero' => static::heroFields(),
            'button' => static::buttonFields(),
            'text' => static::textFields(),
            'heading' => static::headingFields(),
            'portfolio-grid' => static::portfolioGridFields(),
            'portfolio-teaser' => static::portfolioTeaserFields(),
            default => static::genericContentFields(),
        };

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
            Repeater::make('plans')
                ->label('Pricing plans')
                ->schema(static::withLive([
                    TextInput::make('name')
                        ->label('Plan name')
                        ->required(),
                    TextInput::make('price')
                        ->label('Price')
                        ->required(),
                    Textarea::make('description')
                        ->label('Description')
                        ->rows(2),
                    Repeater::make('features')
                        ->label('Features')
                        ->schema(static::withLive([
                            TextInput::make('text')
                                ->label('Feature')
                                ->required(),
                        ]))
                        ->defaultItems(3)
                        ->maxItems(10),
                ]))
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
            Repeater::make('cards')
                ->label('Cards')
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
                ->rows(2),
        ];
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
