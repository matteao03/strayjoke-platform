@extends('layouts.app')

@section('title', '文章')
@section('description', $article->excerpt)

@section('content')

  <div class="row">
    <div class="col-lg-9 col-md-9 article-show">
      <div class="card ">
        <div class="card-body">
          <h1 class="text-center mt-3 mb-3">
            {{ $article->title }}
          </h1>

          <div class="article-meta text-center text-secondary">
            {{ $article->created_at }}
            ⋅
            <i class="fa fa-comment"></i>
            {{ $article->reply_count }}
          </div>

          <div class="topic-body mt-4 mb-4">
            {!! $article->content !!}
          </div>

           @can('update', $article)
            <div class="operate">
              <hr>
              <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-outline-secondary btn-sm" role="button">
                <i class="far fa-edit"></i> 编辑
              </a>
              <form action="{{ route('articles.destroy', $article->id) }}" method="post"
                    style="display: inline-block;"
                    onsubmit="return confirm('您确定要删除吗？');">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-outline-secondary btn-sm">
                  <i class="far fa-trash-alt"></i> 删除
                </button>
              </form>
            </div>
          @endcan
        </div>
      </div>
    </div>
      
    <div class="col-lg-3 col-md-3 sidebar user">
        @include('lawyers._profile', ['user'=> $user])
    </div>
  </div>
@stop