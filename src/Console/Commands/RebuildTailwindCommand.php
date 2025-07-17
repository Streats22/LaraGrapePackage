<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TailwindConfig;

class RebuildTailwindCommand extends Command
{
    protected $signature = 'tailwind:rebuild';
    protected $description = 'Export Tailwind config from DB and rebuild CSS';

    public function handle()
    {
        $this->info('🎨 Rebuilding Tailwind CSS with dynamic configuration...');

        try {
            $config = TailwindConfig::where('is_active', true)->first();
            if (!$config) {
                $this->error('❌ No active Tailwind config found.');
                $this->warn('💡 Please create and activate a Tailwind configuration in the admin panel first.');
                return 1;
            }

            $this->info("📋 Using configuration: {$config->name}");

            // Write config to JS file
            try {
                file_put_contents(
                    base_path('tailwind.config.js'),
                    $config->config_json
                );
                $this->info('✅ Exported Tailwind config to tailwind.config.js.');
            } catch (\Exception $e) {
                $this->warn('⚠️  Failed to write tailwind.config.js: ' . $e->getMessage());
            }

        // Generate dynamic utility classes CSS
        $utilityCss = $config->generateUtilityClassesCss();
        $utilityCssPath = resource_path('css/laralgrape-utilities.css');
        
        // Ensure the CSS directory exists
        $cssDir = dirname($utilityCssPath);
        if (!is_dir($cssDir)) {
            mkdir($cssDir, 0755, true);
        }
        
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
        
        // Ensure the public CSS directory exists
        $publicSiteCssPath = public_path('css/site.css');
        $publicCssDir = dirname($publicSiteCssPath);
        if (!is_dir($publicCssDir)) {
            mkdir($publicCssDir, 0755, true);
        }
        copy($siteCssPath, $publicSiteCssPath);
        $this->info('Copied site.css to public/css.');

        // Generate dynamic admin/theme.css themeable rules
        $adminThemeCss = $config->generateAdminThemeCss();
        $adminCssPath = resource_path('css/filament/admin/theme.css');
        
        // Ensure the admin CSS directory exists
        $adminCssDir = dirname($adminCssPath);
        if (!is_dir($adminCssDir)) {
            mkdir($adminCssDir, 0755, true);
        }
        
        $adminCssContent = file_exists($adminCssPath) ? file_get_contents($adminCssPath) : '';
        $adminCssContent = preg_replace(
            '/\/\* DYNAMIC THEME START \*\/(.*?)\/\* DYNAMIC THEME END \*\//s',
            '',
            $adminCssContent
        );
        $adminCssContent = rtrim($adminCssContent) . "\n/* DYNAMIC THEME START */\n" . $adminThemeCss . "\n/* DYNAMIC THEME END */\n";
        file_put_contents($adminCssPath, $adminCssContent);
        $this->info('Wrote dynamic themeable rules to admin/theme.css.');
        
        // Ensure the public admin CSS directory exists
        $publicAdminCssPath = public_path('css/filament/admin/theme.css');
        $publicAdminCssDir = dirname($publicAdminCssPath);
        if (!is_dir($publicAdminCssDir)) {
            mkdir($publicAdminCssDir, 0755, true);
        }
        copy($adminCssPath, $publicAdminCssPath);
        $this->info('Copied admin/theme.css to public/css/filament/admin.');

        // Copy utility CSS to public for app and GrapesJS
        $publicCssPath = public_path('css/laralgrape-utilities.css');
        copy($utilityCssPath, $publicCssPath);
        $this->info('Copied laralgrape-utilities.css to public/css.');

        $this->info('🎉 Theme files and utilities updated successfully!');
        $this->info('📋 Next steps:');
        $this->info('   1. Run `npm run build` to rebuild frontend assets');
        $this->info('   2. Clear browser cache to see changes');
        $this->info('   3. Restart your development server if needed');

        return 0;
        } catch (\Exception $e) {
            $this->error('❌ Tailwind rebuild failed: ' . $e->getMessage());
            $this->warn('💡 Please check your configuration and try again.');
            return 1;
        }
    }
}
