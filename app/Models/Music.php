<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;

    protected $table = 'music'; // points to your table

    protected $fillable = [
        'title',
        'artist',
        'url',
        'image_path',
        'user_id'
    ];
}
