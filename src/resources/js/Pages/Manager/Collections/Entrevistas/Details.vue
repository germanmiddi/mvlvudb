
<template>
	<main class="flex-1 bg-gray-50 pb-40">
		<!-- Page title & actions -->
		<div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
			<div class="flex-1 min-w-0 flex items-center">
				<button class="btn-blue" @click.prevent="goBack()">
					<ArrowLeftCircleIcon class="w-5 h-5 text-purple-700 mr-2" />
				</button>
				<h1 class="font-sm font-medium text-gray-600 sm:truncate">
					Entrevista de Empadronamiento de Entrega de Cajas
					<!-- <span class="text-indigo-700 text-xl font-semibold ">{{tramite[0].dependencia.description}}</span> -->
				</h1>
			</div>
			<!-- <div class="mt-4 flex sm:mt-0 sm:ml-4">
				<button v-if="tramite[0].estado_id == 1 || tramite[0].estado_id == 3" class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 bg-blue-500 focus:ring-blue-500 sm:order-1 sm:ml-3"
						@click="changeStatus(2)">
						Cerrar Trámite
				</button>
				<button v-else class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 bg-indigo-500  focus:ring-indigo-500 sm:order-1 sm:ml-3"
						@click="changeStatus(1)">
					    Re Abrir Trámite					
				</button>
				<a target="_blank" :href="route('pdf.acusepdf', tramite[0].id)" class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 bg-green-500 focus:ring-green-500 sm:order-1 sm:ml-3">
					Imprimir Acuse					
				</a>
				<a :href="route('pdf.acuseobservacionpdf', tramite[0].id)" target="_blank" class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 bg-purple-500 focus:ring-green-500 sm:order-1 sm:ml-3">
					Imprimir Acuse Obs.</a>
			</div> -->
		</div>

		<Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="bg-white shadow overflow-hidden sm:rounded-lg">
				<div class="px-4 py-5 sm:px-6 flex justify-between">
					<h3 class="text-lg leading-6 font-medium text-gray-900">Información General</h3>
				
					<div v-if="entrevista.status_id == 1" class="flex justify-end items-center gap-4" > 
						<button class="px-4 py-2 border border-transparent 
									shadow-sm text-sm font-medium rounded-md 
									text-white bg-red-600 hover:bg-red-700 
									focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 
									sm:order-1 sm:ml-3" @click="changeStatus(3)">
							RECHAZAR
						</button>
						<button class="px-4 py-2 border border-transparent 
									shadow-sm text-sm font-medium rounded-md 
									text-white bg-green-600 hover:bg-green-700 
									focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 
									sm:order-1 sm:ml-3" @click="changeStatus(2)">
							APROBAR
						</button>
					</div>
				</div>

				<div class="border-t border-gray-200 px-4 py-5 sm:p-0">
					<dl class="sm:divide-y sm:divide-gray-200">
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Fecha de Ingreso</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{ store.dateFormateada(entrevista.fecha) }}</dd>
						</div>
						
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Estado</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
								<span class="px-3 py-2 rounded-md" 
									  :class="estadoClass[status_name]"> 
									{{ status_name }}</span>
							</dd>
						</div>
						
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Punto de Entrega</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ entrevista.puntos_entrega.description }}</dd>
						</div>
						
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Entrevistador</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ entrevista.entrevistador.name }}</dd>
						</div>
						
					</dl>
				</div>

			</div>
		</div>	


		<!-- Datos Titular -->
		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="bg-white shadow overflow-hidden sm:rounded-lg">
				<div class="px-4 py-5 sm:px-6">
					<h3 class="text-lg leading-6 font-medium text-gray-900">Datos del Titular</h3>
					<p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles del tramite.</p>
				</div>

				<div class="border-t border-gray-200 px-4 py-5 sm:p-0">
					<dl class="sm:divide-y sm:divide-gray-200">
			
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{ entrevista.person.lastname}}, {{ entrevista.person.name }}</dd>
						</div>
			
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Documento</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ entrevista.person.num_documento }}</dd>
						</div>
			
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ store.dateFormateada(entrevista.person.fecha_nac) }}</dd>
						</div>
			
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Dirección</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
								{{ entrevista.person.address[0].calle }} {{ entrevista.person.address[0].number }}
								<span v-if="entrevista.person.address[0].piso">
									, Piso: {{ entrevista.person.address[0].piso }}</span> 
								<span v-if="entrevista.person.address[0].dpto">
									, DPTO: {{ entrevista.person.address[0].dpto }}</span> 
								<span v-if="entrevista.person.address[0].localidad">
									, {{ entrevista.person.address[0].localidad.description }}</span>			
							</dd>
						</div>

						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Email</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ entrevista.person.contact[0].email ? entrevista.person.contact[0].email : "" }}</dd>
						</div>

						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Telefono</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ entrevista.person.contact[0].phone }}</dd>
						</div>

						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Celular</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ entrevista.person.contact[0].celular }}</dd>
						</div>

					</dl>
				</div>
				
			</div>
		</div>	
		<!-- Fin  Datos Titular -->


		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="bg-white shadow overflow-hidden sm:rounded-lg">
				<div class="px-4 py-5 sm:px-6">
					<h3 class="text-lg leading-6 font-medium text-gray-900">Situación Social</h3>
				</div>
				<div class="border-t border-gray-200 px-4 py-5 sm:p-0">
					<dl class="sm:divide-y sm:divide-gray-200">
					
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Pais de Origen</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ entrevista.person.aditional[0].nacionalidad }}</dd>
						</div>

						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Situación Conyugal</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ entrevista.person.aditional[0].situacion_conyugal.description }}</dd>
						</div>

						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Cantidad Hijos</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ entrevista.person.aditional[0].cant_hijos }}</dd>
						</div>		
					</dl>
				</div>	
			</div>
		</div>	
		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="bg-white shadow overflow-hidden sm:rounded-lg">
				<div class="px-4 py-5 sm:px-6">
					<h3 class="text-lg leading-6 font-medium text-gray-900">Situación Habitacional</h3>
				</div>
				<div class="border-t border-gray-200 px-4 py-5 sm:p-0">
					<dl class="sm:divide-y sm:divide-gray-200">
					
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Vive Solo</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ entrevista.vive_solo }}</dd>
						</div>
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Cant. Convivientes</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ entrevista.cant_convivientes }}</dd>
						</div>
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Tipo Tenencia</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ entrevista.tenencia }}</dd>
						</div>
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Cant. Ambientes</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ entrevista.ambientes }}</dd>
						</div>
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Pago Inquilino</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">$ {{ entrevista.pago_inquilino }}</dd>
						</div>

