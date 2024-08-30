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
						:estadosGabinete="estadosGabinete" :actividades="actividades" :programasSociales="programasSociales"
						@message="messageToast" />
				</div>

				<div class="lg:col-span-4 xl:col-span-4">
					<div class="sticky top-4">
						<!-- Datos Titular -->
						<PersonComponent :localidades="localidades" :legajo="legajo" @message="messageToast"/>
						<AssignedComponent :users="users" :legajo="legajo" @message="messageToast"/>
						
					</div>
				</div>
			</div>
		</div>
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

</script>

<style></style>
