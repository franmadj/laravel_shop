<template>
    <div class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
        <!--Nav-->
        <Navbar />
        <GlobalGroupTransition>
            <section class="bg-white py-8 px-2">
                <div class="max-w-4xl mx-auto pt-4 pb-12">

                    <router-link to="/cart" class="flex gap-2 items-center mb-9">
                        <svg class="w-4" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                            <path
                                d="M64 468V44c0-6.6 5.4-12 12-12h48c6.6 0 12 5.4 12 12v176.4l195.5-181C352.1 22.3 384 36.6 384 64v384c0 27.4-31.9 41.7-52.5 24.6L136 292.7V468c0 6.6-5.4 12-12 12H76c-6.6 0-12-5.4-12-12z" />
                        </svg>
                        <p class="text-xl">Back to cart</p>

                    </router-link>
                    <h1 class="text-4xl text-center uppercase mb-10">order checkout</h1>
                    <div class="flex justify-between gap-10">

                        <div class="w-1/2 bg-black px-5 py-10 text-white text-center rounded-sm">
                            <h3 class="uppercase mb-5 text-left">billing details</h3>
                            <div class="flex flex-wrap justify-between mb-1 gap-1">
                                <input class="p-2 bg-slate-800 text-white grow-0 w-[49.4%]" type="text"
                                    placeholder="FIRST NAME" v-model="form.fName" />
                                <input class="p-2 bg-slate-800 text-white grow-0 w-[49.4%]" type="text"
                                    placeholder="LAST NAME" v-model="form.lName" />
                            </div>
                            <div class="flex flex-wrap justify-between mb-1 gap-1">
                                <input class="p-2 bg-slate-800 text-white grow-0 w-full" type="email"
                                    placeholder="EMAIL" v-model="form.email" />
                            </div>
                            <div class="flex flex-wrap justify-between mb-1 gap-1">
                                <input class="p-2 bg-slate-800 text-white grow-0 w-full" type="email"
                                    placeholder="CONFIRM EMAIL" v-model="form.cEmail" />
                            </div>


                            <div class="flex flex-wrap justify-between mb-1 gap-1">
                                <input class="p-2 bg-slate-800 text-white grow-0 w-full" type="text"
                                    placeholder="STREET ADDRESS" v-model="form.street" />
                            </div>
                            <div class="flex flex-wrap justify-between mb-1 gap-1">
                                <input class="p-2 bg-slate-800 text-white grow-0 w-[49.4%]" type="text"
                                    placeholder="APT NAME, SUITE" v-model="form.suite" />
                                <input class="p-1 bg-slate-800 text-white grow-0 w-[49.4%]" type="text"
                                    placeholder="TOWN CITY" v-model="form.town" />
                            </div>
                            <div class="flex flex-wrap justify-between mb-1 gap-1">
                                <select class="p-2 bg-slate-800 text-white grow-0 w-[49.4%]" v-model="form.state">
                                    <option value="">STATE</option>
                                </select>

                                <input class="p-2 bg-slate-800 text-white grow-0 w-[49.4%]" type="text"
                                    placeholder="POSTAL CODE / ZIP" v-model="form.pc" />
                            </div>
                            <div class="flex flex-wrap justify-between mb-1 gap-1">
                                <input class="p-2 bg-slate-800 text-white grow-0 w-full" type="tel" placeholder="PHONE"
                                    v-model="form.phone" />
                            </div>
                            <div class="flex flex-wrap justify-between mb-1 gap-1">
                                <input class="p-2 bg-slate-800 text-white grow-0 w-full" type="text"
                                    placeholder="CONFIRM EMAIL" v-model="form.cEmail" />
                            </div>

                        </div>

                        <div class="w-1/2 px-5 py-2 text-black">
                            <ul>
                                <li class="flex justify-between items-start mb-4 border-b border-gray-300 pb-2"
                                    v-for="(cartItem, index) of cartItems" :key="index">
                                    <div class="flex items-start gap-5">
                                        <img :src="cartItem.image" class="w-16 rounded-md" />
                                        <div>
                                            <span v-html="cartItemTitle(cartItem)"></span>
                                            <span>x{{ cartItem.quantity }}</span>
                                        </div>


                                    </div>
                                    <div class="text-2xl">
                                        ${{ cartItem.price }}
                                    </div>
                                </li>

                                <li class="flex justify-between items-start mb-4 border-b border-gray-300 pb-2">
                                    <p class="uppercase">Order Total</p>
                                    <p class="" v-text="cartTotal"></p>

                                </li>

                            </ul>
                            <router-link to="/checkout"
                                class="bg-black text-white inline-block px-6 py-2.5 font-medium text-xs leading-tight uppercase rounded shadow-md w-fit">
                                Place Order
                            </router-link>

                        </div>



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

const form = ref({})



onMounted(() => {

})

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