<!-- 
						<div v-if="nivelEducativo != '' " class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Nivel Educativo</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{ nivelEducativo }}</dd>
						</div>				

						<div v-if="ocupacion !=''" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Ocupación</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ocupacion}}</dd>
						</div>

						<div v-if="coberturaMedica != ''" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Cobertura Médica</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{coberturaMedica}}</dd>
						</div>

						<div v-if="programaSocial != ''" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Programa Social</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{programaSocial}}</dd>
						</div>

						<div v-if="tipoPension != ''" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Tipo Pensión</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{tipoPension}}</dd>
						</div>  -->
					</dl>
				</div>	
			</div>
		</div>	

		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="bg-white shadow overflow-hidden sm:rounded-lg">
				<div class="px-4 py-5 sm:px-6">
					<h3 class="text-lg leading-6 font-medium text-gray-900">Educación</h3>
				</div>
				<div class="border-t border-gray-200 px-4 py-5 sm:p-0">
					<dl class="sm:divide-y sm:divide-gray-200">
						<div v-if="nivelEducativo != '' " class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Último Nivel Educativo</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{ nivelEducativo }}</dd>
						</div>	

						<div v-if="estadoEducativo != '' " class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Estado Alcanzado</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{ estadoEducativo }}</dd>
						</div>	
					</dl>
				</div>	
			</div>
		</div>	


		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="bg-white shadow overflow-hidden sm:rounded-lg">
				<div class="px-4 py-5 sm:px-6">
					<h3 class="text-lg leading-6 font-medium text-gray-900">Situación Laboral</h3>
				</div>
				<div class="border-t border-gray-200 px-4 py-5 sm:p-0">
					<dl class="sm:divide-y sm:divide-gray-200">
						<div v-if="ocupacion != '' " class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Ocupación</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{ ocupacion }}</dd>
						</div>	

						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Percibe Jubilación / Pensión</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{ tipoPension }}</dd>
						</div>	
					</dl>
				</div>	
			</div>
		</div>	

		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="bg-white shadow overflow-hidden sm:rounded-lg">
				<div class="px-4 py-5 sm:px-6">
					<h3 class="text-lg leading-6 font-medium text-gray-900">Datos Adicionales</h3>
				</div>
				<div class="border-t border-gray-200 px-4 py-5 sm:p-0">
					<dl class="sm:divide-y sm:divide-gray-200">
						<div v-if="ocupacion != '' " class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Cobertura de Salud</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{ coberturaMedica }}</dd>
						</div>	

						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Recibe Programa Social</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{ programaSocial }}</dd>
						</div>	
					</dl>
				</div>	
			</div>
		</div>	
		<div v-if="entrevista.status_id == 1" class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="flex justify-end gap-4 px-4" > 
				<button class="px-4 py-2 border border-transparent 
							   shadow-sm text-sm font-medium rounded-md 
							   text-white bg-red-600 hover:bg-red-700 
							   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 
							   sm:order-1 sm:ml-3" @click="changeStatus(3)">
					RECHAZAR
				</button>
				<button class="px-4 py-2 border border-transparent 
							   shadow-sm text-sm font-medium rounded-md 
							   text-white bg-green-600 hover:bg-green-700 
							   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 
							   sm:order-1 sm:ml-3" @click="changeStatus(2)">
					APROBAR
				</button>
			</div>
		</div>
	</main>
