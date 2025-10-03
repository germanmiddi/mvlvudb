<template>
    <TransitionRoot as="template" :show="show">
        <Dialog as="div" class="relative z-10" @close="closeModal">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                            <div>
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-orange-100">
                                    <ExclamationTriangleIcon class="h-6 w-6 text-orange-600" aria-hidden="true" />
                                </div>
                                <div class="mt-3 text-center sm:mt-5">
                                    <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                        Suspender Entrevista
                                    </DialogTitle>
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-500 mb-4">
                                            Seleccione el motivo de la suspensión:
                                        </p>
                                        <select v-model="selectedMotivo"
                                            class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-orange-500 focus:outline-none focus:ring-orange-500 sm:text-sm">
                                            <option value="">Seleccione un motivo</option>
                                            <option v-for="motivo in motivos" :key="motivo.id" :value="motivo.id">
                                                {{ motivo.description }}
                                            </option>
                                        </select>
                                        <p v-if="errorMessage" class="mt-2 text-sm text-red-600">{{ errorMessage }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                                <button type="button"
                                    class="inline-flex w-full justify-center rounded-md border border-transparent bg-orange-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 sm:col-start-2 sm:text-sm"
                                    @click="confirmSuspension">
                                    Suspender
                                </button>
                                <button type="button"
                                    class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:col-start-1 sm:mt-0 sm:text-sm"
                                    @click="closeModal" ref="cancelButtonRef">
                                    Cancelar
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'

export default {
    components: {
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        ExclamationTriangleIcon,
    },

    props: {
        show: {
            type: Boolean,
            required: true,
        },
        motivos: {
            type: Array,
            default: () => [],
        },
    },

    data() {
        return {
            selectedMotivo: '',
            errorMessage: '',
        }
    },

    watch: {
        show(newVal) {
            if (newVal) {
                this.selectedMotivo = ''
                this.errorMessage = ''
            }
        }
    },

    methods: {
        confirmSuspension() {
            if (!this.selectedMotivo) {
                this.errorMessage = 'Debe seleccionar un motivo de suspensión'
                return
            }
            this.$emit('confirm', this.selectedMotivo)
            this.closeModal()
        },

        closeModal() {
            this.$emit('close')
        },
    },
}
</script>

