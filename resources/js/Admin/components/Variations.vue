<template>
    <div class="border border-gray-400 rounded-sm p-2 mt-2">
        <ul class="flex gap-5 pb-2">
            <li v-for="attribute of attributes" :key="attribute.id">
                <input :id="'attribute_' + attribute.id" type="checkbox" v-model="attribute.selected" class="mr-2">
                <label :for="'attribute_' + attribute.id">{{ attribute.name }}</label>
            </li>
        </ul>
        <button type="button" @click="managePosibleVariations"
            class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Create
            variations from attributes</button>
        <div class="m-2 flex flex-col space-y-3">
            <div v-for="(variation, vi) of variations.possibilities" :key="vi" v-show="variation.added">
                <div class="flex gap-2 items-center">
                    <span>{{ vi }}</span>
                    <select v-for="(item, index) of variation.items" :key="index"
                        class="p-2 border rounded-sm shadow-sm block w-full" disabled="">
                        <option>{{ item.name }}</option>

                    </select>
                    <div style="min-width:166px;">
                        <div v-if="!variation.open" class="flex justify-around gap-1">
                            <button class="px-3 py-1 bg-red-500 block rounded-sm text-white w-1/2"
                                @click="variation.added = false; variation.updated = true; variation.action = 'remove'"
                                type="button">Remove</button>
                            <button class="px-3 py-1 bg-green-500 block rounded-sm text-white w-1/2"
                                @click="variation.open = !variation.open" type="button">
                                <span v-if="variation.open">cancel</span><span v-else>Edit</span>
                            </button>

                        </div>
                        <div class="flex justify-around gap-1" v-else>

                            <button class="px-3 py-1 bg-red-500 block w-1/2 rounded-sm text-white"
                                @click="variation.updated = true; variation.action = 'save'; variation.open = false"
                                type="button">Save</button>
                            <button class="px-3 py-1 bg-green-500 block w-1/2 rounded-sm text-white"
                                @click="variation.open = false" type="button">
                                <span>cancel</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-200 rounded-sm p-2 mt-2" :class="{ 'hidden': !variation.open }">
                    <div class="mb-4">
                        <label>Description:</label>
                        <textarea v-model="variation.data.content"
                            class="min-h-2 p-2 border rounded-sm shadow-sm block w-full"></textarea>
                    </div>

                    <div class="mb-4 flex justify-between gap-2">
                        <div class="grow">
                            <label>Price:</label>
                            <input v-model="variation.data.price" type="text"
                                class="p-2 border rounded-sm shadow-sm block w-full">
                        </div>
                        <div class="grow">
                            <label>Sale Price:</label>
                            <input v-model="variation.data.sale_price" type="text"
                                class="p-2 border rounded-sm shadow-sm block w-full">
                        </div>
                    </div>
                    <div class="mb-4 flex justify-between gap-2">
                        <div class="grow w-2/5">
                            <label>Stock status:</label>
                            <select v-model="variation.data.stock_status"
                                class="p-2 border rounded-sm shadow-sm block w-full">
                                <option value="in_stock">In stock</option>
                                <option value="out_stock">Out of stock</option>
                            </select>
                        </div>
                        <div class="grow w-2/5">
                            <label>Stock quantity:</label>
                            <input v-model="variation.data.stock_quantity" type="number"
                                class="p-2 border rounded-sm shadow-sm block w-full">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="px-2 py-1 bg-blue-700 block w-full rounded-sm text-white" type="button" @click="store">Save variations</button>
    </div>
    <custom-modal v-model="showModal" @confirm="confirmModal" @cancel="cancelModal">
        <template v-slot:title>Hello, vue-final-modal</template>
        <ul v-for="(variation, vi) of variations.possibilities" :key="vi"
            class="flex gap-1 bg-slate-100 mb-1 py-2 hover:bg-slate-200 cursor-pointer"
            :class="{ 'bg-green-200': variation.added }" @click="variation.added = !variation.added">
            <li class="p-2 flex justify-center w-1/2" v-for="(item, index) of variation.items" :key="index">{{ item.name }}</li>
        </ul>
    </custom-modal>

    <DialogsWrapper />
</template>
<script setup>
import { ref, onMounted, watch, reactive } from 'vue'
import { createToaster } from "@meforma/vue-toaster"
import { createConfirmDialog } from 'vuejs-confirm-dialog'
import CustomModal from './CustomModal.vue'
import ConfirmDialog from '../../components/ConfirmDialog.vue'
import helpers from '../../compositions/helpers'