</template>

<script>

import { ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, helpers, minLength } from '@vuelidate/validators'
import { ArrowLeftCircleIcon, ArrowDownCircleIcon } from '@heroicons/vue/24/outline';
import VueGoogleAutocomplete from "vue-google-autocomplete"
import GoogleMap from '@/Layouts/Components/GoogleMap.vue'
import FormBeneficiario from '@/Layouts/Components/Tramites/FormBeneficiario.vue'
import Toast from "@/Layouts/Components/Toast.vue";
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import Comment from '@/Layouts/Components/Tramites/Comment.vue';

import store from '@/store.js'

export default {

	props: {
		estados: Object,
		dependencias: Object,
		tramite: Object,
		users: Object,
		entrevista: Object,
	},
	components: {
		ArrowLeftCircleIcon,
		ArrowDownCircleIcon,
		GoogleMap,
		VueGoogleAutocomplete,
		Toast,
		Datepicker,
		FormBeneficiario,
		required,
		useVuelidate,
		helpers,
		minLength,
		Comment
	},
	data() {
		return {
			form: {},
			form_google: "",
			address: "",
			showMap: false,
			toastMessage: "",
			labelType: "info",
			message: "",
			showToast: false,
			file: "",
			form_archivo: {},
			form_beneficiario: {},
			showBenef: false,
			btnGuardar: false,
			datepickerStyle: {
				color: 'red',
				border: '1px solid red',
			},
			comments: [],
			// newDependencia: this.tramite[0].dependencia_id,
			newDepObservacion: "",
			// assignment: this.tramite[0].assigned,
			fileInvalid: false,
            estadoClass: {
                'APROBADA': 'badgeStatus bg-green-600 text-green-100',
                'PENDIENTE': 'badgeStatus bg-gray-200 text-gray-800',
                'RECHAZADA': 'badgeStatus bg-red-600 text-red-100'
            }
		
		}
	},
	setup() {
		// const format = (date) => {
		// 	const day = date.getDate();
		// 	const month = date.getMonth() + 1;
		// 	const year = date.getFullYear();

		// 	return `${day}/${month}/${year}`;
		// }

		return {
			// format,
			// estado,
			store
		}
	},

	methods: {
		goBack(){
			window.history.back();
		},
		
		handleMessage(data){
            this.labelType = data.labelType;
            this.toastMessage = data.toastMessage;
        },

		async changeStatus(newEstado){

			let rt = route('collections.entrevistas.update', {id: this.entrevista.id});

			let formData = new FormData();
			formData.append('status_id', newEstado)
			formData.append('id', this.entrevista.id)

			try {
				const response = await axios.post(rt, formData);
				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
					this.entrevista.status_id = newEstado

				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
				}
			} catch (error) {
				console.log(error)
			}
		},

		clearMessage() {
			this.toastMessage = "";
		},

		getAddressData: function (addressData, placeResultData, id) {
			this.form.google_address = placeResultData['formatted_address']
			this.form.latitude = addressData['latitude']
			this.form.longitude = addressData['longitude']

			this.form_google = addressData

			this.showMap = true
		},

		coord_google($coord) {
			this.form.latitude = $coord.position.lat.toString()
			this.form.longitude = $coord.position.lng.toString()
			this.form.google_address = $coord.address

			// TODO: Mapa: Ver como cargar el nombre de la calle en el Auto-complete-google
		},

	},

	computed: {
  		nivelEducativo: function() {
    		return this.entrevista?.person.education[0]?.nivel_educativo?.description ?? '';
  		},
  		estadoEducativo: function() {
    		return this.entrevista?.person.education[0]?.estado_educativo?.description ?? '';
  		},
		ocupacion: function() {
			return this.entrevista?.person.social[0]?.tipo_ocupacion?.description ?? '';
  		},
		coberturaMedica: function() {
			return this.entrevista?.person.social[0]?.cobertura_medica?.description ?? '';
  		},
		programaSocial: function() {
			return this.entrevista?.person.social[0]?.programa_social?.description ?? '';
  		},
		tipoPension: function() {
			return this.entrevista?.person.social[0]?.tipo_pension?.description ?? '';
	  	},

		status_name: function() {
            switch (this.entrevista.status_id) {
                case 1: return 'PENDIENTE';
                case 2: return 'APROBADA';
                case 3: return 'RECHAZADA';
                default: return '';
            }
        }
	},
}
</script>




