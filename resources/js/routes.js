import VueRouter from 'vue-router';
import Home from './components/Home.vue';
import Editor from './components/Products/Editor.vue';
import MyDesign from './components/Products/MyDesigns.vue';
import ViewDesign from './components/Products/ViewDesign.vue';
import Marketplace from './components/Products/Market.vue';
import Offer from './components/Products/Offer.vue';
import Delivery from './components/Products/AcceptedDesign.vue';
import Jobs from './components/Products/Job.vue';
import Profile from './components/Auth/Profile.vue';
import Approval from './components/Auth/Approval.vue';
import Settings from './components/Auth/Settings.vue';
import Contact from './components/Auth/Contact.vue';
import MyShop from './components/Shop/MyShop.vue';
import ViewItemShop from './components/Shop/ViewShopItem.vue';
import AddItemShop from './components/Shop/AddItemShop.vue';
import EditItemShop from './components/Shop/EditItemShop.vue';
import Shop from './components/Shop/Shop.vue';


const routes = [
    {
        path: "/",
        component: Home,
        name: "Home"
    },
    {
        path: "/auth/login",
        component: require("./components/Auth/Login").default,
        name: "Login"
    },
    {
        path: "/designs/create",
        component: Editor,
        name: "Editor",
    },
    {
        path: "/designs",
        component: MyDesign,
        name: "My Designs"
    },
    {
        path: "/designs/view/:id",
        component: ViewDesign,
        name: "View Design"
    },
    {
        path: "/designs/offers/:id",
        component: Offer,
        name: "View Offer"
    },
    {
        path: "/delivery/status",
        component: Delivery,
        name: "Delivery Status"
    },
    {
        path: "/marketplace",
        component: Marketplace,
        name: "Marketplace"
    },
    {
        path: "/jobs",
        component: Jobs,
        name: "Jobs"
    },
    {
        path: "/auth/settings",
        component: Settings,
        name: "Settings"
    },
    {
        path: "/auth/register/customer",
        component: require("./components/Auth/CustRegister").default,
        name: "Customer Registration"
    },
    {
        path: "/auth/register/partner",
        component: require("./components/Auth/PartnerRegister").default,
        name: "Partner Registration"
    },
    {
        path: "/auth/profile/",
        component: Profile,
        name: "Profile"
    },
    {
        path: "/auth/contact/",
        component: Contact,
        name: "Contact"
    },
    {
        path: "/auth/approval/",
        component: Approval,
        name: "Approval"
    },
    {
        path: "/shop/myshop/",
        component: MyShop,
        name: "My Shop"
    },
    {
        path: "/shop/view/:id",
        component: ViewItemShop,
        name: "View Item"
    },
    {
        path: "/shop/add/",
        component: AddItemShop,
        name: "Add Item"
    },
    {
        path: "/shop/edit/:id",
        component: EditItemShop,
        name: "Edit Item"
    },
    {
        path: "/shop/",
        component: Shop,
        name: "Shop"
    },



]

const router = new VueRouter({
    mode: 'history',
    routes,
});

export default router;
