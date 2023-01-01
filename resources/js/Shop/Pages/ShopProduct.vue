<template>

    <div class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">

        <!--Nav-->
        <Navbar />

        <Carousel />


        <section class="bg-white py-8">

            <div class="container mx-auto pt-4 pb-12">
                <div class=" flex items-center gap-2 flex-wrap justify-around">

                    <GlobalGroupTransition>
                        <ProductItem class="" v-if="product" :product="product" :authenticated="authenticated" />
                    </GlobalGroupTransition>
                </div>
            </div>

        </section>




        <Footer />

    </div>
</template>



<script setup>
import { ref, onMounted, computed, reactive } from 'vue'



import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router';
import { createToaster } from "@meforma/vue-toaster"

import Navbar from '../Components/Navbar.vue'
import Carousel from '../Components/Carousel.vue'
import ProductList from '../Components/ProductList.vue'
import Footer from '../Components/Footer.vue'
import ProductItem from '../Components/ProductItem.vue'


const store = useStore()
const router = useRouter()
const authenticated = ref(store.getters['auth/authenticated'])
const toaster = createToaster({ position: "top" });

const product = ref(false)


const props = defineProps({
    slug: { type: String, required: true, default: '' }
})


onMounted(() => {
    console.log(props,props.slug)
    if (props.slug)
        loadProduct(props.slug)
})

const loadProduct = async (slug) => {
    await axios.get('/api/shop/product/' + slug)
        .then(res => {
            if (res.data.success) {
                let selectedCategories = {};
                res.data.data.categories.map(cat => {
                    selectedCategories[cat.id] = true;
                });

                console.log('DATA EDIT: ', { ...res.data.data, selectedCategories });
                product.value = { ...res.data.data, selectedCategories };

                if (res.data.data.feature_image) {
                    //filesDefault.push(res.data.data.feature_image)
                }

                if (res.data.data.gallery) {
                    res.data.data.gallery.forEach((url) => {
                        //galleryDefault.push(url)
                    })
                }



            } else {
                toaster.error(`Error`);
            }
        })
        .catch(function (error) {
            toaster.error(error);
        });
}




const user = computed(() => store.getters['auth/user'])













</script>



