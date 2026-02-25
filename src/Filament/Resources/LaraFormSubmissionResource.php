<?php

namespace LaraGrape\Filament\Resources;

use LaraGrape\Filament\Resources\FormSubmissionResource\Pages;
use LaraGrape\Models\FormSubmission;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LaraFormSubmissionResource extends Resource
{
    protected static ?string $model = FormSubmission::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|\UnitEnum|null $navigationGroup = 'Form Builder';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Submissions';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('form_id')
                    ->relationship('form', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\KeyValue::make('data')
                    ->label('Form Data')
                    ->keyLabel('Field')
                    ->valueLabel('Value')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('ip_address')
                    ->maxLength(255),

                Forms\Components\TextInput::make('user_agent')
                    ->maxLength(255),

                Forms\Components\Toggle::make('email_sent')
                    ->label('Email Sent'),

                Forms\Components\DateTimePicker::make('email_sent_at')
                    ->label('Email Sent At'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('form.name')
                    ->searchable()
                    ->sortable()
                    ->label('Form'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Submitted At'),

                Tables\Columns\TextColumn::make('ip_address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('email_sent')
                    ->boolean()
                    ->label('Email Sent')
                    ->sortable(),

                Tables\Columns\TextColumn::make('email_sent_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('form_id')
                    ->relationship('form', 'name')
                    ->label('Form')
                    ->searchable()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('email_sent')
                    ->label('Email Sent'),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Created From'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Created Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\Action::make('resend_email')
                    ->label('Resend Email')
                    ->icon('heroicon-o-envelope')
                    ->action(function (FormSubmission $record) {
                        // TODO: Implement email resend functionality
                    })
                    ->visible(fn (FormSubmission $record) => $record->form->send_email_notification),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\LaraListFormSubmissions::route('/'),
            'create' => Pages\LaraCreateFormSubmission::route('/create'),
            'edit' => Pages\LaraEditFormSubmission::route('/{record}/edit'),
        ];
    }
}
