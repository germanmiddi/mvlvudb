<template>
    <main class="flex-1">
        <!-- Page title & actions -->
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Padrón Inscriptos a Entrega de Cajas
                </h1>
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
                            <button v-if="Object.keys(this.filter).length"
                                class="text-xs font-medium text-gray-500 hover:text-gray-700 mr-2"
                                @click="clearFilter">Limpiar Filtro</button>
                            <button type="button"
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                                @click="getList()">Aplicar
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
                            <label for="num_documento" class="block text-sm font-medium text-gray-700">Documento</label>
                            <input v-model="filter.num_documento" type="text" name="num_documento" id="num_documento"
                                autocomplete="address-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                            <Datepicker
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                v-model="filter.date" range multiCalendars :closeOnAutoApply="true"
                                :enableTimePicker="false" :format="customFormat"></Datepicker>
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                            <label for="punto_entrega_id" class="block text-sm font-medium text-gray-700">Sede</label>
                            <select v-model="filter.punto_entrega_id" name="punto_entrega_id" id="punto_entrega_id"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="" selected>Selecciones una sede</option>
                                <option v-for="sede in sedes" :key="sede.id" :value="sede.id">{{ sede.description }}
                                </option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                            <label for="entrevistador_id"
                                class="block text-sm font-medium text-gray-700">Entrevistador</label>
                            <select v-model="filter.entrevistador_id" name="entrevistador_id" id="entrevistador_id"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="" selected>Selecciones un entrevistador</option>
                                <option v-for="entrevistador in entrevistadores" :key="entrevistador.id"
                                    :value="entrevistador.id">{{ entrevistador.name }}</option>
                            </select>
                        </div>
                        <!-- <div class="col-span-12 sm:col-span-2">
                            <label for="estado_id" class="block text-sm font-medium text-gray-700">Estado</label>
                            <select v-model="filter.estado_id" id="estado_id" name="estado_id" autocomplete="off"
                                class="uppercase mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">TODOS</option>
                                <option v-for="estado in estados" :key="estado.id" :value="estado.id">{{
                                    estado.description
                                }}</option>
                            </select>
                        </div> -->
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
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Entrevistador
                                    </th>

                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs text-center font-medium text-gray-500 uppercase tracking-wider">
                                        <span>Acciones</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <ListItem v-for="item in list.data" :key="item.id" :item="item"></ListItem>
                            </tbody>
                        </table>
                        <hr>
                        <div class="flex justify-between mx-5 my-3 px-2 items-center">
                            <div>
                                Mostrando: {{ this.list.from }} a {{ this.list.to }} - Entradas encontradas:
                                {{ this.list.total }}
                            </div>

                            <div class="flex flex-wrap -mb-1">
                                <template v-for="link in list.links">
                                    <div v-if="link.url === null"
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded-md"
                                        v-html="link.label"> </div>
                                    <div v-else
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-gray-300 rounded-md hover:bg-blue-500 hover:text-white cursor-pointer"
                                        :class="{ 'bg-blue-500': link.active }, { 'text-white': link.active }"
                                        @click="getListPaginate(link.url)" v-html="link.label"> </div>
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
import ListItem from './ListItem.vue'

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

export default {
    props: {
        toast: Object,
        sedes: Object,
        entrevistadores: Object
    },
    components: {
        ListItem,
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
            toastMessage: "",
            labelType: "info",
            message: "",
            showToast: false,

            filter: {},
            length: 10,
            customFormat: 'd-M-Y',
            list: [],
        };
    },
    setup() {
        return {
            store
        }
    },
    methods: {

        async getList() {

            let filter = `&length=${this.length}`

            if (this.filter.name) {
                filter += `&name=${this.filter.name}`
            }
            if (this.filter.num_documento) {
                filter += `&num_documento=${this.filter.num_documento}`
            }
            if (this.filter.date) {
                filter += `&date=${JSON.stringify(this.filter.date)}`
            }
            if (this.filter.punto_entrega_id) {
                filter += `&punto_entrega_id=${this.filter.punto_entrega_id}`
            }

            if (this.filter.entrevistador_id) {
                filter += `&entrevistador_id=${this.filter.entrevistador_id}`
            }

            const get = `${route('collections.padron.list')}?${filter}`
            const response = await fetch(get, { method: "GET" });
            this.list = await response.json();
        },

        clearFilter() {
            this.filter = {}
            this.getList()
        },
        clearMessage() {
            this.toastMessage = "";
        },

        async getListPaginate(link) {
            var get = `${link}`;
            const response = await fetch(get, { method: 'GET' })
            this.list = await response.json()
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
        this.getList();
    }
};
</script>

<style>
.btn-green {
    @apply inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3
}

.badgeStatus {
    @apply uppercase inline-flex items-center px-2 py-1 border border-transparent shadow-sm text-xs font-medium rounded-md
}
</style>
