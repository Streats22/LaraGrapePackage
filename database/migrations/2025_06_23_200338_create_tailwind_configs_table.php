<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tailwind_configs', function (Blueprint $table) {
            $table->id();
            
            // Basic info
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(false);
            
            // Primary colors
            $table->string('primary_50')->nullable();
            $table->string('primary_100')->nullable();
            $table->string('primary_200')->nullable();
            $table->string('primary_300')->nullable();
            $table->string('primary_400')->nullable();
            $table->string('primary_500')->nullable();
            $table->string('primary_600')->nullable();
            $table->string('primary_700')->nullable();
            $table->string('primary_800')->nullable();
            $table->string('primary_900')->nullable();
            $table->string('primary_950')->nullable();
            
            // Additional colors
            $table->string('secondary_color')->nullable();
            $table->string('accent_color')->nullable();
            $table->string('success_color')->nullable();
            $table->string('warning_color')->nullable();
            $table->string('error_color')->nullable();
            $table->string('info_color')->nullable();
            
            // Typography
            $table->text('font_family_sans')->nullable();
            $table->text('font_family_serif')->nullable();
            $table->text('font_family_mono')->nullable();
            $table->string('font_size_base')->nullable();
            $table->string('line_height_base')->nullable();
            $table->string('font_weight_base')->nullable();
            
            // Spacing & Layout
            $table->string('spacing_unit')->nullable();
            $table->string('container_padding')->nullable();
            $table->string('border_radius_default')->nullable();
            $table->string('border_radius_lg')->nullable();
            
            // Breakpoints
            $table->string('breakpoint_sm')->nullable();
            $table->string('breakpoint_md')->nullable();
            $table->string('breakpoint_lg')->nullable();
            $table->string('breakpoint_xl')->nullable();
            
            // Custom CSS
            $table->boolean('enable_custom_css')->default(false);
            $table->longText('custom_css')->nullable();
            
            // Advanced settings
            $table->boolean('enable_dark_mode')->default(false);
            $table->boolean('enable_animations')->default(true);
            $table->string('css_variables_prefix')->default('--laralgrape');
            $table->boolean('purge_css')->default(true);
            $table->boolean('minify_css')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tailwind_configs');
    }
};
