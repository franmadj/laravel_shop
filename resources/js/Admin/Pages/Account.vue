<script setup>
import { ref } from 'vue'
const count = ref(0)
</script>


<template>
    <div class="grow overflow-hidden min-h-screen p-6">
        <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600">Profile account</h1>
        <form class="">
            <div class="mb-4">
                <label>Name:</label>
                <input type="text" class="p-2 border rounded-sm shadow-sm block w-full">
            </div>
            <div class="mb-4">
                <label>Email:</label>
                <input type="email" class="p-2 border rounded-sm shadow-sm block w-full">
            </div>

            <div class="mb-4">
                <label>Phone:</label>
                <input type="tel" class="p-2 border rounded-sm shadow-sm block w-full">
            </div>

            <div class="mb-4">
                <label>Bio:</label>
                <textarea class="min-h-2 p-2 border rounded-sm shadow-sm block w-full"></textarea>
            </div>

            <div class="mb-4">
                <button class="px-2 py-1 bg-gray-800 block w-full rounded-sm text-white mb-2">Photo</button>
                <img class="rounded-xs w-60 max-w-full" src="https://picsum.photos/200">
            </div>
            <button class="px-2 py-1 bg-blue-700 block w-full rounded-sm text-white">Save User</button>
        </form>

    </div>
</template>



