<?php

namespace LaraGrape\Support;

use App\Models\Form as AppForm;
use App\Models\LaragrapeEditorSetting as AppLaragrapeEditorSetting;
use App\Models\Page as AppPage;
use App\Models\TailwindConfig as AppTailwindConfig;
use LaraGrape\Models\Form as PackageForm;
use LaraGrape\Models\LaragrapeEditorSetting as PackageLaragrapeEditorSetting;
use LaraGrape\Models\Page as PackagePage;
use LaraGrape\Models\TailwindConfig as PackageTailwindConfig;

/**
 * Resolves published App model classes vs package defaults for multi-app installs.
 */
final class HostModelResolver
{
    /**
     * @param  class-string  $packageClass
     * @param  class-string  $appClass
     * @return class-string
     */
    public static function resolve(string $packageClass, string $appClass): string
    {
        return class_exists($appClass) ? $appClass : $packageClass;
    }

    /** @return class-string */
    public static function tailwindConfig(): string
    {
        return static::resolve(PackageTailwindConfig::class, AppTailwindConfig::class);
    }

    /** @return class-string */
    public static function laragrapeEditorSetting(): string
    {
        return static::resolve(PackageLaragrapeEditorSetting::class, AppLaragrapeEditorSetting::class);
    }

    /** @return class-string */
    public static function form(): string
    {
        return static::resolve(PackageForm::class, AppForm::class);
    }

    /** @return class-string */
    public static function page(): string
    {
        return static::resolve(PackagePage::class, AppPage::class);
    }
}
