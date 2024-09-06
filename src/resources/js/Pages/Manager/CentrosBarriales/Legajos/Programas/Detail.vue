<template>
    <div class="bg-white pt-5 pb-2 shadow mt-2 rounded-lg">
        <div class="w-full flex items-center justify-between p-6 space-x-6">
            <div class="flex-1">
                <div class="sm:flex sm:justify-between sm:items-center">
                    <h3 class="text-gray-900 text-base font-medium truncate">{{
                        item.programa_social?.description ?? '-' }}</h3>

                    <Menu as="div" class="mr-2 relative inline-block text-left">
                        <div>
                            <MenuButton
                                class="rounded-full bg-white flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
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
                                class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <div class="py-1">
                                    <MenuItem v-slot="{ active }" v-if="item.estado.id != 1">
                                    <button type="button" @click="updateEstado(1)" 
                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                        <span>Cambiar a Activo</span>
                                    </button>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }" v-if="item.estado.id != 2">
                                    <button type="button" @click="updateEstado(2)"
                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                        <span>Cambiar a Regular</span>
                                    </button>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }" v-if="item.estado.id != 3">
                                    <button type="button" @click="updateEstado(3)"
                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                        <span>Cambiar a No participa</span>
                                    </button>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }" v-if="item.estado.id != 4">
                                    <button type="button" @click="updateEstado(4)"
                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                        <span>Cambiar a Baja</span>
                                    </button>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }" v-if="item.estado.id != 5">
                                    <button type="button" @click="updateEstado(5)"
                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                        <span>Cambiar a Egreso</span>
                                    </button>
                                    </MenuItem>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>

                </div>

                <p class="mt-1 text-gray-500 text-xs truncate">Estado: 
                    <span v-if="item.estado.id === 1" class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 text-xs font-medium bg-green-100 rounded-full">
                        {{ item.estado?.description }}</span>
                    <span v-else class="flex-shrink-0 inline-block px-2 py-0.5 text-red-800 text-xs font-medium bg-red-100 rounded-full">
                        {{ item.estado?.description }}</span>
                    
                    </p>
                <div class="mt-3">
                    <div class="flex text-sm">
                        <UserCircleIcon class="w-5 text-gray-300" /> <span class="ml-2">{{
                            store.capitalize(item?.profesional?.name ?? '-') }}</span>
                    </div>
                    <div class="flex text-sm mt-1">
                        <CalendarIcon class="w-5 text-gray-300" /><span class="ml-2">{{
                            store.dateTimeFormateada(item?.fecha_inscripcion) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {
    UserCircleIcon,
    CalendarIcon,
    PencilSquareIcon, Bars4Icon
} from '@heroicons/vue/24/solid'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import store from '@/store.js'

export default {

    props: {
        item: Object
    },
    components: {
        UserCircleIcon,
        CalendarIcon, Bars4Icon,
        PencilSquareIcon, Menu, MenuButton, MenuItems, MenuItem
    },
    data() {
        return {
            editData: false
        }
    },
    setup() {
        return {
            store
        }
    },
    methods: {
        updateEstado(id){
            this.$emit('updateEstadoPrograma',{id: this.item.id, estado_id:id})
        }
    },
}

</script>

<style></style>
