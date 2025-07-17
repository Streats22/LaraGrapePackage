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
        Schema::create('custom_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('category')->default('components'); // layouts, content, media, forms, components
            $table->longText('html_content');
            $table->longText('css_content')->nullable();
            $table->longText('js_content')->nullable();
            $table->json('attributes')->nullable(); // GrapesJS attributes
            $table->string('icon')->nullable(); // Icon for block manager
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('settings')->nullable(); // Block-specific settings
            $table->json('tags')->nullable();
            $table->json('variables')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_blocks');
    }
};
