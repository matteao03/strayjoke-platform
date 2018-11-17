@extends('layouts.default')
@section('title', '注册')

@section('content') 
    <div class="register">
        <div class="title">
            注册风了账号
        </div>
        <div class="register-form">
            
            @include('shared._errors')

            <form method="POST" action="{{ route('validateCode_check') }}">
                {{ csrf_field() }}
                
                <label for="input-tel">手机号</label>
                <input type="tel" class="form-control" id="input-tel" name="mobile" placeholder="输入手机号码" value="{{ old('mobile') }}">
            
                <label for="input-validate-code">短信验证码</label>
                <input type="number" name="validate_code" class="form-control" id="input-validate-code" placeholder="输入短信验证码" value="{{ old('validate_code') }}">

                <button class="btn btn-validate-code" type="button" id="btn-validate-code">获取验证码</button>
 
                <button type="submit" class="btn btn-block btn-register">下一步</button>
            </form>
        </div>

        <p class="redirect-login">已有账号？ <a href="{{ route('login') }}">登录</a></p>
    </div>           
   
@endsection

@section('scripts')
    <script>
         /*-------------------------------------------*/
    var InterValObj; //timer变量，控制时间
    var count = 60; //间隔函数，1秒执行
    var curCount;//当前剩余秒数
    var code = ""; //验证码

    $(function () {
        $('#btn-validate-code').click(function () {
            var fn = $(this);
            fn.attr("disabled", "true"); //禁止重复点击

            $.ajax({
                type: "POST",
                url: "{{ route('validateCode') }}",
                data: "mobile="+$("#input-tel").val() ,
                dataType: 'json',
                success: function (result) {
                   if(result==0){
                       curCount = count;
                       //设置button效果，开始计时
                       fn.css("background-color", "#888");
                       fn.html(curCount + "秒");
                       InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
                   }
                }
            })
        })
    })

    function SetRemainTime()
    {
        if (curCount == 0) {
            window.clearInterval(InterValObj);//停止计时器
            $("#btn-validate-code").removeAttr("disabled");//启用按钮
            $("#btn-validate-code").css("background-color", "#409efe");
            $("#btn-validate-code").html("获取验证码");
            code = ""; //清除验证码。如果不清除，过时间后，输入收到的验证码依然有效
        }
        else {
            curCount--;
            $("#btn-validate-code").html(curCount + "秒");
        }
    }
    </script>
@stop
