<?php

namespace Streats22\LaraGrape\Filament\Resources;

use App\Filament\Forms\Components\GrapesJsEditor;
use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use Streats22\LaraGrape\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'Pages';
    
    protected static ?string $modelLabel = 'Page';
    
    protected static ?string $pluralModelLabel = 'Pages';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Page Content')
                    ->tabs([
                        Tabs\Tab::make('Basic Information')
                            ->schema([
                                Section::make('Page Details')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                                                
                                                Forms\Components\TextInput::make('slug')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->unique(Page::class, 'slug', ignoreRecord: true)
                                                    ->rules(['alpha_dash']),
                                            ]),
                                        
                                        Forms\Components\Select::make('template')
                                            ->options([
                                                'default' => 'Default',
                                                'full-width' => 'Full Width',
                                                'minimal' => 'Minimal',
                                            ])
                                            ->default('default'),
                                        
                                        Forms\Components\FileUpload::make('featured_image')
                                            ->image()
                                            ->directory('pages/featured-images'),
                                        
                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\Toggle::make('is_published')
                                                    ->label('Published')
                                                    ->default(false),
                                                
                                                Forms\Components\Toggle::make('show_in_menu')
                                                    ->label('Show in Menu')
                                                    ->default(false),
                                                
                                                Forms\Components\TextInput::make('sort_order')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->label('Sort Order'),
                                            ]),
                                        
                                        Forms\Components\DateTimePicker::make('published_at')
                                            ->label('Publish Date')
                                            ->default(now()),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Visual Editor')
                            ->schema([
                                Section::make('Page Builder')
                                    ->description('Use the visual editor to design your page')
                                    ->schema([
                                        GrapesJsEditor::make('grapesjs_data')
                                            ->label('Page Content')
                                            ->height('800px'),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Content')
                            ->schema([
                                Section::make('Page Content')
                                    ->schema([
                                        Forms\Components\RichEditor::make('content')
                                            ->label('Content (Fallback)')
                                            ->columnSpanFull()
                                            ->toolbarButtons([
                                                'attachFiles',
                                                'blockquote',
                                                'bold',
                                                'bulletList',
                                                'codeBlock',
                                                'h2',
                                                'h3',
                                                'italic',
                                                'link',
                                                'orderedList',
                                                'redo',
                                                'strike',
                                                'underline',
                                                'undo',
                                            ]),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('SEO')
                            ->schema([
                                Section::make('Search Engine Optimization')
                                    ->schema([
                                        Forms\Components\TextInput::make('meta_title')
                                            ->maxLength(60)
                                            ->helperText('Recommended: 50-60 characters'),
                                        
                                        Forms\Components\Textarea::make('meta_description')
                                            ->rows(3)
                                            ->maxLength(160)
                                            ->helperText('Recommended: 150-160 characters'),
                                        
                                        Forms\Components\TextInput::make('meta_keywords')
                                            ->helperText('Comma-separated keywords'),
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
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Image')
                    ->circular(),
                
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),
                
                Tables\Columns\IconColumn::make('show_in_menu')
                    ->label('In Menu')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('template')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published'),
                
                Tables\Filters\TernaryFilter::make('show_in_menu')
                    ->label('Show in Menu'),
                
                Tables\Filters\SelectFilter::make('template')
                    ->options([
                        'default' => 'Default',
                        'full-width' => 'Full Width',
                        'minimal' => 'Minimal',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (Page $record) => route('page.show', $record->slug))
                    ->openUrlInNewTab(),
                
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
