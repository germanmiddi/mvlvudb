<template>
    <main class="flex-1">
        <!-- Page title & actions -->
        <div
            class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8"
        >
            <div class="flex-1 min-w-0">
                <h1
                    class="text-lg font-medium leading-6 text-gray-900 sm:truncate"
                >
                    Entrevistas Entrega de Cajas
                </h1>
            </div>

            <div v-if="formImport" class="mt-4 flex sm:mt-0">
                <input
                    @change="handleFileChange"
                    accept=".jpg, .jpeg, .png, .gif, .pdf, .doc, .docx, .xls, .xlsx"
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
                    :href="route('collections.entrevistas.export.template')"
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
                <div class="mt-4 flex sm:mt-0 sm:ml-4" v-if="!formImport">
                    <a
                        :href="route('collections.entrevistas.create')"
                        class="btn-green"
                        >Crear</a
                    >
                </div>

                <a
                    @click="formImport = true"
                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:order-1 sm:ml-3"
                    >Importar</a
                >
            </div>
        </div>

        <Toast
            :toast="this.toastMessage"
            :type="this.labelType"
            @clear="clearMessage"
        ></Toast>

        <div v-if="showImportResult" class="px-4 mt-6 sm:px-6 lg:px-8">
            <div
                class="px-4 mt-6 sm:px-6 lg:px-8 bg-gray-50 rounded-md py-6"
                v-html="importResult"
            ></div>
        </div>

        <div class="px-4 mt-6 sm:px-6 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div
                        class="flex items-center justify-between flex-wrap sm:flex-nowrap"
                    >
                        <div class="">
                            <h3
                                class="text-lg leading-6 font-medium text-gray-900"
                            >
                                Filtro
                            </h3>
                        </div>
                        <div class="flex-shrink-0 flex item-center">
                            <button
                                v-if="Object.keys(this.filter).length"
                                class="text-xs font-medium text-gray-500 hover:text-gray-700 mr-2"
                                @click="clearFilter"
                            >
                                Limpiar Filtro
                            </button>
                            <button
                                type="button"
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                                @click="getEntrevistas()"
                            >
                                Aplicar Filtro
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 sm:col-span-3">
                            <label
                                for="name"
                                class="block text-sm font-medium text-gray-700"
                                >Nombre</label
                            >
                            <input
                                v-model="filter.name"
                                type="text"
                                name="name"
                                id="name"
                                autocomplete="name-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            />
                        </div>

                        <div class="col-span-12 sm:col-span-3">
                            <label
                                for="num_documento"
                                class="block text-sm font-medium text-gray-700"
                                >Documento</label
                            >
                            <input
                                v-model="filter.num_documento"
                                type="text"
                                name="num_documento"
                                id="num_documento"
                                autocomplete="address-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            />
                        </div>

                        <div class="col-span-12 sm:col-span-5">
                            <label
                                for="fecha"
                                class="block text-sm font-medium text-gray-700"
                                >Fecha</label
                            >
                            <Datepicker
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                v-model="filter.date"
                                range
                                multiCalendars
                                :closeOnAutoApply="true"
                                :enableTimePicker="false"
                                :format="customFormat"
                            ></Datepicker>
                        </div>

                        <div class="col-span-12 sm:col-span-3">
                            <label
                                for="estado"
                                class="block text-sm font-medium text-gray-700"
                                >Estado</label
                            >
                            <select
                                v-model="filter.estado"
                                name="estado"
                                id="estado"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            >
                                <option value="" selected>
                                    Selecciones un estado
                                </option>
                                <option
                                    v-for="estado in estados"
                                    :key="estado.id"
                                    :value="estado.id"
                                >
                                    {{ estado.nombre }}
                                </option>
                            </select>
                        </div>

                        <div class="col-span-12 sm:col-span-3">
                            <label
                                for="punto_entrega_id"
                                class="block text-sm font-medium text-gray-700"
                                >Sede</label
                            >
                            <select
                                v-model="filter.punto_entrega_id"
                                name="punto_entrega_id"
                                id="punto_entrega_id"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            >
                                <option value="" selected>
                                    Selecciones una sede
                                </option>
                                <option
                                    v-for="sede in sedes"
                                    :key="sede.id"
                                    :value="sede.id"
                                >
                                    {{ sede.description }}
                                </option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                            <label
                                for="entrevistador_id"
                                class="block text-sm font-medium text-gray-700"
                                >Entrevistador</label
                            >
                            <select
                                v-model="filter.entrevistador_id"
                                name="entrevistador_id"
                                id="entrevistador_id"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            >
                                <option value="" selected>
                                    Selecciones un entrevistador
                                </option>
                                <option
                                    v-for="entrevistador in entrevistadores"
                                    :key="entrevistador.id"
                                    :value="entrevistador.id"
                                >
                                    {{ entrevistador.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col mt-8 mx-4 sm:mx-6 lg:mx-8">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div
                    class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
                >
                    <div
                        class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
                    >
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        #
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Fecha
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Nombre
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        DNI
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Entrevistador
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Estado
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs text-center font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        <span>Acciones</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <ListItem
                                    v-for="item in entrevistas.data"
                                    :key="item.id"
                                    :item="item"
                                ></ListItem>
                            </tbody>
                        </table>
                        <hr />
                        <div
                            class="flex justify-between mx-5 my-3 px-2 items-center"
                        >
                            <div>
                                Mostrando: {{ this.entrevistas.from }} a
                                {{ this.entrevistas.to }} - Entradas
                                encontradas:
                                {{ this.entrevistas.total }}
                            </div>

                            <div class="flex flex-wrap -mb-1">
                                <div
                                    v-for="(link, index) in entrevistas.links"
                                    :key="index"
                                >
                                    <div
                                        v-if="link.url === null"
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded-md"
                                        v-html="link.label"
                                    ></div>
                                    <div
                                        v-else
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-gray-300 rounded-md hover:bg-blue-500 hover:text-white cursor-pointer"
                                        :class="
                                            ({ 'bg-blue-500': link.active },
                                            { 'text-white': link.active })
                                        "
                                        @click="
                                            getEntrevistasPaginate(link.url)
                                        "
                                        v-html="link.label"
                                    ></div>
                                </div>
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
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import ListItem from "./ListItem.vue";

import {
    ChevronRightIcon,
    EllipsisVerticalIcon,
    PencilSquareIcon,
    ArrowsPointingOutIcon,
    ArrowPathIcon,
    PaperClipIcon,
} from "@heroicons/vue/24/solid";
import Toast from "@/Layouts/Components/Toast.vue";
import store from "@/store.js";

const estadoClass = {
    APROBADA: "badgeStatus bg-green-600 text-green-100",
    PENDIENTE: "badgeStatus bg-gray-200 text-gray-800",
    RECHAZADA: "badgeStatus bg-red-600 text-red-100",
};

export default {
    props: {
        toast: Object,
        estados: Object,
        sedes: Object,
        entrevistadores: Object,
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
        Datepicker,
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
            customFormat: "d-M-Y",
            processReport: false,
            showImportar: false,
            entrevistas: [],
            estadoClass: estadoClass,

            processImport: false,
            formImport: false,
            file: "",

            showImportResult: false,
            importResult: "",
        };
    },
    setup() {
        return {
            store,
        };
    },
    methods: {
        async getEntrevistas() {
            let filter = `&length=${this.length}`;

            if (this.filter.name) {
                filter += `&name=${this.filter.name}`;
            }
            if (this.filter.num_documento) {
                filter += `&num_documento=${this.filter.num_documento}`;
            }
            if (this.filter.date) {
                filter += `&date=${JSON.stringify(this.filter.date)}`;
            }

            if (this.filter.punto_entrega_id) {
                filter += `&punto_entrega_id=${this.filter.punto_entrega_id}`;
            }

            if (this.filter.entrevistador_id) {
                filter += `&entrevistador_id=${this.filter.entrevistador_id}`;
            }
            if (this.filter.estado) {
                filter += `&estado=${this.filter.estado}`;
            }

            const get = `${route("collections.entrevistas.list")}?${filter}`;
            const response = await fetch(get, { method: "GET" });
            this.entrevistas = await response.json();
        },

        clearFilter() {
            this.filter = {};
            this.getEntrevistas();
        },

        clearMessage() {
            this.toastMessage = "";
        },

        async getEntrevistasPaginate(link) {
            var get = `${link}`;
            const response = await fetch(get, { method: "GET" });
            this.entrevistas = await response.json();
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
                let rt = route("collections.entrevistas.import");
                const formData = new FormData();
                formData.append("file", this.file);
                try {
                    const response = await axios.post(rt, formData);
                    if (response.status == 200) {
                        this.labelType = "success";
                        this.toastMessage = response.data.message;
                        this.buildImportResult(response.data);
                        this.getEntrevistas();
                    } else {
                        this.labelType = "danger";
                        this.toastMessage = response.data.message;
                    }
                    this.formImport = false;
                } catch (error) {
                    console.log(error);
                }
                this.processImport = false;
            } else {
                this.labelType = "info";
                this.toastMessage = "Debe seleccionar un archivo";
            }
        },

        handleFileChange(event) {
            this.file = event.target.files[0];
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
        this.getEntrevistas();
    },
};
</script>

<style>
.btn-green {
    @apply inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3;
}

.badgeStatus {
    @apply uppercase inline-flex items-center px-2 py-1 border border-transparent shadow-sm text-xs font-medium rounded-md;
}
</style>
