<template>
	<div class="w w-full py-8 rounded-md border-dotted border-gray-400 border-2 bg-slate-100 my-4 p-3 text-center"
		@dragenter.prevent="setActive" @dragover.prevent="setActive" @dragleave.prevent="setInactive"
		@drop.prevent="onDrop">
		<label :for="'file-input-' + props.name" class="flex justify-center"
			:class="{ 'hidden': files.length >= props.maxFiles }">
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
			<input class="hidden" type="file" :id="'file-input-' + props.name" multiple @change="onInputChange" />
		</label>
		<ul class="image-list flex justify-center gap-1" v-show="files.length">
			<FilePreview v-for="file of files" :key="file.id" :file="file" tag="li" @remove="removeFile" />
		</ul>
	</div>
</template>

<script setup>
import {
	ref, onMounted, onUnmounted, watch, reactive
} from 'vue'
import FilePreview from './FilePreview.vue'
import helpers from '../../compositions/helpers'


const emit = defineEmits(['any-files-update', 'files-updated'])
const props = defineProps({
	filesDefault: { type: Array, default: [] },
	maxFiles: { type: Number, default: 1 },
	name: { type: String, default: 'images' }
})



let active = ref(false)
let inActiveTimeout = null
let limitReached = ref(false)
let files = reactive([])
const filesEdit = ref([])



watch(props.filesDefault, (urls) => {
	console.log('watch(props.filesDefault');
	console.log('urls: ', urls);
	//files = [];
	files.pop();
	let list = new DataTransfer();
	urls.forEach((url, i) => {
		helpers.getFileFromUrl(url, i + '_name.png')
			.then(file => {
				list.items.add(file);
				//console.log('list.items.add', file);
				console.log('list.files: ', list.files)
				addFiles(list.files)
			})
	})
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

const onDrop = (e) => {
	console.log('onDrop maxFile' + props.maxFiles);
	console.log('e.dataTransfer.files: ', e.dataTransfer.files);
	if (e.target.files.length > props.maxFiles)
		return false;
	setInactive()
	addFiles(e.dataTransfer.files)
	emit('files-updated', files)
	emit('any-files-update', true)
	//emit('files-dropped', [...e.dataTransfer.files])
}

const onInputChange = (e) => {
	console.log('onInputChange maxFile' + props.maxFiles);
	console.log('e.target.files', e.target.files);
	if (!e.target.files.length || (e.target.files.length > props.maxFiles))
		return false;
	addFiles(e.target.files)
	emit('files-updated', files)
	emit('any-files-update', true)
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








function addFiles(newFiles) {
	console.log('addFiles');
	console.log('files.value.length: ', files);
	if (files.length > (props.maxFiles - 1))
		return;
	console.log('files.value.length > (props.maxFiles - 1)');
	console.log('newFiles: ', newFiles);
	let newUploadableFiles = [...newFiles].map((file) => new UploadableFile(file)).filter((file) => !fileExists(file.id))

	newUploadableFiles.forEach((uploadedFile) => {
		files.push(uploadedFile)

	})
	console.log('files.concat(newUploadableFiles)', files, files.length);
}

function fileExists(otherId) {
	return files.some(({ id }) => id === otherId)
}

function removeFile(file) {
	const index = files.indexOf(file)

	if (index > -1) files.splice(index, 1)
	emit('files-updated', files)
	emit('any-files-update', true)
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