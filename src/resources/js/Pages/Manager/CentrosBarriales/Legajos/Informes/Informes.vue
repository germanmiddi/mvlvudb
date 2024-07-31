<template>
    <div aria-labelledby="message-heading"
        class="min-w-0 flex-1 h-full flex flex-col overflow-hidden xl:order-last mt-10 px-4">
        <div class="min-h-0 flex-1 overflow-y-auto">
            <div class="bg-white pt-5 pb-6 shadow mt-2 rounded-lg">
                <div class="px-4 sm:flex sm:justify-between sm:items-center sm:px-6 lg:px-8">
                    <div class="sm:w-0 sm:flex-1">
                        <h1 id="message-heading" class="text-lg font-medium text-gray-900">
                            {{ this.programaSelected.programa_social?.description ?? '' }}
                        </h1>
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
                                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                        </svg>
                                        <div
                                            class="ml-1 text-sm font-medium text-gray-500 hover:text-gray-700" :aria-current="page.current ? 'page' : undefined">
                                            {{ page.name }}</div>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="mt-4 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">                        
                        <Menu as="div" class="ml-3 relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="-my-2 p-2 rounded-full bg-white flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
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
                                        <MenuItem v-slot="{ active }" v-if="!showEditor">
                                            <button type="button" @click="showEditor = true"
                                                :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                                <span>Nuevo Informe</span>
                                            </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }" v-else>
                                            <button type="button" @click="showEditor = false"
                                                :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                                <span>Cancelar Informe</span>
                                            </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <button type="button"
                                                :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                                <span>Estado</span>
                                            </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <a href="#"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex justify-between px-4 py-2 text-sm']">
                                            <span>Asignar</span>
                                        </a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <a href="#"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex justify-between px-4 py-2 text-sm']">
                                            <span>Finalizar</span>
                                        </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </div>
            <!-- Thread section-->
            <ul v-if="!showEditor" role="list" class="py-4 space-y-2 sm:space-y-4 ">
                <li v-for="informe in legajo[0].informes" :key="informe.key" class="bg-white px-4 py-6 shadow sm:rounded-lg sm:px-6">
                    <InformesGrid :informe="informe" />
                </li>
            </ul>

            <div v-else class="shadow mt-2 rounded-lg">
                <div class="bg-white pt-5 pb-6 mt-2  px-4">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Detalle del Informe</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum, odit magnam.</p>
                    </div>            
                
                    <div class="grid grid-cols-3 gap-4 pt-5">
                        <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Fecha: </label>
                        <div class="mt-1 col-span-2">
                            <Datepicker
                                class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                v-model="form.fecha_informe"
                                :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                                :enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
                            </Datepicker>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-4 py-5">
                        <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Profesional: </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select v-model="form.profesional_id" id="profesional_id" name="profesional_id"
                                autocomplete="off"
                                :class="input_disable ? bg_disable : ''"
                                :disabled="input_disable"
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
                    <QuillEditor theme="snow" ref="editor" v-model:content="form.description" content-type="html"/>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-end">
                    <button @click="this.showEditor=false" type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">Cancelar</button>
                    <button @click="storeInforme()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

import InformesGrid from './InformesGrid.vue';

import { Bars4Icon, HomeIcon } from '@heroicons/vue/24/solid';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';

import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

import store from '@/store.js';

const pages = [
  { name: 'Legajo', href: '#', current: false },
  { name: 'Informes', href: '#', current: true },
]

export default {
    props: {
        legajo: Object,
        users: Object
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
        InformesGrid
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
            showEditor: false,
            programaSelected: {}
        }
    },
    methods: {
        async storeInforme(){
            let data = {}
            // RUTA
            let rt = route("legajoCB.storeInforme");
            this.form.legajo_id = this.legajo[0].id

            try {
                const response = await axios.post(rt, this.form);
                if (response.status == 200) {
                    data.message = response.data.message
                    data.labelType = 'success'
                    this.showEditor = false
                    this.form = {}
                    this.legajo[0].informes =  response.data.informes[0].informes
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
        fnEditor(data){
            this.showEditor = data.showEditor
            this.programaSelected = data.programa
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