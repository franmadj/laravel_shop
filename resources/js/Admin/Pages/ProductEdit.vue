<template>
    <GlobalTransition>
        <div v-if="show" class="min-h-screen p-6 grow overflow-hidden">
            <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600">Edit Product</h1>

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
                        <FileUploader v-if="galleryon" @files-updated="galleryUpdated" @any-files-update="anyGalleryUpdate"
                            :filesDefault="galleryDefault" :maxFiles="5" name="gallery" />
                    </div>



                    <!--VARIATIONS-->
                    <div class="mb-4" v-if="product.type == 'variable'">
                        <p class="text-2xl">Variations</p>
                        <Variations :productId="props.id" :variations="product.variations" />
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
                    :class="{ 'bg-blue-700': !saving, 'bg-blue-400': saving }" :disabled="saving"
                        @click="update()">Update
                        Product</button>

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

const show = ref(false);
const toaster = createToaster({ position: "top" });
const dialog = createConfirmDialog(ConfirmDialog)
const product = ref({ type: 'simple', status: 'published', stock_status: 'in_stock', selectedCategories: [] })
let categories = ref([])
let filesDefault = reactive([])
let galleryDefault = reactive([])
const saving = ref(false);

let galleryon=ref(true)



onMounted(() => {
    pFns.populateCategories().then((res) => categories.value = res)
    if (props.id) {
        edit(props.id);
    }
    show.value=true


})

const props = defineProps({
    id: { type: Number, required: false, default: false }
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
    product.value.galleryImages = [...files];
    console.log('galleryUpdated', product.value.galleryImages);
}
const anyFilesUpdate = () => {
    product.value.clearFiles = true;
}
const anyGalleryUpdate = () => {
    product.value.clearGallery = true;
}


const edit = async (id) => {
    await axios.get('/api/admin/product/' + id)
        .then(res => {
            if (res.data.success) {
                let selectedCategories = {};
                res.data.data.categories.map(cat => {
                    selectedCategories[cat.id] = true;
                });

                console.log('DATA EDIT: ', { ...res.data.data, selectedCategories });
                product.value = { ...res.data.data, selectedCategories };

                if (res.data.data.feature_thumb) {
                    filesDefault.push(res.data.data.feature_thumb)
                }

                if (res.data.data.gallery.thumb) {
                    res.data.data.gallery.thumb.forEach((url) => {
                        galleryDefault.push(url)
                    })
                }



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
}

const update = async () => {
    saving.value = true;
    console.log('update')

    console.log('product.value', product.value);

   
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
        for (const [key, value] of Object.entries(product.value.selectedCategories)) {
            if (value)
                formData.append('categories[]', key)
        }
    }

    if (product.value.files && product.value.files.length) {
        product.value.files.forEach((file) => {
            console.log('file.file', file.file);
            formData.append('files[]', file.file)
        })
    } else if (product.value.clearFiles) {
        formData.append('clearFiles', true)
    }

    if (product.value.galleryImages && product.value.galleryImages.length) {
        product.value.galleryImages.forEach((file) => {
            console.log('file.file', file.file);
            formData.append('gallery[]', file.file)
        })
    }else if (product.value.clearGallery) {
        formData.append('clearGallery', true)
    }

    axios.post('/api/admin/product/' + props.id, formData)
        .then(response => {
            if (response.data.success) {
                toaster.success(`Product updated`);
                saving.value = false;
            } else {
                toaster.error(`Error`);
                saving.value = false;
            }
        })
        .catch(function (error) {
            toaster.error(error);
            saving.value = false;
        });


}

</script>
