<template>
          	<div v-bind:class="{'rtl': isDr=='dr'}">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item">
                <a href="#">{{$t('dashboard.dashboard')}}</a>
            </li>
            <li class="breadcrumb-item active">{{ $t('bc.product') }}</li>
        </ol>
        <!-- Icon Cards-->
        <div class="row container">
            <div class="card col-lg-12 border-primary shadow mb-3">
                <div class="card-header text-primary" style="font-size: 20px; font-weight: 700;">
                    <i class="fas fa-chart-area"></i>
                    {{$t('product.insert')}}
                    <router-link to="/product" class="btn btn-primary" id="add_new"> {{$t('product.products')}}</router-link>
                </div>
                <div class="card-body">
                    <form @submit.prevent="productInsert" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <label>{{$t('name')}}</label>
                                        <input type="text" v-model="form.product_name" class="form-control" required :placeholder="$t('form.product_name')">
                                        <small class="text-danger" v-if="errors.product_name">{{ errors.product_name[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <label >{{$t('code')}}</label>
                                        <input type="text" v-model="form.product_code" class="form-control"  :placeholder="$t('form.product_code')" >
                                        <small class="text-danger" v-if="errors.product_code">{{ errors.product_code[0] }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampl1">{{$t('product.category')}}</label>
                                        <select class="form-control" id="exampl1" v-model="form.category_id">
                                            <option :value="category.id" v-for="category in categories">{{ category.category_name }}</option>
                                        </select>
                                        <small class="text-danger" v-if="errors.category_id">{{ errors.category_id[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">{{$t('product.supplier')}}</label>
                                        <select class="form-control" v-model="form.supplier_id">
                                            <option :value="supplier.id" v-for="supplier in suppliers" >{{ supplier.name }}</option>
                                        </select>
                                        <small class="text-danger" v-if="errors.supplier_id">{{ errors.supplier_id[0] }}</small>
                                    </div>
                                </div>
                            </div>
                        </div><br>

                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <label>{{$t('product.buying_date')}}</label>
                                        <input type="date" v-model="form.buying_date" class="form-control" required>
                                        <small class="text-danger" v-if="errors.buying_date">{{ errors.buying_date[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <label>{{$t('product.qty')}}</label>
                                        <input type="text" v-model="form.product_quantity" class="form-control" required :placeholder="$t('form.qty')">
                                        <small class="text-danger" v-if="errors.product_quantity">{{ errors.product_quantity[0] }}</small>
                                    </div>
                                </div>
                            </div>
                        </div><br>

                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-label-group">
                                        <label>{{$t('product.root')}}</label>
                                        <input type="text" v-model="form.root" class="form-control" required :placeholder="$t('form.root')">
                                        <small class="text-danger" v-if="errors.root">{{ errors.root[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-label-group">
                                        <label >{{$t('product.buying_price')}}</label>
                                        <input type="text" v-model="form.buying_price" class="form-control" required :placeholder="$t('form.buying_price')">
                                        <small class="text-danger" v-if="errors.buying_price">{{ errors.buying_price[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-label-group">
                                         <label >{{$t('product.selling_price')}} </label>
                                        <input type="text" v-model="form.selling_price" class="form-control" required :placeholder="$t('form.selling_price')">
                                        <small class="text-danger" v-if="errors.selling_price">{{ errors.selling_price[0] }}</small>
                                    </div>
                                </div>
                            </div>
                        </div><br>

                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="file" class="btn btn-info" @change="onFileselected">
                                        <small class="text-danger" v-if="errors.image">{{ errors.image[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <img :src="form.image" style="height:40px; width: 40px;">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">{{$t('submit')}}</button>
                    </form>
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
        data(){
            return{
                form:{
                    product_name :'',
                    product_code :'',
                    category_id:'',
                    supplier_id:'',
                    root :'/',
                    buying_price:'',
                    selling_price : '',
                    buying_date:'',
                    image:'',
                    product_quantity:''
                },
                errors:{},
                categories:{},      //--to take catagory from 'Category' controller
                suppliers:{},       //--to take supplier from 'Supplier' controller
                isDr:'en'
            }
        },
        methods:{
            onFileselected(event){
                let file=event.target.files[0];
                if (file.size > 1048770) {
                    Notification.image_validation()
                }else{
                    let reader = new FileReader();
                    reader.onload = event => {
                        this.form.image = event.target.result
                        //console.log(event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            },
            productInsert(){
                axios.post('/api/product/',this.form)
                    .then(() => {
                        this.$router.push({ name: 'product' })
                        Notification.success()
                    })
                    .catch(error => this.errors = error.response.data.errors)
            },
        },
        created(){            //fatching data from Controller & keeping it in data() property
            axios.get('/api/category')
                .then(({data}) => (this.categories = data))

            axios.get('/api/supplier/')
                .then(({data}) => (this.suppliers = data))
        },
    }
</script>


<style>
.rtl{
    direction: rtl !important;
	text-align: right !important;
}
    #add_new{
        float: right;
    }
</style>
