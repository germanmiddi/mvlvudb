<template>
    <main class="flex-1">
        <!-- Page title & actions -->
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Listado de Inscriptos
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
                                @click="getLegajos()">Aplicar
                                Filtro</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 sm:col-span-3">
                            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha Alta</label>
                            <Datepicker
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                v-model="filter.date" range multiCalendars :closeOnAutoApply="true"
                                :enableTimePicker="false" :format="customFormat"></Datepicker>
                        </div>

                        <div class="col-span-12 sm:col-span-3">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input v-model="filter.name" type="text" name="name" id="name" autocomplete="name-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>

                        <div class="col-span-12 sm:col-span-2">
                            <label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de
                                Documento</label>
                            <input v-model="filter.num_documento" type="text" name="num_documento" id="num_documento"
                                autocomplete="address-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>


                        <div class="col-span-12 sm:col-span-2">
                            <label for="estado_id" class="block text-sm font-medium text-gray-700">Estado</label>
                            <select v-model="filter.estado_id" id="estado_id" name="estado_id" autocomplete="off"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled>Seleccione un Estado</option>
                                <option v-for="estado in estados" :key="estado.id" :value="estado.id">{{
                                    estado.description
                                }}</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-2">
                            <label for="estado_id" class="block text-sm font-medium text-gray-700">Tipo Legajo</label>
                            <select v-model="filter.tipo_legajo_id" id="tipo_legajo_id" name="tipo_legajo_id"
                                autocomplete="off"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled>Seleccione un Tipo Legajo</option>
                                <option v-for="tl in tiposLegajo" :key="tl.id" :value="tl.id">{{
                                    tl.description
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
                                        Apellido y Nombre
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        DNI
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sede
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha Inscripción
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipo Legajo
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs text-center font-medium text-gray-500 uppercase tracking-wider">
                                        <span>Cambiar Estado</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="data in legajos.data" :key="data.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ data.person?.lastname ?? '-' }}, {{ data.person?.name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ data.person?.num_documento ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ data.sede?.description ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ store.dateFormateada(data.fecha_inscripcion) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ data.tipo_legajo?.description ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span v-if="data.estadocbj?.id === 1"
                                            class="inline-flex items-center rounded-md bg-green-200 px-2 py-1 text-xs font-medium text-green-800 ring-1 ring-inset ring-green-600/20">{{
                                                data.estadocbj?.description
                                                ?? '-' }}</span>
                                        <span v-else
                                            class="inline-flex items-center rounded-md bg-gray-200 px-2 py-1 text-xs font-medium text-gray-800 ring-1 ring-inset ring-gray-600/20">{{
                                                data.estadocbj?.description
                                                ?? '-' }}</span>
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
                                                        <a :href="route('legajoCB.legajo', data.id)"
                                                            class="block px-4 py-2 text-sm">
                                                            Ver Legajo</a>
                                                        </MenuItem>
                                                    </div>
                                                    <div class="px-1 py-1 text-left">
                                                        <MenuItem v-slot="{ active }">
                                                        <a @click="updateEstado(data.id, 2)"
                                                            class="cursor-pointer block px-4 py-2 text-sm">
                                                            Cambiar a Regular</a>
                                                        </MenuItem>

                                                        <MenuItem v-slot="{ active }">
                                                        <a @click="updateEstado(data.id, 5)"
                                                            class="cursor-pointer block px-4 py-2 text-sm">
                                                            Cambiar a No Participa</a>
                                                        </MenuItem>

                                                        <MenuItem v-slot="{ active }">
                                                        <a @click="updateEstado(data.id, 3)"
                                                            class="cursor-pointer block px-4 py-2 text-sm">
                                                            Cambiar a Baja</a>
                                                        </MenuItem>

                                                        <MenuItem v-slot="{ active }">
                                                        <a @click="updateEstado(data.id, 4)"
                                                            class="cursor-pointer block px-4 py-2 text-sm">
                                                            Cambiar a Egreso</a>
                                                        </MenuItem>

                                                        <MenuItem v-slot="{ active }">
                                                        <a @click="updateEstado(data.id, 6)"
                                                            class="cursor-pointer block px-4 py-2 text-sm">
                                                            Cambiar a Solo en Vacaciones</a>
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
                                Mostrando: {{ this.legajos.from }} a {{ this.legajos.to }} - Entradas encontradas:
                                {{ this.legajos.total }}
                            </div>

                            <div class="flex flex-wrap -mb-1">
                                <template v-for="link in legajos.links">
                                    <div v-if="link.url === null"
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded-md"
                                        v-html="link.label"> </div>
                                    <div v-else
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-gray-300 rounded-md hover:bg-blue-500 hover:text-white cursor-pointer"
                                        :class="{ 'bg-blue-500': link.active }, { 'text-white': link.active }"
                                        @click="getLegajosPaginate(link.url)" v-html="link.label"> </div>
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
        estados: Object,
        tiposLegajo: Object
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
            legajos: {},
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
        clearFilter() {
            this.filter = {}
            this.getLegajos()
        },
        clearMessage() {
            this.toastMessage = "";
        },
        async getLegajos() {

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

            if (this.filter.estado_id) {
                filter += `&estado_id=${JSON.stringify(this.filter.estado_id)}`
            }

            if (this.filter.tipo_legajo_id) {
                filter += `&tipo_legajo_id=${JSON.stringify(this.filter.tipo_legajo_id)}`
            }

            const get = `${route('legajoCB.list')}?${filter}`

            const response = await fetch(get, { method: "GET" });
            this.legajos = await response.json();
        },
        async getLegajosPaginate(link) {
            var get = `${link}`;
            const response = await fetch(get, { method: 'GET' })

            this.legajos = await response.json()
            //console.log(this.orders)
        },
        namePersons(data) {
            let name_titular = ''
            let name_benef = ''
            data.forEach(element => {
                if (element.pivot.rol_tramite_id == 1) {
                    name_titular = element.lastname + ', ' + element.name
                } else {
                    name_benef = element.lastname + ', ' + element.name
                }
            });
            return name_titular + '<br><p class="text-xs text-red-900 italic mt-1">' + name_benef + '</p>'
        },
        dniPersons(data) {
            let name_titular = ''
            let name_benef = ''
            data.forEach(element => {
                if (element.pivot.rol_tramite_id == 1) {
                    name_titular = element.num_documento
                } else {
                    name_benef = element.num_documento
                }
            });
            return name_titular + '<br><p class="text-xs text-red-900 italic mt-1">' + name_benef + '</p>'
        },
        async updateEstado(id, estado_id) {
            let data = {}
            data.estado_id = estado_id
            // RUTA
            let rt = route("legajoCB.updateEstado", id);

            try {
                const response = await axios.put(rt, data);
                if (response.status == 200) {
                    this.labelType = "success";
                    this.toastMessage = response.data.message;
                    this.getLegajos()
                } else {
                    this.labelType = "info";
                    this.toastMessage = response.data.message;
                }
            } catch (error) {
                this.labelType = "danger";
                this.toastMessage = "Se ha producido un error | Por Favor Comuniquese con el Administrador!"
            }
        },
    },
    mounted() {
        this.getLegajos();
    }
};
</script>

<style></style>
