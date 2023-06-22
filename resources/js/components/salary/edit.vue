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
       <div class="row container">
         <div class="card col-lg-12 border-primary shadow">
          <div class="card-header text-primary" style="font-size: 20px; font-weight: 700;">
            <i class="fas fa-chart-area"></i>
            {{ $t('salary.update') }}
          </div>

          <div class="card-body">
          	  <form @submit.prevent="SalaryUpdate" >
                <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-6">
	                <div class="form-label-group">
                      <label for="firstName">{{$t('name')}}</label>
	                  <input type="text" v-model="form.name" class="form-control" required>
	                  <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
	                </div>
	               </div>
	               <div class="col-md-6">
	                <div class="form-label-group">
                      <label for="lastName">{{$t('email')}}</label>
	                  <input type="text" v-model="form.email" class="form-control" >
	                  <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
	                </div>
	               </div>
	             </div>
	          </div>
	          <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-6">
	                  <div class="form-group">
                        <label>{{ $t('salary.search_month') }}</label>
					    <select class="form-control" id="exampleFormControlSelect1" v-model="form.salary_month">
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
					    <small class="text-danger" v-if="errors.salary_month">{{ errors.salary_month[0] }}</small>
					  </div>
					  <input type="hidden" v-model="form.employee_id">
	               </div>
	               <div class="col-md-6">
	                <div class="form-label-group">
                      <label for="lastName">{{$t('salary.salary')}}</label>
	                  <input type="text" v-model="form.amount" class="form-control" required>
	                  <small class="text-danger" v-if="errors.amount">{{ errors.amount[0] }}</small>
	                </div>
	               </div>
	             </div>
	          </div>
               <button type="submit" class="btn btn-success">{{$t('update')}}</button>
              </form>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
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
        			name :'',
        			email :'',
        			amount:'',
        			salary_month:'',
        			employee_id:''
        		},
        		errors:{},
				isDr:'en'
        	}
        },
        created(){
        	let id = this.$route.params.id
        	axios.get('/api/edit/salary/'+id)
        	.then(({data}) => (this.form = data))
        	.catch()
        },
        methods:{
        	SalaryUpdate(){
        		let id = this.$route.params.id
        		axios.post('/api/salary/update/'+id,this.form)
        		.then(() => {
        			this.$router.push({ name: 'given-salary' })
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
#add_new{
	float: right;
}
</style>
