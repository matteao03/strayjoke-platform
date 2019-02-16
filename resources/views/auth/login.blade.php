@extends('layouts.default')
@section('title', '登录')

@section('content') 
    <div class="login">
        <div class="title">
            登录风了
        </div>
        <div class="login-form">
            <login-form></login-form>
        </div>

        <p class="redirect-register">没有账号？ <a href="{{ route('join') }}">注册</a></p>
    </div>           
   
@endsection
