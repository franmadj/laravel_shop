<template>
    <div class="grow min-h-screen p-6 overflow-hidden">
        <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600">Orders</h1>
        <form class="flex flex-col md:flex-row space-y-4 md:space-y-0">
            <input placeholder="search" type="text" class="p-2 border rounded-sm shadow-sm w-full mr-2">
            <select class="p-2 border rounded-sm shadow-sm w-full md:w-fit mr-2">
                <option>Category</option>
                <option>car1</option>
            </select>

            <select class="p-2 border rounded-sm shadow-sm w-full md:w-fit mr-2">
                <option>Order Type</option>
                <option>Variable</option>
            </select>

            <select class="p-2 border rounded-sm shadow-sm w-full md:w-fit mr-2">
                <option>Status</option>
                <option>Published</option>
            </select>

            <button class="px-3 py-1 bg-gray-800 block w-full md:w-fit rounded-sm text-white">Filter</button>

        </form>
        <div class="flex flex-col">
            <div class="overflow-x-auto ">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            <thead class="border-b bg-gray-800">
                                <tr>

                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                        Order
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                        Date
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                        Status
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                        Total
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4">

                                    </th>
                                </tr>
                            </thead>
                            <GlobalTransition>
                            <tbody v-if="orders.length">
                                
                                    <tr v-for="(order, index) in orders" :key="index" class="bg-white border-b">
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{ order.buyer_name }}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{ order.date }}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{ order.status }}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            ${{ order.cart_total }}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            <div class="flex gap-1">
                                                <button type="button" @click="confirmDelete(order.id)"
                                                    class="px-3 py-1 bg-red-500 block w-fit rounded-sm text-white">Delete</button>
                                                <button type="button"
                                                    @click="$router.push('/admin/order/' + order.id)"
                                                    class="px-3 py-1 bg-green-500 block w-fit rounded-sm text-white">Edit</button>
                                            </div>
                                        </td>
                                    </tr>
                                


                            </tbody>
                        </GlobalTransition>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <DialogsWrapper />
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue'
import { createToaster } from "@meforma/vue-toaster"
import { createConfirmDialog } from 'vuejs-confirm-dialog'

import helpers from '../../compositions/helpers'
import ConfirmDialog from '../../components/ConfirmDialog.vue'
import GlobalTransition from '../../Transitions/GlobalTransition.vue'
import SelectCategories from '../../components/SelectCategories.vue'

const toaster = createToaster({ position: "top" });
const dialog = createConfirmDialog(ConfirmDialog, { msg: 'Do you wnat to remove this item?' })
const orders = ref([])
const categories = ref([])
const filter = reactive({ search: '', type: '', status: '', category: '' })
let filterCategory = ref('')


onMounted(() => {
    populateOrders();
    //populateCategories();
})

const resetFilter = () => {
    filter.search = '';
    filter.type = '';
    filter.status = '';
    filter.category = '';
    filterCategory.value = ''
    populateProducts()
}

const populateCategories = async () => {
    axios.get('/api/admin/category')
        .then(response => {
            if (response.data.success) {
                console.log(response.data.data);
                categories.value = response.data.data
            } else {
                toaster.error(`Error Getting categories`);
            }
        })
        .catch(function (error) {
            toaster.error(error);
        });
}

const populateOrders = async () => {
    console.log(filter)
    axios.get('/api/admin/order', { params: filter })
        .then(res => {
            if (res.data.success) {
                console.log(res.data.data);
                orders.value = res.data.data
            } else {
                toaster.error(`Error Getting orders`);
            }
        })
        .catch(function (error) {
            console.log(error.response);
            toaster.error(helpers.makeTextErrors(error))
        });
}

const confirmDelete = async (id) => {
    const { data, isCanceled } = await dialog.reveal()
    if (isCanceled) return
    deleteProduct(id)
}

const deleteProduct = (id) => {
    axios.delete('/api/admin/product/' + id)
        .then(response => {
            if (response.data.success) {
                products.value = response.data.data
                toaster.success(`Product deleted`);
            } else {
                toaster.error(`Error`);
            }
        })
        .catch(function (error) {
            toaster.error(error);
        });
}
</script>

<style scoped></style>



