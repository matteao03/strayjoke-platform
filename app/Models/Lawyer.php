<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lawyer extends Model
{
    const STATUS_PROCESSING = 'processing';
    const STATUS_PASS = 'pass';
    const STATUS_FAILED = 'failed';

    protected static $statusMap =[
        self::STATUS_PROCESSING => '审核中',
        self::STATUS_PASS => '已认证',
        self::STATUS_FAILED => '不通过',
    ];
    
    protected $fillable = [
        'org', 'description', 'tel', 'avatar', 'user_id', 'name'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
