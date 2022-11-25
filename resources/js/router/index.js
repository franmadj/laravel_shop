import { createWebHistory, createRouter } from "vue-router";
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

export const routes = [{
        path: '/shop',
        component: Dashboard,
        name: 'Shop',
    },
    {
        path: '/shop/:slug',
        component: ShopProduct,
        name: 'ShopProduct',
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
            requiresAuth: true
        }
    },
    {
        path: '/admin/product/:id',
        component: Product,
        props: true,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/admin/products',
        component: Products,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/admin/categories',
        component: Categories,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/admin/attributes',
        component: Attributes,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/admin/orders',
        component: Orders,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/admin/users',
        component: Users,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/admin/add-user',
        component: AddUser,
        meta: {
            requiresAuth: true
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
        path: '/admin/login',
        component: Login,
        name: "Login"
    },
    {
        path: '/admin/register',
        component: Register,
        name: "Register"
    },


]

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (window.Laravel.isLoggedin) {
            next();
            return;
        } else {
            router.push('/admin/login');
        }
    } else {
        if (window.Laravel.isLoggedin && '/admin/login' == to.path) {
            window.location.href = "/admin";
            return;
        }
        next();
    }
});

export default router;