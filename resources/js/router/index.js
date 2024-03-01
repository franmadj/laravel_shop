import { createWebHistory, createRouter } from "vue-router";
const Product = () =>
    import ('../Admin/Pages/Product.vue')
const ProductEdit = () =>
    import ('../Admin/Pages/ProductEdit.vue')
const Products = () =>
    import ('../Admin/Pages/Products.vue')
const Dashboard = () =>
    import ('../Admin/Pages/Dashboard.vue')
const Categories = () =>
    import ('../Admin/Pages/Categories.vue')
const Attributes = () =>
    import ('../Admin/Pages/Attributes.vue')
const Orders = () =>
    import ('../Admin/Pages/Orders.vue')
const OrderEdit = () =>
    import ('../Admin/Pages/OrderEdit.vue')
const MyOrders = () =>
    import ('../Admin/Pages/MyOrders.vue')
const MyOrder = () =>
    import ('../Admin/Pages/MyOrder.vue')
const Users = () =>
    import ('../Admin/Pages/Users.vue')
const User = () =>
    import ('../Admin/Pages/User.vue')
const UserEdit = () =>
    import ('../Admin/Pages/UserEdit.vue')
const Account = () =>
    import ('../Admin/Pages/Account.vue')
const Login = () =>
    import ('../Auth/Pages/Login.vue')
const Register = () =>
    import ('../Auth/Pages/Register.vue')
const ForgotPassword = () =>
    import ('../Auth/Pages/ForgotPassword.vue')
const ResetPassword = () =>
    import ('../Auth/Pages/ResetPassword.vue')
const Shop = () =>
    import ('../Shop/Pages/Shop.vue')
const ShopProduct = () =>
    import ('../Shop/Pages/ShopProduct.vue')
const Cart = () =>
    import ('../Shop/Pages/Cart.vue')
const Checkout = () =>
    import ('../Shop/Pages/Checkout.vue')

/*
import Product from '../Admin/Pages/Product.vue'
import Products from '../Admin/Pages/Products.vue'
import Dashboard from '../Admin/Pages/Dashboard.vue'
import Categories from '../Admin/Pages/Categories.vue'
import Attributes from '../Admin/Pages/Attributes.vue'
import Orders from '../Admin/Pages/Orders.vue'
import Users from '../Admin/Pages/Users.vue'
import AddUser from '../Admin/Pages/AddUser.vue'
import Account from '../Admin/Pages/Account.vue'

import Login from '../Auth/Login.vue'
import Register from '../Auth/Register.vue'

import ShopProduct from '../Shop/Pages/ShopProduct.vue'
*/
export const routes = [{
        path: '/',
        component: Shop,
        name: 'Shop',
        meta: {
            isPublicPage: true
        }
    },
    {
        path: '/shop/:slug',
        component: ShopProduct,
        name: 'ShopProduct',
        props: true,
        meta: {
            isPublicPage: true
        }
    },
    {
        path: '/cart',
        component: Cart,
        name: 'Cart',
        meta: {
            isPublicPage: true
        }
    },
    {
        path: '/checkout',
        component: Checkout,
        name: 'Checkout',
        meta: {
            isPublicPage: true
        }
    },
    {
        path: '/admin',
        component: Dashboard,
        name: 'Dashboard',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/admin/product',
        component: Product,
        meta: {
            requiresAuth: true,
            requiresAdmin: true
        }
    },
    {
        path: '/admin/product/:id',
        component: ProductEdit,
        props: true,
        meta: {
            requiresAuth: true,
            requiresAdmin: true
        }
    },
    {
        path: '/admin/products',
        component: Products,
        meta: {
            requiresAuth: true,
            requiresAdmin: true
        }
    },
    {
        path: '/admin/categories',
        component: Categories,
        meta: {
            requiresAuth: true,
            requiresAdmin: true
        }
    },
    {
        path: '/admin/attributes',
        component: Attributes,
        meta: {
            requiresAuth: true,
            requiresAdmin: true
        }
    },
    {
        path: '/admin/orders',
        component: Orders,
        meta: {
            requiresAuth: true,
            requiresAdmin: true
        }
    },
    {
        path: '/admin/order/:id',
        component: OrderEdit,
        props: true,
        meta: {
            requiresAuth: true,
            requiresAdmin: true
        }
    },
    {
        path: '/admin/users',
        component: Users,
        meta: {
            requiresAuth: true,
            requiresAdmin: true
        }
    },
    {
        path: '/admin/add-user',
        component: User,
        meta: {
            requiresAuth: true,
            requiresAdmin: true
        }
    },
    {
        path: '/admin/user/:id',
        component: UserEdit,
        props: true,
        meta: {
            requiresAuth: true,
            requiresAdmin: true
        }
    },
    {
        path: '/admin/account',
        component: Account,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/admin/my-orders',
        component: MyOrders,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/admin/my-order/:id',
        component: MyOrder,
        props: true,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/login',
        component: Login,
        name: "Login"
    },
    {
        path: '/forgot-password',
        component: ForgotPassword,
        name: "ForgotPassword"
    },
    {
        path: '/reset-password/:token',
        component: ResetPassword,
        name: "ResetPassword",
        props: true,
    },
    {
        path: '/register',
        component: Register,
        name: "Register"
    },


]

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

router.beforeEach((to, from, next) => {
    console.log('to', to);

    const notAllowAuthPages = window.Laravel.isLoggedin && ['/login', '/register', '/forgot-password'].includes(to.path);
    const needsAdmin = to.matched.some(record => record.meta.requiresAdmin) && !window.Laravel.isAdmin;

    if (notAllowAuthPages || needsAdmin) {
        router.push('/admin');
        return;
    }

    const needsLoggedIn = to.matched.some(record => record.meta.requiresAuth) && !window.Laravel.isLoggedin;

    if (needsLoggedIn) {
        router.push('/login');
        return;
    }

    next();




});

export default router;