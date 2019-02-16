<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment;
use Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use App\handlers\UploadHandler;

class ArticlesController extends Controller
{
    public function index(Request $request)
    {
    	$articles = Article::withOrder('created_at')->paginate(10);

//        foreach ($articles as  $article) {
//            $counter = Redis::get('article_'.$article->id.'_counter');
//            $article['counter'] = (int)$counter;
//            $article['counter'] = $article -> counter + (int)$counter;
//            $article['like_status'] = false;
//            if (Auth::check()) {
//               $result = Auth::user()->isLikeArticle($article->id);
//               
//                switch ($result) {
//                    case 1:
//                        $article['like_status'] = true; //数据库点赞
//                        break;
//                    case 2:
//                        $article['like_status'] = true;//redis点赞
//                        break;
//                    case 3:
//                        $article['like_status'] = false;//取消点赞
//                        break;
//                    default:
//                        $article['like_status'] = false; //0 没有点赞 
//                        break;
//                }
//            }   
//        }
    	
    	return view('articles.index', compact('articles'));
    }
    
    public function create(Article $article)
    {
        $user = Auth::user();
        $lawyer = $user->lawyer;
    	return view('articles.create', compact('user', 'lawyer', 'article'));
    }
    
    public function edit(Article $article)
    {
        $this->authorize('update', $article);
        $user = Auth::user();
        $lawyer = $user->lawyer;
    	return view('articles.create', compact('user', 'lawyer', 'article'));
    }
    
    public function update(Article $article)
    {
         $this->authorize('update', $article);
    	return view('articles.create', compact('user', 'lawyer'));
    }
    
    public function store(Request $request, Article $article)
    {
    	$article->fill($request->all());
        $article->user_id = Auth::id();
        $article->save();

        return redirect()->route('articles.show', $article->id);
    }   
    
    public function destroy(Article $article)
    {
        $this->authorize('destroy', $article);
        $article->delete();

        return redirect()->route('articles.index')->with('success', '成功删除！');
    }
    
    public function show(Article $article)
    {
        $user = Auth::user();
        $lawyer = $user->lawyer;
    	return view('articles.show', compact('user', 'lawyer', 'article'));
    }
    
    //上传图片
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        //初始化数据，默认是失败
        $data=[
            'success' => false,
            'msg' => '上传失败',
            'file_path' => ''
        ];
        //判断是否有文件上传，并赋值给$file
        if ($file = $request->upload_file)
        {
            //保存图片到本地
            $result = $uploader->save($file, 'articles', Auth::id(), 1024);
            //图片保存成功
            if($result){
                $data['file_path'] = $result['path'];
                $data['msg'] = '上传成功';
                $data['success'] = true;              
            }
        }
        return $data;
    }

    public function detail(Article $article, Request $request)
    {
        //用户和律师信息
        $author = $article->user;
        //增加浏览数
        $article->timestamps = false; 
        $article->increment('view_count');
        $article->save();
        $article->timestamps = true; 
        $collected = false;
        $liked = false;
        //统计点赞数
        $count = (int)Redis::get('article_'.$article->id.'_count');
        if (($newCount = $article->like_count + $count) >=0){
            $article->like_count = $newCount;
        } else 
        {
            $article->like_count = 0;
        }
        
        //收藏、点赞
        if ($user = $request->user()){
            $collected = boolval($user->articleCollections()->find($article->id));
            if (Redis::hget('article_user_like_'.$article->id.'_'.$user->id,'type')==1)
            {
                $liked = true;
            } else if (Redis::hget('article_user_like_'.$article->id.'_'.$user->id,'type')==2){
                $liked = false;
            } else {
                $liked = boolval($user->articleLikes()->find($article->id));
            }
        } 

    	return view('articles.detail', compact('article', 'liked', 'collected', 'author'));
    }

    //点赞
    public function like(Request $request, $id)
    {
        $userId = Auth::id();
        Redis::sadd('article_set', $id); //存储文章id
        Redis::sadd('article_user_like_set_'.$id, $userId); //存储用户id
        Redis::hmset('article_user_like_'.$id.'_'.$userId, ['type'=>1, 'mtime'=>time()]); //点赞
        Redis::hsetnx('article_user_like_'.$id.'_'.$userId, 'ctime', time()); //创建时间
        $count = Redis::get('article_'.$id.'_count') ?: '0';  //点赞数量
        Redis::set('article_'.$id.'_count', (int)$count + 1);
        
        return ['code' => 1, 'message' => '点赞成功'];
    }
    
    //取消点赞
    public function unlike(Request $request, $id)
    {
        $userId = Auth::id();
        Redis::sadd('article_set', $id); //存储文章id
        Redis::sadd('article_user_like_set_'.$id, $userId); //存储用户id
        Redis::hmset('article_user_like_'.$id.'_'.$userId, ['type'=>2, 'mtime'=>time()]); //取消点赞
        Redis::hsetnx('article_user_like_'.$id.'_'.$userId, 'ctime', time()); //创建时间
        $count = Redis::get('article_'.$id.'_count') ?: '0';  //点赞数量
        Redis::set('article_'.$id.'_count', (int)$count - 1);
        
        return ['code' => 1, 'message' => '已取消'];
    }
    
    //收藏文章
    public function collect(Article $article, Request $request)
    {
        $user = $request->user();
        if($user->articleCollections()->find($article->id)){
            return ['code' => 0, 'message' => '文章已收藏'];
        }
        $user->articleCollections()->attach($article);
        
        //文章收藏数+1
        $article->timestamps = false; 
        $article->increment('collect_count');
        $article->save();
        $article->timestamps = true;
        
        return ['code' => 1, 'message' => '文章收藏成功'];
    }
    
    //取消收藏文章
    public function unCollect(Article $article, Request $request)
    {
        $user = $request->user();
        $user->articleCollections()->detach($article);
        
        //文章收藏数 -1
        $article->timestamps = false; 
        $article->decrement('collect_count');
        $article->save();
        $article->timestamps = true;

        return ['code' => 1, 'message' => '已取消收藏'];
    } 
}
