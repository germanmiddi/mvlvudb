<template>
	<main class="flex-1 bg-gray-50 pb-40">
		<!-- Page title & actions -->
		<div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
			<div class="flex-1 min-w-0 flex items-center">
				<a class="btn-blue" :href="route('mil-dias')">
					<ArrowLeftCircleIcon class="w-5 h-5 text-purple-700 mr-2" />
				</a>
				<h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
					Nuevo tramite Mil Dias. 
				</h1>
			</div>
			<div class="mt-4 flex sm:mt-0 sm:ml-4">
				<button 
					class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"
					:class="this.steps.length > this.step ? 'bg-gray-600 hover:bg-gray-600 cursor-default' : 'bg-green-600 hover:bg-green-700'"
					@click="submit" :disabled="this.steps.length < this.step">
					Guardar
				</button>
			</div>
		</div>

		<Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			
			<ol class="lg:flex items-center w-full space-y-4 lg:space-x-8 lg:space-y-0">
				<li v-for="s in this.steps" :key="step.item" class="flex-1">
					<a class="border-l-2 flex flex-col border-t-0 pl-4 pt-0 border-solid font-medium lg:pt-4 lg:border-t-2 lg:border-l-0 lg:pl-0"
						:class="this.step === s.item ? 'font-bold border-gray-600' : this.step > s.item ?  'border-green-600' : 'border-gray-300'">
						<span class="text-sm lg:text-base"
						:class="this.step === s.item ? 'font-bold text-gray-700' : this.step > s.item ?  'text-green-600' : 'text-gray-400'">Etapa {{s.item}}</span>
						<h4 class="text-base lg:text-lg"
						:class="this.step === s.item ? 'font-bold text-gray-900' : this.step > s.item ?  'font-bold text-gray-900' : 'text-gray-500'">{{s.name}}</h4>
					</a>
				</li>
			</ol>

			<DataTramite v-if="this.step === 1" 
							:form=this.form 
							:sedes=this.sedes
							:motivo_consultas=this.motivo_consultas
							:tipoTratamientos=this.tipoTratamientos
							:origenDemandas=this.origenDemandas
							:motivoBajas=this.motivoBajas
							:tipoDerivaciones=this.tipoDerivaciones
							:tipoArticulaciones=this.tipoArticulaciones
							@updateData="handleUpdateData"
							@message="handleMessage"></DataTramite>

			<DataBeneficiario v-if="this.step === 2" 
							:form=this.form
							:tiposDocumento="tiposDocumento"
							:paises="paises"
							:localidades="localidades"
							:barrios="barrios"
							@updateData="handleUpdateData"
							@message="handleMessage"></DataBeneficiario>

			<DataTutor v-if="this.step === 3" 
							:form=this.form 
							:parentescos="parentescos"
							:paises="paises"
							:nivelesEducativo="nivelesEducativo"
							:tiposOcupacion="tiposOcupacion"
							@updateData="handleUpdateData"
							@message="handleMessage"></DataTutor>

			<DataSalud v-if="this.step === 4" 
							:form=this.form 
							:familarAntecedentes=this.familarAntecedentes
							:tipoEnfermedades=this.tipoEnfermedades
							@updateData="handleUpdateData"
							@message="handleMessage"></DataSalud>
			
			<DataSubmit v-if="this.step === 5" 
							:form=this.form 
							@updateData="handleUpdateData"
							@message="handleMessage"></DataSubmit>
		</div>

		<div class="px-4 mt-6 sm:px-6 lg:px-8 flex justify-end w-full">
			<button
				class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"
				:class="this.steps.length > this.step ? 'bg-gray-600 hover:bg-gray-600 cursor-default' : 'bg-green-600 hover:bg-green-700'" @click="submit"
				:disabled="this.steps.length > this.step">
				Guardar
			</button>
		</div>
		
	</main>
</template>

<script>
import { ref } from "vue";

import { Inertia } from '@inertiajs/inertia'
import { ArrowLeftCircleIcon } from "@heroicons/vue/24/outline";

import Toast from "@/Layouts/Components/Toast.vue";

/* Components */
import DataTramite from './Components/DataTramite.vue';
import DataBeneficiario from './Components/DataBeneficiario.vue';
import DataTutor from './Components/DataTutor.vue';
import DataSalud from './Components/DataSalud.vue';
import DataSubmit from './Components/DataSubmit.vue';

import store from '@/store.js'

const steps = [
    { name: 'Datos Tramite', item: 1},
	{ name: 'Datos Niño', item: 2},
	{ name: 'Datos Tutor/es', item: 3},
	{ name: 'Datos Salud/Social', item: 4},
	{ name: 'Finalizar Tramite', item: 5}
]

export default {
	props: {
		barrios: Object,
		paises: Object,
		localidades: Object,
		sedes: Object,
		motivo_consultas: Object,
		tiposDocumento: Object,
		parentescos: Object,
		tiposOcupacion: Object,
		nivelesEducativo: Object,

		familarAntecedentes: Object,
		motivoBajas: Object,
		origenDemandas: Object,
		tipoArticulaciones: Object,
		tipoDerivaciones: Object,
		tipoEnfermedades: Object,
		tipoTratamientos: Object,
	},
	components: {
		ArrowLeftCircleIcon,
		Toast,
		store,

		/* Components */
		DataTramite,
		DataBeneficiario,
		DataTutor,
		DataSalud,
		DataSubmit
	},
	data() {
		return {
			form: {},
			/* STEP */
			step: 1,
			/* MENSAJERIA */
			toastMessage: "",
			labelType: "info",
			message: "",
			showToast: false,
		};
	},
	setup() {
		return {
			steps
		};
	},
	methods: {
		clearMessage() {
			this.toastMessage = "";
		},
		handleUpdateData(data){
			this.form = data;
			this.step ++;
		},
		handleMessage(data){
            this.labelType = data.labelType;
            this.toastMessage = data.toastMessage;
        },
		async submit() {
			this.btnGuardar = true
			let rt = route("mil-dias.store");
			try {
				const response = await axios.post(rt, this.form);
				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
					this.btnGuardar = false
				}
			} catch (error) {
				console.log(error);
			}
		}, 
	},
	created() {

	},
	computed: {
		
	},

	mounted() {
		this.form.motivo_consultas_id = []
	},
};
</script>
