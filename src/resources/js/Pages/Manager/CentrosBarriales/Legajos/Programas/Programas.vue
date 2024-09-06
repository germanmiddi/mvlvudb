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
                        <button type="submit" v-if="this.showList" @click="showView('new_programa')"
                            class="inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Nuevo
                            Programa</button>
                        <button type="submit" v-if="this.showCreate" @click="showView('init')"
                            class="inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancelar</button>
                        <Menu v-if="this.showDetail" as="div" class="ml-3 relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="-my-2 rounded-full bg-white flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                    <span class="sr-only">Open options</span>
                                    <Bars4Icon class="h-5 w-5" aria-hidden="true" />
                                </MenuButton>
                            </div>

                            <transition enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95">
                                <MenuItems
                                    class="z-50 origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="py-1">
                                        <MenuItem v-slot="{ active }">
                                        <button type="button" @click="this.showView('new_intervencion')"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                            <span>Nueva Intervención</span>
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <button type="button"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                            <span>Cambiar Estado</span>
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <a @click="showView('init')"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex justify-between px-4 py-2 text-sm']">
                                            <span>Cancelar</span>
                                        </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </div>

            <DetailComponent v-if="this.showDetail" :item="this.programaSelected" @updateEstadoPrograma="updateEstadoPrograma" />

            <div class="bg-white pt-5 pb-2 shadow mt-2 rounded-lg" v-if="this.showCreate">
                <div class="bg-white pt-5 pb-6 mt-2  px-4">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Alta de Programa</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Ingrese un nuevo programa asociado al legajo.
                        </p>
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-5">
                        <label for="first-name"
                            class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Programa Social:
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select v-model="form.programa_social_id" id="programa_social_id" name="programa_social_id"
                                autocomplete="off" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled>
                                    Seleccione un Programa
                                </option>
                                <option v-for="a in programasSociales" :key="a.id" :value="a.id">
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

                    <div class="grid grid-cols-3 gap-4 pt-5 pb-5">
                        <label for="first-name"
                            class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Profesional:
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select v-model="form.profesional_id" id="profesional_id" name="profesional_id"
                                autocomplete="off" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled>
                                    Seleccione un Profesional
                                </option>
                                <option v-for="p in users" :key="p.id" :value="p.id">
                                    {{ p.name ?? '' }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-end">
                    <button @click="showView('init'), this.form = {}" type="button"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">Cancelar</button>
                    <button @click="storePrograma()"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                </div>
            </div>

            <div class="py-4 space-y-2 sm:space-y-4 " v-if="this.showDetail">
                <div v-if="this.showDetail" v-for="item in this.programaSelected.intervenciones" :key="item.id">
                    <IntervencionComponent v-if="item.activo" :intervencion="item"
                        @fnEditorIntervencion="fnEditorIntervencion" @fnDelete="fnDelete" />
                </div>
            </div>

            <div class="bg-white pt-5 pb-2 shadow mt-2 rounded-lg" v-if="this.showIntervencion || this.showEditor">
                <div class="bg-white pt-5 pb-6 mt-2  px-4">
                    <div v-if="showIntervencion">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Alta de Nueva intervención</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Ingrese un nuevo detalle de la intervención.
                        </p>
                    </div>

                    <div v-if="showEditor">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Editar intervención</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Ingrese nuevo detalle de la intervención.
                        </p>
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-5">
                        <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Fecha:
                        </label>
                        <div class="mt-1 col-span-2">
                            <Datepicker
                                class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                v-model="form.fecha" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                                :enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
                            </Datepicker>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 py-5">
                        <label for="first-name"
                            class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Profesional:
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select v-model="form.profesional_id" id="profesional_id" name="profesional_id"
                                autocomplete="off" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled>
                                    Seleccione un Profesional
                                </option>
                                <option v-for="p in users" :key="p.id" :value="p.id">
                                    {{ p.name ?? '' }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <QuillEditor theme="snow" ref="editor" v-model:content="form.description" content-type="html" />

                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-end">
                    <button @click="showView('detail'), this.form = {}" type="button"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">Cancelar</button>
                    <button v-if="showIntervencion" @click="storeIntervencion()"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                    <button v-if="showEditor" @click="updateIntervencion()"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Actualizar</button>
                </div>
            </div>

            <!-- eslint-disable -->
            <ul v-if="showList" role="list" class="grid gap-6 grid-cols-2 mt-10">
                <li v-for="programa in legajo[0].programas_sociales" :key="programa.key"
                    class="col-span-1 bg-white rounded-lg shadow divide-y divide-gray-200">
                    <ProgramasGrid :programa="programa" @fnEditor="fnEditor" />
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
import ProgramasGrid from './ProgramasGrid.vue'
import IntervencionComponent from './Intervencion.vue'
import DetailComponent from './Detail.vue'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import store from '@/store.js'

const pages = [
    { name: 'Legajo', href: '#', current: false },
    { name: 'Programas', href: '#', current: true },
]

export default {
    props: {
        legajo: Object,
        users: Object,
        programasSociales: Object,
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
        ProgramasGrid,
        Datepicker,
        IntervencionComponent,
        DetailComponent
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
            programaSelected: {},

            showList: true,
            showCreate: false,
            showEditor: false,
            showDetail: false,
            showIntervencion: false
        }
    },
    methods: {
        async storePrograma() {
            let data = {}
            this.form.legajo_id = this.legajo[0].id
            let rt = route("legajoCB.storeProgramaSocial");
            try {
                const response = await axios.post(rt, this.form);
                if (response.status == 200) {
                    data.message = response.data.message
                    data.labelType = 'success'
                    this.showView('init')
                    this.legajo[0].programas_sociales = response.data.programas[0].programas_sociales
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
        async storeIntervencion() {
            let data = {}
            this.form.programa_social_id = this.programaSelected.id
            // RUTA
            let rt = route("legajoCB.storeIntervencion");

            try {
                const response = await axios.post(rt, this.form);
                if (response.status == 200) {
                    data.message = response.data.message
                    data.labelType = 'success'
                    this.showDetail = false
                    this.showEditor = false
                    this.form = {}
                    this.legajo[0].programas_sociales.forEach(element => {
                        if (element.id === response.data.programas[0].id) {
                            element.intervenciones = response.data.programas[0].intervenciones
                        }
                    });
                    this.showView('detail')
                } else {
                    data.message = response.data.message
                    data.labelType = 'info'
                }
            } catch (error) {
                data.message = "Se ha producido un error | Por Favor Comuniquese con el Administrador!"
                data.labelType = 'danger'
            }
            this.$emit('message', data)
        },
        async fnDelete(id) {
            let data = {}
            // RUTA
            let rt = route("legajoCB.deleteProgramaIntervencion", id);

            try {
                const response = await axios.delete(rt);
                if (response.status == 200) {
                    data.message = response.data.message
                    data.labelType = 'success'
                    this.form = {}
                    this.legajo[0].programas_sociales.forEach(element => {
                        if (element.id === response.data.programas[0].id) {
                            element.intervenciones = response.data.programas[0].intervenciones
                        }
                    });
                } else {
                    data.message = response.data.message
                    data.labelType = 'info'
                }
            } catch (error) {
                data.message = "Se ha producido un error | Por Favor Comuniquese con el Administrador!"
                data.labelType = 'danger'
            }
            this.$emit('message', data)
        },
        async updateIntervencion() {
            let data = {}
            let rt = route("legajoCB.updateProgramaIntervencion");
            try {
                const response = await axios.put(rt, this.form);
                if (response.status == 200) {
                    data.message = response.data.message
                    data.labelType = 'success'
                    this.form = {}
                    this.legajo[0].programas_sociales.forEach(element => {
                        if (element.id === response.data.programas[0].id) {
                            element.intervenciones = response.data.programas[0].intervenciones
                        }
                    });
                    this.showView('detail')
                } else {
                    data.message = response.data.message
                    data.labelType = 'info'
                }
            } catch (error) {
                data.message = "Se ha producido un error | Por Favor Comuniquese con el Administrador!"
                data.labelType = 'danger'
            }
            this.$emit('message', data)
        },
        async updateEstadoPrograma(data) {
            let msg = {}
            let rt = route("legajoCB.updateEstadoPrograma", data.id);

            try {
                const response = await axios.put(rt, {'estado_id':data.estado_id});
                if (response.status == 200) {
                    msg.message = response.data.message
                    msg.labelType = 'success'
                    this.legajo[0].programas_sociales.forEach(element => {
                        if (element.id === response.data.programas[0].id) {
                            element.estado = response.data.programas[0].estado
                        }
                    });
                    this.showView('detail')
                } else {
                    msg.message = response.data.message
                    msg.labelType = 'info'
                }
            } catch (error) {
                msg.labelType = "danger";
                msg.message = "Se ha producido un error | Por Favor Comuniquese con el Administrador!"
            }
            this.$emit('message', msg)
        },
        fnEditor(data) {
            this.showView(data.action)
            this.programaSelected = data.data
        },
        fnEditorIntervencion(data) {
            this.showView(data.action)
            this.form = data.data
            this.form.fecha = this.form.fecha ? new Date(this.form.fecha + "T00:00:00.000-03:00") : null
        },
        showView(accion) {
            switch (accion) {
                case 'init': // Estado inicial - visualiza todos los programas
                    this.showList = true
                    this.showCreate = false
                    this.showEditor = false
                    this.showDetail = false
                    this.showIntervencion = false
                    break;
                case 'new_programa': // Visualiza el formulario para cargar un nuevo programa social
                    this.showList = false
                    this.showCreate = true
                    this.showEditor = false
                    this.showDetail = false
                    this.showIntervencion = false
                    break;
                case 'detail': // Selecciona un programa y visualiza todas las intervenciones
                    this.showList = false
                    this.showCreate = false
                    this.showEditor = false
                    this.showDetail = true
                    this.showIntervencion = false
                    break;
                case 'new_intervencion': // Permite crear una nueva intervencion asociada a un programa
                    this.showList = false
                    this.showCreate = false
                    this.showEditor = false
                    this.showDetail = false
                    this.showIntervencion = true
                    break;
                case 'edit_intervencion': // Permit editar una intervencion.
                    this.showList = false
                    this.showCreate = false
                    this.showEditor = true
                    this.showDetail = false
                    this.showIntervencion = false
                    break;
                default:
                    break;
            }
        },
        messageToast(data) {
            this.$emit('message', data);
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
