<template>
    <GlobalTransition>
        <div class="grow overflow-hidden min-h-screen p-6">
            <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600">Edit Account</h1>
            <form class="">

                <div class="mb-4">
                    <label>Name:</label>
                    <input type="text" v-model="user.name" class="p-2 border rounded-sm shadow-sm block w-full">
                </div>
                <div class="mb-4">
                    <label>Email:</label>
                    <input type="email" v-model="user.email" class="p-2 border rounded-sm shadow-sm block w-full">
                </div>

                <div class="mb-4">
                    <label>Password:</label>
                    <input type="password" v-model="user.password" class="p-2 border rounded-sm shadow-sm block w-full">
                </div>
                <div class="mb-4">
                    <label>Confirm Password:</label>
                    <input type="password" v-model="user.password_confirmation"
                        class="p-2 border rounded-sm shadow-sm block w-full">
                </div>

                <div class="mb-4">
                    <label>Phone:</label>
                    <input type="tel" v-model="user.phone" class="p-2 border rounded-sm shadow-sm block w-full">
                </div>

                <div class="mb-4">
                    <label>Bio:</label>
                    <textarea v-model="user.bio" class="min-h-2 p-2 border rounded-sm shadow-sm block w-full"></textarea>
                </div>


                <div class="mb-4">

                    <FileUploader @files-updated="filesUpdated" @any-files-update="anyFilesUpdate"
                        :filesDefault="filesDefault" :maxFiles="1" name="featureImage" />
                </div>
                <button class="px-2 py-1 bg-blue-700 block w-full rounded-sm text-white" type="button"
                    @click.prevent="update">Update Account</button>
            </form>
        </div>
    </GlobalTransition>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue'
import { createToaster } from "@meforma/vue-toaster"

import helpers from '../../compositions/helpers'
import FileUploader from '../components/FileUploader.vue'
import GlobalTransition from '../../Transitions/GlobalTransition.vue'

const show = ref(false);
const toaster = createToaster({ position: "top" });
const user = ref({})

let filesDefault = reactive([])
let photo = ref(false);



onMounted(() => {
    editAccount()
})

const props = defineProps({
    id: { type: Number, required: false, default: false }
})

const filesUpdated = (files) => {
    console.log(files);
    photo.value = files[0];
    console.log('filesUpdated', photo.value);
}

const anyFilesUpdate = () => {
    user.value.clearFiles = true;
}

const editAccount = async (id) => {
    await axios.get('/api/admin/account')
        .then(res => {
            if (res.data.success) {
                user.value = res.data.data;
                if (res.data.data.photo)
                    filesDefault.push(res.data.data.photo)


            } else
                toaster.error(`Error`);

        })
        .catch(function (error) {
            toaster.error(helpers.makeTextErrors(error));
        });
}

const resetForm = async () => {
    user.value = { type: 'simple', status: 'published', stock_status: 'in_stock', selectedCategories: [] };
}

const update = async () => {
    console.log('update')

    console.log('user.value', user.value);


    let formData = new FormData()
    formData.append('role', user.value.role)
    formData.append('name', user.value.name)
    formData.append('email', user.value.email)

    const phone = user.value.phone
    if (phone)
        formData.append('phone', phone)

    const bio = user.value.bio
    if (bio)
        formData.append('bio', bio)

    const password = user.value.password
    if (password)
        formData.append('password', password)

    const password_confirmation = user.value.password_confirmation
    if (password_confirmation)
        formData.append('password_confirmation', password_confirmation)

    formData.append('_method', 'PUT')



    if (photo.value) {
        formData.append('photo', photo.value.file)

    } else if (user.value.clearFiles) {
        formData.append('clearFiles', true)
    }

    axios.post('/api/admin/account/' + user.value.id, formData)
        .then(response => {
            if (response.data.success) {
                toaster.success(`User updated`);
            } else {
                toaster.error(`Error`);
            }
        })
        .catch(function (error) {
            toaster.error(helpers.makeTextErrors(error));
        });


}

</script>
