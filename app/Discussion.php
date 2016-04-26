<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    protected $fillable=[
        'title',
        'contents',
        'user_id',
        'update_info',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class,'like'); //取得like_id为Discussion实例的id,并且like_type为App\Discussion的记录
    }

    public function favourite()
    {
        return $this->belongsToMany(User::class,'favourites')->withTimestamps();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

}
