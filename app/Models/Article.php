<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    const STATUS_DRAFT = 'draft';
    const STATUS_PROCESSING = 'processing';
    const STATUS_PASS = 'pass';
    const STATUS_FAILED = 'failed';

    protected static $statusMap =[
        self::STATUS_DRAFT => '待审核',
        self::STATUS_PROCESSING => '审核中',
        self::STATUS_PASS => '已发布',
        self::STATUS_FAILED => '不通过',
    ];
    
    protected $fillable = [
        'title', 'content', 'user_id', 'reply_count', 'view_count', 'excerpt', 'status'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->hotReplied();
                break;
        }
        // 预加载防止 N+1 问题
        return $query->with('user');
    }

    public function scopeHotReplied($query)
    {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        return $query->orderBy('reply_count', 'desc');
    }

    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }

}
