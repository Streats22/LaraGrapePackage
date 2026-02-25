<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('menu_sets')) {
            Schema::create('menu_sets', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('display_name');
                $table->text('description')->nullable();
                $table->enum('menu_type', ['header', 'footer', 'mobile', 'custom'])->default('header');
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->foreignId('menu_set_id')->nullable()->constrained('menu_sets')->onDelete('cascade');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('sort_order')->default(0);
            $table->enum('link_type', ['page', 'url', 'custom', 'dropdown'])->default('page');
            $table->string('link_url')->nullable();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onDelete('set null');
            $table->string('link_text');
            $table->string('link_title')->nullable();
            $table->boolean('open_in_new_tab')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_visible')->default(true);
            $table->string('icon')->nullable();
            $table->string('css_class')->nullable();
            $table->timestamps();
            $table->index(['menu_set_id', 'is_active', 'sort_order']);
            $table->index('parent_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('menu_sets');
    }
};
