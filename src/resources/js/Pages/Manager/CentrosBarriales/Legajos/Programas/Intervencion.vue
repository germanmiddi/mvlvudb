<template>
    <div class="bg-white px-4 py-6 shadow sm:rounded-lg sm:px-6">
        <div class="flex space-x-3">
            <div class="flex-1">
                <div class="sm:flex sm:justify-between sm:items-center">
                    <div>
                        <h3 class="text-base font-medium text-gray-900">{{ intervencion.profesional?.name ?? '-' }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            <time datetime="2020-12-08T18:02:00">{{ store.dateFormateada(intervencion.fecha) }}
                            </time>
                        </p>
                    </div>
                    <Menu as="div" class="mr-2 relative inline-block text-left">
                        <div>
                            <MenuButton
                                class="my-2 rounded-full bg-white flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <span class="sr-only">Open options</span>
                                <Bars4Icon class="h-5 w-5" aria-hidden="true" />
                            </MenuButton>
                        </div>

                        <transition enter-active-class="z-50 transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <MenuItems
                                class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
                                <div class="py-1">
                                    <MenuItem v-slot="{ active }">
                                    <a @click="editIntervencion()"
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
            </div>
        </div>
        <div class="mt-4 space-y-6 text-sm text-gray-800 mb-4 text-justify" v-html="intervencion.description ?? '-'" />

    </div>

    <DeleteModal v-if="showDelete" :id="intervencion.id" :title="`¿Está seguro que desea eliminar la intervención?`"
        @viewDeleted="fnShowDelete" @responseDeleted="fnDelete" />
</template>

<script>

import {
    UserCircleIcon,
    CalendarIcon,
    Bars4Icon,
    ChevronDownIcon,
    TrashIcon,
    PencilSquareIcon,
} from '@heroicons/vue/24/solid'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import store from '@/store.js'
import DeleteModal from '@/Layouts/Components/DeleteModal.vue';

export default {

    props: {
        intervencion: Object
    },
    components: {
        UserCircleIcon,
        CalendarIcon,
        Bars4Icon,
        ChevronDownIcon,
        TrashIcon,
        PencilSquareIcon,
        DeleteModal,
        Menu, MenuButton, MenuItems, MenuItem
    },
    data() {
        return {
            showDetail: Boolean,
            showEditor: Boolean,
            showDelete: false
        }
    },
    setup() {
        return {
            store
        }
    },
    methods: {
        fnShowDelete() {
            this.showDelete = false
        },
        fnDelete() {
            this.showDelete = false
            this.$emit('fnDelete', { 'id': this.intervencion.id })
        },
        editIntervencion() {
            this.$emit('fnEditorIntervencion', { 'action': 'edit_intervencion', 'data': this.intervencion })
        },
    },
}

</script>

<style></style>
