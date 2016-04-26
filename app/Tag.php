<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'tag_name',
        'tag_group'
    ];

    public function discussions()
    {
        return $this->belongsToMany(Discussion::class)->withTimestamps();
    }
}
