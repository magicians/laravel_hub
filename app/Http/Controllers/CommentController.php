<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Discussion;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Requests\CommentRequest $request)
    {
        $user_id = Auth::Guard('web')->user()->id;
        $comment = new Comment([
            'user_id' => $user_id,
            'comment' => $request->comment,
        ]);
        Discussion::findOrfail($request->discussion_id)->comments()->save($comment);

//        Comment::create(array_merge($request->all(), ['user_id' => $user_id]));
        return redirect()->action('PostController@show', ['id' => $request->discussion_id]);
    }
}
