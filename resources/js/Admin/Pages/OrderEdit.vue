<template>
    <GlobalTransition>
        <div v-if="show" class="min-h-screen p-6 grow overflow-hidden text-gray-600">
            <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600">Edit Order</h1>
            <form class="flex flex-col lg:flex-row gap-5">
                <!--LEFT SIDE-->
                <div class="w-full lg:w-4/5">
                    <h1 class="font-bold mb-2 text-xl">Order #15445 details</h1>
                    <p class="font-medium mb-2">Payment via Cash on April 13, 2023 @ 10:12 pm. Customer 24.45.154.153</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="w-full sm:w-1/5">
                            <h3 class="mb-2 text-lg font-medium">General</h3>
                            <div class="mb-4">
                                <label for="content">Date created:</label>
                                <Datepicker v-model="order.date" class="w-full" />
                            </div>
                            <div class="mb-4">
                                <label for="content">Status:</label>
                                <select v-model="order.status" class="p-2 border rounded-sm shadow-sm block w-full">
                                    <option value="simple">Pending</option>
                                    <option value="variable">Completed</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-full sm:w-2/5">
                            <h3 class="mb-2 text-lg font-medium">Billing</h3>
                            <div class="flex justify-between mb-4 gap-2">
                                <div class="w-full">
                                    <label for="first_name">First Name:</label>
                                    <input v-model="order.first_name" type="text"
                                        class="p-2 border rounded-sm shadow-sm block w-full">
                                </div>
                                <div class="w-full">
                                    <label for="last_name">Last Name:</label>
                                    <input v-model="order.last_name" type="text"
                                        class="p-2 border rounded-sm shadow-sm block w-full">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="address">Street Address:</label>
                                <input v-model="order.address" type="text"
                                    class="p-2 border rounded-sm shadow-sm block w-full">
                            </div>

                            <div class="flex justify-between mb-4 gap-2">
                                <div class="w-full">
                                    <label for="first_name">First Name:</label>
                                    <input v-model="order.first_name" type="text"
                                        class="p-2 border rounded-sm shadow-sm block w-full">
                                </div>
                                <div class="w-full">
                                    <label for="last_name">Last Name:</label>
                                    <input v-model="order.last_name" type="text"
                                        class="p-2 border rounded-sm shadow-sm block w-full">
                                </div>
                            </div>

                            

                        </div>
                        <div class="w-full sm:w-2/5">

                        </div>
                    </div>
                </div>
                <!--RIGHT SIDE -->
                <div class="w-full lg:w-1/5">
                    <button class="px-2 py-1 bg-blue-700 block w-full rounded-sm text-white" type="button"
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

import Variations from '../components/Variations.vue'
import pFns from '../composables/products'
import helpers from '../../compositions/helpers'
import ConfirmDialog from '../../components/ConfirmDialog.vue'
import FileUploader from '../components/FileUploader.vue'
import GlobalTransition from '../../Transitions/GlobalTransition.vue'
import Datepicker from '@vuepic/vue-datepicker';

import '@vuepic/vue-datepicker/dist/main.css';

const show = ref(false);
const toaster = createToaster({ position: "top" });
const dialog = createConfirmDialog(ConfirmDialog)
const order = ref({ status: 'pending', items: [] })



onMounted(() => {
    if (props.id) {
        edit(props.id);
    }
    show.value = true


})

const props = defineProps({
    id: { type: Number, required: false, default: false }
})


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
    axios.post('/api/admin/order/' + props.id, order)
        .then(response => {
            if (response.data.success) {
                toaster.success(`Product updated`);
            } else {
                toaster.error(`Error`);
            }
        })
        .catch(function (error) {
            toaster.error(error);
        });
}
</script>
