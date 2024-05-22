<template>
    <div class="block lg:flex" v-if="(isLoggedIn && !route.meta.isPublicPage)">
        <SidebarMenu />
        <router-view></router-view>
    </div>
    <div v-else>
        <router-view></router-view>
    </div>
</template>



<script setup>
import { ref, onMounted, computed } from 'vue'
import SidebarMenu from './Admin/components/sidebarMenu.vue'


import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router';

const store = useStore()
const route = useRoute()
//console.log('App',route);



const user = computed(() => store.getters['auth/user'])
const authenticated = computed(() => store.getters['auth/authenticated'])






const isPublicPage = computed
    (() => {
        return route.meta.isPublicPage
    })

//console.log(user.value,isLoggedIn);




let isLoggedIn = ref(false)

onMounted(() => {
    if (window.Laravel.isLoggedin) {
        isLoggedIn.value = true
    } else if(user || authenticated){
        store.dispatch('auth/clearStorage')

    }
    //const route = useRoute()
    setTimeout(() => {
        console.log(route.meta.isPublicPage);
    }, 30)



})

</script>