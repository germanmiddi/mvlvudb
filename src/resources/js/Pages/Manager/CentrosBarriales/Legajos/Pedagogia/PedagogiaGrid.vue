<template>
    <div class="flex space-x-3">
        <div class="min-w-0 flex-1">
            <span class="px-3 py-1 text-xxl font-semibold rounded-full" :class="{
                'text-green-700 bg-green-100': pedagogia.estado_id === 1,
                'text-yellow-700 bg-yellow-100': pedagogia.estado_id === 2,
                'text-gray-700 bg-gray-200': pedagogia.estado_id === 3
            }">
                {{ pedagogia.estado?.description ?? '-' }}
            </span>
            <p class="pl-3 pt-3 text-sm text-gray-500">

                <time datetime="2020-12-08T18:02:00">{{ store.dateTimeFormateada(pedagogia.fecha_prueba) }} </time>

            </p>
        </div>
        <Menu as="div" class="relative inline-block text-left">
            <div>
                <!-- <MenuButton class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"> -->
                <MenuButton
                    class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Opciones
                    <ChevronDownIcon class="-mr-1 ml-2 h-5 w-5" aria-hidden="true" />
                </MenuButton>
            </div>

            <transition enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95">
                <MenuItems
                    class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
                    <div class="py-1">
                        <MenuItem v-slot="{ active }">
                        <a @click="showDetail = true"
                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                            <EyeIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                            Detalle
                        </a>
                        </MenuItem>
                    </div>
                    <div class="py-1">
                        <MenuItem v-slot="{ active }">
                        <a @click="editPedagogia()"
                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                            <PencilSquareIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                aria-hidden="true" />
                            Editar
                        </a>
                        </MenuItem>
                    </div>
                    <div class="py-1">
                        <MenuItem v-slot="{ active }">
                        <a @click="showDelete = true"
                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                            <TrashIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                aria-hidden="true" />
                            Borrar
                        </a>
                        </MenuItem>
                    </div>
                </MenuItems>
            </transition>
        </Menu>
    </div>
    <div class="pl-3 mt-4 space-y-6 text-sm text-gray-800 mb-4 text-justify">
        <strong>Profesional:</strong> {{ pedagogia.profesional ?? '-' }}
    </div>

    <div class="pl-3 mt-4 space-y-2 text-sm text-gray-800 mb-4 text-justify">
        <strong>Detalles:</strong>
        <div class="text-gray-900 overflow-hidden text-ellipsis"
            style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"
            v-html="pedagogia.detalles ?? '-'">
        </div>
    </div>

    <DeleteModal v-if="showDelete" :id="pedagogia.id" :title="`¿Está seguro que desea eliminar la prueba Pedagógica?`"
        @viewDeleted="fnShowDelete" @responseDeleted="fnDelete" />

    <transition name="fade">
        <div v-if="showDetail" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            @keydown.esc="showDetail = false" tabindex="0">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl max-h-[80vh] relative overflow-hidden">

                <button @click="showDetail = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                    <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>cerrar</title>
                        <path fill="currentColor"
                            d="M13.46,12L19,17.54V19H17.54L12,13.46L6.46,19H5V17.54L10.54,12L5,6.46V5H6.46L12,10.54L17.54,5H19V6.46L13.46,12Z" />
                    </svg>
                </button>

                <h2 class="text-lg font-semibold mb-4">Detalles de Pedagogía</h2>

                <div class="space-y-4 overflow-auto max-h-[60vh] px-2">
                    <div>
                        <strong class="block text-gray-700">Profesional:</strong>
                        <p class="text-gray-900">{{ pedagogia.profesional ?? '-' }}</p>
                    </div>
                    <div>
                        <strong class="block text-gray-700">Fecha de Prueba:</strong>
                        <p class="text-gray-900">{{ store.dateTimeFormateada(pedagogia.fecha_prueba) }}</p>
                    </div>
                    <div>
                        <strong class="block text-gray-700">Detalles:</strong>
                        <div class="text-gray-900" v-html="pedagogia.detalles ?? '-'"></div>
                    </div>
                    <div>
                        <strong class="block text-gray-700">Estado:</strong>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full" :class="{
                            'text-green-700 bg-green-100': pedagogia.estado_id === 1,
                            'text-yellow-700 bg-yellow-100': pedagogia.estado_id === 2,
                            'text-gray-700 bg-gray-200': pedagogia.estado_id === 3
                        }">
                            {{ pedagogia.estado?.description ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>

import { Bars4Icon, CalendarIcon, ChevronDownIcon, EllipsisVerticalIcon, HomeIcon, PencilSquareIcon, PhoneIcon, TrashIcon, UserCircleIcon, EyeIcon } from '@heroicons/vue/24/solid';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import store from '@/store.js';
import DeleteModal from '@/Layouts/Components/DeleteModal.vue';


export default {

    props: {
        pedagogia: Object
    },
    components: {
        UserCircleIcon,
        CalendarIcon,
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        PhoneIcon,
        Bars4Icon,
        HomeIcon,
        EllipsisVerticalIcon,
        ChevronDownIcon,
        TrashIcon,
        PencilSquareIcon,
        DeleteModal,
        EyeIcon,
    },
    data() {
        return {
            showDelete: false,
            showDetail: false,
        }
    },
    setup() {
        return {
            store
        }
    },
    methods: {
        editPedagogia() {
            this.$emit('fnEditor', { 'showEditor': true, 'form': this.pedagogia })
        },
        fnShowDelete() {
            this.showDelete = false
        },
        fnDelete() {
            this.showDelete = false
            this.$emit('fnDelete', { 'id': this.pedagogia.id })
        }
    },
}

</script>

<style></style>
