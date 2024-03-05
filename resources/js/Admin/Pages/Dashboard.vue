<template>
    <div class="grow min-h-screen p-6 overflow-hidden">
        <h1 class="text-3xl font-bold mb-3 uppercase text-gray-600">Dashboard {{ user.name }}</h1>

        <div class="flex gap-4 justify-center">
            <StatisticCard v-for="(card, index) of cards" :key="index" :card="card" />
        </div>

    </div>
</template>

<script setup>
import { ref, onMounted, computed, reactive } from 'vue'
import { createToaster } from "@meforma/vue-toaster"
import { useStore } from 'vuex'


import helpers from '../../compositions/helpers'
import StatisticCard from '../components/StatisticCard.vue'

const store = useStore()
const toaster = createToaster({ position: "top" });

const user = computed(() => store.getters['auth/user'])
const isAdmin = computed(() => store.getters['auth/user'].isAdmin)

const cards = ref([]);


onMounted(() => {
    console.log(isAdmin.value);
    if (isAdmin.value) {
        getTotalUsers();
        getTotalOrders();
    } else {
        getTotalMyOrders();
    }


})

const getTotalUsers = () => {
    axios.get('/api/admin/user-statistics')
        .then(res => {
            if (res.data.success) {
                const data = [
                    { type: 'user', link: 'users', title: 'Total Users', text: 'All Users that are registered on this platform', count: res.data.data.usersCount },
                    { type: 'user', link: 'users', title: 'New Users', text: 'All Users that are registered on this platform in the last week', count: res.data.data.newUsersCount },
                ]
                cards.value = [...cards.value, ...data]
            } else
                toaster.error(`Error`);
        })
        .catch(function (error) {
            toaster.error(helpers.makeTextErrors(error));
        });
}



const getTotalOrders = () => {
    axios.get('/api/admin/order-statistics')
        .then(res => {
            if (res.data.success) {
                const data = [
                    { type: 'order', link: 'orders', title: 'Total Orders', text: 'All Orders that are registered on this platform', count: res.data.data.ordersCount },
                    { type: 'order', link: 'orders', title: 'New Orders', text: 'All Orders that are registered on this platform in the last week', count: res.data.data.newOrdersCount },
                ]
                cards.value = [...cards.value, ...data]
            } else
                toaster.error(`Error`);
        })
        .catch(function (error) {
            toaster.error(helpers.makeTextErrors(error));
        });
}

const getTotalMyOrders = () => {
    axios.get('/api/admin/my-order-statistics')
        .then(res => {
            if (res.data.success) {
                const data = [
                    { type: 'order', link: 'my-orders', title: 'My Total Orders', text: 'All your Orders that are registered on this platform', count: res.data.data.ordersCount },
                ]
                cards.value = [...cards.value, ...data]
            } else
                toaster.error(`Error`);
        })
        .catch(function (error) {
            toaster.error(helpers.makeTextErrors(error));
        });
}






</script>
