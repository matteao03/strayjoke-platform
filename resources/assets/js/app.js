
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import { Form, Button, Input, FormItem, Steps, Step, Dialog, Radio, Row, Col, Message, MessageBox} from 'element-ui'
import '../icon/iconfont.css'
import SlideVerify from 'vue-monoplasty-slide-verify'; //滑块拼图验证码

// element-ui 组件
Vue.component(Button.name, Button);
Vue.component(Form.name, Form);
Vue.component(Input.name, Input);
Vue.component(FormItem.name, FormItem);
Vue.component(Dialog.name, Dialog);
Vue.component(Radio.name, Radio);
Vue.component(Row.name, Row);
Vue.component(Col.name, Col);
Vue.prototype.$message = Message;
Vue.prototype.$msgbox = MessageBox;

Vue.use(Steps);
Vue.use(Step);
//滑块拼图验证 组件
Vue.use(SlideVerify);

require('./components/RegisterStepOne')
require('./components/RegisterStepTwo')
require('./components/GiftTool')

Vue.component('ThumbsUp', require('./components/ThumbsUp.vue'));
Vue.component('CommentReply', require('./components/CommentReply.vue'));
Vue.component('CommentBox', require('./components/CommentBox.vue'));
Vue.component('CommentList', require('./components/CommentList.vue'));
Vue.component('CollectTool', require('./components/CollectTool.vue'));
Vue.component('ShareTool', require('./components/ShareTool.vue'));
Vue.component('LoginForm', require('./components/LoginForm.vue'));
Vue.component('RegisterForm', require('./components/RegisterForm.vue'));
Vue.component('RegisterAuthInfoForm', require('./components/RegisterAuthInfoForm.vue'));
Vue.component('ForgetPasswordForm', require('./components/ForgetPasswordForm.vue'));
Vue.component('ResetPasswordForm', require('./components/ResetPasswordForm.vue'));
Vue.component('BindMobile', require('./components/BindMobile.vue'));

const app = new Vue({
    el: '#app'
});
