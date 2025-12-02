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
            $table->string('genre')->nullable()->after('artist');
            $table->unsignedBigInteger('views')->default(0)->after('url');
            $table->float('rating_avg')->default(0)->after('views');
            $table->unsignedInteger('reviews_count')->default(0)->after('rating_avg');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            $table->dropColumn(['genre', 'views', 'rating_avg', 'reviews_count']);
        });
    }
};
