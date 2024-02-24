<template>
    <GlobalTransition>
        <div v-if="show" class="min-h-screen p-6 grow overflow-hidden text-gray-600">
            <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600">Edit Order</h1>
            <form class="flex flex-col lg:flex-row gap-5" v-if="order.buyer_details">
                <!--LEFT SIDE-->
                <div class="w-full lg:w-4/5">
                    <h1 class="font-bold mb-2 text-xl">Order #{{ order.id }} details</h1>
                    <p class="font-medium mb-6">Payment via Cash on {{ order.date }}</p>
                    <div class="flex flex-col sm:flex-row gap-6 p-4 border border-gray-200 rounded mb-4">
                        <div class="w-full sm:w-1/5">
                            <h3 class="mb-2 text-lg font-medium">General</h3>
                            <div class="mb-4">
                                <label for="content">Date created:</label>
                                <Datepicker v-model="order.date" class="w-full" />
                            </div>
                            <div class="mb-4">
                                <label for="content">Status:</label>
                                <select v-model="order.status" class="p-2 border rounded-sm shadow-sm block w-full">
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-full sm:w-2/5">
                            <h3 class="mb-2 text-lg font-medium flex">Billing
                                <svg v-if="billing_preview" class="ml-4 w-4 cursor-pointer"
                                    @click="billing_preview = !billing_preview" fill="none" stroke="currentColor"
                                    stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10">
                                    </path>
                                </svg>
                            </h3>
                            <div v-show="billing_preview">
                                <p v-text="order.buyer_name"></p>
                                <p v-text="order.buyer_details.address"></p>
                                <p>{{ order.buyer_details.state }} {{ order.buyer_details.pc }}</p>
                                <p v-text="order.buyer_details.email"></p>
                                <p v-text="order.buyer_details.phone"></p>

                            </div>
                            <div v-show="!billing_preview">
                                <div class="flex justify-between mb-4 gap-2">
                                    <div class="w-full">
                                        <label for="first_name">First Name:</label>
                                        <input v-model="order.buyer_details.first_name" type="text"
                                            class="p-1 border rounded-sm shadow-sm block w-full">
                                    </div>
                                    <div class="w-full">
                                        <label for="last_name">Last Name:</label>
                                        <input v-model="order.buyer_details.last_name" type="text"
                                            class="p-1 border rounded-sm shadow-sm block w-full">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="address">Street Address:</label>
                                    <input v-model="order.buyer_details.address" type="text"
                                        class="p-1 border rounded-sm shadow-sm block w-full">
                                </div>

                                <div class="flex justify-between mb-4 gap-2">
                                    <div class="w-full">
                                        <label for="email">Email:</label>
                                        <input v-model="order.buyer_details.email" type="text"
                                            class="p-1 border rounded-sm shadow-sm block w-full">
                                    </div>
                                    <div class="w-full">
                                        <label for="phone">Phone:</label>
                                        <input v-model="order.buyer_details.phone" type="text"
                                            class="p-1 border rounded-sm shadow-sm block w-full">
                                    </div>
                                </div>

                                <div class="flex justify-between mb-4 gap-2">
                                    <div class="w-full">
                                        <label for="suite">Apt name, suite:</label>
                                        <input v-model="order.buyer_details.suite" type="text"
                                            class="p-1 border rounded-sm shadow-sm block w-full">
                                    </div>
                                    <div class="w-full">
                                        <label for="town">Town:</label>
                                        <input v-model="order.buyer_details.town" type="text"
                                            class="p-1 border rounded-sm shadow-sm block w-full">
                                    </div>
                                </div>

                                <div class="flex justify-between mb-4 gap-2">
                                    <div class="w-full">
                                        <label for="first_name">State:</label>
                                        <select class="p-2 border rounded-sm shadow-sm block w-full"
                                            v-model="order.buyer_details.state">
                                            <StateSelectOptions></StateSelectOptions>
                                        </select>
                                    </div>
                                    <div class="w-full">
                                        <label for="pc">Postal code:</label>
                                        <input v-model="order.buyer_details.pc" type="text"
                                            class="p-1 border rounded-sm shadow-sm block w-full">
                                    </div>
                                </div>
                            </div>



                        </div>
                        <div class="w-full sm:w-2/5">
                            <h3 class="mb-2 text-lg font-medium flex">Shipping
                                <svg v-if="shipping_preview" class="ml-4 w-4 cursor-pointer"
                                    @click="shipping_preview = !shipping_preview" fill="none" stroke="currentColor"
                                    stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10">
                                    </path>
                                </svg>
                            </h3>
                            <div v-if="shipping_preview">
                                <p>{{ order.buyer_details.sh_first_name }} {{ order.buyer_details.sh_last_name }}</p>
                                <p v-text="order.buyer_details.sh_address"></p>
                                <p>{{ order.buyer_details.sh_state }} {{ order.buyer_details.sh_pc }}</p>
                                <p v-text="order.buyer_details.sh_phone"></p>
                            </div>
                            <div v-else>
                                <div class="flex justify-between mb-4 gap-2">
                                    <div class="w-full">
                                        <label for="first_name">First Name:</label>
                                        <input v-model="order.buyer_details.sh_first_name" type="text"
                                            class="p-1 border rounded-sm shadow-sm block w-full">
                                    </div>
                                    <div class="w-full">
                                        <label for="last_name">Last Name:</label>
                                        <input v-model="order.buyer_details.sh_last_name" type="text"
                                            class="p-1 border rounded-sm shadow-sm block w-full">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="address">Street Address:</label>
                                    <input v-model="order.buyer_details.sh_address" type="text"
                                        class="p-1 border rounded-sm shadow-sm block w-full">
                                </div>

                                <div class="flex justify-between mb-4 gap-2">
                                    <div class="w-full">
                                        <label for="email">Email:</label>
                                        <input v-model="order.buyer_details.sh_email" type="text"
                                            class="p-1 border rounded-sm shadow-sm block w-full">
                                    </div>
                                    <div class="w-full">
                                        <label for="phone">Phone:</label>
                                        <input v-model="order.buyer_details.sh_phone" type="text"
                                            class="p-1 border rounded-sm shadow-sm block w-full">
                                    </div>
                                </div>

                                <div class="flex justify-between mb-4 gap-2">
                                    <div class="w-full">
                                        <label for="suite">Apt name, suite:</label>
                                        <input v-model="order.buyer_details.sh_suite" type="text"
                                            class="p-1 border rounded-sm shadow-sm block w-full">
                                    </div>
                                    <div class="w-full">
                                        <label for="town">Town:</label>
                                        <input v-model="order.buyer_details.sh_town" type="text"
                                            class="p-1 border rounded-sm shadow-sm block w-full">
                                    </div>
                                </div>

                                <div class="flex justify-between mb-4 gap-2">
                                    <div class="w-full">
                                        <label for="first_name">State:</label>
                                        <select class="p-1 border rounded-sm shadow-sm block w-full"
                                            v-model="order.buyer_details.sh_state">
                                            <StateSelectOptions></StateSelectOptions>
                                        </select>
                                    </div>
                                    <div class="w-full">
                                        <label for="pc">Postal code:</label>
                                        <input v-model="order.buyer_details.sh_pc" type="text"
                                            class="p-1 border rounded-sm shadow-sm block w-full">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="p-4 border border-gray-200 rounded">
                        <table class="w-full">
                            <thead>
                                <tr class="flex p-3 bg-gray-100">
                                    <th class="w-full text-left">Item</th>
                                    <th class="w-14 text-left">Cost</th>
                                    <th class="w-12 text-left">Qty</th>
                                    <th class="w-14 text-left">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in order.cart_items" :key="index" class="flex p-3">
                                    <td class="flex gap-3 w-full items-start">
                                        <img :src="item.image" class="w-14" />
                                        <div>
                                            <p v-text="item.title"></p>
                                            <div v-if="item.isVariable">
                                                <p v-text="item.variation.name"></p>
                                                <p>Variation ID: {{ item.variation.id }}</p>

                                            </div>
                                        </div>
                                    </td>

                                    <td class="w-14 text-left">${{ item.isVariable ? item.variation.price : item.price }}
                                    </td>
                                    <td class="w-12 text-left">{{ item.quantity }}</td>
                                    <td class="w-14 text-left">${{ item.isVariable ? item.variation.price : item.price *
                                        item.quantity }}</td>
                                </tr>
                            </tbody>
                            <tr class="p-3 flex justify-end">
                                <td colspan="4" class="text-right font-bold">Order Total: ${{ order.cart_total }}</td>
                            </tr>
                            <tr class="p-3 border-t border-gray-200 flex justify-end">
                                <td colspan="4" class="text-right font-bold">Total payed: ${{ order.cart_total }}</td>
                            </tr>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>


                </div>
                <!--RIGHT SIDE -->
                <div class="w-full lg:w-1/5">
                    <OrderNotes :orderId="order.id" :notes="order.notes"/>
                    <button class="px-2 py-1 mt-2 bg-blue-700 block w-full rounded-sm text-white" type="button"
                        @click="update()">Update
                        Order</button>
                </div>
            </form>
        </div>
    </GlobalTransition>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue'
