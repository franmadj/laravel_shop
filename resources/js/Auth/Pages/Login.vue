<template>
    <div class="conteiner relative">
        
        <div class="flex items-center justify-center h-screen max-w-xs mx-auto">
            <div class="p-3 border rounded-md border-gray-200 shadow-md w-full">

                <div class="text-center text-xl">Login</div>

                <form class="mt-5">
                    <div class="mb-4">
                        <label for="email">Email:</label>
                        <input type="email" id="email" class="p-2 border rounded-sm shadow-sm block w-full"
                            v-model="email" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label for="password">Password:</label>
                        <input type="password" id="password" class="p-2 border rounded-sm shadow-sm block w-full"
                            v-model="password" required>
                    </div>


                    <button class="px-2 py-3 mb-5 mt-2 bg-blue-700 block w-full rounded-sm text-white" type="submit"
                        @click="handleSubmit">Login</button>

                    <router-link class="mt-1 block text-blue-600 hover:underline mb-2" to="/register">Register</router-link>
                    <router-link class="mt-0 block text-blue-600 hover:underline" to="/forgot-password">Forgot Password</router-link>
                </form>

            </div>

        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { createToaster } from "@meforma/vue-toaster"
import { useRouter } from 'vue-router';
import helpers from '../../compositions/helpers'
import { useStore } from 'vuex'

let email = ref("")
let password = ref("")

const router = useRouter()
const toaster = createToaster({ position: "top" });
const store = useStore()



const handleSubmit = (e) => {
    e.preventDefault()
    if (password.value.length > 0) {
        //axios.get('/sanctum/csrf-cookie').then(response => {
            axios.post('/api/login', {
                email: email.value,
                password: password.value
            })
                .then(response => {
                    console.log(response.data)
                    if (response.data.success) {
                        //this.$router.go('/admin')
                        store.dispatch('auth/login')
                        
                        //window.location.href = "/admin"
                        //router.push('/admin')
                    } else {
                      
                        toaster.error(response.data.message);
                    }
                })
                .catch(function (error) {
                    console.error(error);
                    toaster.error(helpers.makeTextErrors(error));
                });
        //})
    }
}
</script>