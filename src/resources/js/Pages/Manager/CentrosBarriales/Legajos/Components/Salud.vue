<template>
    <div class="px-4 mt-10">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="sm:flex sm:justify-between sm:items-center">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Salud</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles de Salud.</p>
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
                        <dt class="text-sm font-medium text-gray-500">Apto médico</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.apto_medico ? 'SI' : (this.form.apto_medico != null ? 'NO' : '-') }}</dd>

                        <Switch v-else v-model="form.apto_medico" @click="form.apto_medico = !form.apto_medico"
                            :class="form.apto_medico ? 'bg-blue-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11  items-center rounded-full">
                            <span :class="form.apto_medico ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                        </Switch>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fecha apto médico</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.fecha_apto_medico ?
                            store.dateTimeFormateada(this.form.fecha_apto_medico) : '-' }}</dd>
                        <Datepicker v-else
                            class="sm:col-span-2 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            v-model="this.form.fecha_apto_medico" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                            :enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
                        </Datepicker>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Vencimiento apto médico</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.vencimiento_apto_medico ?
                            store.dateTimeFormateada(this.form.vencimiento_apto_medico) : '-' }}</dd>
                        <Datepicker v-else
                            class="sm:col-span-2 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            v-model="this.form.vencimiento_apto_medico" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                            :enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
                        </Datepicker>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Electrocardiograma</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.electrocardiograma ? 'SI' : (this.form.electrocardiograma != null ? 'NO' : '-') }}</dd>

                        <Switch v-else v-model="form.electrocardiograma" @click="form.electrocardiograma = !form.electrocardiograma"
                            :class="form.electrocardiograma ? 'bg-blue-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11  items-center rounded-full">
                            <span :class="form.electrocardiograma ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                        </Switch>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fecha electrocardiograma</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.fecha_electrocardiograma ?
                            store.dateTimeFormateada(this.form.fecha_electrocardiograma) : '-' }}</dd>
                        <Datepicker v-else
                            class="sm:col-span-2 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            v-model="this.form.fecha_electrocardiograma" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                            :enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
                        </Datepicker>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Libreta vacunacion</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.libreta_vacunacion ? 'SI' : (this.form.libreta_vacunacion != null ? 'NO' : '-') }}</dd>

                        <Switch v-else v-model="form.libreta_vacunacion" @click="form.libreta_vacunacion = !form.libreta_vacunacion"
                            :class="form.libreta_vacunacion ? 'bg-blue-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11  items-center rounded-full">
                            <span :class="form.libreta_vacunacion ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                        </Switch>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Lugar de atención:</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.centro_salud ?? '-' }}</dd>

                        <select v-else v-model="form.centro_salud_id" id="localidad_id" name="localidad_id" autocomplete="off"
                            :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione un lugar de atencion
                            </option>
                            <option v-for="item in centrosSalud" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Posee CUD</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.posee_cud ? 'SI' : (this.form.posee_cud != null ? 'NO' : '-')}}</dd>

                        <Switch v-else v-model="form.posee_cud" @click="form.posee_cud = !form.posee_cud"
                            :class="form.posee_cud ? 'bg-blue-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11  items-center rounded-full">
                            <span :class="form.posee_cud ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                        </Switch>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Presento CUD</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.presento_cud ? 'SI' : (this.form.presento_cud != null ? 'NO' : '-')}}</dd>

                        <Switch v-else v-model="form.presento_cud" @click="form.presento_cud = !form.presento_cud"
                            :class="form.presento_cud ? 'bg-blue-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11  items-center rounded-full">
                            <span :class="form.presento_cud ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                        </Switch>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Vencimiento CUD</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.vencimiento_cud ?
                            store.dateTimeFormateada(this.form.vencimiento_cud) : '-' }}</dd>
                        <Datepicker v-else
                            class="sm:col-span-2 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            v-model="this.form.vencimiento_cud" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                            :enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
                        </Datepicker>
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
import { PencilSquareIcon, Bars4Icon } from '@heroicons/vue/24/solid'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import store from '@/store.js'

export default {
    props: {
        legajo: Object,
        centrosSalud: Object,
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

            this.form.apto_medico = this.legajo[0].person?.salud?.apto_medico ?? null
            this.form.fecha_apto_medico = this.legajo[0].person?.salud?.fecha_apto_medico ?? null
            this.form.fecha_apto_medico = this.form.fecha_apto_medico ? new Date(this.form.fecha_apto_medico + "T00:00:00.000-03:00") : null
            this.form.vencimiento_apto_medico = this.legajo[0].person?.salud?.vencimiento_apto_medico ?? null
            this.form.electrocardiograma = this.legajo[0].person?.salud?.electrocardiograma ?? null

            this.form.fecha_electrocardiograma = this.legajo[0].person?.salud?.fecha_electrocardiograma ?? null
            this.form.fecha_electrocardiograma = this.form.fecha_electrocardiograma ? new Date(this.form.fecha_electrocardiograma + "T00:00:00.000-03:00") : null

            this.form.libreta_vacunacion = this.legajo[0].person?.salud?.libreta_vacunacion ?? null
            this.form.centro_salud = this.legajo[0].person?.salud?.centro_salud?.description ?? null
            this.form.centro_salud_id = this.legajo[0].person?.salud?.centro_salud?.id ?? null

            this.form.posee_cud = this.legajo[0].person?.cud?.posee_cud ?? null
            this.form.presento_cud = this.legajo[0].person?.cud?.presento_cud ?? null
            this.form.vencimiento_cud = this.legajo[0].person?.cud?.vencimiento_cud ?? null
            this.form.observacion = this.legajo[0].person?.salud?.observacion ?? null

            // Registro datos temporales PreEdicion
            this.form_temp = JSON.parse(JSON.stringify(this.form));
        },
        resetForm() {
            this.form = JSON.parse(JSON.stringify(this.form_temp));
        },
        async updateLegajo() {
            let data = {}
            // RUTA
            let rt = route("legajoCB.updateLegajoSalud");
            // Actualiza el Form
            this.form.centro_salud = this.centrosSalud.find(item => item.id === this.form.centro_salud_id)?.description || null;

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
