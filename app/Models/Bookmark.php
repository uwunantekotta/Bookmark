<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany; // Import this

class Bookmark extends Model
{
    protected $fillable = [
        'user_id', 'title', 'artist', 'url', 'image', 'genre', 
        'views', 'rating_avg', 'reviews_count', 'release_date', 'uploaded_at'
    ];

    protected $casts = [
        'release_date' => 'date',
        'uploaded_at' => 'datetime',
        'rating_avg' => 'float',
        'reviews_count' => 'integer',
        'views' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Add this relationship
    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class, 'rateable');
    }
}