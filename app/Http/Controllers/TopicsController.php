<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;

class TopicsController extends Controller
{
    public function index(Topic $topic)
    {
    	$topics = $topic::paginate(5);
    	return view('topics.topics',compact('topics'));
    }

    public function show(Topic $topic)
    {
    	return view('topics.show',compact('topic'));
    }
}
