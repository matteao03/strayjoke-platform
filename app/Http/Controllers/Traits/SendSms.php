<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
// 引入阿里大鱼命名空间
use Mrgoon\AliSms\AliSms as AliSms;

trait SendSms
{
    /**
     * 发送短信验证码
     * @param Request $request
     * @param type $type 短信验证码的类型，如register，login， reset
     * @return type
     */
    public function sendSmsCode(Request $request, $type)
    {
        //验证唯一性
         $request->validate([
            'mobile' => [
                'required',
                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/'
            ]
        ]);

        //生成验证码
        $smsCode = str_pad(random_int(1,999999),4,0,STR_PAD_LEFT);
        $expiredAt = now()->addMinutes(2);

        //定义参数
        $smsParams = [
            'code' => $smsCode
        ];
        
        // 执行发送动作
        $aliSms = new AliSms();
        //$data = $aliSms->sendSms($request->mobile, "SMS_148590449", $smsParams);
        
         // 判断短信发送结果
        // if (strtolower($data->Code) === 'ok') {
            if (true) {
            // 将验证码存入redis 设置2分钟失效时间
            Cache::put($type.'_'.$request->mobile, $smsCode, $expiredAt);

            return [
                'code' => 1,
                'message' => '验证码已发送，120秒内有效！',
                'smsCode' => Cache::get($type.'_'.$request->mobile)
            ]; 
        }
        else{
            return [
                'code' => 0,
                'message' => '验证码发送失败，请重试',
            ]; 
        }
    }

    /**
     * 检验短信验证码
     * @param Request $request
     * @param type $type 短信验证码的类型，如register，login， reset
     * @return type
     */
    public function checkSmsCode(Request $request, $type)
    {
        $this->validate($request, [
            'mobile' => 'required|regex:/^1\d{10}$/',
            'code' => 'required|regex:/^\d{6}$/'
        ]);

        if ($request->code == Cache::get($type.'_'.$request->mobile))
        {
            //验证成功的标志存储在session中
            session([$type.'_'.'mobile' => $request->mobile]);
            return true;
        }

        return false;
    }
}
