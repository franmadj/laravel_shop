<template>
    <div class="min-h-screen p-6 grow overflow-hidden">
            <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600"><span v-if="editing">Edit</span><span
                    v-else>Add</span> Product</h1>

            <form class="flex flex-col lg:flex-row gap-5">

                <!--LEFT SIDE-->
                <div class="w-full lg:w-4/5">
                    <div class="mb-4">
                        <label for="content">Poduct type</label>
                        <select v-model="product.type" class="p-2 border rounded-sm shadow-sm block w-full">
                            <option value="simple">Simple</option>
                            <option value="variable">Variable</option>
                        </select>

                    </div>
                    <div class="mb-4">
                        <label for="content">Title</label>
                        <input v-model="product.title" @blur="slugify" type="text"
                            class="p-2 border rounded-sm shadow-sm block w-full" placeholder="Title">
                    </div>

                    <div class="mb-4">
                        <label for="content">Slug</label>
                        <input v-model="product.slug" type="text" class="p-2 border rounded-sm shadow-sm block w-full"
                            placeholder="Slug">
                    </div>

                    <div class="mb-4">
                        <label for="content">Content</label>
                        <textarea v-model="product.content"
                            class="min-h-2 p-2 border rounded-sm shadow-sm block w-full"></textarea>
                    </div>

                    <div class="mb-4 flex justify-between gap-2">
                        <div class="grow">
                            <label>Price:</label>
                            <input v-model="product.price" type="text"
                                class="p-2 border rounded-sm shadow-sm block w-full">
                        </div>
                        <div class="grow">
                            <label>Sale Price:</label>
                            <input v-model="product.sale_price" type="text"
                                class="p-2 border rounded-sm shadow-sm block w-full">
                        </div>
                    </div>
                    <div class="mb-4 flex justify-between gap-2">
                        <div class="grow w-2/5">
                            <label>Stock status:</label>
                            <select v-model="product.stock_status" class="p-2 border rounded-sm shadow-sm block w-full">
                                <option value="in_stock">In stock</option>
                                <option value="out_stock">Out of stock</option>
                            </select>
                        </div>
                        <div class="grow w-2/5">
                            <label>Stock quantity:</label>
                            <input v-model="product.stock_quantity" type="number"
                                class="p-2 border rounded-sm shadow-sm block w-full">
                        </div>
                    </div>

                    <!--ATTRIBUTES

                <div class="mb-4">
                    <p class="text-2xl">Attributes</p>
                    <div class="border border-gray-400 rounded-sm p-2 mt-2">
                        <div class="flex justify-between gap-2 mb-2">
                            <div class="grow w-2/5">
                                <label>Name:</label>
                                <input type="text" class="p-2 border rounded-sm shadow-sm block w-full">
                            </div>
                            <div class="grow w-2/5">
                                <label>Items:</label>
                                <textarea class="h-11 p-2 border rounded-sm shadow-sm block w-full" placeholder="Enter some text, or some attributes by  |  separating values"></textarea>
                            </div>
                        </div>
                        <button class="px-2 py-1 bg-blue-700 block w-full rounded-sm text-white">Save Atttributes</button>
                        <div class="border border-gray-400 rounded-sm p-2 mt-2">

                            <div class="flex justify-between items-center rounded-sm">
                                <span>Color</span>
                                <div class="flex gap-1">
                                    <a href="#" class="mr-2 hover:text-blue-400">Remove</a>
                                    <a href="#">Edit</a>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>
                -->

                    <!--VARIATIONS-->
                    <div class="mb-4" v-if="product.type == 'variable'">
                        <p class="text-2xl">Variations</p>

                        <div v-if="!editing" class="border border-gray-400 rounded-sm p-2 mt-2">
                            <button type="button" class="px-2 py-1 bg-gray-800 block w-full rounded-sm text-white"
                                @click="store">Save product before add variations</button>
                        </div>

                        <Variations :productId="props.id" :variations="product.variations" v-else />



                    </div>

                </div>
                <!--RIGHT SIDE -->
                <div class="w-full lg:w-1/5">

                    <div class="mb-4">
                        <label>Status:</label>
                        <select v-model="product.status" class="p-2 border rounded-sm shadow-sm block w-full">
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <p class="text-2xl">Categories</p>
                        <div class="border border-gray-400 rounded-sm p-2 mt-2">
                            <ul class="">
                                <li v-for="category of categories" :key="category.id" class="flex items-center gap-1">
                                    <input :id="'category_' + category.id" type="checkbox"
                                        v-model="product.selectedCategories[category.id]" :value="category.id">
                                    <label :for="'category_' + category.id">{{ category.name }}</label>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-2xl">Image</p>
                        <FileUploader @files-updated="filesUpdated" @any-files-update="anyFilesUpdate"
                            :filesDefault="filesDefault" />
                    </div>

                    <button v-if="!editing" class="px-2 py-1 bg-blue-700 block w-full rounded-sm text-white"
                        type="button" @click="store()">Save
                        Product</button>
                    <button v-else class="px-2 py-1 bg-blue-700 block w-full rounded-sm text-white" type="button"
                        @click="update()">Update
                        Product</button>

                </div>

            </form>
        </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { createToaster } from "@meforma/vue-toaster"
