<template>
    <ul id="comment-list">
            <li v-for="(item,index) in comments" :key="index" class="article-comment" >
                <div :id=" 'comment-'+item.id">
                    <div class="comment-other">
                        <img :src="item.user.avatar ? item.user.avatar : '/images/avatar-default.png'" class="avatar">
                        <span>{{item.user.nickname}}</span>
                        <span>{{item.created_at}}&nbsp;&nbsp;&nbsp;</span>
                        <span>点赞</span>
                        <span @click="toComment(item,index)">回复</span>                                
                    </div>
                    {{item.content}}
                
                    <template v-if="replyList">
                        <ul class="media-list reply-list">
                            <template v-for="(item2,index2) in replyList">
                                <li class="media" v-if="item2.comment_id === item.id" :key="index2">
                                    <div class="media-left">
                                       <img src="" class="avater">
                                    </div> 
                                    <div class="media-body" :id=" 'reply-'+item2.id">
                                        <div class="media-heading">
                                            <span>{{item2.user.nickname}}</span>
                                            <span>{{item2.created_at}}&nbsp;&nbsp;&nbsp;</span>
                                            <span>点赞</span>
                                            <span @click="toReply(item2, index, item)">回复</span>                                
                                        </div>
                                        {{item2.content}}
                                        <template v-if="item2.reply_id">
                                            <span>//@matteao:{{item2.reply.content}}</span>
                                        </template>
                                    </div>
                                </li>
                            </template>
                        </ul>
                    </template>
        
                    <template v-if="item.reply_count > 0">
                        <div @click="showReplyList(item.id)" class="reply-counter">共有{{item.reply_count}}条回复</div>
                    </template> 
                    
                    <div v-if="item.boxShow">
                        <p id="comment-title">{{boxTitle}}</p>
                        <div class="form-group">
                            <textarea class="form-control" rows="3" placeholder="回复TA" name="content" id="reply-content"></textarea>
                        </div>
                        <el-button type="primary" @click="submitReply(item,index)" :loading="isLoading">发表</el-button>
                        <el-button type="info" @click="cancel(item,index)">取消</el-button>
                    </div>
                </div>        
            </li>
    </ul>
</template>

<script>
    export default{
        data() {
            return {
                replyList:[],
                commentId:0,
                replyId:0,
                boxTitle:'',
                comments:[],
                isLoading:false,
            }
	},
        props:{
            commentList:{
                type:Array,
                default:[]
            }
        },
        methods:{
            toComment(target,index){
                this.commentId = target.id
                this.replyId = 0
                this.boxTitle = '@'+target.user.nickname
                target.boxShow = true
                this.$set(this.comments,index, target)
                this.$emit('commentList', this.comments)
            },
            toReply(target,index, parent){
                this.commentId = target.comment_id
                this.replyId = target.id
                this.boxTitle = '@'+target.user.nickname
                parent.boxShow = true
                this.$set(this.comments,index, parent)
                this.$emit('commentList', this.comments)
            },
            cancel(target, index){
                let content = document.getElementById('reply-content')
                content.value = ''
                this.commentId = target.id
                target.boxShow = false
                this.$set(this.comments,index, target)
                this.$emit('commentList', this.comments)
            },
            submitReply(target,index){
                this.isLoading = true
                let content = document.getElementById('reply-content')
                let me = this
                axios.post('/replies',{
                    content:content.value,
                    comment_id:me.commentId,
                    reply_id:me.replyId,
                })
                .then(function(response){
                    me.isLoading = false
                    if (response.data.code == 1)
                    {
                       me.replyList.push(response.data.data)
                       me.$emit('replyList', me.replyList)
                       me.cancel(target,index)
                    } 
                })
                .catch(function(error){
                    me.isLoading = false
                    console.log(error)
                })
            },
            showReplyList(comment_id){
               if (comment_id){
                   let me = this
                   axios.get('/comments/'+comment_id+'/replies')
                    .then(function(response){
                        if (response.data.code == 1){            
                            me.replyList.push(...response.data.data)
                            document.querySelector('#comment-'+comment_id+' .reply-counter').classList.add('reply-list-hide')
                        }
                    })
                    .catch(function(error){
                        console.log(error)
                    })
               }
           }
        },
        mounted:function(){
            this.comments = this.commentList
        }
    }
</script>
