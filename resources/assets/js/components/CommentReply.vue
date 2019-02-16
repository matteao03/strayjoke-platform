<template>
    <div class="panel-body" id="article-comment">
        <div class="comment-box">
            <comment-box  :target-id="articleId"  :comment-list.sync="commentList"></comment-box>
        </div>
        <hr>
        <template v-if="commentList.length > 0">
            <comment-list :comment-list="commentList"></comment-list>
        </template>
        <div v-else class="empty-block" id="empty-block">暂无数据 ~_~ </div>
    </div>
</template>

<script>
    export default{
        data() {
            return {
                commentList:[]
            }
	},
        props:{
           articleId:Number,
        },
        methods:{
            getComments(){
                let me = this
                axios.get('/articles/'+this.articleId+'/comments')
                .then(function(response){
                    if (response.data.code == 1)
                    {   
                        me.commentList = response.data.data
                    }
                })
                .catch(function(error){
                    console.log(error)
                })
            }
        },
        mounted:function(){
            this.getComments()
        }
    }
</script>
