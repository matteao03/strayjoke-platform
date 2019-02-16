@extends('layouts.app')

@section('title', '文章列表')

@section('content')
<div class="row">
  <div class="col-lg-9 col-md-9 articles-list">
    <div class="card ">
      <div class="card-body">
        {{-- 话题列表 --}}
        @if (count($articles))
        <ul class="media-list">
            @foreach ($articles as $article)
                <li class="media">
                    <div class="media-body">  
                        <a class="media-heading title" href="{{ route('articles.detail', [$article->id]) }}">
                            {{ $article->title }}
                        </a>
                        <div class="excerpt">{{ $article->excerpt }}</div> 
                        <div class="other-info">
                            <a class="author" href="{{ route('users.show', $article->user->id)}}">{{ $article->user->name }}</a>
                            <span class="comment"><i class="fas fa-comment"></i>&nbsp;{{ $article->reply_count }}&nbsp;条评论</span> 
                            <span class="view"><i class="fas fa-eye"></i>&nbsp;{{ $article->view_count }}&nbsp;次浏览</span> 
                            <span class="time">发布于&nbsp;{{ $article->created_at }}</span> 
                        </div>   
                    </div>
                </li>

                @if ( ! $loop->last)
                    <hr>
                @endif

            @endforeach
        </ul>
        @else
           <div class="empty-block">暂无数据 ~_~ </div>
        @endif
        {{-- 分页 --}}
        <div class="mt-5">
          {!! $articles->appends(Request::except('page'))->render() !!}
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-3 sidebar">
   123
  </div>
</div>

@endsection