<?php

namespace Streats22\LaraGrape\Filament\Resources;

use Streats22\LaraGrape\Filament\Resources\SiteSettingsResource\Pages;
use Streats22\LaraGrape\Filament\Resources\SiteSettingsResource\RelationManagers;
use Streats22\LaraGrape\Models\SiteSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\KeyValue;

class SiteSettingsResource extends Resource
{
    protected static ?string $model = SiteSettings::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static ?string $navigationLabel = 'Site Settings';
    
    protected static ?string $modelLabel = 'Site Setting';
    
    protected static ?string $pluralModelLabel = 'Site Settings';
    
    protected static ?string $navigationGroup = 'Design System';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('key')
                    ->label('Key')
                    ->visible(fn ($record) => $record->exists)
                    ->unique(ignoreRecord: true)
                    ->helperText('A unique key for this setting (e.g. site_name, header_logo_text)')
                    ->reactive()
                    ->afterStateUpdated(function ($set, $state, $context) {
                        // Only auto-generate if creating and key is empty
                        if ($context === 'create' && empty($state)) {
                            $set('key', str(
                                request()->input('label', '')
                            )->slug('_'));
                        }
                    }),
                Tabs::make('Site Configuration')
                    ->tabs([
                        Tabs\Tab::make('General')
                            ->schema([
                                Section::make('General Site Settings')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('site_name')
                                                    ->label('Site Name')
                                                    ->default('LaralGrape')
                                                    ->helperText('The name of your website'),
                                                
                                                TextInput::make('site_tagline')
                                                    ->label('Site Tagline')
                                                    ->default('Laravel + GrapesJS + Filament')
                                                    ->helperText('A short description of your site'),
                                            ]),
                                        
                                        Textarea::make('site_description')
                                            ->label('Site Description')
                                            ->rows(3)
                                            ->default('A powerful web development boilerplate combining Laravel, GrapesJS, and Filament.')
                                            ->helperText('Detailed description for SEO'),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('contact_email')
                                                    ->label('Contact Email')
                                                    ->email()
                                                    ->default('contact@example.com'),
                                                
                                                TextInput::make('contact_phone')
                                                    ->label('Contact Phone')
                                                    ->default('+1 (555) 123-4567'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('address')
                                                    ->label('Address')
                                                    ->default('123 Main Street, City, State 12345'),
                                                
                                                TextInput::make('timezone')
                                                    ->label('Timezone')
                                                    ->default('UTC')
                                                    ->helperText('Server timezone'),
                                            ]),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Header')
                            ->schema([
                                Section::make('Header Configuration')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('header_logo_text')
                                                    ->label('Logo Text')
                                                    ->default('LaralGrape')
                                                    ->helperText('Text to display as logo'),
                                                
                                                FileUpload::make('header_logo_image')
                                                    ->label('Logo Image')
                                                    ->image()
                                                    ->directory('site/header')
                                                    ->helperText('Upload a logo image (optional)'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                ColorPicker::make('header_background_color')
                                                    ->label('Background Color')
                                                    ->default('#ffffff'),
                                                
                                                ColorPicker::make('header_text_color')
                                                    ->label('Text Color')
                                                    ->default('#1f2937'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('header_sticky')
                                                    ->label('Sticky Header')
                                                    ->default(true)
                                                    ->helperText('Keep header fixed at top'),
                                                
                                                Toggle::make('header_show_search')
                                                    ->label('Show Search')
                                                    ->default(false)
                                                    ->helperText('Display search bar in header'),
                                            ]),
                                        
                                        Textarea::make('header_custom_css')
                                            ->label('Custom Header CSS')
                                            ->rows(4)
                                            ->placeholder('/* Add custom header styles here */
.header {
    /* Your custom styles */
}')
                                            ->helperText('Custom CSS for header styling'),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Footer')
                            ->schema([
                                Section::make('Footer Configuration')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('footer_logo_text')
                                                    ->label('Footer Logo Text')
                                                    ->default('LaralGrape')
                                                    ->helperText('Text to display in footer'),
                                                
                                                FileUpload::make('footer_logo_image')
                                                    ->label('Footer Logo Image')
                                                    ->image()
                                                    ->directory('site/footer')
                                                    ->helperText('Upload a footer logo image'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                ColorPicker::make('footer_background_color')
                                                    ->label('Background Color')
                                                    ->default('#1f2937'),
                                                
                                                ColorPicker::make('footer_text_color')
                                                    ->label('Text Color')
                                                    ->default('#ffffff'),
                                            ]),
                                        
                                        Textarea::make('footer_content')
                                            ->label('Footer Content')
                                            ->rows(4)
                                            ->default('© 2024 LaralGrape. All rights reserved.')
                                            ->helperText('Main footer content (supports HTML)'),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('footer_show_social')
                                                    ->label('Show Social Links')
                                                    ->default(true)
                                                    ->helperText('Display social media links'),
                                                
                                                Toggle::make('footer_show_newsletter')
                                                    ->label('Show Newsletter Signup')
                                                    ->default(false)
                                                    ->helperText('Display newsletter subscription form'),
                                            ]),
                                        
                                        Textarea::make('footer_custom_css')
                                            ->label('Custom Footer CSS')
                                            ->rows(4)
                                            ->placeholder('/* Add custom footer styles here */
.footer {
    /* Your custom styles */
}')
                                            ->helperText('Custom CSS for footer styling'),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('SEO')
                            ->schema([
                                Section::make('SEO Settings')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('seo_title')
                                                    ->label('Default Page Title')
                                                    ->default('LaralGrape - Web Development Boilerplate')
                                                    ->helperText('Default title for pages without custom title'),
                                                
                                                TextInput::make('seo_keywords')
                                                    ->label('Default Keywords')
                                                    ->default('laravel, grapesjs, filament, web development')
                                                    ->helperText('Comma-separated keywords'),
                                            ]),
                                        
                                        Textarea::make('seo_description')
                                            ->label('Default Meta Description')
                                            ->rows(3)
                                            ->default('A powerful web development boilerplate combining Laravel, GrapesJS, and Filament for building modern websites.')
                                            ->helperText('Default meta description for pages'),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('seo_auto_generate')
                                                    ->label('Auto-generate Meta Tags')
                                                    ->default(true)
                                                    ->helperText('Automatically generate meta tags from content'),
                                                
                                                Toggle::make('seo_show_author')
                                                    ->label('Show Author Meta')
                                                    ->default(false)
                                                    ->helperText('Include author meta tags'),
                                            ]),
                                        
                                        TextInput::make('google_analytics_id')
                                            ->label('Google Analytics ID')
                                            ->placeholder('G-XXXXXXXXXX')
                                            ->helperText('Google Analytics tracking ID'),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Social Media')
                            ->schema([
                                Section::make('Social Media Links')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('social_facebook')
                                                    ->label('Facebook URL')
                                                    ->url()
                                                    ->placeholder('https://facebook.com/yourpage'),
                                                
                                                TextInput::make('social_twitter')
                                                    ->label('Twitter/X URL')
                                                    ->url()
                                                    ->placeholder('https://twitter.com/yourhandle'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('social_instagram')
                                                    ->label('Instagram URL')
                                                    ->url()
                                                    ->placeholder('https://instagram.com/yourhandle'),
                                                
                                                TextInput::make('social_linkedin')
                                                    ->label('LinkedIn URL')
                                                    ->url()
                                                    ->placeholder('https://linkedin.com/company/yourcompany'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('social_youtube')
                                                    ->label('YouTube URL')
                                                    ->url()
                                                    ->placeholder('https://youtube.com/yourchannel'),
                                                
                                                TextInput::make('social_github')
                                                    ->label('GitHub URL')
                                                    ->url()
                                                    ->placeholder('https://github.com/yourusername'),
                                            ]),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Advanced')
                            ->schema([
                                Section::make('Advanced Settings')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('enable_cache')
                                                    ->label('Enable Caching')
                                                    ->default(true)
                                                    ->helperText('Enable site-wide caching'),
                                                
                                                Toggle::make('enable_debug')
                                                    ->label('Enable Debug Mode')
                                                    ->default(false)
                                                    ->helperText('Show debug information'),
                                            ]),
                                        
                                        Textarea::make('custom_css')
                                            ->label('Global Custom CSS')
                                            ->rows(6)
                                            ->placeholder('/* Add global custom styles here */
.custom-class {
    /* Your styles */
}')
                                            ->helperText('CSS that will be applied site-wide'),
                                        
                                        Textarea::make('custom_js')
                                            ->label('Global Custom JavaScript')
                                            ->rows(6)
                                            ->placeholder('// Add global custom JavaScript here
console.log("Site loaded!");')
                                            ->helperText('JavaScript that will run on all pages'),
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
                Tables\Columns\TextColumn::make('key')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('group')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'general' => 'gray',
                        'header' => 'primary',
                        'footer' => 'success',
                        'seo' => 'warning',
                        'social' => 'info',
                        default => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('label')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('type')
                    ->badge(),
                
                Tables\Columns\TextColumn::make('value')
                    ->limit(50)
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->options(SiteSettings::getGroups()),
                
                Tables\Filters\SelectFilter::make('type')
                    ->options(SiteSettings::getTypes()),
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
            ->defaultSort('group', 'asc');
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
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSettings::route('/create'),
            'edit' => Pages\EditSiteSettings::route('/{record}/edit'),
        ];
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-generate label from key if not set
        if (empty($data['label']) && !empty($data['key'])) {
            $data['label'] = self::prettifyKey($data['key']);
        }
        return $data;
    }

    protected static function prettifyKey(string $key): string
    {
        return ucwords(str_replace(['_', '-'], ' ', $key));
    }
}
