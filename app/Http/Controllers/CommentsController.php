<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Comment;
use App\Models\Reply;

class CommentsController extends Controller
{
    public function __construct()
    {
            $this->middleware('auth');
    }

    //创建评论
    public function store(Request $request, Comment $comment)
    {
    	$data = $comment::create([
    		'content' => $request['content'],
    		'article_id' => $request['article_id'],
    		'user_id' => Auth::id(),
    	]);
        $data['user'] = Auth::user();
    	return ['code' => 1, 'data' => $data] ;
    }

    //显示评论
    public function show(Request $request, $id)
    {
        $data = Comment::with('user')->where('article_id', $id)->get();
        return [
            'code'=>1,
            'data'=>$data
        ];
    }
    
    //显示回复
    public function showReplies($comment)
    {
        $data = Reply::with(['user', 'reply'])->where('comment_id', $comment)->get();
        return [
            'code' => 1,
            'data' => $data
        ];
    }
}
