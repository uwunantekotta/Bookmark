<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookmark extends Model
{
    protected $fillable = [
        'user_id', 
        'title', 
        'artist', 
        'url', 
        'image', 
        'genre', 
        'views', 
        'rating_avg', 
        'reviews_count',
        // ADD THESE TWO:
        'release_date',
        'uploaded_at'
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
}