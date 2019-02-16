<template>
    <el-form  
            ref="authInfoForm" 
            :model="authInfoForm" :rules="rules" 
            label-position="top" 
            :hide-required-asterisk="true"  
            id="register-user-info-form"
    >
        <el-form-item prop="nickname" label="昵称">
            <el-input v-model="authInfoForm.nickname"  placeholder="输入昵称" name="nickname">
            </el-input>
        </el-form-item>

        <el-form-item prop="password" label="密码">
            <el-input v-model="authInfoForm.password"  placeholder="输入密码" name="password">
            </el-input>
        </el-form-item>

        <el-form-item prop="checkPassword" label="确认密码">
            <el-input v-model="authInfoForm.checkPassword"  placeholder="输入密码" name="password_confirmation">
            </el-input>
        </el-form-item>
        <el-button type="primary" @click="submitForm('authInfoForm')" class="btn btn-block btn-login" :loading="loading">提交</el-button>
    </el-form>
</template>

<script>
    export default{
        data() {
            var checkNickname = (rule, value, callback) => {
                if (!value) {
                  return callback(new Error('昵称不能为空'));
                } else {
                  callback();
                }
            };
            var validatePassword = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请输入密码'));
                } else {
                    if (this.authInfoForm.checkPassword !== '') {
                        this.$refs.authInfoForm.validateField('checkPassword');
                    }
                    callback();
                }
            };
            var validatePassword2 = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请再次输入密码'));
                } else if (value !== this.authInfoForm.password) {
                    callback(new Error('两次输入密码不一致!'));
                } else {
                    callback();
                }
            };
            return {
              authInfoForm: {
                password: '',
                checkPassword: '',
                nickname: ''
              },
              loading:false,
              rules:{
                password: [
                  { validator: validatePassword, trigger: 'blur' }
                ],
                checkPassword: [
                  { validator: validatePassword2, trigger: 'blur' }
                ],
                nickname: [
                  { validator: checkNickname, trigger: 'blur' }
                ]
              }
            }
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.loading = true
                        let me = this
                        axios.post('/auth_info',this.authInfoForm)
                        .then(function (response) {
                            if (response.data.code === 1)
                            {
                                location.href = '/'
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
                            me.loading = false
                        })
                        .catch(function (error){ me.loading = false })
                    } else {
                      return false;
                    } 
                });
            },
        }
    }
</script>
