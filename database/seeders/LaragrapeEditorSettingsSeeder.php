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

        $model::query()->firstOrCreate(
            ['key' => EditorSettings::KEY_BLOCK_BUILDER_ENABLED],
            ['value' => config('laragrape.editor.block_builder_enabled', false)],
        );

        $model::query()->firstOrCreate(
            ['key' => EditorSettings::KEY_EDITOR_MODE_POLICY],
            ['value' => config('laragrape.editor.editor_mode_policy', EditorSettings::POLICY_VISUAL_ONLY)],
        );

        $this->command?->info('Seeded LaraGrape editor settings.');
    }
}