const props = defineProps({
    productId: { type: Number, required: false, default: false },
    variations: { type: String, required: true, default: false },
})


onMounted(() => {
    populateAttributes();
    console.log('onMounted', props.variations);
})

const attributes = ref([])
const toaster = createToaster({ position: "top" });
const dialog = createConfirmDialog(ConfirmDialog,{msg:'This action will reset variations'})
let variations = reactive({ possibilities: [], attrs: [] })
let showModal = ref(false)

const confirmModal = (close) => { 
    // some code...
    close()
}
const cancelModal = (close) => {
    // some code...
    close()
    //modalShow.value = false
}







const populateAttributes = () => {
    //console.log(e.target.value);
    axios.get('/api/admin/attribute')
        .then(response => {
            if (response.data.success) {
                attributes.value = response.data.data

                //if (helpers.testJSON(props.variations)) {

                    //const possibilities = (JSON.parse(props.variations))
                    const possibilities = props.variations
                    attributes.value = attributes.value.map((attr) => {
                        if (possibilities.attrs.includes(attr.id)) {
                            variations.attrs.push(attr.id)
                            attr.selected = true
                        }
                        return attr;

                    })

                    possibilities.possibilities.forEach(el => {
                        variations.possibilities.push(el)

                    });


                    console.log(attributes.value, variations)
                //}

            } else {

            }
        })
        .catch(function (error) {
            toaster.error(error);
        });
}


const confirmResetVariations = async () => {
    const { data, isCanceled } = await dialog.reveal()
    if (isCanceled) return
    createPosibleVariations()
}


const managePosibleVariations = () => {
    let selectedAttrs = attributes.value.filter(attr => attr.selected)
    let selectedAttrsIds = selectedAttrs.map(attr => attr.id);


    if (variations.possibilities.length) {
        const intersection = selectedAttrsIds.filter(x => variations.attrs.includes(x));
        const attrsLength = selectedAttrsIds.length;
        console.log(selectedAttrsIds, variations.attrs, intersection)
        console.log(variations.attrs.length, attrsLength, intersection.length);
        console.log(variations.attrs.length == attrsLength && intersection.length == attrsLength)
        if (variations.attrs.length == attrsLength && intersection.length == attrsLength) {
            showModal.value = true; 
            return;
        } else {
            confirmResetVariations()
            return;
        }
    }
    createPosibleVariations()
}

const createPosibleVariations = () => {
    showModal.value = true; 
    let selectedAttrs = attributes.value.filter(attr => attr.selected)
    let selectedAttrsIds = selectedAttrs.map(attr => attr.id);

    const lastIndex = selectedAttrs.length - 1;
    console.log(selectedAttrs)

    if (selectedAttrs.length && selectedAttrs.length < 4) {
        variations.attrs = selectedAttrsIds;
        variations.possibilities = [];
        let countTrack = [0, 0, 0];
        let possibilitiesItem = []
        let keep = true;
        while (keep) {
            selectedAttrs.forEach((attr, i) => {
                possibilitiesItem.push({ id: attr.items[countTrack[i]].id, name: attr.items[countTrack[i]].name, attributeId:attr.id })
                if (i == lastIndex) {
                    for (let key = lastIndex; key >= 0; key--) {
                        let nextItem = countTrack[key] + 1
                        if (typeof selectedAttrs[key].items[nextItem] != 'undefined') {
                            countTrack[key]++;
                            break;
                        } else {
                            if (!key)
                                keep = false
                            else
                                countTrack[key] = 0;
                        }
                    }
                    variations.possibilities.push({ items: possibilitiesItem, added: false, data: {}, action: 'none' })
                    possibilitiesItem = [];
                }
            })
        }
        console.log(variations.possibilities);
    } else {
        toaster.error(`Select Maximum 3 attributes`);
    }

}



const store = async () => {
    if (typeof variations.possibilities != 'undefined') {
        axios.post('/api/admin/variations/' + props.productId, { variations: variations })
            .then(response => {
                if (response.data.success) {
                    variations.possibilities=response.data.data.possibilities
                    toaster.success(`Variation saved`);
                } else {
                    toaster.error(`Error`);
                }
            })
            .catch(function (error) {
                toaster.error(error);
            });

    } else {
        toaster.error(`Add some variations`);

    }
}


</script>



