<?php

namespace App\Observer;

use App\Models\Reply;

class ReplyObserver 
{
   public function created(Reply $reply) 
   {
        //更新评论reply_count 字段
        $reply->comment->reply_count = $reply->comment->replies->count();
        $reply->comment->save();
        //更新文章的reply_count 字段
        $reply->comment->article->increment('reply_count', 1);
   } 
}

