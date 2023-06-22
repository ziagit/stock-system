<template>
    <div v-bind:class="{'rtl': isDr=='dr'}">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item">
                <a href="#">{{$t('dashboard.dashboard')}}</a>
            </li>
            <li class="breadcrumb-item active">{{ $t('bc.employee') }}</li>
        </ol>
        <!-- Icon Cards-->
        <div class="row card container ml-3 border-primary shadow mb-3">  <!-----f----->
            <div class="card-header text-primary" style="font-size: 20px; font-weight:700;">
                <i class="fas fa-chart-area"></i>
                {{$t('employee.employees')}}
                <router-link to="/store-employee" class="btn btn-primary" id="add_new"> {{$t('employee.add')}}</router-link>  <!-----f----->
            </div>
            <div class="card-body pt-0">       <!-----f----->
                <div class="card-body">
                    <div class="table-responsive">
                        <input type="text" v-model="searchTerm" class="form-control d-inline" style="width:200px" :placeholder="$t('form.search_name')"><br> <br>    <!-----f----->
                        <table class="table table-bordered table-striped table-hover table-warning border-primary" id="" width="100%" cellspacing="0">  <!-----f----->

                            <thead>
                            <tr class="bg-info text-white"> <!-----f----->
                                <th>{{$t('employee.name')}}</th>
                                <th>{{$t('photo')}}</th>
                                <th>{{$t('phone')}}</th>
                                <th>{{$t('employee.salary')}}</th>
                                <th>{{$t('employee.joining_date')}}</th>
                                <th>{{$t('action')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="employee in filtersearch" :key="employee.id">    <!-------------------------->
                                <td>{{ employee.name }}</td>
                                <td><img :src="employee.photo" id="em_photo"></td>   <!--bind(:) korle R {{}} lage na-->
                                <td>{{ employee.phone }}</td>
                                <td>{{ employee.salary }}</td>
                                <td>{{ employee.joining_date }}</td>
                                <td>
                                    <router-link :to="{name: 'edit-employee', params:{id: employee.id} }" class="btn btn-sm btn-info">{{$t('edit')}}</router-link>    <!----it will dynamic thats why applied bind(:to)---->
                                    <!-- <router-link :to="'/edit-category/'+category.id" class="btn btn-warning mr-1">Edit</router-link> --> <!--or, -->
                                    <!-- <router-link :to="`/edit-category/${category.id}`" class="btn btn-sm btn-primary text-white">Edit</router-link> -->
                                    <a @click="deleteEmployee(employee.id)" class="btn btn-sm btn-danger text-white">{{$t('delete')}}</a>
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

        created(){          //--immediately showing data_table after opening file
            this.allEmployee();
        },

        data(){
            return{
                employees:[],
                searchTerm:'',
                isDr:'en',
            }
        },
        computed:{                      //----search + show-------
            filtersearch(){
                return this.employees.filter(employee => {
                    //return employee.phone.match(this.searchTerm)
                    return employee.name.toLowerCase().match(this.searchTerm.toLowerCase())
                    // let searchLowerCase = employee.name.toLowerCase()
                    // return searchLowerCase.match(this.searchTerm.toLowerCase())
                })
            }
        },
        methods:{
            allEmployee(){
                axios.get('/api/employee/')        //--'get' will auto call index()_mathod in controller
                    .then(({data}) => this.employees = data)
                    .catch()
            },
            deleteEmployee(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/employee/'+id)               //------------delete-------------
                            .then(()=>{
                                this.employees = this.employees.filter(employee =>{
                                    return employee.id !=id
                                })
                            })
                            .catch(()=>{
                                this.$router.push({name: 'employee'})
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
