<template>
    <li id="good-item">
        <div class="good-tool" v-if="isLike" @click="cancel">
            <span v-if="textCancelShow" class="tool-color">已点赞</span>
            <span v-else class="glyphicon glyphicon-thumbs-up tool-color"  aria-hidden="true"></span>
        </div>
        <div class="good-tool" v-else @click="like">
            <span v-if="textLikeShow">点赞</span>
            <span v-else class="glyphicon glyphicon-thumbs-up"  aria-hidden="true"></span>
        </div>     
    </li>
</template>

<script>
    export default{
        data() {
            return {
                textCancelShow :false,
                textLikeShow:false,
                isLike: false,
            }
	},
        props:{
            dataId:String,
            flagLike:String,
        },
	methods:{
            like(){
                let me = this
                axios.post('/articles/'+this.dataId+'/like')
                .then(function(response){
                    if (response.data.code == 1)
                    {
                       me.isLike = true
                    } 
                })
                .catch(function(error){
                    if (error.response && error.response.status === 401){
                         swal('请先登录', '', 'error');
                    }
                })
            },
            cancel(){
                let me = this
                axios.delete('/articles/'+this.dataId+'/unLike')
                .then(function(response){
                    if (response.data.code == 1)
                    {
                       me.isLike = false
                    } 
                })
                .catch(function(error){
                    console.log(error)
                })
            }
	},
        mounted:function(){
            this.isLike = this.flagLike ==='1' ? true :false
            this.$nextTick(function () {
                let me = this
                let goodItem = document.getElementById('good-item')
                const events = ['mouseenter', 'mouseleave']
                events.forEach((event)=>{
                    goodItem.addEventListener(event, function(){
                        if (event === 'mouseenter'){
                            me.textLikeShow = true
                            me.textCancelShow = true
                        } else{
                            me.textLikeShow = false
                            me.textCancelShow = false
                        }
                    }, false)
                })
            })
        }
    }
</script>
