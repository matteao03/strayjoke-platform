@if (count($comments))
    <ul class="media-list">
        @foreach ($comments as $comment)
            <li class="media article-comment">
                <div class="media-left">
                   123
                </div> 
                <div class="media-body" id="comment-{{ $comment->id }}">
                    {{ $comment->content }}
                    <div class="request-reply" data-comment-id="{{ $comment->id }}">若干条回复</div>
                    <div class="reply" style="color:#3097D1;">回复</div>
                    <div  style="display:none;">
                        <div class="form-group">
                            <textarea  name="content" class="form-control" placeholder="我来说一说"></textarea>
                        </div>
                        <button class="btn btn-primary btn-reply" data-comment-id="{{ $comment->id }}">回复</button> 
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


@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){

        //回复框的显示逻辑
       $(".article-comment").on('click', '.reply', function() {
            if ($(this).next().css('display') == 'none')
            {
                $(this).text("收起");
                $(this).next().slideDown();
            }else {
                $(this).text("回复");
                $(this).next().slideUp();
            }
        });

       $(".article-comment").on('click', '.request-reply', function(){
            var id = $(this).data('comment-id');
            axios.get('/comments/'+id)
            .then(function (response) {
                for(var i = 0; i<response.data.length; i++){
                    var id = response.data[i].id
                    var content = response.data[i].content;
                    var comment_id = response.data[i].comment_id;
                    var reply_id = response.data[i].reply_id;
                    var dom = '<li class="media"><div class="media-left">123</div> <div class="media-body" id="reply-'+id+'">';
                        dom += content;
                        dom += '<div class="reply" style="color:#3097D1;">回复</div>';
                        dom += '<div style="display:none;"><div class="form-group"><textarea  name="content" class="form-control" placeholder="我来说一说"></textarea></div>';
                        dom += '<button class="btn btn-primary btn-reply" data-comment-id="'+comment_id+'" data-reply-id="'+id+'">回复</button></div></li>';
                    
                    //是否有reply_id
                    if (reply_id){
                        $('#reply-'+reply_id).append(dom);
                    }else{
                        $('#comment-'+comment_id).append(dom);
                    } 
                }
                
            })
            .catch(function (error) {
                console.log(error);
            });
       });

       //提交回复
       $(".article-comment").on('click', '.btn-reply', function(){

            axios.post('{{ route('replies.store') }}', {
                content: $(this).prev('.form-group').children('textarea').val(),
                comment_id: $(this).data("comment-id"),
                reply_id: $(this).data('reply-id')
            })
            .then(function (response) {
                var id = response.data;
                json_data = JSON.parse(response.config.data);
                var content = json_data.content;
                var comment_id = json_data.comment_id;
                var reply_id = json_data.reply_id;
                var dom = '<div class="media-body" id="reply-'+id+'">';
                    dom += content;
                    dom += '<div class="reply" style="color:#3097D1;">回复</div>';
                    dom += '<div style="display:none;"><div class="form-group"><textarea  name="content" class="form-control" placeholder="我来说一说"></textarea></div>';
                    dom += '<button class="btn btn-primary btn-reply" data-comment-id="'+comment_id+'" data-reply-id="'+id+'">回复</button></div>';
                
                //是否有reply_id
                if (reply_id){
                    $('#reply-'+reply_id).append(dom);
                }else{
                    $('#comment-'+comment_id).append(dom);
                }          
            })
            .catch(function (error) {
                console.log(error);
            });
       })
    })
    
</script>
@endsection

