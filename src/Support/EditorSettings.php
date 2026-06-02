<?php

namespace LaraGrape\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class EditorSettings
{
    public const KEY_BLOCK_PREVIEW_TOOLTIPS = 'editor_block_preview_tooltips';

    /**
     * @return class-string<\LaraGrape\Models\SiteSettings|\App\Models\SiteSettings>
     */
    protected static function siteSettingsModel(): string
    {
        if (class_exists(\App\Models\SiteSettings::class)) {
            return \App\Models\SiteSettings::class;
        }

        return \LaraGrape\Models\SiteSettings::class;
    }

    public static function blockPreviewTooltipsEnabled(): bool
    {
        return (bool) static::resolve(
            self::KEY_BLOCK_PREVIEW_TOOLTIPS,
            config('laragrape.editor.block_preview_tooltips', true),
        );
    }

    /**
     * Values for the Filament editor settings form.
     *
     * @return array{block_preview_tooltips: bool}
     */
    public static function formDefaults(): array
    {
        return [
            'block_preview_tooltips' => static::blockPreviewTooltipsEnabled(),
        ];
    }

    /**
     * Settings passed into grapesjs-editor.js (Filament + frontend).
     *
     * @return array{blockPreviewTooltips: bool}
     */
    public static function forJs(): array
    {
        return [
            'blockPreviewTooltips' => static::blockPreviewTooltipsEnabled(),
        ];
    }

    /**
     * @param  array{block_preview_tooltips?: bool}  $data
     */
    public static function persist(array $data): void
    {
        $model = static::siteSettingsModel();

        if (! Schema::hasTable('site_settings')) {
            return;
        }

        $model::set(
            self::KEY_BLOCK_PREVIEW_TOOLTIPS,
            (bool) ($data['block_preview_tooltips'] ?? true),
        );

        static::ensureSettingRecord(
            self::KEY_BLOCK_PREVIEW_TOOLTIPS,
            'Block preview tooltips',
            'editor',
            'Show hover popovers with block description and styled preview in the GrapesJS block panel.',
        );

        Cache::forget('site_settings_all');
    }

    protected static function resolve(string $key, mixed $default): mixed
    {
        if (! Schema::hasTable('site_settings')) {
            return $default;
        }

        try {
            $model = static::siteSettingsModel();
            $stored = $model::get($key, null);

            if ($stored !== null) {
                return static::toBool($stored);
            }
        } catch (\Throwable) {
            return $default;
        }

        return $default;
    }

    protected static function toBool(mixed $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (bool) $value;
        }

        $filtered = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        return $filtered ?? (bool) $value;
    }

    protected static function ensureSettingRecord(
        string $key,
        string $label,
        string $group,
        string $description,
    ): void {
        $model = static::siteSettingsModel();

        $model::firstOrCreate(
            ['key' => $key],
            [
                'label' => $label,
                'value' => static::blockPreviewTooltipsEnabled(),
                'type' => 'boolean',
                'group' => $group,
                'description' => $description,
                'sort_order' => 1,
            ],
        );
    }
}
