@extends('layouts.app')
@section('title','热点详情1')

@section('content')
<div class="row">
    <div class="col-lg-9 col-md-9 article-detail">
    	<div class="panel panel-default">
		  <div class="panel-body">
		   	<h1>{{ $article->content}}</h1>
		   	<div>{{ $article->created_at->diffForHumans() }}</div>
		   	<div>{{ $article->title}}</div>
		  </div>
		</div>
		<div class="panel panel-default">
		  <div class="panel-body">
		   	@include('articles._reply_box', ['article' => $article])
		   	@include('comments.show', ['comments' => $comments])
		  </div>
		</div>
    </div>
    <div class="col-lg-3 col-md-3 sidebar">456</div>
</div>
@endsection
