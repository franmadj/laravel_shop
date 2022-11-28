<script setup>
import { ref, reactive } from 'vue'
let c = reactive([])
console.log(c)
c.push(1)

console.log(c)
</script>


<template>
    <div class="grow min-h-screen p-6 overflow-hidden">
        <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600">Users</h1>
        <form class="flex flex-col md:flex-row space-y-4 md:space-y-0">
            <input placeholder="search" type="text" class="p-2 border rounded-sm shadow-sm w-full mr-2">
            <select class="p-2 border rounded-sm shadow-sm w-full md:w-fit mr-2">
                <option>Category</option>
                <option>car1</option>
            </select>

            <select class="p-2 border rounded-sm shadow-sm w-full md:w-fit mr-2">
                <option>Order Type</option>
                <option>Variable</option>
            </select>

            <select class="p-2 border rounded-sm shadow-sm w-full md:w-fit mr-2">
                <option>Status</option>
                <option>Published</option>
            </select>

            <button class="px-3 py-1 bg-gray-800 block w-full md:w-fit rounded-sm text-white">Filter</button>

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

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b">
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        paco perez
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        paco@mail.es
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        Admin
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        <div class="flex gap-1">
                                            <button
                                                class="px-3 py-1 bg-gray-800 block w-fit rounded-sm text-white">Delete</button>
                                            <button
                                                class="px-3 py-1 bg-gray-800 block w-fit rounded-sm text-white">Edit</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        paco perez
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        paco@mail.es
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        Admin
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        <div class="flex gap-1">
                                            <button
                                                class="px-3 py-1 bg-gray-800 block w-fit rounded-sm text-white">Delete</button>
                                            <button
                                                class="px-3 py-1 bg-gray-800 block w-fit rounded-sm text-white">Edit</button>
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
</template>



