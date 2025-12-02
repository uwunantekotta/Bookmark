<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            // Check if user_id exists, if not add it
            if (!Schema::hasColumn('bookmarks', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
            }
            
            // Check if image exists, if not add it
            if (!Schema::hasColumn('bookmarks', 'image')) {
                $table->string('image')->nullable()->after('url');
            }
            
            // Ensure views and ratings exist
            if (!Schema::hasColumn('bookmarks', 'views')) {
                $table->integer('views')->default(0);
                $table->float('rating_avg')->default(0);
                $table->integer('reviews_count')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'image', 'views', 'rating_avg', 'reviews_count']);
        });
    }
};