<template>
    <main class="flex-1">
        <!-- Page title & actions -->
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Gestion de cajas y kits
                </h1>
            </div>
            <!-- <div class="mt-4 flex sm:mt-0 sm:ml-4">
                
                <a  @click="generateReport()" v-if="!processReport"
                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Exportar</a>

                <a v-else
                    class="border-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"><ArrowPathIcon class="h-5 w-5 text-red-500 animate-spin mr-2" /> Procesando...</a>
            </div> -->
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
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white" @click="getPersons()">Aplicar
                                Filtro</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6">
                        <!-- <div class="col-span-12 sm:col-span-1 ">
                            <label for="tramite_id" class="block text-sm font-medium text-gray-700">N° Tramite</label>
                            <input v-model="filter.tramite_id" type="number" name="tramite_id" id="tramite_id" autocomplete="name-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div> -->
                        <div class="col-span-12 sm:col-span-3 ">
                            <label for="name" class="block text-sm font-medium text-gray-700">Apellido</label>
                            <input v-model="filter.lastname" type="text" name="name" id="name" autocomplete="name-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>

                        <div class="col-span-12 sm:col-span-3 ">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input v-model="filter.name" type="text" name="name" id="name" autocomplete="name-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        
                        <div class="col-span-12 sm:col-span-3 ">
                            <label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de
                                Documento</label>
                            <input v-model="filter.num_documento" type="text" name="num_documento" id="num_documento"
                                autocomplete="address-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <div class="col-span-12 sm:col-span-3">
								<label for="localidad_id" class="block text-sm font-medium text-gray-700">Localidad</label>
								<select v-model="filter.localidad" id="localidad_id" name="localidad_id" autocomplete="off"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione una localidad
									</option>
									<option v-for="localidad in localidades" :key="localidad.id" :value="localidad.id">
										{{ localidad.description }}
									</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="barrio_id" class="block text-sm font-medium text-gray-700">Barrio</label>
								<select v-model="filter.barrio" id="barrio_id" name="barrio_id"
									autocomplete="barrio_id-name" :disabled="barriosComputed.length === 0 || input_disable"
									:class="barriosComputed.length === 0 || input_disable ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione un barrio</option>
									<option v-for="barrio in barriosComputed" :key="barrio.id" :value="barrio.id">{{
										barrio.description
									}}</option>
								</select>
							</div>
                        <!-- <div class="col-span-12 sm:col-span-3">
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
                        </div> -->
                        <!-- <div class="col-span-12 sm:col-span-3" v-show="store.userCan('ADM', $page.props.userGroups)"> -->
                        <!-- <div class="col-span-12 sm:col-span-3">
                            <label for="user_id" class="block text-sm font-medium text-gray-700">Usuarios</label>
                            <select @click="filter.not_assigned = ''" v-model="filter.user_id" id="user_id" name="user_id"
                                autocomplete="off"
                                class="uppercase mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option v-for="user in users" :key="user.id" :value="user.id">{{
                                    user.name
                                }}</option>
                            </select> 
                        </div>-->
                        <!-- <div class="col-span-12 sm:col-span-2" v-show="!store.userCan('-OP', $page.props.userGroups) || store.userCan('ALL', $page.props.userGroups)"> -->
                       <!--  <div class="col-span-12 sm:col-span-2">
                            <label for="assigned_me" class="block text-sm font-medium text-gray-700">Asignados solo a mi</label>
                            <input @click="filter.not_assigned = ''" v-model="filter.assigned_me" id="assigned_me" type="checkbox" value="2" class="w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        </div> -->
                        <!-- <div class="col-span-12 sm:col-span-2" v-show="store.userCan('ADM', $page.props.userGroups)"> -->
                        <!-- <div class="col-span-12 sm:col-span-2">
                            <label for="not_assigned" class="block text-sm font-medium text-gray-700">Sin Asignar</label>
                            <input @click="filter.user_id = '', filter.assigned_me = ''" v-model="filter.not_assigned" id="not_assigned" type="checkbox" value="2" class="w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
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
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-l-8 border-gray-500">
                                        Nro Doc.
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Apellido
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha Nac.
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Barrio
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cant. Tramite
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs text-center font-medium text-gray-500 uppercase tracking-wider">
                                        <span>Acciones</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="data in persons.data" :key="data.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ data.num_documento }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ data.lastname }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ data.name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ data.fecha_nac }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ data.barrio ?? '--'}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ data.cant_tramites ?? '--'}}
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
                                                    <div class="py-1 text-left">
                                                        
                                                        <MenuItem v-slot="{ active }">
                                                        <a :href="route('persons.edit', data.id)"
                                                            class="block px-4 py-2 text-sm">
                                                            Editar</a>
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
                                Mostrando: {{ this.persons.from }} a {{ this.persons.to }} - Entradas encontradas:
                                {{ this.persons.total }}
                            </div>

                            <div class="flex flex-wrap -mb-1">
                                <template v-for="link in persons.links">
                                    <div v-if="link.url === null"
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded-md"
                                        v-html="link.label"> </div>
                                    <div v-else
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-gray-300 rounded-md hover:bg-blue-500 hover:text-white cursor-pointer"
                                        :class="{ 'bg-blue-500': link.active }, { 'text-white': link.active }"
                                        @click="getPersonsPaginate(link.url)" v-html="link.label"> </div>
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
    ArrowPathIcon,
    PaperClipIcon
} from "@heroicons/vue/24/solid";
import Toast from "@/Layouts/Components/Toast.vue";
import store from '@/store.js'

