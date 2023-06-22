
<template>
    <div  v-bind:class="{'rtl': isDr=='dr'}">   <!-----total_<div>----->
<!--------------------Dashboard------------------------>
<h1 class="mt-4">{{$t('dashboard.dashboard')}}</h1>
<ol class="breadcrumb mb-4 d-flext justify-content-between">
    <li class="breadcrumb-item active">{{$t('dashboard.dashboard_inventory')}}</li>
    <span>{{ $t('dashboard.capital') }}: <span class="capital">{{capital.toFixed(1)}}</span> {{$t('currency')}}</span>
</ol>
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">{{ todaysell }} {{$t('dashboard.afn')}}</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="text-white stretched-link" href="#">{{ $t('dashboard.today_sell') }}</a>
                <div class="text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">{{ income }} {{$t('dashboard.afn')}}</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class=" text-white stretched-link" href="#">{{ $t('dashboard.today_income') }}</a>
                <div class=" text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-info text-white mb-4">
            <div class="card-body">{{ due }} {{$t('dashboard.afn')}}</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class=" text-white stretched-link" href="#">{{ $t('dashboard.today_due') }}</a>
                <div class=" text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">{{ expense }} {{$t('dashboard.afn')}}</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class=" text-white stretched-link" href="#">{{ $t('dashboard.today_expense') }}</a>
                <div class=" text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>      <!------End_Dashboard------>

<!------Stock_Out_Products------>
<div class="row my-3">
    <div class="col-xl-12">
        <div class="card border-primary">
            <div class="card-header text-primary font-weight-bold">
                <i class="fas fa-chart-area mr-1"></i>
            {{ $t('dashboard.stock_out_product') }}
            </div>
            <div class="card-body">
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover table-warning" id="" width="100%" cellspacing="0">
                            <thead>
                                <tr class="bg-info text-white">
                                    <th>{{$t('dashboard.name')}}</th>
                                    <th>{{$t('dashboard.code')}}</th>
                                    <th>{{$t('dashboard.photo')}}</th>
                                    <th>{{$t('dashboard.status')}}</th>
                                    <th>{{$t('dashboard.availability')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="product in products" :key="product.id">
                                    <td>{{ product.product_name}}</td>
                                    <td>{{ product.product_code}}</td>
                                    <td><img :src="product.image" id="em_photo"></td>
                                    <td v-if="product.product_quantity >= 1"><span class="badge badge-success">{{$t('dashboard.available')}}</span></td>
                                    <td v-else=""><span class="badge badge-danger">{{$t('dashboard.stock_out')}}</span></td>
                                    <td>{{ product.product_quantity }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  <!------End_Stock_ Out_Products------>

    </div>  <!------End_total_<div>------>

</template>

<script>
    export default {
        created(){
            axios.get('/api/test').then(res=>{
                console.log("backup took: ",res.data)
            })
            if (!User.loggedIn()) {
                this.$router.push({name : '/'})
            }
        },
        mounted(){
            if (localStorage.getItem("locale")) {
                this.$i18n.locale = localStorage.getItem("locale");
                this.isDr = localStorage.getItem("locale");
            } else {
                localStorage.setItem("locale", this.$i18n.locale);
                this.isDr = localStorage.getItem("locale");
            }
            this.allCapital();
            this.TodaySell();
            this.TodayIncome();
            this.TodayDue();
            this.TodayExpense();
            this.Stockout();
        },
        data(){
            return{
                capital:0,
                todaysell:'',
                income:'',
                expense:'',
                due:'',
                products:'',
                isDr:'en',
            }
        },
        methods:{
            TodaySell(){
                axios.get('/api/today/sell')
                    .then(({data}) => (this.todaysell = data))
                    .catch()
            },
            TodayIncome(){
                axios.get('/api/today/income')
                    .then(({data}) => (this.income = data))
                    .catch()
            },
            TodayDue(){
                axios.get('/api/today/due')
                    .then(({data}) => (this.due = data))
            },
            TodayExpense(){
                axios.get('/api/today/expense')
                    .then(({data}) => (this.expense = data))
            },
            Stockout(){
                axios.get('/api/stockout')
                    .then(({data}) => (this.products = data))
            },
            allCapital(){
                axios.get('/api/product')
                .then(res=> {
                    this.capital=0;
                    res.data.forEach(el => {
                        this.capital = this.capital + (el.product_quantity*el.buying_price);
                    });
                })
            },
        }
    }
</script>


<style scoped>
.capital{
    font-weight: 700;
}
.rtl{
    direction: rtl !important;
	text-align: right !important;

}
#em_photo{
    height: 40px;
    width: 40px;
}
</style>
