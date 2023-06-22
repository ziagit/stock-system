 <template>
                             	<div v-bind:class="{'rtl': isDr=='dr'}">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item">
                <a href="#">{{$t('dashboard.dashboard')}}</a>
            </li>
            <li class="breadcrumb-item active">{{ $t('bc.expense') }}</li>
        </ol>
        <!-- Icon Cards-->
       <div class="row container">
         <div class="card col-lg-12 border-primary shadow">
          <div class="card-header text-primary" style="font-size: 20px; font-weight: 700;">
            <i class="fas fa-chart-area"></i>
            {{$t('expense.insert')}}
            <router-link to="/expense" class="btn btn-primary" id="add_new"> {{$t('expense.expenses')}}</router-link>
          </div>

          <div class="card-body">
            <form @submit.prevent="expenseInsert">
                <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-12">
	               	<div class="form-group">
				       <label for="Textarea1">{{$t('expense.details')}}</label>
				       <textarea class="form-control" id="Textarea1" rows="3" v-model="form.details" :placeholder="$t('form.details')"></textarea>
				       <small class="text-danger" v-if="errors.details">{{ errors.details[0] }}</small>
				     </div>
	               </div>
	               <div class="col-lg-12">
	               	<div class="form-label-group">
                      <label for="firstName">{{$t('expense.amount')}}</label>
	                  <input type="text" v-model="form.amount" class="form-control" required :placeholder="$t('form.amount')">
	                  <small class="text-danger" v-if="errors.amount">{{ errors.amount[0] }}</small>
	                </div>
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
        			details :'',
        			amount:''
        		},
        		errors:{},
            isDr:'en'
        	}
        },
        methods:{
        	expenseInsert(){
        		axios.post('/api/expense/',this.form)
        		.then(() => {
        			this.$router.push({ name: 'expense' })
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
