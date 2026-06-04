<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('editor_mode', 20)->default('visual')->after('grapesjs_data');
            $table->json('block_layout')->nullable()->after('editor_mode');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['editor_mode', 'block_layout']);
        });
    }
};
