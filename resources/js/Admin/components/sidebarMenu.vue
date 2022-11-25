<template>
    <!--SIDEBAR-->
        <sidebar class="w-60 border-r border-stone-400 min-h-screen shrink-0 absolute lg:relative">
            <ul class="w-full block mx-auto bg-gray-800 h-full">
                <li class="relative">
                    <router-link class="peer p-2 bg-gray-800 font-normal text-white hover:bg-gray-700 hover:text-blue-400 border-white border-b flex" to="/admin">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                      </svg> Dashboard</router-link>
                    <ul class="absolute left-full top-0 bg-salte-400 w-fit hidden peer-hover:block hover:block rounded-sm">
                        <li>
                            <router-link 
                            class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5" 
                            to="/admin/product">View Site</router-link>
                        </li>
                        
                    </ul>
                </li>
                <li class="relative">
                    <router-link class="peer p-2 bg-gray-800 font-normal text-white hover:bg-gray-700 hover:text-blue-400 border-white border-b flex" to="/admin/products">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                      </svg> Products</router-link>
                    <ul class="absolute left-full top-0 bg-salte-400 w-fit hidden peer-hover:block hover:block rounded-sm">
                        <li>
                            <router-link 
                            class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5" 
                            to="/admin/products">All products</router-link>
                        </li>
                        <li>
                            <router-link 
                            class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5" 
                            to="/admin/product">Add products</router-link>
                        </li>
                        <li>
                            <router-link 
                            class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5" 
                            to="/admin/categories">Categories</router-link>
                        </li>
                        <li>
                            <router-link 
                            class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5" 
                            to="/admin/attributes">Attributes</router-link>
                        </li>
                    </ul>
                </li>
                <li class="relative">
                    <a class="peer p-2 bg-gray-800 font-normal text-white hover:bg-gray-700 hover:text-blue-400 border-white border-b flex" href="/">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                          </svg> Shop
                    </a>
                    <ul class="absolute left-full top-0 bg-salte-400 w-fit hidden peer-hover:block hover:block rounded-sm">
                        <li>
                            <router-link 
                            class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5" 
                            to="/admin/orders">Orders</router-link>
                        </li>
                        <li>
                            <router-link 
                            class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5" 
                            to="/admin/settings">Settings</router-link>
                        </li>

                    </ul>
                </li>

                <li class="relative">
                    <a class="peer p-2 bg-gray-800 font-normal text-white hover:bg-gray-700 hover:text-blue-400 border-white border-b flex" href="#">
                        <svg  xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                          </svg> Users
                    </a>
                    <ul class="absolute left-full top-0 bg-salte-400 w-fit hidden peer-hover:block hover:block rounded-sm">
                        <li>
                            <router-link 
                            class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5" 
                            to="/admin/users">Users</router-link>
                        </li>
                        <li>
                            <router-link 
                            class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5" 
                            to="/admin/add-user">Add User</router-link>
                        </li>

                    </ul>
                </li>

                <li class="relative">
                    <a class="peer p-2 bg-gray-800 font-normal text-white hover:bg-gray-700 hover:text-blue-400 border-white border-b flex" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                          </svg> Account
                    </a>
                    <ul class="absolute left-full top-0 bg-salte-400 w-fit hidden peer-hover:block hover:block rounded-sm">
                        <li>
                            <router-link 
                            class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5" 
                            to="/admin/account">Profile</router-link>
                        </li>
                        <li>
                            <a class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5" href="#" 
                            @click="logout">Log Out</a>
                        </li>

                    </ul>
                </li>
            </ul>


        </sidebar>
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
        logout(e) {
            console.log('ss')
            e.preventDefault()
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/api/admin/logout')
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/admin/login"
                        } else {
                            console.log(response)
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
    
}
</script>