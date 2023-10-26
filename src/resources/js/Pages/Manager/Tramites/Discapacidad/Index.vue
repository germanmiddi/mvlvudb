<template>
    <main class="flex-1">
        <!-- Page title & actions -->
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Bandeja General de Discapacidad
                </h1>
            </div>
            <div class="mt-4 flex sm:mt-0 sm:ml-4">
                <a  :href="route('discapacidad.create')"
                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Crear</a>
                
                <a  @click="generateReport()" v-if="!processReport"
                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Exportar</a>

                <a v-else
                    class="border-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"><ArrowPathIcon class="h-5 w-5 text-red-500 animate-spin mr-2" /> Procesando...</a>
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
                            <button type="button"
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white" @click="getTramites()">Aplicar
                                Filtro</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 sm:col-span-1 ">
                            <label for="tramite_id" class="block text-sm font-medium text-gray-700">N° Tramite</label>
                            <input v-model="filter.tramite_id" type="number" name="tramite_id" id="tramite_id" autocomplete="name-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <div class="col-span-12 sm:col-span-2 ">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input v-model="filter.name" type="text" name="name" id="name" autocomplete="name-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        
                        <div class="col-span-12 sm:col-span-2 ">
                            <label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de
                                Documento</label>
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
                        <div class="col-span-12 sm:col-span-2">
                            <label for="tipo_tramite_id" class="block text-sm font-medium text-gray-700">Tipo de
                                Tramite</label>
                            <select v-model="filter.tipo_tramite_id" id="tipo_tramite_id" name="tipo_tramite_id"
                                autocomplete="tipo_tramite_id_name"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" selected>Selecciones un tipo de tramite</option>
                                <option v-for="tipoTramite in tiposTramite" :key="tipoTramite.id" :value="tipoTramite.id">{{
                                    tipoTramite.description
                                }}</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-2">
                            <label for="asiggned_me" class="block text-sm font-medium text-gray-700">Asignados solo a mi</label>
                            <input v-model="filter.assigned_me" id="asiggned_me" type="checkbox" value="2" class="w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
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
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-l-8 border-gray-500">
                                        N° Tramite
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" :class="data.tramite.estado_id == 2 ? 'border-l-8 border-green-500' : data.tramite.estado_id == 3 ? 'border-l-8 border-purple-500' : 'border-l-8 border-red-500' ">
                                        {{ data.tramite.id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ store.dateFormateada(data.tramite.fecha) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div v-html=" namePersons(data.tramite.persons) "></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div v-html=" dniPersons(data.tramite.persons) "></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ data.tramite.tipo_tramite.description }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm font-medium">
                                        <!-- <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                            <PencilSquareIcon class="w-5 h-5 text-purple-700 mr-2" />
                                        </a> -->
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
                                                    <div class="py-1 text-left">
                                                        
                                                        <MenuItem v-slot="{ active }">
                                                        <a :href="route('discapacidad.edit', data.tramite.id)"
                                                            class="block px-4 py-2 text-sm">
                                                            Editar</a>
                                                        </MenuItem>

                                                        <MenuItem v-slot="{ active }">
                                                        <a :href="route('detail.view', data.tramite.id)"
                                                            class="block px-4 py-2 text-sm">
                                                            Detalle</a>
                                                        </MenuItem>

                                                        <!-- <MenuItem v-slot="{ active }">
                                                        <a href="#" class="block px-4 py-2 text-sm">
                                                            Ver</a>
                                                        </MenuItem> -->
                                                        
                                                        <MenuItem v-slot="{ active }">
                                                        <a :href="route('pdf.acusepdf', data.tramite.id)" target="_blank"
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
                                Mostrando: {{ this.tramites.from }} a {{ this.tramites.to }} - Entradas encontradas:
                                {{ this.tramites.total }}
                            </div>

                            <div class="flex flex-wrap -mb-1">
                                <template v-for="link in tramites.links">
                                    <div v-if="link.url === null"
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded-md"
                                        v-html="link.label"> </div>
                                    <div v-else
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-gray-300 rounded-md hover:bg-blue-500 hover:text-white cursor-pointer"
                                        :class="{ 'bg-blue-500': link.active }, { 'text-white': link.active }"
                                        @click="getTramitesPaginate(link.url)" v-html="link.label"> </div>
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
    UserCircleIcon,
    ArrowPathIcon
} from "@heroicons/vue/24/solid";
import Toast from "@/Layouts/Components/Toast.vue";
import store from '@/store.js'

export default {
    props: {
        toast: Object,
        tiposTramite: Object,
        estados: Object
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
        UserCircleIcon,
        ArrowPathIcon,
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
            processReport: false
        };
    },
    setup() {
        return {
            store
        }
    },
    methods: {
        clearMessage() {
            this.toastMessage = "";
        },
        async getTramites() {
            this.tramites = ''
            let filter = `&length=${this.length}`

            if (this.filter.tramite_id) {
                filter += `&tramite_id=${JSON.stringify(this.filter.tramite_id)}`
            }

            if (this.filter.assigned_me) {
                filter += `&assigned_me=${JSON.stringify(this.filter.assigned_me)}`
            }

            if (this.filter.name) {
                filter += `&name=${JSON.stringify(this.filter.name)}`
            }

            if (this.filter.num_documento) {
                filter += `&num_documento=${JSON.stringify(this.filter.num_documento)}`
            }

            if (this.filter.date) {
                filter += `&date=${JSON.stringify(this.filter.date)}`
            }

            if (this.filter.estado_id) {
                filter += `&estado_id=${JSON.stringify(this.filter.estado_id)}`
            }

            if (this.filter.tipo_tramite_id) {
                filter += `&tipo_tramite_id=${JSON.stringify(this.filter.tipo_tramite_id)}`
            }

            const get = `${route('discapacidad.list')}?${filter}`

            const response = await fetch(get, { method: "GET" });
            this.tramites = await response.json();
        },
        async getTramitesPaginate(link) {
            var get = `${link}`;
            const response = await fetch(get, { method: 'GET' })

            this.tramites = await response.json()
            //console.log(this.orders)  
        },
        async generateReport() {

            this.filter.dependencia_id = 2
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
        },
        /* fechaFormateada(fecha) {
            const fechaObjeto = new Date(fecha);
            fechaObjeto.setDate(fechaObjeto.getDate() + 1); // Restar un día

            const dia = fechaObjeto.getDate();
            const mes = fechaObjeto.getMonth() + 1; // Los meses en JavaScript son indexados desde 0
            const anio = fechaObjeto.getFullYear();

            // Agregar ceros iniciales si es necesario
            const diaFormateado = dia < 10 ? `0${dia}` : dia;
            const mesFormateado = mes < 10 ? `0${mes}` : mes;

            return `${diaFormateado}-${mesFormateado}-${anio}`;

            return fecha;
        }, */
        namePersons(data){
            let name_titular = ''
            let name_benef = ''
            data.forEach(element => {
                if(element.pivot.rol_tramite_id == 1){
                    name_titular = element.lastname + ', '+element.name
                }else{
                    name_benef = element.lastname + ', '+element.name
                }
            });
            return name_titular+'<br><p class="text-xs text-red-900 italic mt-1">'+name_benef+'</p>'
        },
        dniPersons(data){
            let name_titular = ''
            let name_benef = ''
            data.forEach(element => {
                if(element.pivot.rol_tramite_id == 1){
                    name_titular = element.num_documento
                }else{
                    name_benef = element.num_documento
                }
            });
            return name_titular+'<br><p class="text-xs text-red-900 italic mt-1">'+name_benef+'</p>'
        }
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
    }
};
</script>

<style></style>
