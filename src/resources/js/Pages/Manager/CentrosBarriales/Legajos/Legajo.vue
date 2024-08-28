<template>
	<!-- eslint-disable -->
	<!-- <CreateModal :open="showModal" @close="showModal = false" /> -->

	<main class="flex-1 bg-gray-50 pb-40">
		<!-- Page title & actions -->
		<div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
			<div class="flex-1 min-w-0 flex items-center justify-between">
				<div class="flex items-center">
					<a class="btn-blue" :href="route('legajoCB')">
						<ArrowLeftCircleIcon class="w-5 h-5 text-purple-700 mr-2" />
					</a>
					<h1 class="font-sm font-medium text-gray-600 sm:truncate">
						Detalle del Legajo
					</h1>
				</div>
				<div class="flex">
					<button type="button"
						class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Editar</button>
					<button type="button" @click="showForm = true"
						class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Crear</button>
				</div>
			</div>
		</div>

		<Toast :toast="toastMessage" :type="labelType" @clear="clearMessage"></Toast>
		<div class="py-10">
			<div class="max-w-3xl mx-auto sm:px-6 lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-12 lg:gap-8">
				<div class="lg:col-span-8 xl:col-span-8">
					<div class="border-b border-gray-200 dark:border-gray-700">
						<ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
							<li v-for="(item, index) in subNavigation" :key="item.name" class="me-2 w-1/5">
								<a href="#" @click.prevent="selectItem(index)"
									:class="tabs === index ? 'border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'"
									class="w-full inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group">
									{{ item.name }}
								</a>
							</li>
						</ul>
					</div>
					<component :is="selectedItem.componentName" :data="selectedItem.componentData" :legajo="legajo"
						:sedes="sedes" :users="users" :areas="areas" :canalesAtencion="canalesAtencion"
						:tiposLegajo="tiposLegajo" :estados="estados" :localidades="localidades" :paises="paises"
						:parentescos="parentescos" :situacionesConyugal="situacionesConyugal"
						:tiposOcupacion="tiposOcupacion" :estadosEducativo="estadosEducativo"
						:nivelesEducativo="nivelesEducativo" :centrosSalud="centrosSalud" 
						:escuelas="escuelas" :turnosEducativo="turnosEducativo" 
						:escuelasDependencia="escuelasDependencia" :escuelasNivel="escuelasNivel" 
						:estadosGabinete="estadosGabinete" @message="messageToast" />
				</div>

				<div class="lg:col-span-4 xl:col-span-4">
					<div class="sticky top-4">
						<!-- Datos Titular -->

						<PersonComponent :localidades="localidades" :legajo="legajo" @message="messageToast"/>
						<AssignedComponent :users="users" :legajo="legajo" @message="messageToast"/>
						<!-- Fin  Datos Titular -->
						<!-- Datos Asignado -->
						<!-- <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-4">
							<div class="sm:flex sm:justify-between sm:items-center">
								<div class="px-4 py-5 sm:px-6">
									<h3 class="text-lg leading-6 font-medium text-gray-900">Asignado</h3>
								</div>
								<div
									class="mt-4 pr-4 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
									<button type="submit"
										class="inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Reasignar</button>
								</div>
							</div>

							<div class="border-t border-gray-200 px-4 py-5 sm:p-0">
								<dl class="sm:divide-y sm:divide-gray-200">
									<div class="pl-4 py-4 grid grid-cols-2 gap-4">
										<dt class="text-sm font-medium text-gray-500 col-span-1">Usuario:</dt>
										<dd class="mt-1 pr-4 text-sm text-gray-900 sm:mt-0 sm:col-span-1"> <select
												id="profesional_id" name="profesional_id" autocomplete="off"
												:class="input_disable ? bg_disable : ''" :disabled="input_disable"
												class="mt- block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
												<option value="" disabled>
													Seleccione un Profesional
												</option>
												<option v-for="p in users" :key="p.id" :value="p.id">
													{{ p.name ?? '' }}
												</option>
											</select></dd>
									</div>
								</dl>
							</div>
						</div> -->
						<!-- Fin  Datos Asignado -->
					</div>
				</div>
			</div>
		</div>

		<CreateModal v-if="showForm" :open="showForm" :programasSociales="programasSociales" :actividades="actividades"
			:users="users" :areas="areas" @closeForm="showForm = false" @submitStore="submitStore" />

	</main>
