<template>
    <li id="collect-item">
        <div class="collect-tool" v-if="isCollect" @click="cancel">
            <span v-if="textCancelShow" class="tool-color">已收藏</span>
            <span v-else class="glyphicon glyphicon-heart tool-color"  aria-hidden="true"></span>
        </div>
        <div class="collect-tool" v-else @click="collect">
            <span v-if="textCollectShow">收藏</span>
            <span v-else class="glyphicon glyphicon-heart-empty"  aria-hidden="true"></span>
        </div>     
    </li>
</template>

<script>
    export default{
        data() {
            return {
                textCancelShow :false,
                textCollectShow:false,
                isCollect: false,
            }
	},
        props:{
            dataId:String,
            flagCollect:String,
        },
	methods:{
            collect(){
                let me = this
                axios.post('/articles/'+this.dataId+'/collect')
                .then(function(response){
                    if (response.data.code == 1)
                    {
                       me.isCollect = true
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
               axios.delete('/articles/'+this.dataId+'/unCollect')
                .then(function(response){
                    if (response.data.code == 1)
                    {
                       me.isCollect = false
                    } 
                })
                .catch(function(error){
                    console.log(error)
                })
            },
	},
        mounted:function(){
            this.isCollect = this.flagCollect ==='1' ? true :false
            this.$nextTick(function () {
                let collectItem = document.getElementById('collect-item')
                const events = ['mouseenter', 'mouseleave']
                let me = this
                events.forEach((event)=>{
                    collectItem.addEventListener(event, function(){
                        if (event === 'mouseenter'){
                            me.textCollectShow = true
                            me.textCancelShow = true
                        } else{
                            me.textCollectShow = false
                            me.textCancelShow = false
                        }
                    }, false)
                })
            })
        }
    }
</script>
