<template>
    <div v-bind:class="{'rtl': isDr=='dr'}">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item">
                <a href="#">{{$t('dashboard.dashboard')}}</a>
            </li>
            <li class="breadcrumb-item active">{{ $t('bc.order') }}</li>
        </ol>
        <!-- Icon Cards-->
        <div class="row container">
            <div class="card col-lg-12 border-primary shadow">
                <div class="card-header text-primary" style="font-size: 20px; font-weight: 700;">
                    <i class="fas fa-chart-area"></i>
                    {{$t('order.search_order')}}
                    <router-link to="/order" class="btn btn-primary" id="add_new">{{$t('order.today_order')}}</router-link>
                </div>

<!------------Search By Date---------------->
<div class="card-body">
    <div class="row">
        <!-- <div class="col-lg-6">
            <form @submit.prevent="searchDate">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-label-group">
                                <label>{{$t('order.search_by_date')}} : </label>
                                <input type="date" v-model="date" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">{{$t('order.orders')}}</button>
            </form>
        </div> -->
        <div class="col-lg-6">
            <form @submit.prevent="searchCustomer">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-label-group">
                                <label>{{$t('order.search_by_customer')}} : </label>
                                <input v-model="customer" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">{{$t('search')}}</button>
            </form>
        </div>

<!------------Search By Month---------------->
        <div class="col-lg-6">
            <form @submit.prevent="searchMonth">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-label-group">
                                <label>{{$t('order.search_by_month')}} : </label>
                                <select class="form-control" v-model="month">
                                    <option value="January">{{ $t('jan') }}</option>
                                    <option value="February">{{ $t('feb') }}</option>
                                    <option value="March">{{ $t('mar') }}</option>
                                    <option value="April">{{ $t('apr') }}</option>
                                    <option value="May">{{ $t('may') }}</option>
                                    <option value="June">{{ $t('jun') }}</option>
                                    <option value="July">{{ $t('jul') }}</option>
                                    <option value="August">{{ $t('aug') }}</option>
                                    <option value="September">{{ $t('sep') }}</option>
                                    <option value="October">{{ $t('oct') }}</option>
                                    <option value="November">{{ $t('nov') }}</option>
                                    <option value="December">{{ $t('dec') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">{{$t('search')}}</button>
            </form>
        </div>
    </div>
</div>  <!-----------End_Search_text_box------------------>


<!-----------Search_Result------------------>
    <div class="row container pt-4">
        <div class="card col-lg-12  shadow-none mb-3">
            <div class="card-header text-primary" style="font-size: 20px; font-weight: 700;">
                <i class="fas fa-chart-area"></i>
                {{$t('order.orders')}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-warning border-primary" id="" width="100%" cellspacing="0">

                        <thead>
                            <tr class="bg-info text-white">
                                <th>{{ $t('name') }}</th>
                                <th>{{$t('qty')}}</th>
                                <th>{{$t('order.subtotal')}}</th>
                                <th>{{$t('order.vat')}}</th>
                                <th>{{$t('total')}}</th>
                                <th>{{$t('order.pay')}}</th>
                                <th>{{$t('pos.discount')}}</th>
                                <th>{{$t('order.due')}}</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="order in orders" :key="order.id">
                                <td>{{ order.name }}</td>
                                <td>{{ order.qty }}</td>
                                <td>{{ order.sub_total }}</td>
                                <td>{{ order.vat }}</td>
                                <td>{{ order.total }}</td>
                                <td>{{ order.pay }}</td>
                                <td>{{ order.discount }}</td>
                                <td>{{ order.due }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td>{{ quantity }}</td>
                                <td>{{ subtotal }} {{$t('currency')}}</td>
                                <td></td>
                                <td>{{ total }} {{$t('currency')}}</td>
                                <td>{{ pay }} {{$t('currency')}}</td>
                                <td>{{ due }} {{$t('currency')}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--------End_Search_Result------------>


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
                date :'',
                customer:'',
                orders:'',
                month:'',
                isDr:'en'
            }
        },
        computed:{
            quantity(){
                let sum=0;
                for(let i=0; i < this.orders.length; i++ ){
                    sum += (parseFloat(this.orders[i].qty));
                }
                return sum;
            },
            subtotal(){
                let sum=0;
                for(let i=0; i < this.orders.length; i++ ){
                    sum += (parseFloat(this.orders[i].sub_total));
                }
                return sum;
            },
            total(){
                let sum=0;
                for(let i=0; i < this.orders.length; i++ ){
                    sum += (parseFloat(this.orders[i].total));
                }
                return sum;
            },
            pay(){
                let sum=0;
                for(let i=0; i < this.orders.length; i++ ){
                    sum += (parseFloat(this.orders[i].pay));
                }
                return sum;
            },
            due(){
                let sum=0;
                for(let i=0; i < this.orders.length; i++ ){
                    sum += (parseFloat(this.orders[i].due));
                }
                return sum;
            },
        },
        methods:{
            searchDate(){
                var data = {date: this.date}
                axios.post('/api/search/order',data)
                    .then(({data}) => (this.orders = data))
                    .catch()
            },
            searchCustomer(){
                var data = {customer: this.customer}
                axios.post('/api/search/customer',data)
                    .then(({data}) => (this.orders = data))
                    .catch()
            },
            searchMonth(){
                var data = {month: this.month}
                axios.post('/api/search/month',data)
                    .then(({data}) => (this.orders = data))
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
</style>
