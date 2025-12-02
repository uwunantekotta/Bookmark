<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Bookmark extends Model
{
    protected $fillable = [
        'user_id', 'title', 'artist', 'url', 'image'
    ];
}php artisan make:controller BookmarkController

