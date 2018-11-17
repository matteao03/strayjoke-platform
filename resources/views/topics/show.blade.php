@extends('layouts.app')
@section('title', '论坛')

@section('content')
<div class="row">
	<div class="col-lg-9 col-md-9 topic-detail">
	<div class="panel panel-default">
		  <div class="panel-body">
		   	<div>{{ $topic->content}}</div>
		   	<div>{{ $topic->created_at->diffForHumans() }}</div>
		   	<div>{{ $topic->title}}</div>
		  </div>
		</div>
		<div class="panel panel-default">
		  <div class="panel-body">
		  	123
		  </div>
		</div>
    </div>
    <div class="col-lg-3 col-md-3 sidebar">创建帖子</div>
@endsection