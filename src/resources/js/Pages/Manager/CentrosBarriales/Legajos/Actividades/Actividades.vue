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
                        <button type="submit" v-if="this.showList" @click="showView('new_actividad')"
                            class="inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Nueva
                            Actividad</button>
                        <button type="submit" v-if="this.showCreate" @click="showView('init')"
                            class="inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancelar</button>
                    </div>
                </div>

            </div>
            <div class="bg-white pt-5 pb-2 shadow mt-2 rounded-lg" v-if="this.showCreate">
                <div class="bg-white pt-5 pb-6 mt-2  px-4">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Alta de Actividad</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Ingrese una nueva actividad asociado al
                            legajo.
                        </p>
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-5">
                        <label for="first-name"
                            class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Actividad:
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select v-model="form.actividad_id" id="actividad_id" name="actividad_id" autocomplete="off"
                                :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled>
                                    Seleccione una Actividad
                                </option>
                                <option v-for="a in actividades" :key="a.id" :value="a.id">
                                    {{ a.description ?? '' }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-5">
                        <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Fecha:
                        </label>
                        <div class="mt-1 col-span-2">
                            <Datepicker
                                class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                v-model="form.fecha_inscripcion" :disabled="input_disable"
                                :class="input_disable ? bg_disable : ''" :enableTimePicker="false"
                                :monthChangeOnScroll="false" autoApply :format="format">
                            </Datepicker>
                        </div>
                    </div>

                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-end">
                    <button @click="showView('init'), this.form = {}" type="button"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">Cancelar</button>
                    <button @click="storeActividad()"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                </div>
            </div>
            <!-- eslint-disable -->
            <ul v-if="showList" role="list" class="grid gap-6 grid-cols-2 mt-10">
                <li v-for="actividad in legajo[0].actividades" :key="actividad.key"
                    class="col-span-1 bg-white rounded-lg shadow divide-y divide-gray-200">
                    <ActividadesGrid :actividad="actividad" />
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import {
    PhoneIcon,
    Bars4Icon,
    HomeIcon,
    EllipsisVerticalIcon,
    ChevronDownIcon,
    TrashIcon,
    PencilSquareIcon,
    UserCircleIcon,
    CalendarIcon
} from '@heroicons/vue/24/solid'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import ActividadesGrid from './ActividadesGrid.vue'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import store from '@/store.js'

const pages = [
    { name: 'Legajo', href: '#', current: false },
    { name: 'Actividades', href: '#', current: true },
]

export default {
    props: {
        legajo: Object,
        users: Object,
        actividades: Object,
    },
    components: {
        PhoneIcon,
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        Bars4Icon,
        HomeIcon,
        EllipsisVerticalIcon,
        ChevronDownIcon,
        TrashIcon,
        PencilSquareIcon,
        UserCircleIcon,
        CalendarIcon,
        QuillEditor,
        ActividadesGrid,
        Datepicker,
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
            form: {},
            showList: true,
            showCreate: false
        }
    },
    methods: {
        async storeActividad() {
            let data = {}
            this.form.legajo_id = this.legajo[0].id
            let rt = route("legajoCB.storeActividad");
            try {
                const response = await axios.post(rt, this.form);
                if (response.status == 200) {
                    data.message = response.data.message
                    data.labelType = 'success'
                    this.showView('init')
                    this.legajo[0].actividades = response.data.actividades[0].actividades
                } else {
                    data.message = response.data.message
                    data.labelType = 'info'
                }
            } catch (error) {
                console.log(error)
                data.labelType = "danger";
                data.message = "Se ha producido un error | Por Favor Comuniquese con el Administrador!"
            }
            this.$emit('message', data)
        },
        showView(accion) {
            switch (accion) {
                case 'init':
                    this.showList = true
                    this.showCreate = false
                    break;
                case 'new_actividad':
                    this.showList = false
                    this.showCreate = true
                    break;
                default:
                    break;
            }
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
