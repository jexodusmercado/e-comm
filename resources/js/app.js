require('./bootstrap');

import VueRouter from "vue-router";
import loading from 'vue-full-loading';
import Vuex from 'vuex';
import router from "./routes";
import VueRecaptcha from "vue-recaptcha";
import Index from "./Index";
import pModal from './components/shared/popModal';
import RegModal from './components/shared/RegisterPopout';
import imgModal from './components/shared/imgModal';
import vModal from './components/shared/vImgModal';
import offerModal from "./components/shared/offerModal.vue";
import StarRating from 'vue-star-rating'
import storeDefinition from "./store";

window.Vue = require('vue');
Vue.use(VueRouter);
Vue.use(Vuex);

Vue.component("Loader", loading);
Vue.component("Index", Index);
Vue.component("vue-recaptcha", VueRecaptcha);
Vue.component("Modal", pModal);
Vue.component("RegModal", RegModal);
Vue.component("Offer", offerModal);
Vue.component("imageModal", imgModal);
Vue.component("vModal", vModal);
Vue.component('star-rating', StarRating);

const store = new Vuex.Store(storeDefinition);

window.axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if(401 === error.response.status){
            store.dispatch("logout");
            router.push({name:'Home'});

        }
        return Promise.reject(error);
    }
);



const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        "Index": Index,
    },

    async beforeCreate() {

        this.$store.dispatch("loadStoredState");
        this.$store.dispatch("loadUser");
    }

});
