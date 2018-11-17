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

    public function store(Request $request, Comment $comment)
    {
    	// $this->validate($request,[
    	// 	'content' => 'require|max:140',
    	// 	'article_id' => 'require'
    	// ]);
    	$comment::create([
    		'content' => $request['content'],
    		'article_id' => $request['article_id'],
    		'user_id' => Auth::id()
    	]);

    	return redirect()->back();
    }

    public function show(Comment $comment){
        return $replies = $comment->replies;

    }
}
