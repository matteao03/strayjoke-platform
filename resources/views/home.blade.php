@extends('layouts.app')
@section('title', '热点')

@section('content') 
    <div class="row">
       <div class="col-lg-9 col-md-9 topic-list">
			<div class="panel panel-default">
			  <div class="panel-heading">最新发表</div>
			  <div class="panel-body">
			    @include('articles._article_list', ['articles' => $articles])
			    {!! $articles->render() !!}
			  </div>
			</div>
       </div>
       <div class="col-lg-3 col-md-3 sidebar">456</div>
    </div>           
   
@endsection