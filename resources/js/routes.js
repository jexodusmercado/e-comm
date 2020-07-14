import VueRouter from 'vue-router';
import Example from './components/ExampleComponent.vue';

const routes = [
    {
        path: "/",
        component: Example,
        name: "home"
    }
]

const router = new VueRouter({
    mode: 'history',
    routes,
});

export default router;
