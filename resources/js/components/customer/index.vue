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
       <div class="row card container ml-3 border-primary shadow mb-3">
          <div class="card-header text-primary" style="font-size: 20px; font-weight:700;">
            <i class="fas fa-chart-area"></i>
            {{$t('customer.insert')}}
            <router-link to="/store-Customer" class="btn btn-primary" id="add_new"> {{$t('add')}}</router-link>
          </div>
          <div class="card-body">
            <div class="card-body">
              <div class="table-responsive" v-if="customers">
                <label class="d-inline">{{$t('search')}} : </label>
                <input type="text" v-model="keywords" class="form-control d-inline" style="width:200px;" :placeholder="$t('form.search_name')"><br><br>
               <table class="table table-bordered table-striped table-hover table-warning border-primary" id="" width="100%" cellspacing="0">
                  <thead>
                    <tr class="bg-info text-white">
                      <th>{{$t('name')}}</th>
                      <th>{{$t('photo')}}</th>
                      <th>{{$t('phone')}}</th>
                      <th>{{$t('address')}}</th>
                      <th>{{$t('action')}}</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr v-for="customer in customers.data" :key="customer.id">
                      <td>{{ customer.name }}</td>
                      <td><img :src="customer.photo" id="em_photo"></td>
                      <td>{{ customer.phone }}</td>
                      <td>{{ customer.address }}</td>
                      <td>
                        <router-link :to="{name: 'edit-Customer', params:{id: customer.id} }" class="btn btn-sm btn-info">{{$t('edit')}}</router-link>
                        <!-- <router-link :to="'/edit-category/'+category.id" class="btn btn-warning mr-1">Edit</router-link> --> <!--or-->
                        <!-- <router-link :to="`/edit-category/${category.id}`" class="btn btn-sm btn-primary text-white">Edit</router-link> -->
                        <a @click="deleteCustomer(customer.id)" class="btn btn-sm btn-danger text-white">{{$t('delete')}}</a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <pagination v-if="customers" :limit="4" :data="customers" @pagination-change-page="allCustomer"></pagination>
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
            this.allCustomer();
        },
        data(){
          return{
            keywords: null,
            customers:null,
            searchTerm:'',
            isDr:'en'
          }
        },
       computed:{
         filtersearch(){
          return this.customers.filter(customer => {
            //return customer.name.match(this.searchTerm)
            return customer.name.toLowerCase().match(this.searchTerm.toLowerCase())
           })
         }
       },
       watch: {
            keywords(after, before) {
                this.search();
            },
        },
        methods:{
          search() {
                axios.get("/api/search-customer", {
                        params: {
                            keywords: this.keywords,
                        },
                    })
                    .then((res) => {
                        console.log("search: ",res.data)
                        this.customers = res.data;
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            },
          allCustomer(page=1){
            axios.get('/api/Customer?page='+page)
            .then(({data}) => (this.customers = data))
            .catch()
          },
          deleteCustomer(id){
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
              axios.delete('/api/Customer/'+id)
              .then(()=>{
                 this.customers = this.customers.filter(customer =>{
                    return customer.id !=id
                 })
              })
              .catch(()=>{
                 this.$router.push({name: 'Customer'})
              })
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
            }
           })
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
