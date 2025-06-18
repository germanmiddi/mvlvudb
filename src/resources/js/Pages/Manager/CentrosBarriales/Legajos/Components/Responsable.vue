<template>
    <div class="px-4 mt-10">
        <!-- Mostrar ResponsableNew cuando showNewForm es true -->
        <ResponsableNew
            v-if="showNewForm"
            :legajo="legajo"
            :paises="paises"
            :parentescos="parentescos"
            :situacionesConyugal="situacionesConyugal"
            :tiposOcupacion="tiposOcupacion"
            :estadosEducativo="estadosEducativo"
            :nivelesEducativo="nivelesEducativo"
            :tipoDocumento="tipoDocumento"
            @message="handleNewResponsableMessage"
        />

        <!-- Mostrar formulario original cuando showNewForm es false -->
        <div v-else class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="sm:flex sm:justify-between sm:items-center">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Datos del Adulto Responsable</h3>
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

            <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Apellido</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.lastname ?? '-' }}</dd>

                        <input v-else v-model="form.lastname" type="text" name="lastname" id="lastname"
                            autocomplete="name-level2"
                            class="sm:col-span-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.name ?? '-' }}</dd>

                        <input v-else v-model="form.name" type="text" name="name" id="name" autocomplete="name-level2"
                            class="sm:col-span-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Tipo de Documento</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.tipo_documento ?? '-' }}</dd>

                        <select v-else v-model="form.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
                            autocomplete="off" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione un tipo de documento
                            </option>
                            <option v-for="item in tipoDocumento" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Documento</dt>

                                                        <!-- Mostrar DNI como texto (modo lectura) -->
                        <dd v-if="!editData || (hasDni && !changeDni)"
                            class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ form.num_documento ?? '-' }}
                            <button v-if="hasDni && editData && !changeDni"
                                @click="changeDniMode()"
                                class="block text-blue-500 text-xs cursor-pointer hover:text-blue-700 hover:underline mt-1">
                                Cambiar DNI
                            </button>
                        </dd>

                        <!-- Mostrar input para DNI (modo edición) -->
                        <div v-else class="sm:col-span-2 relative">
                            <input v-model="form.num_documento"
                                @keyup.enter="getPerson()"
                                :class="!form.num_documento ? 'border-red-500' : ''"
                                type="text"
                                name="num_documento"
                                id="num_documento"
                                placeholder="Ingrese el número de documento"
                                class="w-full focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md pr-20" />
                            <button @click="getPerson()"
                                class="absolute inset-y-0 right-0 px-4 py-2 bg-green-200 text-green-900 text-xs rounded-r-md hover:bg-green-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-green-600 shadow-sm font-medium flex items-center transition-colors">
                                Verificar
                            </button>
                            <span v-if="!form.num_documento" class="block text-red-500 text-xs mt-1">Campo obligatorio</span>
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.fecha_nac ?
                                (this.form.fecha_nac instanceof Date ?
                                    format(this.form.fecha_nac) :
                                    store.dateFormateada(this.form.fecha_nac)) : '-' }}</dd>
                        <Datepicker v-else
                            class="sm:col-span-2 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            v-model="this.form.fecha_nac" :disabled="input_disable"
                            :class="input_disable ? bg_disable : ''" :enableTimePicker="false"
                            :monthChangeOnScroll="false" autoApply :format="format">
                        </Datepicker>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Telefono</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.phone ?? '-' }}</dd>

                        <input v-else v-model="form.phone" type="text" name="phone" id="phone"
                            autocomplete="name-level2"
                            class="sm:col-span-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Celular</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.celular ?? '-' }}</dd>

                        <input v-else v-model="form.celular" type="text" name="celular" id="celular"
                            autocomplete="name-level2"
                            class="sm:col-span-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Pais</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.pais ?? '-' }}</dd>

                        <select v-else v-model="form.pais_id" id="pais_id" name="pais_id" autocomplete="off"
                            :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione un pais
                            </option>
                            <option v-for="item in paises" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Situación Laboral</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.tipo_ocupacion ?? '-' }}</dd>

                        <select v-else v-model="form.tipo_ocupacion_id" id="tipo_ocupacion_id" name="tipo_ocupacion_id"
                            autocomplete="off" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione una ocupación
                            </option>
                            <option v-for="item in tiposOcupacion" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Situación Conyugal</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.situacion_conyugal ?? '-' }}</dd>

                        <select v-else v-model="form.situacion_conyugal_id" id="situacion_conyugal_id"
                            name="situacion_conyugal_id" autocomplete="off" :class="input_disable ? bg_disable : ''"
                            :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione una situación
                            </option>
                            <option v-for="item in situacionesConyugal" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Nivel Educativo</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.nivel_educativo ?? '-' }}</dd>

                        <select v-else v-model="form.nivel_educativo_id" id="nivel_educativo_id"
                            name="nivel_educativo_id" autocomplete="off" :class="input_disable ? bg_disable : ''"
                            :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione un nivel educativo
                            </option>
                            <option v-for="item in nivelesEducativo" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Estado Educativo</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.estado_educativo ?? '-' }}</dd>

                        <select v-else v-model="form.estado_educativo_id" id="estado_educativo_id"
                            name="estado_educativo_id" autocomplete="off" :class="input_disable ? bg_disable : ''"
                            :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione un estado educativo
                            </option>
                            <option v-for="item in estadosEducativo" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Parentesco</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                            this.form.parentesco ?? '-' }}</dd>

                        <select v-else v-model="form.parentesco_id" id="parentesco_id" name="parentesco_id"
                            autocomplete="off" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione un parentesco
                            </option>
                            <option v-for="item in parentescos" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Teléfono de Emergencia</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.phone_emergency ?? '-' }}</dd>

                        <input v-else v-model="form.phone_emergency" type="text" name="phone_emergency"
                            id="phone_emergency" autocomplete="name-level2"
                            class="sm:col-span-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                    </div>
                </dl>
            </div>
        </div>
    </div>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required, helpers, minLength } from '@vuelidate/validators'

