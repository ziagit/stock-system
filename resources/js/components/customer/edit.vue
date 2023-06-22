 <template>
                         	<div v-bind:class="{'rtl': isDr=='dr'}">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item">
                <a href="#">{{$t('dashboard.dashboard')}}</a>
            </li>
            <li class="breadcrumb-item active">{{ $t('bc.customer') }}</li>
        </ol>
        <!-- Icon Cards-->
       <div class="row container">
         <div class="card col-lg-12 border-primary shadow">
          <div class="card-header text-primary" style="font-size: 20px; font-weight: 700;">
            <i class="fas fa-chart-area"></i>
            {{$t('customer.update')}}
            <router-link to="/Customer" class="btn btn-primary" id="add_new"> {{$t('customer.customers')}}</router-link>
          </div>
          <div class="card-body">
          	  <form @submit.prevent="customerUpdate" enctype="multipart/form-data">
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
                      <label>{{$t('email')}}</label>
	                  <input type="text" v-model="form.email" class="form-control" >
	                  <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
	                </div>
	               </div>
	             </div>
	          </div>
	          <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-6">
	                <div class="form-label-group">
                      <label>{{$t('address')}}</label>
	                  <input type="text" v-model="form.address" class="form-control" >
	                  <small class="text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
	                </div>
	               </div>
	               <div class="col-md-6">
	                <div class="form-label-group">
                      <label>{{$t('phone')}}</label>
	                  <input type="text" v-model="form.phone" class="form-control" >
	                  <small class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
	                </div>
	               </div>
	             </div>
	          </div>
               <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-6">
	                <div class="form-label-group">
	                 <input type="file" class="btn btn-info" @change="onFileselected">
	                  <small class="text-danger" v-if="errors.photo">{{ errors.photo[0] }}</small>
	                </div>
	               </div>
	                <div class="col-md-6">
	                	<img :src="'/'+form.photo" style="height:40px; width: 40px;">
	                </div>
	             </div>
	          </div>
               <button type="submit" class="btn btn-success">{{$t('update')}}</button>
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
        			name :'',
        			email :'',
        			address:'',
        			photo :'',
        			newphoto:'',
        			phone:''
        		},
        		errors:{},
				isDr:'en'
        	}
        },
        created(){
        	let id = this.$route.params.id
        	axios.get('/api/Customer/'+id)
        	.then(({data}) => (this.form = data))
        	.catch()
        },
        methods:{
        	onFileselected(event){
        		let file=event.target.files[0];
        		if (file.size > 1048770) {
        			Notification.image_validation()
        		}else{
        			let reader = new FileReader();
        			reader.onload = event => {
        				this.form.newphoto = event.target.result
        			};
        			reader.readAsDataURL(file);
        		}
        	},
        	customerUpdate(){
        		let id = this.$route.params.id
        		axios.patch('/api/Customer/'+id,this.form)
        		.then(() => {
        			this.$router.push({ name: 'Customer' })
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
