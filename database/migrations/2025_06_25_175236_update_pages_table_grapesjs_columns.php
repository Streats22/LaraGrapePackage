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
        Schema::table('pages', function (Blueprint $table) {
            // Change grapesjs_css and grapesjs_html from JSON to TEXT
            $table->text('grapesjs_css')->nullable()->change();
            $table->text('grapesjs_html')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Change back to JSON if needed
            $table->json('grapesjs_css')->nullable()->change();
            $table->json('grapesjs_html')->nullable()->change();
        });
    }
};
