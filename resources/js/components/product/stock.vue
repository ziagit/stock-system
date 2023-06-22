<template>
                	<div v-bind:class="{'rtl': isDr=='dr'}">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item">
                <a href="#">{{$t('dashboard.dashboard')}}</a>
            </li>
            <li class="breadcrumb-item active">{{ $t('bc.stock') }}</li>
        </ol>
        <!-- Icon Cards-->
        <div class="row card container ml-3 border-primary shadow mb-3">
            <div class="card-header text-primary" style="font-size: 20px; font-weight:700;">
                <i class="fas fa-chart-area"></i>
                {{$t('product.stock')}}
            </div>
            <div class="card-body">
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <input type="text" v-model="searchTerm" class="form-control d-inline" style="width:200px" :placeholder="$t('form.search_name')"><br> <br>
                        <table class="table table-bordered table-striped table-hover table-warning" width="100%" cellspacing="0">
                            <thead>
                            <tr class="bg-info text-white">
                                <th>{{$t('name')}}</th>
                                <th>{{$t('code')}}</th>
                                <th>{{$t('photo')}}</th>
                                <th>{{$t('product.category')}}</th>
                                <th>{{$t('product.status')}}</th>
                                <th>{{$t('product.availability')}}</th>
                                <th>{{$t('action')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="product in filtersearch" :key="product.id">
                                <td>{{ product.product_name}}</td>
                                <td>{{ product.product_code}}</td>
                                <td><img :src="product.image" id="em_photo"></td>
                                <td>{{ product.category_name }}</td>
                                <td v-if="product.product_quantity >= 1"><span class="badge badge-success">{{$t('product.available')}}</span></td>
                                <td v-else=""><span class="badge badge-danger">{{$t('product.stock_out')}}</span></td>
                                <td>{{ product.product_quantity }}</td>
                                <td>
                                    <router-link :to="{name: 'edit-stock', params:{id: product.id} }" class="btn btn-sm btn-info">{{$t('edit')}}</router-link>
                                    <!-- <router-link :to="'/edit-category/'+category.id" class="btn btn-warning mr-1">Edit</router-link> --> <!--or, -->
                                    <!-- <router-link :to="`/edit-category/${category.id}`" class="btn btn-sm btn-primary text-white">Edit</router-link> -->
                                </td>
                            </tr>
                            </tbody>
                        </table>
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
        },

        data(){
            return{
                products:[],
                searchTerm:'',
                isDr:'en'
            }
        },
        computed:{
            filtersearch(){
                return this.products.filter(product => {
                    // return product.product_name.match(this.searchTerm)
                    return product.product_name.toLowerCase().match(this.searchTerm.toLowerCase())
                })
            }
        },
        methods:{
            allProduct(){
                axios.get('/api/product/')
                    .then(({data}) => (this.products = data))
                    .catch()
            }
        }
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
    #em_photo{
        height: 40px;
        width: 40px;
    }
</style>
