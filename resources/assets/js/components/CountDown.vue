<template>
    <el-button 
        class="count-down" 
        :disabled="countDown ? true : false"
    >
        {{countDown ? countDown+'s 重发' : text}}
    </el-button>
</template>

<script>
    export default {
        data(){
            return{
                countDown:0,
            }
        },
        props:{
            text:{
                type:String,
                default:'获取验证码'
            },
            second:{
                type:Number,
                default:120
            },
            start:{
                type:Boolean,
                default:false
            }
        },
        watch:{
            start:function(val){
                if (val){
                    this.countDown = this.second
                    this.countDownMethod()
                } else {
                    this.countDown = this.second
                }
            }
        },
        methods:{
            countDownMethod(){
                if (this.countDown > 0){
                    setTimeout(()=>{
                        this.countDown -=1
                        this.countDownMethod()
                    }, 1000)
                }
            }
        }
    }
</script>
