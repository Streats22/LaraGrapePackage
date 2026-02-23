<?php

namespace LaraGrape\Filament\Resources;

use LaraGrape\Filament\Resources\FooterConfigResource\Pages;
use LaraGrape\Models\FooterConfig;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;

class LaraFooterConfigResource extends Resource
{
    protected static ?string $model = FooterConfig::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = 'Footer Configurations';
    
    protected static ?string $modelLabel = 'Footer Configuration';
    
    protected static ?string $pluralModelLabel = 'Footer Configurations';
    
    protected static string|\UnitEnum|null $navigationGroup = 'Site Design';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('Footer Configuration')
                    ->tabs([
                        Tabs\Tab::make('Basic Information')
                            ->schema([
                                Section::make('Footer Details')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('display_name')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->label('Display Name')
                                                    ->helperText('A friendly name for this footer configuration'),
                                                
                                                TextInput::make('name')
                                                    ->maxLength(255)
                                                    ->label('Slug')
                                                    ->helperText('Auto-generated from display name')
                                                    ->disabled(),
                                            ]),
                                        
                                        Textarea::make('description')
                                            ->maxLength(500)
                                            ->label('Description')
                                            ->helperText('Optional description of this footer configuration'),
                                        
                                        Section::make('Layout Presets')
                                            ->description('Quick setup with predefined layouts')
                                            ->schema([
                                                Select::make('layout_preset')
                                                    ->label('Choose Preset')
                                                    ->options([
                                                        'modern-footer' => 'Modern Footer - Comprehensive with multiple sections and social links',
                                                        'minimal-footer' => 'Minimal Footer - Simple, clean footer with essential links',
                                                        'centered-footer' => 'Centered Footer - Centered layout with logo and social links',
                                                        'split-footer' => 'Split Footer - Split layout with company info and links',
                                                    ])
                                                    ->placeholder('Select a preset to apply...')
                                                    ->helperText('Select a preset to automatically configure this footer')
                                                    ->live()
                                                    ->afterStateUpdated(function ($state, callable $set) {
                                                        if ($state) {
                                                            $preset = FooterConfig::where('name', $state)->first();
                                                            if ($preset) {
                                                                $set('layout', $preset->layout);
                                                                $set('show_newsletter', $preset->show_newsletter);
                                                                $set('newsletter_title', $preset->newsletter_title);
                                                                $set('newsletter_description', $preset->newsletter_description);
                                                                $set('show_social_links', $preset->show_social_links);
                                                                $set('show_contact_info', $preset->show_contact_info);
                                                                $set('show_quick_links', $preset->show_quick_links);
                                                                $set('logo_text', $preset->logo_text);
                                                                $set('logo_size', $preset->logo_size);
                                                                $set('background_color', $preset->background_color);
                                                                $set('text_color', $preset->text_color);
                                                                $set('accent_color', $preset->accent_color);
                                                                $set('border_color', $preset->border_color);
                                                                $set('border_width', $preset->border_width);
                                                                $set('shadow', $preset->shadow);
                                                                $set('font_family', $preset->font_family);
                                                                $set('font_weight', $preset->font_weight);
                                                                $set('font_size', $preset->font_size);
                                                                $set('padding_y', $preset->padding_y);
                                                                $set('padding_x', $preset->padding_x);
                                                                $set('section_spacing', $preset->section_spacing);
                                                                $set('grid_columns_desktop', $preset->grid_columns_desktop);
                                                                $set('grid_columns_tablet', $preset->grid_columns_tablet);
                                                                $set('grid_columns_mobile', $preset->grid_columns_mobile);
                                                                $set('dark_mode_enabled', $preset->dark_mode_enabled);
                                                                $set('dark_mode_style', $preset->dark_mode_style);
                                                                $set('dark_background_color', $preset->dark_background_color);
                                                                $set('dark_text_color', $preset->dark_text_color);
                                                                $set('dark_accent_color', $preset->dark_accent_color);
                                                                $set('dark_border_color', $preset->dark_border_color);
                                                            }
                                                        }
                                                    }),
                                            ])
                                            ->collapsed(),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Layout Configuration')
                            ->schema([
                                Section::make('Layout Settings')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('layout')
                                                    ->options(FooterConfig::getLayouts())
                    ->required()
                                                    ->default('standard')
                                                    ->label('Layout Style')
                                                    ->helperText('Choose the layout style for the footer'),
                                                
                                                TextInput::make('grid_columns_desktop')
                                                    ->numeric()
                                                    ->default(4)
                                                    ->minValue(1)
                                                    ->maxValue(6)
                                                    ->label('Desktop Columns')
                                                    ->helperText('Number of columns on desktop screens'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('grid_columns_tablet')
                                                    ->numeric()
                                                    ->default(2)
                                                    ->minValue(1)
                                                    ->maxValue(4)
                                                    ->label('Tablet Columns')
                                                    ->helperText('Number of columns on tablet screens'),
                                                
                                                TextInput::make('grid_columns_mobile')
                                                    ->numeric()
                                                    ->default(1)
                                                    ->minValue(1)
                                                    ->maxValue(2)
                                                    ->label('Mobile Columns')
                                                    ->helperText('Number of columns on mobile screens'),
                                            ]),
                                        
                                        KeyValue::make('layout_config')
                                            ->label('Layout Configuration')
                                            ->helperText('Additional settings for the selected layout')
                                            ->keyLabel('Setting')
                                            ->valueLabel('Value')
                                            ->addActionLabel('Add Setting'),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Content Sections')
                            ->schema([
                                Section::make('Section Visibility')
                                    ->description('Control which sections appear in your footer')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('show_brand_section')
                                                    ->default(true)
                                                    ->label('Brand Section')
                                                    ->helperText('Show logo and brand description'),
                                                
                                                Toggle::make('show_quick_links')
                                                    ->default(true)
                                                    ->label('Quick Links')
                                                    ->helperText('Show quick navigation links'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('show_social_links')
                                                    ->default(true)
                                                    ->label('Social Links')
                                                    ->helperText('Show social media links'),
                                                
                                                Toggle::make('show_newsletter')
                                                    ->default(false)
                                                    ->label('Newsletter')
                                                    ->helperText('Show newsletter subscription form'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('show_contact_info')
                                                    ->default(true)
                                                    ->label('Contact Info')
                                                    ->helperText('Show contact information'),
                                                
                                                Toggle::make('show_copyright')
                                                    ->default(true)
                                                    ->label('Copyright')
                                                    ->helperText('Show copyright notice'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('show_powered_by')
                                                    ->default(false)
                                                    ->label('Powered By')
                                                    ->helperText('Show "Powered by" text'),
                                            ]),
                                    ]),
                                
                                Section::make('Global Positioning')
                                    ->description('Position elements globally across all layouts')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('brand_position')
                                                    ->options(FooterConfig::getPositionOptions())
                                                    ->default('left')
                                                    ->label('Brand Position')
                                                    ->helperText('Where to position the brand/logo section'),
                                                
                                                Select::make('social_position')
                                                    ->options(FooterConfig::getPositionOptions())
                                                    ->default('right')
                                                    ->label('Social Links Position')
                                                    ->helperText('Where to position social media links'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('menu_position')
                                                    ->options(FooterConfig::getPositionOptions())
                                                    ->default('center')
                                                    ->label('Menu Position')
                                                    ->helperText('Where to position navigation menu items'),
                                                
                                                Select::make('copyright_position')
                                                    ->options(FooterConfig::getPositionOptions())
                                                    ->default('bottom')
                                                    ->label('Copyright Position')
                                                    ->helperText('Where to position copyright notice'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('newsletter_position')
                                                    ->options(FooterConfig::getPositionOptions())
                                                    ->default('center')
                                                    ->label('Newsletter Position')
                                                    ->helperText('Where to position newsletter form'),
                                                
                                                Select::make('contact_position')
                                                    ->options(FooterConfig::getPositionOptions())
                                                    ->default('right')
                                                    ->label('Contact Position')
                                                    ->helperText('Where to position contact information'),
                                            ]),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Brand & Logo')
                            ->schema([
                                Section::make('Brand Configuration')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('logo_text')
                                                    ->maxLength(255)
                                                    ->label('Logo Text')
                                                    ->helperText('Text to display if no logo image is set'),
                                                
                                                FileUpload::make('logo_image')
                                                    ->image()
                                                    ->directory('footers/logos')
                                                    ->label('Logo Image')
                                                    ->helperText('Upload your logo image'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('logo_position')
                                                    ->options([
                                                        'left' => 'Left',
                                                        'center' => 'Center',
                                                        'right' => 'Right',
                                                    ])
                                                    ->default('left')
                                                    ->label('Logo Position'),
                                                
                                                TextInput::make('logo_size')
                                                    ->numeric()
                                                    ->default(32)
                                                    ->minValue(16)
                                                    ->maxValue(128)
                                                    ->label('Logo Size (px)')
                                                    ->helperText('Height in pixels'),
                                            ]),
                                        
                                        Textarea::make('brand_description')
                                            ->maxLength(500)
                                            ->label('Brand Description')
                                            ->helperText('Description text displayed in the brand section')
                                            ->rows(3),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Quick Links')
                            ->schema([
                                Section::make('Quick Links Configuration')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('quick_links_title')
                                                    ->default('Quick Links')
                                                    ->maxLength(255)
                                                    ->label('Section Title'),
                                                
                                                TextInput::make('quick_links_columns')
                    ->numeric()
                                                    ->default(3)
                                                    ->minValue(1)
                                                    ->maxValue(6)
                                                    ->label('Link Columns')
                                                    ->helperText('Number of columns for quick links'),
                                            ]),
                                        
                                        Repeater::make('quick_links')
                                            ->schema([
                                                TextInput::make('text')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->label('Link Text'),
                                                
                                                TextInput::make('url')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->label('Link URL')
                                                    ->helperText('Full URL including https://'),
                                                
                                                Toggle::make('open_in_new_tab')
                                                    ->default(false)
                                                    ->label('Open in New Tab'),
                                            ])
                                            ->label('Quick Links')
                                            ->helperText('Add quick navigation links')
                                            ->addActionLabel('Add Link')
                                            ->reorderable()
                                            ->collapsible(),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Social Links')
                            ->schema([
                                Section::make('Social Media Configuration')
                                    ->schema([
                                        TextInput::make('social_links_title')
                                            ->default('Follow Us')
                                            ->maxLength(255)
                                            ->label('Section Title'),
                                        
                                        Repeater::make('social_links')
                                            ->schema([
                                                Select::make('platform')
                                                    ->options([
                                                        'facebook' => 'Facebook',
                                                        'twitter' => 'Twitter',
                                                        'instagram' => 'Instagram',
                                                        'linkedin' => 'LinkedIn',
                                                        'youtube' => 'YouTube',
                                                        'tiktok' => 'TikTok',
                                                        'github' => 'GitHub',
                                                        'discord' => 'Discord',
                                                        'custom' => 'Custom',
                                                    ])
                                                    ->required()
                                                    ->label('Platform'),
                                                
                                                TextInput::make('url')
                    ->required()
                                                    ->maxLength(255)
                                                    ->label('Profile URL')
                                                    ->helperText('Full URL to your social media profile'),
                                                
                                                TextInput::make('icon')
                                                    ->maxLength(255)
                                                    ->label('Custom Icon')
                                                    ->helperText('FontAwesome icon class (e.g., fab fa-facebook)')
                                                    ->visible(fn ($get) => $get('platform') === 'custom'),
                                            ])
                                            ->label('Social Links')
                                            ->helperText('Add your social media profiles')
                                            ->addActionLabel('Add Social Link')
                                            ->reorderable()
                                            ->collapsible(),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Newsletter')
                            ->schema([
                                Section::make('Newsletter Configuration')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('newsletter_title')
                                                    ->default('Subscribe to our newsletter')
                                                    ->maxLength(255)
                                                    ->label('Title'),
                                                
                                                TextInput::make('newsletter_placeholder')
                                                    ->default('Enter your email')
                                                    ->maxLength(255)
                                                    ->label('Input Placeholder'),
                                            ]),
                                        
                                        Textarea::make('newsletter_description')
                                            ->maxLength(500)
                                            ->label('Description')
                                            ->helperText('Description text for the newsletter section')
                                            ->rows(3),
                                        
                                        TextInput::make('newsletter_button_text')
                                            ->default('Subscribe')
                                            ->maxLength(255)
                                            ->label('Button Text'),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Contact Information')
                            ->schema([
                                Section::make('Contact Details')
                                    ->schema([
                                        TextInput::make('contact_title')
                                            ->default('Contact Info')
                                            ->maxLength(255)
                                            ->label('Section Title'),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('contact_phone')
                                                    ->maxLength(255)
                                                    ->label('Phone Number')
                                                    ->helperText('Include country code if needed'),
                                                
                                                TextInput::make('contact_email')
                                                    ->email()
                                                    ->maxLength(255)
                                                    ->label('Email Address'),
                                            ]),
                                        
                                        Textarea::make('contact_address')
                                            ->maxLength(500)
                                            ->label('Address')
                                            ->helperText('Full address or location information')
                                            ->rows(3),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Copyright')
                            ->schema([
                                Section::make('Copyright Configuration')
                                    ->schema([
                                        TextInput::make('copyright_text')
                                            ->default('© 2024 All rights reserved.')
                                            ->maxLength(255)
                                            ->label('Copyright Text')
                                            ->helperText('Copyright notice text'),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('show_powered_by')
                                                    ->default(false)
                                                    ->label('Show Powered By')
                                                    ->helperText('Show "Powered by" text'),
                                                
                                                TextInput::make('powered_by_text')
                                                    ->maxLength(255)
                                                    ->label('Powered By Text')
                                                    ->helperText('Custom "Powered by" text')
                                                    ->visible(fn ($get) => $get('show_powered_by')),
                                            ]),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Styling & Colors')
                            ->schema([
                                Section::make('Light Mode Colors')
                                    ->schema([
                                        ColorPicker::make('background_color')
                                            ->label('Background Color')
                                            ->default('#1f2937')
                    ->required(),

                                        ColorPicker::make('text_color')
                                            ->label('Text Color')
                                            ->default('#f9fafb')
                    ->required(),

                                        ColorPicker::make('accent_color')
                                            ->label('Accent Color')
                                            ->default('#3b82f6')
                    ->required(),

                                        ColorPicker::make('border_color')
                                            ->label('Border Color')
                                            ->default('#374151')
                    ->required(),
                                    ])
                                    ->columns(2),

                                Section::make('Dark Mode Colors')
                                    ->schema([
                                        Toggle::make('dark_mode_enabled')
                                            ->label('Enable Dark Mode')
                                            ->default(true)
                                            ->helperText('Enable dark mode styling for this footer'),

                                        Select::make('dark_mode_style')
                                            ->label('Dark Mode Style')
                                            ->options(\App\Models\FooterConfig::getDarkModeStyles())
                                            ->default('auto')
                                            ->helperText('How dark mode should be applied'),

                                        ColorPicker::make('dark_background_color')
                                            ->label('Dark Background Color')
                                            ->default('#111827')
                                            ->visible(fn ($get) => $get('dark_mode_enabled')),

                                        ColorPicker::make('dark_text_color')
                                            ->label('Dark Text Color')
                                            ->default('#f3f4f6')
                                            ->visible(fn ($get) => $get('dark_mode_enabled')),

                                        ColorPicker::make('dark_accent_color')
                                            ->label('Dark Accent Color')
                                            ->default('#60a5fa')
                                            ->visible(fn ($get) => $get('dark_mode_enabled')),

                                        ColorPicker::make('dark_border_color')
                                            ->label('Dark Border Color')
                                            ->default('#1f2937')
                                            ->visible(fn ($get) => $get('dark_mode_enabled')),
                                    ])
                                    ->columns(2),

                                Section::make('Typography & Spacing')
                                    ->schema([
                                        Select::make('font_family')
                                            ->label('Font Family')
                                            ->options([
                                                'Inter' => 'Inter',
                                                'Arial' => 'Arial',
                                                'Helvetica' => 'Helvetica',
                                                'Georgia' => 'Georgia',
                                                'Times New Roman' => 'Times New Roman',
                                                'Roboto' => 'Roboto',
                                                'Open Sans' => 'Open Sans',
                                                'Lato' => 'Lato',
                                            ])
                                            ->default('Inter')
                    ->required(),

                                        Select::make('font_weight')
                                            ->label('Font Weight')
                                            ->options([
                                                '300' => 'Light (300)',
                                                '400' => 'Normal (400)',
                                                '500' => 'Medium (500)',
                                                '600' => 'Semi Bold (600)',
                                                '700' => 'Bold (700)',
                                            ])
                                            ->default('400')
                    ->required(),

                                        TextInput::make('font_size')
                                            ->label('Font Size (px)')
                                            ->numeric()
                                            ->default(14)
                                            ->minValue(10)
                                            ->maxValue(24)
                    ->required(),

                                        TextInput::make('padding_y')
                                            ->label('Vertical Padding (px)')
                                            ->numeric()
                                            ->default(64)
                                            ->minValue(16)
                                            ->maxValue(128)
                    ->required(),

                                        TextInput::make('padding_x')
                                            ->label('Horizontal Padding (px)')
                                            ->numeric()
                                            ->default(24)
                                            ->minValue(8)
                                            ->maxValue(64)
                    ->required(),

                                        TextInput::make('section_spacing')
                                            ->label('Section Spacing (px)')
                                            ->numeric()
                                            ->default(32)
                                            ->minValue(16)
                                            ->maxValue(64)
                    ->required(),

                                        TextInput::make('border_width')
                                            ->label('Border Width (px)')
                    ->numeric()
                                            ->default(1)
                                            ->minValue(0)
                                            ->maxValue(8)
                    ->required(),

                                        Select::make('shadow')
                                            ->label('Shadow')
                                            ->options([
                                                'none' => 'None',
                                                'sm' => 'Small',
                                                'md' => 'Medium',
                                                'lg' => 'Large',
                                                'xl' => 'Extra Large',
                                            ])
                                            ->default('sm')
                    ->required(),
                                    ])
                                    ->columns(3),
                            ]),
                        
                        Tabs\Tab::make('Advanced')
                            ->schema([
                                Section::make('Custom CSS')
                                    ->schema([
                                        Textarea::make('custom_css')
                                            ->label('Custom CSS')
                                            ->helperText('Add custom CSS styles for this footer')
                                            ->rows(10)
                                            ->placeholder('.footer-config-custom { /* Your custom styles */ }'),
                                    ]),
                                
                                Section::make('Status')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('is_active')
                                                    ->default(false)
                                                    ->label('Active')
                                                    ->helperText('Make this the active footer configuration'),
                                                
                                                Toggle::make('is_default')
                                                    ->default(false)
                                                    ->label('Default')
                                                    ->helperText('Set as default configuration'),
                                            ]),
                                        
                                        TextInput::make('sort_order')
                    ->numeric()
                                            ->default(0)
                                            ->label('Sort Order')
                                            ->helperText('Order in which configurations appear'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('display_name')
                    ->searchable()
                    ->sortable()
                    ->label('Name'),
                
                TextColumn::make('layout')
                    ->badge()
                    ->colors([
                        'primary' => 'standard',
                        'success' => 'centered',
                        'warning' => 'minimal',
                        'info' => 'extended',
                        'secondary' => 'split',
                    ])
                    ->label('Layout'),
                
                IconColumn::make('show_brand_section')
                    ->boolean()
                    ->label('Brand'),
                
                IconColumn::make('show_social_links')
                    ->boolean()
                    ->label('Social'),
                
                IconColumn::make('show_newsletter')
                    ->boolean()
                    ->label('Newsletter'),
                
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                
                IconColumn::make('is_default')
                    ->boolean()
                    ->label('Default'),
                
                TextColumn::make('sort_order')
                    ->sortable()
                    ->label('Order'),
                
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Last Updated'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('layout')
                    ->options(FooterConfig::getLayouts())
                    ->label('Layout'),
                
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
                
                Tables\Filters\TernaryFilter::make('show_newsletter')
                    ->label('Newsletter'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
                Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->url(fn (FooterConfig $record) => route('home') . '?footer_preview=' . $record->id)
                    ->openUrlInNewTab(),
                Action::make('activate')
                    ->label('Activate')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn (FooterConfig $record) => static::activateFooter($record))
                    ->visible(fn (FooterConfig $record) => !$record->is_active)
                    ->color('success'),
                Action::make('clear_cache')
                    ->label('Clear Cache')
                    ->icon('heroicon-o-arrow-path')
                    ->action(fn () => Artisan::call('layout:clear-cache'))
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Clear Layout Cache')
                    ->modalDescription('This will clear all layout-related caches. This action cannot be undone.')
                    ->modalSubmitActionLabel('Clear Cache'),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                    BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn (Collection $records) => $records->each(fn ($record) => static::activateFooter($record)))
                        ->color('success'),
                ]),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\LaraListFooterConfigs::route('/'),
            'create' => Pages\LaraCreateFooterConfig::route('/create'),
            'edit' => Pages\LaraEditFooterConfig::route('/{record}/edit'),
        ];
    }

    /**
     * Activate a footer configuration
     */
    public static function activateFooter(FooterConfig $footer): void
    {
        // Deactivate all other footers
        FooterConfig::where('is_active', true)->update(['is_active' => false]);
        
        // Activate the selected footer
        $footer->update(['is_active' => true]);
    }
}
