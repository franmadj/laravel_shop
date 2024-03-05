<template>
    <!--SIDEBAR-->
    <button type="button" class="block lg:hidden absolute right-2 top-2 w-7" @click="toggleMenu = !toggleMenu">
        <svg class="w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
            <path
                d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z" />
        </svg>
    </button>
    <sidebar class="bg-gray-800 w-full lg:w-60 border-r-0 border-stone-400 h-screen lg:h-auto overflow-y-scroll lg:overflow-y-visible 
         shrink-0 fixed lg:relative lg:block lg:border-r top-0 left-0"
        :class="{ 'grid': !toggleMenu, 'hidden': toggleMenu }">
        <div class="flex lg:hidden justify-end pt-4 pr-6">
            <button type="button" class="w-5" @click="toggleMenu = !toggleMenu">
                <svg class="w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512">
                    <path fill="#fff"
                        d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z" />
                </svg>
            </button>
        </div>



        <ul class="w-full block mx-auto bg-gray-800 h-full">


            <li class="relative">
                <router-link
                    class="peer p-2 bg-gray-800 font-normal text-white hover:bg-gray-700 hover:text-blue-400 border-white border-b flex"
                    to="/admin">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                    </svg> Dashboard
                </router-link>

                <ul class="relative left-0 top-0 bg-salte-400 w-full block peer-hover:block hover:block rounded-sm
                lg:hidden lg:absolute lg:left-full lg:w-fit">
                    <li>
                        <router-link class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5
                            pl-10 lg:pl-2" to="/">View Site</router-link>
                    </li>

                </ul>
            </li>


            <li v-if="isAdmin" class="relative">
                <router-link
                    class="peer p-2 bg-gray-800 font-normal text-white hover:bg-gray-700 hover:text-blue-400 border-white border-b flex"
                    to="/admin/products">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                    </svg> Products
                </router-link>

                <ul class="relative left-0 top-0 bg-salte-400 w-full block peer-hover:block hover:block rounded-sm
                lg:hidden lg:absolute lg:left-full lg:w-fit">
                    <li>
                        <router-link class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5
                            pl-10 lg:pl-2" to="/admin/products">All products</router-link>
                    </li>
                    <li>
                        <router-link class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5
                            pl-10 lg:pl-2" to="/admin/product">Add products</router-link>
                    </li>
                    <li>
                        <router-link class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5
                            pl-10 lg:pl-2" to="/admin/categories">Categories</router-link>
                    </li>
                    <li>
                        <router-link class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5
                            pl-10 lg:pl-2" to="/admin/attributes">Attributes</router-link>
                    </li>
                </ul>
            </li>


            <li v-if="isAdmin" class="relative">
                <a class="peer p-2 bg-gray-800 font-normal text-white hover:bg-gray-700 hover:text-blue-400 border-white border-b flex"
                    href="/">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg> Shop
                </a>

                <ul class="relative left-0 top-0 bg-salte-400 w-full block peer-hover:block hover:block rounded-sm 
                lg:hidden lg:absolute lg:left-full lg:w-fit">
                    <li>
                        <router-link class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5
                            pl-10 lg:pl-2" to="/admin/orders">Orders</router-link>
                    </li>
                    <li>
                        <router-link class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5
                            pl-10 lg:pl-2" to="/admin/settings">Settings</router-link>
                    </li>

                </ul>
            </li>


            <li v-if="isAdmin" class="relative">
                <a class="peer p-2 bg-gray-800 font-normal text-white hover:bg-gray-700 hover:text-blue-400 border-white border-b flex"
                    href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg> Users
                </a>

                <ul class="relative left-0 top-0 bg-salte-400 w-full block peer-hover:block hover:block rounded-sm 
                lg:hidden lg:absolute lg:left-full lg:w-fit">
                    <li>
                        <router-link class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5
                            pl-10 lg:pl-2" to="/admin/users">Users</router-link>
                    </li>
                    <li>
                        <router-link class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5
                            pl-10 lg:pl-2" to="/admin/add-user">Add User</router-link>
                    </li>

                </ul>
            </li>


            <li class="relative">
                <a class="peer p-2 bg-gray-800 font-normal text-white hover:bg-gray-700 hover:text-blue-400 border-white border-b flex"
                    href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg> My Orders
                </a>

                <ul class="relative left-0 top-0 bg-salte-400 w-full block peer-hover:block hover:block rounded-sm 
                lg:hidden lg:absolute lg:left-full lg:w-fit">
                    <li>
                        <router-link class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5
                            pl-10 lg:pl-2" to="/admin/my-orders">List</router-link>
                    </li>
                    

                </ul>
            </li>

            <li class="relative">
                <a class="peer p-2 bg-gray-800 font-normal text-white hover:bg-gray-700 hover:text-blue-400 border-white border-b flex"
                    href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg> Account
                </a>

                <ul class="relative left-0 top-0 bg-salte-400 w-full block peer-hover:block hover:block rounded-sm 
                lg:hidden lg:absolute lg:left-full lg:w-fit">
                    <li>
                        <router-link class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5
                            pl-10 lg:pl-2" to="/admin/account">Profile</router-link>
                    </li>
                    <li>
                        <a class="whitespace-nowrap p-2 bg-gray-800 font-normal text-white block hover:bg-gray-700 hover:text-blue-400 border-white border-b rounded-sm px-5
                        pl-10 lg:pl-2" href="#" @click="logout">Log Out</a>
                    </li>

                </ul>
            </li>
        </ul>


    </sidebar>
</template>
<script setup>
import { ref, onMounted, computed } from 'vue'
import { useStore } from 'vuex'

const store = useStore()
let toggleMenu = ref(true)

const isAdmin = computed(() => store.getters['auth/user'].isAdmin)

onMounted(() => {

    const links = [...document.getElementsByTagName('a')]
    console.log(links);

    links.forEach(item => {
        item.addEventListener('click', event => {
            if (991 > screen.width)
                toggleMenu.value = !toggleMenu.value
        })
    })

})
const logout = (e) => {
    console.log('ss')
    e.preventDefault()
    //axios.get('/sanctum/csrf-cookie').then(response => {
    axios.post('/api/logout')
        .then(response => {
            if (response.data.success) {
                store.dispatch('auth/logout')
                
            } else {
                console.log(response)
            }
        })
        .catch(function (error) {
            console.error(error);
        });
    //})
}
            /*
export default {
data() {
return {
name: "",
email: "",
password: "",
password: "",
password_confirmation: "",
error: null,
toggleMenu: false
}
},
onMonuted: {
const links=document.getElementsByTagName("a");
document.getElementsByTagName("a").forEach(item => {
item.addEventListener('click', event => {
//handle click
})
})

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
*/
</script>