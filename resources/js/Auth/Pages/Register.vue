<template>



<div class="conteiner">
    <div class="absolute top-3 w-full">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded w-4/5 mx-auto relative" role="alert" v-if="error !== null">
                <strong class="font-bold">Holy smokes!</strong>
                <span class="block sm:inline ml-1">{{ error }}.</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
            </div>
        </div>
        <div class="flex items-center justify-center h-screen max-w-xs mx-auto">
                <div class="p-3 border rounded-md border-gray-200 shadow-md w-full">
                    
                    <div class="text-center text-xl">Register</div>
                    
                        <form class="mt-5">

                            <div class="mb-4">
                                <label for="name">Name:</label>
                                <input type="text" id="name" class="p-2 border rounded-sm shadow-sm block w-full" v-model="name" required autofocus >
                            </div>

                            <div class="mb-4">
                                <label for="email">Email:</label>
                                <input type="email" id="email" class="p-2 border rounded-sm shadow-sm block w-full" v-model="email" required autofocus >
                            </div>

                            <div class="mb-4">
                                <label for="password">Password:</label>
                                <input type="password" id="password" class="p-2 border rounded-sm shadow-sm block w-full" v-model="password" required>
                            </div>

                            <div class="mb-4">
                                <label for="password">Password Confirmation:</label>
                                <input type="password" id="password_confirmation" class="p-2 border rounded-sm shadow-sm block w-full" v-model="password_confirmation" required>
                            </div>
                            

                            <button class="px-2 py-1 mb-2 bg-blue-700 block w-full rounded-sm text-white" type="submit" @click="handleSubmit">Register</button>
                            <router-link class="mt-1" to="/login">Login</router-link>

                            
                        </form>
                    
                </div>
            
        </div>
    </div>

</template>

<script>
export default {
    data() {
        return {
            name: "",
            email: "",
            password: "",
            password: "",
            password_confirmation: "",
            error: null
        }
    },
    methods: {
        handleSubmit(e) {
            e.preventDefault()
            if (this.password.length > 0) {
                
                    axios.post('api/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation
                    })
                        .then(response => {
                            if (response.data.success) {
                                window.location.href = "/login"
                            } else {
                                this.error = response.data.message
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                
            }
        }
    },
    
}
</script>