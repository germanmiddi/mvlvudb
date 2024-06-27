<template>
	<main class="flex-1 bg-gray-50 pb-40">
		<!-- Page title & actions -->
		<div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
			<div class="flex-1 min-w-0 flex items-center">
				<a class="btn-blue" :href="route('inscripcionCBJ')">
					<ArrowLeftCircleIcon class="w-5 h-5 text-purple-700 mr-2" />
				</a>
				<h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
					Nueva Inscripción | Centro Barrial Juventud
				</h1>
			</div>
			<div class="mt-4 flex sm:mt-0 sm:ml-4">
				<button
					class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"
					:class="btnGuardar || input_disable ? 'bg-gray-600 hover:bg-gray-700 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700'"
					@click="submit" :disabled="btnGuardar || input_disable">
					Guardar
				</button>
			</div>
		</div>

		<Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="border-b border-gray-200 dark:border-gray-700">
				<ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
					<li class="me-2">
						<a href="#" @click="this.tabs = 1" :class="this.tabs === 1 ? 'border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'" class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group">
							Datos Inscripción
						</a>
					</li>
					<li class="me-2">
						<a href="#" @click="input_disable ? requiredPerson() : this.tabs = 2" :class="this.tabs === 2 ? 'border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'" class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group">
							Dirección
						</a>
					</li>
					<li class="me-2">
						<a href="#" @click="input_disable ? requiredPerson() : this.tabs = 3" :class="this.tabs === 3 ? 'border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'" class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group">
							Salud
						</a>
					</li>
					<li class="me-2">
						<a href="#" @click="input_disable ? requiredPerson() : this.tabs = 4" :class="this.tabs === 4 ? 'border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'" class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group">
							Autorizaciones
						</a>
					</li>
					<li class="me-2">
						<a href="#" @click="input_disable ? requiredPerson() : this.tabs = 5" :class="this.tabs === 5 ? 'border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'" class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group">
							Educación
						</a>
					</li>
					<li class="me-2">
						<a href="#" @click="input_disable ? requiredPerson() : this.tabs = 6" :class="this.tabs === 6 ? 'border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'" class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group">
							Adulto Responsable
						</a>
					</li>
				</ul>
			</div>

			<div v-if="v$.form.$error" class="border-b border-gray-200 dark:border-gray-700 text-xs">
				<div class="px-4 mt-6 sm:px-6 lg:px-8 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md"
					role="alert">
					<p class="font-bold text-md mb-2">Campos requeridos </p>
					<p v-for="error of v$.form.$errors" :key="error.$uid">
						{{error.$message}}
					</p>
				</div>
			</div>

			<form action="#" method="POST" enctype="multipart/form-data">
				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6" v-show="this.tabs === 1">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Datos del Beneficiario
								</h3>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Tipo de
									Documento</label>
								<select v-model="form.person.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
									autocomplete="off"
									:class="v$.form.person.tipo_documento_id.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un tipo de documento
									</option>
									<option v-for="tipoDocumento in tiposDocumento" :key="tipoDocumento.id"
										:value="tipoDocumento.id">
										{{ tipoDocumento.description }}
									</option>
								</select>
								<span v-if="v$.form.person.tipo_documento_id.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de
									Documento</label>
								<div class="relative">
									<input type="text" v-model="form.person.num_documento" @keyup.enter="getPerson()" :class="v$.form.person.num_documento.$error ? 'border-red-500' : ''"
										class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
									<a @click="getPerson()"
										class="absolute inset-y-0 right-0 px-4 py-2 bg-green-200 text-white text-xs rounded-r-md hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-600  shadow-sm text-xs font-medium flex items-center  text-green-900 hover:text-white">
										Verificar
									</a>
								</div>
								<span v-if="v$.form.person.num_documento.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>

							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
								<input v-model="form.person.name" type="text" name="name" id="name" autocomplete="name"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.person.name.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable" />
								<span v-if="v$.form.person.name.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
								<input v-model="form.person.lastname" type="text" name="lastname" id="lastname" autocomplete="name"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.person.lastname.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable" />
								<span v-if="v$.form.person.lastname.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="fecha_nac" class="block text-sm font-medium text-gray-700">Fecha de
									Nacimiento</label>
								<Datepicker
									class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:style="v$.form.person.fecha_nac.$error ? datepickerStyle : ''" v-model="form.person.fecha_nac"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									:enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
								</Datepicker>
								<span v-if="v$.form.person.fecha_nac.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="email" class="block text-sm font-medium text-gray-700">Mail</label>
								<input v-model="form.contact.email" type="text" name="email" id="email" autocomplete="email"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="phone" class="block text-sm font-medium text-gray-700">Telefono</label>
								<input v-model="form.contact.phone" type="text" name="phone" id="phone" autocomplete="off"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

						</div>

					</div>
				</div>

				<!-- DATOS INSCRIPCION -->
				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6" v-show="this.tabs === 1">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">
								Datos de Inscripción
							</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
								<Datepicker
									class="focus:ring-indigo-500 mt-1 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md"
									v-model="form.inscripcion.fecha" :enableTimePicker="false" :monthChangeOnScroll="true" autoApply
									:formatinscripcionCBJ="format" :style="v$.form.inscripcion.fecha.$error ? datepickerStyle : ''"
									:disabled="input_disable">
								</Datepicker>
								<span v-if="v$.form.inscripcion.fecha.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="canal_atencion" class="block text-sm font-medium text-gray-700">Canal de
									Atención</label>
								<select v-model="form.inscripcion.canal_atencion_id" id="canal_atencion_id" name="canal_atencion_id"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
									:class="v$.form.inscripcion.canal_atencion_id.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable">
									<option value="" disabled>
										Selecciones un canal de atencion
									</option>
									<option v-for="canalAtencion in canalesAtencion" :key="canalAtencion.id"
										:value="canalAtencion.id">
										{{ canalAtencion.description }}
									</option>
								</select>
								<span v-if="v$.form.inscripcion.canal_atencion_id.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="sede_id" class="block text-sm font-medium text-gray-700">Sede</label>
								<select v-model="form.inscripcion.sede_id" id="sede_id" name="sede_id" autocomplete="off"
									:disabled="input_disable"
									:class="v$.form.inscripcion.sede_id.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione una sede</option>
									<option v-for="sede in sedes" :key="sede.id" :value="sede.id">{{
										sede.description
									}}</option>

								</select>
								<span v-if="v$.form.inscripcion.fecha.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha inicio CB</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form.inscripcion.fecha_inicio" auto-apply year-picker
									:disabled="input_disable">
								</Datepicker>
							</div>

							<div class="col-span-12 xl:col-span-12">
								<label for="observacion" class="block text-sm font-medium text-gray-700">Observaciones
								</label>
								<div class="mt-1">
									<textarea v-model="form.inscripcion.observacion" id="observacion" name="observacion" rows="3" :disabled="input_disable"
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"
										:class="input_disable ? bg_disable : ''"/>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- DOMICILIO -->
				<TabDireccion 	v-if="this.tabs === 2"
									:form="form.direccion"
									:input_disable="input_disable"
									:localidades="localidades"
									@submit="handleDireccion">
				</TabDireccion>

				<!-- SALUD -->
				<TabSalud 	v-if="this.tabs === 3"
									:form="form.salud"
									:input_disable="input_disable"
									@submit="handleSalud">
				</TabSalud>

				<!-- AUTORIZACIONES -->
				<TabAutorizaciones 	v-if="this.tabs === 4"
									:form="form.autorizaciones"
									:input_disable="input_disable"
									@submit="handleAutorizaciones">
				</TabAutorizaciones>

				<!-- Educacion -->
				<TabEducacion 	v-if="this.tabs === 5"
									:form="form.educacion"
									:input_disable="input_disable"
									:nivelesEducativo="nivelesEducativo"
									:estadosEducativo="estadosEducativo"
									:turnosEducativo="turnosEducativo"
									@submit="handleEducacion">
				</TabEducacion>

				<!-- ADULTO RESPONSABLE -->
				<TabResponsable 	v-if="this.tabs === 6"
									:v="v$"
									:form="form.responsable"
									:input_disable="input_disable"
									:tiposDocumento="tiposDocumento"
									@submit="handleResponsable">
				</TabResponsable>

			</form>
		</div>
	</main>
