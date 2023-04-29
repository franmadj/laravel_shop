<template>
    <div class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
        <!--Nav-->
        <Navbar />
        <GlobalGroupTransition>
            <section v-if="!orderPlacedId" class="bg-white py-8 px-2">
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
                                <input class="p-2 bg-slate-800 text-white grow-0 w-[49.4%]"
                                    :class='{ "border border-red-400 border-solid": v$.first_name.$errors.length }'
                                    @blur="v$.first_name.$touch" type="text" placeholder="FIRST NAME"
                                    v-model="form.first_name" />

                                <input class="p-2 bg-slate-800 text-white grow-0 w-[49.4%]" type="text"
                                    :class='{ "border border-red-400 border-solid": v$.last_name.$errors.length }'
                                    @blur="v$.last_name.$touch" placeholder="LAST NAME" v-model="form.last_name" />
                            </div>

                            <div class="flex flex-wrap justify-between mb-1 gap-1">
                                <input class="p-2 bg-slate-800 text-white grow-0 w-full" type="email" placeholder="EMAIL"
                                    :class='{ "border border-red-400 border-solid": v$.email.$errors.length }'
                                    @blur="v$.email.$touch" v-model="form.email" />
                            </div>

                            <div class="flex flex-wrap justify-between mb-1 gap-1">
                                <input class="p-2 bg-slate-800 text-white grow-0 w-full" type="email"
                                    :class='{ "border border-red-400 border-solid": v$.cEmail.$errors.length }'
                                    @blur="v$.cEmail.$touch" placeholder="CONFIRM EMAIL" v-model="form.cEmail" />
                            </div>


                            <div class="flex flex-wrap justify-between mb-1 gap-1">
                                <input class="p-2 bg-slate-800 text-white grow-0 w-full" type="text"
                                    :class='{ "border border-red-400 border-solid": v$.address.$errors.length }'
                                    @blur="v$.address.$touch" placeholder="STREET ADDRESS" v-model="form.address" />
                            </div>

                            <div class="flex flex-wrap justify-between mb-1 gap-1">
                                <input class="p-2 bg-slate-800 text-white grow-0 w-[49.4%]" type="text"
                                    placeholder="APT NAME, SUITE" v-model="form.suite" />

                                <input class="p-1 bg-slate-800 text-white grow-0 w-[49.4%]" type="text"
                                    :class='{ "border border-red-400 border-solid": v$.town.$errors.length }'
                                    @blur="v$.town.$touch" placeholder="TOWN CITY" v-model="form.town" />
                            </div>

                            <div class="flex flex-wrap justify-between mb-1 gap-1">
                                <select class="p-2 bg-slate-800 text-white grow-0 w-[49.4%]"
                                    :class='{ "border border-red-400 border-solid": v$.state.$errors.length }'
                                    @blur="v$.state.$touch" v-model="form.state">
                                    <StateSelectOptions></StateSelectOptions>
                                </select>

                                <input class="p-2 bg-slate-800 text-white grow-0 w-[49.4%]" type="text"
                                    :class='{ "border border-red-400 border-solid": v$.pc.$errors.length }'
                                    @blur="v$.pc.$touch" placeholder="POSTAL CODE / ZIP" v-model="form.pc" />
                            </div>

                            <div class="flex flex-wrap justify-between mb-1 gap-1">
                                <input class="p-2 bg-slate-800 text-white grow-0 w-full" type="tel" placeholder="PHONE"
                                    :class='{ "border border-red-400 border-solid": v$.phone.$errors.length }'
                                    @blur="v$.phone.$touch" v-model="form.phone" />
                            </div>

                            <div class="flex flex-wrap justify-between mb-1 gap-1">
                                <textarea class="p-2 bg-slate-800 text-white grow-0 w-full" type="text" placeholder="Notes"
                                    v-model="form.notes"></textarea>
                            </div>

                            <div v-if="v$.$errors.length" class="border border-red-400 p-2 text-left mt-2">

                                <p v-for="(error, index) of v$.$errors" :key="index" class="text-r text-red-400">
                                    * {{ error.$message }}

                                </p>
                            </div>

                        </div>

                        <div class="w-1/2 px-5 py-2 text-black">
                            <ul>
                                <li class="flex justify-between items-start mb-4 border-b border-gray-300 pb-2"
                                    v-for="(cartItem, index) of cartItems" :key="index">
                                    <div class="flex items-start gap-5">
                                        <img :src="cartItem.image" class="w-16 rounded-xs" />
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
                            <button type="button" @click="placeOrder"
                                class="bg-black text-white inline-block px-6 py-2.5 font-medium text-xs leading-tight uppercase rounded shadow-md w-fit">
                                Place Order
                            </button>

                        </div>
                    </div>
                </div>
            </section>
            <section v-else>
                <div class="max-w-4xl mx-auto pt-4 pb-12">

                    <router-link to="/" class="flex gap-2 items-center mb-9">
                        <svg class="w-4" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                            <path
                                d="M64 468V44c0-6.6 5.4-12 12-12h48c6.6 0 12 5.4 12 12v176.4l195.5-181C352.1 22.3 384 36.6 384 64v384c0 27.4-31.9 41.7-52.5 24.6L136 292.7V468c0 6.6-5.4 12-12 12H76c-6.6 0-12-5.4-12-12z" />
                        </svg>
                        <p class="text-xl">Back to shop</p>

                    </router-link>
                    <h1 class="text-4xl text-center uppercase mb-10">order placed</h1>

                    <div class="bg-black max-w-lg w-full p-6 mx-auto">
                        <p class="text-white">Your order number {{orderPlacedId}} has been placed, you will recive an email with further details</p>

                    </div>


                </div>

            </section>
        </GlobalGroupTransition>
        <Footer />
    </div>
