<template>
    <div>
        <div class="container">
<div class="row justify-content-left">
    <div class="col-lg-5 offset-2 pt-5 mt-2">
        <div class="card shadow-lg border-primary rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center text-primary font-weight-bold my-3">{{$t('auth.forget_password')}}</h3></div>
            <div class="card-body"  v-bind:class="{'rtl': isDr=='dr'}">
                <form>
                    <div class="form-group">
                        <label class="small mb-1" for="inputEmailAddress">{{$t('auth.existing_email')}}</label>
                        <input class="form-control py-4" id="inputEmailAddress" type="email" :placeholder="$t('auth.existing_email')" required v-model="form.email" />
                    </div>

                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button type="submit" class="btn btn-primary"> {{$t('auth.forget_password')}} </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <div class="">
                    <router-link to="/">{{$t('auth.back_login')}}</router-link>
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
        this.$router.push('/home')
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
          email:null,
        },
        errors:{},
        isDr:'en'
      }
    },
}
</script>


<style>
  .rtl{
    direction: rtl !important;
	text-align: right !important;
}
</style>
