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
        <div class="row container">
            <div class="card col-lg-12 border-primary shadow">
                <div class="card-header text-primary" style="font-size: 20px; font-weight: 700;">
                    <i class="fas fa-chart-area"></i>
                    {{$t('product.stock')}}
                </div>
                <form @submit.prevent="stockUpdate" >
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="form-label-group">
                                    <label for="phone">{{$t('product.qty')}}  </label>
                                    <input type="text" v-model="form.product_quantity" class="form-control" required>
                                    <small class="text-danger" v-if="errors.product_quantity">{{ errors.product_quantity[0] }}</small>
                                </div>
                            </div>
                        </div>
                    </div><br>
                    <button type="submit" class="btn btn-success">{{$t('update')}}</button>
                </form><br>
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
                    product_quantity:''
                },
                errors:{},
                isDr:'en'
            }
        },
        created(){
            let id = this.$route.params.id
            axios.get('/api/product/'+id)
                .then(({data}) => (this.form = data))
                .catch()
        },
        methods:{
            stockUpdate(){
                let id = this.$route.params.id
                axios.post('/api/stock/update/'+id,this.form)
                    .then(() => {
                        this.$router.push({ name: 'stock' })
                        Notification.success()
                    })
                    .catch(error => this.errors = error.response.data.errors)
            },
        }
    }
</script>


<style>
.rtl{
    direction: rtl !important;
	text-align: right !important;
}
</style>
