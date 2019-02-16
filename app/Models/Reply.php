<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'content', 'user_id', 'comment_id', 'reply_id'
    ];

    public function replies()
    {
    	return $this->hasMany(self::class);
    }
    
    public function reply()
    {
    	return $this->belongsTo(self::class);
    }
    
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
    
    public function comment()
    {
    	return $this->belongsTo(Comment::class);
    }
}
