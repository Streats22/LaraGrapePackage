<?php

namespace LaraGrape\Filament\Resources;

use LaraGrape\Filament\Resources\CustomBlockResource\Pages;
use LaraGrape\Filament\Resources\CustomBlockResource\RelationManagers;
use LaraGrape\Models\CustomBlock;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\TagsInput;

class LaraCustomBlockResource extends Resource
{
    protected static ?string $model = CustomBlock::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cube';
    
    protected static ?string $navigationLabel = 'Custom Blocks';
    
    protected static ?string $modelLabel = 'Custom Block';
    
    protected static ?string $pluralModelLabel = 'Custom Blocks';
    
    protected static string|\UnitEnum|null $navigationGroup = 'Design System';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('Block Builder')
                    ->tabs([
                        Tab::make('Basic Info')
                            ->schema([
                                Section::make('Block Details')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('name')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->placeholder('e.g., Feature Card, Hero Section')
                                                    ->helperText('A descriptive name for this block'),
                                                
                                                TextInput::make('slug')
                                                    ->maxLength(255)
                                                    ->helperText('Auto-generated from name, or customize')
                                                    ->unique(CustomBlock::class, 'slug', ignoreRecord: true),
                                            ]),
                                        
                                        Textarea::make('description')
                                            ->rows(3)
                                            ->placeholder('Describe what this block does...')
                                            ->helperText('Description shown in the block manager'),
                                        
                                        Grid::make(3)
                                            ->schema([
                                                Select::make('category')
                                                    ->options(CustomBlock::getCategories())
                                                    ->default('components')
                                                    ->required(),
                                                
                                                Select::make('icon')
                                                    ->options(CustomBlock::getIcons())
                                                    ->placeholder('Choose an icon')
                                                    ->helperText('Icon shown in block manager'),
                                                
                                                Toggle::make('is_active')
                                                    ->label('Active')
                                                    ->default(true)
                                                    ->helperText('Enable/disable this block'),
                                            ]),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('sort_order')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->helperText('Order in block manager'),
                                                TagsInput::make('tags')
                                                    ->label('Tags')
                                                    ->placeholder('e.g. hero, card, form')
                                                    ->helperText('Add tags to help search and reuse blocks'),
                                            ]),
                                    ]),
                            ]),
                        Tab::make('HTML')
                            ->schema([
                                Section::make('HTML Structure')
                                    ->description('Write the HTML structure for your block. Use data-gjs attributes for GrapesJS integration.')
                                    ->schema([
                                        CodeEditor::make('html_content')
                                            ->label('HTML Content')
                                            ->helperText('Only HTML is allowed. Use data-gjs-type="text" and data-gjs-name="unique-name" to make elements editable'),
                                    ]),
                            ]),
                        Tab::make('CSS Styling')
                            ->schema([
                                Section::make('Custom CSS')
                                    ->description('Add custom CSS styles for your block')
                                    ->schema([
                                        CodeEditor::make('css_content')
                                            ->label('CSS Content')
                                            ->helperText('CSS will be scoped to this block'),
                                    ]),
                            ]),
                        Tab::make('PHP')
                            ->schema([
                                Section::make('Custom PHP')
                                    ->description('Add custom PHP (Blade) code for advanced use. This will not be executed in the admin preview.')
                                    ->schema([
                                        CodeEditor::make('php_content')
                                            ->label('PHP Content')
                                            ->helperText('Write your PHP/Blade code here. This will only be executed on the frontend, not in the admin preview.'),
                                    ]),
                            ]),
                        Tab::make('Variables')
                            ->schema([
                                Section::make('Reusable Variables')
                                    ->description('Define variables (e.g., title, content) that can be used in your block code as {{ $variable }}.')
                                    ->schema([
                                        KeyValue::make('variables')
                                            ->label('Variables')
                                            ->keyLabel('Variable Name')
                                            ->valueLabel('Default Value')
                                            ->addActionLabel('Add Variable')
                                            ->helperText('Define variables that can be used in your HTML, CSS, or PHP/Blade code.'),
                                    ]),
                            ]),
                        Tab::make('Preview')
                            ->schema([
                                Section::make('Block Preview')
                                    ->description('See how your block will look')
                                    ->schema([
                                        Placeholder::make('preview')
                                            ->content(function ($record) {
                                                if (!$record || !$record->html_content) {
                                                    return view('filament.components.block-preview-empty');
                                                }
                                                $content = $record->getCompleteContent();
                                                return view('filament.components.block-preview', ['content' => $content]);
                                            })
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Examples & Help')
                            ->schema([
                                Section::make('Block Examples & Conventions')
                                    ->description('Reference for building custom blocks')
                                    ->schema([
                                        Placeholder::make('examples_help')
                                            ->content(function () {
                                                return view('filament.components.block-examples-help');
                                            })
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        // Other tabs temporarily removed for debugging
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
                
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'layouts' => 'primary',
                        'content' => 'success',
                        'media' => 'warning',
                        'forms' => 'info',
                        'components' => 'gray',
                        default => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                
                Tables\Columns\TagsColumn::make('tags')
                    ->label('Tags'),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options(CustomBlock::getCategories()),
                
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('clone')
                    ->label('Clone')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function ($record, $livewire) {
                        $newBlock = $record->replicate();
                        $newBlock->name = $record->name . ' (Copy)';
                        $newBlock->slug = $record->slug . '-copy-' . uniqid();
                        $newBlock->push();
                        $livewire->redirect(CustomBlockResource::getUrl('edit', ['record' => $newBlock->getKey()]));
                    })
                    ->color('secondary'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('export')
                        ->label('Export as JSON')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action(function ($records) {
                            $json = $records->toJson(JSON_PRETTY_PRINT);
                            return response($json)
                                ->header('Content-Type', 'application/json')
                                ->header('Content-Disposition', 'attachment; filename=custom-blocks-export.json');
                        }),
                    Tables\Actions\BulkAction::make('import')
                        ->label('Import from JSON')
                        ->icon('heroicon-o-arrow-up-tray')
                        ->form([
                            Forms\Components\FileUpload::make('import_file')
                                ->label('JSON File')
                                ->acceptedFileTypes(['application/json'])
                                ->required(),
                        ])
                        ->action(function ($data, $livewire) {
                            $file = $data['import_file'];
                            $json = file_get_contents($file->getRealPath());
                            $blocks = json_decode($json, true);
                            foreach ($blocks as $block) {
                                \App\Models\CustomBlock::create($block);
                            }
                            $livewire->notify('success', 'Blocks imported successfully!');
                        }),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
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
            'index' => Pages\ListCustomBlocks::route('/'),
            'create' => Pages\CreateCustomBlock::route('/create'),
            'edit' => Pages\EditCustomBlock::route('/{record}/edit'),
        ];
    }
}
