<template>
    <li id="share-item">
        <a class="share-tool" href="#share-anchor">
            <span v-if="textShow">分享</span>
            <span v-else class="glyphicon glyphicon-share-alt"  aria-hidden="true"></span>
        </a>
    </li>
</template>

<script>
    export default{
        data() {
            return {
                textShow :false,
            }
	},
        mounted:function(){
            this.$nextTick(function () {
                let me = this
                let replyItem = document.getElementById('share-item')
                const events = ['mouseenter', 'mouseleave']
                events.forEach((event)=>{
                    replyItem.addEventListener(event, function(){
                        if (event === 'mouseenter'){
                            me.textShow = true
                        } else{
                            me.textShow = false
                        }
                    }, false)
                })
            })
        }
    }
</script>
