<?php

namespace LaraGrape\Filament\Resources;

use LaraGrape\Filament\Forms\Components\GrapesJsEditor;
use LaraGrape\Filament\Resources\LaraPortfolioProjectResource\Pages;
use LaraGrape\Models\PortfolioProject;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use BackedEnum;
use UnitEnum;

class LaraPortfolioProjectResource extends Resource
{
    protected static ?string $model = PortfolioProject::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Portfolio';

    protected static ?string $modelLabel = 'Project';

    protected static ?string $pluralModelLabel = 'Portfolio projects';

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 15;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('Portfolio project')
                    ->tabs([
                        Tab::make('Project')
                            ->schema([
                                Section::make('Details')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                                                Forms\Components\TextInput::make('slug')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->unique(PortfolioProject::class, 'slug', ignoreRecord: true)
                                                    ->rules(['alpha_dash']),
                                            ]),
                                        Forms\Components\Textarea::make('excerpt')
                                            ->rows(3)
                                            ->maxLength(2000)
                                            ->columnSpanFull()
                                            ->helperText('Short summary for cards and teasers.'),
                                        Forms\Components\FileUpload::make('featured_image')
                                            ->image()
                                            ->directory('portfolio/featured')
                                            ->disk('public')
                                            ->columnSpanFull(),
                                        Forms\Components\TagsInput::make('tags')
                                            ->placeholder('Add tag')
                                            ->separator(',')
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('Publishing')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('sort_order')
                                                    ->numeric()
                                                    ->default(0),
                                                Forms\Components\Toggle::make('is_published')
                                                    ->label('Published')
                                                    ->default(false),
                                                Forms\Components\DateTimePicker::make('published_at')
                                                    ->nullable(),
                                            ]),
                                    ]),
                            ]),
                        Tab::make('Visual Editor')
                            ->schema([
                                Section::make('Project page layout')
                                    ->description('Build the public project detail page (replaces fallback content when saved).')
                                    ->schema([
                                        GrapesJsEditor::make('grapesjs_data')
                                            ->label('Layout')
                                            ->height('800px')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Fallback content')
                            ->schema([
                                Section::make('Rich text (fallback)')
                                    ->description('Used when no visual layout is saved, or as reference while editing.')
                                    ->schema([
                                        Forms\Components\RichEditor::make('content')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('SEO')
                            ->schema([
                                Section::make('Search Engine Optimization')
                                    ->schema([
                                        Forms\Components\TextInput::make('meta_title')
                                            ->maxLength(255)
                                            ->helperText('Override browser title; defaults to project title.'),
                                        Forms\Components\Textarea::make('meta_description')
                                            ->rows(2)
                                            ->maxLength(500)
                                            ->columnSpanFull(),
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
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published'),
            ])
            ->actions([
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPortfolioProjects::route('/'),
            'create' => Pages\CreatePortfolioProject::route('/create'),
            'edit' => Pages\EditPortfolioProject::route('/{record}/edit'),
        ];
    }
}
