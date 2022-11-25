<template>
    <Header />
    <div class="flex">
        <SidebarMenu />
        <div class="grow overflow-hidden min-h-screen p-6">
            <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600">Categories</h1>
            <form class="">
                <div class="mb-4">
                    <label>Name</label>
                    <input v-model="category.name" @blur="slugify()" type="text"
                        class="p-2 border rounded-sm shadow-sm block w-full">
                </div>
                <div class="mb-4">
                    <label>Slug</label>
                    <input v-model="category.slug" type="text" class="p-2 border rounded-sm shadow-sm block w-full">
                </div>

                <div class="mb-4">
                    <label>Description</label>
                    <textarea v-model="category.description"
                        class="min-h-2 p-2 border rounded-sm shadow-sm block w-full"></textarea>
                </div>

                <div class="mb-4">
                    <FileUploader @files-updated="filesUpdated" @any-files-update="anyFilesUpdate" :filesDefault="filesDefault" />   
                </div>
                <button v-if="!editing" type="button" @click="store()"
                    class="px-2 py-1 bg-blue-700 block w-full rounded-sm text-white">Save Category</button>
                <div v-else class="flex gap-2">
                    <button type="button" @click="updateCategory()"
                        class="px-2 py-1 bg-blue-700 block w-full rounded-sm text-white">Update Category</button>
                    <button type="button" @click="resetForm()"
                        class="px-2 py-1 bg-blue-700 block w-full rounded-sm text-white">Cancel</button>
                </div>

            </form>
            <div class="flex flex-col mt-4">
                <div class="overflow-x-auto">
                    <div class="py-4 inline-block min-w-full">
                        <div class="overflow-hidden">
                            <table class="min-w-full text-center">
                                <thead class="border-b bg-gray-800">
                                    <tr>
                                        <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                            Name
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                            Slug
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                            Description
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-white px-6 py-4">

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="cat of categories" :key="cat.id" class="bg-white border-b">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">

                                            <img v-if="cat.image" class="rounded-md w-8 max-w-full" :src="cat.image">
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{ cat.name }}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{ cat.slug }}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{ cat.description }}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            <div class="flex gap-1">
                                                <button class="px-3 py-1 bg-red-500 block w-fit rounded-sm text-white"
                                                    @click="confirmDelete(cat.id)" type="button">Delete</button>
                                                <button class="px-3 py-1 bg-green-500 block w-fit rounded-sm text-white"
                                                    @click="editCategory(cat.id)" type="button">Edit</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <DialogsWrapper />
</template>




<script setup>

import { ref, onMounted } from 'vue'
import { createToaster } from "@meforma/vue-toaster"
import { createConfirmDialog } from 'vuejs-confirm-dialog'

import Header from '../components/Header.vue'
import SidebarMenu from '../components/sidebarMenu.vue'
import helpers from '../../compositions/helpers'
import FileUploader from '../components/FileUploader.vue'
import ConfirmDialog from '../../components/ConfirmDialog.vue'


onMounted(() => {
    populateCategories();
})


const filesUpdated = (file) => {
    category.value.file = file[0];
    console.log('filesUpdated',category.value.file);
}
const anyFilesUpdate = () => {
    category.value.clearFiles=true;
}


const toaster = createToaster({ position: "top" });
const dialog = createConfirmDialog(ConfirmDialog)
const category = ref([])
let categories = ref([])
let filesDefault = ref([])
let editing = ref(false)

const populateCategories = async () => {
    axios.get('/api/admin/category')
        .then(response => {
            //console.log(response)
            if (response.data.success) {
                categories.value = response.data.data

                //console.log(categories);


            } else {

            }
        })
        .catch(function (error) {
            console.error(error);
        });
}

const store = async () => {
    if (category.value.name) {
        let formData = new FormData()
        formData.append('name', category.value.name)
        formData.append('slug', category.value.slug)
        formData.append('description', category.value.description)
        if (category.value.file) {
            formData.append('file', category.value.file)
        }
        axios.post('/api/admin/category', formData)
            .then(response => {
                if (response.data.success) {
                    categories.value = response.data.data
                    resetForm();

                } else {

                }
            })
            .catch(function (error) {
                console.error(error);
            });

    } else {
        toaster.error(`Error, Name is required`);

    }
}

const editCategory = (id) => {
    axios.get('/api/admin/category/' + id)
        .then(response => {
            //console.log(response)
            if (response.data.success) {
                category.value = response.data.data
                editing.value = response.data.data.id
                filesDefault.value.length = 0;
                if (response.data.data.image) {
                    //addFilesEdit(response.data.data.image)
                    //console.log(filesEdit.value);
                    const file = helpers.getFileFromUrl(response.data.data.image, 'name.png').then(file => {
                        filesDefault.value.push(file)
                    })


                }
                console.log(filesDefault.value);
            } else {

            }
        })
        .catch(function (error) {
            console.error(error);
        });
}

const resetForm = async () => {
    category.value = [];
    filesDefault.value.length = 0;
    editing.value = false;
}

const updateCategory = async () => {
    //console.log(files.value[0]);
    if (category.value.name) {
        // set up the request data
        let formData = new FormData()
        formData.append('name', category.value.name)
        formData.append('slug', category.value.slug)
        formData.append('description', category.value.description)
        formData.append('_method', 'PUT')

        if (category.value.file) {
            formData.append('file', category.value.file)
        }else if (category.value.clearFiles) {
            formData.append('clearFiles', true)
        }
        axios.post('/api/admin/category/' + editing.value, formData)
            .then(response => {
                //console.log(response.data)
                if (response.data.success) {
                    categories.value = response.data.data
                    console.log(categories.value);
                    resetForm();

                } else {

                }
            })
            .catch(function (error) {
                console.error(error);
            });

    } else {
        toaster.error(`Error, Name is required`);

    }
}

const slugify = () => {
    if (category.value.name && !category.value.slug) {
        category.value.slug = helpers.slugify(category.value.name)
    }
}

const confirmDelete = async (id) => {
  const { data, isCanceled } = await dialog.reveal()
  if(isCanceled) return
  deleteCategory(id)
}
const deleteCategory = (id) => {
    axios.delete('/api/admin/category/' + id)
        .then(response => {
            //console.log(response)
            if (response.data.success) {
                categories.value = response.data.data
                //console.log(categories);
            } else {

            }
        })
        .catch(function (error) {
            console.error(error);
        });
}


</script>


