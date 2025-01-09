<template>
    <main class="flex-1">
        <!-- Page title & actions -->


        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                     Entrevistas Entrega de Cajas
                </h1>
            </div>
            <div class="mt-4 flex sm:mt-0 sm:ml-4" v-if="!showImportar">
                <a :href="route('collections.entrevistas.create')"
                    class="btn-green">Crear</a>
                
            </div>
        </div>

        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

        <div class="px-4 mt-6 sm:px-6 lg:px-8">

            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
                        <div class="">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Filtro</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <button v-if="Object.keys(this.filter).length" class="text-xs font-medium text-gray-500 hover:text-gray-700 mr-2"
                                    @click="clearFilter">Limpiar Filtro</button>
                            <button type="button"
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white" @click="getEntrevistas()">Aplicar
                                Filtro</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 sm:col-span-2 ">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input v-model="filter.name" type="text" name="name" id="name" autocomplete="name-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        
                        <div class="col-span-12 sm:col-span-2 ">
                            <label for="num_documento" class="block text-sm font-medium text-gray-700">NumDoc</label>
                            <input v-model="filter.num_documento" type="text" name="num_documento" id="num_documento"
                                autocomplete="address-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                            <Datepicker class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" v-model="filter.date" range multiCalendars
                                    :closeOnAutoApply="true" :enableTimePicker="false" :format="customFormat"></Datepicker>
                        </div>
                        <div class="col-span-12 sm:col-span-2">
                            <label for="estado_id" class="block text-sm font-medium text-gray-700">Estado</label>
                            <select v-model="filter.estado_id" id="estado_id" name="estado_id"
                                autocomplete="off"
                                class="uppercase mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">TODOS</option>
                                <option v-for="estado in estados" :key="estado.id" :value="estado.id">{{
                                    estado.description
                                }}</option>
                            </select>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="flex flex-col mt-8 mx-4 sm:mx-6 lg:mx-8">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        #
                                    </th>
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
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entrevistador
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs text-center font-medium text-gray-500 uppercase tracking-wider">
                                        <span>Acciones</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="item in entrevistas.data" :key="item.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ item.id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                                        {{ store.dateFormateada(item.fecha) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <div> {{ item.person }} </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <div> {{ item.num_documento }} </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <div class="flex flex-col"> 
                                            <div> {{ item.entrevistador.name }} </div>
                                            <div> {{ item.puntosEntrega.description }} </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <span :class='estadoClass[item.status.nombre]'>{{ item.status.nombre }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm font-medium flex justify-center">
                                        <Menu as="div" class="inline-node">
                                            <div>
                                                <MenuButton class="btn-blue h-7">
                                                    <EllipsisVerticalIcon name="options-vertical"
                                                        class="w-7 h-7 inline-flex items-center bg-blue-100 p-1 rounded-full shadow-sm text-gray-600  hover:bg-blue-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" />
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
                                                    <div class="px-1 py-1 text-left">
                                                        <MenuItem v-slot="{ active }">
                                                        <a :href="route('collections.entrevistas.view', item.id)"
                                                            class="block px-4 py-2 text-sm">
                                                            Detalle</a>
                                                        </MenuItem>
                                                    </div>
                                                    <div class="px-1 py-1 text-left">
                                                        <MenuItem v-slot="{ active }" class="hover:bg-gray-100">
                                                        <a href="#"
                                                            class="block px-4 py-2 text-sm">
                                                            Aprobar</a>
                                                        </MenuItem>

                                                        <MenuItem v-slot="{ active }" class="hover:bg-gray-100">
                                                        <a href="#"
                                                            class="block px-4 py-2 text-sm">
                                                            Rechazar</a>
                                                        </MenuItem>
                                                    </div>
                                                    <div class="px-1 py-1 text-left ">
                                                        <MenuItem v-slot="{ active }" class="hover:bg-gray-100">
                                                        <a href="#"
                                                            class="block px-4 py-2 text-sm">
                                                            Imprimir</a>
                                                        </MenuItem>
                                                    </div>
                                                </MenuItems>
                                            </transition>
                                        </Menu>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <div class="flex justify-between mx-5 my-3 px-2 items-center">
                            <div>
                                Mostrando: {{ this.entrevistas.from }} a {{ this.entrevistas.to }} - Entradas encontradas:
                                {{ this.entrevistas.total }}
                            </div>

                            <div class="flex flex-wrap -mb-1">
                                <template v-for="link in entrevistas.links">
                                    <div v-if="link.url === null"
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded-md"
                                        v-html="link.label"> </div>
                                    <div v-else
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-gray-300 rounded-md hover:bg-blue-500 hover:text-white cursor-pointer"
                                        :class="{ 'bg-blue-500': link.active }, { 'text-white': link.active }"
                                        @click="getEntrevistasPaginate(link.url)" v-html="link.label"> </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>

import { ref } from "vue";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

import {
    ChevronRightIcon,
    EllipsisVerticalIcon,
    PencilSquareIcon,
    ArrowsPointingOutIcon,
    ArrowPathIcon,
    PaperClipIcon
} from "@heroicons/vue/24/solid";
import Toast from "@/Layouts/Components/Toast.vue";
import store from '@/store.js'

const estadoClass = {
    'APROBADA' :  'badgeStatus bg-green-600 text-green-100',
    'PENDIENTE' : 'badgeStatus bg-gray-200 text-gray-800',
    'RECHAZADA' : 'badgeStatus bg-red-600 text-red-100'
}
    
export default {
    props: {
        toast: Object,
        tiposTramite: Object,
        estados: Object,
        users: Object
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
        ArrowPathIcon,
        PaperClipIcon,
        Toast,
        Datepicker
    },
    data() {
        return {
            tramites: "",
            toastMessage: "",
            labelType: "info",
            message: "",
            showToast: false,
            filter: {},
            length: 10,
            customFormat: 'd-M-Y',
            processReport: false,
            showImportar: false,
            entrevistas: [],
            estadoClass: estadoClass
        };
    },
    setup() {
        return {
            store
        }
    },
    methods: {

        async getEntrevistas(){
            const get = `${route('collections.entrevistas.list')}`
            const response = await fetch(get, { method: "GET" });
            this.entrevistas = await response.json();
        },

        clearFilter(){
            this.filter = {}
            this.getEntrevistas()
        },
        clearMessage() {
            this.toastMessage = "";
        },

        async getEntrevistasPaginate(link) {
            var get = `${link}`;
            const response = await fetch(get, { method: 'GET' })
            this.entrevistas = await response.json()
        },


        // async generateReport() {

        //     this.filter.dependencia_id = 12
        //     this.processReport = true
        //     let rt = route("report.exportTramiteExcel");

        //     try {
        //         const response = await axios.post(rt, this.filter, {
        //             responseType: 'blob', // Especifica que esperamos un archivo binario (Blob)
        //         });

        //         // Crear un objeto Blob con la respuesta
        //         const blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

        //         // Crear una URL de objeto para el Blob
        //         const url = window.URL.createObjectURL(blob);

        //         // Crear un enlace <a> para iniciar la descarga
        //         const a = document.createElement('a');
        //         a.href = url;
        //         a.download = 'Resumen de Tramites.xlsx'; // Nombre del archivo
        //         a.style.display = 'none';

        //         // Agregar el enlace al cuerpo del documento y hacer clic en él
        //         document.body.appendChild(a);
        //         a.click();

        //         // Liberar la URL del objeto después de la descarga
        //         window.URL.revokeObjectURL(url);
        //     } catch (error) {
        //         console.error(error);
        //     }
        //     this.processReport = false
        // }
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
        this.getEntrevistas();
    }
};
</script>

<style>

.btn-green{
    @apply inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3
}

.badgeStatus{
    @apply uppercase inline-flex items-center px-2 py-1 border border-transparent shadow-sm text-xs font-medium rounded-md

}
</style>
