<template>
    
    <div class="block lg:flex" v-if="isLoggedIn">
        <SidebarMenu/>
        <router-view></router-view>
    </div>
    <div v-else>
        <router-view></router-view>
    </div>
    
</template>

<script setup>
import { ref, onMounted } from 'vue'
import Header from './Admin/components/Header.vue'
import SidebarMenu from './Admin/components/sidebarMenu.vue'
let isLoggedIn = ref(false)

onMounted(() => {
    if (window.Laravel.isLoggedin) {
        isLoggedIn.value = true
    }

})

</script>