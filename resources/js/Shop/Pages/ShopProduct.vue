<template>
    <div class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
        <!--Nav-->
        <Navbar />
        <section class="bg-white py-8 px-2">
            <div class="container mx-auto pt-4 pb-12">
                <router-link to="/" class="flex gap-2 items-center mb-9">
                    <svg class="w-4" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 448 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                        <path
                            d="M64 468V44c0-6.6 5.4-12 12-12h48c6.6 0 12 5.4 12 12v176.4l195.5-181C352.1 22.3 384 36.6 384 64v384c0 27.4-31.9 41.7-52.5 24.6L136 292.7V468c0 6.6-5.4 12-12 12H76c-6.6 0-12-5.4-12-12z" />
                    </svg>
                    <p class="text-xl">Back to shop</p>
                </router-link>
                <div class="flex flex-col md:flex-row items-center md:items-start gap-4 flex-wrap justify-center">
                    <GlobalGroupTransition>
                        <ProductItem class="w-full sm:w-[500px] md:w-[500px] lg:w-[700px]" v-if="product"
                            :product="product" :authenticated="authenticated" gallery="true" content="true" />
                    </GlobalGroupTransition>

                    <div class="flex flex-col gap-4 w-full lg:w-fit">
                        <div class="flex flex-col gap-4" v-if="product.type == 'variable'">
                            <SelectVariations :product="product" @update:variations="updateVariations" />
                        </div>
                        <span class="font-bold">${{ product.price }}</span>
                        <select class="p-2 border rounded-sm shadow-sm grow" v-model="productItem.quantity">

                            <option v-for="qty of [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]" :key="qty"> {{ qty }}</option>
                        </select>
                        <button type="button" @click="addToCart"
                            :class="{ 'bg-black text-white': addToCartActive, 'bg-grey-500 text-black': !addToCartActive }"
                            class="inline-block px-6 py-2.5  font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-300 hover:shadow-lg focus:bg-gray-300 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-400 active:shadow-lg transition duration-150 ease-in-out">add
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

import Navbar from '../Components/Navbar.vue'
import Carousel from '../Components/Carousel.vue'
import ProductList from '../Components/ProductList.vue'
import Footer from '../Components/Footer.vue'
import ProductItem from '../Components/ProductItem.vue'
import SelectVariations from '../Components/SelectVariations.vue'
import GlobalGroupTransition from '../../Transitions/GlobalGroupTransition.vue'


const store = useStore()
const carItems = computed(() => store.getters['cart/cartItems'])
const product = ref(false)


let addToCartActive = ref(false)
let productItem = ref({});

const props = defineProps({
    slug: { type: String, required: true, default: '' }
})

onMounted(() => {
    console.log(props, props.slug)
    if (props.slug)
        loadProduct(props.slug)

    console.log('cart/cartItems', store.getters['cart/cartItems'])
})

const updateVariations = (variation) => {
    console.log(variation)
    if (variation && typeof product.value.selected_variations[variation] != 'undefined') {
        productItem.value.variation = product.value.selected_variations[variation]
        productItem.value.price = product.value.price = product.value.selected_variations[variation].price
        addToCartActive.value = true
    } else {
        productItem.value.variation = false
        addToCartActive.value = false
    }
}

const addToCart = () => {
    const item = productItem.value
    if (!addToCartActive.value || (product.value.is_variable && !productItem.value.variation)) {
        alert('select attributes')
        return;
    }
    const newItem = {
        id: item.id,
        image: item.image,
        title: item.title,
        isVariable: item.isVariable,
        quantity: item.quantity,
        variation: item.variation,
        price: item.price,
    }

    const payload = {
        newItem: newItem,
        cartItems: carItems
    }
    console.log('carItems',carItems);

    store.commit('cart/ADD_CART_ITEMS', payload.newItem)
    //store.dispatch('cart/addCartItem', productItem)
}

const loadProduct = async (slug) => {
    await axios.get('/api/shop/product/' + slug)
        .then(res => {
            if (res.data.success) {
                console.log('DATA loadProduct: ', { ...res.data.data });
                product.value = { ...res.data.data };
                if (!product.value.is_variable)
                    addToCartActive.value = true
                setProductItem()
            } else {
                toaster.error(`Error`);
            }
        })
        .catch(function (error) {
            toaster.error(error);
        });
}
const user = computed(() => store.getters['auth/user'])

const setProductItem = () => {
    const prod = product.value
    productItem.value = {
        'price': prod.price,
        'image': prod.feature_thumb,
        'id': prod.id,
        'title': prod.title,
        'isVariable': prod.is_variable,
        'variation': null,
        'quantity': 1
    }

}
</script>
