<template>

    <div>
        <router-link :to="'/shop/'+props.product.slug">
            <img v-if="props.product.feature_medium"
                class="hover:grow hover:shadow-lg mx-auto md:h-44 lg:h-80 xl:h-[400px] object-cover"
                :src="props.product.feature_medium">
            <img v-else class="hover:grow hover:shadow-lg mx-auto md:h-44 lg:h-80 xl:h-[400px] object-cover"
                src="https://images.unsplash.com/photo-1555982105-d25af4182e4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=400&h=400&q=80">
            <div class="pt-3 flex items-center justify-between">
                <p class="">{{ props.product.title }}</p>
                <div @click.prevent="likeToggle(props.product.id)">
                    <svg v-if="liked" class="h-6 w-6 fill-current text-red-500 hover:text-black"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path
                            d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z" />
                    </svg>
                    <svg v-else class="h-6 w-6 fill-current text-grey-500 hover:text-black"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path
                            d="M12,4.595c-1.104-1.006-2.512-1.558-3.996-1.558c-1.578,0-3.072,0.623-4.213,1.758c-2.353,2.363-2.352,6.059,0.002,8.412 l7.332,7.332c0.17,0.299,0.498,0.492,0.875,0.492c0.322,0,0.609-0.163,0.792-0.409l7.415-7.415 c2.354-2.354,2.354-6.049-0.002-8.416c-1.137-1.131-2.631-1.754-4.209-1.754C14.513,3.037,13.104,3.589,12,4.595z M18.791,6.205 c1.563,1.571,1.564,4.025,0.002,5.588L12,18.586l-6.793-6.793C3.645,10.23,3.646,7.776,5.205,6.209 c0.76-0.756,1.754-1.172,2.799-1.172s2.035,0.416,2.789,1.17l0.5,0.5c0.391,0.391,1.023,0.391,1.414,0l0.5-0.5 C14.719,4.698,17.281,4.702,18.791,6.205z" />
                    </svg>
                </div>
            </div>
            <p class="pt-1 text-gray-900">£{{ props.product.price }}</p>
        </router-link>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const props = defineProps({
    product: { type: Object, required: true, default: false },
    authenticated: { type: Boolean, required: true, default: false }
})

onMounted(() => {

    console.log('productItem', props.product)

})

const liked = ref(props.product.liked);

const likeToggle = async (id) => {
    console.log(props.authenticated);
    if(!props.authenticated){
        alert('Please log in')
    }
    
    axios.patch(`/api/product/${id}/like`)
        .then(res => {
            if (res.data.success) {
                liked.value = !liked.value;

            } else {
                console.log(`Error Getting products`);
            }
        })
        .catch(function (error) {
            console.log(error.response);

        });

}



// watch(props.product, (products) => {
// 	console.log('watch(props.filesDefault');
// 	console.log('urls: ', urls);
// 	//files = [];
// 	let list = new DataTransfer();
// 	urls.forEach((url, i) => {
// 		helpers.getFileFromUrl(url, i + '_name.png')
// 			.then(file => {
// 				list.items.add(file);
// 				//console.log('list.items.add', file);
// 				console.log('list.files: ', list.files)
// 				addFiles(list.files)
// 			})
// 	})
// });
</script>



