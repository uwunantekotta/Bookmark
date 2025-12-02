<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany; // Import this

class Music extends Model
{
    use HasFactory;

    protected $table = 'music';

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'title', 'artist', 'url', 'image_path', 'user_id', 
        'status', 'rejection_reason', 'release_date', 'uploaded_at',
        'rating_avg', 'reviews_count' // Add these
    ];

    protected $casts = [
        'release_date' => 'date',
        'uploaded_at' => 'datetime',
        'rating_avg' => 'float',
        'reviews_count' => 'integer',
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
    
    // ... [keep your existing status methods] ...
    public function isApproved(): bool { return $this->status === self::STATUS_APPROVED; }
    public function isPending(): bool { return $this->status === self::STATUS_PENDING; }
    public function isRejected(): bool { return $this->status === self::STATUS_REJECTED; }
}