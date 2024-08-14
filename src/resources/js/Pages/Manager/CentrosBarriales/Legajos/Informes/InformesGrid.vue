<template>
    <div class="flex space-x-3">
        <div class="min-w-0 flex-1">
            <h3 class="text-base font-medium text-gray-900">{{ informe.area?.description ?? '-' }} - {{
                informe.profesional?.name ?? '-' }}</h3>
            <p class="text-sm text-gray-500">

                <time datetime="2020-12-08T18:02:00">{{ store.dateTimeFormateada(informe.fecha_informe) }} </time>

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
                        <a @click="editInforme()"
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
                            <TrashIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                            Borrar
                        </a>
                        </MenuItem>
                    </div>
                </MenuItems>
            </transition>
        </Menu>
    </div>
    <div class="mt-4 space-y-6 text-sm text-gray-800 mb-4 text-justify" v-html="informe.description ?? '-'" />

    <DeleteModal :show="showDelete" :id="informe.id" :title="`¿Está seguro que desea eliminar la informe?`"
        @viewDeleted="fnShowDelete" @responseDeleted="fnDelete" />
</template>

<script>

import { Bars4Icon, CalendarIcon, ChevronDownIcon, EllipsisVerticalIcon, HomeIcon, PencilSquareIcon, PhoneIcon, TrashIcon, UserCircleIcon } from '@heroicons/vue/24/solid';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import store from '@/store.js';
import DeleteModal from '@/Layouts/Components/DeleteModal.vue';


export default {

    props: {
        informe: Object
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
        DeleteModal
    },
    data() {
        return {
            showDelete: false
        }
    },
    setup() {
        return {
            store
        }
    },
    methods: {
        editInforme() {
            this.$emit('fnEditor', { 'showEditor': true, 'form': this.informe })
        },
        fnShowDelete() {
            this.showDelete = false
        },
        fnDelete() {
            this.showDelete = false
            this.$emit('fnDelete', { 'id': this.informe.id })
        }
    },
}

</script>

<style></style>
