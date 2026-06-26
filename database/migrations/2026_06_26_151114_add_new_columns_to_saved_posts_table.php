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
            // `platform` already exists on this table, so it is intentionally
            // not re-added here.
            if (! Schema::hasColumn('saved_posts', 'tone')) {
                $table->string('tone')->nullable()->after('platform');
            }

            if (! Schema::hasColumn('saved_posts', 'image_prompt')) {
                $table->text('image_prompt')->nullable()->after('tone');
            }

            if (! Schema::hasColumn('saved_posts', 'is_posted')) {
                $table->boolean('is_posted')->default(false)->after('is_shared');
            }

            if (! Schema::hasColumn('saved_posts', 'posted_at')) {
                $table->timestamp('posted_at')->nullable()->after('shared_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('saved_posts', function (Blueprint $table) {
            $table->dropColumn(['tone', 'image_prompt', 'is_posted', 'posted_at']);
        });
    }
};
