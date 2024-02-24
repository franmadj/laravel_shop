<template>
    <div class="p-4 border border-gray-200 rounded">
        <div class="mb-4">
            <div v-for="(item, index) in notes" :key="index" class="mb-3">
                <div class="bg-gray-200 p-2 mb-1">
                    {{ item.note }}
                </div>
                <p class="f text-xs text-gray-300">{{ item.author }} On {{ item.date }} <a class="f text-red-400" href="#" 
                    @click.prevent="confirmDelete(item.id)">Delete note</a></p>

            </div>

        </div>
        <textarea class="p-2 border border-gray-300 w-full" v-model="note"></textarea>
        <button class="px-2 py-1 bg-blue-700 block w-full rounded-sm text-white" type="button" @click="store()">Add
            Note</button>
    </div>
    <DialogsWrapper />
</template>
<script setup>
import { ref, onMounted, watch, reactive } from 'vue'
import { createToaster } from "@meforma/vue-toaster"
import { createConfirmDialog } from 'vuejs-confirm-dialog'
import ConfirmDialog from '../../components/ConfirmDialog.vue'
import helpers from '../../compositions/helpers'

const props = defineProps({
    orderId: { type: Number, required: false, default: false },
    notes: { type: Array, required: true, default: false },
})


onMounted(() => {
    populateNotes()
    console.log('onMounted', props.notes);
    //notes = props.notes
})


const toaster = createToaster({ position: "top" });
const dialog = createConfirmDialog(ConfirmDialog, { msg: 'Do you wnat to remove this item?' })

let note = ref('')
let notes = ref([])

const confirmModal = (close) => {
    // some code...
    close()
}
const cancelModal = (close) => {
    // some code...
    close()
    //modalShow.value = false
}



const populateNotes = () => {
    //console.log(e.target.value);
    axios.get('/api/admin/order/'+props.orderId+'/notes')
        .then(response => {
            if (response.data.success) {
                notes.value = response.data.data
            } else {

            }
        })
        .catch(function (error) {
            toaster.error(error);
        });
}


const confirmDelete = async (id) => { console.log('confirm');
    const { data, isCanceled } = await dialog.reveal()
    if (isCanceled) return
    deleteNote(id)
}

const deleteNote = (id) => {
    axios.delete('/api/admin/note/' + id)
        .then(response => {
            if (response.data.success) {
                populateNotes()
                toaster.success(`Note deleted`);
            } else {
                toaster.error(`Error`);
            }
        })
        .catch(function (error) {
            toaster.error(error);
        });
}




const store = async () => {
    if (note.value.length) {
        axios.post('/api/admin/note', { note: note.value, order_id: props.orderId })
            .then(response => {
                if (response.data.success) {
                    note.value=''
                    populateNotes()
                    toaster.success(`Note saved`);
                } else {
                    toaster.error(`Error`);
                }
            })
            .catch(function (error) {
                toaster.error(error);
            });

    } else {
        toaster.error(`Add some notes`);

    }
}


</script>



