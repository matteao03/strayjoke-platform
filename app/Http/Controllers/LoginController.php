<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function index()
    {
    	return view('login');
    }

    public function signin(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required|regex:/^1\d{10}$/',
        ]);

        //登录成功
        if (Auth::attempt(['mobile' => $request->mobile, 'password' => $request->password])) {
            return redirect()->route('articles');
        } else {
            //自动登录失败
            return redirect()->route('signup');
        }
    }
    public function logout()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('/');
    }
}
