<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'announcement',
        'show',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(Admin::class);
    }
}
