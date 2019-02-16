<template>
    <span>
        <template v-if="localMobile">
            {{localMobile}} <span @click="unbindMobile" class="unbind-mobile">{{unbindText}}</span>
        </template>
        <template v-else>
            <el-button size="medium" round  type="primary" plain  @click="bindMobile">绑定手机</el-button>
        </template>
        <el-dialog title="解绑手机" :visible.sync="dialogFormVisible">
            <el-form :model="form">
              <el-form-item>
                <el-input v-model="form.mobile" placeholder="手机号"></el-input>
              </el-form-item>
              <el-form-item>
                <el-input v-model="form.code" placeholder="短信验证码"></el-input>
              </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
              <el-button type="primary" @click="dialogFormVisible = false">确 定</el-button>
            </div>
        </el-dialog>
    </span>
</template>

<script>
    export default{
        data(){
            return{
                dialogFormVisible: false,
                localMobile:'',
                form:{
                    mobile:'',
                    code:''
                },
                unbindText:'解绑手机'
            }
        },
        props:{
            mobile:String
        },
        mounted:function(){
            this.localMobile = this.mobile
        },
	methods:{
           unbindMobile(){
                let me = this
                this.unbindText = '解绑中...'
                axios.patch('/user/unbindMobile', {'mobile':me.localMobile})
                    .then(function(response){
                        console.log(response)
                        if (response.data.code == 1)
                        {
                           me.localMobile = ''
                           me.$message({
                                message: response.data.msg,
                                type: 'success'
                            });
                        } else {
                            me.$message.error(response.data.msg);
                        }
                    })
                    .catch(function(error){
                        console.log(error)
                    })
           },
           bindMobile(){
               this.dialogFormVisible = true
           }
        }
    }
</script>
