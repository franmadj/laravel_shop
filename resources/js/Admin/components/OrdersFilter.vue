<template>
    <form class="flex flex-col md:flex-row space-y-4 md:space-y-0">
        <input placeholder="search" type="text" class="p-2 border rounded-sm shadow-sm w-full mr-2"
            v-model="filters.search" />

        <Datepicker range auto-range fixed-end v-model="filters.dateRange" :timezone="'UTC'" class="p-0 w-full md:w-fit mr-2"
            input-class-name="h-[42px]" />

        <select class="p-2 border rounded-sm shadow-sm w-full md:w-fit mr-2" v-model="filters.status">
            <option value="">Status</option>
            <option value="pending">pending</option>
            <option value="processing">Processing</option>
            <option value="completed">completed</option>
        </select>

        <button class="px-3 py-1 bg-gray-800 block w-full md:w-fit rounded-sm text-white" @click="doFilter"
            type="button">Filter</button>

    </form>
</template>

<script setup>
import {
    ref, onMounted, reactive
} from 'vue'

import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

import helpers from '../../compositions/helpers'

const emit = defineEmits(['do-filter'])
const props = defineProps({
    
})

const filters = reactive({ search: '', status: 'completed', dateRange: [] })
const endDate = new Date();
const startDate = new Date(new Date().setDate(endDate.getDate() - 7));

onMounted(() => {
    filters.dateRange = [startDate, endDate];
    doFilter();
})

const doFilter= ()=>{
    emit('do-filter', filters)
}

const resetFilter = () => {
    filters.search = '';
    filters.dateRange = [startDate, endDate];
    filters.status = '';
    emit('do-filter', filters)
}


</script>