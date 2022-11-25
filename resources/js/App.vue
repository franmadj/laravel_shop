<template>
    <Header/>
    <div class="flex">
        <SidebarMenu/>
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

/*
export default {
    name: "App",
    data() {
        return {
            isLoggedIn: false,
        }
    },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true
        }
    },
    methods: {

    },
}*/
</script>