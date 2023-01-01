<template>
    <div class="grow min-h-screen p-6 overflow-hidden">
        <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600">Users</h1>
        <form class="flex flex-col md:flex-row space-y-4 md:space-y-0">
            <input v-model="filter.search" placeholder="search" type="text"
                class="p-2 border rounded-sm shadow-sm w-full mr-2">
            <select v-model="filter.role" class="p-2 border rounded-sm shadow-sm w-full md:w-fit mr-2">
                <option value="">Role</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>

            
            <button class="px-3 py-1 bg-gray-800 block w-full md:w-fit rounded-sm text-white mr-1" type="button"
                @click="populateUsers">Filter</button>
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

                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                        Name
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                        Email
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                        Role
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                        Active
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4">

                                    </th>
                                </tr>
                            </thead>
                            <GlobalTransition>
                                <tbody>
                                    <tr v-for="user of users" :key="user.id" class="bg-white border-b">
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{user.name}}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{user.email}}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{user.roles}}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{ user.active ? 'Yes' : 'No' }}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            <div class="flex justify-center gap-1">
                                                <button type="button" @click="confirmDelete(user.id)"
                                                    class="px-3 py-1 bg-red-500 block w-fit rounded-sm text-white">Delete</button>
                                                <button type="button"
                                                    @click="$router.push('/admin/user/' + user.id)"
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
const users = ref([])
const filter = reactive({ search: '', role: '' })


onMounted(() => {
    populateUsers();
})

const resetFilter = () => {
    filter.search = '';
    filter.role = '';

}


const populateUsers = async () => {
    axios.get('/api/admin/user', { params: filter })
        .then(res => {
            if (res.data.success) {
                console.log(res.data.data);
                users.value = res.data.data
            } else {
                toaster.error(`Error Getting users`);
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
    deleteUser(id)
}

const deleteUser = (id) => {
    axios.delete('/api/admin/user/' + id)
        .then(response => {
            if (response.data.success) {
                users.value = response.data.data
                toaster.success(`User deleted`);
            } else {
                toaster.error(`Error`);
            }
        })
        .catch(function (error) {
            toaster.error(error);
        });
}
</script>



