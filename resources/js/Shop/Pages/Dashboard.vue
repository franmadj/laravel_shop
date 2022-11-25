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
            <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600">Dashboard</h1>
            
        </div>
    </div>
</template>



