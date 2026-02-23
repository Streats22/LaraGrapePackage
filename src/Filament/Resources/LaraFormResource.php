<?php

namespace LaraGrape\Filament\Resources;

use LaraGrape\Filament\Resources\FormResource\Pages;
use LaraGrape\Models\Form;
use LaraGrape\Models\FormField;
use Filament\Forms;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class LaraFormResource extends Resource
{
    protected static ?string $model = Form::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static string|\UnitEnum|null $navigationGroup = 'Form Builder';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Form Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $state, callable $set) => $set('slug', Str::slug($state))),
                        
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('This will be used to identify the form in your code.'),
                        
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Email Settings')
                    ->schema([
                        Forms\Components\TextInput::make('email_to')
                            ->email()
                            ->helperText('Email address where form submissions will be sent.'),
                        
                        Forms\Components\TextInput::make('subject_template')
                            ->maxLength(255)
                            ->helperText('Email subject template. Use {form_name} for form name, {submission_date} for submission date.'),
                        
                        Forms\Components\Toggle::make('send_email_notification')
                            ->label('Send email notifications')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Messages')
                    ->schema([
                        Forms\Components\Textarea::make('success_message')
                            ->required()
                            ->maxLength(65535)
                            ->default('Thank you! Your form has been submitted successfully.'),
                        
                        Forms\Components\Textarea::make('error_message')
                            ->required()
                            ->maxLength(65535)
                            ->default('Sorry, there was an error submitting your form. Please try again.'),
                    ])
                    ->columns(2),

                Section::make('Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        
                        Forms\Components\Toggle::make('store_submissions')
                            ->label('Store submissions in database')
                            ->default(true)
                            ->helperText('If disabled, submissions will only be sent via email.'),
                    ])
                    ->columns(2),

                Section::make('Form Fields')
                    ->description('Add and configure form fields. Drag to reorder.')
                    ->schema([
                        Forms\Components\Repeater::make('fields')
                            ->relationship('fields')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\Select::make('type')
                                            ->options(FormField::getFieldTypes())
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(fn (callable $set) => $set('options', []))
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('sort_order')
                                            ->numeric()
                                            ->default(0)
                                            ->columnSpan(1),
                                    ]),

                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('label')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('e.g., Full Name, Email Address')
                                            ->helperText('Display label for the field'),

                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('e.g., full_name, email')
                                            ->helperText('Field name for form submission (use lowercase, no spaces)'),
                                    ]),

                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('placeholder')
                                            ->maxLength(255)
                                            ->placeholder('e.g., Enter your full name')
                                            ->helperText('Placeholder text shown in the field'),

                                        Forms\Components\Toggle::make('is_required')
                                            ->label('Required field')
                                            ->helperText('Make this field mandatory'),
                                    ]),

                                Forms\Components\Textarea::make('help_text')
                                    ->maxLength(65535)
                                    ->placeholder('e.g., Please enter your full legal name')
                                    ->helperText('Additional help text shown below the field')
                                    ->rows(2),

                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\Toggle::make('is_unique')
                                            ->label('Unique value')
                                            ->helperText('Ensure this field value is unique across all submissions'),

                                        Forms\Components\TagsInput::make('validation_rules')
                                            ->separator(',')
                                            ->placeholder('e.g., min:3, max:255, email')
                                            ->helperText('Additional Laravel validation rules'),
                                    ]),

                                // Options for select, radio, checkbox fields
                                Section::make('Field Options')
                                    ->description('Configure options for select, radio, and checkbox fields')
                                    ->schema([
                                        Forms\Components\Repeater::make('options')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('label')
                                                            ->required()
                                                            ->maxLength(255)
                                                            ->placeholder('e.g., Option 1')
                                                            ->helperText('Display label for the option'),

                                                        Forms\Components\TextInput::make('value')
                                                            ->required()
                                                            ->maxLength(255)
                                                            ->placeholder('e.g., option_1')
                                                            ->helperText('Value submitted when this option is selected'),
                                                    ]),
                                            ])
                                            ->columns(1)
                                            ->defaultItems(0)
                                            ->addActionLabel('Add Option')
                                            ->reorderableWithButtons()
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? 'Option'),
                                    ])
                                    ->visible(fn ($get) => in_array($get('type'), ['select', 'radio', 'checkbox']))
                                    ->collapsed(),
                            ])
                            ->columns(1)
                            ->orderable('sort_order')
                            ->defaultItems(0)
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? 'Unnamed Field')
                            ->addActionLabel('Add Field')
                            ->cloneable()
                            ->collapsed(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('fields_count')
                    ->counts('fields')
                    ->label('Fields')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('submissions_count')
                    ->counts('submissions')
                    ->label('Submissions')
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('send_email_notification')
                    ->boolean()
                    ->label('Email Notifications')
                    ->sortable(),
                
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
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Forms'),
                
                Tables\Filters\TernaryFilter::make('send_email_notification')
                    ->label('Email Notifications'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\Action::make('view_submissions')
                    ->label('Submissions')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Form $record): string => route('filament.admin.resources.form-submissions.index', ['tableFilters[form_id][value]' => $record->id]))
                    ->visible(fn (Form $record) => $record->store_submissions),
                \Filament\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Form $record): string => route('form.preview', $record))
                    ->openUrlInNewTab(),
                \Filament\Actions\Action::make('clone')
                    ->label('Clone')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function ($record, $livewire) {
                        $newForm = $record->replicate();
                        $newForm->name = $record->name . ' (Copy)';
                        $newForm->slug = $record->slug . '-copy-' . uniqid();
                        $newForm->is_active = false; // Clone as inactive by default
                        $newForm->push();
                        
                        // Clone the fields
                        foreach ($record->fields as $field) {
                            $newField = $field->replicate();
                            $newField->form_id = $newForm->id;
                            $newField->push();
                        }
                        
                        $livewire->notify('success', 'Form cloned successfully!');
                        $livewire->redirect(static::getUrl('edit', ['record' => $newForm->getKey()]));
                    })
                    ->color('secondary'),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                    \Filament\Actions\BulkAction::make('activate')
                        ->label('Activate')
                        ->icon('heroicon-o-check-circle')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_active' => true]);
                            });
                        })
                        ->color('success')
                        ->visible(fn () => true),
                    \Filament\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate')
                        ->icon('heroicon-o-x-circle')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_active' => false]);
                            });
                        })
                        ->color('danger')
                        ->visible(fn () => true),
                ]),
            ]);
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
            'index' => Pages\LaraListForms::route('/'),
            'create' => Pages\LaraCreateForm::route('/create'),
            'edit' => Pages\LaraEditForm::route('/{record}/edit'),
        ];
    }
}
