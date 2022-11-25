<template>
    <vue-final-modal v-slot="{ params, close }" v-bind="$attrs" classes="flex justify-center items-center"
        content-class="relative flex flex-col max-h-full mx-4 p-4 border dark:border-gray-800 rounded bg-white dark:bg-gray-900 min-w-full">
        <span class="mr-8 text-2xl font-bold">
            <slot name="title"></slot>
        </span>
        <div class="flex-grow overflow-y-auto">
            <slot :params="params"></slot>
        </div>
        
        <button class="absolute top-0 right-0 mt-2 mr-2 px-3 py-1 bg-green-500 block w-fit rounded-sm text-white" @click="close" type="button">
                Close
            </button>
        
    </vue-final-modal>
</template>
<script>
//import { $vfm, VueFinalModal, ModalsContainer } from 'vue-final-modal'
export default {
    name: 'CustomModal',
    inheritAttrs: false,
    emits: ['cancel', 'confirm']
}
</script>