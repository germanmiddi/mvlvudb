<template>
    <div class="px-4 mt-10">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="sm:flex sm:justify-between sm:items-center">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Educación</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles Educación</p>
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
                        <dt class="text-sm font-medium text-gray-500">Escuela:</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.escuela_primaria ?? '-' }}</dd>

                        <div v-else class="sm:col-span-2">
                            <SelectEscuelas :escuelas="escuelas" :modelValue="form.escuela_primaria_id" @update="form.escuela_primaria_id = $event" />
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Nivel educativo</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.nivel_educativo ?? '-' }}</dd>

                        <select v-else v-model="form.nivel_educativo_id" id="nivel_educativo_id" name="nivel_educativo_id" autocomplete="off"
                            :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione un nivel
                            </option>
                            <option v-for="item in nivelesEducativo" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Grado/Año</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.escuela_nivel ?? '-' }}</dd>

                        <select v-else v-model="form.escuela_nivel_id" id="escuela_nivel_id" name="escuela_nivel_id" autocomplete="off"
                            :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione un nivel
                            </option>
                            <option v-for="item in escuelasNivel" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Estado Educativo:</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.estado_educativo ?? '-' }}</dd>

                        <select v-else v-model="form.estado_educativo_id" id="estado_educativo_id" name="estado_educativo_id" autocomplete="off"
                            :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione un estado
                            </option>
                            <option v-for="item in estadosEducativo" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Turno</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.escuela_turno ?? '-' }}</dd>

                        <select v-else v-model="form.escuela_turno_id" id="escuela_turno_id" name="locaescuela_turno_idlidad_id" autocomplete="off"
                            :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione un turno
                            </option>
                            <option v-for="item in turnosEducativo" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Dependencia</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.escuela_dependencia ?? '-' }}</dd>

                        <select v-else v-model="form.escuela_dependencia_id" id="escuela_dependencia_id" name="escuela_dependencia_id" autocomplete="off"
                            :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione una dependencia
                            </option>
                            <option v-for="item in escuelasDependencia" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Localidad</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.escuela_localidad ?? '-' }}</dd>

                        <select v-else v-model="form.escuela_localidad_id" id="escuela_localidad_id" name="escuela_localidad_id" autocomplete="off"
                            :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione una localidad
                            </option>
                            <option v-for="item in localidades" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>


                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Certificado escolar</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.certificado_escolar ? 'SI' : (this.form.certificado_escolar != null ? 'NO' : '-') }}</dd>

                        <Switch v-else v-model="form.certificado_escolar" @click="form.certificado_escolar = !form.certificado_escolar"
                            :class="form.certificado_escolar ? 'bg-blue-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11  items-center rounded-full">
                            <span :class="form.certificado_escolar ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                        </Switch>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Realizo permanencia</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.permanencia ? 'SI' : (this.form.permanencia != null ? 'NO' : '-') }}</dd>

                        <Switch v-else v-model="form.permanencia" @click="form.permanencia = !form.permanencia"
                            :class="form.permanencia ? 'bg-blue-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11  items-center rounded-full">
                            <span :class="form.permanencia ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                        </Switch>
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
import SelectEscuelas from '@/Layouts/Components/Generics/SelectEscuelas.vue';
import store from '@/store.js'

export default {
    props: {
        legajo: Object,
        escuelas: Object,
        estadosEducativo: Object,
        nivelesEducativo: Object,
        turnosEducativo: Object,
	    escuelasDependencia: Object,
        localidades: Object,
        escuelasNivel: Object
    },
    components: {
        PencilSquareIcon,Bars4Icon, Datepicker, Menu, MenuButton, MenuItems, MenuItem, SelectEscuelas
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

            this.form.escuela_primaria = this.legajo[0].person?.education[0]?.escuela_primaria?.description ?? null
            this.form.escuela_primaria_id = this.legajo[0].person?.education[0]?.escuela_primaria?.id ?? null

            this.form.nivel_educativo = this.legajo[0].person?.education[0]?.nivel_educativo?.description ?? null
            this.form.nivel_educativo_id = this.legajo[0].person?.education[0]?.nivel_educativo?.id ?? null

            this.form.escuela_nivel = this.legajo[0].person?.education[0]?.escuela_nivel?.description ?? null
            this.form.escuela_nivel_id = this.legajo[0].person?.education[0]?.escuela_nivel?.id ?? null

            this.form.estado_educativo = this.legajo[0].person?.education[0]?.estado_educativo?.description ?? null
            this.form.estado_educativo_id = this.legajo[0].person?.education[0]?.estado_educativo?.id ?? null

            this.form.escuela_turno = this.legajo[0].person?.education[0]?.escuela_turno?.description ?? null
            this.form.escuela_turno_id = this.legajo[0].person?.education[0]?.escuela_turno?.id ?? null

            this.form.escuela_dependencia = this.legajo[0].person?.education[0]?.escuela_dependencia?.description ?? null
            this.form.escuela_dependencia_id = this.legajo[0].person?.education[0]?.escuela_dependencia?.id ?? null

            this.form.escuela_localidad = this.legajo[0].person?.education[0]?.escuela_localidad?.description ?? null
            this.form.escuela_localidad_id = this.legajo[0].person?.education[0]?.escuela_localidad?.id ?? null

            this.form.certificado_escolar = this.legajo[0].person?.education[0]?.certificado_escolar ?? null
            this.form.permanencia = this.legajo[0].person?.education[0]?.permanencia ?? null
            this.form.observacion = this.legajo[0].person?.education[0]?.observacion ?? null

            // Registro datos temporales PreEdicion
            this.form_temp = JSON.parse(JSON.stringify(this.form));
        },
        resetForm() {
            this.form = JSON.parse(JSON.stringify(this.form_temp));
        },
        async updateLegajo() {
            let data = {}
            // RUTA
            let rt = route("legajoCB.updateLegajoEducacion");
            // Actualiza el Form
            this.form.escuela_primaria = this.escuelas.find(item => item.id === this.form.escuela_primaria_id)?.description || null;
            this.form.nivel_educativo = this.nivelesEducativo.find(item => item.id === this.form.nivel_educativo_id)?.description || null;
            this.form.escuela_nivel = this.escuelasNivel.find(item => item.id === this.form.escuela_nivel_id)?.description || null;
            this.form.estado_educativo = this.estadosEducativo.find(item => item.id === this.form.estado_educativo_id)?.description || null;
            this.form.escuela_turno = this.turnosEducativo.find(item => item.id === this.form.escuela_turno_id)?.description || null;
            this.form.escuela_dependencia = this.escuelasDependencia.find(item => item.id === this.form.escuela_dependencia_id)?.description || null;
            this.form.escuela_localidad = this.localidades.find(item => item.id === this.form.escuela_localidad_id)?.description || null;

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
