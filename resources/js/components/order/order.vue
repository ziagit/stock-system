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
       <div class="row card container ml-3 border-primary shadow mb-3">
          <div class="card-header text-primary" style="font-size: 20px; font-weight:700;">
            <i class="fas fa-chart-area"></i>
            {{$t('order.today_order')}}
          </div>
          <div class="card-body pt-0">
            <div class="card-body">
              <div class="table-responsive">
               <input type="text" v-model="searchTerm" class="form-control d-inline" style="width:200px;" :placeholder="$t('form.search_name')"><br><br>
                <table class="table table-bordered table-striped table-hover table-warning border-primary" id="" width="100%" cellspacing="0">

                  <thead>
                    <tr class="bg-info text-white">
                      <th>{{$t('name')}}</th>
                      <th>{{$t('order.total')}}</th>
                      <th>{{$t('order.pay')}}</th>
                      <th>{{$t('order.due')}}</th>
                      <th>{{$t('order.payby')}}</th>
                      <th>{{$t('action')}}</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr v-for="order in filtersearch" :key="order.id">
                      <td>{{ order.name }}</td>
                      <td>{{ order.total }}</td>
                      <td>{{ order.pay }}</td>
                      <td>{{ order.due }}</td>
                      <td>{{ order.payby=='HandCash'?'نقد':order.payby }}</td>
                      <td>
                        <router-link :to="{name: 'view-order', params:{id: order.id} }" class="btn btn-sm btn-info">{{$t('view')}}</router-link>
                        <!-- <router-link :to="'/pay-salary/'+employee.id" class="btn btn-sm btn-info">Pay Salary</router-link> --> <!--or, -->
                        <!-- <router-link :to="`/pay-salary/${employee.id}`" class="btn btn-sm btn-info">Pay Salary</router-link> -->
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
            this.allOrder();
        },
        data(){
          return{
            orders:[],
            searchTerm:'',
            isDr:'en'
          }
        },
        computed:{
            filtersearch(){
                return this.orders.filter(order => {
                    //return order.name.match(this.searchTerm)
                    return order.name.toLowerCase().match(this.searchTerm.toLowerCase())
                })
            }
        },
        methods:{
          allOrder(){
            axios.get('/api/orders/')
            .then(({data}) => (this.orders = data))
            .catch()
          }
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
#em_photo{
  height: 40px;
  width: 40px;
}
</style>
