<?php

namespace LaraGrape\Support;

use Illuminate\Support\Facades\Schema;

class EditorSettings
{
    public const KEY_BLOCK_PREVIEW_TOOLTIPS = 'block_preview_tooltips';

    /**
     * @return class-string<\LaraGrape\Models\LaragrapeEditorSetting|\App\Models\LaragrapeEditorSetting>
     */
    protected static function model(): string
    {
        if (class_exists(\App\Models\LaragrapeEditorSetting::class)) {
            return \App\Models\LaragrapeEditorSetting::class;
        }

        return \LaraGrape\Models\LaragrapeEditorSetting::class;
    }

    public static function blockPreviewTooltipsEnabled(): bool
    {
        return static::toBool(static::resolve(
            self::KEY_BLOCK_PREVIEW_TOOLTIPS,
            config('laragrape.editor.block_preview_tooltips', true),
        ));
    }

    /**
     * @return array{block_preview_tooltips: bool}
     */
    public static function formDefaults(): array
    {
        return [
            'block_preview_tooltips' => static::blockPreviewTooltipsEnabled(),
        ];
    }

    /**
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
        if (! Schema::hasTable('laragrape_editor_settings')) {
            return;
        }

        static::model()::set(
            self::KEY_BLOCK_PREVIEW_TOOLTIPS,
            (bool) ($data['block_preview_tooltips'] ?? true),
        );
    }

    protected static function resolve(string $key, mixed $default): mixed
    {
        if (! Schema::hasTable('laragrape_editor_settings')) {
            return $default;
        }

        try {
            $stored = static::model()::get($key, null);

            if ($stored !== null) {
                return $stored;
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
}
