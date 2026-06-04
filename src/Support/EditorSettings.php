<?php

namespace LaraGrape\Support;

use Illuminate\Support\Facades\Schema;
use Throwable;

class EditorSettings
{
    public const KEY_BLOCK_PREVIEW_TOOLTIPS = 'block_preview_tooltips';

    public const KEY_BLOCK_BUILDER_ENABLED = 'block_builder_enabled';

    public const KEY_EDITOR_MODE_POLICY = 'editor_mode_policy';

    public const POLICY_VISUAL_ONLY = 'visual_only';

    public const POLICY_BLOCK_ONLY = 'block_only';

    public const POLICY_BOTH = 'both';

    public const POLICY_VISUAL = 'visual';

    public const POLICY_BLOCK = 'block';

    public const PAGE_MODE_VISUAL = 'visual';

    public const PAGE_MODE_BLOCK = 'block';

    /**
     * @return list<string>
     */
    public static function policyOptions(): array
    {
        return [
            self::POLICY_VISUAL_ONLY,
            self::POLICY_BLOCK_ONLY,
            self::POLICY_BOTH,
            self::POLICY_VISUAL,
            self::POLICY_BLOCK,
        ];
    }

    /** @return class-string */
    protected static function model(): string
    {
        return HostModelResolver::laragrapeEditorSetting();
    }

    public static function blockPreviewTooltipsEnabled(): bool
    {
        return static::toBool(static::resolve(
            self::KEY_BLOCK_PREVIEW_TOOLTIPS,
            config('laragrape.editor.block_preview_tooltips', true),
        ));
    }

    public static function blockBuilderEnabled(): bool
    {
        return static::toBool(static::resolve(
            self::KEY_BLOCK_BUILDER_ENABLED,
            config('laragrape.editor.block_builder_enabled', false),
        ));
    }

    public static function editorModePolicy(): string
    {
        $policy = static::resolve(
            self::KEY_EDITOR_MODE_POLICY,
            config('laragrape.editor.editor_mode_policy', self::POLICY_VISUAL_ONLY),
        );

        $policy = is_string($policy) ? $policy : (string) $policy;

        return in_array($policy, static::policyOptions(), true)
            ? $policy
            : self::POLICY_VISUAL_ONLY;
    }

    public static function allowsBlockBuilder(): bool
    {
        if (! static::blockBuilderEnabled()) {
            return false;
        }

        return ! in_array(static::editorModePolicy(), [self::POLICY_VISUAL_ONLY, self::POLICY_VISUAL], true);
    }

    public static function allowsVisualEditor(): bool
    {
        return ! in_array(static::editorModePolicy(), [self::POLICY_BLOCK_ONLY, self::POLICY_BLOCK], true);
    }

    public static function allowsFrontendEditor(): bool
    {
        return static::editorModePolicy() !== self::POLICY_BLOCK_ONLY;
    }

    public static function usesPerPageEditorMode(): bool
    {
        return static::editorModePolicy() === self::POLICY_BOTH;
    }

    public static function defaultPageEditorMode(): string
    {
        return match (static::editorModePolicy()) {
            self::POLICY_BLOCK_ONLY, self::POLICY_BLOCK => self::PAGE_MODE_BLOCK,
            default => self::PAGE_MODE_VISUAL,
        };
    }

    /**
     * @return array<string, mixed>
     */
    public static function formDefaults(): array
    {
        return [
            'block_preview_tooltips' => static::blockPreviewTooltipsEnabled(),
            'block_builder_enabled' => static::blockBuilderEnabled(),
            'editor_mode_policy' => static::editorModePolicy(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function forJs(): array
    {
        return [
            'blockPreviewTooltips' => static::blockPreviewTooltipsEnabled(),
            'frontendEditorEnabled' => static::allowsFrontendEditor(),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
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

        static::model()::set(
            self::KEY_BLOCK_BUILDER_ENABLED,
            (bool) ($data['block_builder_enabled'] ?? false),
        );

        $policy = $data['editor_mode_policy'] ?? self::POLICY_VISUAL_ONLY;
        if (! in_array($policy, static::policyOptions(), true)) {
            $policy = self::POLICY_VISUAL_ONLY;
        }

        static::model()::set(self::KEY_EDITOR_MODE_POLICY, $policy);
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
        } catch (Throwable) {
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
