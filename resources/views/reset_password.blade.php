@extends('layouts.default')
@section('title', '重置密码')

@section('content') 
    <div class="register">
        <div class="title">
            重置登录密码
        </div>
        <div class="register-form">
            <form method="POST" action="#">
                {{ csrf_field() }}
                
                <label for="exampleInputEmail2">手机号</label>
                <input type="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com">
            
                <label for="exampleInputEmail2">短信验证码</label>
                <input type="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com">

                 <button type="submit" class="btn btn-block btn-register">重置密码</button>
            </form>
        </div>

        <p class="redirect-login">返回 <a href="/login">登录</a></p>
    </div>           
   
@endsection
