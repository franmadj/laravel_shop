<template>
  <select v-model="filterCategory" class="p-2 border rounded-sm shadow-sm grow">
    <option value="">Category</option>
    <option v-for="category of categories" :key="category.id" :value="category.id">{{ category.name }}
    </option>
  </select>
</template>

<script setup>
import { watch, onMounted, ref } from 'vue'

const emit = defineEmits(['update:modelValue']) // must emits

onMounted(() => {
  populateCategories();
})


const props = defineProps({
  modelValue: {
    type: String,
    default: '',
  },
})

console.log('props.modelValue', props)

let filterCategory = ref(props.modelValue)
const categories = ref([])

watch(props, (value) => {
  console.log('props',value);
  filterCategory.value = value.modelValue

})
watch(filterCategory, (value) => {
  console.log('emit',value);
  emit('update:modelValue', value)
})

const populateCategories = async () => {
  axios.get('/api/shop/categories')
    .then(response => {
      if (response.data.success) {
        console.log(response.data.data);
        categories.value = response.data.data
      } else {
        toaster.error(`Error Getting categories`);
      }
    })
    .catch(function (error) {
      toaster.error(error);
    });
}


</script>


