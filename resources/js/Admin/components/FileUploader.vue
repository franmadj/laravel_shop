<template>
	<div class="w w-full py-8 rounded-md border-dotted border-gray-400 border-2 bg-slate-100 my-4 p-3 text-center"
		@dragenter.prevent="setActive" @dragover.prevent="setActive" @dragleave.prevent="setInactive"
		@drop.prevent="onDrop">
		<label for="file-input" class="flex justify-center">
			<span v-if="active">
				<span>Drop Them Here</span>
				<span class="smaller">to add them</span>
			</span>
			<span v-else>
				<span>Drag Your Files Here</span>
				<span class="smaller">
					or <strong><em>click here</em></strong> to select files
				</span>
			</span>
			<input class="hidden" type="file" id="file-input" multiple @change="onInputChange" />
		</label>
		<ul class="image-list" v-show="files.length">
			<FilePreview v-for="file of files" :key="file.id" :file="file" tag="li" @remove="removeFile" />
		</ul>
	</div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue'
import FilePreview from './FilePreview.vue'
const emit = defineEmits(['any-files-update', 'files-updated'])
const props = defineProps({
	filesDefault: { type: Array, default: [] }
})

let active = ref(false)
let inActiveTimeout = null


watch(props.filesDefault, (currentValue, oldValue) => {
	files.value=[];
	addFiles(currentValue)
});

// setActive and setInactive use timeouts, so that when you drag an item over a child element,
// the dragleave event that is fired won't cause a flicker. A few ms should be plenty of
// time to wait for the next dragenter event to clear the timeout and set it back to active.
function setActive() {
	active.value = true
	clearTimeout(inActiveTimeout)
}
function setInactive() {
	inActiveTimeout = setTimeout(() => {
		active.value = false
	}, 50)
}

function onDrop(e) {
	setInactive()
	addFiles([...e.dataTransfer.files])
	emit('files-updated', files)
	emit('any-files-update',true)
	//emit('files-dropped', [...e.dataTransfer.files])
}

function onInputChange(e) {
	addFiles(e.target.files)
	emit('files-updated', e.target.files)
	emit('any-files-update',true)
	e.target.value = null // reset so that selecting the same file again will still cause it to fire this change
}

function preventDefaults(e) {
	e.preventDefault()
}

const events = ['dragenter', 'dragover', 'dragleave', 'drop']

onMounted(() => { 
	events.forEach((eventName) => {
		document.body.addEventListener(eventName, preventDefaults)
	})
})

onUnmounted(() => {
	events.forEach((eventName) => {
		document.body.removeEventListener(eventName, preventDefaults)
	})
})





const files = ref([])
const filesEdit = ref([])
function addFiles(newFiles) {
	//console.log(newFiles);
	if (files.value.length > 0)
		return;
	let newUploadableFiles = [...newFiles].map((file) => new UploadableFile(file)).filter((file) => !fileExists(file.id))
	files.value = files.value.concat(newUploadableFiles)
}

function fileExists(otherId) {
	return files.value.some(({ id }) => id === otherId)
}

function removeFile(file) {
	const index = files.value.indexOf(file)

	if (index > -1) files.value.splice(index, 1)
	emit('any-files-update',true)
}
class UploadableFile {
	constructor(file) {
		this.file = file
		this.id = `${file.name}-${file.size}-${file.lastModified}-${file.type}`
		this.url = URL.createObjectURL(file)
		this.status = null
	}
}


</script>