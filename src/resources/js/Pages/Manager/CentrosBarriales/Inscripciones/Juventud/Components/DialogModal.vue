<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <TransitionRoot as="template" :show="show">
        <Dialog as="div" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                    enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <TransitionChild as="template" enter="ease-out duration-300"
                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                    leave-from="opacity-100 translate-y-0 sm:scale-100"
                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-10 sm:px-7 ">
                            <div class="sm:flex sm:items-start">
                                <!-- <div
                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                </div> -->
                                <component :is="iconModal[type]" class="h-12 w-12" :class="colorIconModal[type]" aria-hidden="true" />
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> {{ title }} </DialogTitle>
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-500">{{ message }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button"
                                :class="typeModal[type]"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium  focus:outline-none focus:ring-2 focus:ring-offset-2  sm:ml-3 sm:w-auto sm:text-sm"
                                @click="confirm">Si, Confirmar</button>
                            <button type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                @click="closeModal" ref="cancelButtonRef">Cancelar</button>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import { ref } from 'vue'
import { Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'

const typeModal = 
{
    'confirm' : 'bg-blue-500 text-white focus:ring-blue-500 hover:bg-blue-600',
    'warning' : 'bg-yellow-500',
    'error'   : 'bg-red-600 text-white focus:ring-red-500 hover:bg-red-700'
}

const iconModal = 
{
    'confirm' : 'ExclamationTriangleIcon',
    'warning' : 'ExclamationTriangleIcon',
    'error' : 'ExclamationTriangleIcon'
}

const colorIconModal = 
{
    'confirm' : 'text-blue-500',
    'warning' : 'text-yellow-500',
    'error' : 'text-red-600'
}

export default {
    props: {
        show: Boolean,
        title: String,
        message: String,
        type: String
    },
    components: {
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        ExclamationTriangleIcon,
    },
    setup() {
        const open = ref(true)

        return {
            open,
        }
    },
    data() {
        return {
            typeModal: typeModal,
            iconModal: iconModal,
            colorIconModal: colorIconModal
        }
    },
    methods: {
        confirm() {
            this.$emit('confirmModal')
        },
        closeModal() {
            this.$emit('closeModal');
        }
    }
}
</script>