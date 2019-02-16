<template>
    <el-form ref="registerForm" :model="registerForm" :rules="rules" label-position="top" :hide-required-asterisk="true"  id="register-form">
        <el-form-item prop="mobile" label="手机号">
            <el-input v-model="registerForm.mobile" placeholder="输入手机号" name="mobile" ></el-input>
        </el-form-item>
        <el-form-item prop="code" label="短信验证码" id="item-password">
            <el-input v-model="registerForm.code" placeholder="输入短信验证码"  name="code">
                <count-down slot="append" :start="countDownShow" @click.native="sendSmsCode('registerForm')"></count-down>
            </el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="submitForm('registerForm')" class="btn btn-block btn-register" :loading="loading">下一步</el-button>
        </el-form-item>
    </el-form>
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
                registerForm: {
                    mobile: '',
                    code: '', 
                },
                loading:false,
                countDownShow:false, //倒计时是否显示
                rules:{
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
                        axios.post('/join',this.registerForm)
                        .then(function (response) {
                            if (response.data.code === 1)
                            {
                                location.href = '/auth_info'
                                me.$message({
                                    message: response.data.message,
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
                    } else {
                        return false;
                    }
                });
            },
            sendSmsCode(formName){
                this.$refs[formName].validateField('mobile',(validMessage)=>{
                    if(validMessage === ""){
                        this.loading = false
                        let me = this
                        axios.post('/registerCode',{
                            mobile:this.registerForm.mobile
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
                            me.loading = false
                        })
                        .catch(function (error){
                            me.loading = false
                            if (error.response.status == 422){
                                me.$message({
                                    message: error.response.data.errors.mobile[0],
                                    type: 'error'
                                });
                            }
                        })
                    }
                })
            }
        }
    }
</script>
