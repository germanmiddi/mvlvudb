<template>
    <div class="px-4 mt-10">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="sm:flex sm:justify-between sm:items-center">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Nuevo Adulto Responsable</h3>
                </div>
                <div class="mt-4 mr-4 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                    <button type="submit" @click="updateLegajo()"
                        class="ml-1 inline-flex items-center px-4 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                    <button type="button" @click="$emit('cancel')"
                        class="ml-1 inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancelar</button>
                </div>
            </div>

            <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Apellido</dt>
                        <div class="sm:col-span-2">
                            <input v-model="form.lastname" type="text" name="lastname" id="lastname"
                                autocomplete="name-level2"
                                :readonly="!isEditMode"
                                :class="[
                                    isEditMode ? 'focus:ring-indigo-500 focus:border-indigo-500' : 'bg-gray-100 text-gray-500 cursor-not-allowed',
                                    v$?.form?.lastname?.$error ? 'border-red-500' : 'border-gray-300',
                                    'block w-full shadow-sm sm:text-sm rounded-md'
                                ]" />
                            <span v-if="v$?.form?.lastname?.$error" class="text-red-500 text-xs">Campo obligatorio</span>
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                        <div class="sm:col-span-2">
                            <input v-model="form.name" type="text" name="name" id="name" autocomplete="name-level2"
                                :readonly="!isEditMode"
                                :class="[
                                    isEditMode ? 'focus:ring-indigo-500 focus:border-indigo-500' : 'bg-gray-100 text-gray-500 cursor-not-allowed',
                                    v$?.form?.name?.$error ? 'border-red-500' : 'border-gray-300',
                                    'block w-full shadow-sm sm:text-sm rounded-md'
                                ]" />
                            <span v-if="v$?.form?.name?.$error" class="text-red-500 text-xs">Campo obligatorio</span>
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Tipo de Documento</dt>
                        <div class="sm:col-span-2">
                            <select v-model="form.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
                                autocomplete="off"
                                :disabled="!isEditMode"
                                :class="[
                                    isEditMode ? 'bg-white focus:ring-indigo-500 focus:border-indigo-500' : 'bg-gray-100 text-gray-500 cursor-not-allowed',
                                    v$?.form?.tipo_documento_id?.$error ? 'border-red-500' : 'border-gray-300',
                                    'block w-full py-2 px-3 border rounded-md shadow-sm focus:outline-none inline-flex sm:text-sm'
                                ]">
                                <option value="" disabled>
                                    Seleccione un tipo de documento
                                </option>
                                <option v-for="item in tipoDocumento" :key="item.id" :value="item.id">
                                    {{ item.description }}
                                </option>
                            </select>
                            <span v-if="v$?.form?.tipo_documento_id?.$error" class="text-red-500 text-xs">Campo obligatorio</span>
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Documento</dt>
                        <div class="sm:col-span-2 relative">
                            <input v-model="form.num_documento"
                                @keyup.enter="getPerson()"
                                :class="[
                                    v$?.form?.num_documento?.$error ? 'border-red-500' : 'border-gray-300',
                                    'w-full focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm rounded-md pr-20'
                                ]"
                                type="text"
                                name="num_documento"
                                id="num_documento"
                                placeholder="Ingrese el número de documento" />
                            <button @click="getPerson()"
                                class="absolute inset-y-0 right-0 px-4 py-2 bg-green-200 text-green-900 text-xs rounded-r-md hover:bg-green-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-green-600 shadow-sm font-medium flex items-center transition-colors">
                                Verificar
                            </button>
                            <span v-if="v$?.form?.num_documento?.$error" class="block text-red-500 text-xs mt-1">Campo obligatorio</span>
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
                        <div class="sm:col-span-2">
                            <Datepicker
                                :class="[
                                    isEditMode ? 'focus:ring-red-500 focus:border-red-500' : 'bg-gray-100 text-gray-500 cursor-not-allowed',
                                    v$?.form?.fecha_nac?.$error ? 'border-red-500' : 'border-gray-300',
                                    'block w-full shadow-sm sm:text-sm rounded-md'
                                ]"
                                v-model="this.form.fecha_nac"
                                :disabled="!isEditMode"
                                :enableTimePicker="false"
                                :monthChangeOnScroll="false" autoApply :format="format">
                            </Datepicker>
                            <span v-if="v$?.form?.fecha_nac?.$error" class="text-red-500 text-xs">Campo obligatorio</span>
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Telefono</dt>
                        <input v-model="form.phone" type="text" name="phone" id="phone"
                            autocomplete="name-level2"
                            :readonly="!isEditMode"
                            :class="isEditMode ? 'sm:col-span-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md' : 'sm:col-span-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed'" />
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Celular</dt>
                        <input v-model="form.celular" type="text" name="celular" id="celular"
                            autocomplete="name-level2"
                            :readonly="!isEditMode"
                            :class="isEditMode ? 'sm:col-span-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md' : 'sm:col-span-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed'" />
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Pais</dt>
                        <select v-model="form.pais_id" id="pais_id" name="pais_id" autocomplete="off"
                            :disabled="!isEditMode"
                            :class="isEditMode ? 'sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' : 'sm:col-span-2 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-500 cursor-not-allowed sm:text-sm'">
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
                        <select v-model="form.tipo_ocupacion_id" id="tipo_ocupacion_id" name="tipo_ocupacion_id"
                            autocomplete="off"
                            :disabled="!isEditMode"
                            :class="isEditMode ? 'sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' : 'sm:col-span-2 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-500 cursor-not-allowed sm:text-sm'">
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
                        <select v-model="form.situacion_conyugal_id" id="situacion_conyugal_id"
                            name="situacion_conyugal_id" autocomplete="off"
                            :disabled="!isEditMode"
                            :class="isEditMode ? 'sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' : 'sm:col-span-2 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-500 cursor-not-allowed sm:text-sm'">
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
                        <select v-model="form.nivel_educativo_id" id="nivel_educativo_id"
                            name="nivel_educativo_id" autocomplete="off"
                            :disabled="!isEditMode"
                            :class="isEditMode ? 'sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' : 'sm:col-span-2 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-500 cursor-not-allowed sm:text-sm'">
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
                        <select v-model="form.estado_educativo_id" id="estado_educativo_id"
                            name="estado_educativo_id" autocomplete="off"
                            :disabled="!isEditMode"
                            :class="isEditMode ? 'sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' : 'sm:col-span-2 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-500 cursor-not-allowed sm:text-sm'">
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
                        <select v-model="form.parentesco_id" id="parentesco_id" name="parentesco_id"
                            autocomplete="off"
                            :disabled="!isEditMode"
                            :class="isEditMode ? 'sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' : 'sm:col-span-2 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-500 cursor-not-allowed sm:text-sm'">
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
                        <input v-model="form.phone_emergency" type="text" name="phone_emergency"
                            id="phone_emergency" autocomplete="name-level2"
                            :readonly="!isEditMode"
                            :class="isEditMode ? 'sm:col-span-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md' : 'sm:col-span-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed'" />
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
        PencilSquareIcon, Datepicker, Toast,
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
    validations() {
        return {
            form: {
                tipo_documento_id: { required },
                num_documento: { required },
                name: { required },
                lastname: { required },
                fecha_nac: { required }
            }
        }
    },
    data() {
        return {
            form: {},
            toastMessage: "",
            showToast: false,
            labelType: "info",
            isEditMode: false,
        }
    },
    methods: {
        initForm() {
            this.form = {
                id: this.legajo[0].id,
                num_documento: null,
                pais: null,
                pais_id: null,
                tipo_ocupacion: null,
                tipo_ocupacion_id: null,
                situacion_conyugal: null,
                situacion_conyugal_id: null,
                tipo_documento: null,
                tipo_documento_id: null,
                nivel_educativo: null,
                nivel_educativo_id: null,
                estado_educativo: null,
                estado_educativo_id: null,
                parentesco: null,
                parentesco_id: null,
                phone_emergency: null,
                name: null,
                lastname: null,
                fecha_nac: null,
                phone: null,
                celular: null
            }
        },
        clearMessage() {
            this.toastMessage = "";
        },
        async getPerson() {
            let num_documento = this.form.num_documento;
            const get = `${route('persons.getPersonDni', this.form.num_documento)}`
            const response = await fetch(get, { method: 'GET' })
            let data = await response.json()

            // Habilitar modo edición después de verificar
            this.isEditMode = true;

            if (!data.data.length == 0) {
                data = data.data[0].person

                this.form.num_documento = num_documento;
                /// Recuperar datos - solo llenar campos vacíos para preservar datos del usuario
                this.form.tipo_documento_id = this.form.tipo_documento_id || data.tipo_documento_id
                this.form.fecha_nac = this.form.fecha_nac || (data.fecha_nac ? new Date(data.fecha_nac + "T00:00:00.000-03:00") : null)
                this.form.name = this.form.name || data.name
                this.form.lastname = this.form.lastname || data.lastname
                this.form.genero = this.form.genero || data.genero
                if (data.contact != '' && data.contact.length > 0) {
                    this.form.celular = this.form.celular || data.contact[0].celular
                    this.form.phone = this.form.phone || data.contact[0].phone
                }

            } else {
                this.labelType = "info";
                this.toastMessage = "El DNI indicado no se encuentra registrado";
                this.form.num_documento = num_documento;
            }
        },
        async updateLegajo() {
            // Validar el formulario antes de continuar
            this.v$.$touch();
            if (this.v$.$invalid) {
                this.labelType = "danger";
                this.toastMessage = "Por favor complete todos los campos obligatorios";
                return;
            }

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
                    data.responsableId = response.data.responsable_id
                    // Enviar todos los datos del nuevo responsable
                    data.responsableData = {
                        id: response.data.responsable_id,
                        num_documento: this.form.num_documento,
                        lastname: this.form.lastname,
                        name: this.form.name,
                        fecha_nac: this.form.fecha_nac ? (this.form.fecha_nac instanceof Date ? this.form.fecha_nac.toISOString().split('T')[0] : this.form.fecha_nac) : null,
                        phone: this.form.phone,
                        celular: this.form.celular,
                        pais: this.form.pais,
                        pais_id: this.form.pais_id,
                        tipo_ocupacion: this.form.tipo_ocupacion,
                        tipo_ocupacion_id: this.form.tipo_ocupacion_id,
                        situacion_conyugal: this.form.situacion_conyugal,
                        situacion_conyugal_id: this.form.situacion_conyugal_id,
                        tipo_documento: this.form.tipo_documento,
                        tipo_documento_id: this.form.tipo_documento_id,
                        nivel_educativo: this.form.nivel_educativo,
                        nivel_educativo_id: this.form.nivel_educativo_id,
                        estado_educativo: this.form.estado_educativo,
                        estado_educativo_id: this.form.estado_educativo_id,
                        parentesco: this.form.parentesco,
                        parentesco_id: this.form.parentesco_id,
                        phone_emergency: this.form.phone_emergency
                    }
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
    created() {
        this.initForm()
    },
}
</script>
