import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'
require('./bootstrap');

import VueRouter from "vue-router";
import loading from 'vue-full-loading';
import router from "./routes";
import Index from "./Index";

window.Vue = require('vue');
Vue.use(VueRouter);

Vue.component("Loader", loading);
Vue.component("Index", Index);


const app = new Vue({
    el: '#app',
    router,
    components: {
        "Index": Index,
    }
});
