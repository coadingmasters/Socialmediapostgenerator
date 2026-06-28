<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedPost extends Model
{
    protected $fillable = [
        'content',
        'platform',
        'tone',
        'hashtags',
        'image_prompt',
        'image_url',
        'is_shared',
        'shared_at',
        'is_posted',
        'posted_at',
    ];

    protected $casts = [
        'is_shared' => 'boolean',
        'shared_at' => 'datetime',
        'is_posted' => 'boolean',
        'posted_at' => 'datetime',
    ];
}
