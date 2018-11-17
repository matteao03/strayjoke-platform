<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lawyer extends Model
{
    public function articles()
    {
    	return $this->hasMany(Articles::class);
    }

    protected $fillable = [
        'name', 'mobile', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
