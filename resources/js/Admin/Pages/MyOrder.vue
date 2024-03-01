<template>
    <GlobalTransition>
        <div v-if="show" class="min-h-screen p-6 grow overflow-hidden text-gray-600">
            <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600">My Order</h1>
            <form class="flex flex-col lg:flex-row gap-5" v-if="order.buyer_details">
                <!--LEFT SIDE-->
                <div class="w-full">
                    <h1 class="font-bold mb-2 text-xl">Order #{{ order.id }} details</h1>
                    <p class="font-medium mb-6">Payment via Cash on {{ order.date }}</p>
                    <div class="flex flex-col sm:flex-row gap-6 p-4 border border-gray-200 rounded mb-4">
                        <div class="w-full sm:w-1/5">
                            <h3 class="mb-2 text-lg font-medium">General</h3>
                            <div class="mb-4">
                                <label for="content">Date created:</label>
                                <p>{{ order.date }}</p>
                                
                            </div>
                            <div class="mb-4">
                                <label for="content">Status:</label>
                                <p>{{ order.status }}</p>
                                
                            </div>
                        </div>
                        <div class="w-full sm:w-2/5">
                            <h3 class="mb-2 text-lg font-medium flex">Billing
                                
                            </h3>
                            <div>
                                <p v-text="order.buyer_name"></p>
                                <p v-text="order.buyer_details.address"></p>
                                <p>{{ order.buyer_details.state }} {{ order.buyer_details.pc }}</p>
                                <p v-text="order.buyer_details.email"></p>
                                <p v-text="order.buyer_details.phone"></p>

                            </div>
                     



                        </div>
                        <div class="w-full sm:w-2/5">
                            <h3 class="mb-2 text-lg font-medium flex">Shipping
                                
                            </h3>
                            <div>
                                <p>{{ order.buyer_details.sh_first_name }} {{ order.buyer_details.sh_last_name }}</p>
                                <p v-text="order.buyer_details.sh_address"></p>
                                <p>{{ order.buyer_details.sh_state }} {{ order.buyer_details.sh_pc }}</p>
                                <p v-text="order.buyer_details.sh_phone"></p>
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
    await axios.get('/api/admin/my-orders/' + id)
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
