<?php

namespace LaraGrape\Console\Commands;

use Illuminate\Console\Command;
use LaraGrape\Models\TailwindConfig;

class RebuildTailwindCommand extends Command
{
    protected $signature = 'tailwind:rebuild';
    protected $description = 'Export Tailwind config from DB and rebuild CSS';

    public function handle()
    {
        $config = TailwindConfig::where('is_active', true)->first();
        if (!$config) {
            $this->error('No active Tailwind config found.');
            return 1;
        }

        // Write config to JS file
        file_put_contents(
            base_path('tailwind.config.js'),
            $config->config_json // Adjust if your config is stored differently
        );

        $this->info('Exported Tailwind config.');

        // Generate dynamic utility classes CSS
        $utilityCss = $config->generateUtilityClassesCss();
        $utilityCssPath = resource_path('css/laralgrape-utilities.css');
        file_put_contents($utilityCssPath, $utilityCss);
        $this->info('Generated laralgrape-utilities.css.');

        // Generate dynamic site.css themeable rules
        $siteThemeCss = $config->generateSiteThemeCss();
        $siteCssPath = resource_path('css/site.css');
        $siteCssContent = file_exists($siteCssPath) ? file_get_contents($siteCssPath) : '';
        $siteCssContent = preg_replace(
            '/\/\* DYNAMIC THEME START \*\/(.*?)\/\* DYNAMIC THEME END \*\//s',
            '',
            $siteCssContent
        );
        $siteCssContent = rtrim($siteCssContent) . "\n/* DYNAMIC THEME START */\n" . $siteThemeCss . "\n/* DYNAMIC THEME END */\n";
        file_put_contents($siteCssPath, $siteCssContent);
        $this->info('Wrote dynamic themeable rules to site.css.');
        $publicSiteCssPath = public_path('css/site.css');
        copy($siteCssPath, $publicSiteCssPath);
        $this->info('Copied site.css to public/css.');

        // Generate dynamic admin/theme.css themeable rules
        $adminThemeCss = $config->generateAdminThemeCss();
        $adminCssPath = resource_path('css/filament/admin/theme.css');
        $adminCssContent = file_exists($adminCssPath) ? file_get_contents($adminCssPath) : '';
        $adminCssContent = preg_replace(
            '/\/\* DYNAMIC THEME START \*\/(.*?)\/\* DYNAMIC THEME END \*\//s',
            '',
            $adminCssContent
        );
        $adminCssContent = rtrim($adminCssContent) . "\n/* DYNAMIC THEME START */\n" . $adminThemeCss . "\n/* DYNAMIC THEME END */\n";
        file_put_contents($adminCssPath, $adminCssContent);
        $this->info('Wrote dynamic themeable rules to admin/theme.css.');
        $publicAdminCssPath = public_path('css/filament/admin/theme.css');
        copy($adminCssPath, $publicAdminCssPath);
        $this->info('Copied admin/theme.css to public/css/filament/admin.');

        // Copy utility CSS to public for app and GrapesJS
        $publicCssPath = public_path('css/laralgrape-utilities.css');
        copy($utilityCssPath, $publicCssPath);
        $this->info('Copied laralgrape-utilities.css to public/css.');

        $this->info('Theme files and utilities updated. Please run `npm run build` on the server to rebuild frontend assets.');

        return 0;
    }
}
