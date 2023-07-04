<template>
    <main class="flex-1">
        <!-- Page title & actions -->
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Bandeja General de Género y Diversidad
                </h1>
            </div>
            <div class="mt-4 flex sm:mt-0 sm:ml-4">
                <!-- <button type="button" class="order-1 ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:order-0 sm:ml-0">Share</button> -->
                <a :href="route('genero.create')"
                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Crear</a>
            </div>
        </div>

        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

        <div class="flex flex-col mt-8 mx-4 sm:mx-6 lg:mx-8">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        DNI
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rol
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tramite
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs text-center font-medium text-gray-500 uppercase tracking-wider">
                                        <span>Acciones</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="data in tramites.data" :key="data.tramite.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ data.tramite.fecha }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ data.tramite.persons[0].lastname }},
                                        {{ data.tramite.persons[0].name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{
                                            data.tramite.persons[0]
                                                .num_documento
                                        }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{
                                            data.tramite.rol_tramite[0]
                                                .description
                                        }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{
                                            data.tramite.tipo_tramite
                                                .description
                                        }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm font-medium">
                                        <!-- <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                            <PencilSquareIcon class="w-5 h-5 text-purple-700 mr-2" />
                                        </a> -->
                                        <Menu as="div" class="inline-node">
                                            <div>
                                                <MenuButton class="btn-blue h-7">
                                                    <EllipsisVerticalIcon name="options-vertical"
                                                        class="w-7 h-7 inline-flex items-center bg-blue-100 p-1 rounded-full shadow-sm text-gray-600 hover:bg-blue-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" />
                                                </MenuButton>
                                            </div>
                                            <transition enter-active-class="transition ease-out duration-100"
                                                enter-from-class="transform opacity-0 scale-95"
                                                enter-to-class="transform opacity-100 scale-100"
                                                leave-active-class="transition ease-in duration-75"
                                                leave-from-class="transform opacity-100 scale-100"
                                                leave-to-class="transform opacity-0 scale-95">
                                                <MenuItems
                                                    class="origin-top-left absolute z-50 right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
                                                    <div class="py-1 text-left">
                                                        <MenuItem v-slot="{ active }">
                                                        <a :href="route(
                                                            'genero.edit',
                                                            data
                                                                .tramite
                                                                .id
                                                        )
                                                            " class="block px-4 py-2 text-sm">
                                                            Editar</a>
                                                        </MenuItem>

                                                        <MenuItem v-slot="{ active }">
                                                        <a href="#" class="block px-4 py-2 text-sm">
                                                            Ver</a>
                                                        </MenuItem>
                                                        <MenuItem v-slot="{ active }">
                                                        <a :href="route(
                                                            'pdf.acusepdf',
                                                            data
                                                                .tramite
                                                                .id
                                                        )
                                                            " target="_blank" class="block px-4 py-2 text-sm">
                                                            Imprimir</a>
                                                        </MenuItem>
                                                    </div>

                                                    <!--  <div class="py-1 text-left">
                                                    <MenuItem v-slot="{ active }">
                                                    <a href="#" @click="createInvoice(order.order)"
                                                        :class="[(active ? 'bg-gray-100 text-gray-900 ' : 'text-gray-700 hover:bg-gray-50', 'block px-4 py-2 text-sm'),
                                                        (order.bill_status != 'finished' ? 'hover:bg-blue-200' : 'pointer-events-none text-gray-400')]">
                                                        Emitir Factura</a>
                                                    </MenuItem>
                                                </div>

                                                -->
                                                </MenuItems>
                                            </transition>
                                        </Menu>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import { ref } from "vue";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";

import {
    ChevronRightIcon,
    EllipsisVerticalIcon,
    PencilSquareIcon,
    ArrowsPointingOutIcon
} from "@heroicons/vue/24/solid";
import Toast from "@/Layouts/Components/Toast.vue";

export default {
    props: {
        toast: Object,
    },
    components: {
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        EllipsisVerticalIcon,
        ChevronRightIcon,
        PencilSquareIcon,
        ArrowsPointingOutIcon,
        Toast,
    },
    data() {
        return {
            tramites: "",
            toastMessage: "",
            labelType: "info",
            message: "",
            showToast: false,
        };
    },
    setup() {
        const sidebarOpen = ref(false);

        return {};
    },
    methods: {
        clearMessage() {
            this.toastMessage = "";
        },
        async getTramites() {
            const get = `${route("genero.list")}`;

            const response = await fetch(get, { method: "GET" });
            this.tramites = await response.json();
        },
    },
    mounted() {
        if (this.toast) {
            if (this.toast["status"] == 200) {
                this.labelType = "success";
                this.toastMessage = this.toast["message"];
            } else {
                this.labelType = "danger";
                this.toastMessage = this.toast["message"];
            }
        }
        this.getTramites();
    },
};
</script>

<style></style>
