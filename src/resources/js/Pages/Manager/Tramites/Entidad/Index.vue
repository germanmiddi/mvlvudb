<template>
    <main class="flex-1">
        <!-- Page title & actions -->
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Bandeja Entidades
                </h1>
            </div>

            <div v-if="formImportParticipantes" class="mt-4 flex sm:mt-0">
                <input
                    @change="handleFileChange"
                    accept=".xls, .xlsx"
                    type="file"
                    name="file"
                    id="file"
                    ref="inputfile"
                    autocomplete="off"
                    class="bg-gray-100 focus:ring-indigo-500 focus:border-indigo-500 block"
                />

                <a
                    @click="importFile()"
                    v-if="!processImport"
                    class="order-0 inline-flex items-center px-4 py-2 shadow-sm text-sm font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white sm:order-1 sm:ml-3"
                    >Importar</a
                >

                <a
                    v-else
                    class="border-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"
                >
                    <ArrowPathIcon
                        class="h-5 w-5 text-red-500 animate-spin mr-2"
                    />
                    Procesando...
                </a>

                <a
                    :href="route('entidad.exportar_template_participantes')"
                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:order-1 sm:ml-3"
                    >Descargar Modelo</a
                >
                <a
                    @click="formImport = false"
                    class="order-0 inline-flex items-center px-4 py-2 border border-red-700 shadow-sm text-sm font-medium rounded-md text-red-700 hover:text-white hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:order-1 sm:ml-3"
                    >Cancelar</a
                >
            </div>

            <div v-else class="mt-4 flex sm:mt-0 sm:ml-4">
                <!-- <button type="button" class="order-1 ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:order-0 sm:ml-0">Share</button> -->
                <a :href="route('entidad.create')"
                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Crear</a>

                <a @click="formImportParticipantes = true"
                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:order-1 sm:ml-3">Importar Participantes</a>

                <a @click="generateReport()" v-if="!processReport"
                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Exportar</a>

                <a v-else
                    class="border-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">
                    <ArrowPathIcon class="h-5 w-5 text-red-500 animate-spin mr-2" /> Procesando...
                </a>

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
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                                @click="getEntidades()">Aplicar
                                Filtro</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 sm:col-span-3 ">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input v-model="filter.name" type="text" name="name" id="name" autocomplete="name-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <div class="col-span-12 sm:col-span-3 ">
                            <label for="num_entidad" class="block text-sm font-medium text-gray-700">Nro de
                                Entidad</label>
                            <input v-model="filter.num_entidad" type="number" name="num_entidad" id="num_entidad"
                                autocomplete="address-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>

                        <div class="col-span-12 sm:col-span-3">
                            <label for="tipo_entidad_id" class="block text-sm font-medium text-gray-700">Tipo de
                                Entidad</label>
                            <select v-model="filter.tipo_entidad_id" id="tipo_entidad_id" name="tipo_entidad_id"
                                autocomplete="off"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled>Selecciones un tipo de tramite</option>
                                <option v-for="tipoEntidad in tiposEntidad" :key="tipoEntidad.id"
                                    :value="tipoEntidad.id">{{
                                        tipoEntidad.description
                                    }}</option>
                            </select>
                        </div>

                        <!-- <div class="col-span-12 sm:col-span-3">
                            <label for="tipo_entidad_id" class="block text-sm font-medium text-gray-700">Estado
                                Entidad</label>
                            <select v-model="filter.activo" id="activo" name="activo"
                                autocomplete="off"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled>Selecciones un estado</option>
                                <option value="1">Habilitado</option>
                                <option value="0">Deshabilitado</option>
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
                                        Num Entidad
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha Fundacion
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Telefono
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipo Entidad
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs text-center font-medium text-gray-500 uppercase tracking-wider">
                                        <span>Acciones</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="data in entidades.data" :key="data.entidad.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ data.entidad.num_entidad }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ data.entidad.name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ data.entidad.fecha_fundacion ? fechaFormateada(data.entidad.fecha_fundacion)
                                            :
                                            '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ data.entidad.phone ? data.entidad.phone : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ data.entidad.tipo_entidad_id ? data.entidad.tipo_entidad.description : '-' }}
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
                                                            'entidad.edit',
                                                            data.entidad.id
                                                        )
                                                            " class="block px-4 py-2 text-sm">
                                                            Editar</a>
                                                        </MenuItem>

                                                        <MenuItem v-slot="{ active }">
                                                        <a href="#" class="block px-4 py-2 text-sm">
                                                            Ver</a>
                                                        </MenuItem>

                                                        <MenuItem v-slot="{ active }">
                                                        <a href="#"
                                                            @click="this.deleteEntidad.id = data.entidad.id, this.deleteEntidad.name = data.entidad.name, this.deleteEntidad.num_entidad = data.entidad.num_entidad, showDeleteEntidad = true"
                                                            class="block px-4 py-2 text-sm">
                                                            Eliminar</a>
                                                        </MenuItem>

                                                        <!--  <MenuItem v-else v-slot="{ active }">
                                                        <button @click="active(data.entidad.id)" class="block px-4 py-2 text-sm">
                                                            Activar</button>
                                                        </MenuItem> -->
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
                                Mostrando: {{ this.entidades.from }} a {{ this.entidades.to }} - Entradas encontradas:
                                {{ this.entidades.total }}
                            </div>

                            <div class="flex flex-wrap -mb-1">
                                <template v-for="link in entidades.links">
                                    <div v-if="link.url === null"
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded-md"
                                        v-html="link.label"> </div>
                                    <div v-else
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-gray-300 rounded-md hover:bg-blue-500 hover:text-white cursor-pointer"
                                        :class="{ 'bg-blue-500': link.active }, { 'text-white': link.active }"
                                        @click="getEntidadesPaginate(link.url)" v-html="link.label"> </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <DeleteModal v-if="showDeleteEntidad" :id="deleteEntidad.id"
        :title="`¿Está seguro que desea eliminar la entidad ${deleteEntidad.name}, identificada con el N° ${deleteEntidad.num_entidad}`"
        @viewDeleted="fnShowDeleteEntidad" ref="componenteDeleteOrder" @responseDeleted="fnDeleteEntidad" />