import { createToaster } from "@meforma/vue-toaster"
import { createConfirmDialog } from 'vuejs-confirm-dialog'

import OrderNotes from '../components/OrderNotes.vue'
import pFns from '../composables/products'
import helpers from '../../compositions/helpers'
import ConfirmDialog from '../../components/ConfirmDialog.vue'
import FileUploader from '../components/FileUploader.vue'
import GlobalTransition from '../../Transitions/GlobalTransition.vue'
import Datepicker from '@vuepic/vue-datepicker';
import StateSelectOptions from '../../Components/StateSelectOptions.vue'

import '@vuepic/vue-datepicker/dist/main.css';

const show = ref(false);
const toaster = createToaster({ position: "top" });
const dialog = createConfirmDialog(ConfirmDialog)
const order = ref({ status: 'pending', items: [] })
const billing_preview = ref(true)
const shipping_preview = ref(true)



onMounted(() => {
    if (props.id) {
        edit(props.id);
    }
    show.value = true


})

const props = defineProps({
    id: { type: Number, required: false, default: false }
})

const getBuyerDetails = (key) => {
    if (order.value.buyer_details.hasOwnProperty(key))
        return order.value.buyer_details[key]
    return ''

}


const edit = async (id) => {
    await axios.get('/api/admin/order/' + id)
        .then(res => {
            if (res.data.success) {
                order.value = res.data.data;
            } else {
                toaster.error(`Error`);
            }
        })
        .catch(function (error) {
            toaster.error(error);
        });
}


const update = async () => {
    console.log('update')
    console.log('order.value', order.value); 
    axios.put('/api/admin/order/' + order.value.id, order.value)
        .then(response => {
            if (response.data.success) {
                toaster.success(`Order updated`);
            } else {
                toaster.error(`Error`);
            }
        })
        .catch(function (error) {
            toaster.error(error);
        });
}
</script>
