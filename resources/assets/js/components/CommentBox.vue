<template>
    <div>
        <p id="comment-title">发表评论</p>
        <div class="form-group">
            <textarea class="form-control" rows="3" placeholder="分享你的想法" name="content" id="comment-content"></textarea>
        </div>
        <el-button type="primary" @click="submit" :loading="isLoading">发表</el-button>
        <el-button type="info" @click="cancel">取消</el-button>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                isLoading:false,
            }
        },
        props:{
            targetId:Number,
            commentList:{
                type:Array,
                default:[]
            },
        },
	methods:{
            cancel(){
               let content = document.getElementById('comment-content')
               content.value = ''
            },
            submit(){
                this.submitComment();
            },
            submitComment(){
                this.isLoading = true
                let content = document.getElementById('comment-content')
                let me = this
                axios.post('/comments',{
                    content:content.value,
                    article_id:me.targetId,
                })
                .then(function(response){
                    me.isLoading = false
                    if (response.data.code == 1)
                    {
                       content.value = ''
                       me.commentList.push(response.data.data)
                       me.$emit('commentList', me.commentList)
                    } 
                })
                .catch(function(error){
                    me.isLoading = false
                    console.log(error)
                })
            }
        }
    }
</script>
