@extends('layouts.app')
@section('title','热点详情')

@section('content')
<div class="row article-detail">
    <div class="col-lg-9 col-md-9 article-content">
    	<div class="panel panel-default">
            <div class="panel-body">
               <div class="title">{{ $article->title}}</div>
               <div class="other">
                   <span>{{ $article->created_at}}</span>
                   <span>阅读 {{$article->view_count}}</span>
                   <span>评论 {{$article->reply_count}}</span>
                   <span>收藏 {{$article->collect_count}}</span>
                   <span>点赞 {{$article->like_count}}</span>
                </div>
               <div class="article-content">{!! $article->content !!}</div>
            </div>
        </div>
        <div class="panel panel-default">
            <comment-reply :article-id="{{$article->id}}"></comment-reply>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-3 sidebar lawyer-profile">
        @include('lawyers._profile', ['user'=> $author])
    </div>
    <div class="tool-box" id="tool-box">
        <ul class="tool-list">
            <thumbs-up data-id="{{$article->id}}" flag-Like="{{$liked}}"></thumbs-up>
            <share-tool></share-tool>
            <collect-tool data-id="{{$article->id}}" flag-collect="{{$collected}}"></collect-tool>
            <gift-tool article-id="{{$article->id}}"></gift-tool>
        </ul>
    </div>
</div>
@endsection
