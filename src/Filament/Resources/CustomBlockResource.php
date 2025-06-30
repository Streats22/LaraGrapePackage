<?php

namespace Streats22\LaraGrape\Filament\Resources;

use Streats22\LaraGrape\Filament\Resources\CustomBlockResource\Pages;
use Streats22\LaraGrape\Filament\Resources\CustomBlockResource\RelationManagers;
use Streats22\LaraGrape\Models\CustomBlock;
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
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ViewField;

class CustomBlockResource extends Resource
{
    protected static ?string $model = CustomBlock::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    
    protected static ?string $navigationLabel = 'Custom Blocks';
    
    protected static ?string $modelLabel = 'Custom Block';
    
    protected static ?string $pluralModelLabel = 'Custom Blocks';
    
    protected static ?string $navigationGroup = 'Design System';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Block Builder')
                    ->tabs([
                        Tabs\Tab::make('Basic Info')
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
                                            ]),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('HTML Content')
                            ->schema([
                                Section::make('HTML Structure')
                                    ->description('Write the HTML structure for your block. Use data-gjs attributes for GrapesJS integration.')
                                    ->schema([
                                        CodeEditor::make('html_content')
                                            ->label('HTML Content')
                                            ->language('html')
                                            ->required()
                                            ->minHeight(400)
                                            ->placeholder('<!-- Example block structure -->
<div class="custom-block bg-white rounded-lg shadow-md p-6">
    <h3 data-gjs-type="text" data-gjs-name="title">Block Title</h3>
    <p data-gjs-type="text" data-gjs-name="description">Block description goes here</p>
    <button class="btn btn-primary" data-gjs-type="text" data-gjs-name="button-text">Click Me</button>
</div>')
                                            ->helperText('Use data-gjs-type="text" and data-gjs-name="unique-name" to make elements editable'),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('CSS Styling')
                            ->schema([
                                Section::make('Custom CSS')
                                    ->description('Add custom CSS styles for your block')
                                    ->schema([
                                        CodeEditor::make('css_content')
                                            ->label('CSS Content')
                                            ->language('css')
                                            ->minHeight(300)
                                            ->placeholder('/* Custom styles for your block */
.custom-block {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    transition: transform 0.3s ease;
}

.custom-block:hover {
    transform: translateY(-2px);
}

.custom-block h3 {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 1rem;
}

.custom-block .btn {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid white;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.custom-block .btn:hover {
    background: white;
    color: #667eea;
}')
                                            ->helperText('CSS will be scoped to this block'),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('JavaScript')
                            ->schema([
                                Section::make('Custom JavaScript')
                                    ->description('Add interactive functionality to your block')
                                    ->schema([
                                        CodeEditor::make('js_content')
                                            ->label('JavaScript Content')
                                            ->language('javascript')
                                            ->minHeight(300)
                                            ->placeholder('// Custom JavaScript for your block
document.addEventListener("DOMContentLoaded", function() {
    const block = document.querySelector(".custom-block");
    
    if (block) {
        // Add click event
        block.addEventListener("click", function() {
            console.log("Block clicked!");
        });
        
        // Add animation on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = "1";
                    entry.target.style.transform = "translateY(0)";
                }
            });
        });
        
        observer.observe(block);
    }
});')
                                            ->helperText('JavaScript will be executed when the block is loaded'),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('GrapesJS Settings')
                            ->schema([
                                Section::make('Block Attributes')
                                    ->description('Configure how this block behaves in GrapesJS')
                                    ->schema([
                                        KeyValue::make('attributes')
                                            ->label('GrapesJS Attributes')
                                            ->keyLabel('Attribute')
                                            ->valueLabel('Value')
                                            ->addActionLabel('Add Attribute')
                                            ->placeholder('Add GrapesJS attributes like draggable, droppable, etc.')
                                            ->helperText('Common attributes: draggable, droppable, removable, copyable'),
                                    ]),
                                
                                Section::make('Block Settings')
                                    ->description('Additional configuration for the block')
                                    ->schema([
                                        KeyValue::make('settings')
                                            ->label('Block Settings')
                                            ->keyLabel('Setting')
                                            ->valueLabel('Value')
                                            ->addActionLabel('Add Setting')
                                            ->placeholder('Add custom settings for your block')
                                            ->helperText('These can be used in your JavaScript or CSS'),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('Preview')
                            ->schema([
                                Section::make('Block Preview')
                                    ->description('See how your block will look')
                                    ->schema([
                                        Placeholder::make('preview')
                                            ->content(function ($record) {
                                                if (!$record || !$record->html_content) {
                                                    return '<div class="text-gray-500 text-center p-8">No content to preview</div>';
                                                }
                                                
                                                $content = $record->getCompleteContent();
                                                return view('filament.components.block-preview', ['content' => $content]);
                                            })
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
