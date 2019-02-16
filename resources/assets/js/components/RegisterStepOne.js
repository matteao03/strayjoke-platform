// 注册step1组件
Vue.component('register-step-one', {
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
      };
      return {
        registerForm: {
          mobile: '',
          verifycode: ''
        },
        loading:false,
        verifycodeShow:false, //验证码输入框是否显示
        verifybtnShow:true, //验证点击按钮是否显示
        verifyimgShow:false, //拼图验证是否显示
        countdownShow:true, //倒计时是否显示
        time:120,
        rules:{
            mobile:[
                { validator: checkMobile, trigger: 'blur' }
            ],
            verifycode:[
                { required: true, message: '请输入短信验证码', trigger: 'blur' },
                {pattern:/^\d{6}$/, message:'短信验证码格式不正确', trigger: 'blur'}
            ]
        }
      }
    },
    methods: {
      verifyMobile(formName) {
        this.$refs[formName].validateField('mobile',(validMessage)=>{
          if(validMessage === ""){
              this.verifyimgShow = true; 
          }
        })
      },
      onSuccess(){
        this.sendSms(); //发送短信验证码
      },
      onFail(){
      },
      onRefresh(){
      },
      sendSms(){ 
        let vm = this
        axios.post('/validateCode',{
          mobile:this.registerForm.mobile
        })
        .then(function (response) {
          console.log(response)
            //短信发送成功
            if (response.data.code === 1)
            {
              vm.setCountdown()
              vm.countdownShow = true
            }
            else {
              vm.countdownShow = false
              vm.time = 0
            }
            vm.msgShow(response.data.message)
            vm.setShow()
        })
        .catch(function (error) {
          console.log(error)
            vm.msgShow(error.response.data.message)
            vm.setShow()
            vm.countdownShow = false
            vm.time = 0
        })
      },
      resendSms(formName){
        this.$refs[formName].validateField('mobile',(validMessage)=>{
          if(validMessage === ""){
              this.sendSms()
              this.loading = false
          }
        })
      },
      setShow(){
          this.verifybtnShow = false
          this.verifycodeShow = true
          this.verifyimgShow = false
      },
      setCountdown(){
        //开始倒计时
        let timer = window.setInterval(()=>{
          if (this.time === 0){
              window.clearInterval(timer)
              this.countdownShow = false
              this.time = 120
          }else{
              this.time --
              document.getElementById('countdown').innerText = this.time+'秒'
          }
        }, 1000)   
      },
      submitForm(formName){
        this.$refs[formName].validate((valid) => {
          if (valid) {
            this.loading = true
            let vm = this
            axios.post('/mobile_check',{
              mobile:this.registerForm.mobile,
              verifycode:this.registerForm.verifycode
            })
            .then(function (response) {
                console.log(response)
                //短信发送成功
                if (response.data.code === 1)
                {
                   location.href = '/register_user_info'
                }
                else 
                { 
                  vm.msgShow(response.data.message)
                  vm.setShow()
                  vm.countdownShow = false
                  vm.time = 0
                  vm.loading = false
                }          
            })
            .catch(function (error) {
                console.log(error)
                vm.msgShow(error.response.data.message)
                vm.setShow()
                vm.countdownShow = false
                vm.time = 0
                vm.loading = false
            })
          }
        })
      },
      msgShow(msg){
        let parentDom = document.getElementById('register')
        let alert = document.querySelector('.alert')
        if (alert)
        { 
          parentDom.removeChild(alert);
        }
        let tpl = `<div class="alert alert-danger"><ul><li>${msg}</li></ul></div>`
        let fragment = document.createRange().createContextualFragment(tpl)
        parentDom.insertBefore(fragment, parentDom.firstChild)
      }
    }
});