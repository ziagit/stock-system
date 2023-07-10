<template>
                     	<div v-bind:class="{'rtl': isDr=='dr'}">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item">
                <a href="#">{{$t('dashboard.dashboard')}}</a>
            </li>
            <li class="breadcrumb-item active">{{ $t('bc.pos') }}</li>
        </ol>

        <div class="row mb-4">
    <!--------------------------Left_Side_"Expense Insert"------------2nd_task----------->
            <div class="card col-lg-5 border-primary shadow">
                <div class="card-header text-primary">
                    <i class="fas fa-chart-area"></i>
                    <b>{{$t('pos.expense_insert')}}</b>
                    <a class="btn btn-sm btn-primary text-white" data-toggle="modal" data-target="#exampleModal" id="add_new"> {{$t('pos.new_customer')}}</a>
                </div>

                <div class="card-body">
                    <table class="table table-sm table-striped">
                        <thead>
                        <tr>
                            <th scope="col">{{$t('name')}}</th>
                            <th scope="col">{{$t('qty')}}</th>
                            <th scope="col">{{$t('unit')}}</th>
                            <th scope="col">{{$t('total')}}</th>
                            <th scope="col">{{$t('action')}}</th>
                        </tr>
                        </thead>
                        <tbody>                
                        <tr v-for="card in cards" :key="card.id">      
                            <th>{{ card.pro_name }}</th>
                            <td><input type="text" 
                                style="width:70px;" 
                                v-model="card.pro_quantity" 
                                @blur="handleInputChange(card)">
                            </td>
                            <td>{{ card.product_price }}</td>
                            <td>{{ card.sub_total }}</td>
                            <td><a @click="removeItem(card.id)" class="btn btn-sm btn-danger text-white">x</a></td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                </div>
                <div class="card-footer">       
                    <ul class="list-group" v-bind:class="{'no-padding': isDr=='dr'}">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{$t('pos.product_qty')}}:
                            <strong>{{ qty }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{$t('subtotal')}}:
                            <strong>{{ subtotal }} {{$t('currency')}}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{$t('pos.vat')}}:
                            <strong> {{ vats.vat }} % </strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{$t('total')}}:
                            <strong> {{ subtotal*vats.vat /100 +subtotal }} {{$t('currency')}}</strong>
                        </li>
                    </ul>
                    <br>                   <!-----Expense_Insert_Table(Bottom_Left)------>
                    <form @submit.prevent="orderdone">          <!--------------2----------------->
                        <label>{{$t('pos.customer')}}</label>
                        <select class="form-control" v-model="customer_id">
                            <option :value="customer.id" v-for="customer in customers">{{ customer.name }}</option>
                        </select>

                       
                        <label>{{$t('pos.pay')}}</label>
                        <input type="text" class="form-control" required v-model="pay">

                        <label>{{$t('pos.due')}}</label>                             
                        <input type="text" class="form-control" required :value="((subtotal*vats.vat /100 +subtotal) - pay).toFixed(2)">

                        <label>{{$t('pos.payby')}}</label>
                        <select class="form-control" v-model="payby">
                            <option value="HandCash">{{$t('pos.cash')}}</option>
                            <option value="Cheaque">{{$t('pos.cheaque')}}</option>
                            <option value="GiftCard">{{$t('pos.card')}}</option>
                        </select>

                        <label>{{$t('pos.discount')}}</label>
                        <input type="number" class="form-control"  v-model="discount">

                        <br>
                        <button type="submit" class="btn btn-success mb-4">{{$t('submit')}}</button>
                    </form>
                </div>
            </div>

    <!------------------customer add modal------------------2-------->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{$t('pos.new_customer')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="customerInsert" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-label-group">
                                                <input type="text" v-model="form.name" class="form-control" required>
                                                <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                                                <label for="firstName">{{$t('name')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-label-group">
                                                <input type="email" v-model="form.email" class="form-control" >
                                                <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                                                <label for="lastName">{{$t('email')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-label-group">
                                                <input type="text" v-model="form.address" class="form-control" >
                                                <small class="text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
                                                <label for="firstName">{{$t('address')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-label-group">
                                                <input type="text" v-model="form.phone" class="form-control" >
                                                <label for="lastName">{{$t('phone')}}</label>
                                                <small class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-label-group">
                                                <input type="file" class="btn" @change="onFileselected">
                                                <small class="text-danger" v-if="errors.photo">{{ errors.photo[0] }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <img :src="form.photo" style="height:40px; width: 40px;">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">{{$t('submit')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    <!------------end customer modal------------------------->




<!--------------Right_Side_"Product"----------1st_task----------1----->
            <div class="card col-lg-7 border-primary">
                <div class="card-header text-primary">
                    <i class="fas fa-chart-area"></i>
                    <b>{{$t('product.products')}}</b>
                </div>

                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" v-bind:class="{'no-padding': isDr=='dr'}">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">{{$t('pos.all_product')}}</a>
                        </li>

                        <li class="nav-item" v-for="category in categories" :key="category.id">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false" @click="subproduct(category.id)">{{ category.category_name }}</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">

                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <input type="text" v-model="keywords" class="form-control" :placeholder="$t('form.search_here')"><br>
                            <div>
                                <table class="table table-bordered table-striped table-hover table-warning border-primary" id="" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="bg-info text-white">
                                            <th>{{$t('name')}}</th>
                                            <th>{{$t('photo') }}</th>
                                            <th>{{$t('qty')}}</th>
                                            <th>{{$t('price')}}</th>
                                            <th>{{$t('action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(product,index) in products.data" :key="index">
                                            <td>{{ product.product_name }}</td>
                                            <td><img :src="product.image" id="em_photo" style="max-width: 40px; max-height: 40px;"></td>
                                            <td :style="{ color: product.product_quantity >= 1 ? 'black' : 'red' }">{{ product.product_quantity }}</td>
                                            <td>{{ product.selling_price }}</td>
                                            <td>
                                                <button v-if="product.product_quantity >= 1" class="btn btn-sm btn-success" @click.prevent="AddToCart(product.id,product)">Add</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <pagination :limit="4" :data="products" @pagination-change-page="allProduct"></pagination>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted(){
            if (!User.loggedIn()) {
                this.$router.push({ name:'/' })
            }
            if (localStorage.getItem("locale")) {
                this.$i18n.locale = localStorage.getItem("locale");
                this.isDr = localStorage.getItem("locale");
            } else {
                localStorage.setItem("locale", this.$i18n.locale);
                this.isDr = localStorage.getItem("locale");
            }
        },
        created(){
            this.allProduct();    
            this.allCategory();   
            this.allCustomer();     
            this.cartProduct();        
            this.vat();
            Reload.$on('AfterAdd', ()=>{    
                this.cartProduct();
            });
            Reload.$on('customerReload',()=>{   
                this.allCustomer();
            })
        },
        data(){
            return{
                form:{                   
                    name :'',
                    email :'',
                    address:'',
                    photo :'',
                    phone:'',
                },
                keywords: null,
                customer_id:'',     
                pay:'',
                due:'',
                discount:0,
                payby:'',
                products:null,       
                categories:'',     
                getproducts:[],    
                searchTerm:'',     
                getsearchTerm:'',  
                customers:'',          
                errors:'',         
                cards:[],                   
                vats:'',
                isDr:'en',
                cardIndex:null,
                oldValue:null,
            }
        },
        watch:{
             clonedItems: function(newVal, oldVal){
                for(let i=0;i<newVal.length;i++){
                    if(oldVal[i]!=undefined &&(newVal[i].pro_quantity!=oldVal[i].pro_quantity)){
                        this.cardIndex=i;
                        this.oldValue = oldVal[i].pro_quantity;
                    }
                }
            },
            keywords(after, before) {
                this.search();
            },
        },
        computed:{
             clonedItems: function(){
                 return JSON.parse(JSON.stringify(this.cards))
             },
            filtersearch(){                
                return this.products.filter(product => {
                    return product.product_name.toLowerCase().match(this.searchTerm.toLowerCase())
                })
            },
            getfiltersearch(){             
                return this.getproducts.filter(getproduct => {
                    return getproduct.product_name.toLowerCase().match(this.getsearchTerm.toLowerCase())
                })
            },
            qty(){
                let sum=0;
                for(let i=0; i < this.cards.length; i++ ){
                    sum += (parseFloat(this.cards[i].pro_quantity));
                }
                return sum;
            },
            subtotal(){
                let sum=0;
                for(let i=0; i < this.cards.length; i++){
                    sum += (parseFloat(this.cards[i].pro_quantity) * parseFloat(this.cards[i].product_price));
                }
                return sum;
            },
        },
        methods:{
            search() {
                axios.get("/api/search-product", {
                        params: {
                            keywords: this.keywords,
                        },
                    })
                    .then((res) => {
                        console.log("search: ",res.data)
                        this.products = res.data;
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            },
            checkProduct(product){
                var available=false;
                var isInCard=false;

                this.cards.forEach(card => {
                    if(card.pro_id==product.id){
                        isInCard=true;
                        var cardQty = parseInt(card.pro_quantity);
                        var qty = parseInt(product.product_quantity);
                        if(cardQty < qty){
                            available=true;
                        }
                    }
                });
                if(!isInCard) return true;
                return available;
            },
            AddToCart(id,product){
               if(!this.checkProduct(product)){
                return;
               }

                axios.get('/api/addTocart/'+id)
                    .then(() => {
                        Reload.$emit('AfterAdd');
                        Notification.cart_success()
                    })
            },
            cartProduct(){                         
                axios.get('/api/cart/product')
                    .then(({data}) => (this.cards = data))
                    .catch()
            },
            removeItem(id){                        
                axios.get('/api/remove/cart/'+id)
                    .then(() => {
                        Reload.$emit('AfterAdd');
                        Notification.success()
                    })
            },
            increment(id){    
                axios.get('/api/increment/'+id)
                    .then(() => {
                        Reload.$emit('AfterAdd');
                        Notification.success()
                    })
            },
            decrement(id){     
                axios.get('/api/decrement/'+id)
                    .then(() => {
                        Reload.$emit('AfterAdd');
                        Notification.success()
                    })
            },
            handleInputChange(card){
                axios.get('/api/updateCard/'+ card.id,{params:{
                    qty:card.pro_quantity,
                    product_id:card.pro_id,
                }})
                    .then((res) => {
                        console.log(res.data)
                        Reload.$emit('AfterAdd');
                        Notification.success()
                    }).catch((err)=>{
                        this.cards[this.cardIndex].pro_quantity = this.oldValue;
                        Notification.error();
                    })
            },
            vat(){
                axios.get('/api/vats')
                    .then(({data}) => (
                    this.vats = data))
                    .catch()
            },
           
            orderdone(){
                let total = this.subtotal * this.vats.vat /100 + this.subtotal;
                let due = (total - this.pay).toFixed(2)         //variable.toFixed(2)=take 2 specified decimal number
                var data = {qty:this.qty, subtotal:this.subtotal, customer_id:this.customer_id, payby:this.payby, pay:(this.pay-this.discount), due:due, vat:this.vats.vat, total:total,discount:this.discount}       //due:this.due //due_dynamic

                axios.post('/api/orderdone/',data)
                .then(()=>{
                    Notification.success()
                    this.$router.push({ name: 'home'})
                })
            },
            //---End_cart_methods----

            allProduct(){                                        
                axios.get('/api/product')
                    .then(({data}) => (this.products = data))
                    .catch()
            },
            allCategory(){                                      
                axios.get('/api/category/')
                    .then(({data}) => (this.categories = data))
                    .catch()
            },
            allCustomer(){                              
                axios.get('/api/Customer/')
                    .then(({data}) => (this.customers = data))
                    .catch()
            },
            subproduct(id){                                      
                axios.get('/api/getting/product/'+id)
                    .then(({data}) => (this.products = data))
                    .catch(error => this.errors = error.response.data.errors)
            },
            //---image validationmethod---
            onFileselected(event){               
                let file=event.target.files[0];
                if (file.size > 1048770) {
                    Notification.image_validation()
                }else{
                    let reader = new FileReader();
                    reader.onload = event => {
                        this.form.photo = event.target.result

                        console.log(event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            },
            customerInsert(){                  
                axios.post('/api/Customer/',this.form)
                    .then(() => {
                        $('#closeModal').click();
                        Reload.$emit('customerReload'); 
                        Notification.success()
                    })
            }
        }
    }
</script>


<style scoped>
.no-padding{
    padding: 0;
}
 .rtl{
    direction: rtl !important;
	text-align: right !important;
}
    #add_new{
        float: right;
    }
    #em_photo{
        height: 100px;
        width: 90px;
    }
</style>
