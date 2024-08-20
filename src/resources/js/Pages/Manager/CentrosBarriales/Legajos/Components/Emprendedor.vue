<template>
    <div class="px-4 mt-10">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="sm:flex sm:justify-between sm:items-center">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Emprendedores</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles Emprendedores</p>
                </div>
                <div v-if="!editData"
                    class="mt-4 mr-2 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                    <Menu as="div" class="ml-3 relative inline-block text-left">
                        <div>
                            <MenuButton
                                class="-my-2 p-2 rounded-full bg-white flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <span class="sr-only">Open options</span>
                                <Bars4Icon class="h-5 w-5" aria-hidden="true" />
                            </MenuButton>
                        </div>

                        <transition enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <MenuItems
                                class="z-50 origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <div class="py-1">
                                    <MenuItem v-slot="{ active }">
                                    <button type="button" @click="editData = true"
                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                        <span>Editar</span>
                                    </button>
                                    </MenuItem>
                                    <!-- <MenuItem v-slot="{ active }" :disabled="true">
                                    <button type="button"
                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                        <span>Nuevo Informe</span>
                                    </button>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                    <a href="#"
                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex justify-between px-4 py-2 text-sm']">
                                        <span>Adjuntar Archivo</span>
                                    </a>
                                    </MenuItem> -->
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
                <div v-else
                    class="mt-4 mr-4 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                    <button type="submit" @click="editData = false, updateLegajo()"
                        class="ml-1 inline-flex items-center px-4 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                    <button type="submit" @click="editData = false, resetForm()"
                        class="ml-1 inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancelar</button>
                </div>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Participa</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.participa ? 'SI' : 'NO' }}</dd>

                        <Switch v-else v-model="form.participa" @click="form.participa = !form.participa"
                            :class="form.participa ? 'bg-blue-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11  items-center rounded-full">
                            <span :class="form.participa ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                        </Switch>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fecha inscripción</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.fecha_inscripcion ?
                                store.dateTimeFormateada(this.form.fecha_inscripcion) : '-' }}</dd>
                        <Datepicker v-else
                            class="sm:col-span-2 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            v-model="this.form.fecha_inscripcion" :disabled="input_disable"
                            :class="input_disable ? bg_disable : ''" :enableTimePicker="false"
                            :monthChangeOnScroll="false" autoApply :format="format">
                        </Datepicker>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fecha finalización</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.fecha_finalizacion ?
                                store.dateTimeFormateada(this.form.fecha_finalizacion) : '-' }}</dd>
                        <Datepicker v-else
                            class="sm:col-span-2 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            v-model="this.form.fecha_finalizacion" :disabled="input_disable"
                            :class="input_disable ? bg_disable : ''" :enableTimePicker="false"
                            :monthChangeOnScroll="false" autoApply :format="format">
                        </Datepicker>
                    </div>

                    
                </dl>
            </div>
        </div>
    </div>
</template>

<script>
import { PencilSquareIcon, Bars4Icon } from '@heroicons/vue/24/solid'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import store from '@/store.js'

export default {
    props: {
        legajo: Object,
    },
    components: {
        PencilSquareIcon, Bars4Icon, Datepicker, Menu, MenuButton, MenuItems, MenuItem
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
            store
        }
    },
    data() {
        return {
            editData: false,
            form: {},
            form_temp: {}
        }
    },
    methods: {
        initForm() {
            this.form = {}
            this.form.id = this.legajo[0].id

            this.form.fecha_inscripcion = this.legajo[0].emprendedor?.fecha_inscripcion ?? null
            this.form.fecha_finalizacion = this.legajo[0].emprendedor?.fecha_finalizacion ?? null
            this.form.participa = this.legajo[0].emprendedor?.participa ?? null


            // Registro datos temporales PreEdicion
            this.form_temp = JSON.parse(JSON.stringify(this.form));
        },
        resetForm() {
            this.form = JSON.parse(JSON.stringify(this.form_temp));
        },
        async updateLegajo() {
            let data = {}
            // RUTA
            let rt = route("legajoCB.updateLegajoEmprendedor");
            // Actualiza el Form
    
            try {
                const response = await axios.put(rt, this.form);
                if (response.status == 200) {
                    data.message = response.data.message
                    data.labelType = 'success'
                    this.editData = false
                    this.form_temp = this.form
                } else {
                    data.message = response.data.message
                    data.labelType = 'info'
                    this.form = this.form_temp
                }
            } catch (error) {
                data.message = "Se ha producido un error | Por Favor Comuniquese con el Administrador!"
                data.labelType = 'danger'
                this.form = this.form_temp
            }
            this.$emit('message', data)
        }
    },
    created() {
        this.initForm()
    },
}
</script>
