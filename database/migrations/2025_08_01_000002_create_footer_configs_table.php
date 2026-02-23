<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('footer_configs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->enum('layout', ['standard', 'centered', 'minimal', 'extended', 'split'])->default('standard');
            $table->json('layout_config')->nullable();
            $table->boolean('show_brand_section')->default(true);
            $table->boolean('show_quick_links')->default(true);
            $table->boolean('show_social_links')->default(true);
            $table->boolean('show_newsletter')->default(false);
            $table->boolean('show_contact_info')->default(true);
            $table->boolean('show_copyright')->default(true);
            $table->boolean('show_powered_by')->default(false);
            $table->string('logo_text')->nullable();
            $table->string('logo_image')->nullable();
            $table->enum('logo_position', ['left', 'center', 'right'])->default('left');
            $table->integer('logo_size')->default(32);
            $table->text('brand_description')->nullable();
            $table->integer('quick_links_columns')->default(3);
            $table->string('quick_links_title')->default('Quick Links');
            $table->json('quick_links')->nullable();
            $table->string('social_links_title')->default('Follow Us');
            $table->json('social_links')->nullable();
            $table->string('newsletter_title')->default('Subscribe to our newsletter');
            $table->text('newsletter_description')->nullable();
            $table->string('newsletter_placeholder')->default('Enter your email');
            $table->string('newsletter_button_text')->default('Subscribe');
            $table->string('contact_title')->default('Contact Info');
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('contact_address')->nullable();
            $table->string('copyright_text')->default('© 2024 All rights reserved.');
            $table->string('powered_by_text')->nullable();
            $table->string('background_color')->default('#1f2937');
            $table->string('dark_background_color')->nullable();
            $table->string('text_color')->default('#ffffff');
            $table->string('dark_text_color')->nullable();
            $table->string('accent_color')->default('#3b82f6');
            $table->string('dark_accent_color')->nullable();
            $table->string('border_color')->default('#374151');
            $table->string('dark_border_color')->nullable();
            $table->integer('border_width')->default(1);
            $table->string('shadow')->default('lg');
            $table->string('font_family')->default('Inter');
            $table->string('font_weight')->default('400');
            $table->integer('font_size')->default(14);
            $table->integer('padding_y')->default(64);
            $table->integer('padding_x')->default(24);
            $table->integer('section_spacing')->default(32);
            $table->integer('grid_columns_desktop')->default(4);
            $table->integer('grid_columns_tablet')->default(2);
            $table->integer('grid_columns_mobile')->default(1);
            $table->boolean('dark_mode_enabled')->default(true);
            $table->string('dark_mode_style')->default('auto');
            $table->text('custom_css')->nullable();
            $table->string('brand_position')->default('left');
            $table->string('social_position')->default('right');
            $table->string('menu_position')->default('center');
            $table->string('copyright_position')->default('bottom');
            $table->string('newsletter_position')->default('center');
            $table->string('contact_position')->default('right');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_default')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->index(['is_active', 'is_default']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('footer_configs');
    }
};
