<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use Auth;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use Traits\ArticleLikeDataToSqlHelper;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'mobile', 'password', 'active', 'nickname', 'open_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function lawyer()
    {
    	return $this->hasOne(Lawyer::class);
    }
    
    public function articles()
    {
    	return $this->hasMany(Article::class);
    }
    
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    //点赞的文章
    public function articleLikes()
    {
        return $this->morphedByMany('App\Models\Article', 'like')->withTimestamps();
    }
    
    //收藏的文章
    public function articleCollections()
    {
        return $this->morphedByMany('App\Models\Article', 'collection')->withTimestamps();
    }

    // Rest omitted for brevity

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
