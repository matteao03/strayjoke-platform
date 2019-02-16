@extends('layouts.app')
@section('title','写文章')

@section('content')
<div class="row article-create">
    <div class="col-lg-9 col-md-9 article-content">
    	<div class="card ">
            <div class="card-body">
                <h2 class="">
                  <i class="fa fa-edit"></i>
                   @if($article->id)
                    编辑文章
                   @else
                    写文章
                   @endif
                </h2>
                <hr>
                
                @if($article->id)
                    <form action="{{ route('articles.update', $article->id) }}" method="POST" accept-charset="UTF-8">
                      <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('articles.store') }}" method="POST" accept-charset="UTF-8">
                @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    @include('shared._errors')

                    <div class="form-group">
                      <input class="form-control" type="text" name="title" value="{{ old('title', $article->title ) }}" placeholder="请填写标题" required  />
                    </div>

                    <div class="form-group">
                        <textarea name="content" class="form-control" id="editor" rows="6" placeholder="请填入至少三个字符的内容。" required>
                          {{ old('content', $article->content ) }}
                        </textarea>
                    </div>

                    <div class="well well-sm">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2" aria-hidden="true"></i> 保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-3 sidebar user">
        @include('lawyers._profile', ['user'=> $user])
    </div>
</div>
@endsection

@section('styles')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
@stop

@section('scripts')
  <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>

  <script>
    $(document).ready(function() {
      var editor = new Simditor({
        textarea: $('#editor'),
        upload: {
          url: '{{ route('articles.upload_image') }}',
          params: {
            _token: '{{ csrf_token() }}'
          },
          fileKey: 'upload_file',
          connectionCount: 3,
          leaveConfirm: '文件上传中，关闭此页面将取消上传。'
        },
        pasteImage: true,
      });
    });
  </script>
@stop

