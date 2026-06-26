<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTemplate extends Model
{
    protected $fillable = [
        'topic',
        'category',
        'platform',
        'content',
        'hashtags',
    ];
}
