<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\SendSms;
use App\Models\User;
use Auth;

class ResetPasswordController extends Controller
{
    //短信验证码trait
    use SendSms;
    
    //找回密码
    public function showForgetPasswordForm()
    {
    	return view('auth.forget_password');
    }
    
    //重置密码
    public function showResetPasswordForm()
    {
    	return view('auth.reset_password');
    }
    
    //发送手机验证码
    public function sendCode(Request $request){
        $user = User::where('mobile', $request->mobile)->first();
        if (!empty($user)){
            return $this->sendSmsCode($request, 'reset');
        }
        return [
            'code' => 0,
            'message' => '当前手机号未注册'
        ];
    }
    
    //验证手机号
    public function verifyMobile(Request $request){
        if ($this->checkSmsCode($request, 'reset')){
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
    
    //重置密码
    public function resetPassword(Request $request){
        $this->validate($request, [
            'password' => 'required|comfirmed'
        ]);
        
        $mobile = $request->session()->get('reset_mobile');
        
        if ($mobile){
            $user = User::where('mobile', $mobile)->first();
            if ($user){
                $user->password = bcrypt($request->password);
                $user->save();
                
                $request->session()->forget('reset_mobile'); //删除session
                
                //登录成功
                Auth::login($user);

                return [
                    'code' => 1,
                    'message' => '密码重置成功！'
                ];
            }
        } 
        
        return [
            'code' => 0,
            'message' => '请先验证手机号！'
        ];
    }
}
