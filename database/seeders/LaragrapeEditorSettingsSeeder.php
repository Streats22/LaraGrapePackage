<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use LaraGrape\Support\EditorSettings;

class LaragrapeEditorSettingsSeeder extends Seeder
{
    public function run(): void
    {
        if (! Schema::hasTable('laragrape_editor_settings')) {
            $this->command?->warn('laragrape_editor_settings table missing; run migrations first.');

            return;
        }

        $model = class_exists(\App\Models\LaragrapeEditorSetting::class)
            ? \App\Models\LaragrapeEditorSetting::class
            : \LaraGrape\Models\LaragrapeEditorSetting::class;

        $model::query()->firstOrCreate(
            ['key' => EditorSettings::KEY_BLOCK_PREVIEW_TOOLTIPS],
            ['value' => config('laragrape.editor.block_preview_tooltips', true)],
        );

        $this->command?->info('Seeded LaraGrape editor settings.');
    }
}
