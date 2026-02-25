<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Fixes: NOT NULL constraint failed on html_content when creating custom blocks with empty HTML.
     */
    public function up(): void
    {
        Schema::table('custom_blocks', function (Blueprint $table) {
            $table->longText('html_content')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_blocks', function (Blueprint $table) {
            $table->longText('html_content')->nullable(false)->change();
        });
    }
};
