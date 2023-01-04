<template>
  <SelectAttributes v-for="attribute of attributes" :key="attribute" :product="product" />
</template>

<script setup>
import { watch, onMounted, ref } from 'vue'
import SelectAttributes from './SelectAttributes.vue'

const emit = defineEmits(['update:modelValue']) // must emits
const attributes = reactive([]);

const props = defineProps({
  product: {
    type: Object,
    default: {},
  },
})

onMounted(() => {
  if (props.product.value.type = 'variable') {
    attributes = product.value.variations.attrs
  }
})




console.log('props.modelValue', props)

let filterCategory = ref(props.modelValue)
const categories = ref([])

watch(props, (value) => {
  console.log('props', value);
  filterCategory.value = value.modelValue

})
watch(filterCategory, (value) => {
  console.log('emit', value);
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


