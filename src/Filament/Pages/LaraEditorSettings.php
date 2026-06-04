<?php

namespace LaraGrape\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
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

/**
 * Standalone LaraGrape / GrapesJS editor settings (not Site Settings).
 *
 * @see https://filamentphp.com/docs/panels/pages
 */
class LaraEditorSettings extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'LaraGrape editor';

    protected static ?string $title = 'LaraGrape editor';

    protected static ?string $slug = 'laragrape-editor';

    protected static string|\UnitEnum|null $navigationGroup = 'Design System';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationParentItem = null;

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
                Section::make('GrapesJS block sidebar')
                    ->description('These options apply to the page builder block list (admin and frontend editor). They are stored separately from Site Settings.')
                    ->schema([
                        Toggle::make('block_preview_tooltips')
                            ->label('Block preview tooltips')
                            ->helperText(
                                'Show a small hover popover with description and styled preview when pointing at a block in the GrapesJS sidebar.',
                            )
                            ->default(true),
                    ]),
                Section::make('Page editing modes')
                    ->description('Control whether pages are edited with the visual GrapesJS canvas, the backend block list builder, or both.')
                    ->schema([
                        Toggle::make('block_builder_enabled')
                            ->label('Enable block style builder')
                            ->helperText('When off, the block list builder is hidden everywhere.')
                            ->default(false)
                            ->live(),
                        Select::make('editor_mode_policy')
                            ->label('Editor mode policy')
                            ->options([
                                EditorSettingsStore::POLICY_VISUAL_ONLY => 'Visual only — GrapesJS in admin; frontend editing allowed',
                                EditorSettingsStore::POLICY_BLOCK_ONLY => 'Block only — block list in admin; no frontend GrapesJS',
                                EditorSettingsStore::POLICY_BOTH => 'Both — per-page choice of visual or block in admin; frontend visual',
                                EditorSettingsStore::POLICY_VISUAL => 'Visual (default) — visual editor; new pages default to visual',
                                EditorSettingsStore::POLICY_BLOCK => 'Block (default) — block builder when enabled; new pages default to block',
                            ])
                            ->default(EditorSettingsStore::POLICY_VISUAL_ONLY)
                            ->required()
                            ->helperText('Block only disables the frontend edit bar and GrapesJS assets on public pages.'),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();
        EditorSettingsStore::persist($data);

        Notification::make()
            ->title('LaraGrape editor settings saved')
            ->success()
            ->send();
    }

    public function getTitle(): string|Htmlable
    {
        return static::$title ?? 'LaraGrape editor';
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