</template>

<script>
import { ref } from "vue";
import { useVuelidate } from '@vuelidate/core'
import { required, helpers, minLength } from '@vuelidate/validators'

import { ArrowLeftCircleIcon, ArrowsPointingInIcon ,PlusCircleIcon, TrashIcon} from "@heroicons/vue/24/outline";
import Toast from "@/Layouts/Components/Toast.vue";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { Switch } from "@headlessui/vue";
import store from '@/store.js'

// Tabs
import TabAutorizaciones from './Components/TabAutorizaciones.vue';
import TabDireccion from './Components/TabDireccion.vue';
import TabSalud from './Components/TabSalud.vue';
import TabEducacion from './Components/TabEducacion.vue';
import TabResponsable from './Components/TabResponsable.vue';


export default {
	props: {
		acompanamientosCbj: Object,
        actividadesCbj: Object,
        barrios: Object,
        canalesAtencion: Object,
        coberturasMedica: Object,
        comedores: Object,
        estadosEducativo: Object,
        localidades: Object,
        nivelesEducativo: Object,
        paises: Object,
        programasSocial: Object,
        rolesTramite: Object,
        sedes: Object,
        situacionesConyugal: Object,
        tiposDocumento: Object,
        tiposOcupacion: Object,
        tiposPension: Object,
        tiposTramite: Object,
        tiposVivienda: Object,
        turnosEducativo: Object

	},
	components: {
		ArrowsPointingInIcon,
        ArrowLeftCircleIcon,
        PlusCircleIcon,
        TabAutorizaciones,
        TabDireccion,
        TabEducacion,
        TabResponsable,
        TabSalud,
        Toast,
        TrashIcon,
        Datepicker,
        Switch,
        helpers,
        minLength,
        required,
        store,
        useVuelidate,

	},
	data() {
		return {
			tabs: 1,
			// Datos formulario
			form: {
				person:{},
				contact: {},
				inscripcion: {},
				autorizaciones: {},
				direccion: {},
				salud: {},
				educacion: {},
				responsable: {}
			},

			/* MENSAJERIA */
			toastMessage: "",
			labelType: "info",
			showToast: false,

			// Multiselect
			actividadSelect: '',
            actividadesSelected: [],
			acompanamientoSelect: '',
            acompanamientosSelected: [],
			tallerSelect: '',
            talleresSelected: [],

			// Disabled - Enabled
			bg_disable: 'bg-gray-100',
			btnGuardar: false,
			input_disable: true,
			datepickerStyle: {
				color: 'red',
				border: '1px solid red',
			},
		};
	},
	validations() {
		const dynamicValidations = this.form.responsable.num_documento
				? {
					tipo_documento_id: { required: helpers.withMessage('Responsable: El campo Tipo de Documento es Obligatorio', required) },
					name: { required: helpers.withMessage('Responsable: El campo Nombre es Obligatorio', required) },
					lastname: { required: helpers.withMessage('Responsable: El campo Apellido es Obligatorio', required) },
					fecha_nac: { required: helpers.withMessage('Responsable: El campo Fecha de Nacimiento es Obligatorio', required) }
				}
				: {};
		return {

			// Validaciones de campos obligatorios
			form: {
				person: {
					tipo_documento_id: { required: helpers.withMessage('El campo Tipo de Documento es Obligatorio', required) },
					num_documento: { required: helpers.withMessage('El campo N° de documento es Obligatorio', required) }, // Matches this.contact.email
					name: { required: helpers.withMessage('El campo Nombre es Obligatorio', required) },
					lastname: { required: helpers.withMessage('El campo Apellido es Obligatorio', required) },
					fecha_nac: { required: helpers.withMessage('El campo Fecha de Nacimiento es Obligatorio', required) },
				},
				inscripcion: {
					fecha: { required: helpers.withMessage('El campo Fecha de Inscripcion es Obligatorio', required) },
					canal_atencion_id: { required: helpers.withMessage('El campo Canal de Atencion es Obligatorio', required) },
					sede_id: { required: helpers.withMessage('El campo Sede es Obligatorio', required) },
				},
				responsable:
					dynamicValidations,
			}
		}
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
			v$: useVuelidate()
		};
	},
	methods: {
		closeModal() {
            this.openModal = false
        },
		clearMessage() {
			this.toastMessage = "";
		},
		clearFormData() {
			this.form = {
				autorizaciones: {},
                contact: {},
                direccion: {},
                educacion: {},
                inscripcion: {},
                person: {},
                responsable: {},
                salud: {},

			}
		},
		async submit() {
			// VALIDACION CAMPOS OBLIGATORIOS
			const result = await this.v$.$validate()
			if(!result){
				return
			}

			// RUTA
			let rt = route("inscripcionCBJ.store");

			// FORMATEO DE FECHAS
			this.form.fecha = this.form.fecha
				? new Date(this.form.fecha).toISOString()
				: null;
			this.form.fecha_nac = this.form.fecha_nac
				? new Date(this.form.fecha_nac).toISOString()
				: null;

			try {
				const response = await axios.post(rt, this.form);
				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
					this.btnGuardar = false
					setTimeout(() => {
						window.location.href = "/centros-barriales/juventud";
					}, 3100);
				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
				}
			} catch (error) {
				this.labelType = "danger";
				this.toastMessage = "Se ha producido un error | Por Favor Comuniquese con el Administrador!"
			}
		},
		async getPerson() {
			let num_documento = this.form.person.num_documento;
			const get = `${route('persons.getPersonDni', this.form.person.num_documento)}`
			const response = await fetch(get, { method: 'GET' })
			let data = await response.json()
			if (!data.data.length == 0) {
				this.clearFormData()
				data = data.data[0].person

				if(data.legajo_cb){
					this.labelType = "danger";
					this.toastMessage = "El DNI ya se encuentra inscripto en Centros Barriales";

					this.input_disable = true;
				}else{
					this.form.person.num_documento = num_documento;
					/// Recuperar datos.
					this.form.person.tipo_documento_id = data.tipo_documento_id
					this.form.person.fecha_nac = data.fecha_nac
					this.form.person.fecha_nac = new Date(this.form.person.fecha_nac + "T00:00:00.000-03:00")
					this.form.person.name = data.name
					this.form.person.lastname = data.lastname
					if (data.contact != '') {
						this.form.contact.email = data.contact[0].email
						this.form.contact.phone = data.contact[0].phone
					}

					if (data.address != '') {
						this.form.direccion.localidad_id = data.address[0].localidad_id
						this.form.direccion.calle = data.address[0].calle
						this.form.direccion.number = data.address[0].number
						this.form.direccion.piso = data.address[0].piso
						this.form.direccion.dpto = data.address[0].dpto
					}

					if (data.salud != null) {
						this.form.salud.apto_medico = data.salud.apto_medico
						this.form.salud.fecha_apto_medico = data.salud.fecha_apto_medico
						this.form.salud.fecha_apto_medico = new Date(this.form.salud.fecha_apto_medico + "T00:00:00.000-03:00")
						this.form.salud.electrocardiograma = data.salud.electrocardiograma
						this.form.salud.fecha_electrocardiograma = data.salud.fecha_electrocardiograma
						this.form.salud.fecha_electrocardiograma = new Date(this.form.salud.fecha_electrocardiograma + "T00:00:00.000-03:00")
					}

					if (data.education[0]) {
						this.form.educacion.nivel_educativo_id = data.education[0].nivel_educativo_id
						this.form.educacion.estado_educativo_id = data.education[0].estado_educativo_id
						this.form.educacion.escuela_turno_id = data.education[0].escuela_turno_id
					}

					this.form = this.removeNullValues(this.form);
					this.input_disable = false;
				}
			} else {
				this.labelType = "info";
				this.toastMessage = "El DNI indicado no se encuentra registrado";
				this.clearFormData()
				this.form.person.num_documento = num_documento;
				this.input_disable = false;
			}
		},
		removeNullValues(data) {
			return Object.fromEntries(Object.entries(data).filter(([key, value]) => value !== null && value !== undefined));
		},
		requiredPerson(){
			this.labelType = "info";
			this.toastMessage = "Debe ingresar un DNI.";
		},
		handleAutorizaciones(data){
			this.form.autorizaciones = data;
		},
		handleDireccion(data){
			this.form.direccion = data;
		},
		handleSalud(data){
			this.form.salud = data;
		},
		handleEducacion(data){
			this.form.educacion = data;
		},
		handleResponsable(data){
			this.form.responsable = data;
		}
	},
	computed: {
	},

	mounted() {
		this.form.tipo_tramite_id = "";
		this.form.observacion = "";
	},
};
</script>
