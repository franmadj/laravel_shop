<template>
    <!-- Nav -->
    <nav id="header" class="w-full z-30 top-0 py-1 border-b border-gray-200">
        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-6 py-3">

            <label for="menu-toggle" class="cursor-pointer md:hidden block">
                <svg class="fill-current text-gray-900" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                    viewBox="0 0 20 20">
                    <title>menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                </svg>
            </label>
            <input class="hidden" type="checkbox" id="menu-toggle" />

            <div class="hidden md:flex md:items-center md:w-auto w-full order-3 md:order-1" id="menu">
                <nav>
                    <ul class="md:flex items-center justify-between text-base text-gray-700 pt-4 md:pt-0">
                        <li>
                            <router-link to="/"
                                class="inline-block no-underline hover:text-black hover:underline py-2 px-4">Shop</router-link>
                        </li>
                        
                    </ul>
                </nav>
            </div>

            <div class="order-1 md:order-2">
                <a class="flex items-center tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl "
                    href="#">
                    <svg class="fill-current text-gray-800 mr-2" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24">
                        <path
                            d="M5,22h14c1.103,0,2-0.897,2-2V9c0-0.553-0.447-1-1-1h-3V7c0-2.757-2.243-5-5-5S7,4.243,7,7v1H4C3.447,8,3,8.447,3,9v11 C3,21.103,3.897,22,5,22z M9,7c0-1.654,1.346-3,3-3s3,1.346,3,3v1H9V7z M5,10h2v2h2v-2h6v2h2v-2h2l0.002,10H5V10z" />
                    </svg>
                    e-comerce
                </a>
            </div>

            <ul class="order-2 md:order-3 flex items-center" id="nav-content">

                <li class="inline-block no-underline hover:text-black relative group" href="#">
                    <a href="#" class="">
                        <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24">
                            <circle fill="none" cx="12" cy="7" r="3" />
                            <path
                                d="M12 2C9.243 2 7 4.243 7 7s2.243 5 5 5 5-2.243 5-5S14.757 2 12 2zM12 10c-1.654 0-3-1.346-3-3s1.346-3 3-3 3 1.346 3 3S13.654 10 12 10zM21 21v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h2v-1c0-2.757 2.243-5 5-5h4c2.757 0 5 2.243 5 5v1H21z" />
                        </svg>
                    </a>
                    <ul class="absolute top-5 z-10 -left-3 hidden group-hover:block pt-3">
                        <li v-if="isAuthenicated">
                            <a href="/admin" class="py-1 px-5 border-b border-cyan-100 block bg-neutral-50 hover:bg-neutral-100">Dashboard</a>
                        </li>
                        <li v-if="isAuthenicated">
                            <a class="py-1 px-5 border-b border-cyan-100 block bg-neutral-50 hover:bg-neutral-100" href="#" @click="logout">Log Out</a>
                        </li>
                        <li v-else>
                            <a class="py-1 px-5 border-b border-cyan-100 block bg-neutral-50 hover:bg-neutral-100 min-w-[86px]" href="/login">Log In</a>
                        </li>
                    </ul>
                </li>

                <li class="pl-3 inline-block no-underline hover:text-black static sm:relative" href="#">
                    <a href="#" @click.prevent="openCartPreview" class="relative">
                        <span
                            class="absolute rounded-full text-center bg-red-500 text-white p-1 w-5 h-5 -top-2 -right-2 leading-3 fs-10">{{
                                cartQuantity
                            }}</span>
                        <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24">
                            <path
                                d="M21,7H7.462L5.91,3.586C5.748,3.229,5.392,3,5,3H2v2h2.356L9.09,15.414C9.252,15.771,9.608,16,10,16h8 c0.4,0,0.762-0.238,0.919-0.606l3-7c0.133-0.309,0.101-0.663-0.084-0.944C21.649,7.169,21.336,7,21,7z M17.341,14h-6.697L8.371,9 h11.112L17.341,14z" />
                            <circle cx="10.5" cy="18.5" r="1.5" />
                            <circle cx="17.5" cy="18.5" r="1.5" />
                        </svg>
                    </a>
                    <div v-show="cartPreview" id="contentCartPreview"
                        class="absolute border rounded border-gray-400 z-20 sm:min-w-[340px] w-full right-0 bg-white">
                        <h3 class="flex justify-center gap-2 pt-5 pb-3 text-xl">Your Cart 
                            <svg class="text-white w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"/></svg></h3>
                        <ul v-if="cartItems.length">
                            <li class="p-2 border-b border-gray-400 w-full flex justify-between gap-1"
                                v-for="(cartItem, index) of cartItems" :key="index">
                                <span v-html="cartItemTitle(cartItem)"></span>
                                <span>x{{ cartItem.quantity }}</span>
                                <span>${{ cartItem.price }}</span>
                            </li>
                            <li class="p-2 text-right">Total: <span class="font-bold">{{ cartTotal }}</span></li>
                            <li class="p-2">
                                <router-link to="/cart"
                                    class="dark:bg-gray-800 dark:border-gray-600  dark:text-gray-400 text-center inline-block px-6 py-2.5 font-medium text-xs leading-tight uppercase rounded shadow-md w-full">Go
                                    To yout cart</router-link>
                            </li>
                            <li class="p-2">
                                <router-link to="/checkout"
                                    class="dark:bg-gray-800 dark:border-gray-600  dark:text-gray-400 text-center inline-block px-6 py-2.5 font-medium text-xs leading-tight uppercase rounded shadow-md w-full">
                                    Checkout</router-link>
                            </li>
                            <li class="p-2">
                                <button type="button" @click="emptyCart"
                                    class="dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 inline-block px-6 py-2.5 font-medium text-xs leading-tight uppercase rounded shadow-md w-full">Empty
                                    Cart</button>
                            </li>

                        </ul>
                        <p v-else class="flex m-4 justify-center">Your cart is empty</p>

                    </div>
                </li>

            </ul>
        </div>
    </nav>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useStore } from 'vuex'
