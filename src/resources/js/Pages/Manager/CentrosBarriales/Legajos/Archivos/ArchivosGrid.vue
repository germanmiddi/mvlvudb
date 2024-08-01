<template>
    <div class="flex space-x-3">
        <div class="min-w-0 flex-1">
            <h3 class="text-base font-medium text-gray-900">{{ archivo.description ?? '-' }}</h3>
            <h3 class="text-sm text-gray-900">Area: {{ archivo.area?.description ?? '-' }}</h3>
            <p class="text-sm text-gray-500">

            <time datetime="2020-12-08T18:02:00">{{ store.dateTimeFormateada(archivo.created_at)}} </time>

            </p>
        </div>
        <Menu as="div" class="relative inline-block text-left">
            <div>
                <!-- <MenuButton class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"> -->
                    <MenuButton class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Opciones
                    <ChevronDownIcon class="-mr-1 ml-2 h-5 w-5" aria-hidden="true" />
                </MenuButton>
            </div>

            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                <MenuItems class="z-50 origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
                    <div class="py-1">
                    <MenuItem v-slot="{ active }">
                        <a :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']"
                        :href="'/file/download/' + archivo.id +'/legajo'" target="_blank" title="Descargar Archivo">
                        <DocumentArrowDownIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                        Descargar
                        </a>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                        <a :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']"
                        :href="'/file/render/' + archivo.id +'/legajo'" target="_blank" title="Descargar Archivo">
                        <DocumentIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                        Ver Archivo
                        </a>
                    </MenuItem>
                    </div>
                    <div class="py-1">
                    <MenuItem v-slot="{ active }">
                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                        <TrashIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                        Borrar
                        </a>
                    </MenuItem>
                    </div>
                </MenuItems>
            </transition>
        </Menu>
        </div>
    <!-- <div class="mt-4 space-y-6 text-sm text-gray-800 mb-4" v-html="informe.description ?? '-'" /> -->
</template>

<script>

import { Bars4Icon, CalendarIcon, ChevronDownIcon, EllipsisVerticalIcon, HomeIcon, PencilSquareIcon, DocumentArrowDownIcon, TrashIcon, UserCircleIcon, DocumentIcon } from '@heroicons/vue/24/solid';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import store from '@/store.js';


export default {

    props: {
        archivo: Object
    },
    components: {
        UserCircleIcon,
        CalendarIcon,
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        DocumentArrowDownIcon,
        Bars4Icon,
        HomeIcon,
        EllipsisVerticalIcon,
        ChevronDownIcon,
        TrashIcon,
        PencilSquareIcon,
        DocumentIcon
    },
    data() {
        return {
            showDetail: Boolean,
            showEditor: Boolean
        }
    },
    setup() {
        return {
            store
        }
    },
    methods: {
        fnIntervencion(data){
            this.showDetail = true
            this.showEditor = true
            this.$emit('fnEditor', {'showDetail' : this.showDetail, 'showEditor' : this.showEditor, 'programa' : data})
        },
        fnDetails(data){
            this.showDetail = true
            this.showEditor = false
            this.$emit('fnEditor', {'showDetail' : this.showDetail, 'showEditor' : this.showEditor, 'programa' : data})
        }
    },
}

</script>

<style>

</style>
