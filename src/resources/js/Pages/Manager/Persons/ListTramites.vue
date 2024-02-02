<template>
    <main class="flex-1">
        <!-- Page title & actions -->
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0 flex items-center">
				<a class="btn-blue" :href="route('persons')">
					<ArrowLeftCircleIcon class="w-5 h-5 text-purple-700 mr-2" />
				</a>
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Listado de Tramites | {{person.lastname}}, {{person.name}}
                </h1>
			</div>


           <!--  <div class="flex-1 min-w-0">
                <a class="btn-blue" :href="route('persons')">
					<ArrowLeftCircleIcon class="w-5 h-5 text-purple-700 mr-2" />
				</a>
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Listado de Tramites | {{person.lastname}}, {{person.name}}
                </h1>
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
                        <div class="col-span-12 sm:col-span-3">
                            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                            <Datepicker class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" v-model="filter.date" range multiCalendars
                                    :closeOnAutoApply="true" :enableTimePicker="false" :format="customFormat"></Datepicker>
                        </div>

                        <div class="col-span-12 sm:col-span-3">
                            <label for="dependencia_id" class="block text-sm font-medium text-gray-700">Dependencia</label>
                            <select v-model="filter.dependencia_id" id="dependencia_id" name="dependencia_id" @change="filtrarTiposTramite"
                                autocomplete="off"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" selected>Selecciones una dependencia</option>
                                <option v-for="dependencia in dependencias" :key="dependencia.id" :value="dependencia.id">{{
                                    dependencia.description
                                }}</option>
                            </select>
                        </div>
                        
                        <div class="col-span-12 sm:col-span-3">
                            <label for="tipo_tramite_id" class="block text-sm font-medium text-gray-700">Tipo de Tramite</label>
                            <select v-model="filter.tipo_tramite_id" id="tipo_tramite_id" name="tipo_tramite_id"
                                autocomplete="tipo_tramite_id_name"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" selected>Selecciones un tipo de tramite</option>
                                <option v-for="tipoTramite in tiposTramiteFiltrados" :key="tipoTramite.id" :value="tipoTramite.id">{{
                                    tipoTramite.description
                                }}</option>
                            </select>
                        </div>

                        <div class="col-span-12 sm:col-span-3">
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
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-l-8 border-gray-500">
                                        N° de Tramite
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Dependencia
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
                                <tr v-for="data in persons.data" :key="data.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" :class="data.tramite.estado_id == 2 ? 'border-l-8 border-red-500' : data.tramite.estado_id == 3 ? 'border-l-8 border-purple-500' : 'border-l-8 border-green-500' ">
                                        {{ data.tramite.id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ store.dateFormateada(data.tramite.fecha) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ data.dependencia.description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ data.tramite.tipo_tramite.description }}
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
                                                        <a :href="defineUrl(data.tramite.dependencia_id, data.tramite.id)"
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
import { ArrowLeftCircleIcon } from '@heroicons/vue/24/outline';
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
        tiposTramite: Object,
        dependencias: Object,
        estados: Object,
        person: Object
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
        Datepicker,
        ArrowLeftCircleIcon,
        store
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
            processReport: false,
            tiposTramiteFiltrados: this.tiposTramite,
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
            filter += `&person_id=${this.person.id}`

            if (this.filter.date) {
                filter += `&date=${JSON.stringify(this.filter.date)}`
            }

            if (this.filter.estado_id) {
                filter += `&estado_id=${JSON.stringify(this.filter.estado_id)}`
            }

            if (this.filter.tipo_tramite_id) {
                filter += `&tipo_tramite_id=${JSON.stringify(this.filter.tipo_tramite_id)}`
            }

            if (this.filter.dependencia_id) {
                filter += `&dependencia_id=${JSON.stringify(this.filter.dependencia_id)}`
            }

            const get = `${route('persons.listTramites')}?${filter}`

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
        defineUrl(dependencia, tramite_id){
                let url = ''
                switch (dependencia) {
                    case 2:
                        url = route('discapacidad.edit', tramite_id) 
                        break;
                    case 5:
                        url = route('fortalecimiento.edit',tramite_id) 
                        break;
                    case 6:
                        url = route('genero.edit', tramite_id) 
                        break;
                    case 7:
                        url = route('habitat.edit', tramite_id) 
                        break;
                    case 8:
                        url = route('ninez.edit', tramite_id) 
                        break;
                    case 9:
                        url = route('promocion.edit', tramite_id) 
                        break;
                    case 11:
                        url = route('vivienda.edit', tramite_id) 
                        break;
                    case 12:
                        url = route('infancia.edit', tramite_id) 
                        break;
                    case 13:
                        url = route('juventud.edit', tramite_id) 
                        break;
                    case 14:
                        url = route('mayores.edit', tramite_id) 
                        break;
                    default:
                        break;
                }
                return url
            
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
    },
    computed: {
		/* barriosComputed: function () {
			return this.barrios.filter(
				(barrio) => barrio.localidad_id == this.filter.localidad
			);
		}, */
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
