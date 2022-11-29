<template>
    <div class="grow min-h-screen p-6 overflow-hidden">
        <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600">Products</h1>
        <form class="flex flex-col md:flex-row space-y-4 md:space-y-0">
            <input v-model="filter.search" placeholder="search" type="text"
                class="p-2 border rounded-sm shadow-sm w-full mr-2">
            <select v-model="filter.category" class="p-2 border rounded-sm shadow-sm w-full md:w-fit mr-2">
                <option value="">Category</option>
                <option v-for="category of categories" :key="category.id" :value="category.id">{{ category.name }}
                </option>
            </select>

            <select v-model="filter.type" class="p-2 border rounded-sm shadow-sm w-full md:w-fit mr-2">
                <option value="">Product Type</option>
                <option value="simple">Simple</option>
                <option value="variable">Variable</option>
            </select>

            <select v-model="filter.status" class="p-2 border rounded-sm shadow-sm w-full md:w-fit mr-2">
                <option value="">Status</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
            <button class="px-3 py-1 bg-gray-800 block w-full md:w-fit rounded-sm text-white mr-1" type="button"
                @click="populateProducts">Filter</button>
            <button class="px-3 py-1 bg-gray-800 block w-full md:w-fit rounded-sm text-white" type="button"
                @click="resetFilter">Reset</button>

        </form>
        <div class="flex flex-col">
            <div class="overflow-x-auto ">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            <thead class="border-b bg-gray-800">
                                <tr>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 hidden sm:table-cell">

                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                        Title
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 hidden sm:table-cell">
                                        Price
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 hidden md:table-cell">
                                        Type
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 hidden md:table-cell">
                                        Status
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 hidden md:table-cell">
                                        Categories
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                        Actions

                                    </th>
                                </tr>
                            </thead>
                            <GlobalTransition>
                                <tbody v-if="products.length">
                                    <tr v-for="(product) of products" :key="product.id" class="bg-white border-b">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 hidden sm:table-cell">
                                            <img v-if="product.feature_image" class="rounded-md w-[50px]" :src="product.feature_image">
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{ product.title }}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                            {{ product.price }}$
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                            {{ product.type }}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                            {{ product.status }}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap hidden md:table-cell"
                                            v-html="product.categories_text">

                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            <div class="flex justify-center gap-1">
                                                <button type="button" @click="confirmDelete(product.id)"
                                                    class="px-3 py-1 bg-red-500 block w-fit rounded-sm text-white">Delete</button>
                                                <button type="button"
                                                    @click="$router.push('/admin/product/' + product.id)"
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

const toaster = createToaster({ position: "top" });
const dialog = createConfirmDialog(ConfirmDialog, { msg: 'Do you wnat to remove this item?' })
const products = ref([])
const categories = ref([])
const filter = reactive({ search: '', type: '', status: '', category: '' })


onMounted(() => {
    populateProducts();
    populateCategories();
})

const resetFilter = () => {
    filter.search = '';
    filter.type = '';
    filter.status = '';
    filter.category = '';
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

const populateProducts = async () => {
    axios.get('/api/admin/product', { params: filter })
        .then(res => {
            if (res.data.success) {
                console.log(res.data.data);
                products.value = res.data.data
            } else {
                toaster.error(`Error Getting products`);
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

<style scoped>


</style>


