<?php

namespace App\Observer;

use App\Models\Comment;

class CommentObserver 
{
   public function created(Comment $comment) 
   {
        $comments = $comment->article->comments;
        $count=0;
        foreach ($comments as $comment) {
            $count+=$comment->reply_count;
        }
        $comment->article->reply_count = $count+$comment->article->comments->count();
        $comment->article->save();
   } 
}

