<?php

namespace LaraGrape\Filament\Resources;

use LaraGrape\Filament\Forms\Components\GrapesJsEditor;
use LaraGrape\Filament\Resources\PageResource\Pages;
use LaraGrape\Models\Page;
use LaraGrape\Services\BlockLayoutService;
use LaraGrape\Support\BlockBuilderSchema;
use LaraGrape\Support\EditorSettings;
use Filament\Schemas\Components\Fieldset;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class LaraPageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Pages';

    protected static ?string $modelLabel = 'Page';

    protected static ?string $pluralModelLabel = 'Pages';

    public static function form(Schema $schema): Schema
    {
        $blockOptions = app(BlockLayoutService::class)->blockSelectOptions();

        return $schema
            ->schema([
                Tabs::make('Page Content')
                    ->tabs([
                        Tab::make('Basic Information')
                            ->schema([
                                Section::make('Page Details')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn (string $operation, $state, $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                                                Forms\Components\TextInput::make('slug')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->unique(Page::class, 'slug', ignoreRecord: true)
                                                    ->rules(['alpha_dash']),
                                            ]),

                                        Forms\Components\Select::make('editor_mode')
                                            ->label('Page editor mode')
                                            ->options([
                                                EditorSettings::PAGE_MODE_VISUAL => 'Visual (GrapesJS canvas)',
                                                EditorSettings::PAGE_MODE_BLOCK => 'Block list builder',
                                            ])
                                            ->default(EditorSettings::defaultPageEditorMode())
                                            ->required()
                                            ->visible(fn (): bool => EditorSettings::usesPerPageEditorMode()
                                                && EditorSettings::allowsBlockBuilder()
                                                && EditorSettings::allowsVisualEditor())
                                            ->helperText('Choose how this page is edited in the admin. The public site always uses the saved layout.'),

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

                        Tab::make('Visual Editor')
                            ->schema([
                                Section::make('Page Builder')
                                    ->description('Use the visual editor to design your page')
                                    ->schema([
                                        GrapesJsEditor::make('grapesjs_data')
                                            ->label('Page Content')
                                            ->height('800px')
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->visible(fn (Get $get): bool => static::shouldShowVisualEditorTab($get('editor_mode'))),

                        Tab::make('Block Builder')
                            ->schema([
                                Section::make('Block layout')
                                    ->description('Add and reorder blocks from the catalog. Edit each block\'s content below; preview uses the same Blade templates and CSS as the live site.')
                                    ->schema([
                                        Forms\Components\Repeater::make('block_layout')
                                            ->label('Blocks')
                                            ->schema([
                                                Forms\Components\Select::make('block_id')
                                                    ->label('Block')
                                                    ->options($blockOptions)
                                                    ->searchable()
                                                    ->required()
                                                    ->live(),
                                                Fieldset::make('Content')
                                                    ->description('Edit the text and values for this block. The preview updates as you type.')
                                                    ->schema(fn (Get $get): array => BlockBuilderSchema::fieldsFor($get('block_id')))
                                                    ->statePath('dynamic_data')
                                                    ->visible(fn (Get $get): bool => filled($get('block_id')))
                                                    ->columns(1)
                                                    ->columnSpanFull(),
                                                Forms\Components\Placeholder::make('block_preview')
                                                    ->label('Preview')
                                                    ->content(function (Get $get) use ($blockOptions): HtmlString {
                                                        $blockId = $get('block_id');
                                                        if (! filled($blockId)) {
                                                            return new HtmlString(
                                                                '<div class="rounded-lg border border-dashed border-gray-300 dark:border-gray-600 px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">Select a block to see its content.</div>',
                                                            );
                                                        }

                                                        $row = [
                                                            'dynamic_data' => is_array($get('dynamic_data')) ? $get('dynamic_data') : [],
                                                            'custom_html' => $get('custom_html') ?? '',
                                                        ];

                                                        $html = app(BlockLayoutService::class)->renderBlockPreviewHtml($blockId, $row);

                                                        if ($html === null) {
                                                            return new HtmlString(
                                                                '<div class="text-sm text-amber-600 dark:text-amber-400 px-2">Preview is not available for this block.</div>',
                                                            );
                                                        }

                                                        return new HtmlString(view('filament.forms.components.block-builder-item-preview', [
                                                            'content' => $html,
                                                            'label' => static::blockLabelForId($blockId, $blockOptions),
                                                            'compact' => false,
                                                            'fullWidth' => true,
                                                        ])->render());
                                                    })
                                                    ->columnSpanFull(),
                                                Forms\Components\Hidden::make('instance_key'),
                                            ])
                                            ->itemLabel(fn (array $state): ?string => static::blockRepeaterItemLabel($state, $blockOptions))
                                            ->collapsible()
                                            ->reorderable()
                                            ->live()
                                            ->defaultItems(0)
                                            ->columnSpanFull()
                                            ->columns(1),
                                        Forms\Components\Placeholder::make('block_layout_stack_preview')
                                            ->label('Page preview')
                                            ->content(function (Get $get): HtmlString {
                                                $layout = $get('block_layout');
                                                if (! is_array($layout)) {
                                                    $layout = [];
                                                }

                                                $stack = app(BlockLayoutService::class)->buildPreviewStack($layout);

                                                return new HtmlString(view('filament.forms.components.block-layout-stack-preview', [
                                                    'blocks' => $stack,
                                                ])->render());
                                            })
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->visible(fn (Get $get): bool => static::shouldShowBlockBuilderTab($get('editor_mode'))),

                        Tab::make('Content')
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

                        Tab::make('SEO')
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

    public static function shouldShowVisualEditorTab(?string $editorMode = null): bool
    {
        if (! EditorSettings::allowsVisualEditor()) {
            return false;
        }

        if (EditorSettings::usesPerPageEditorMode()) {
            return ($editorMode ?? EditorSettings::PAGE_MODE_VISUAL) === EditorSettings::PAGE_MODE_VISUAL;
        }

        return ! in_array(EditorSettings::editorModePolicy(), [EditorSettings::POLICY_BLOCK_ONLY, EditorSettings::POLICY_BLOCK], true);
    }

    public static function shouldShowBlockBuilderTab(?string $editorMode = null): bool
    {
        if (! EditorSettings::allowsBlockBuilder()) {
            return false;
        }

        if (EditorSettings::usesPerPageEditorMode()) {
            return ($editorMode ?? EditorSettings::defaultPageEditorMode()) === EditorSettings::PAGE_MODE_BLOCK;
        }

        return in_array(EditorSettings::editorModePolicy(), [
            EditorSettings::POLICY_BLOCK_ONLY,
            EditorSettings::POLICY_BLOCK,
        ], true);
    }

    /**
     * @param  array<string, array<string, string>>  $blockOptions
     */
    protected static function blockRepeaterItemLabel(array $state, array $blockOptions): ?string
    {
        $blockId = $state['block_id'] ?? null;
        if (! is_string($blockId) || $blockId === '') {
            return 'New block';
        }

        return static::blockLabelForId($blockId, $blockOptions);
    }

    /**
     * @param  array<string, array<string, string>>  $blockOptions
     */
    protected static function blockLabelForId(string $blockId, array $blockOptions): string
    {
        foreach ($blockOptions as $labels) {
            if (isset($labels[$blockId])) {
                return $labels[$blockId];
            }
        }

        return $blockId;
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

                Tables\Columns\TextColumn::make('editor_mode')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->visible(fn (): bool => EditorSettings::usesPerPageEditorMode()),

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
                ViewAction::make()
                    ->url(fn (Page $record) => route('page.show', $record->slug))
                    ->openUrlInNewTab(),

                EditAction::make(),

                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\LaraListPages::route('/'),
            'create' => Pages\LaraCreatePage::route('/create'),
            'edit' => Pages\LaraEditPage::route('/{record}/edit'),
        ];
    }
}
