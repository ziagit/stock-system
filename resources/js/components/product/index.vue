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
        <div class="row card container ml-3 border-primary shadow mb-3">
            <div class="card-header text-primary" style="font-size: 20px; font-weight:700;">
                <i class="fas fa-chart-area"></i>
                {{$t('product.products')}}
                <router-link to="/store-product" class="btn btn-primary" id="add_new"> {{$t('add')}}</router-link>
            </div>
            <div class="card-body pt-0">
                <div class="card-body">
                    <div class="table-responsive" v-if="products">
                        <input type="text" v-model="keywords" class="form-control d-inline" style="width:200px;" :placeholder="$t('form.search_name')"><br><br>
                        <table class="table table-bordered table-striped table-hover table-warning border-primary" id="" width="100%" cellspacing="0">

                            <thead>
                            <tr class="bg-info text-white">
                                <th>{{$t('name')}}</th>
                                <th>{{$t('code')}}</th>
                                <th>{{$t('photo')}}</th>
                                <th>{{$t('product.category')}}</th>
                                <th>{{$t('product.buying_price')}}</th>
                                <th>{{$t('product.selling_price')}}</th>
                                <th>{{$t('root')}}</th>
                                <th>{{$t('action')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="product in products.data" :key="product.id">
                                <td>{{ product.product_name}}</td>
                                <td>{{ product.product_code}}</td>
                                <td><img :src="product.image" id="em_photo"></td>
                                <td>{{ product.category_name }}</td>
                                <td>{{ product.buying_price }}</td>
                                <td>{{ product.selling_price }}</td>
                                <td>{{ product.root }}</td>
                                <td>
                                    <router-link :to="{name: 'edit-product', params:{id: product.id} }" class="btn btn-sm btn-info">Edit</router-link>
                                    <!-- <router-link :to="'/edit-category/'+category.id" class="btn btn-warning mr-1">Edit</router-link> -->   <!--or-->
                                    <!-- <router-link :to="`/edit-category/${category.id}`" class="btn btn-sm btn-primary text-white">Edit</router-link> -->
                                    <a @click="deleteProduct(product.id)" class="btn btn-sm btn-danger text-white">Delete</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <pagination v-if="products" :limit="4" :data="products" @pagination-change-page="allProduct"></pagination>
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
        },
        data(){
            return{
                keywords: null,
                products:null,
                searchTerm:'',
                isDr:'en',
                searchTerm:'',
                isDr:'en'
            }
        },
        watch: {
            keywords(after, before) {
                this.search();
            },
        },
        computed:{
            filtersearch(){
                return this.products.filter(product => {
                    //return product.product_name.match(this.searchTerm)
                    return product.product_name.toLowerCase().match(this.searchTerm.toLowerCase())
                })
            }
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
            allProduct(page=1){
                axios.get("/api/product?page=" + page)
                    .then(({data}) => (this.products = data))
                    .catch()
            },
            deleteProduct(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/product/'+id)
                            .then(()=>{
                                this.products = this.products.filter(product =>{
                                    return product.id !=id
                                })
                            })
                            .catch(()=>{
                                this.$router.push({name: 'product'})
                            })
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            }
        },
    }
</script>


<style>
    #add_new{
        float: right;
    }
    #em_photo{
        height: 40px;
        width: 40px;
    }
    .rtl{
    direction: rtl !important;
	text-align: right !important;
}
</style>
