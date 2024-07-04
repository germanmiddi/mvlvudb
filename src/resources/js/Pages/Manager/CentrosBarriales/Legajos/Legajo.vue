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
					<!-- <span class="text-indigo-700 text-xl font-semibold ">{{tramite[0].dependencia.description}}</span> -->
				</h1>
			</div>
			<div class="flex">
				<button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Editar</button>
				<button type="button" @click="showForm = true" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Crear</button>
			</div>
		</div>
	</div>

	<Toast :toast="toastMessage" :type="labelType" @clear="clearMessage"></Toast>
	<div class="py-10" >
		<div class="max-w-3xl mx-auto sm:px-6 lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-12 lg:gap-8">
			<div class="lg:col-span-8 xl:col-span-8" v-if="!showForm">
				<div v-if="!showForm" class="border-b border-gray-200 dark:border-gray-700">
					<ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
						<li v-for="(item, index) in subNavigation" :key="item.name" class="me-2 w-1/3">
							<a	href="#" @click.prevent="selectItem(index)"
								:class="tabs === index ? 'border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'"
								class="w-full inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group">
								{{ item.name }}
							</a>
						</li>
					</ul>
				</div>
				<component 	v-if="!showForm"
							:is="selectedItem.componentName"
						   	:data="selectedItem.componentData"
						   	:legajo="legajo" />
			</div>
            <div class="lg:col-span-8 xl:col-span-8" v-if="showForm">
                <FormCreate v-if="showForm" @closeForm="showForm=false"/>
            </div>

			<div class="lg:col-span-4 xl:col-span-4">
				<div class="sticky top-4">
					<!-- Datos Titular -->
					<div class="bg-white shadow overflow-hidden sm:rounded-lg">
						<div class="px-4 py-5 sm:px-6">
							<h3 class="text-lg leading-6 font-medium text-gray-900">Datos del Titular</h3>
						</div>

						<div class="border-t border-gray-200 px-4 py-5 sm:p-0">
							<dl class="sm:divide-y sm:divide-gray-200">

								<div class="pl-4 py-4 grid grid-cols-2 gap-4">
									<dt class="text-sm font-medium text-gray-500 col-span-1">Nombre:</dt>
									<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1" > {{legajo[0].person.lastname}}, {{ legajo[0].person.name }}</dd>
								</div>

								<div class="pl-4 py-4 grid grid-cols-2 gap-4">
									<dt class="text-sm font-medium text-gray-500 col-span-1">Documento:</dt>
									<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">{{legajo[0].person.num_documento}}</dd>
								</div>

								<div class="pl-4 py-4 grid grid-cols-2 gap-4">
									<dt class="text-sm font-medium text-gray-500 col-span-1">Fecha de Nac:</dt>
									<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">{{ store.dateFormateada(legajo[0].person.fecha_nac)}}</dd>
								</div>

								<div class="pl-4 py-4 grid grid-cols-2 gap-4">
									<dt class="text-sm font-medium text-gray-500 col-span-1">Teléfono</dt>
									<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">{{legajo[0].person?.contact[0]?.phone ?? '-'}}</dd>
								</div>

								<!-- <div class="py-4 grid grid-cols-2 gap-4">
									<dt class="text-sm font-medium text-gray-500 col-span-1">Email</dt>
									<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">{{legajo[0].person?.contact[0]?.email ?? "-" }}</dd>
								</div> -->


								<div class="pl-4 py-4 grid grid-cols-2 gap-4">
									<dt class="text-sm font-medium text-gray-500 col-span-1">Localidad</dt>
									<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">{{legajo[0].person?.address[0]?.localidad?.description ?? '-'}}</dd>
								</div>
							</dl>
						</div>
					</div>
					<!-- Fin  Datos Titular -->
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
import Actividades from './Actividades/Actividades.vue';
import FormCreate from './FormCreate.vue';

// import CreateModal from './CreateModal.vue';

import { ArrowLeftCircleIcon, CubeIcon } from '@heroicons/vue/24/outline'
import store from '@/store.js'

const props = defineProps({
	legajo: Object,
});

const legajo = props.legajo;

const subNavigation = [
    { name: 'General', icon: CubeIcon, componentName: InformacionGeneral },
    { name: 'Programas', icon: CubeIcon, componentName: Programas },
	{ name: 'Actividades', icon: CubeIcon, componentName: Actividades },

]

const tabs = ref(0);
const toastMessage = ref("");
const labelType = ref("info");
const showModal = ref(false);
const showForm = ref(false);

const selectItem = (index) => {
	tabs.value = index;
};

const selectedItem = computed(() => {
	return subNavigation[tabs.value];
});

function clearMessage() {
	toastMessage = "";
	//return toastMessage
}

function viewForm() {
	showForm.value = true;
}

</script>

<style>

</style>
