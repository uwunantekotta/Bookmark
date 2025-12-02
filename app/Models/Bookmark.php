<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'url', 'tags', 'image'
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    protected $appends = ['image_url'];

    // Return a public URL when image is present
    public function getImageUrlAttribute()
    {
        if (!$this->image) return null;
        // storage disk 'public' stores files in storage/app/public — accessible at /storage/
        return asset('storage/' . ltrim($this->image, '/'));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = ['user_id', 'title', 'url', 'tags', 'image'];

    protected $casts = [
        'tags' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}