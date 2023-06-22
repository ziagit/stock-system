<template>
    <div>
        <div class="container">
<div class="row justify-content-left">
    <div class="col-lg-7 offset-1">
        <div class="card shadow-lg border-primary rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center text-primary font-weight-bold my-4">{{$t('auth.register')}}</h3></div>
            <div class="card-body" v-bind:class="{'rtl': isDr=='dr'}">

                <form @submit.prevent="signup">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1" for="inputFirstName">{{$t('auth.name')}}</label>
                                <input class="form-control py-4" id="inputFirstName" type="text" :placeholder="$t('form.name')" v-model="form.name"/>

                                <small class="text-danger" v-if="errors.name" style="color:red">{{ errors.name[0] }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="mb-1" for="inputEmailAddress">{{$t('auth.email')}}</label>
                        <input class="form-control py-4" id="inputEmailAddress" type="email" aria-describedby="emailHelp" :placeholder="$t('form.email')" v-model="form.email"/>

                        <small class="text-danger" v-if="errors.email" style="color:red">{{ errors.email[0] }}</small>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-1" for="inputPassword">{{$t('auth.password')}}</label>
                                <input class="form-control py-4" id="inputPassword" type="password" :placeholder="$t('form.password')" v-model="form.password"/>

                                <small class="text-danger" v-if="errors.password" style="color:red">{{ errors.password[0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-1" for="inputConfirmPassword">{{$t('auth.confirm_password')}}</label>
                                <input class="form-control py-4" id="inputConfirmPassword" type="password" :placeholder="$t('auth.confirm_password')" v-model="form.password_confirmation"/>

                                <!-- <small class="text-danger" v-if="errors.password_confirmation" style="color:red">{{ errors.password_confirmation[0] }}</small> -->
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4 mb-0">
                        <button type="submit" class="btn btn-primary btn-block"> {{ $t('auth.signup') }} </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <div class="">
                    <router-link to="/">{{ $t('auth.have_account') }}</router-link>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    </div>
</template>


<script>
    export default {
        created(){
            if (User.loggedIn()) {
                this.$router.push({name:'home'})   // or, //this.$router.push('/home')
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
            return {
                form:{
                    name:null,
                    email:null,
                    password:null,
                    password_confirmation:null
                },
                errors:{},
                isDr:'en'
            }
        },
        methods:{
            signup(){
                // alert('done');   //--testing submit
                axios.post('/api/auth/signup',this.form)
                // .then(response => console.log(response.data))
                .then(response => {
                    User.responseAfterLogin(response)
                    Toast.fire({
                        icon: 'success',
                        title: 'Signed in Successfully'
                    })
                    this.$router.push('/home')    // or, this.$router.push({name:'home})
                })
                // .catch(error => console.log(error.response.data))
                .catch(error => this.errors = error.response.data.errors)
            }
        }
    }
</script>


<style>
  .rtl{
    direction: rtl !important;
	text-align: right !important;
}
</style>
