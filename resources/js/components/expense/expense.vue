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
       <div class="row card container ml-3 border-primary shadow mb-3">
          <div class="card-header text-primary" style="font-size: 20px; font-weight:700;">
            <i class="fas fa-chart-area"></i>
            {{$t('expense.expenses')}}
            <router-link to="/store-expense" class="btn btn-primary" id="add_new">{{$t('add')}}</router-link>
          </div>
          <div class="card-body pt-0">
            <div class="card-body">
              <div class="table-responsive">
               <input type="text" v-model="searchTerm" class="form-control d-inline" style="width:200px;" :placeholder="$t('form.search_date')"><br><br>
                <table class="table table-bordered table-striped table-hover table-warning border-primary" width="100%" cellspacing="0">

                  <thead>
                    <tr class="bg-info text-white">
                      <th>{{$t('name')}}</th>
                      <th>{{$t('expense.amount')}}</th>
                      <th>{{$t('expense.date')}}</th>
                      <th>{{$t("action")}}</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr v-for="expense in filtersearch" :key="expense.id">
                      <td>{{ expense.details }}</td>
                      <td>{{ expense.amount }}</td>
                      <td>{{ expense.expense_date }}</td>
                      <td>
                        <router-link :to="{name: 'edit-expense', params:{id: expense.id} }" class="btn btn-sm btn-info">{{$t('edit')}}</router-link>
                        <!-- <router-link :to="'/edit-category/'+category.id" class="btn btn-warning mr-1">Edit</router-link> -->    <!--or-->
                        <!-- <router-link :to="`/edit-category/${category.id}`" class="btn btn-sm btn-primary text-white">Edit</router-link> -->
                        <a @click="deleteExpense(expense.id)" class="btn btn-sm btn-danger text-white">{{$t('delete')}}</a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
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
        created(){
            this.allExpense();
        },
        data(){
          return{
            expenses:[],
            searchTerm:'',
            isDr:'en'
          }
        },
       computed:{
         filtersearch(){
          return this.expenses.filter(expense => {
            // return expense.expense_date.match(this.searchTerm)
            return expense.expense_date.toLowerCase().match(this.searchTerm.toLowerCase())
           })
         }
       },
        methods:{
          allExpense(){
            axios.get('/api/expense/')
            .then(({data}) => (this.expenses = data))
            .catch()
          },
          deleteExpense(id){
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
              axios.delete('/api/expense/'+id)
              .then(()=>{
                 this.expenses = this.expenses.filter(expense =>{
                    return expense.id !=id
                 })
              })
              .catch(()=>{
                 this.$router.push({name: 'expense'})
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
