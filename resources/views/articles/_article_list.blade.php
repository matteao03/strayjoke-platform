@if (count($articles))

    <ul class="media-list">
        @foreach ($articles as $article)
            <li class="media">
                <div class="media-left">
                   <img src="{{ $article->lawyer->avater ?: asset('images/avater-default.png') }}" class="avater">
                </div>

                <div class="media-body">

                    <div class="media-heading">
                        <a href="{{ route('show', [$article->id]) }}" title="{{ $article->title }}">
                            {{ $article->title }}
                        </a>
                        <a class="pull-right" href="#" >
                            <span class="badge"> 12</span>
                        </a>
                    </div>

                    <div class="media-body meta">
                    用户
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