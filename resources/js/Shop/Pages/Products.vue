<script setup>
    import { ref } from 'vue'
    import Header from '../components/Header.vue'
    import SidebarMenu from '../components/sidebarMenu.vue'
    const count = ref(0)
    //this.$route.params.slug
</script>


<template>
<Header/>
    <div class="flex">
        <SidebarMenu/>
        <div class="w-full min-h-screen p-6">
            <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600">Products</h1>
            <form class="flex">
                <input placeholder="search" type="text" class="p-2 border rounded-sm shadow-sm w-full mr-2">
                <select class="p-2 border rounded-sm shadow-sm w-fit mr-2">
                    <option>Category</option>
                    <option>car1</option>
                </select>

                <select class="p-2 border rounded-sm shadow-sm w-fit mr-2">
                    <option>Product Type</option>
                    <option>Variable</option>
                </select>

                <select class="p-2 border rounded-sm shadow-sm w-fit mr-2">
                    <option>Status</option>
                    <option>Published</option>
                </select>

                <button class="px-3 py-1 bg-gray-800 block w-fit rounded-sm text-white">Filter</button>

            </form>
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
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
                                            Price
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                            Categories
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-white px-6 py-4">

                                        </th>
                                    </tr>
                                </thead >
                                <tbody>
                                    <tr class="bg-white border-b">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <img class="rounded-md" src="https://picsum.photos/30">
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            Prod1
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            300$
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            Cat1, Cat2sdfsdf, sdfsdfsdf, sdfsdfs
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            <div class="flex gap-1">
                                                <button class="px-3 py-1 bg-gray-800 block w-fit rounded-sm text-white">Delete</button>
                                                <button class="px-3 py-1 bg-gray-800 block w-fit rounded-sm text-white">Edit</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <img class="rounded-md" src="https://picsum.photos/30">
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            Prod1
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            300$
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            Cat1, Cat2sdfsdf, sdfsdfsdf, sdfsdfs
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            <div class="flex gap-1">
                                                <button class="px-3 py-1 bg-gray-800 block w-fit rounded-sm text-white">Delete</button>
                                                <button class="px-3 py-1 bg-gray-800 block w-fit rounded-sm text-white">Edit</button>
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
</template>