import { createConfirmDialog } from 'vuejs-confirm-dialog'

import Variations from '../components/Variations.vue'
import helpers from '../../compositions/helpers'
import ConfirmDialog from '../../components/ConfirmDialog.vue'
import FileUploader from '../components/FileUploader.vue'
import { useRoute } from "vue-router";


onMounted(() => {
    populateCategories();
    if (props.id) {
        editing.value = props.id;
        console.log(props.id);
        edit(props.id);

    }

})

const props = defineProps({
    id: { type: Number, required: false, default: false }
})

const slugify = () => {
    if (product.value.title && !product.value.slug) {
        product.value.slug = helpers.slugify(product.value.title)
    }
}

const filesUpdated = (file) => {
    product.value.file = file[0];
    console.log('filesUpdated', product.value.file);
}
const anyFilesUpdate = () => {
    product.value.clearFiles = true;
}

const route = useRoute()
const toaster = createToaster({ position: "top" });
const dialog = createConfirmDialog(ConfirmDialog)
const product = ref({ type: 'simple', status: 'published', stock_status: 'in_stock', selectedCategories: [] })

let categories = ref([])
let editing = ref(false)
let id = ref([]);
let filesDefault = ref([])



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

const store = async () => {

    let formData = new FormData()
    formData.append('title', product.value.title)
    formData.append('type', product.value.type)
    formData.append('price', product.value.price)
    formData.append('slug', product.value.slug)
    formData.append('stock_status', product.value.stock_status)
    formData.append('status', product.value.status)

    if (product.value.content)
        formData.append('content', product.value.content)
    if (product.value.sale_price)
        formData.append('sale_price', product.value.sale_price)
    if (product.value.stock_quantity)
        formData.append('stock_quantity', product.value.stock_quantity)
    if (product.value.selectedCategories) {

        console.log(product.value.selectedCategories);


        product.value.selectedCategories.forEach((selCat, i) => {
            if (selCat)
                formData.append('categories[]', i)
        })

    }
    if (product.value.file)
        formData.append('file', product.value.file)




    axios.post('/api/admin/product', formData)
        .then(response => {
            if (response.data.success) {

                resetForm();
                toaster.success(`Product saved`);
            } else {
                toaster.error(`Error`);
            }
        })
        .catch(function (error) {
            console.log(error.response);
            // let message = error;
            // if ("The given data was invalid." == error.response.data.message) {
            //     message = '';
            //     for (const [key, value] of Object.entries(error.response.data.errors)) {
            //         console.log(`${key}: ${value}`);
            //         message += `<p>${value}</p>`
            //     }


            // }
            toaster.error(helpers.makeTextErrors(error));
        });


}

const edit = (id) => {
    axios.get('/api/admin/product/' + id)
        .then(res => {
            if (res.data.success) {
                let selectedCategories = {};
                res.data.data.categories.map(cat => {
                    selectedCategories[cat.id] = true;
                });

                console.log({ ...res.data.data, selectedCategories });
                product.value = { ...res.data.data, selectedCategories };

                if (res.data.data.image)
                    helpers.getFileFromUrl(res.data.data.image, 'name.png').then(file => {
                        filesDefault.value.push(file)
                    })


            } else {
                toaster.error(`Error`);
            }
        })
        .catch(function (error) {
            toaster.error(error);
        });
}

const resetForm = async () => {
    product.value = { type: 'simple', status: 'published', stock_status: 'in_stock', selectedCategories: [] };
    editing.value = false;
}

const update = async () => {

    console.log(product.value);

    let formData = new FormData()
    formData.append('title', product.value.title)
    formData.append('type', product.value.type)
    formData.append('price', product.value.price)
    formData.append('slug', product.value.slug)
    formData.append('stock_status', product.value.stock_status)
    formData.append('status', product.value.status)
    formData.append('_method', 'PUT')

    if (product.value.content)
        formData.append('content', product.value.content)
    if (product.value.sale_price)
        formData.append('sale_price', product.value.sale_price)
    if (product.value.stock_quantity)
        formData.append('stock_quantity', product.value.stock_quantity)
    if (product.value.selectedCategories) {

        console.log(product.value.selectedCategories);

        for (const [key, value] of Object.entries(product.value.selectedCategories)) {
            if (value)
                formData.append('categories[]', key)
        }
    }
    if (product.value.file) {
        formData.append('file', product.value.file)
    } else if (product.value.clearFiles) {
        formData.append('clearFiles', true)
    }



    axios.post('/api/admin/product/' + editing.value, formData)
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
