<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['content', 'user_id', 'article_id'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function article()
    {
    	return $this->belongsTo(Article::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
