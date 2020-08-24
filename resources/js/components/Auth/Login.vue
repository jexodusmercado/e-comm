<template>
    <div class="bg-img">

        <Loader :show="loading"></Loader>
        <Modal></Modal>

        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto p-5">
                    <div class="card shadow py-3 px-2">
                        <div class="card-header">
                            <h2 class="h2">
                                Sign in
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="input-group col-md-12 mb-1 mx-auto">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="email" class="form-control" placeholder="Email" aria-label="Username" v-model="email">
                            </div>
                            <div class="input-group col-md-12  mb-5 mx-auto">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control" placeholder="Password" aria-label="Password" v-model="password" @keyup.enter="accLogin">
                            </div>
                            <div class="input-group col-md-12 mx-auto">
                                <button class="btn btn-block btn-primary" @click.prevent="accLogin">
                                    SIGN IN
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import { logIn } from "../../shared/utils/auth";

export default {

    beforeMount(){
        if(this.$store.state.isLoggedIn){
            this.$router.push({name:"Home"});
        }
    },
    mounted(){

    },
    data(){
        return{
            email: '',
            password: '',
            loading: false,
            errors: []
        }
    },
    methods:{
        async accLogin(){
            this.loading = true;
            const formData = new FormData();
            formData.append('email', this.email);
            formData.append('password', this.password);
                try {
                    await axios.get('/sanctum/csrf-cookie');
                    await axios.post('/login', formData);
                    logIn();
                    this.$store.dispatch("loadUser");

                    this.$router.push({name:"Home"});

                } catch (error) {

                }
            this.loading = false;

        }
    },
    created(){
        if(this.$store.state.isLoggedIn){
            this.$router.push({name:'Home'});
        }
    }
}
</script>

<style scoped>
    .bg-img{
        background-color:hsl(226, 40%, 50%);
        height:100vh;
    }

    .row{
        height:100vh;
    }
</style>
