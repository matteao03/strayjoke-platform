//点赞组件
Vue.component('gift-tool', {
	data() {
		return {
                    textShow :false,
                    dialogVisible:false,
                    customMoneyShow:false,
                   
                    form: {
                      money:2,
                      comment:'',
                      type:'alipay',
                    }
		}
	},
        props:{
            articleId:String,
        },
	methods:{
		showMoneyDialog(){
                    this.dialogVisible = true
                },
                setMoney(){
                    this.customMoneyShow = true
                },
                parseIntMoney(){
                    let e = event
                    let customInput = document.getElementById('customInput')
                    
                    value = parseInt(Math.min(Math.max(customInput.value, 0), 10000), 10) 
                    customInput.value = value
                    this.form.money = value
                },
                clickRadio(value){
                    this.form.money = value
                    this.customMoneyShow = false
                },
                goToPay(){
                    let me = this
                    axios.post('/orders',{
                        money:me.form.money,
                        comment:me.form.comment,
                        articleId:me.articleId
                    })
                   .then(function(response){
                        console.log(response) 
                        if (response.data.code == 1){
                            location.href="/payment/"+ response.data.data.id+"/alipay"
                        }
                    })
                    .catch(function(error){
                        console.log(error)
                    })
                }
	},
        mounted:function(){
            this.$nextTick(function () {
                let me = this
                let giftItem = document.getElementById('gift-item')
                const events = ['mouseenter', 'mouseleave']
                events.forEach((event)=>{
                    giftItem.addEventListener(event, function(){
                        if (event === 'mouseenter'){
                            me.textShow = true
                        } else{
                            me.textShow = false
                        }
                    }, false)
                })
                
                let token = document.head.querySelector('meta[name="csrf-token"]')
                me.token = token.content
            })
        },
	template:`<li id="gift-item">
                    <div class="gift-tool" @click="showMoneyDialog">
                        <span v-if="textShow">打赏</span>
                        <span v-else class="glyphicon glyphicon-gift"  aria-hidden="true"></span>
                    </div>
                    <el-dialog title="打赏作者" :visible.sync="dialogVisible" :center="true"
                    :append-to-body="true" width="500px" :close-on-click-modal="true"
                    :close-on-press-escape="false">
                       
                          <el-row type="flex" :gutter="20" justify="space-around">
                            <el-col :span="8">
                                <el-button v-if="form.money==2" plain type="primary" icon="el-icon-star-off" 
                                    size="medium" style="width:136px;font-size:18px;">2元</el-button>
                                <el-button v-else plain icon="el-icon-star-off" @click="clickRadio(2)"
                                    size="medium" style="width:136px;font-size:18px;">2元</el-button>
                            </el-col>
                             <el-col :span="8">
                                <el-button v-if="form.money==5" plain type="primary" icon="el-icon-star-off" 
                                    size="medium" style="width:136px;font-size:18px;">5元</el-button>
                                <el-button v-else plain icon="el-icon-star-off" @click="clickRadio(5)"
                                    size="medium" style="width:136px;font-size:18px;">5元</el-button>
                            </el-col>
                             <el-col :span="8">
                                <el-button v-if="form.money==10" plain type="primary" icon="el-icon-star-off" 
                                    size="medium" style="width:136px;font-size:18px;">10元</el-button>
                                <el-button v-else plain icon="el-icon-star-off"  @click="clickRadio(10)"
                                    size="medium" style="width:136px;font-size:18px;">10元</el-button>
                            </el-col>
                          </el-row>
                          <el-row type="flex" :gutter="20" justify="space-around" style="margin-top:20px;">
                             <el-col :span="8">
                                <el-button v-if="form.money==20" plain type="primary" icon="el-icon-star-off" 
                                    size="medium" style="width:136px;font-size:18px;">20元</el-button>
                                <el-button v-else plain icon="el-icon-star-off" @click="clickRadio(20)"
                                    size="medium" style="width:136px;font-size:18px;">20元</el-button>
                            </el-col>
                            <el-col :span="8">
                                <el-button v-if="form.money==50" plain type="primary" icon="el-icon-star-off" 
                                    size="medium" style="width:136px;font-size:18px;">50元</el-button>
                                <el-button v-else plain icon="el-icon-star-off" @click="clickRadio(50)"
                                    size="medium" style="width:136px;font-size:18px;">50元</el-button>
                            </el-col>
                            <el-col :span="8">
                                <input v-if="customMoneyShow" type="number" @input="parseIntMoney" 
                                    id="customInput" autofocus="autofocus"
                                    style=" width:100%;padding:10px 20px;border-radius:4px;
                                        line-height:1;border: 1px solid #409eff;">    
                                <el-button  v-else plain size="medium" style="width:136px;font-size:18px;" 
                                    @click="setMoney">自定义</el-button>
                            </el-col>
                          </el-row>
                          <div class="gift-comment">
                            <el-input type="textarea" placeholder="给Ta留言..." :rows="3" v-model="form.comment"></el-input>
                          </div>
                        
                        <div style="margin:20px auto -20px; font-size:18px; text-align:center; color:#409eff; ">金额￥{{form.money}}元</div>
                        <div slot="footer" class="dialog-footer">
                          <el-button type="primary" @click="goToPay">支付宝支付</el-button>
                        </div>
                      </el-dialog>
                  </li>`
})