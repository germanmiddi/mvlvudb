<template>
    <div aria-labelledby="message-heading"
        class="min-w-0 flex-1 h-full flex flex-col overflow-hidden xl:order-last mt-10 px-4">
        <div class="min-h-0 flex-1 overflow-y-auto">
            <div class="bg-white pt-5 pb-6 shadow mt-2 rounded-lg">
                <div class="px-4 sm:flex sm:justify-between sm:items-center sm:px-6 lg:px-8">
                    <div class="sm:w-0 sm:flex-1">
                        <nav class="flex mt-1" aria-label="Breadcrumb">
                            <ol role="list" class="flex items-center space-x-2 text-xs">
                                <li>
                                    <div>
                                        <a href="#" class="text-gray-400 hover:text-gray-500">
                                            <HomeIcon class="flex-shrink-0 h-5 w-5" aria-hidden="true" />
                                            <span class="sr-only">Home</span>
                                        </a>
                                    </div>
                                </li>
                                <li v-for="page in pages" :key="page.name">
                                    <div class="flex items-center">
                                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"
                                            aria-hidden="true">
                                            <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                        </svg>
                                        <div class="ml-1 text-sm font-medium text-gray-500 hover:text-gray-700"
                                            :aria-current="page.current ? 'page' : undefined">
                                            {{ page.name }}</div>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div
                        class="mt-4 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                        <button type="submit" v-if="!this.showEditor" @click="showEditor = true"
                            class="inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Nueva
                            Prueba Pedagógica</button>
                        <button type="submit" v-else @click="showEditor = false"
                            class="inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancelar</button>
                    </div>
                </div>
            </div>

            <ul v-if="!showEditor" role="list" class="py-4 space-y-2 sm:space-y-4 ">
                <li v-for="pedagogia in legajo[0].pedagogia" :key="pedagogia.key"
                    class="bg-white px-4 py-6 shadow sm:rounded-lg sm:px-6">
                    <PedagogiaGrid :pedagogia="pedagogia" @fnEditor="fnEditor" @fnDelete="fnDelete" />
                </li>
            </ul>

            <div v-else class="shadow mt-2 rounded-lg">
                <div class="bg-white pt-5 pb-6 mt-2  px-4">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Detalle de la Prueba</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Edita los campos necesarios</p>
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-5">
                        <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Fecha:
                        </label>
                        <div class="mt-1 col-span-2">
                            <Datepicker
                                class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                :class="{ 'border border-red-500': errors.fecha_prueba }" v-model="form.fecha_prueba"
                                :disabled="input_disable" :monthChangeOnScroll="false" autoApply :format="format">
                            </Datepicker>
                            <span v-if="errors.fecha_prueba" class="text-red-500 text-xs mt-1 col-span-2"> {{
                                errors.fecha_prueba }} </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-5">
                        <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Estado:
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select v-model="form.estado_id" id="estado_id" name="estado_id" autocomplete="off"
                                :class="{ 'border-red-500': errors.estado_id }" :disabled="input_disable"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled>
                                    Seleccione un estado
                                </option>
                                <option v-for="estados in estadosPedagogia" :key="estados.id" :value="estados.id">
                                    {{ estados.description ?? '' }}
                                </option>
                            </select>
                            <span v-if="errors.estado_id" class="text-red-500 text-xs"> {{ errors.estado_id }} </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-5 pb-5">
                        <label for="first-name"
                            class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Profesional:
                        </label>
                        <div class="mt-1 col-span-2">
                            <input type="text" id="profesional" v-model="form.profesional"
                                placeholder="Escribe el nombre del profesional..."
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                        </div>
                    </div>

                    <label for="first-name"
                        class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 pb-2">Detalles:</label>
                    <QuillEditor theme="snow" ref="editor" v-model:content="form.detalles" content-type="html" />
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-end">
                    <button @click="this.showEditor = false, this.form = {}" type="button"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">Cancelar</button>
                    <button v-if="!edit" @click="storePedagogia()"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                    <button v-else @click="updatePedagogia()"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

