<template>
    <div>
        <RegModal ref="regModal"></RegModal>
        <Modal ref="pModal" :title="title" :message="message"></Modal>
        <div class="bg-top py-1">
            <div class="d-flex container">
                <div class="mr-auto">
                    Custom T-shirts & More
                </div>
                <div class="ml-auto" v-if="isLoggedIn">
                    <router-link :to="{name: 'Profile'}" class="btn btn-sm text-white"> My Account </router-link>
                    <span> | </span>
                    <router-link :to="{name: 'Settings'}" class="btn btn-sm text-white"> Settings </router-link>
                    <span> | </span>
                    <a class="btn btn-sm text-white" @click.prevent="accLogout"> Logout </a>
                </div>
                <div class="ml-auto" v-if="!isLoggedIn">
                    <router-link :to="{name: 'Login'}" class="btn btn-sm text-white"> Login </router-link>
                    <span> | </span>
                    <button type="button" class="btn btn-sm text-white" @click.prevent="regModal"> Register </button>
                </div>
            </div>
        </div>
        <!--
        **
        **NAVBAR HERE
        **
        -->
        <nav class="navbar sticky-top navbar-expand-lg bg-custom border">
            <router-link :to="{name: 'Home'}" class="navbar-brand">
                <img src="/assets/images/brand-debuhu.png" class="d-inline-block align-top image-fluid ml-5" width="200" alt="debuhu brand logo" loading="lazy">
            </router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-align-justify"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown" v-if="!isLoggedIn">
                <ul class="navbar-nav ml-auto mr-5">
                    <li class="nav-item">
                        <a class="nav-link" href="http://127.0.0.1:80/#wwd">WHAT WE OFFER</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://127.0.0.1:80/#pm">PAYMENT SUPPORTED</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://127.0.0.1:80/#cu">CONTACT US</a>
                    </li>
                </ul>
            </div>
            <!--
                **
                *
                *CUSTOMER HERE
                -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown" v-if="isLoggedIn && userRole == '1'">
                <ul class="navbar-nav ml-auto mr-5">
                    <li class="nav-item">
                        <router-link :to="{ name: 'My Designs'}" class="card-link px-2">MY DESIGN</router-link>
                    </li>
                    <li class="nav-item">
                         <router-link :to="{ name: 'Delivery Status'}" class="card-link px-2">OFFERS</router-link>
                    </li>
                    <li class="nav-item">
                         <router-link :to="{ name: 'Shop'}" class="card-link px-2">SHOP</router-link>
                    </li>
                    <li class="nav-item">
                         <a href="http://localhost#cu" class="card-link px-2">CONTACT US</a>
                    </li>
                </ul>
            </div>
            <!--
                **
                *
                *PARTNER HERE
                -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown" v-if="isLoggedIn && userRole == '3' || userRole == '2'">
                <ul class="navbar-nav ml-auto mr-5">
                    <li class="nav-item">
                        <router-link :to="{ name: 'Marketplace'}" class="card-link px-2">MARKETPLACE</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'Jobs'}" class="card-link px-2">JOB</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'My Shop'}" class="card-link px-2">MY SHOP</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'Home'}" class="card-link px-2">CONTACT US</router-link>
                    </li>
                </ul>
            </div>

            <!--
                **
                *
                *PARTNER HERE
                -->

            <div class="collapse navbar-collapse" id="navbarNavDropdown" v-if="isLoggedIn && userRole == '0'">
                <ul class="navbar-nav ml-auto mr-5">
                    <li class="nav-item">
                        <router-link :to="{ name: 'Contact'}" class="card-link px-2">INBOX</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'Approval'}" class="card-link px-2">APPROVALS</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'Home'}" class="card-link px-2">CONTACT US</router-link>
                    </li>
                </ul>
            </div>

        </nav>

        <div id="top">
            <router-view></router-view>
            <footer class="page-footer font-small border-top">
                    <div class="footer-copyright text-center py-4">
                        © 2020 Copyright: Debuhu.com
                    </div>
            </footer>
        </div>

    </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
export default {
    beforeMount(){
        //console.log(this.$route.name);
        //console.log(this.$store.state.formData.length)
    },
    data(){
        return{
            title:'',
            message:''
        }
    },
    computed:{
        ...mapState({
            isLoggedIn: "isLoggedIn",
            user:"user",
            userId:"userId",
            userRole:"userRole",
        })

    },
    methods:{
        accLogout(){
            try {
                axios.post("/logout");
                this.$store.dispatch("logout");

                if(this.$route.name != "Home"){
                    this.$router.push({name: "Home"});
                }
            } catch (error) {
                this.$store.dispatch("logout");
            }
        },
        regModal(){
            let regModal = this.$refs.regModal.$el;
            $(regModal).modal('show');
        }
    }
}
</script>

<style scoped>
    .bg-custom{
        background-color:#fff;
    }

    .bg-top{
        background-color:#575757;
        color:#ffffff;
        font-size: 0.9em;
        font-family:Verdana, Geneva, Tahoma, sans-serif;
    }

    #top{
        position: relative;
        min-height: 100vh;
    }

    .page-footer{
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 0.0rem;
    }

</style>
