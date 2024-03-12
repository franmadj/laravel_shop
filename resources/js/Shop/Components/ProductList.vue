<template>

    <section class="bg-white py-8">

        <div class="container mx-auto pt-4 pb-12">

            <nav id="store" class="w-full z-30 top-0 px-6 py-1 relative">
                <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">

                    <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl "
                        href="#">
                        Store
                    </a>

                    <div class="flex items-center" id="store-nav-content">

                        <a class="pl-3 inline-block no-underline hover:text-black" href="#">
                            <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24">
                                <path d="M7 11H17V13H7zM4 7H20V9H4zM10 15H14V17H10z" />
                            </svg>
                        </a>

                        <div class="pl-3 inline-block no-underline hover:text-black cursor-pointer"
                            @click="openFilterPopUp">
                            <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24">
                                <path
                                    d="M10,18c1.846,0,3.543-0.635,4.897-1.688l4.396,4.396l1.414-1.414l-4.396-4.396C17.365,13.543,18,11.846,18,10 c0-4.411-3.589-8-8-8s-8,3.589-8,8S5.589,18,10,18z M10,4c3.309,0,6,2.691,6,6s-2.691,6-6,6s-6-2.691-6-6S6.691,4,10,4z" />
                            </svg>
                        </div>

                        <ComponentTransition>
                            <div v-if="filterPopUp" id="contentFilterPopUp"
                                class="absolute bg-white right-0 top-16 w-96 p-3 border border-gray-300 shadow-md rounded">
                                <div class="relative h-10">
                                    <span class="absolute right-0 top-0 cursor-pointer w-5 opacity-70"
                                        @click="filterPopUp = false">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path
                                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm101.8-262.2L295.6 256l62.2 62.2c4.7 4.7 4.7 12.3 0 17l-22.6 22.6c-4.7 4.7-12.3 4.7-17 0L256 295.6l-62.2 62.2c-4.7 4.7-12.3 4.7-17 0l-22.6-22.6c-4.7-4.7-4.7-12.3 0-17l62.2-62.2-62.2-62.2c-4.7-4.7-4.7-12.3 0-17l22.6-22.6c4.7-4.7 12.3-4.7 17 0l62.2 62.2 62.2-62.2c4.7-4.7 12.3-4.7 17 0l22.6 22.6c4.7 4.7 4.7 12.3 0 17z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <input id="filterSearch" v-model="filter.search" type="text"
                                        class="p-2 border border-slate-200 text-base w-full" placeholder="search">
                                    <SelectCategories class="w-full" v-model="filter.category"></SelectCategories>
                                    <button class="w-full p-2 border-slate-200 border text-base"
                                        @click="populateProducts">Filter</button>
                                    <button class="w-full p-2 border-slate-200 border text-base"
                                        @click="resetFilter">Reset</button>

                                </div>

                            </div>
                        </ComponentTransition>

                    </div>
                </div>
            </nav>



            <div class=" flex items-center gap-3 mx-auto flex-wrap justify-center">
                <GlobalGroupTransition>
                    <ProductItem class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col shadow-xl mb-7" v-for="product of products" :key="product.id" :product="product" :authenticated="authenticated" />
                </GlobalGroupTransition>
            </div>
        </div>

    </section>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import ProductItem from './ProductItem.vue'
import GlobalGroupTransition from '../../Transitions/GlobalGroupTransition.vue'
import ComponentTransition from '../../Transitions/ComponentTransition.vue'
import SelectCategories from '../../components/SelectCategories.vue'
import { useStore } from 'vuex'

const store = useStore()
const authenticated = ref(store.getters['auth/authenticated'])

console.log('authenticated',authenticated.value);

const filterPopUp = ref(false)

let products = ref([])
let categories = reactive([])
let filter = reactive({ search: '', category: '' })

onMounted(() => {
    populateProducts();

    console.log('PorductList');
})



const resetFilter = () => {
    filter.search = ''
    filter.category = ''
    populateProducts()

}

const openFilterPopUp = () => {
    filterPopUp.value = true
    setTimeout(() => {
        const contentFilterPopUp = document.getElementById('contentFilterPopUp')
        document.getElementById('filterSearch').focus()
        console.log('popup', contentFilterPopUp);

        const handleClickOutside = (e) => {
            if (!(contentFilterPopUp === e.target || contentFilterPopUp.contains(e.target))) {
                filterPopUp.value = false
                document.body.removeEventListener('click', handleClickOutside)

            }
        }
        document.body.addEventListener('click', handleClickOutside)

    }, 500)

}


const populateProducts = async () => {
    axios.get('/api/shop/products', { params: filter })
        .then(res => {
            if (res.data.success) {
                //console.log(res.data.data);
                products.value = res.data.data
                console.log(products.value);
            } else {
                console.log(`Error Getting products`);
            }
        })
        .catch(function (error) {
            console.log(error.response);

        });
}
</script>



