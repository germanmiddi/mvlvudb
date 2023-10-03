<template>
    <main class="flex-1">
        <!-- Page title & actions -->
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Reporte General
                </h1>
            </div>
            <div class="mt-4 flex sm:mt-0 sm:ml-4" v-if="!processReport">
                <!-- <button type="button" class="order-1 ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:order-0 sm:ml-0">Share</button> -->
                <a @click="generateReport()"
                    class="border-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Generar
                    Reporte</a>
            </div>
            <div class="mt-4 flex sm:mt-0 sm:ml-4" v-else>
                <!-- <button type="button" class="order-1 ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:order-0 sm:ml-0">Share</button> -->
                <a
                    class="border-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">
                    <ArrowPathIcon class="h-5 w-5 text-red-500 animate-spin mr-2" /> Procesando...</a>
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
                        <div class="flex-shrink-0 flex item-center">
                            <button v-if="Object.keys(this.filter).length"
                                class="text-xs font-medium text-gray-500 hover:text-gray-700 mr-2"
                                @click="clearFilter">Limpiar Filtro</button>
                            <button type="button"
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                                @click="getRegister()">Aplicar Filtro</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 sm:col-span-3">
                            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                            <Datepicker
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                v-model="filter.date" range multiCalendars :closeOnAutoApply="true"
                                :enableTimePicker="false" :format="customFormat"></Datepicker>
                        </div>

                        <div class="col-span-12 sm:col-span-4">
                            <label for="dependencia_id" class="block text-sm font-medium text-gray-700">Dependencia</label>
                            <select v-model="filter.dependencia_id" id="dependencia_id" name="dependencia_id"
                                @change="filtrarTiposTramite" autocomplete="off"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" selected>Selecciones una dependencia</option>
                                <option v-for="dependencia in dependencias" :key="dependencia.id" :value="dependencia.id">{{
                                    dependencia.description
                                }}</option>
                            </select>
                        </div>

                        <div class="col-span-12 sm:col-span-4">
                            <label for="tipo_tramite_id" class="block text-sm font-medium text-gray-700">Tipo de
                                Tramite</label>
                            <select v-model="filter.tipo_tramite_id" id="tipo_tramite_id" name="tipo_tramite_id"
                                autocomplete="tipo_tramite_id_name"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" selected>Selecciones un tipo de tramite</option>
                                <option v-for="tipoTramite in tiposTramiteFiltrados" :key="tipoTramite.id"
                                    :value="tipoTramite.id">{{
                                        tipoTramite.description
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
                        <ul role="list" class="divide-y divide-gray-100 w-2/5">
                            <li class="flex justify-between gap-x-6 py-5 ml-8">
                                <div class="flex min-w-0 gap-x-4">
                                    <!--  <img class="h-12 w-12 flex-none rounded-full bg-gray-50"  alt="" /> -->
                                    <DocumentChartBarIcon class="h-12 w-12 flex-none rounded-full bg-gray-50" />
                                    <div class="min-w-0 flex-auto">
                                        <p class="text-sm font-semibold leading-6 text-gray-900">Resumen de Total de
                                            Tramites</p>
                                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ this.registers }}</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
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
    ArrowPathIcon
} from "@heroicons/vue/24/solid";
import { DocumentChartBarIcon } from '@heroicons/vue/24/outline'
import Toast from "@/Layouts/Components/Toast.vue";

import store from '@/store.js'

export default {
    props: {
        toast: Object,
        tiposTramite: Object,
        dependencias: Object
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
        DocumentChartBarIcon,
        ArrowPathIcon,
        Toast,
        Datepicker
    },
    data() {
        return {
            registers: "",
            toastMessage: "",
            labelType: "info",
            message: "",
            showToast: false,
            showCreate: false,
            filter: {},
            customFormat: 'd-M-Y',
            tiposTramiteFiltrados: this.tiposTramite,
            dependencia_id: '',
            processReport: false
        };
    },
    setup() {
        return {
            store
        }
    },
    methods: {
        clearFilter() {
            this.filter = {}
            this.tiposTramiteFiltrados = this.tiposTramite
            this.getRegister()
        },

        filtrarTiposTramite() {
            if (this.filter.dependencia_id) {
                // Filtra los tipos de trámite según la dependencia seleccionada
                this.tiposTramiteFiltrados = this.tiposTramite.filter((tipoTramite) => tipoTramite.dependencia_id === this.filter.dependencia_id);
            } else {
                // Si no se selecciona una dependencia, muestra todos los tipos de trámite
                this.tiposTramiteFiltrados = this.tiposTramite;
            }
        },

        clearMessage() {
            this.toastMessage = "";
        },

        async getRegister() {
            this.registers = ''
            let filter = ''

            if (this.filter.date) {
                filter += `&date=${JSON.stringify(this.filter.date)}`
            }

            if (this.filter.tipo_tramite_id) {
                filter += `&tipo_tramite_id=${JSON.stringify(this.filter.tipo_tramite_id)}`
            }

            if (this.filter.dependencia_id) {
                filter += `&dependencia_id=${JSON.stringify(this.filter.dependencia_id)}`
            }

            const get = `${route('report.summary')}?${filter}`

            const response = await fetch(get, { method: "GET" });
            this.registers = await response.json();
        },
        async generateReport() {

            this.processReport = true
            let rt = route("report.exportTramiteExcel");

            try {
                const response = await axios.post(rt, this.filter, {
                    responseType: 'blob', // Especifica que esperamos un archivo binario (Blob)
                });

                // Crear un objeto Blob con la respuesta
                const blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

                // Crear una URL de objeto para el Blob
                const url = window.URL.createObjectURL(blob);

                // Crear un enlace <a> para iniciar la descarga
                const a = document.createElement('a');
                a.href = url;
                a.download = 'Resumen de Tramites.xlsx'; // Nombre del archivo
                a.style.display = 'none';

                // Agregar el enlace al cuerpo del documento y hacer clic en él
                document.body.appendChild(a);
                a.click();

                // Liberar la URL del objeto después de la descarga
                window.URL.revokeObjectURL(url);
            } catch (error) {
                console.error(error);
            }
            this.processReport = false
        }
    },
    computed: {
        createDependencia: function () {
            return this.dependencias.filter(dependencia => (dependencia.id != 1 && dependencia.id != 3 && dependencia.id != 4 && dependencia.id != 10))
        }
    },
    mounted() {
        this.getRegister();
    },
};
</script>

<style></style>
