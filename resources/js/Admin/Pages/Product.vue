<template>
    <GlobalTransition>
        <div v-if="show" class="min-h-screen p-6 grow overflow-hidden">
            <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600">Add Product</h1>

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

                    <div class="mb-4 block lg:flex justify-between gap-2">
                        <div class="grow">
                            <label>Price:</label>
                            <input v-model="product.price" type="text"
                                class="p-2 border rounded-sm shadow-sm block w-full">
                        </div>
                        <div class="grow mt-3 lg:mt-0">
                            <label>Sale Price:</label>
                            <input v-model="product.sale_price" type="text"
                                class="p-2 border rounded-sm shadow-sm block w-full">
                        </div>
                    </div>
                    <div class="mb-4 block lg:flex justify-between gap-2">
                        <div class="grow w-full lg:w-2/5">
                            <label>Stock status:</label>
                            <select v-model="product.stock_status" class="p-2 border rounded-sm shadow-sm block w-full">
                                <option value="in_stock">In stock</option>
                                <option value="out_stock">Out of stock</option>
                            </select>
                        </div>
                        <div class="grow w-full lg:w-2/5 mt-3 lg:mt-0">
                            <label>Stock quantity:</label>
                            <input v-model="product.stock_quantity" type="number"
                                class="p-2 border rounded-sm shadow-sm block w-full">
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-2xl">Gallery</p>
                        <FileUploader @files-updated="galleryUpdated" @any-files-update="anyGalleryUpdate"
                            :filesDefault="galleryDefault" :maxFiles="5" name="gallery" />
                    </div>



                    <!--VARIATIONS-->
                    <div class="mb-4" v-if="product.type == 'variable'">
                        <p class="text-2xl">Variations</p>
                        <div class="border border-gray-400 rounded-sm p-2 mt-2">
                            <button type="button" class="px-2 py-1 bg-red-800 block w-full rounded-sm text-white">Save
                                product before add variations</button>
                        </div>
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
                            :filesDefault="filesDefault" :maxFiles="1" name="featureImage" />
                    </div>

                    <button class="px-2 py-1 block w-full rounded-sm text-white" type="button"
                        :class="{ 'bg-blue-700': !saving, 'bg-blue-400': saving }" :disabled="saving" @click="store()">Save
                        Product</button>
                </div>
            </form>
        </div>
    </GlobalTransition>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue'
import { useRouter } from 'vue-router';
import { createToaster } from "@meforma/vue-toaster"

import helpers from '../../compositions/helpers'
import pFns from '../composables/products'
import FileUploader from '../components/FileUploader.vue'
import GlobalTransition from '../../Transitions/GlobalTransition.vue'

const show = ref(false);
const toaster = createToaster({ position: "top" });
const product = ref({ type: 'simple', status: 'published', stock_status: 'in_stock', selectedCategories: [] })

let categories = ref([])
const router = useRouter()
const saving = ref(false);


onMounted(() => {
    show.value = true
    pFns.populateCategories().then((res) => categories.value = res)
})


const slugify = () => {
    if (product.value.title && !product.value.slug) {
        product.value.slug = helpers.slugify(product.value.title)
    }
}

const filesUpdated = (files) => {
    console.log(files);
    product.value.files = [...files];
    console.log('filesUpdated', product.value.files);
}
const galleryUpdated = (files) => {
    console.log(files);
    product.value.gallery = [...files];
    console.log('galleryUpdated', product.value.gallery);
}



// const populateCategories = async () => {
//     axios.get('/api/admin/category')
//         .then(response => {
//             if (response.data.success) {
//                 categories.value = response.data.data
//             } else {
//                 toaster.error(`Error Getting categories`);
//             }
//         })
//         .catch(function (error) {
//             toaster.error(error);
//         });
// }

const store = async () => {
    saving.value = true;

    console.log('product.value', product.value);

    let formData = new FormData()

    formData.append('stock_status', product.value.stock_status)
    formData.append('status', product.value.status)
    formData.append('type', product.value.type)

    if (product.value.title)
        formData.append('title', product.value.title)
    if (product.value.price)
        formData.append('price', product.value.price)
    if (product.value.slug)
        formData.append('slug', product.value.slug)
    if (product.value.content)
        formData.append('content', product.value.content)
    if (product.value.sale_price)
        formData.append('sale_price', product.value.sale_price)
    if (product.value.stock_quantity)
        formData.append('stock_quantity', product.value.stock_quantity)
    if (product.value.selectedCategories) {
        product.value.selectedCategories.forEach((selCat, i) => {
            if (selCat)
                formData.append('categories[]', i)
        })
    }
    if (product.value.files && product.value.files.length) {
        product.value.files.forEach((file) => {
            console.log('file.value', file.file);
            formData.append('files[]', file.file)
        })
    }
    if (product.value.gallery && product.value.gallery.length) {
        product.value.gallery.forEach((file) => {
            console.log('file.value', file.file);
            formData.append('gallery[]', file.file)
        })
    }
    console.log(formData);
    axios.post('/api/admin/product', formData)
        .then(response => {
            if (response.data.success) {
                toaster.success(`Product saved`);
                router.push('/admin/product/' + response.data.data.id)
            } else {
                toaster.error(`Error`);
                saving.value = false;
            }
        })
        .catch(function (error) {
            console.log(error)
            toaster.error(helpers.makeTextErrors(error));
            saving.value = false;
        });
}



</script>
