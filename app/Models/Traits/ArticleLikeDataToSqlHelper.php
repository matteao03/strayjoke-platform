<?php 

namespace App\Models\Traits;

use Illuminate\Support\Facades\Redis;
use App\Models\Article;
use App\Models\User;

trait ArticleLikeDataToSqlHelper
{
    //获取redis里的数据
    public function articleLikestoSql()
    {
        //Redis::flushall();
        $article_set = Redis::smembers('article_set');
       //print_r($article_set);
        foreach ($article_set as $article_id) {
            $article = Article::find($article_id);
            Redis::srem('article_set', $article_id); //删除缓存
            $user_like_set = Redis::smembers('article_user_like_set_'.$article_id);
            //print_r($user_like_set);
            foreach ($user_like_set as $user_id) {
                $user = User::find($user_id);
                $liked = boolval($user->articleLikes()->find($article->id));
                Redis::srem('article_user_like_set_'.$article_id, $user_id); //删除缓存

                $article_user_like_hash = Redis::hgetall('article_user_like_'.$article_id.'_'.$user_id);
                //print_r($article_user_like_hash);
                if ($article_user_like_hash['type'] == 1 && !$liked){
                    $user->articleLikes()->attach($article);
                } else if ($article_user_like_hash['type'] == 2 && $liked) {
                    $user->articleLikes()->detach($article);
                }
                Redis::hdel('article_user_like_'.$article_id.'_'.$user_id, 'type', 'mtime', 'ctime');
            }

            $count = (int)Redis::get('article_'.$article_id.'_count');
            Redis::del('article_'.$article_id.'_count');
            if (($newCount = $article->like_count + $count) >=0){
                $article->like_count = $newCount;
            } else 
            {
                $article->like_count = 0;
            }
            $article->save();
        }
    }
}
