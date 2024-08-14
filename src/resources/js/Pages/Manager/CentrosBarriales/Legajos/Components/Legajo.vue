<template>
    <div class="px-4 mt-10">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="sm:flex sm:justify-between sm:items-center">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Legajo N°: {{ this.form.id }}</h3>
                </div>
                <div v-if="!editData"
                    class="mt-4 mr-2 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                    <a @click="editData = true" title="Editar"
                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-2 py-2 text-sm']">
                        <PencilSquareIcon class="h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                    </a>
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
                        <dt class="text-sm font-medium text-gray-500">Semaforo:</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div
                                class="mt-4 mr-2 flex items-center justify-between sm:mt-0 sm:flex-shrink-0 sm:justify-start">
                                <Menu as="div" class="relative inline-block text-left">
                                    <div>
                                        <MenuButton
                                            class=" p-2 rounded-full bg-white flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                            <SunIcon class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                                                aria-hidden="true" />

                                            <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
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
                                            <div class="py-1 z-50">
                                                <MenuItem v-slot="{ active }">
                                                <button type="button"
                                                    :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                                    <span>
                                                        <SunIcon
                                                            class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                                                            aria-hidden="true" />
                                                    </span>
                                                </button>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }">
                                                <button type="button"
                                                    :class="[active ? 'bg-gray-100 text-red-900' : 'text-red-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                                    <span>
                                                        <SunIcon class="mr-3 h-6 w-6 text-red-400 group-hover:text-red-500"
                                                            aria-hidden="true" />
                                                    </span>
                                                </button>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }">
                                                <button type="button"
                                                    :class="[active ? 'bg-yellow-100 text-red-900' : 'text-yellow-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                                    <span>
                                                        <SunIcon
                                                            class="mr-3 h-6 w-6 text-yellow-400 group-hover:text-yellow-500"
                                                            aria-hidden="true" />
                                                    </span>
                                                </button>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }">
                                                <button type="button"
                                                    :class="[active ? 'bg-gray-100 text-green-900' : 'text-green-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                                    <span>
                                                        <SunIcon
                                                            class="mr-3 h-6 w-6 text-green-400 group-hover:text-green-500"
                                                            aria-hidden="true" />
                                                    </span>
                                                </button>
                                                </MenuItem>
                                            </div>
                                        </MenuItems>
                                    </transition>
                                </Menu>
                            </div>


                        </dd>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Tipo Legajo:</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                                legajo[0].tipo_legajo?.description ?? '-' }}</dd>

                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fecha de Ingreso:</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{ legajo[0].created_at ?
                                store.fechaFormateada(legajo[0].created_at) : '-' }}</dd>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Última actualización</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ legajo[0].updated_at ?
                                store.fechaFormateada(legajo[0].updated_at) : '-' }}</dd>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fecha de Inscripcion:</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{ this.form.fecha_inscripcion ?
                                store.dateTimeFormateada(this.form.fecha_inscripcion) : '-' }}</dd>
                        <Datepicker v-else
                            class="sm:col-span-2 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            v-model="this.form.fecha_inscripcion" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                            :enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
                        </Datepicker>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fecha de Inicio:</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{ this.form.fecha_inicio ?
                                store.dateTimeFormateada(this.form.fecha_inicio) : '-' }}</dd>
                        <Datepicker v-else
                            class="sm:col-span-2 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            v-model="this.form.fecha_inicio" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                            :enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
                        </Datepicker>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Estado Actual</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                                this.form.estado ?? '-' }}</dd>

                        <select v-else v-model="form.estado_id" id="estado_id"
                            name="estado_id" autocomplete="off" :class="input_disable ? bg_disable : ''"
                            :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione un estado
                            </option>
                            <option v-for="item in estados" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Canal de Atención:</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                                this.form.canal_atencion ?? '-' }}</dd>

                        <select v-else v-model="form.canal_atencion_id" id="canal_atencion_id"
                            name="canal_atencion_id" autocomplete="off" :class="input_disable ? bg_disable : ''"
                            :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione un canal
                            </option>
                            <option v-for="item in canalesAtencion" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Sede</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ this.form.sede ??
                            '-' }}</dd>

                        <select v-else v-model="form.sede_id" id="sede_id"
                            name="sede_id" autocomplete="off" :class="input_disable ? bg_disable : ''"
                            :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione una Sede
                            </option>
                            <option v-for="item in sedes" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Observación</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-justify text-gray-900 sm:mt-0 sm:col-span-2">{{
                            this.form.observacion ?? '-' }}</dd>

                        <textarea v-else v-model="this.form.observacion" id="observacion" name="observacion" rows="3"
                            :disabled="input_disable"
                            class="mt-1 text-sm text-justify text-gray-900 sm:mt-0 sm:col-span-2 rounded-md
                                shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300"
                            :class="input_disable ? bg_disable : ''" />
                    </div>
                </dl>
            </div>
        </div>
    </div>
</template>

<script>
import { PencilSquareIcon, SunIcon } from '@heroicons/vue/24/solid'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import store from '@/store.js'

export default {
    props: {
        legajo: Object,
        sedes: Object,
        canalesAtencion: Object,
        tiposLegajo: Object,
        estados: Object
    },
    components: {
        PencilSquareIcon, SunIcon, Menu, MenuButton, MenuItems, MenuItem, Datepicker
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

            this.form.canal_atencion = this.legajo[0].canal_atencion?.description ?? null
            this.form.canal_atencion_id = this.legajo[0].canal_atencion?.id ?? null

            this.form.estado = this.legajo[0].estadocbj?.description ?? null
            this.form.estado_id = this.legajo[0].estadocbj?.id ?? null

            this.form.fecha_inscripcion = this.legajo[0].fecha_inscripcion
            this.form.fecha_inicio = this.legajo[0].fecha_inicio

            this.form.observacion = this.legajo[0].observacion
            this.form.sede = this.legajo[0].sede?.description ?? null
            this.form.sede_id = this.legajo[0].sede?.id ?? null

            // Registro datos temporales PreEdicion
            this.form_temp = this.form
        },
        resetForm() {
            this.form = this.form_temp
        },
        async updateLegajo(){
            let data = {}
            // RUTA
            let rt = route("legajoCB.updateLegajo");
            // Actualiza el Form
            this.form.estado = this.estados.find(estado => estado.id === this.form.estado_id)?.description || null;
            this.form.canal_atencion = this.canalesAtencion.find(canal => canal.id === this.form.canal_atencion_id)?.description || null;
            this.form.sede = this.sedes.find(sede => sede.id === this.form.sede_id)?.description || null;

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
