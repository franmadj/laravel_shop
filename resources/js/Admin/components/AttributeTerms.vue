<template>
    <!-- Modal -->
    <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
        id="genericModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog relative w-auto pointer-events-none">
            <div
                class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">Attribute Terms
                        {{ attribute }}
                    </h5>
                    <button type="button"
                        class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                        data-bs-dismiss="modal" aria-label="Close" @click="resetModal"></button>
                </div>
                <div class="modal-body relative p-4">
                    <div class="grow overflow-hidden min-h-screen p-6">

                        <form class="">
                            <div class="mb-4">

                                <input type="text" class="p-2 border rounded-sm shadow-sm block w-full"
                                    v-model="term.name" placeholder="Term">
                            </div>

                            <button v-if="!editing" type="button"
                                class="px-2 py-1 bg-blue-700 block w-full rounded-sm text-white" @click="store()">Save
                                Term</button>


                            <div v-else class="flex gap-2">
                                <button type="button" @click="update()"
                                    class="px-2 py-1 bg-blue-700 block w-full rounded-sm text-white">Update
                                    Term</button>
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
                                                <tr v-for="(term, index) of terms" :key="index"
                                                    class="bg-white border-b">

                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{ term.name }}
                                                    </td>


                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        <div class="flex justify-center gap-1">
                                                            <button
                                                                class="px-3 py-1 bg-red-500 block w-fit rounded-sm text-white"
                                                                type="button"
                                                                @click="deleteTerm(term.id)">Delete</button>
                                                            <button
                                                                class="px-3 py-1 bg-green-500 block w-fit rounded-sm text-white"
                                                                type="button" @click="edit(term.id)">Edit</button>

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

            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { createToaster } from "@meforma/vue-toaster"
import { createConfirmDialog } from 'vuejs-confirm-dialog'
import ConfirmDialog from '../../components/ConfirmDialog.vue'
const props = defineProps({
    id: { type: Array }
})


onMounted(() => {
    //populateTerms();
    console.log('onMounted', props.id);

})



watch(props.id, (currentValue) => {
    console.log(currentValue[0]);
    //terms.value=currentValue;
    // if(currentValue[0])
    attributeId = currentValue[0];
    populateTerms(attributeId)
});


const toaster = createToaster({ position: "top" });
const dialog = createConfirmDialog(ConfirmDialog)
const term = ref([])
let terms = ref([])
let editing = ref(false)
let attributeId = 0;

const resetModal = () => {
    resetForm();
    terms.value = [];

}

const populateTerms = async (id) => {
    axios.get('/api/admin/attribute-item/' + id)
        .then(response => {
            if (response.data.success) {
                terms.value = response.data.data
            } else {
                toaster.error(`Error`);
            }
        })
        .catch(function (error) {
            toaster.error(error);
        });
}

const store = async () => {
    if (term.value.name) {
        axios.post('/api/admin/attribute-item', { name: term.value.name, attribute_id: attributeId })
            .then(response => {
                if (response.data.success) {
                    populateTerms(attributeId)
                    resetForm();
                    toaster.success(`Term saved`);
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
    axios.get('/api/admin/attribute-item/edit/' + id)
        .then(response => {
            if (response.data.success) {
                term.value = response.data.data
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
    term.value = [];
    editing.value = false;
}

const update = async () => {
    if (term.value.name) {
        axios.post('/api/admin/attribute-item/' + editing.value, { name: term.value.name, _method: 'PUT' })
            .then(response => {
                if (response.data.success) {
                    populateTerms(attributeId)
                    resetForm();
                    toaster.success(`Term updated`);
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
    deleteTerm(id)
}
const deleteTerm = (id) => {
    axios.delete('/api/admin/attribute-item/' + id)
        .then(response => {
            if (response.data.success) {
                populateTerms(attributeId)
                toaster.success(`Term deleted`);
            } else {
                toaster.error(`Error`);
            }
        })
        .catch(function (error) {
            toaster.error(error);
        });
}
</script>



