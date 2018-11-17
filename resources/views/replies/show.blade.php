@if (count($replies))
    <ul class="media-list">
        @foreach ($replies as $reply)
            <li class="media comment-reply">
                <div class="media-left">
                   123
                </div> 
                <div class="media-body" id="reply-{{ $reply->id }}">
                    {{ $reply->content }}
                    <div class="open-reply" style="color:#3097D1;">共5个回复</div>
                    <div class="reply" style="color:#3097D1;">回复</div>
                    <div  style="display:none;">
                        <div class="form-group">
                            <textarea  name="content" class="form-control" placeholder="我来说一说"></textarea>
                        </div>
                        <button class="btn btn-primary btn-reply" data-comment-id="{{ $coment->id }}" data-reply-id="{{ $reply->id }}">回复</button> 
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