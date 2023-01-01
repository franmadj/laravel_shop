


<template>

    <div class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">

        <!--Nav-->
        <Navbar />

        <Carousel />


        <productList/>

      

        <footer/>

    </div>
</template>



<script setup>
import { ref, onMounted, computed, reactive } from 'vue'



import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router';

import Navbar from '../Components/Navbar.vue'
import Carousel from '../Components/Carousel.vue'
import ProductList from '../Components/ProductList.vue'

const store = useStore()
const router = useRouter()
const route = useRoute()




const user = computed(() => store.getters['auth/user'])













</script>



