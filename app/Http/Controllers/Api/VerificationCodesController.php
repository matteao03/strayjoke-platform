<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

// 引入阿里大鱼命名空间
use iscms\Alisms\SendsmsPusher as Sms;

class VerificationCodesController extends Controller
{
    public function store(Request $request, Sms $sms)
    {
        //$mobile = $request->mobile;
        $validateCode = str_pad(random_int(1,999999),6,0,STR_PAD_LEFT);
        $expiredAt = now()->addMinutes(100);
        // Cache::put('17717935765', $validateCode, $expiredAt); 
        // echo Cache::get('17717935765');
        // echo "<br/>";
        return 0;
    }
}
