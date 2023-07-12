<template>
                      	<div v-bind:class="{'rtl': isDr=='dr'}">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item">
                <a href="#">{{$t('dashboard.dashboard')}}</a>
            </li>
            <li class="breadcrumb-item active">{{ $t('bc.order') }}</li>
        </ol>

        <!-----Order------->
        <div class="row container">
            <div class="card col-lg-12 border-primary shadow mb-3">
                <div class="card-header text-primary" style="font-size: 20px; font-weight: 700;">
                    <i class="fas fa-chart-area"></i>
                    {{ $t('order.order') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-6">
                            <ul class="list-group">
                                <li class="list-group-item bg-info text-white">{{ $t('order.customer') }}</li>
                                <li class="list-group-item">{{$t('order.product')}}: {{ orders.name }}</li>
                                <li class="list-group-item">{{$t('phone')}}: {{ orders.phone }}</li>
                                <li class="list-group-item">{{$t('address')}}: {{ orders.address }}</li>
                                <li class="list-group-item">{{$t('date')}}: {{ orders.order_date }}</li>
                                <li class="list-group-item">{{$t('qty')}}: {{ orders.qty }}</li>
                            </ul>
                        </div>
                        <div class="col-lg-6 col-md-6 col-6">
                            <ul class="list-group">
                                <li class="list-group-item">{{$t('price')}}: {{orders.sub_total}}</li>
                                <li class="list-group-item">{{$t('order.vat')}}: {{ orders.vat }}</li>
                                <li class="list-group-item">{{$t('total')}}: {{ orders.total }}</li>
                                <li class="list-group-item">{{$t('order.pay')}}: {{ orders.pay }}</li>
                                <li class="list-group-item">{{$t('order.due')}}: {{ orders.due }}</li>
                                <li class="list-group-item">{{$t('order.payby')}}: {{ orders.payby=='HandCash'?'نقدی':orders.payby }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> <br>


        <!--------Order Details--------->
        <div class="row container">
            <div class="card col-lg-12 border-primary shadow mb-3">
                <div class="card-header text-primary" style="font-size: 20px; font-weight: 700;">
                    <i class="fas fa-chart-area"></i>
                    {{$t('order.products')}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- <input type="text" v-model="searchTerm" class="form-control d-inline" style="width:200px;" :placeholder="$t('form.search_name')"><br><br> -->
                        <table class="table table-bordered table-striped table-hover table-warning border-primary" id="" width="100%" cellspacing="0">

                            <thead>
                                <tr class="bg-info text-white">
                                    <th>{{$t('order.product')}}</th>
                                    <th>{{$t('order.code')}}</th>
                                    <th>{{$t('order.image')}}</th>
                                    <th>{{$t('order.qty')}}</th>
                                    <th>{{$t('order.unit_price')}}</th>
                                    <th>{{$t('order.total')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="detail in details" :key="detail.id">
                                    <td>{{ detail.product_name}}</td>
                                    <td>{{ detail.product_code}}</td>
                                    <td><img :src="'/'+detail.image" id="em_photo"></td>
                                    <td>{{ detail.pro_quantity }}</td>
                                    <td>{{ detail.product_price }}</td>
                                    <td>{{ detail.sub_total }}</td>
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
        data(){
            return{
                //errors:{},
                orders:{},
                details:{},
                isDr:'en'
            }
        },
        created(){
            let id = this.$route.params.id
        	axios.get('/api/order/details/'+id)
        	.then(({data}) =>(this.orders = data,console.log("order 1:",data)))
            .catch()

        	axios.get('/api/order/orderdetails/'+id)
        	.then(({data}) => (this.details = data,console.log("order 2:",data)))
            .catch()
        },
        methods:{

        }
    }
</script>


<style scoped>
  .rtl{
    direction: rtl !important;
	text-align: right !important;
}
    #em_photo{
        height: 40px;
        width: 40px;
    }
</style>
