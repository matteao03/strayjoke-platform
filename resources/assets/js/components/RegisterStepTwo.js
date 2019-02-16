// 注册step1组件
Vue.component('register-step-two', {
  data() {
      var checkNickname = (rule, value, callback) => {
        if (!value) {
          return callback(new Error('昵称不能为空'));
        } else {
          callback();
        }
        
      };
      var validatePass = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入密码'));
        } else {
          if (this.registerUserInfoForm.checkPass !== '') {
            this.$refs.registerUserInfoForm.validateField('checkPass');
          }
          callback();
        }
      };
      var validatePass2 = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请再次输入密码'));
        } else if (value !== this.registerUserInfoForm.pass) {
          callback(new Error('两次输入密码不一致!'));
        } else {
          callback();
        }
      };
      return {
        registerUserInfoForm: {
          pass: '',
          checkPass: '',
          nickname: ''
        },
        loading:false,
        rules:{
          pass: [
            { validator: validatePass, trigger: 'blur' }
          ],
          checkPass: [
            { validator: validatePass2, trigger: 'blur' }
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
            let form = document.getElementById('register-user-info-form')
            form.submit()
          } else {
            return false;
          } 
        });
      },
    }
});