import { createToaster } from "@meforma/vue-toaster"
import { createConfirmDialog } from 'vuejs-confirm-dialog'

const store = useStore()




onMounted(() => {
    //populateTerms();


})

const cartItems = computed(() => store.getters['cart/cartItems'])
const cartQuantity = computed(() => store.getters['cart/cartQuantity'])
const cartTotal = computed(() => store.getters['cart/cartTotal'])
const isAuthenicated = ref(store.getters['auth/authenticated'])
const isAdmin = ref(store.getters['auth/user'].isAdmin)

const cartPreview = ref(false)

const emptyCart = () => {
    store.commit('cart/EMPTY_CART')
}

const openCartPreview = () => {
    cartPreview.value = true
    setTimeout(() => {
        const contentCartPreview = document.getElementById('contentCartPreview')
        
        console.log('popup', contentCartPreview);

        const handleClickOutside = (e) => {
            if (!(contentCartPreview === e.target || contentCartPreview.contains(e.target))) {
                cartPreview.value = false
                document.body.removeEventListener('click', handleClickOutside)

            }
        }
        document.body.addEventListener('click', handleClickOutside)

    }, 500)

}

const cartItemTitle = (cartItem) => {
    let title = cartItem.title
    if (cartItem.isVariable)
        title += '<span class="block text-xs font-bold">' + cartItem.variation.name + '</span>'
    return title
}

const logout = (e) => {
    console.log('ss')
    e.preventDefault()
    //axios.get('/sanctum/csrf-cookie').then(response => {
    axios.post('/api/logout')
        .then(response => {
            if (response.data.success) {
                store.dispatch('auth/logout')
            } else {
                console.log(response)
            }
        })
        .catch(function (error) {
            console.error(error);
        });
    //})
}




</script>



