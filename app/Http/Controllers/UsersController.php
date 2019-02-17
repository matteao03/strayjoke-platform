<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Uuid;

class UsersController extends Controller
{
    public function __construct()
    {
      // $this->middleware('auth', ['except' => ['show', 'store', ]]);
    }
    
    //创建用户
    public function store(Request $request){
        $this->validate($request, [
            'nickname' => 'required',
            'password' => 'required|confirmed'
        ]);

        $mobile = $request->session()->get('register_mobile');
        
        $user = User::create([
            'name' => Uuid::generate(),
            'nickname' => $request -> nickname,
            'password' => bcrypt($request->password),
            'mobile' => $mobile,
        ]);
        
        //登录成功
        Auth::login($user);
        
        return [
            'code' => 1,
            'message' => '注册成功！'
        ];
    }  

    //我的主页
    public function show(User $user)
    {
        return  view('users.show', compact('user'));
    }
    
    //设置
    public function edit(User $user)
    {
        //$this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    
    //更新
    public function update(Request $request, User $user)
    {
       // $this->authorize('update', $user);
        $user->name = $request->name;
        $user->save();
        return  redirect()->route('users.edit', $user);
    }
    
    public function unbindMobile(Request $request)
    {
        $user = Auth::user();
        if ($request->mobile === $user->mobile)
        {
            $user->mobile = '';
            $user->save();
            return  [
                'code'=>1, 
                'msg'=> '手机号解绑成功'
            ];
        } else {
            return  [
                'code'=> 0, 
                'msg'=> '手机号解绑失败'
            ];
        }  
    }

    public function showTopics()
    {
        $user = Auth::user();
        $topics = $user ->topics;
        return view('users.topics', compact('topics', 'user'));
    }

    public function showComments()
    {
        $user = Auth::user();
        $comments = $user ->comments;
        return view('users.comments', compact('comments', 'user'));
    }

}
