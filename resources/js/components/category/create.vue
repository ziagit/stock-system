<template>
   	<div v-bind:class="{'rtl': isDr=='dr'}">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item">
                <a href="#">{{$t('dashboard.dashboard')}}</a>
            </li>
            <li class="breadcrumb-item active">{{ $t('bc.category') }}</li>
        </ol>
        <!-- Icon Cards-->
        <div class="row container">
            <div class="card col-lg-12 border-primary shadow">
                <div class="card-header text-primary" style="font-size: 20px; font-weight: 700;">
                    <i class="fas fa-chart-area"></i>
                    {{$t('category.insert')}}
                    <router-link to="/category" class="btn btn-primary" id="add_new"> {{$t('category.categories')}}</router-link>
                </div>

                <div class="card-body">
                    <form @submit.prevent="categoryInsert">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-label-group">
                                        <label>{{$t('name')}}: </label>
                                        <input type="text" v-model="form.category_name" class="form-control" required :placeholder="$t('form.category_name')">
                                        <small class="text-danger" v-if="errors.category_name">{{ errors.category_name[0] }}</small>
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
                    category_name :''
                },
                errors:{},
                isDr:'en'
            }
        },
        methods:{
            categoryInsert(){
                axios.post('/api/category/',this.form)
                    .then(() => {
                        this.$router.push({ name: 'category' })
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
