<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create the polymorphic ratings table
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // This creates 'rateable_id' and 'rateable_type' columns
            $table->morphs('rateable'); 
            $table->integer('rating'); // 1-5
            $table->timestamps();

            // Prevent duplicate ratings from same user on same item
            $table->unique(['user_id', 'rateable_id', 'rateable_type']);
        });

        // 2. Add rating columns to 'music' table (Bookmarks already has them)
        Schema::table('music', function (Blueprint $table) {
            if (!Schema::hasColumn('music', 'rating_avg')) {
                $table->float('rating_avg')->default(0)->after('uploaded_at');
                $table->unsignedInteger('reviews_count')->default(0)->after('rating_avg');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
        Schema::table('music', function (Blueprint $table) {
            $table->dropColumn(['rating_avg', 'reviews_count']);
        });
    }
};