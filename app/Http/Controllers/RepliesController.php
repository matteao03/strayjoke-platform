<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\User;
use App\Models\Comment;
use Auth;

class RepliesController extends Controller
{
    //创建回复
    public function store(Request $request)
    {
        $reply = Reply::create([
            'content'=>$request->content,
            'user_id'=>Auth::id(),
            'comment_id'=>$request->comment_id,
            'reply_id'=> $request->reply_id ?: 0
        ]);
        
        $data = Reply::with('user','reply')->find($reply->id);
        return ['code' => 1, 'data' => $data] ;
    }
}   
