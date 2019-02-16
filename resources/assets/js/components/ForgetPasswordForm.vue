<template>
    <el-form ref="forgetPassswordForm" :model="forgetPassswordForm" :rules="rules" label-position="top" :hide-required-asterisk="true"  id="forget-password-form">
        <el-form-item prop="mobile" label="手机号">
            <el-input v-model="forgetPassswordForm.mobile" placeholder="输入手机号" name="mobile" ></el-input>
        </el-form-item>
        <el-form-item v-if="isVerifyMobile">
            <el-button type="primary" @click="sendSmsCode('forgetPassswordForm')" class="btn btn-block btn-forget-password" :loading="loading">下一步</el-button>
        </el-form-item>

        <template v-else>
            <el-form-item prop="code" label="短信验证码" id="item-password">
                <el-input v-model="forgetPassswordForm.code" placeholder="输入短信验证码"  name="code">
                    <count-down slot="append" :start="countDownShow" @click.native="sendSmsCode('forgetPassswordForm')"></count-down>
                </el-input>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="submitForm('forgetPassswordForm')" class="btn btn-block btn-forget-password" :loading="loading">下一步</el-button>
            </el-form-item>
        </template>
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
                forgetPassswordForm: {
                    mobile: '',
                    code: '', 
                },
                isVerifyMobile:true,
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
                        axios.post('/mobile_verify',this.forgetPassswordForm)
                        .then(function (response) {
                            if (response.data.code === 1)
                            {
                                location.href = '/password_reset'
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
                        this.isVerifyMobile = false
                        let me = this
                        axios.post('/resetCode',{
                            mobile:this.forgetPassswordForm.mobile
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
                        .catch(function (error){
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
