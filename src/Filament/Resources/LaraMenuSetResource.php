<?php

namespace LaraGrape\Filament\Resources;

use LaraGrape\Filament\Resources\MenuSetResource\Pages;
use LaraGrape\Models\MenuSet;
use Filament\Forms;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class LaraMenuSetResource extends Resource
{
    protected static ?string $model = MenuSet::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-bars-4';

    protected static string|\UnitEnum|null $navigationGroup = 'Menu Management';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('Menu Set Configuration')
                    ->tabs([
                        Tab::make('Basic Information')
                            ->schema([
                                Section::make('Menu Set Details')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Internal Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (string $state, callable $set) {
                                                if (empty($state)) {
                                                    $set('name', Str::slug($state));
                                                }
                                            })
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('display_name')
                                            ->label('Display Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (string $state, callable $set, $get) {
                                                if (empty($get('name'))) {
                                                    $set('name', Str::slug($state));
                                                }
                                                if (empty($get('link_text'))) {
                                                    $set('link_text', $state);
                                                }
                                            })
                                            ->columnSpan(1),

                                        Forms\Components\Select::make('menu_type')
                                            ->label('Menu Type')
                                            ->options(MenuSet::getMenuTypes())
                                            ->required()
                                            ->default('header')
                                            ->helperText('Type of menu this set represents')
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('sort_order')
                                            ->label('Sort Order')
                                            ->numeric()
                                            ->default(0)
                                            ->helperText('Order in which this menu set appears')
                                            ->columnSpan(1),

                                        Forms\Components\Toggle::make('is_active')
                                            ->label('Active')
                                            ->default(true)
                                            ->helperText('Enable or disable this menu set')
                                            ->columnSpan(2)
                                            ->afterStateUpdated(function ($state, $get, $set) {
                                                // If activating a header or footer menu, show warning about deactivating others
                                                if ($state && in_array($get('menu_type'), ['header', 'footer'])) {
                                                    $set('description', $get('description') . ' (This will deactivate other ' . $get('menu_type') . ' menus)');
                                                }
                                            }),

                                        Forms\Components\Textarea::make('description')
                                            ->label('Description')
                                            ->maxLength(500)
                                            ->rows(3)
                                            ->helperText('Optional description for this menu set')
                                            ->columnSpan(2),
                                    ])
                                    ->columns(2),
                            ]),

                        Tab::make('Menu Items')
                            ->schema([
                                Section::make('Menu Items')
                                    ->description('Add and configure menu items. Drag to reorder.')
                                    ->schema([
                                        Forms\Components\Repeater::make('menuItems')
                                            ->relationship('allMenuItems')
                                            ->schema([
                                                Grid::make(3)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('name')
                                                            ->label('Internal Name')
                                                            ->required()
                                                            ->maxLength(255)
                                                            ->live(onBlur: true)
                                                            ->afterStateUpdated(function (string $state, callable $set) {
                                                                if (empty($state)) {
                                                                    $set('name', Str::slug($state));
                                                                }
                                                            })
                                                            ->columnSpan(1),

                                                        Forms\Components\TextInput::make('display_name')
                                                            ->label('Display Name')
                                                            ->required()
                                                            ->maxLength(255)
                                                            ->live(onBlur: true)
                                                            ->afterStateUpdated(function (string $state, callable $set, $get) {
                                                                if (empty($get('name'))) {
                                                                    $set('name', Str::slug($state));
                                                                }
                                                                if (empty($get('link_text'))) {
                                                                    $set('link_text', $state);
                                                                }
                                                            })
                                                            ->columnSpan(1),

                                                        Forms\Components\Select::make('link_type')
                                                            ->label('Link Type')
                                                            ->options([
                                                                'page' => 'Page',
                                                                'url' => 'URL',
                                                                'custom' => 'Custom',
                                                                'dropdown' => 'Dropdown (Parent Item)',
                                                            ])
                                                            ->required()
                                                            ->default('page')
                                                            ->live()
                                                            ->afterStateUpdated(function (string $state, callable $set) {
                                                                if ($state === 'dropdown') {
                                                                    $set('has_children', true);
                                                                } else {
                                                                    $set('has_children', false);
                                                                }
                                                            })
                                                            ->columnSpan(1),

                                                        Forms\Components\Hidden::make('has_children')
                                                            ->default(false),
                                                    ]),

                                                Grid::make(2)
                                                    ->schema([
                                                        Forms\Components\Select::make('page_id')
                                                            ->label('Select Page')
                                                            ->options(function () {
                                                                return \App\Models\Page::published()
                                                                    ->pluck('title', 'id')
                                                                    ->toArray();
                                                            })
                                                            ->searchable()
                                                            ->visible(fn ($get) => $get('link_type') === 'page' && !$get('has_children'))
                                                            ->columnSpan(1),

                                                        Forms\Components\TextInput::make('link_url')
                                                            ->label('URL')
                                                            ->placeholder('e.g., /about, https://example.com')
                                                            ->visible(fn ($get) => in_array($get('link_type'), ['url', 'custom']) && !$get('has_children'))
                                                            ->columnSpan(1),
                                                    ]),

                                                Grid::make(2)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('link_text')
                                                            ->label('Link Text')
                                                            ->required(fn ($get) => !$get('has_children'))
                                                            ->maxLength(255)
                                                            ->placeholder('e.g., About Us, Contact')
                                                            ->columnSpan(1),

                                                        Forms\Components\TextInput::make('link_title')
                                                            ->label('Tooltip')
                                                            ->maxLength(255)
                                                            ->placeholder('e.g., Learn more about our company')
                                                            ->helperText('Text shown on hover')
                                                            ->columnSpan(1),
                                                    ]),

                                                Grid::make(3)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('icon')
                                                            ->label('Icon')
                                                            ->maxLength(255)
                                                            ->placeholder('e.g., fa-home, fa-user')
                                                            ->helperText('FontAwesome icon class')
                                                            ->columnSpan(1),

                                                        Forms\Components\TextInput::make('css_class')
                                                            ->label('CSS Class')
                                                            ->maxLength(255)
                                                            ->placeholder('e.g., btn-primary, text-lg')
                                                            ->helperText('Additional CSS classes')
                                                            ->columnSpan(1),

                                                        Forms\Components\TextInput::make('sort_order')
                                                            ->label('Sort Order')
                                                            ->numeric()
                                                            ->default(0)
                                                            ->helperText('Lower numbers appear first')
                                                            ->columnSpan(1),
                                                    ]),

                                                Grid::make(3)
                                                    ->schema([
                                                        Forms\Components\Toggle::make('open_in_new_tab')
                                                            ->label('Open in New Tab')
                                                            ->default(false)
                                                            ->helperText('Open link in new browser tab')
                                                            ->columnSpan(1),

                                                        Forms\Components\Toggle::make('is_active')
                                                            ->label('Active')
                                                            ->default(true)
                                                            ->helperText('Enable this menu item')
                                                            ->columnSpan(1),

                                                        Forms\Components\Toggle::make('is_visible')
                                                            ->label('Visible')
                                                            ->default(true)
                                                            ->helperText('Show this item in the menu')
                                                            ->columnSpan(1),
                                                    ]),

                                                // Sub-items section
                                                Section::make('Sub-items')
                                                    ->description('Add child menu items (sub-menu)')
                                                    ->schema([
                                                        Forms\Components\Repeater::make('children')
                                                            ->relationship('children')
                                                            ->schema([
                                                                Grid::make(2)
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('display_name')
                                                                            ->label('Display Name')
                                                                            ->required()
                                                                            ->maxLength(255)
                                                                            ->columnSpan(1),

                                                                        Forms\Components\Select::make('link_type')
                                                                            ->label('Link Type')
                                                                            ->options([
                                                                                'page' => 'Page',
                                                                                'url' => 'URL',
                                                                                'custom' => 'Custom',
                                                                            ])
                                                                            ->required()
                                                                            ->default('page')
                                                                            ->live()
                                                                            ->columnSpan(1),
                                                                    ]),

                                                                Grid::make(2)
                                                                    ->schema([
                                                                        Forms\Components\Select::make('page_id')
                                                                            ->label('Select Page')
                                                                            ->options(function () {
                                                                                return \App\Models\Page::published()
                                                                                    ->pluck('title', 'id')
                                                                                    ->toArray();
                                                                            })
                                                                            ->searchable()
                                                                            ->visible(fn ($get) => $get('link_type') === 'page')
                                                                            ->columnSpan(1),

                                                                        Forms\Components\TextInput::make('link_url')
                                                                            ->label('URL')
                                                                            ->placeholder('e.g., /about, https://example.com')
                                                                            ->visible(fn ($get) => in_array($get('link_type'), ['url', 'custom']))
                                                                            ->columnSpan(1),
                                                                    ]),

                                                                Grid::make(2)
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('link_text')
                                                                            ->label('Link Text')
                                                                            ->required()
                                                                            ->maxLength(255)
                                                                            ->placeholder('e.g., About Us, Contact')
                                                                            ->columnSpan(1),

                                                                        Forms\Components\TextInput::make('link_title')
                                                                            ->label('Tooltip')
                                                                            ->maxLength(255)
                                                                            ->placeholder('e.g., Learn more about our company')
                                                                            ->helperText('Text shown on hover')
                                                                            ->columnSpan(1),
                                                                    ]),

                                                                Grid::make(3)
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('icon')
                                                                            ->label('Icon')
                                                                            ->maxLength(255)
                                                                            ->placeholder('e.g., fa-home, fa-user')
                                                                            ->helperText('FontAwesome icon class')
                                                                            ->columnSpan(1),

                                                                        Forms\Components\TextInput::make('css_class')
                                                                            ->label('CSS Class')
                                                                            ->maxLength(255)
                                                                            ->placeholder('e.g., btn-primary, text-lg')
                                                                            ->helperText('Additional CSS classes')
                                                                            ->columnSpan(1),

                                                                        Forms\Components\TextInput::make('sort_order')
                                                                            ->label('Sort Order')
                                                                            ->numeric()
                                                                            ->default(0)
                                                                            ->helperText('Lower numbers appear first')
                                                                            ->columnSpan(1),
                                                                    ]),

                                                                Grid::make(3)
                                                                    ->schema([
                                                                        Forms\Components\Toggle::make('open_in_new_tab')
                                                                            ->label('Open in New Tab')
                                                                            ->default(false)
                                                                            ->helperText('Open link in new browser tab')
                                                                            ->columnSpan(1),

                                                                        Forms\Components\Toggle::make('is_active')
                                                                            ->label('Active')
                                                                            ->default(true)
                                                                            ->helperText('Enable this menu item')
                                                                            ->columnSpan(1),

                                                                        Forms\Components\Toggle::make('is_visible')
                                                                            ->label('Visible')
                                                                            ->default(true)
                                                                            ->helperText('Show this item in the menu')
                                                                            ->columnSpan(1),
                                                                    ]),
                                                            ])
                                                            ->columns(1)
                                                            ->defaultItems(0)
                                                            ->reorderableWithButtons()
                                                            ->collapsible()
                                                            ->itemLabel(fn (array $state): ?string => $state['display_name'] ?? null)
                                                            ->addActionLabel('Add Sub-item')
                                                            ->cloneable()
                                                            ->collapsed(),
                                                    ])
                                                    ->collapsed(),
                                            ])
                                            ->columns(1)
                                            ->defaultItems(0)
                                            ->reorderableWithButtons()
                                            ->orderable('sort_order')
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string => $state['display_name'] ?? null)
                                            ->addActionLabel('Add Menu Item')
                                            ->cloneable()
                                            ->collapsed()
                                            ->reorderableWithDragAndDrop()
                                            ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                                                // Ensure sort_order is set for existing items
                                                if (!isset($data['sort_order'])) {
                                                    $data['sort_order'] = 0;
                                                }
                                                // Ensure all required fields have defaults
                                                if (!isset($data['name'])) {
                                                    $data['name'] = Str::slug($data['display_name'] ?? 'menu-item');
                                                }
                                                if (!isset($data['link_text'])) {
                                                    $data['link_text'] = $data['display_name'] ?? 'Menu Item';
                                                }
                                                if (!isset($data['is_active'])) {
                                                    $data['is_active'] = true;
                                                }
                                                if (!isset($data['is_visible'])) {
                                                    $data['is_visible'] = true;
                                                }
                                                
                                                // Set has_children based on link_type or existing children
                                                if (isset($data['link_type']) && $data['link_type'] === 'dropdown') {
                                                    $data['has_children'] = true;
                                                } elseif (isset($data['children']) && !empty($data['children'])) {
                                                    $data['has_children'] = true;
                                                } else {
                                                    $data['has_children'] = false;
                                                }
                                                
                                                return $data;
                                            })
                                            ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
                                                // Ensure required fields are set
                                                if (!isset($data['name']) || empty($data['name'])) {
                                                    $data['name'] = Str::slug($data['display_name'] ?? 'menu-item');
                                                }
                                                if (!isset($data['link_text']) || empty($data['link_text'])) {
                                                    $data['link_text'] = $data['display_name'] ?? 'Menu Item';
                                                }
                                                if (!isset($data['sort_order'])) {
                                                    $data['sort_order'] = 0;
                                                }
                                                if (!isset($data['is_active'])) {
                                                    $data['is_active'] = true;
                                                }
                                                if (!isset($data['is_visible'])) {
                                                    $data['is_visible'] = true;
                                                }
                                                
                                                // Handle dropdown logic
                                                if (isset($data['link_type']) && $data['link_type'] === 'dropdown') {
                                                    $data['has_children'] = true;
                                                    // Clear link fields for dropdown items
                                                    $data['link_url'] = null;
                                                    $data['page_id'] = null;
                                                    $data['link_text'] = $data['display_name'] ?? 'Menu Item';
                                                } else {
                                                    $data['has_children'] = false;
                                                }
                                                
                                                // Handle URL field based on link type
                                                if (isset($data['link_type']) && $data['link_type'] === 'page') {
                                                    $data['link_url'] = null; // Clear URL when using page
                                                } elseif (isset($data['link_type']) && in_array($data['link_type'], ['url', 'custom'])) {
                                                    $data['page_id'] = null; // Clear page when using URL
                                                }
                                                
                                                return $data;
                                            }),
                                    ])
                                    ->columns(1),

                                Section::make('Preview')
                                    ->description('Preview of how your menu will look')
                                    ->schema([
                                        Forms\Components\Placeholder::make('preview')
                                            ->content(function ($get) {
                                                $menuItems = $get('menuItems');
                                                if (empty($menuItems)) {
                                                    return '<div class="text-gray-500 italic">No menu items added yet. Add some items above to see a preview.</div>';
                                                }
                                                
                                                $html = '<div class="space-y-2">';
                                                foreach ($menuItems as $item) {
                                                    $text = $item['display_name'] ?? $item['link_text'] ?? 'Unnamed Item';
                                                    $url = $item['link_url'] ?? '#';
                                                    $icon = $item['icon'] ? "<i class=\"{$item['icon']}\"></i> " : '';
                                                    $active = $item['is_active'] ?? true ? 'text-blue-600' : 'text-gray-400';
                                                    $visible = $item['is_visible'] ?? true ? '' : 'opacity-50';
                                                    $isDropdown = ($item['link_type'] ?? '') === 'dropdown' || ($item['has_children'] ?? false);
                                                    
                                                    $html .= "<div class=\"{$active} {$visible} flex items-center space-x-2\">";
                                                    if ($isDropdown) {
                                                        $html .= "<span>{$icon}<span class=\"font-medium\">{$text}</span> <span class=\"text-xs text-gray-500\">(Dropdown)</span></span>";
                                                    } else {
                                                        $html .= "<span>{$icon}<a href=\"{$url}\" class=\"hover:underline\">{$text}</a></span>";
                                                    }
                                                    if (!($item['is_active'] ?? true)) {
                                                        $html .= '<span class="text-xs text-gray-400">(Inactive)</span>';
                                                    }
                                                    if (!($item['is_visible'] ?? true)) {
                                                        $html .= '<span class="text-xs text-gray-400">(Hidden)</span>';
                                                    }
                                                    $html .= '</div>';
                                                }
                                                $html .= '</div>';
                                                
                                                return $html;
                                            }),
                                    ])
                                    ->collapsed(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('display_name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('menu_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'header' => 'primary',
                        'footer' => 'success',
                        'mobile' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('menuItems_count')
                    ->label('Items')
                    ->counts('allMenuItems')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->numeric(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable()
                    ->tooltip(function ($record) {
                        if ($record->is_active && in_array($record->menu_type, ['header', 'footer'])) {
                            return "This is the active {$record->menu_type} menu";
                        }
                        return null;
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('menu_type')
                    ->label('Menu Type')
                    ->options(MenuSet::getMenuTypes()),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->url(fn (MenuSet $record): string => route('home'))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc')
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
            'index' => Pages\LaraListMenuSets::route('/'),
            'create' => Pages\LaraCreateMenuSet::route('/create'),
            'edit' => Pages\LaraEditMenuSet::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
