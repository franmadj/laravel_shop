<template>
    <div class="conteiner relative">
        
        <div v-if="!formSent" class="flex items-center justify-center h-screen max-w-xs mx-auto">
            <div class="p-3 border rounded-md border-gray-200 shadow-md w-full">

                <div class="text-center text-xl">Forgot password</div>

                <form class="mt-5">
                    <div class="mb-4">
                        <label for="email">Email:</label>
                        <input type="email" id="email" class="p-2 border rounded-sm shadow-sm block w-full"
                            v-model="email" required autofocus>
                    </div>

                    <button class="px-2 py-1 mb-2 bg-blue-700 block w-full rounded-sm text-white" type="submit"
                        @click="handleSubmit">Send</button>

                    <router-link class="mt-1" to="/login">Login</router-link>

                </form>

            </div>

        </div>
        <p v-else class="text-center mt-20 text-xl">Please check your email, we have sent you an email with instructions to reset your password. Thanks</p>
        <div class="text-center mt-12">
            <svg class="block w-40 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                
                <path fill="#ccc" d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z"/></svg>
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
let formSent = ref(false)

const router = useRouter()
const toaster = createToaster({ position: "top" });
const store = useStore()



const handleSubmit = (e) => {
    e.preventDefault()
    if (email.value.length > 4) {
        //axios.get('/sanctum/csrf-cookie').then(response => {
            axios.post('/api/forgot-password', {
                email: email.value
            })
                .then(response => {
                    console.log(response.data)
                    if (response.data.success) {
                        formSent.value=true;
                        //this.$router.go('/admin')
                        
                        
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