export default {
    props: {
        toast: Object,
        localidades: Object,
        barrios: Object,
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
        UserCircleIcon,
        ArrowPathIcon,
        PaperClipIcon,
        Toast,
        Datepicker
    },
    data() {
        return {
            tramites: "",
            persons: "",
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
        clearFilter(){
            this.filter = {}
            this.getPersons()
        },
        clearMessage() {
            this.toastMessage = "";
        },
        async getPersons() {
            this.tramites = ''
            let filter = `&length=${this.length}`

            /* if (this.filter.name) {
                filter += `&name=${JSON.stringify(this.filter.tramite_id)}`
            }

            if (this.filter.user_id) {
                filter += `&user_id=${JSON.stringify(this.filter.user_id)}`
            }

            if (this.filter.assigned_me) {
                filter += `&assigned_me=${JSON.stringify(this.filter.assigned_me)}`
            }

            if (this.filter.not_assigned) {
                filter += `&not_assigned=${JSON.stringify(this.filter.not_assigned)}`
            } */

            if (this.filter.lastname) {
                filter += `&lastname=${JSON.stringify(this.filter.lastname)}`
            }

            if (this.filter.name) {
                filter += `&name=${JSON.stringify(this.filter.name)}`
            }

            if (this.filter.num_documento) {
                filter += `&num_documento=${JSON.stringify(this.filter.num_documento)}`
            }

            if (this.filter.localidad) {
                filter += `&localidad=${JSON.stringify(this.filter.localidad)}`
            }

            if (this.filter.barrio) {
                filter += `&barrio=${JSON.stringify(this.filter.barrio)}`
            }

            /* if (this.filter.date) {
                filter += `&date=${JSON.stringify(this.filter.date)}`
            }

            if (this.filter.estado_id) {
                filter += `&estado_id=${JSON.stringify(this.filter.estado_id)}`
            }

            if (this.filter.tipo_tramite_id) {
                filter += `&tipo_tramite_id=${JSON.stringify(this.filter.tipo_tramite_id)}`
            } */

            const get = `${route('persons.list')}?${filter}`

            const response = await fetch(get, { method: "GET" });
            this.persons = await response.json();
        },
        async getPersonsPaginate(link) {
            var get = `${link}`;
            const response = await fetch(get, { method: 'GET' })

            this.persons = await response.json()
        },
        async generateReport() {

            this.filter.dependencia_id = 2
            this.processReport = true
            let rt = route("report.exportPersonsExcel");

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
                a.download = 'Persons.xlsx'; // Nombre del archivo
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
    },
    computed: {
		barriosComputed: function () {
			return this.barrios.filter(
				(barrio) => barrio.localidad_id == this.filter.localidad
			);
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
        this.getPersons();
    }
};
</script>

<style></style>
