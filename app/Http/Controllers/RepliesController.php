<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use Auth;

class RepliesController extends Controller
{
    public function store(Request $request)
    {
    	//创建会员信息
        $reply = Reply::create([
            'content'=>$request->content,
            'user_id'=>Auth::id(),
            'comment_id'=>$request->comment_id,
            'reply_id'=> $request->reply_id ?: 0
        ]);

        return $reply->id;
    }
}
