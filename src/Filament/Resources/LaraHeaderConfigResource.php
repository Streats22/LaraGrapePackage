<?php

namespace LaraGrape\Filament\Resources;

use LaraGrape\Filament\Resources\HeaderConfigResource\Pages;
use LaraGrape\Models\HeaderConfig;
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
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Actions\Action as FormAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;

class LaraHeaderConfigResource extends Resource
{
    protected static ?string $model = HeaderConfig::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = 'Header Configurations';
    
    protected static ?string $modelLabel = 'Header Configuration';
    
    protected static ?string $pluralModelLabel = 'Header Configurations';
    
    protected static string|\UnitEnum|null $navigationGroup = 'Site Design';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('Header Configuration')
                    ->tabs([
                        Tabs\Tab::make('Basic Information')
                            ->schema([
                                Section::make('Header Details')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('display_name')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->label('Display Name')
                                                    ->helperText('A friendly name for this header configuration'),
                                                
                                                TextInput::make('name')
                                                    ->maxLength(255)
                                                    ->label('Slug')
                                                    ->helperText('Auto-generated from display name')
                                                    ->disabled(),
                                            ]),
                                        
                                        Textarea::make('description')
                                            ->maxLength(500)
                                            ->label('Description')
                                            ->helperText('Optional description of this header configuration'),
                                        
                                        Section::make('Layout Presets')
                                            ->description('Quick setup with predefined layouts')
                                            ->schema([
                                                Select::make('layout_preset')
                                                    ->label('Choose Preset')
                                                    ->options([
                                                        'modern-header' => 'Modern Header - Clean, centered layout with search and CTA',
                                                        'minimal-header' => 'Minimal Header - Simple, clean typography',
                                                        'dark-header' => 'Dark Header - Dark theme with bold styling',
                                                        'split-header' => 'Split Header - Logo left, navigation right',
                                                    ])
                                                    ->placeholder('Select a preset to apply...')
                                                    ->helperText('Select a preset to automatically configure this header')
                                                    ->live()
                                                    ->afterStateUpdated(function ($state, callable $set) {
                                                        if ($state) {
                                                            $preset = HeaderConfig::where('name', $state)->first();
                                                            if ($preset) {
                                                                $set('layout', $preset->layout);
                                                                $set('menu_type', $preset->menu_type);
                                                                $set('is_sticky', $preset->is_sticky);
                                                                $set('is_transparent', $preset->is_transparent);
                                                                $set('show_search', $preset->show_search);
                                                                $set('show_cta_button', $preset->show_cta_button);
                                                                $set('cta_text', $preset->cta_text);
                                                                $set('cta_url', $preset->cta_url);
                                                                $set('logo_text', $preset->logo_text);
                                                                $set('logo_position', $preset->logo_position);
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
                                                                $set('menu_spacing', $preset->menu_spacing);
                                                                $set('mobile_menu_enabled', $preset->mobile_menu_enabled);
                                                                $set('mobile_menu_style', $preset->mobile_menu_style);
                                                                $set('mobile_breakpoint', $preset->mobile_breakpoint);
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
                        
                        Tabs\Tab::make('Menu Configuration')
                            ->schema([
                                Section::make('Menu Settings')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('menu_type')
                                                    ->options(HeaderConfig::getMenuTypes())
                                                    ->required()
                                                    ->default('normal')
                                                    ->label('Menu Type')
                                                    ->helperText('Choose the type of menu to display'),
                                                
                                                Select::make('layout')
                                                    ->options(HeaderConfig::getLayouts())
                                                    ->required()
                                                    ->default('standard')
                                                    ->label('Layout Style')
                                                    ->helperText('Choose the layout style for the header'),
                                            ]),
                                        
                                        KeyValue::make('menu_config')
                                            ->label('Menu Configuration')
                                            ->helperText('Additional settings for the selected menu type')
                                            ->keyLabel('Setting')
                                            ->valueLabel('Value')
                                            ->addActionLabel('Add Setting'),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Logo & Branding')
                            ->schema([
                                Section::make('Logo Configuration')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('logo_text')
                                                    ->maxLength(255)
                                                    ->label('Logo Text')
                                                    ->helperText('Text to display if no logo image is set'),
                                                
                                                FileUpload::make('logo_image')
                                                    ->image()
                                                    ->directory('headers/logos')
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
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Styling & Colors')
                            ->schema([
                                Section::make('Light Mode Colors')
                                    ->schema([
                                        ColorPicker::make('background_color')
                                            ->label('Background Color')
                                            ->default('#ffffff')
                    ->required(),

                                        ColorPicker::make('text_color')
                                            ->label('Text Color')
                                            ->default('#1f2937')
                    ->required(),

                                        ColorPicker::make('accent_color')
                                            ->label('Accent Color')
                                            ->default('#3b82f6')
                    ->required(),

                                        ColorPicker::make('border_color')
                                            ->label('Border Color')
                                            ->default('#e5e7eb')
                    ->required(),
                                    ])
                                    ->columns(2),

                                Section::make('Dark Mode Colors')
                                    ->schema([
                                        Toggle::make('dark_mode_enabled')
                                            ->label('Enable Dark Mode')
                                            ->default(true)
                                            ->helperText('Enable dark mode styling for this header'),

                                        Select::make('dark_mode_style')
                                            ->label('Dark Mode Style')
                                            ->options(\LaraGrape\Models\HeaderConfig::getDarkModeStyles())
                                            ->default('auto')
                                            ->helperText('How dark mode should be applied'),

                                        ColorPicker::make('dark_background_color')
                                            ->label('Dark Background Color')
                                            ->default('#1f2937')
                                            ->visible(fn ($get) => $get('dark_mode_enabled')),

                                        ColorPicker::make('dark_text_color')
                                            ->label('Dark Text Color')
                                            ->default('#f9fafb')
                                            ->visible(fn ($get) => $get('dark_mode_enabled')),

                                        ColorPicker::make('dark_accent_color')
                                            ->label('Dark Accent Color')
                                            ->default('#60a5fa')
                                            ->visible(fn ($get) => $get('dark_mode_enabled')),

                                        ColorPicker::make('dark_border_color')
                                            ->label('Dark Border Color')
                                            ->default('#374151')
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
                                            ->default('500')
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
                                            ->default(16)
                                            ->minValue(8)
                                            ->maxValue(64)
                    ->required(),

                                        TextInput::make('padding_x')
                                            ->label('Horizontal Padding (px)')
                                            ->numeric()
                                            ->default(24)
                                            ->minValue(8)
                                            ->maxValue(64)
                    ->required(),

                                        TextInput::make('menu_spacing')
                                            ->label('Menu Spacing (px)')
                    ->numeric()
                                            ->default(16)
                                            ->minValue(8)
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
                        
                        Tabs\Tab::make('Layout Options')
                            ->schema([
                                Section::make('Header Behavior')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('is_sticky')
                                                    ->default(true)
                                                    ->label('Sticky Header')
                                                    ->helperText('Header stays at top when scrolling'),
                                                
                                                Toggle::make('is_transparent')
                                                    ->default(false)
                                                    ->label('Transparent Background')
                                                    ->helperText('Makes header background transparent'),
                                            ]),
                                    ]),
                                
                                Section::make('Additional Elements')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('show_search')
                                                    ->default(false)
                                                    ->label('Show Search')
                                                    ->helperText('Display search functionality in header'),
                                                
                                                Toggle::make('show_cta_button')
                                                    ->default(false)
                                                    ->label('Show CTA Button')
                                                    ->helperText('Display a call-to-action button'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('cta_text')
                                                    ->maxLength(255)
                                                    ->label('CTA Button Text')
                                                    ->helperText('Text for the call-to-action button')
                                                    ->visible(fn ($get) => $get('show_cta_button')),
                                                
                                                TextInput::make('cta_url')
                                                    ->maxLength(255)
                                                    ->label('CTA Button URL')
                                                    ->helperText('URL for the call-to-action button')
                                                    ->visible(fn ($get) => $get('show_cta_button')),
                                            ]),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Mobile & Responsive')
                            ->schema([
                                Section::make('Mobile Menu')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('mobile_menu_enabled')
                                                    ->default(true)
                                                    ->label('Enable Mobile Menu')
                                                    ->helperText('Show mobile menu on smaller screens'),
                                                
                                                Select::make('mobile_menu_style')
                                                    ->options(HeaderConfig::getMobileMenuStyles())
                                                    ->default('hamburger')
                                                    ->label('Mobile Menu Style')
                                                    ->visible(fn ($get) => $get('mobile_menu_enabled')),
                                            ]),
                                        
                                        Select::make('mobile_breakpoint')
                                            ->options(HeaderConfig::getBreakpoints())
                                            ->default('md')
                                            ->label('Mobile Breakpoint')
                                            ->helperText('Screen size at which mobile menu activates'),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Advanced')
                            ->schema([
                                Section::make('Custom CSS')
                                    ->schema([
                                        Textarea::make('custom_css')
                                            ->label('Custom CSS')
                                            ->helperText('Add custom CSS styles for this header')
                                            ->rows(10)
                                            ->placeholder('.header-config-custom { /* Your custom styles */ }'),
                                    ]),
                                
                                Section::make('Status')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('is_active')
                                                    ->default(false)
                                                    ->label('Active')
                                                    ->helperText('Make this the active header configuration'),
                                                
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
                
                TextColumn::make('menu_type')
                    ->badge()
                    ->colors([
                        'primary' => 'normal',
                        'success' => 'mega',
                        'warning' => 'dropdown',
                        'info' => 'centered',
                        'secondary' => 'minimal',
                    ])
                    ->label('Menu Type'),
                
                TextColumn::make('layout')
                    ->badge()
                    ->colors([
                        'primary' => 'standard',
                        'success' => 'centered',
                        'warning' => 'split',
                        'info' => 'minimal',
                    ])
                    ->label('Layout'),
                
                IconColumn::make('is_sticky')
                    ->boolean()
                    ->label('Sticky'),
                
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
                Tables\Filters\SelectFilter::make('menu_type')
                    ->options(HeaderConfig::getMenuTypes())
                    ->label('Menu Type'),
                
                Tables\Filters\SelectFilter::make('layout')
                    ->options(HeaderConfig::getLayouts())
                    ->label('Layout'),
                
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
                
                Tables\Filters\TernaryFilter::make('is_sticky')
                    ->label('Sticky'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
                Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->url(fn (HeaderConfig $record) => route('home') . '?header_preview=' . $record->id)
                    ->openUrlInNewTab(),
                Action::make('activate')
                    ->label('Activate')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn (HeaderConfig $record) => static::activateHeader($record))
                    ->visible(fn (HeaderConfig $record) => !$record->is_active)
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
                        ->action(fn (Collection $records) => $records->each(fn ($record) => static::activateHeader($record)))
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
            'index' => Pages\LaraListHeaderConfigs::route('/'),
            'create' => Pages\LaraCreateHeaderConfig::route('/create'),
            'edit' => Pages\LaraEditHeaderConfig::route('/{record}/edit'),
        ];
    }

    /**
     * Activate a header configuration
     */
    public static function activateHeader(HeaderConfig $header): void
    {
        // Deactivate all other headers
        HeaderConfig::where('is_active', true)->update(['is_active' => false]);
        
        // Activate the selected header
        $header->update(['is_active' => true]);
    }
}
