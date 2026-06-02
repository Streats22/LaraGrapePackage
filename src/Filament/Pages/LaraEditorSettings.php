<?php

namespace LaraGrape\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Support\Htmlable;
use LaraGrape\Support\EditorSettings as EditorSettingsStore;

class LaraEditorSettings extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Editor settings';

    protected static ?string $title = 'GrapesJS editor';

    protected static ?string $slug = 'editor-settings';

    protected static string|\UnitEnum|null $navigationGroup = 'Design System';

    protected static ?int $navigationSort = 15;

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $this->form->fill(EditorSettingsStore::formDefaults());
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Block sidebar')
                    ->description('Options for the GrapesJS block list in the page builder.')
                    ->schema([
                        Toggle::make('block_preview_tooltips')
                            ->label('Block preview tooltips')
                            ->helperText(
                                'When enabled, hovering or clicking a block in the sidebar shows a small popover with a description and styled preview (uses your Tailwind theme).',
                            )
                            ->default(true),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();
        EditorSettingsStore::persist($data);

        Notification::make()
            ->title('Editor settings saved')
            ->success()
            ->send();
    }

    public function getTitle(): string|Htmlable
    {
        return static::$title ?? 'GrapesJS editor';
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            $this->getFormContentComponent(),
        ]);
    }

    public function getFormContentComponent(): Component
    {
        return Form::make([EmbeddedSchema::make('form')])
            ->id('laragrape-editor-settings-form')
            ->livewireSubmitHandler('save')
            ->footer([
                Actions::make($this->getFormActions())
                    ->alignment($this->getFormActionsAlignment())
                    ->key('laragrape-editor-settings-actions'),
            ]);
    }

    /**
     * @return array<Action>
     */
    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save settings')
                ->submit('save'),
        ];
    }

    public function getFormActionsAlignment(): Alignment|string
    {
        return Alignment::Start;
    }
}
