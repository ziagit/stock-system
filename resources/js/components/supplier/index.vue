<template>
           	<div v-bind:class="{'rtl': isDr=='dr'}">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item">
                <a href="#">{{$t('dashboard.dashboard')}}</a>
            </li>
            <li class="breadcrumb-item active">{{ $t('bc.supplier') }}</li>
        </ol>
        <!-- Icon Cards-->
        <div class="row card container ml-3 border-primary shadow">
            <div class="card-header text-primary" style="font-size: 20px; font-weight:700;">
                <i class="fas fa-chart-area"></i>
                {{ $t('supplier.suppliers') }}
                <router-link to="/store-supplier" class="btn btn-primary" id="add_new"> {{ $t('add') }}</router-link>
            </div>
            <div class="card-body pt-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <input type="text" v-model="searchTerm" class="form-control d-inline" style="width:200px;" :placeholder="$t('form.search_name')"><br> <br>
                        <table class="table table-bordered table-striped table-hover table-warning border-primary" id="" width="100%" cellspacing="0">

                            <thead>
                            <tr class="bg-info text-white">
                                <th>{{ $t('name') }}</th>
                                <th>{{ $t('photo') }}</th>
                                <th>{{ $t('phone') }}</th>
                                <th>{{ $t('supplier.shop') }}</th>
                                <th>{{ $t('address') }}</th>
                                <th>{{ $t('action') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="supplier in filtersearch" :key="supplier.id">
                                <td>{{ supplier.name }}</td>
                                <td><img :src="supplier.photo" id="em_photo"></td>
                                <td>{{ supplier.phone }}</td>
                                <td>{{ supplier.shopname }}</td>
                                <td>{{ supplier.address }}</td>
                                <td>
                                    <router-link :to="{name: 'edit-supplier', params:{id: supplier.id} }" class="btn btn-sm btn-info">{{ $t('edit') }}</router-link>
                                    <!-- <router-link :to="'/edit-category/'+category.id" class="btn btn-warning mr-1">Edit</router-link> --> <!--or, -->
                                    <!-- <router-link :to="`/edit-category/${category.id}`" class="btn btn-sm btn-primary text-white">Edit</router-link> -->
                                    <a @click="deleteSupplier(supplier.id)" class="btn btn-sm btn-danger text-white">{{ $t('delete') }}</a>
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
            this.allSupplier();
        },
        data(){
            return{
                suppliers:[],
                searchTerm:'',
                isDr:'en'
            }
        },
        computed:{
            filtersearch(){
                return this.suppliers.filter(supplier => {
                    //return supplier.phone.match(this.searchTerm)
                    return supplier.name.toLowerCase().match(this.searchTerm.toLowerCase())
                    // let searchLowerCase = supplier.name.toLowerCase()
                    // return searchLowerCase.match(this.searchTerm.toLowerCase())
                })
            }
        },
        methods:{
            allSupplier(){
                axios.get('/api/supplier/')
                    .then(({data}) => (this.suppliers = data))
                    .catch()
            },
            deleteSupplier(id){
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
                        axios.delete('/api/supplier/'+id)
                            .then(()=>{
                                this.suppliers = this.suppliers.filter(supplier =>{
                                    return supplier.id !=id
                                })
                            })
                            .catch(()=>{
                                this.$router.push({name: 'supplier'})
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
