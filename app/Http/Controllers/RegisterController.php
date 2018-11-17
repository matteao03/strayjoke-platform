<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class RegisterController extends Controller
{
    public function index()
    {
    	return view('register');
    }

    //验证手机号和短信验证码
    public function validateMobile(Request $request)
    {
    	$this->validate($request, [
            'mobile' => 'required|regex:/^1\d{10}$/|unique:users',
            'validate_code' => 'required|regex:/^\d{6}$/'
        ]);

        //创建会员信息
        $user = User::create([
            'mobile'=>$request->mobile,
            'password'=>bcrypt('123456')
        ]);
        if(!$user){
            $this->setMsg('注册失败');
            return false;
        }

        //自动登录成功
        if (Auth::attempt(['mobile'=>$request->mobile, 'password'=>'123456'])){
            return redirect()->route('register_user_info', compact('user')); 
        }else{
           //自动登录失败
            return redirect()->route('login');
        }
        
    }

    //完善用户信息
    public function showUserInfoForm(User $user){
        return view('user_info', compact('user'));
    }
}
