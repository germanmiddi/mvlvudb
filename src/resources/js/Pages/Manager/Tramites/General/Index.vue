<template>
    <main class="flex-1">
        <!-- Page title & actions -->


        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Bandeja General
                </h1>
            </div>
            <div class="mt-4 flex sm:mt-0 sm:ml-4" v-if="!showCreate">
                <!-- <button type="button" class="order-1 ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:order-0 sm:ml-0">Share</button> -->
                <a @click="showCreate = true"
                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Crear</a>
            </div>
            <div class="mt-4 flex sm:mt-0 sm:ml-4" v-else>
                <!-- <button type="button" class="order-1 ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:order-0 sm:ml-0">Share</button> -->
                <div class="col-span-12 sm:col-span-4">
                    <select v-model="dependencia_id" id="create_dependencia_id" name="create_dependencia_id"
                        autocomplete="off"
                        class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" selected disabled>Selecciones una dependencia</option>
                        <option v-for="dependencia in createDependencia " :key="dependencia.id" :value="dependencia.id">{{
                            dependencia.description
                        }}</option>
                    </select>
                </div>
                <a :href="formUrl()"
                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Ir Formulario</a>
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
                            <button v-if="Object.keys(this.filter).length" class="text-xs font-medium text-gray-500 hover:text-gray-700 mr-2"
                                    @click="clearFilter">Limpiar Filtro</button>
                            <button type="button"
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white" @click="getTramites()">Aplicar Filtro</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 sm:col-span-4 ">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input v-model="filter.name" type="text" name="name" id="name" autocomplete="name-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>

                        <div class="col-span-12 sm:col-span-2 ">
                            <label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de Documento</label>
                            <input v-model="filter.num_documento" type="text" name="num_documento" id="num_documento"
                                autocomplete="address-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>

                        <div class="col-span-12 sm:col-span-3">
                            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                            <Datepicker class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" v-model="filter.date" range multiCalendars
                                    :closeOnAutoApply="true" :enableTimePicker="false" :format="customFormat"></Datepicker>
                        </div>

                        <div class="col-span-12 sm:col-span-4">
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
                        
                        <div class="col-span-12 sm:col-span-4">
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
                                <tr v-for="data in this.tramites.data" :key="data.tramite.id">
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
                                        {{ data.dependencia.description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-wrap text-sm text-gray-500">
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
                                                        <MenuItem v-slot="{ active }" v-show="store.userCan('VUDS-VU', $page.props.userGroups)">
                                                        <a :href="defineUrl(data.tramite.dependencia_id, data.tramite.id)"
                                                            class="block px-4 py-2 text-sm">
                                                            Editar</a>
                                                        </MenuItem>
 
                                                        <!-- <MenuItem v-slot="{ active }">
                                                        <a href="#" class="block px-4 py-2 text-sm">
                                                            Ver</a>
                                                        </MenuItem> -->
                                                        
                                                        <MenuItem v-slot="{ active }" v-show="!store.userCan('VUDS-VU', $page.props.userGroups)" >
                                                            <a :href="route('detail.view', data.tramite.id) "
                                                                class="block px-4 py-2 text-sm">
                                                                Detalle</a>
                                                        </MenuItem>

                                                        <MenuItem v-slot="{ active }">
                                                        <a :href="route('pdf.acusepdf', data.tramite.id)" target="_blank"
                                                            class="block px-4 py-2 text-sm">
                                                            Imprimir</a>
                                                        </MenuItem>

                                                        <MenuItem v-slot="{ active }" v-show="!store.userCan('VUDS-VU', $page.props.userGroups)">
                                                        <a :href="route('pdf.acuseobservacionpdf', data.tramite.id)" target="_blank"
                                                            class="block px-4 py-2 text-sm">
                                                            Imprimir Obs.</a>
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
    ArrowsPointingOutIcon
} from "@heroicons/vue/24/solid";
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
            showCreate: false,
            filter: {},
            length: 10,
            customFormat: 'd-M-Y',
            tiposTramiteFiltrados: this.tiposTramite,
            dependencia_id: ''
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
            this.tiposTramiteFiltrados = this.tiposTramite
            this.getTramites()
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

        async getTramites() {
            this.tramites = ''
            let filter = `&length=${this.length}`

            if (this.filter.name) {
                filter += `&name=${JSON.stringify(this.filter.name)}`
            }

            if (this.filter.num_documento) {
                filter += `&num_documento=${JSON.stringify(this.filter.num_documento)}`
            }

            if (this.filter.date) {
                filter += `&date=${JSON.stringify(this.filter.date)}`
            }

            if (this.filter.tipo_tramite_id) {
                filter += `&tipo_tramite_id=${JSON.stringify(this.filter.tipo_tramite_id)}`
            }

            if (this.filter.dependencia_id) {
                filter += `&dependencia_id=${JSON.stringify(this.filter.dependencia_id)}`
            }

            const get = `${route('general.list')}?${filter}`

            const response = await fetch(get, { method: "GET" });
            this.tramites = await response.json();
        },

        async getTramitesPaginate(link) {
            var get = `${link}`;
            const response = await fetch(get, { method: 'GET' })

            this.tramites = await response.json()
            //console.log(this.orders)  
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
        },
        formUrl(){
                let url = ''
                switch (this.dependencia_id) {
                    case 2:
                        url = route('discapacidad.create') 
                        break;
                    case 3:
                        url = route('entidad.create') 
                        break;
                    case 5:
                        url = route('fortalecimiento.create') 
                        break;
                    case 6:
                        url = route('genero.create') 
                        break;
                    case 7:
                        url = route('habitat.create') 
                        break;
                    case 8:
                        url = route('ninez.create') 
                        break;
                    case 9:
                        url = route('promocion.create') 
                        break;
                    case 11:
                        url = route('vivienda.create') 
                        break;
                    case 12:
                        url = route('infancia.create') 
                        break;
                    case 13:
                        url = route('juventud.create') 
                        break;
                    case 14:
                        url = route('mayores.create') 
                        break;
                    default:
                        break;
                }
                return url    
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
            
        }

    },
    computed: {
		createDependencia: function () {
			return this.dependencias.filter(dependencia => (dependencia.id != 1 &&  dependencia.id != 4 && dependencia.id != 10))
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
    },
};
</script>

<style></style>