import PedagogiaGrid from './PedagogiaGrid.vue';

import { Bars4Icon, HomeIcon } from '@heroicons/vue/24/solid';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';

import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

import store from '@/store.js';

const pages = [
    { name: 'Legajo', href: '#', current: false },
    { name: 'Pedagogía', href: '#', current: true },
]

export default {
    props: {
        legajo: Object,
        estadosPedagogia: Object,
    },
    components: {
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        Bars4Icon,
        HomeIcon,
        QuillEditor,
        Datepicker,
        PedagogiaGrid
    },

    setup() {
        const format = (date) => {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            return `${day}/${month}/${year}`;
        };

        return {
            format,
            pages,
            store
        }
    },
    data() {
        return {
            form: {
                estado_id: '',
                fecha_prueba: '',
            },
            showEditor: false,
            edit: false,
            errors: {},
        }
    },
    methods: {
        validate() {
            this.errors = {};

            if (!this.form.fecha_prueba) this.errors.fecha_prueba = "La fecha de la Prueba es obligatoria";
            if (!this.form.estado_id) this.errors.estado_id = "El estado de la Prueba es obligatoria";

            return Object.keys(this.errors).length === 0;
        },
        async storePedagogia() {
            const isValid = await this.validate();

            if (isValid) {
                let data = {}
                // RUTA
                let rt = route("legajoCB.storePedagogia");
                this.form.legajo_id = this.legajo[0].id

                try {
                    const response = await axios.post(rt, this.form);
                    if (response.status === 200) {
                        data.message = response.data.message
                        data.labelType = 'success'
                        this.showEditor = false
                        this.form = {}
                        this.legajo[0].pedagogia = response.data.pedagogias[0].pedagogia
                    } else {
                        data.message = response.data.message
                        data.labelType = 'info'
                    }
                } catch (error) {
                    data.message = "Se ha producido un error | Por Favor Comuniquese con el Administrador!"
                    data.labelType = 'danger'
                }
                this.$emit('message', data)
            }
        },
        async updatePedagogia() {
            const isValid = await this.validate();

            if (isValid) {
                let data = {}
                // RUTA
                let rt = route("legajoCB.updatePedagogia");

                try {
                    const response = await axios.put(rt, this.form);
                    if (response.status === 200) {
                        data.message = response.data.message
                        data.labelType = 'success'
                        this.showEditor = false
                        this.edit = false
                        this.form = {}
                        this.legajo[0].pedagogia = response.data.pedagogias[0].pedagogia
                    } else {
                        data.message = response.data.message
                        data.labelType = 'info'
                    }
                } catch (error) {
                    data.message = "Se ha producido un error | Por Favor Comuniquese con el Administrador!";
                    data.labelType = 'danger';
                }
                this.$emit('message', data)
            }
        },

        fnEditor(data) {
            this.showEditor = data.showEditor
            this.edit = true
            this.form = data.form
        },
        async fnDelete(id) {
            let data = {}
            // RUTA
            let rt = route("legajoCB.deletePedagogia", id);

            try {
                const response = await axios.delete(rt);
                if (response.status === 200) {
                    data.message = response.data.message
                    data.labelType = 'success'
                    this.showEditor = false
                    this.form = {}
                    this.legajo[0].pedagogia = response.data.pedagogias[0].pedagogia
                } else {
                    data.message = response.data.message
                    data.labelType = 'info'
                }
            } catch (error) {
                data.message = "Se ha producido un error | Por Favor Comuniquese con el Administrador!"
                data.labelType = 'danger'
            }
            this.$emit('message', data)
        }
    },

}
</script>

<style scope>
.ql-toolbar {
    border-radius: 15px 15px 0px 0px;
}

.ql-container {
    border-radius: 0px 0px 15px 15px;
    height: 300px;
}
</style>