</template>

<script>
import { ref } from "vue";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import DeleteModal from '@/Layouts/Components/DeleteModal.vue'

import {
    ChevronRightIcon,
    EllipsisVerticalIcon,
    PencilSquareIcon,
    ArrowsPointingOutIcon,
    ArrowPathIcon
} from "@heroicons/vue/24/solid";
import Toast from "@/Layouts/Components/Toast.vue";

export default {
    props: {
        toast: Object,
        tiposEntidad: Object
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
        Toast,
        Datepicker,
        DeleteModal
    },
    data() {
        return {
            entidades: "",
            toastMessage: "",
            labelType: "info",
            message: "",
            showToast: false,
            filter: {},
            length: 10,
            customFormat: 'd-M-Y',
            showDeleteEntidad: false,
            deleteEntidad: {},
            processReport: false,

            processImport: false,
            formImportParticipantes: false,
            file: "",

            showImportResult: false,
            importResult: "",

        };
    },
    setup() {
    },
    methods: {
        clearMessage() {
            this.toastMessage = "";
        },
        fnShowDeleteEntidad() {
            this.showDeleteEntidad = false
        },
        async getEntidades() {
            this.entidades = ''
            let filter = `&length=${this.length}`

            if (this.filter.name) {
                filter += `&name=${JSON.stringify(this.filter.name)}`
            }

            if (this.filter.num_entidad) {
                filter += `&num_entidad=${JSON.stringify(this.filter.num_entidad)}`
            }

            if (this.filter.tipo_entidad_id) {
                filter += `&tipo_entidad_id=${JSON.stringify(this.filter.tipo_entidad_id)}`
            }

            if (this.filter.activo) {
                filter += `&activo=${JSON.stringify(this.filter.activo)}`
            }

            const get = `${route('entidad.list')}?${filter}`

            const response = await fetch(get, { method: "GET" });
            this.entidades = await response.json();
        },
        async getEntidadesPaginate(link) {
            var get = `${link}`;
            const response = await fetch(get, { method: 'GET' })

            this.entidades = await response.json()
            //this.tramites.persons = this.tramites[0].persons.filter(person => person.pivot.rol_tramite_id == 1)
            //console.log(this.orders)
        },
        fechaFormateada(fecha) {
            const fechaObjeto = new Date(fecha + "T00:00:00.000-03:00");
            const dia = fechaObjeto.getDate();
            const mes = fechaObjeto.getMonth() + 1; // Los meses en JavaScript son indexados desde 0
            const anio = fechaObjeto.getFullYear();

            // Agregar ceros iniciales si es necesario
            const diaFormateado = dia < 10 ? `0${dia}` : dia;
            const mesFormateado = mes < 10 ? `0${mes}` : mes;

            return `${diaFormateado}-${mesFormateado}-${anio}`;
        },
        async fnDeleteEntidad(data) {
            this.showDeleteEntidad = false
            const response = await axios.delete(route('entidad.destroy', data));

            if (response.status == 200) {
                this.labelType = "success"
                this.toastMessage = response.data.message
                this.showToast = true
                this.getEntidades()

            } else {
                this.labelType = "danger"
                this.toastMessage = response.data.message
                this.showToast = true
            }
        },
        async generateReport() {

            this.processReport = true
            let rt = route("report.exportEntidadExcel");

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
                a.download = 'Entidades.xlsx'; // Nombre del archivo
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
        handleFileChange(event) {
            this.file = event.target.files[0];
        },
        buildImportResult(response) {
            console.log(response);
            this.importResult =
                '<span class="text-green-500 font-bold">' +
                response.message +
                "</span>";

            if (response.result.rowsSuccess > 0) {
                this.importResult +=
                    "<br><br><span class='text-green-500'>Entrevistas registradas: " +
                    response.result.rowsSuccess +
                    "</span>";
            }

            if (response.result.rowsDuplicadosCount > 0) {
                this.importResult +=
                    "<br><br><span class='text-yellow-500'>Entrevistas duplicadas: " +
                    response.result.rowsDuplicadosCount +
                    "</span>";
                this.importResult += "<br>" + response.result.rowsDuplicados;
            }

            if (response.result.rowsError > 0) {
                this.importResult +=
                    "<br><br><span class='text-red-500'>Entrevistas no registradas: " +
                    response.result.rowsError +
                    "</span>";
            }

            this.showImportResult = true;
        },


        async importFile() {
            if (this.file != "") {
                this.processImport = true;
                // this.status = ''
                let rt = route("entidad.importar_participantes");
                const formData = new FormData();
                formData.append("file", this.file);
                try {
                    const response = await axios.post(rt, formData);
                    if (response.status == 200) {
                        this.labelType = "success";
                        this.toastMessage = response.data.message;
                        this.buildImportResult(response.data);
                    } else {
                        this.labelType = "danger";
                        this.toastMessage = response.data.message;
                    }
                    this.formImportParticipantes = false;
                } catch (error) {
                    console.log(error);
                }
                this.processImport = false;
            } else {
                this.labelType = "info";
                this.toastMessage = "Debe seleccionar un archivo";
            }
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
        this.getEntidades();
    },
};
</script>

<style></style>
