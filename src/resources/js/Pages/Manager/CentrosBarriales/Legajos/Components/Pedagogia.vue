<template>
    <div class="px-4 mt-10">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="sm:flex sm:justify-between sm:items-center">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Pedagogia</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles Pedagogia</p>
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
                        <dt class="text-sm font-medium text-gray-500">Realizó Prueba</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.realizo_prueba ? 'SI' : (this.form.realizo_prueba != null ? 'NO' : '-') }}</dd>
                    
                        <Switch v-else v-model="form.realizo_prueba" @click="form.realizo_prueba = !form.realizo_prueba"
                            :class="form.realizo_prueba ? 'bg-blue-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11  items-center rounded-full">
                            <span :class="form.realizo_prueba ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                        </Switch>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Estado</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.estado ?? '-' }}</dd>

                        <select v-else v-model="form.estado_id" id="estado_id"
                            name="estado_id" autocomplete="off" :class="input_disable ? bg_disable : ''"
                            :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione un estado
                            </option>
                            <option v-for="item in estadosPedagogia" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fecha de la Prueba</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.fecha_prueba ?
                            store.dateTimeFormateada(this.form.fecha_prueba) : '-' }}</dd>
                        <Datepicker v-else
                            class="sm:col-span-2 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            v-model="this.form.fecha_prueba" :disabled="input_disable"
                            :class="input_disable ? bg_disable : ''" :enableTimePicker="false" :monthChangeOnScroll="false"
                            autoApply :format="format">
                        </Datepicker>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Profesional</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-justify text-gray-900 sm:mt-0 sm:col-span-2">{{
                            this.form.profesional ?? '-' }}</dd>
                    
                        <input v-else v-model="this.form.profesional" id="profesional" name="profesional" 
                            :disabled="input_disable"
                            placeholder="Escribe el nombre del profesional..."
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            :class="input_disable ? bg_disable : ''" />
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Detalles</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-justify text-gray-900 sm:mt-0 sm:col-span-2">{{
                            this.form.detalles ?? '-' }}</dd>

                        <textarea v-else v-model="this.form.detalles" id="detalles" name="detalles" rows="3"
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
import { PencilSquareIcon, Bars4Icon } from '@heroicons/vue/24/solid'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import store from '@/store.js'

export default {
    props: {
        legajo: Object,
        estadosPedagogia: Array
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
            this.form.pedagogia_id = this.legajo[0]?.pedagogia[0]?.id ?? null;

            this.form.realizo_prueba = this.legajo[0]?.pedagogia[0]?.realizo_prueba ?? null
            this.form.fecha_prueba = this.legajo[0]?.pedagogia[0]?.fecha_prueba ?? null
            // this.form.fecha_prueba = this.form.fecha_prueba ? new Date(this.form.fecha_prueba + "T00:00:00.000-03:00") : null

            this.form.estado_id = this.legajo[0].pedagogia[0]?.estado?.id ?? null
            this.form.estado = this.legajo[0].pedagogia[0]?.estado?.description ?? null

            this.form.detalles = this.legajo[0].pedagogia[0]?.detalles ?? null
            this.form.profesional = this.legajo[0].pedagogia[0]?.profesional ?? null

            // Registro datos temporales PreEdicion
            this.form_temp = JSON.parse(JSON.stringify(this.form));
        },
        resetForm() {
            this.form = JSON.parse(JSON.stringify(this.form_temp));
        },
        resetFields() {
            if (!this.form.realizo_prueba) {
                this.form.fecha_prueba = null;
                this.form.estado_id = null;
                this.form.estado = null;
                this.form.detalles = null;
                this.form.profesional = null;
            }
        },
        async updateLegajo() {
            let data = {}
            // RUTA
            let rt = route("legajoCB.updateLegajoPedagogia");
            // Actualiza el Form
            this.form.estado = this.estadosPedagogia.find(item => item.id === this.form.estado_id)?.description || null;

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
    watch: {
        'form.realizo_prueba'(newValue) {
            if (newValue === false) {
                this.resetFields(); // Resetea campos a null cuando "NO" es seleccionado
            }
        }
    },
    created() {
        this.initForm()
    },
}
</script>
