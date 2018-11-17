<?php

return [

    'custom' => [
        'mobile' => [
            'required' => '手机号码不能为空！',
            'regex' => '手机号码格式不正确！',
            'unique' => '该手机号码已注册！'
        ],
        'validate_code' =>[
            'required' => '短信验证码不能为空！', 
            'regex' => '短信验证码格式不正确！'
        ]
    ],
];
