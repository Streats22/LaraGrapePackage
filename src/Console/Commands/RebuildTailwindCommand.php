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
        $config = TailwindConfig::where('active', true)->first();
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

        // Run the build process
        $this->info('Building Tailwind CSS...');
        exec('npm run build', $output, $resultCode);

        if ($resultCode === 0) {
            $this->info('Tailwind CSS built successfully.');
        } else {
            $this->error('Build failed: ' . implode("\n", $output));
        }

        return $resultCode;
    }
} 