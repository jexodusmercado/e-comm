import VueRouter from 'vue-router';
import Index from './Index.vue';
import Example from './components/ExampleComponent.vue';
import Editor from './components/Products/Editor.vue';

const routes = [
    {
        path: "/",
        component: Example,
        name: "Example"
    },
    {
        path: "/product-creator",
        component: Editor,
        name: "Editor"
    },
    {
        path: "/Test",
        component: Example,
        name: "Test"
    }
]

const router = new VueRouter({
    mode: 'history',
    routes,
});

export default router;
