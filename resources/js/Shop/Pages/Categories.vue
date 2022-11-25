<script setup>
    import { ref } from 'vue'
    import Header from '../components/Header.vue'
    import SidebarMenu from '../components/sidebarMenu.vue'
    const count = ref(0)
</script>


<template>
<Header/>

    <div class="flex">
        <SidebarMenu/>
        <div class="w-full min-h-screen p-6">
            <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600">Categories</h1>
            <form class="">
                <div class="mb-4">
                    <label>Name:</label>
                    <input type="text" class="p-2 border rounded-sm shadow-sm block w-full">
                </div>

                <div class="mb-4">
                    <label>Description:</label>
                    <textarea class="min-h-2 p-2 border rounded-sm shadow-sm block w-full"></textarea>
                </div>

                <div class="mb-4">
                    <label>Slug:</label>
                    <input type="text" class="p-2 border rounded-sm shadow-sm block w-full">
                </div>

                <div class="mb-4">
                    <button class="px-2 py-1 bg-gray-800 block w-full rounded-sm text-white mb-2">Add Image</button>
                    <img class="rounded-xs w-60 max-w-full" src="https://picsum.photos/200">
                </div>
                <button class="px-2 py-1 bg-blue-700 block w-full rounded-sm text-white">Save Category</button>
            </form>
            <div class="flex flex-col mt-4">
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
                                            Description
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                            Slug
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-white px-6 py-4">

                                        </th>
                                    </tr>
                                </thead >
                                <tbody>
                                    <tr class="bg-white border-b">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <img class="rounded-md w-8 max-w-full" src="https://picsum.photos/30">
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            Cat1
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            This is a category
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            category-1
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            <div class="flex gap-1">
                                                <button class="px-3 py-1 bg-red-500 block w-fit rounded-sm text-white">Delete</button>
                                                <button class="px-3 py-1 bg-green-500 block w-fit rounded-sm text-white">Edit</button>
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



