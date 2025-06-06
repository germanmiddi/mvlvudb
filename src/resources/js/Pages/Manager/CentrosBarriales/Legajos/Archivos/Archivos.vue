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
                                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                            fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
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

                    <div class="mt-4 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                        <button type="submit" v-if="!this.showEditor" @click="showEditor = true"
                            class="inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Nuevo
                            Archivo</button>
                        <button type="submit" v-else @click="showEditor = false"
                            class="inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancelar</button>
                    </div>
                </div>
            </div>

            <!-- Mensaje de errores de validación -->
            <div v-if="v$.form.$error" class="px-4 mt-6 sm:px-6 lg:px-8">
                <div class="px-4 mt-6 sm:px-6 lg:px-8 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md"
                    role="alert">
                    <p class="font-bold">Campos requeridos</p>
                    <p v-for="error of v$.form.$errors" :key="error.$uid">
                        {{ error.$message }}
                    </p>
                </div>
            </div>

            <!-- Thread section-->
            <ul v-if="!showEditor" role="list" class="py-4 space-y-2 sm:space-y-4 ">
                <li v-for="archivo in legajo[0].archivos" :key="archivo.key"
                    class="bg-white px-4 py-6 shadow sm:rounded-lg sm:px-6">
                    <ArchivosGrid :archivo="archivo" @fnDelete="fnDelete" />
                </li>
            </ul>

            <div v-else class="shadow mt-2 rounded-lg">
                <div class="bg-white pt-5 pb-6 mt-2  px-4">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Nuevo Archivo/Documento</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Seleccione el area y el archivo a subir</p>
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-5">
                        <label for="first-name"
                            class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Descripción: </label>
                        <div class="mt-1 col-span-2">
                            <input type="text" v-model="form.description"
                                :class="v$.form.description.$error ? 'border-red-500' : ''"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                            <span v-if="v$.form.description.$error" class="text-red-500 text-xs">Campo obligatorio</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 py-5">
                        <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Area:
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select v-model="form.area_id" id="area_id" name="area_id" autocomplete="off"
                                :class="v$.form.area_id.$error ? 'border-red-500' : ''"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled>
                                    Seleccione un Area
                                </option>
                                <option v-for="a in areas" :key="a.id" :value="a.id">
                                    {{ a.description ?? '' }}
                                </option>
                            </select>
                            <span v-if="v$.form.area_id.$error" class="text-red-500 text-xs">Campo obligatorio</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-5">
                        <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Archivo:
                        </label>
                        <div class="mt-1 col-span-2">
                            <label
                                :class="v$.form.file.$error ? 'border-red-500' : ''"
                                class=" w-full justify-center relative flex flex-col items-center px-2 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:border-gray-150 hover:bg-gray-100 hover:text-gray-500">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                </svg>
                                <span v-if="!file" class="mt-2 text-base leading-normal">Seleccione Archivo</span>
                                <span v-else class="mt-2 text-base leading-normal text-center">{{ fileName }}</span>
                                <input @change="handleFileChange" type="file" name="file" id="file" ref="inputfile"
                                    autocomplete="off" class="hidden" />
                            </label>
                            <span v-if="v$.form.file.$error" class="text-red-500 text-xs">Campo obligatorio</span>
                        </div>
                    </div>

                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-end">
                    <button @click="this.showEditor = false; resetForm()" type="button"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">Cancelar</button>
                    <button @click="storeArchivo()"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ArchivosGrid from './ArchivosGrid.vue';
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import store from '@/store.js';
import { Bars4Icon, HomeIcon } from '@heroicons/vue/24/solid';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { useVuelidate } from '@vuelidate/core'
import { required, helpers } from '@vuelidate/validators'

const pages = [
    { name: 'Legajo', href: '#', current: false },
    { name: 'Archivos', href: '#', current: true },
]

export default {
    props: {
        legajo: Object,
        users: Object,
        areas: Object
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
        ArchivosGrid
    },
    validations() {
        return {
            form: {
                description: { required: helpers.withMessage('El campo Descripción es obligatorio', required) },
                area_id: { required: helpers.withMessage('El campo Area es obligatorio', required) },
                file: { required: helpers.withMessage('Debe seleccionar un archivo', required) }
            }
        }
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
            store,
            v$: useVuelidate()
        }
    },
    data() {
        return {
            form: {},
            showDetail: false,
            showEditor: false,
            file: '',
            fileName: '',
        }
    },
    methods: {
        async storeArchivo() {
            // Validar antes de enviar
            const result = await this.v$.$validate()
            if (!result) {
                return
            }

            let data = {}
            // RUTA
            let rt = route("legajoCB.storeArchivo");
            const formData = new FormData();
            formData.append("legajo_id", this.legajo[0].id);
            formData.append("area_id", this.form.area_id);
            formData.append("file", this.file);
            formData.append("description", this.form.description);

            try {
                const response = await axios.post(rt, formData);
                if (response.status == 200) {
                    data.message = response.data.message
                    data.labelType = 'success'
                    this.showEditor = false
                    this.resetForm()
                    this.legajo[0].archivos = response.data.archivos[0].archivos
                } else {
                    data.message = response.data.message
                    data.labelType = 'info'
                }
            } catch (error) {
                console.log(error)
                data.message = "Se ha producido un error | Por Favor Comuniquese con el Administrador!"
                data.labelType = 'danger'
            }
            this.$emit('message', data)
        },
        fnEditor(data) {
            this.showDetail = data.showDetail
            this.showEditor = data.showEditor
        },
        handleFileChange(event) {
            this.file = event.target.files[0];
            this.fileName = this.file ? this.file.name : '';
            // Actualizar la validación del archivo
            this.form.file = this.file;
        },
        resetForm() {
            this.form = {};
            this.file = '';
            this.fileName = '';
            this.v$.$reset();
        },
        async fnDelete(id) {
            let data = {}
            // RUTA
            let rt = route("legajoCB.deleteArchivo", id);

            try {
                const response = await axios.delete(rt);
                if (response.status == 200) {
                    data.message = response.data.message
                    data.labelType = 'success'
                    this.showEditor = false
                    this.resetForm()
                    this.legajo[0].archivos = response.data.archivos[0].archivos
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

<style scope>.ql-toolbar {
    border-radius: 15px 15px 0px 0px;
}

.ql-container {
    border-radius: 0px 0px 15px 15px;
    height: 300px;
}</style>
