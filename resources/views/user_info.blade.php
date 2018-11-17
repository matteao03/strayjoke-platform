@extends('layouts.default')
@section('title', '完善用户信息')

@section('content') 
    <div class="login">
        <div class="title">
            完善会员信息
        </div>
        <div class="login-form">
            <form method="POST" action="{{ route('user_info', $user->id)}}">
                <input type="hidden" name="_method" value="PUT">
                {{ csrf_field() }}
                
                <label for="input-tel">昵称</label>
                <input type="text" class="form-control" id="input-tel" name="name" placeholder="输入昵称">
            
                <label for="input-password">密码</label>
                <input type="text" class="form-control" id="input-password" name="password" placeholder="输入密码">

                <label for="input-password">确认密码</label>
                <input type="text" class="form-control" id="input-again-password" name="again_password" placeholder="输入密码">

                <button type="submit" class="btn btn-block btn-login">提交</button>
            </form>
        </div>

        <p class="redirect-register"><a href="/auto_login">跳过</a></p>
    </div>           
   
@endsection
