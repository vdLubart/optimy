<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasMany;

class News extends Eloquent
{
    protected $fillable = [
        'id', 'title', 'body', 'created_at'
    ];

    public $timestamps = false;

    /**
     * Return related comments collection
     *
     * @return HasMany
     */
    public function comments(): HasMany {
        return $this->hasMany(Comment::class, 'news_id', 'id');
    }
}