</template>

<script setup>
import { ref, computed } from 'vue';
import Toast from "@/Layouts/Components/Toast.vue";
import InformacionGeneral from './InformacionGeneral.vue';
import Programas from './Programas/Programas.vue';
import Archivos from './Archivos/Archivos.vue';
import Informes from './Informes/Informes.vue';
import Actividades from './Actividades/Actividades.vue';
import PersonComponent from './Components/Person.vue';
import AssignedComponent from './Components/Assigned.vue';
import FormCreate from './FormCreate.vue';

import CreateModal from './CreateModal.vue';
import { PencilSquareIcon } from '@heroicons/vue/24/solid'
import { ArrowLeftCircleIcon, CubeIcon } from '@heroicons/vue/24/outline'
import store from '@/store.js'


const props = defineProps({
	legajo: Object,
	users: Object,
	programasSociales: Object,
	actividades: Object,
	areas: Object,
	localidades: Object,
	sedes: Object,
	canalesAtencion: Object,
	tiposLegajo: Object,
	estados: Object,

	paises: Object, 
	parentescos: Object,
	situacionesConyugal: Object,
	tiposOcupacion: Object,
	estadosEducativo: Object,
	nivelesEducativo: Object,

	centrosSalud: Object,

	escuelas: Object,
	turnosEducativo: Object,
	escuelasDependencia: Object,
	escuelasNivel: Object,
	estadosGabinete: Object
});

const legajo = props.legajo;
const users = props.users;
const programasSociales = props.programasSociales;
const actividades = props.actividades;

const subNavigation = [
	{ name: 'General', icon: CubeIcon, componentName: InformacionGeneral },
	{ name: 'Programas', icon: CubeIcon, componentName: Programas },
	{ name: 'Actividades', icon: CubeIcon, componentName: Actividades },
	{ name: 'Informes', icon: CubeIcon, componentName: Informes },
	{ name: 'Archivos', icon: CubeIcon, componentName: Archivos },
]

const tabs = ref(0);
const toastMessage = ref("");
const labelType = ref("info");
const showModal = ref(false);
const showForm = ref(false);
const editTitular = ref(false);

const selectItem = (index) => {
	tabs.value = index;
};

const selectedItem = computed(() => {
	return subNavigation[tabs.value];
});

function clearMessage() {
	toastMessage.value = "";
}

function messageToast(data) {
	labelType.value = data.labelType;
	toastMessage.value = data.message;
}

function viewForm() {
	showForm.value = true;
}

async function submitStore(data) {
	// RUTA
	data.legajo_id = legajo[0].id
	console.log(data);
	let rt = ''
	if (data.selectedOption === 'programa_social') {
		rt = route("legajoCB.storeProgramaSocial");
	} else if (data.selectedOption === 'actividades') {
		rt = route("legajoCB.storeActividad");
	} else {
		labelType.value = "info";
		toastMessage.value = 'No se ha seleccionado un tipo de inscripcion';
	}

	try {
		const response = await axios.post(rt, data);
		if (response.status == 200) {
			labelType.value = "success";
			toastMessage.value = response.data.message;
			showForm.value = false
			if (data.selectedOption === 'programa_social') {
				legajo[0].programas_sociales = response.data.programas[0].programas_sociales
			} else {
				legajo[0].actividades = response.data.actividades[0].actividades
			}
			// TODO: Actualizar los datos de los programas sociales
		} else {
			labelType.value = "info";
			toastMessage.value = response.data.message;
		}
	} catch (error) {
		labelType.value = "danger";
		toastMessage.value = "Se ha producido un error | Por Favor Comuniquese con el Administrador!"
	}
}

</script>

<style></style>
