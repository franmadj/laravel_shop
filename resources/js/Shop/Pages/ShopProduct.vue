<template>

    <div class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">

        <!--Nav-->
        <Navbar />

        <Carousel />


        <section class="bg-white py-8 px-2">

            <div class="container mx-auto pt-4 pb-12">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-4 flex-wrap justify-center">

                    <GlobalGroupTransition>
                        <ProductItem class="w-full sm:w-[500px] md:w-[500px] lg:w-[700px]" v-if="product"
                            :product="product" :authenticated="authenticated" gallery="true" content="true" />
                    </GlobalGroupTransition>

                    <div class="flex flex-col gap-4 w-full lg:w-fit">
                        <div class="flex flex-col gap-4" v-if="product.type == 'variable'">
                            <SelectVariations :product="product" />
                            
                        </div>
                        <button type="button"
                            class="inline-block px-6 py-2.5 bg-gray-200 text-gray-700 font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-300 hover:shadow-lg focus:bg-gray-300 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-400 active:shadow-lg transition duration-150 ease-in-out">add
                            To Cart</button>

                    </div>
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
import SelectVariations from '../Components/SelectVariations.vue'
import GlobalGroupTransition from '../../Transitions/GlobalGroupTransition.vue'
import helpers from '../../compositions/helpers'


const store = useStore()
const router = useRouter()
const authenticated = ref(store.getters['auth/authenticated'])
const toaster = createToaster({ position: "top" });

const product = ref(false)




const props = defineProps({
    slug: { type: String, required: true, default: '' }
})


onMounted(() => {
    console.log(props, props.slug)
    if (props.slug)
        loadProduct(props.slug)
})

const loadProduct = async (slug) => {
    await axios.get('/api/shop/product/' + slug)
        .then(res => {
            if (res.data.success) {

                console.log('DATA EDIT: ', { ...res.data.data });
                product.value = { ...res.data.data };

                







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



