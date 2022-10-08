<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Comment extends Eloquent
{
    protected $table = 'comment';

    public $timestamps = false;

    protected $fillable = [
        'id', 'news_id', 'body', 'created_at'
    ];
}