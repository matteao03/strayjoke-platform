<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment;

class ArticlesController extends Controller
{
    public function index(Request $request, Article $article)
    {
    	$articles = $article->withOrder($request->order)->paginate(3);
    	
    	return view('home', compact('articles'));
    }

    public function show(Article $article)
    {
    	$comments = $article->comments;
    	return view('articles.show', compact('article', 'comments'));
    }
}
