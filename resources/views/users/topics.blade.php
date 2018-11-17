@extends('users.info')
@section('user_part')
    @if (count($topics))
    <ul class="media-list">
        @foreach ($topics as $topic)
            <li class="media">
                <div class="media-left">
                    1233
                </div>

                <div class="media-body">

                    <div class="media-heading">
                        <a href="{{ route('topics.show', [$topic->id]) }}">
                            {{ $topic->content }}
                        </a>
                        <a class="pull-right" href="#" >
                            <span class="badge">13</span>
                        </a>
                    </div>

                    <div class="media-body meta">
                        评论
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
@endsection