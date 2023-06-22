 <template>
                                     	<div v-bind:class="{'rtl': isDr=='dr'}">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item">
                <a href="#">{{$t('dashboard.dashboard')}}</a>
            </li>
            <li class="breadcrumb-item active">{{ $t('bc.salary') }}</li>
        </ol>
        <!-- Icon Cards-->
       <div class="row card container ml-3 border-primary shadow mb-3">
          <div class="card-header text-primary" style="font-size: 20px; font-weight:700;">
            <i class="fas fa-chart-area"></i>
            {{$t('salary.employee')}}
          </div>
          <div class="card-body pt-0">
            <div class="card-body">
              <div class="table-responsive">
                <label class="d-inline">{{$t('search')}} : </label>
               <input type="text" v-model="searchTerm" class="form-control d-inline" style="width:200px;" :placeholder="$t('form.search_name')"><br><br>
                <table class="table table-bordered table-striped table-hover table-warning" id="" width="100%" cellspacing="0">

                  <thead>
                    <tr class="bg-info text-white">
                      <th>{{$t('name')}}</th>
                      <th>{{$t('photo')}}</th>
                      <th>{{$t('phone')}}</th>
                      <th>{{$t('salary.salary')}}</th>
                      <th>{{$t('action')}}</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr v-for="employee in filtersearch" :key="employee.id">
                      <td>{{ employee.name }}</td>
                      <td><img :src="employee.photo" id="em_photo"></td>
                      <td>{{ employee.phone }}</td>
                      <td>{{ employee.salary }}</td>
                      <td>
                        <router-link :to="{name: 'pay-salary', params:{id: employee.id} }" class="btn btn-sm btn-info">{{$t('salary.pay_now')}}</router-link>
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
            this.allEmployee();
        },
        data(){
          return{
            employees:[],
            searchTerm:'',
            isDr:'en'
          }
        },
       computed:{
         filtersearch(){
          return this.employees.filter(employee => {
            //  return employee.name.match(this.searchTerm)
            return employee.name.toLowerCase().match(this.searchTerm.toLowerCase())
           })
         }
       },
        methods:{
          allEmployee(){
            axios.get('/api/employee/')
            .then(({data}) => (this.employees = data))
            .catch()
          },
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
