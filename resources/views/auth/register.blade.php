@extends('layouts.default')
@section('title', '注册')

@section('content') 
    <div class="register">
        <div class="title">
            注册风了账号
        </div>
        <div class="register-form" id="register">
            <register-form></register-form>
        </div>

        <p class="redirect-login">已有账号？ <a href="{{ route('login') }}">登录</a></p>
    </div>           
   
@endsection