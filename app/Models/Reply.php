<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
	protected $fillable = [
        'content', 'user_id', 'comment_id', 'reply_id'];

    public function replies()
    {
    	return $this->hasMany(self::class);
    }
}
