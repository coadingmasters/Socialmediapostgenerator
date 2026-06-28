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
        Schema::table('saved_posts', function (Blueprint $table) {
            if (! Schema::hasColumn('saved_posts', 'image_url')) {
                $table->text('image_url')->nullable()->after('image_prompt');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('saved_posts', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });
    }
};
