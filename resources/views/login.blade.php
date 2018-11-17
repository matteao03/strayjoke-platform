@extends('layouts.default')
@section('title', '登录')

@section('content') 
    <div class="login">
        <div class="title">
            登录风了
        </div>
        <div class="login-form">

            @include('shared._errors')

            <form method="POST" action="{{ route('signin') }}">
                {{ csrf_field() }}
                
                <label for="input-tel">手机号</label>
                <input type="tel" class="form-control" id="input-tel" name="mobile" placeholder="输入手机号码">
            
                <label for="input-password">密码 <a href="{{ route('password_reset') }}" class="redirect-reset-password">忘记密码？</a></label>
                <input type="password" class="form-control" id="input-password" name="password" placeholder="输入密码">
                <button type="submit" class="btn btn-block btn-login">登录</button>
            </form>
        </div>

        <p class="redirect-register">没有账号？ <a href="{{ route('signup') }}">注册</a></p>
    </div>           
   
@endsection
