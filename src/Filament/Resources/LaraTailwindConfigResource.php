<?php

namespace LaraGrape\Filament\Resources;

use LaraGrape\Filament\Resources\TailwindConfigResource\Pages;
use LaraGrape\Models\TailwindConfig;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\KeyValue;

class LaraTailwindConfigResource extends Resource
{
    protected static ?string $model = TailwindConfig::class;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    
    protected static ?string $navigationLabel = 'Tailwind Config';
    
    protected static ?string $modelLabel = 'Tailwind Configuration';
    
    protected static ?string $pluralModelLabel = 'Tailwind Configurations';
    
    protected static ?string $navigationGroup = 'Design System';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tailwind Configuration')
                    ->tabs([
                        Tabs\Tab::make('Basic Info')
                            ->schema([
                                Section::make('Configuration Details')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('name')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->placeholder('e.g., Default Theme, Purple Theme')
                                                    ->helperText('A descriptive name for this configuration'),
                                                
                                                Forms\Components\Toggle::make('is_active')
                                                    ->label('Active Configuration')
                                                    ->helperText('Only one configuration can be active at a time')
                                                    ->default(false),
                                            ]),
                                        
                                        Forms\Components\Textarea::make('description')
                                            ->rows(3)
                                            ->placeholder('Describe this configuration...')
                                            ->helperText('Optional description of this theme configuration'),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Colors')
                            ->schema([
                                Section::make('Primary Colors')
                                    ->description('Configure your primary color palette')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                ColorPicker::make('primary_50')
                                                    ->label('Primary 50')
                                                    ->default('#f0f9ff'),
                                                ColorPicker::make('primary_100')
                                                    ->label('Primary 100')
                                                    ->default('#e0f2fe'),
                                                ColorPicker::make('primary_200')
                                                    ->label('Primary 200')
                                                    ->default('#bae6fd'),
                                                ColorPicker::make('primary_300')
                                                    ->label('Primary 300')
                                                    ->default('#7dd3fc'),
                                                ColorPicker::make('primary_400')
                                                    ->label('Primary 400')
                                                    ->default('#38bdf8'),
                                                ColorPicker::make('primary_500')
                                                    ->label('Primary 500')
                                                    ->default('#0ea5e9'),
                                                ColorPicker::make('primary_600')
                                                    ->label('Primary 600')
                                                    ->default('#0284c7'),
                                                ColorPicker::make('primary_700')
                                                    ->label('Primary 700')
                                                    ->default('#0369a1'),
                                                ColorPicker::make('primary_800')
                                                    ->label('Primary 800')
                                                    ->default('#075985'),
                                                ColorPicker::make('primary_900')
                                                    ->label('Primary 900')
                                                    ->default('#0c4a6e'),
                                                ColorPicker::make('primary_950')
                                                    ->label('Primary 950')
                                                    ->default('#082f49'),
                                            ]),
                                    ]),
                                
