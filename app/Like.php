<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'user_id',
        'like_id',
        'like_type',
    ];

    public function likeable()
    {
        return $this->morphTo();
    }
}
