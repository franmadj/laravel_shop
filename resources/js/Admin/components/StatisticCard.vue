<template>
    <div class="block p-6 rounded-lg shadow-lg bg-white max-w-sm">
        <div class="flex items-center gap-2 mb-2">
            <h5 class="text-gray-900 text-xl leading-tight font-medium">{{ card.count }} {{ card.title }}</h5>
            <svg v-if="card.type == 'user'" class="w-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                <path
                    d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm32 32h-64c-17.6 0-33.5 7.1-45.1 18.6 40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64zm-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zm-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4z" />
            </svg>
            <svg v-else class="w-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                <path
                    d="M224 320h32V96h-32c-17.67 0-32 14.33-32 32v160c0 17.67 14.33 32 32 32zm352-32V128c0-17.67-14.33-32-32-32h-32v224h32c17.67 0 32-14.33 32-32zm48 96H128V16c0-8.84-7.16-16-16-16H16C7.16 0 0 7.16 0 16v32c0 8.84 7.16 16 16 16h48v368c0 8.84 7.16 16 16 16h82.94c-1.79 5.03-2.94 10.36-2.94 16 0 26.51 21.49 48 48 48s48-21.49 48-48c0-5.64-1.15-10.97-2.94-16h197.88c-1.79 5.03-2.94 10.36-2.94 16 0 26.51 21.49 48 48 48s48-21.49 48-48c0-5.64-1.15-10.97-2.94-16H624c8.84 0 16-7.16 16-16v-32c0-8.84-7.16-16-16-16zM480 96V48c0-26.51-21.49-48-48-48h-96c-26.51 0-48 21.49-48 48v272h192V96zm-48 0h-96V48h96v48z" />
            </svg>
        </div>
        <p class="text-gray-700 text-base mb-4 min-h-[48px]">
            {{ card.text }}
        </p>
        <router-link :to="'/admin/'+card.link"
            class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
            Go</router-link>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, reactive } from 'vue'


const props = defineProps({
    card: { type: Object, required: true, default: {} },
    /*type: { type: String, required: true, default: 'user' },
    title: { type: String, required: true, default: '' },
    text: { type: String, required: true, default: '' },
    count: { type: Number, required: true, default: 0 },*/

})


onMounted(() => {

})




</script>
