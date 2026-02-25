<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('header_configs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->enum('menu_type', ['normal', 'mega', 'dropdown', 'centered', 'minimal'])->default('normal');
            $table->json('menu_config')->nullable();
            $table->enum('layout', ['standard', 'centered', 'split', 'minimal'])->default('standard');
            $table->boolean('is_sticky')->default(true);
            $table->boolean('is_transparent')->default(false);
            $table->boolean('show_search')->default(false);
            $table->boolean('show_cta_button')->default(false);
            $table->string('cta_text')->nullable();
            $table->string('cta_url')->nullable();
            $table->string('logo_text')->nullable();
            $table->string('logo_image')->nullable();
            $table->enum('logo_position', ['left', 'center', 'right'])->default('left');
            $table->integer('logo_size')->default(32);
            $table->string('background_color')->default('#ffffff');
            $table->string('dark_background_color')->nullable();
            $table->string('text_color')->default('#1f2937');
            $table->string('dark_text_color')->nullable();
            $table->string('accent_color')->default('#3b82f6');
            $table->string('dark_accent_color')->nullable();
            $table->string('border_color')->default('#e5e7eb');
            $table->string('dark_border_color')->nullable();
            $table->integer('border_width')->default(1);
            $table->string('shadow')->default('sm');
            $table->string('font_family')->default('Inter');
            $table->string('font_weight')->default('500');
            $table->integer('font_size')->default(14);
            $table->integer('padding_y')->default(16);
            $table->integer('padding_x')->default(24);
            $table->integer('menu_spacing')->default(32);
            $table->boolean('mobile_menu_enabled')->default(true);
            $table->enum('mobile_menu_style', ['hamburger', 'fullscreen', 'slide'])->default('hamburger');
            $table->string('mobile_breakpoint')->default('md');
            $table->boolean('dark_mode_enabled')->default(true);
            $table->string('dark_mode_style')->default('auto');
            $table->text('custom_css')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_default')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->index(['is_active', 'is_default']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('header_configs');
    }
};