                                Section::make('Additional Colors')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                ColorPicker::make('secondary_color')
                                                    ->label('Secondary Color')
                                                    ->default('#64748b'),
                                                ColorPicker::make('accent_color')
                                                    ->label('Accent Color')
                                                    ->default('#f59e0b'),
                                                ColorPicker::make('success_color')
                                                    ->label('Success Color')
                                                    ->default('#10b981'),
                                                ColorPicker::make('warning_color')
                                                    ->label('Warning Color')
                                                    ->default('#f59e0b'),
                                                ColorPicker::make('error_color')
                                                    ->label('Error Color')
                                                    ->default('#ef4444'),
                                                ColorPicker::make('info_color')
                                                    ->label('Info Color')
                                                    ->default('#3b82f6'),
                                            ]),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Typography')
                            ->schema([
                                Section::make('Font Settings')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('font_family_sans')
                                                    ->label('Sans Font Family')
                                                    ->default('Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif')
                                                    ->helperText('Comma-separated list of font families'),
                                                
                                                TextInput::make('font_family_serif')
                                                    ->label('Serif Font Family')
                                                    ->default('ui-serif, Georgia, Cambria, "Times New Roman", Times, serif'),
                                                
                                                TextInput::make('font_family_mono')
                                                    ->label('Monospace Font Family')
                                                    ->default('ui-monospace, SFMono-Regular, "SF Mono", Consolas, "Liberation Mono", Menlo, monospace'),
                                            ]),
                                        
                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('font_size_base')
                                                    ->label('Base Font Size')
                                                    ->default('1rem')
                                                    ->helperText('Default font size'),
                                                
                                                TextInput::make('line_height_base')
                                                    ->label('Base Line Height')
                                                    ->default('1.5')
                                                    ->helperText('Default line height'),
                                                
                                                TextInput::make('font_weight_base')
                                                    ->label('Base Font Weight')
                                                    ->default('400')
                                                    ->helperText('Default font weight'),
                                            ]),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Spacing & Layout')
                            ->schema([
                                Section::make('Spacing Scale')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('spacing_unit')
                                                    ->label('Spacing Unit')
                                                    ->default('0.25rem')
                                                    ->helperText('Base spacing unit (usually 0.25rem = 4px)'),
                                                
                                                TextInput::make('container_padding')
                                                    ->label('Container Padding')
                                                    ->default('1rem')
                                                    ->helperText('Default container padding'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('border_radius_default')
                                                    ->label('Default Border Radius')
                                                    ->default('0.375rem')
                                                    ->helperText('Default border radius for elements'),
                                                
                                                TextInput::make('border_radius_lg')
                                                    ->label('Large Border Radius')
                                                    ->default('0.5rem')
                                                    ->helperText('Large border radius for cards, etc.'),
                                            ]),
                                    ]),
                                
                                Section::make('Breakpoints')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('breakpoint_sm')
                                                    ->label('Small Breakpoint')
                                                    ->default('640px')
                                                    ->helperText('Small screen breakpoint'),
                                                
                                                TextInput::make('breakpoint_md')
                                                    ->label('Medium Breakpoint')
                                                    ->default('768px')
                                                    ->helperText('Medium screen breakpoint'),
                                                
                                                TextInput::make('breakpoint_lg')
                                                    ->label('Large Breakpoint')
                                                    ->default('1024px')
                                                    ->helperText('Large screen breakpoint'),
                                                
                                                TextInput::make('breakpoint_xl')
                                                    ->label('Extra Large Breakpoint')
                                                    ->default('1280px')
                                                    ->helperText('Extra large screen breakpoint'),
                                            ]),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Custom CSS')
                            ->schema([
                                Section::make('Custom Styles')
                                    ->schema([
                                        Toggle::make('enable_custom_css')
                                            ->label('Enable Custom CSS')
                                            ->default(false)
                                            ->helperText('Enable custom CSS injection'),
                                        
                                        Textarea::make('custom_css')
                                            ->label('Custom CSS')
                                            ->rows(10)
                                            ->placeholder('/* Add your custom CSS here */
.custom-class {
    /* Your styles */
}')
                                            ->helperText('Add custom CSS that will be injected into all pages')
                                            ->visible(fn (Forms\Get $get) => $get('enable_custom_css')),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Advanced')
                            ->schema([
                                Section::make('Configuration')
                                    ->schema([
                                        Toggle::make('enable_dark_mode')
                                            ->label('Enable Dark Mode')
                                            ->default(true)
                                            ->helperText('Enable dark mode support'),
                                        
                                        Toggle::make('enable_animations')
                                            ->label('Enable Animations')
                                            ->default(true)
                                            ->helperText('Enable CSS animations and transitions'),
                                        
                                        TextInput::make('css_variables_prefix')
                                            ->label('CSS Variables Prefix')
                                            ->default('--laralgrape')
                                            ->helperText('Prefix for CSS custom properties'),
                                    ]),
                                
                                Section::make('Performance')
                                    ->schema([
                                        Toggle::make('purge_css')
                                            ->label('Purge Unused CSS')
                                            ->default(true)
                                            ->helperText('Remove unused CSS in production'),
                                        
                                        Toggle::make('minify_css')
                                            ->label('Minify CSS')
                                            ->default(true)
                                            ->helperText('Minify CSS in production'),
                                    ]),
                                
                                // Dark Mode Colors Section
                                Section::make('Dark Mode Colors')
                                    ->visible(fn ($get) => $get('enable_dark_mode'))
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                ColorPicker::make('dark_primary_50')->label('Dark Primary 50'),
                                                ColorPicker::make('dark_primary_100')->label('Dark Primary 100'),
                                                ColorPicker::make('dark_primary_200')->label('Dark Primary 200'),
                                                ColorPicker::make('dark_primary_300')->label('Dark Primary 300'),
                                                ColorPicker::make('dark_primary_400')->label('Dark Primary 400'),
                                                ColorPicker::make('dark_primary_500')->label('Dark Primary 500'),
                                                ColorPicker::make('dark_primary_600')->label('Dark Primary 600'),
                                                ColorPicker::make('dark_primary_700')->label('Dark Primary 700'),
                                                ColorPicker::make('dark_primary_800')->label('Dark Primary 800'),
                                                ColorPicker::make('dark_primary_900')->label('Dark Primary 900'),
                                                ColorPicker::make('dark_primary_950')->label('Dark Primary 950'),
                                            ]),
                                        Section::make('Additional Dark Colors')
                                            ->description('Accent, status, and link colors for dark mode')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        ColorPicker::make('dark_secondary_color')->label('Dark Secondary Color'),
                                                        ColorPicker::make('dark_accent_color')->label('Dark Accent Color'),
                                                        ColorPicker::make('dark_success_color')->label('Dark Success Color'),
                                                        ColorPicker::make('dark_warning_color')->label('Dark Warning Color'),
                                                        ColorPicker::make('dark_error_color')->label('Dark Error Color'),
                                                        ColorPicker::make('dark_info_color')->label('Dark Info Color'),
                                                        ColorPicker::make('dark_link_color')->label('Dark Link Color'),
                                                    ]),
                                            ]),
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListTailwindConfigs::route('/'),
            'create' => Pages\CreateTailwindConfig::route('/create'),
            'edit' => Pages\EditTailwindConfig::route('/{record}/edit'),
        ];
    }
}
