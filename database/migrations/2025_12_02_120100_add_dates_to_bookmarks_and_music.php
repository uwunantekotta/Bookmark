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
        Schema::table('bookmarks', function (Blueprint $table) {
            $table->date('release_date')->nullable()->after('genre');
            $table->timestamp('uploaded_at')->nullable()->after('release_date');
        });

        Schema::table('music', function (Blueprint $table) {
            $table->date('release_date')->nullable()->after('artist');
            $table->timestamp('uploaded_at')->nullable()->after('release_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            $table->dropColumn(['release_date', 'uploaded_at']);
        });

        Schema::table('music', function (Blueprint $table) {
            $table->dropColumn(['release_date', 'uploaded_at']);
        });
    }
};
