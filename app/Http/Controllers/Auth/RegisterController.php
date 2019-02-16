<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Traits\SendSms;

class RegisterController extends Controller
{
    //短信验证码trait
    use SendSms;
    
    //注册页面
    public function showRegisterForm()
    {
    	return view('auth.register');
    }
    
    //获取短信验证码
    public function sendCode(Request $request){
        $this->validate($request, [
           'mobile' => 'required|unique:users'
        ]);
        
        return $this->sendSmsCode($request, 'register');
    }
    
    //注册
    public function join(Request $request){
        if ($this->checkSmsCode($request, 'register')){
            return [
                'code' => 1,
                'message' => '手机号验证成功'
            ];
        } else {
            return [
                'code' => 0,
                'message' => '手机号与验证码不匹配，请重新输入'
            ];
        }
    }
    
    //认证信息
    public function showAuthInfoForm(Request $request)
    {
        return view('auth.register_auth_info');
    }
}
