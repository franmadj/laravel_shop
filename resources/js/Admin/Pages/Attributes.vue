


<template>
    <Header />

    <div class="flex">
        <SidebarMenu />
        <div class="grow overflow-hidden min-h-screen p-6">
            <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600">Attributes</h1>
            <form class="">
                <div class="mb-4">
                    <label>Name:</label>
                    <input type="text" v-model="attr.name" class="p-2 border rounded-sm shadow-sm block w-full">
                </div>

                <button v-if="!editing" class="px-2 py-1 bg-blue-700 block w-full rounded-sm text-white"
                    @click="store()" type="button">Save Attribute</button>
                <div v-else class="flex gap-2">
                    <button type="button" @click="update()"
                        class="px-2 py-1 bg-blue-700 block w-full rounded-sm text-white">Update Attribute</button>
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
                                            Name
                                        </th>

                                        <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                            Actions

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="attribute of attributes" :key="attribute.id" class="bg-white border-b">

                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{ attribute.name }}
                                        </td>


                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            <div class="flex justify-center gap-1">
                                                <button class="px-3 py-1 bg-red-500 block w-fit rounded-sm text-white"
                                                    @click="confirmDelete(attribute.id)" type="button">Delete</button>
                                                <button class="px-3 py-1 bg-green-500 block w-fit rounded-sm text-white"
                                                    @click="edit(attribute.id)" type="button">Edit</button>
                                                <button class="px-3 py-1 bg-blue-500 block w-fit rounded-sm text-white"
                                                    data-bs-toggle="modal" data-bs-target="#genericModal"
                                                    @click="configureTerms(attribute.id)">Configure
                                                    terms</button>
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

        <AttributeTerms :id="id"></AttributeTerms>
    </div>
    <DialogsWrapper />
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { createToaster } from "@meforma/vue-toaster"
import { createConfirmDialog } from 'vuejs-confirm-dialog'

import Header from '../components/Header.vue'
import SidebarMenu from '../components/sidebarMenu.vue'
import AttributeTerms from '../components/AttributeTerms.vue'
import helpers from '../../compositions/helpers'
import ConfirmDialog from '../../components/ConfirmDialog.vue'


onMounted(() => {
    populateAttributes();
    //setTimeout(()=>{ id.value.push(10);console.log(id.value) },2000);
})


const toaster = createToaster({ position: "top" });
const dialog = createConfirmDialog(ConfirmDialog)
const attr = ref([])
let attributes = ref([])
let editing = ref(false)
let id = ref([]);

const configureTerms = (attrId) => {
    console.log(attrId);
    id.value.splice(0,1)
    id.value.push(attrId)
}

const populateAttributes = async () => {
    axios.get('/api/admin/attribute')
        .then(response => {
            if (response.data.success) {
                attributes.value = response.data.data
            } else {

            }
        })
        .catch(function (error) {
            toaster.error(error);
        });
}

const store = async () => {
    if (attr.value.name) {
        axios.post('/api/admin/attribute', { name: attr.value.name })
            .then(response => {
                if (response.data.success) {
                    attributes.value = response.data.data
                    resetForm();
                    toaster.success(`Attribute saved`);
                } else {
                    toaster.error(`Error`);
                }
            })
            .catch(function (error) {
                toaster.error(error);
            });

    } else {
        toaster.error(`Error, Name is required`);

    }
}

const edit = (id) => {
    axios.get('/api/admin/attribute/' + id)
        .then(response => {
            if (response.data.success) {
                attr.value = response.data.data
                editing.value = response.data.data.id
            } else {
                toaster.error(`Error`);
            }
        })
        .catch(function (error) {
            toaster.error(error);
        });
}

const resetForm = async () => {
    attr.value = [];
    editing.value = false;
}

const update = async () => {
    if (attr.value.name) {
        axios.post('/api/admin/attribute/' + editing.value, { name: attr.value.name, _method: 'PUT' })
            .then(response => {
                if (response.data.success) {
                    attributes.value = response.data.data
                    resetForm();
                    toaster.success(`Attribute updated`);
                } else {
                    toaster.error(`Error`);
                }
            })
            .catch(function (error) {
                toaster.error(error);
            });

    } else {
        toaster.error(`Error, Name is required`);

    }
}



const confirmDelete = async (id) => {
    const { data, isCanceled } = await dialog.reveal()
    if (isCanceled) return
    deleteAttr(id)
}
const deleteAttr = (id) => {
    axios.delete('/api/admin/attribute/' + id)
        .then(response => {
            if (response.data.success) {
                attributes.value = response.data.data
                toaster.success(`Attribute deleted`);
            } else {
                toaster.error(`Error`);
            }
        })
        .catch(function (error) {
            toaster.error(error);
        });
}
</script>