</template>



<script setup>
import { ref, reactive, onMounted, computed } from 'vue'

import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router';
import { createToaster } from "@meforma/vue-toaster"
import { useVuelidate } from '@vuelidate/core'
import { email, required, alphaNum, minValue, minLength, maxLength, sameAs, helpers } from '@vuelidate/validators'

import Navbar from '../Components/Navbar.vue'
import Footer from '../Components/Footer.vue'
import GlobalGroupTransition from '../../Transitions/GlobalGroupTransition.vue'
import StateSelectOptions from '../../Components/StateSelectOptions.vue'


const store = useStore()
let orderPlacedId = ref(false)

const cartItems = computed(() => store.getters['cart/cartItems'])
const cartTotal = computed(() => store.getters['cart/cartTotal'])

const form = reactive({
    first_name: '',
    email: '',
    last_name: '',
    phone: '',
    town: '',
    state: '',
    address: '',
    suite: '',
    notes: '',
    pc: '',
    cart_items: '',
    cart_total: ''
})


const rules = {
    first_name: {
        required: helpers.withMessage('First Name field cannot be empty', required),
        minLength: helpers.withMessage(
            ({
                $pending,
                $invalid,
                $params,
                $model
            }) => `This field has a value of '${$model}' but must have a min length of ${$params.min} so it is ${$invalid ? 'invalid' : 'valid'}`,
            minLength(3)
        ),
        maxLength: helpers.withMessage(
            ({
                $pending,
                $invalid,
                $params,
                $model
            }) => `This field has a value of '${$model}' but must have a max length of ${$params.max} so it is ${$invalid ? 'invalid' : 'valid'}`,
            maxLength(15)
        ),
        alphaNum: helpers.withMessage(
            ({
                $pending,
                $invalid,
                $params,
                $model
            }) => `This field has a value of '${$model}' but must be Alpha numeric`,
            alphaNum
        )

    },
    email: {
        required: helpers.withMessage('Email field cannot be empty', required),
        email: helpers.withMessage('Email field must be a valid email', email)
    },
    last_name: {
        required: helpers.withMessage('Last Name field cannot be empty', required),
        minLength: helpers.withMessage(
            ({
                $pending,
                $invalid,
                $params,
                $model
            }) => `This field has a value of '${$model}' but must have a min length of ${$params.min} so it is ${$invalid ? 'invalid' : 'valid'}`,
            minLength(3)
        ),
        maxLength: helpers.withMessage(
            ({
                $pending,
                $invalid,
                $params,
                $model
            }) => `This field has a value of '${$model}' but must have a max length of ${$params.max} so it is ${$invalid ? 'invalid' : 'valid'}`,
            maxLength(15)
        ),
        alphaNum: helpers.withMessage(
            ({
                $pending,
                $invalid,
                $params,
                $model
            }) => `This field has a value of '${$model}' but must be Alpha numeric`,
            alphaNum
        )
    },
    phone: {
        required: helpers.withMessage('Phone field cannot be empty', required),
        minLength: helpers.withMessage(
            ({
                $pending,
                $invalid,
                $params,
                $model
            }) => `This field has a value of '${$model}' but must have a min length of ${$params.min} so it is ${$invalid ? 'invalid' : 'valid'}`,
            minLength(8)
        ),
        maxLength: helpers.withMessage(
            ({
                $pending,
                $invalid,
                $params,
                $model
            }) => `This field has a value of '${$model}' but must have a max length of ${$params.max} so it is ${$invalid ? 'invalid' : 'valid'}`,
            maxLength(15)
        ),
    },
    town: {
        required: helpers.withMessage('Town field cannot be empty', required),
        minLength: helpers.withMessage(
            ({
                $pending,
                $invalid,
                $params,
                $model
            }) => `This field has a value of '${$model}' but must have a min length of ${$params.min} so it is ${$invalid ? 'invalid' : 'valid'}`,
            minLength(3)
        ),
        maxLength: helpers.withMessage(
            ({
                $pending,
                $invalid,
                $params,
                $model
            }) => `This field has a value of '${$model}' but must have a max length of ${$params.max} so it is ${$invalid ? 'invalid' : 'valid'}`,
            maxLength(20)
        ),
    },
    state: {
        required: helpers.withMessage('State field cannot be empty', required),

    },
    address: {
        required: helpers.withMessage('Street field cannot be empty', required),
        minLength: helpers.withMessage(
            ({
                $pending,
                $invalid,
                $params,
                $model
            }) => `This field has a value of '${$model}' but must have a min length of ${$params.min} so it is ${$invalid ? 'invalid' : 'valid'}`,
            minLength(5)
        ),
        maxLength: helpers.withMessage(
            ({
                $pending,
                $invalid,
                $params,
                $model
            }) => `This field has a value of '${$model}' but must have a max length of ${$params.max} so it is ${$invalid ? 'invalid' : 'valid'}`,
            maxLength(50)
        ),
    },
    pc: {
        required: helpers.withMessage('Zip Code field cannot be empty', required),
        minLength: helpers.withMessage(
            ({
                $pending,
                $invalid,
                $params,
                $model
            }) => `This field has a value of '${$model}' but must have a min length of ${$params.min} so it is ${$invalid ? 'invalid' : 'valid'}`,
            minLength(4)
        ),
        maxLength: helpers.withMessage(
            ({
                $pending,
                $invalid,
                $params,
                $model
            }) => `This field has a value of '${$model}' but must have a max length of ${$params.max} so it is ${$invalid ? 'invalid' : 'valid'}`,
            maxLength(8)
        ),
    },

    cEmail: { required, }
}

const v$ = useVuelidate(rules, form)



onMounted(() => {

    console.log(cartItems.value);

})

const placeOrder = async () => {
    console.log(form.email);

    const result = await v$.value.$validate()
    console.log(result)
    if (!result) {
        // notify user form is invalid
        return
    }

    form.cart_items = cartItems;
    form.cart_total = cartTotal;

    axios.post('/api/create-order', form)
        .then(response => {
            if (response.data.success) {
                orderPlacedId.value = response.data.data.id
                store.commit('cart/EMPTY_CART')
                //router.push('/admin/product/' + response.data.data.id)
            } else {

            }
        })
        .catch(function (error) {
            console.log(error)
            toaster.error(helpers.makeTextErrors(error));
        });


}







const cartItemTitle = (cartItem) => {
    let title = cartItem.title
    if (cartItem.isVariable)
        title += '<span class="block text-xs font-bold">' + cartItem.variation.name + '</span>'
    return title
}







</script>



