<?php

namespace App\Observer;

use App\Models\Article;

class ArticleObserver 
{
   public function saving(Article $article) 
   {
       $article->excerpt = make_excerpt($article->content);
       //$article->content = clean($article->content, 'article_content');
   } 
}

