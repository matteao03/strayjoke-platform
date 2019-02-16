<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Traits\SendSms;
use App\Models\User;

class LoginController extends Controller
{
    //短信验证码trait
    use SendSms;
    
    //登录页面
    public function showLoginForm()
    {
    	return view('auth.login');
    }

    //登录
    public function login(Request $request)
    {
        $this->validate($request, [
           'account' => 'required',
           'password' => 'required'
        ]);
        
        //登录成功
        if (Auth::attempt(['mobile' => $request->account, 'password' => $request->password])
            || Auth::attempt(['name' => $request->account, 'password' => $request->password])) {
            return [
                'code' => 1,
                'message' => '登录成功'
            ];
        } else {
            //登录失败
            return [
                'code' => 0,
                'message' => '账户与密码不匹配，请重新输入'
            ];
        }
    }
    
    //发送手机验证码
    public function sendCode(Request $request){
        $user = User::where('mobile', $request->mobile)->first();
        if (!empty($user)){
            return $this->sendSmsCode($request, 'login');
        }
        return [
            'code' => 0,
            'message' => '当前手机号未注册'
        ];
    }
    
    //手机验证码登录
    public function codeLogin(Request $request)
    {
        if ($this->checkSmsCode($request, 'login')){
            $user = User::where('mobile', $request->mobile)->first();
            Auth::login($user);
            return [
                'code' => 1,
                'message' => '登录成功'
            ];
        } else {
            return [
                'code' => 0,
                'message' => '手机号与验证码不匹配，请重新输入'
            ];
        }
    }
    
    //退出
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
//        return [
//            'code' => 1,
//            'message' => '退出成功！'
//        ];
    }
}
