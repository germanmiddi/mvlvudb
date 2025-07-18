
<template>
	<main class="flex-1 bg-gray-50 pb-40">
		<!-- Page title & actions -->
		<div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
			<div class="flex-1 min-w-0 flex items-center">
				<a class="btn-blue" :href="route('entidad')">
					<ArrowLeftCircleIcon class="w-5 h-5 text-purple-700 mr-2" />
				</a>
				<h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
					Detalle de Entidad
				</h1>
			</div>
		</div>

		<Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="shadow sm:rounded-md sm:overflow-hidden">
				<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
					<div>
						<h3 class="text-lg leading-6 font-medium text-gray-900">
							Datos de la Entidad
						</h3>
					</div>

					<div class="grid grid-cols-12 gap-6">

						<div class="col-span-12 sm:col-span-3">
							<label class="block text-sm font-medium text-gray-700">Nro de Entidad</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
								{{ form.num_entidad || '-' }}
							</div>
						</div>

						<div class="col-span-12 sm:col-span-3">
							<label class="block text-sm font-medium text-gray-700">Nombre</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
								{{ form.name || '-' }}
							</div>
						</div>

						<div class="col-span-12 sm:col-span-3">
							<label class="block text-sm font-medium text-gray-700">Tipo de la Entidad</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
								{{ getTipoEntidadName(form.tipo_entidad_id) || '-' }}
							</div>
						</div>

						<div class="col-span-12 sm:col-span-3">
							<label class="block text-sm font-medium text-gray-700">Objeto</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
								{{ form.objeto || '-' }}
							</div>
						</div>

						<div class="col-span-12 sm:col-span-6">
							<label class="block text-sm font-medium text-gray-700">Dirección</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
								{{ form.address || '-' }}
							</div>
						</div>

						<div class="col-span-12 sm:col-span-3">
							<label class="block text-sm font-medium text-gray-700">Teléfono</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
								{{ form.phone || '-' }}
							</div>
						</div>

						<div class="col-span-12 sm:col-span-3">
							<label class="block text-sm font-medium text-gray-700">Email</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
								{{ form.email || '-' }}
							</div>
						</div>

						<div class="col-span-12 sm:col-span-3">
							<label class="block text-sm font-medium text-gray-700">Localidad</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
								{{ getLocalidadName(form.localidad_id) || '-' }}
							</div>
						</div>

						<div class="col-span-12 sm:col-span-3">
							<label class="block text-sm font-medium text-gray-700">Solicitud de Inscripción</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
								{{ form.solicitud_inscripcion || '-' }}
							</div>
						</div>

						<div class="col-span-12 sm:col-span-3">
							<label class="block text-sm font-medium text-gray-700">Fecha Inscripción</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
								{{ formatDate(form.fecha_inscripcion) || '-' }}
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
				<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
					<div>
						<h3 class="text-lg leading-6 font-medium text-gray-900">
							Fecha de Documentación
						</h3>
					</div>

					<div class="grid grid-cols-12 gap-6">

						<div class="col-span-12 sm:col-span-3">
							<label class="block text-sm font-medium text-gray-700">Fecha Fundación</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
								{{ formatDate(form.fecha_fundacion) || '-' }}
							</div>
						</div>

						<div class="col-span-12 sm:col-span-3">
							<label class="block text-sm font-medium text-gray-700">Vencimiento del mandato</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
								{{ formatDate(form.fecha_fin_mandato) || '-' }}
							</div>
						</div>

						<div class="col-span-12 sm:col-span-3">
							<label class="block text-sm font-medium text-gray-700">Última Asamblea</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
								{{ formatDate(form.fecha_asamblea) || '-' }}
							</div>
						</div>

						<div class="col-span-12 sm:col-span-3">
							<label class="block text-sm font-medium text-gray-700">Memoria y Balance</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
								{{ formatDate(form.fecha_memoria) || '-' }}
							</div>
						</div>

						<div class="col-span-12 sm:col-span-3">
							<label class="block text-sm font-medium text-gray-700">Personería Jurídica</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
								{{ form.personeria || '-' }}
							</div>
						</div>

						<div class="col-span-12 sm:col-span-3">
							<label class="block text-sm font-medium text-gray-700">Eximisión de las tasas de ABL y SeH</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
								{{ form.eximision || '-' }}
							</div>
						</div>

						<div class="col-span-12 sm:col-span-3">
							<label class="block text-sm font-medium text-gray-700">Tipo de Actividad</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
								{{ getTipoActividadName(form.tipo_actividad_id) || '-' }}
							</div>
						</div>

						<div class="col-span-12 sm:col-span-9">
							<label class="block text-sm font-medium text-gray-700">Observaciones</label>
							<div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md min-h-[80px]">
								{{ form.observation || '-' }}
							</div>
						</div>

					</div>
				</div>
			</div>

            <div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">

						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Autoridades
								</h3>
							</div>

						</div>

						<div class="grid grid-cols-12 gap-6" v-if="entidad[0].autoridades && entidad[0].autoridades.length > 0">
							<div class="col-span-12 sm:col-span-12">
                                <div >
                                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Rol
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Nombre
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Teléfono
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr v-for="autoridad in entidad[0].autoridades" :key="autoridad.id" class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ autoridad.cargo.description }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ autoridad.name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ autoridad.phone }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
				</div>



			<ParticipantesReadOnly :participantes="entidad[0].participantes" />
		</div>
	</main>
</template>

<script>
import { ArrowLeftCircleIcon } from '@heroicons/vue/24/outline';
import Toast from "@/Layouts/Components/Toast.vue";
import ParticipantesReadOnly from './ParticipantesReadOnly.vue';

export default {
	props: {
		localidades: Object,
		cargos: Object,
		tiposEntidad: Object,
		tiposActividad: Object,
		entidad: Object
	},
	components: {
		ArrowLeftCircleIcon,
		Toast,
		ParticipantesReadOnly
	},
	data() {
		return {
			form: {},
			/* MENSAJERIA */
			toastMessage: "",
			labelType: "info"
		}
	},
	methods: {
		clearMessage() {
			this.toastMessage = "";
		},
		formatDate(dateString) {
			if (!dateString) return null;
			const date = new Date(dateString);
			return date.toLocaleDateString('es-ES', {
				day: '2-digit',
				month: '2-digit',
				year: 'numeric'
			});
		},
		getTipoEntidadName(tipoEntidadId) {
			if (!tipoEntidadId || !this.tiposEntidad) return null;
			const tipo = this.tiposEntidad.find(t => t.id === tipoEntidadId);
			return tipo ? tipo.description : null;
		},
		getLocalidadName(localidadId) {
			if (!localidadId || !this.localidades) return null;
			const localidad = this.localidades.find(l => l.id === localidadId);
			return localidad ? localidad.description : null;
		},
		getTipoActividadName(tipoActividadId) {
			if (!tipoActividadId || !this.tiposActividad) return null;
			const tipo = this.tiposActividad.find(t => t.id === tipoActividadId);
			return tipo ? tipo.description : null;
		}
	},
	mounted() {
		this.form = this.entidad[0];
	},
}
</script>



