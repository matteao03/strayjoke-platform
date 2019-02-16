<template>
    <div>
        <el-form v-if="isLogin" ref="loginForm" :model="loginForm" :rules="rules" label-position="top" :hide-required-asterisk="true"  id="login-form">
            <el-form-item prop="account" label="用户名 / 手机号">
                <el-input v-model="loginForm.account" placeholder="输入用户名或手机号" name="account" ></el-input>
            </el-form-item>
            <a href="/password_forget" class="redirect-reset-password">忘记密码？</a>
            <el-form-item prop="password" label="密码" id="item-password">
              <el-input v-model="loginForm.password" placeholder="输入密码" type="password" name="password" suffix-icon="st-icon-view"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="submitForm('loginForm')" class="btn btn-block btn-login" :loading="loading">登录</el-button>
            </el-form-item>
        </el-form>
        <el-form v-else ref="codeLoginForm" :model="codeLoginForm" :rules="codeRules" label-position="top" :hide-required-asterisk="true"  id="login-form">
            <el-form-item prop="mobile" label="手机号">
                <el-input v-model="codeLoginForm.mobile" placeholder="输入手机号" name="mobile" ></el-input>
            </el-form-item>
            <el-form-item prop="code" label="短信验证码" id="item-password">
                <el-input v-model="codeLoginForm.code" placeholder="输入短信验证码"  name="code">
                    <count-down slot="append" :start="countDownShow" @click.native="sendSmsCode('codeLoginForm')"></count-down>
                </el-input>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="submitForm('codeLoginForm')" class="btn btn-block btn-login" :loading="loading">登录</el-button>
            </el-form-item>
        </el-form>
        <div class="login-footer">
            <el-button type="text" @click="changeLogin">
                {{isLogin ? '手机验证码登录' : '密码登录' }}
            </el-button>
            <span class="third-login">
                <img src="/images/weixin.png" class="weixin"/>
                <img src="/images/weibo.png" class="weibo"/>
            </span>
        </div>
    </div>
</template>

<script>
    import CountDown from './CountDown.vue'

    export default{
        data() {
            var checkMobile = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请输入手机号'));
                } else {
                    const reg = /^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/;
                    if (reg.test(value)) {
                        callback();
                    } else {
                        return callback(new Error('手机号格式不正确'));
                    }
                     callback();
                }
            }
            return {
                loginForm: {
                    account: '',
                    password: '', 
                },
                codeLoginForm: {
                    mobile: '',
                    code: '', 
                },
                loading:false,
                isLogin:true,
                countDownShow:false, //倒计时是否显示
                rules:{
                    account:[
                        { required: true, message: '请输入用户名或手机号', trigger: 'blur' }
                    ],
                    password:[
                        { required: true, message: '请输入密码', trigger: 'blur' }
                    ]
                },
                codeRules:{
                    mobile:[
                        { validator: checkMobile, trigger: 'blur' }
                    ],
                    code:[
                        { required: true, message: '请输入短信验证码', trigger: 'blur' },
                        { pattern:/^\d{6}$/, message:'短信验证码格式不正确', trigger: 'blur'}
                    ] 
                }
            }
        },
        components:{
            CountDown
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.loading = true
                        let me = this
                        if (this.isLogin){ 
                            axios.post('/login',this.loginForm)
                            .then(function (response) {
                                if (response.data.code === 1)
                                {
                                    location.href = '/'
                                    me.$message({
                                        message: '欢迎回来！',
                                        type: 'success'
                                    });
                                } else {
                                    me.$message({
                                        message: response.data.message,
                                        type: 'error'
                                    });
                                }
                                me.loading = false
                            })
                            .catch(function (error){
                                me.loading = false
                            })
                        } else {
                            axios.post('/code_login',this.codeLoginForm)
                            .then(function (response) {
                                if (response.data.code === 1)
                                {
                                    location.href = '/'
                                    me.$message({
                                        message: '欢迎回来！',
                                        type: 'success'
                                    });
                                }
                            })
                            .catch(function (error){}) 
                        }
                    } else {
                        return false;
                    }
                });
            },
            changeLogin(){
                this.isLogin = !this.isLogin
                if (this.isLogin){
                    this.$refs['codeLoginForm'].clearValidate()
                } else {
                    this.$refs['loginForm'].clearValidate()
                }
            },
            sendSmsCode(formName){
                this.$refs[formName].validateField('mobile',(validMessage)=>{
                    if(validMessage === ""){
                        this.loading = false
                        let me = this
                        axios.post('/loginCode',{
                            mobile:this.codeLoginForm.mobile
                        })
                        .then(function (response) {
                            if (response.data.code === 1)
                            {
                                me.countDownShow = true
                                me.$message({
                                    message: '短信验证码已发送，请注意查收',
                                    type: 'success'
                                });
                            } else {
                                me.$message({
                                    message: response.data.message,
                                    type: 'error'
                                });
                            }
                        })
                        .catch(function (error){})
                    }
                })
            }
        },
        mounted:function(){
            this.$nextTick(function () {
                let itemView = document.getElementById("item-password").querySelector('.el-input__suffix');
                let inputView = document.getElementById("item-password").querySelector('input');
                let iconView = document.getElementById("item-password").querySelector('i');

                itemView.addEventListener('click',function(){
                    if (inputView.getAttribute("type")==="password" )
                    {
                         inputView.setAttribute("type", "text") ;
                         iconView.classList.remove('st-icon-view');
                         iconView.classList.add('st-icon-view-off');
                    }
                    else 
                    {
                        inputView.setAttribute("type", "password");
                        iconView.classList.remove('st-icon-view-off');
                        iconView.classList.add('st-icon-view');
                    }
                }, false)
            })
        }
    }
</script>