import { PencilSquareIcon } from '@heroicons/vue/24/solid'
import Toast from "@/Layouts/Components/Toast.vue";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import store from '@/store.js'
import ResponsableNew from './ResponsableNew.vue'

export default {
    props: {
        legajo: Object,
        paises: Object,
        parentescos: Object,
        situacionesConyugal: Object,
        tiposOcupacion: Object,
        estadosEducativo: Object,
        nivelesEducativo: Object,
        tipoDocumento: Object,
    },
    components: {
        PencilSquareIcon, Datepicker, Toast, ResponsableNew,
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
            store,
            v$: useVuelidate()
        }
    },
    data() {
        return {
            editData: false,
            form: {},
            form_temp: {},
            toastMessage: "",
            showToast: false,
            labelType: "info",
            dniStatus: false,
            changeDni: false,
            showNewForm: false,
            input_disable: true,
            bg_disable: "bg-gray-100",
        }
    },
    computed: {
        hasDni() {
            return !!(this.form.num_documento || this.legajo[0].responsable?.num_documento || this.dniStatus);
        }
    },

    methods: {
        initForm() {
            this.form = {}
            this.form.id = this.legajo[0].id
            this.form.num_documento = this.legajo[0].responsable?.num_documento ?? null

            this.form.pais = this.legajo[0].responsable?.address[0]?.pais?.description ?? null
            this.form.pais_id = this.legajo[0].responsable?.address[0]?.pais?.id ?? null

            this.form.tipo_ocupacion = this.legajo[0].responsable?.social[0]?.tipo_ocupacion?.description ?? null
            this.form.tipo_ocupacion_id = this.legajo[0].responsable?.social[0]?.tipo_ocupacion?.id ?? null

            this.form.situacion_conyugal = this.legajo[0].responsable?.aditional[0]?.situacion_conyugal?.description ?? null
            this.form.situacion_conyugal_id = this.legajo[0].responsable?.aditional[0]?.situacion_conyugal?.id ?? null

            this.form.tipo_documento = this.legajo[0].responsable?.tipo_doc?.description ?? null
            this.form.tipo_documento_id = this.legajo[0].responsable?.tipo_documento_id ?? null

            this.form.nivel_educativo = this.legajo[0].responsable?.education[0]?.nivel_educativo?.description ?? null
            this.form.nivel_educativo_id = this.legajo[0].responsable?.education[0]?.nivel_educativo?.id ?? null

            this.form.estado_educativo = this.legajo[0].responsable?.education[0]?.estado_educativo?.description ?? null
            this.form.estado_educativo_id = this.legajo[0].responsable?.education[0]?.estado_educativo?.id ?? null

            this.form.parentesco = this.legajo[0].parentesco?.description ?? null
            this.form.parentesco_id = this.legajo[0].parentesco?.id ?? null

            this.form.phone_emergency = this.legajo[0].phone_emergency ?? null
            this.form.name = this.legajo[0].responsable?.name ?? null
            this.form.lastname = this.legajo[0].responsable?.lastname ?? null
            // Manejar fecha correctamente - si viene como string del servidor, convertir a Date para el Datepicker
            this.form.fecha_nac = this.legajo[0].responsable?.fecha_nac ?
                (typeof this.legajo[0].responsable.fecha_nac === 'string' ?
                    new Date(this.legajo[0].responsable.fecha_nac + "T00:00:00.000-03:00") :
                    this.legajo[0].responsable.fecha_nac) : null
            this.form.phone = this.legajo[0].responsable?.contact[0]?.phone ?? null
            this.form.celular = this.legajo[0].responsable?.contact[0]?.celular ?? null

            // Si ya existe un responsable, habilitar campos para edición normal
            // Solo deshabilitar si estamos en modo cambio de DNI sin verificar
            this.input_disable = false;
            if (this.form.num_documento) {
                this.dniStatus = true;
            }

            // Registro datos temporales PreEdicion
            this.form_temp = JSON.parse(JSON.stringify(this.form));
        },
        resetForm() {
            this.form = JSON.parse(JSON.stringify(this.form_temp));
            this.changeDni = false;
        },
        clearMessage() {
            this.toastMessage = "";
        },
        changeDniMode() {
            // Mostrar el formulario nuevo en lugar del modo de edición
            this.showNewForm = true;
            this.editData = false;
        },
                        handleNewResponsableMessage(data) {
            // Manejar el mensaje del componente ResponsableNew
            this.$emit('message', data);

            // Si fue exitoso, actualizar el formulario con los nuevos datos
            if (data.labelType === 'success' && data.responsableData) {
                this.showNewForm = false;
                // Actualizar el formulario con los datos del nuevo responsable
                this.updateFormWithNewResponsable(data.responsableData);
            }
        },
        updateFormWithNewResponsable(responsableData) {
            // Actualizar el formulario con los datos del nuevo responsable
            this.form.num_documento = responsableData.num_documento;
            this.form.lastname = responsableData.lastname;
            this.form.name = responsableData.name;
            // Manejar fecha - viene como string desde ResponsableNew, convertir a Date para Datepicker
            this.form.fecha_nac = responsableData.fecha_nac ?
                (typeof responsableData.fecha_nac === 'string' ?
                    new Date(responsableData.fecha_nac + "T00:00:00.000-03:00") :
                    responsableData.fecha_nac) : null;
            this.form.phone = responsableData.phone;
            this.form.celular = responsableData.celular;
            this.form.pais = responsableData.pais;
            this.form.pais_id = responsableData.pais_id;
            this.form.tipo_ocupacion = responsableData.tipo_ocupacion;
            this.form.tipo_ocupacion_id = responsableData.tipo_ocupacion_id;
            this.form.situacion_conyugal = responsableData.situacion_conyugal;
            this.form.situacion_conyugal_id = responsableData.situacion_conyugal_id;
            this.form.tipo_documento = responsableData.tipo_documento;
            this.form.tipo_documento_id = responsableData.tipo_documento_id;
            this.form.nivel_educativo = responsableData.nivel_educativo;
            this.form.nivel_educativo_id = responsableData.nivel_educativo_id;
            this.form.estado_educativo = responsableData.estado_educativo;
            this.form.estado_educativo_id = responsableData.estado_educativo_id;
            this.form.parentesco = responsableData.parentesco;
            this.form.parentesco_id = responsableData.parentesco_id;
            this.form.phone_emergency = responsableData.phone_emergency;

            // Actualizar datos temporales para el modo edición
            this.form_temp = JSON.parse(JSON.stringify(this.form));
            this.dniStatus = true;
        },
        async getPerson() {
            let num_documento = this.form.num_documento;
            const get = `${route('persons.getPersonDni', this.form.num_documento)}`
            const response = await fetch(get, { method: 'GET' })
            let data = await response.json()
            if (!data.data.length == 0) {
                data = data.data[0].person

                this.form.num_documento = num_documento;
                /// Recuperar datos.
                this.form.tipo_documento_id = data.tipo_documento_id
                this.form.fecha_nac = data.fecha_nac ? new Date(data.fecha_nac + "T00:00:00.000-03:00") : null
                this.form.name = data.name
                this.form.lastname = data.lastname
                this.form.genero = data.genero
                if (data.contact != '') {
                    this.form.celular = data.contact[0].celular
                    this.form.phone = data.contact[0].phone
                }
                // Habilitar campos para edición después de verificar
                this.input_disable = false;
                this.dniStatus = true;

            } else {
                this.labelType = "info";
                this.toastMessage = "El DNI indicado no se encuentra registrado";
                this.form.num_documento = num_documento;
                // Habilitar campos incluso si no se encuentra la persona para permitir crear una nueva
                this.input_disable = false;
            }
        },
        async updateLegajo() {
            let data = {}
            // RUTA
            let rt = route("legajoCB.updateLegajoResponsable");
            // Actualiza el Form
            this.form.pais = this.paises.find(item => item.id === this.form.pais_id)?.description || null;
            this.form.tipo_ocupacion = this.tiposOcupacion.find(item => item.id === this.form.tipo_ocupacion_id)?.description || null;
            this.form.situacion_conyugal = this.situacionesConyugal.find(item => item.id === this.form.situacion_conyugal_id)?.description || null;
            this.form.estado_educativo = this.estadosEducativo.find(item => item.id === this.form.estado_educativo_id)?.description || null;
            this.form.nivel_educativo = this.nivelesEducativo.find(item => item.id === this.form.nivel_educativo_id)?.description || null;
            this.form.parentesco = this.parentescos.find(item => item.id === this.form.parentesco_id)?.description || null;
            this.form.tipo_documento = this.tipoDocumento.find(item => item.id === this.form.tipo_documento_id)?.description || null;
            this.form.num_documento = this.form.num_documento;

            try {
                const response = await axios.put(rt, this.form);
                if (response.status == 200) {
                    data.message = response.data.message
                    data.labelType = 'success'
                    this.editData = false
                    this.changeDni = false
                    this.form_temp = this.form
                    this.dniStatus = true;
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
