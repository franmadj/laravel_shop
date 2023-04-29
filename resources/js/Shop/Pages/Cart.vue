<template>
    <div class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
        <!--Nav-->
        <Navbar />
        <GlobalGroupTransition>
            <section class="bg-white py-8 px-2">
                <div class="max-w-3xl mx-auto pt-4 pb-12">

                    <router-link to="/" class="flex gap-2 items-center mb-9">
                        <svg class="w-4" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                            <path
                                d="M64 468V44c0-6.6 5.4-12 12-12h48c6.6 0 12 5.4 12 12v176.4l195.5-181C352.1 22.3 384 36.6 384 64v384c0 27.4-31.9 41.7-52.5 24.6L136 292.7V468c0 6.6-5.4 12-12 12H76c-6.6 0-12-5.4-12-12z" />
                        </svg>
                        <p>Back to shop</p>

                    </router-link>
                    <div class="w-full bg-black px-5 py-8 text-white text-center rounded-sm">
                        <h1 class="uppercase mb-5 text-3xl">Your Cart <span class="text-gray-500">({{ cartQuantity }})</span></h1>
                        <table class="w-full">
                            <tr class="border-t border-white border-b">
                                <th class="text-center uppercase p-3">Item</th>
                                <th class="text-center uppercase p-3">Amount</th>
                                <th class="text-center uppercase p-3">qty</th>
                                <th class="text-center uppercase p-3">remove</th>
                            </tr>

                            <tr class="" v-for="(cartItem, index) of cartItems" :key="index">
                                <th class="text-center font-normal p-3 flex items-center gap-5">
                                    <img :src="cartItem.image"
                                        class="w-16 rounded">
                                    <span class="text-left" v-html="cartItemTitle(cartItem)"></span> 
                                </th>
                                <th class="text-center font-normal p-3">${{ cartItem.price }}</th>
                                <th class="text-center font-normal p-3">
                                    <input class="rounded-sm w-14 text-black px-2 py-1 " type="number" @change="updateQuantity(index, $event)"
                                        :value="cartItem.quantity" />
                                </th>
                                <th class="font-normal p-3">
                                    <svg class="cursor-pointer w-4 text-white block mx-auto" @click="removeItem(index)"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 448 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                        <path fill="#fff"
                                            d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z" />
                                    </svg>
                                </th>
                            </tr>
                        </table>





                    </div>

                    <div class="flex justify-between text-2xl mt-10 border-gray-200 border-t pt-5">
                        <p class="uppercase">Order Total</p>
                        <p class="">$<span v-text="cartTotal"></span></p>

                    </div>
                    <div class="text-right mt-5">
                        <router-link to="/checkout"
                            class="bg-black text-white inline-block px-6 py-2.5 font-medium text-xs leading-tight uppercase rounded shadow-md w-fit">
                            Go Continue Checkout
                        </router-link>
                    </div>
                </div>
            </section>
        </GlobalGroupTransition>
        <Footer />
    </div>
</template>



<script setup>
import { ref, onMounted, computed } from 'vue'

import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router';
import { createToaster } from "@meforma/vue-toaster"

import Navbar from '../Components/Navbar.vue'
import Footer from '../Components/Footer.vue'
import GlobalGroupTransition from '../../Transitions/GlobalGroupTransition.vue'


const store = useStore()

const cartItems = computed(() => store.getters['cart/cartItems'])
const cartTotal = computed(() => store.getters['cart/cartTotal'])
const cartQuantity = computed(() => store.getters['cart/cartQuantity'])



onMounted(() => {

})

const updateQuantity=(index,e)=>{
    console.log(index,e.target.value);
    store.commit('cart/UPDATE_CART_ITEM', {index, qty:e.target.value})
}

const removeItem = (index) => {
    store.commit('cart/REMOVE_CART_ITEM', index)

}

const cartItemTitle = (cartItem) => {
    let title = cartItem.title
    if (cartItem.isVariable)
        title += '<span class="block text-xs font-bold">' + cartItem.variation.name + '</span>'
    return title
}





</script>



