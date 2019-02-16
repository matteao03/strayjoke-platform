<template>
    <el-form  
            ref="resetPasswordForm" 
            :model="resetPasswordForm" :rules="rules" 
            label-position="top" 
            :hide-required-asterisk="true"  
            id="reset-password-form"
    >
        <el-form-item prop="password" label="新密码">
            <el-input v-model="resetPasswordForm.password"  placeholder="输入新密码" name="password">
            </el-input>
        </el-form-item>

        <el-form-item prop="checkPassword" label="确认新密码">
            <el-input v-model="resetPasswordForm.checkPassword"  placeholder="输入新密码" name="password_confirmation">
            </el-input>
        </el-form-item>
        <el-button type="primary" @click="submitForm('resetPasswordForm')" class="btn btn-block btn-reset-password" :loading="loading">重置密码</el-button>
    </el-form>
</template>

<script>
    export default{
        data() {
            var validatePassword = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请输入新密码'));
                } else {
                    if (this.resetPasswordForm.checkPassword !== '') {
                        this.$refs.resetPasswordForm.validateField('checkPassword');
                    }
                    callback();
                }
            };
            var validatePassword2 = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请再次输入新密码'));
                } else if (value !== this.resetPasswordForm.password) {
                    callback(new Error('两次输入密码不一致!'));
                } else {
                    callback();
                }
            };
            return {
              resetPasswordForm: {
                password: '',
                checkPassword: '',
              },
              loading:false,
              rules:{
                password: [
                  { validator: validatePassword, trigger: 'blur' }
                ],
                checkPassword: [
                  { validator: validatePassword2, trigger: 'blur' }
                ],
              }
            }
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.loading = true
                        let me = this
                        axios.post('/password_reset',this.resetPasswordForm)
                        .then(function (response) {
                            if (response.data.code === 1)
                            {
                                location.href = '/'
                                me.$message({
                                    message: response.data.message,
                                    type: 'success'
                                });
                            } else {
                                location.href = '/password_forget'
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
                      return false;
                    } 
                });
            },
        }
    }
</script>
