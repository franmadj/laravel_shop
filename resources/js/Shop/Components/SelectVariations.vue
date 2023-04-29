<template>
  <select v-for="(attrSelect, i) of attrsSelect" :key="i" class="p-2 border rounded-sm shadow-sm grow"
    @change="changeAttribute(attrSelect, i, $event)">
    <option value="">Select {{ attrSelect.attrName }}</option>
    <option v-for="option of attrSelect.options" :key="option.text" :value="option.value"> {{ option.text }} </option>
  </select>

</template>

<script setup>
import { watch, onMounted, ref, reactive } from 'vue'
import SelectAttributes from './SelectAttributes.vue'

const emit = defineEmits(['update:variations']) // must emits
let attrs = reactive([]);
let attrsSelect = reactive([]);
let possibilities = ref([]);

const props = defineProps({
  product: {
    type: Object,
    default: {},
  },
})

onMounted(() => {
  console.log(props.product);
  if (props.product.type == 'variable') {
    attrs = props.product.variations.attrs
    possibilities.value = props.product.variations.possibilities.filter(item => item.added);
    console.log('added possibilities', possibilities.value);
    setAttributeNames()
    console.log('attributeIdNames', attributeIdNames);

    //console.log('possibilities', props.product.variations.possibilities, possibilities.value);

    if (attrs.length)
      attrs.forEach((attr, i) => {
        if (i == 0) {
          const options = getAttributes(attr, null);
          console.log('options', options);
          attrsSelect.push({ attrId: attr, attrName: attributeIdNames[attr], options })
        } else {
          attrsSelect.push({ attrId: attr, attrName: attributeIdNames[attr], options: [] })
        }
      });

    console.log('attrsSelect', attrsSelect);
  }
})

const changeAttribute = (attrSelect, i, e) => {
  console.log(attrSelect, i, e.target.value);
  const variations = e.target.value.split('|')
  console.log('changeAttribute', attrSelect.attrId, variations);
  const nextAttr = attrsSelect[i + 1]
  //if there is a next dorpdown
  if (nextAttr) {
    const options = getAttributes(nextAttr.attrId, variations);
    nextAttr.options = options
    //reset all next dropdowns
    for (let selectIndex = (i + 2); selectIndex <= 5; selectIndex++) {
      if (attrsSelect[selectIndex])
        attrsSelect[selectIndex].options = []
    }
    emit('update:variations', false)
  } else {
    console.log(variations);
    if (typeof variations[0] != 'undefined')
      emit('update:variations', variations[0])
  }

}



let attributeIdNames = {}
const setAttributeNames = () => {
  possibilities.value.forEach((item, i) => {
    item.items.forEach(el => {
      attributeIdNames[el.attributeId] = el.attributeName
    })
  })

}


const getAttributes_ = (attr, variations, product) => {
  axios.get('/api/shop/attribute-items', { params: { attr, variations, product } })
    .then(response => {

    })

}

const getAttributes = (attr, variations) => {
  console.log('getAttributes', attr, variations);
  let options = {};
  possibilities.value.forEach((item, i) => {
    if (!variations || variations.includes(String(item.id))) {
      item.items.forEach(el => {
        if (attr == el.attributeId) {
          if (typeof options[el.name] == 'undefined')
            options[el.name] = []
          options[el.name].push(item.id)
        }
      })
    }
  })

  console.log('options', options);
  let result = [];
  for (const [key, value] of Object.entries(options)) {
    result.push({ text: key, value: value.join('|') })
  }

  console.log('result', result);

  return result

}







</script>


