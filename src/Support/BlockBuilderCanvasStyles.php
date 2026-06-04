<?php

namespace LaraGrape\Support;

use Illuminate\Support\Facades\Vite;
use Throwable;

/**
 * Same front-end canvas assets as the GrapesJS editor (app.css, site.css, theme vars, utilities).
 */
class BlockBuilderCanvasStyles
{
    /**
     * @return list<string> CSS URLs or inline <style>...</style> strings for iframe / head injection.
     */
    public static function styles(): array
    {
        $styles = [];

        $tailwindModel = HostModelResolver::tailwindConfig();

        try {
            $tailwindConfig = $tailwindModel::getActive();
            if ($tailwindConfig) {
                $styles[] = '<style>'.str_replace('</style>', '<\/style>', $tailwindConfig->generateCss()).'</style>';
            }
        } catch (Throwable) {
            // Database may be unavailable during package discovery.
        }

        foreach (['resources/css/app.css', 'resources/css/site.css'] as $entry) {
            try {
                $styles[] = Vite::asset($entry);
            } catch (Throwable) {
                // Run npm run build in the host app.
            }
        }

        $utilitiesPath = public_path('css/laralgrape-utilities.css');
        if (is_file($utilitiesPath)) {
            $utilities = file_get_contents($utilitiesPath);
            if (is_string($utilities) && $utilities !== '') {
                $styles[] = '<style>'.str_replace('</style>', '<\/style>', $utilities).'</style>';
            }
        }

        return $styles;
    }

    public static function hasViteAssets(): bool
    {
        foreach (static::styles() as $style) {
            if (is_string($style) && str_ends_with($style, '.css')) {
                return true;
            }
        }

        return false;
    }
}
