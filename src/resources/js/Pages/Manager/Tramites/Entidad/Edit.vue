
<template>
	<main class="flex-1 bg-gray-50 pb-40">
		<!-- Page title & actions -->
		<div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
			<div class="flex-1 min-w-0 flex items-center">
				<a class="btn-blue" :href="route('entidad')">
					<ArrowLeftCircleIcon class="w-5 h-5 text-purple-700 mr-2" />
				</a>
				<h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
					Nueva Entidad
				</h1>
			</div>
			<div class="mt-4 flex sm:mt-0 sm:ml-4">
				<button
					class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"
					:class="btnGuardar ? 'bg-gray-600 hover:bg-gray-700' : 'bg-green-600 hover:bg-green-700'"
					@click="submit" :disabled="btnGuardar">
					Guardar
				</button>
			</div>
		</div>

		<Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

		<div v-if="v$.form.$error" class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="px-4 mt-6 sm:px-6 lg:px-8 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md"
				role="alert">
				<p class="font-bold">Campos requeridos</p>
				<p v-for="error of v$.form.$errors" :key="error.$uid">
					{{ error.$message }}
				</p>
			</div>
		</div>

		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<form action="#" method="POST">
				<div class="shadow sm:rounded-md sm:overflow-hidden">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">
								Datos de la Entidad
							</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-3">
								<label for="num_entidad" class="block text-sm font-medium text-gray-700">Nro de
									Entidad</label>
								<input v-model="form.num_entidad" type="number" name="num_entidad" id="num_entidad"
									autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.num_entidad.$error ? 'border-red-500' : ''" />
								<span v-if="v$.form.num_entidad.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
								<input v-model="form.name" type="text" name="name" id="name" autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.name.$error ? 'border-red-500' : ''" />
								<span v-if="v$.form.name.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_entidad_id" class="block text-sm font-medium text-gray-700">Tipo de la
									Entidad</label>
								<select v-model="form.tipo_entidad_id" id="tipo_entidad_id" name="tipo_tramite_id"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Selecciones un tipo de entidad
									</option>
									<option v-for="tipoEntidad in tiposEntidad" :key="tipoEntidad.id"
										:value="tipoEntidad.id">
										{{ tipoEntidad.description }}
									</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="objeto" class="block text-sm font-medium text-gray-700">Objeto</label>
								<input v-model="form.objeto" type="text" name="objeto" id="objeto" autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />

							</div>

							<div class="col-span-12 sm:col-span-6">
								<label for="address" class="block text-sm font-medium text-gray-700">Direccion</label>
								<input v-model="form.address" type="text" name="address" id="address" autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />

							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="phone" class="block text-sm font-medium text-gray-700">Telefono</label>
								<input v-model="form.phone" type="text" name="phone" id="phone" autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />

							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="email" class="block text-sm font-medium text-gray-700">Email</label>
								<input v-model="form.email" type="text" name="email" id="email" autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />

							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="localidad_id" class="block text-sm font-medium text-gray-700">Localidad</label>
								<select v-model="form.localidad_id" id="localidad_id" name="localidad_id"
									autocomplete="localidad_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione una localidad
									</option>
									<option v-for="localidad in localidades" :key="localidad.id" :value="localidad.id">
										{{ localidad.description }}
									</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="solicitud_inscripcion" class="block text-sm font-medium text-gray-700">Solicitud
									de Inscripcion</label>
								<input v-model="form.solicitud_inscripcion" type="text" name="solicitud_inscripcion"
									id="solicitud_inscripcion" autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="fecha_inscripcion" class="block text-sm font-medium text-gray-700">Fecha
									Inscripción</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form.fecha_inscripcion" :enableTimePicker="false" :monthChangeOnScroll="true"
									autoApply :format="format">
								</Datepicker>
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
								<label for="fecha_fundacion" class="block text-sm font-medium text-gray-700">Fecha
									Fundación</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form.fecha_fundacion" :enableTimePicker="false" :monthChangeOnScroll="true"
									autoApply :format="format">
								</Datepicker>

							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="fecha_fin" class="block text-sm font-medium text-gray-700">Vencimiento del
									mandato</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form.fecha_fin_mandato" :enableTimePicker="false" :monthChangeOnScroll="true"
									autoApply :format="format">
								</Datepicker>

							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="fecha_asamblea" class="block text-sm font-medium text-gray-700">Última
									Asamblea</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form.fecha_asamblea" :enableTimePicker="false" :monthChangeOnScroll="true"
									autoApply :format="format">
								</Datepicker>

							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="fecha_memoria" class="block text-sm font-medium text-gray-700">Memoria y
									Balance</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form.fecha_memoria" :enableTimePicker="false" :monthChangeOnScroll="true"
									autoApply :format="format">
								</Datepicker>

							</div>


							<div class="col-span-12 sm:col-span-3">
								<label for="personeria" class="block text-sm font-medium text-gray-700">Personería
									Jurídica</label>
								<input v-model="form.personeria" type="text" name="personeria" id="personeria"
									autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />

							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="eximision" class="block text-sm font-medium text-gray-700">Eximisión de las
									tasas de ABL y SeH</label>
								<input v-model="form.eximision" type="text" name="eximision" id="eximision"
									autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />

							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_actividad_id" class="block text-sm font-medium text-gray-700">Tipo de
									Actividad</label>
								<select v-model="form.tipo_actividad_id" id="tipo_actividad_id" name="tipo_actividad_id"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Selecciones un tipo de entidad
									</option>
									<option v-for="tipoActividad in tiposActividad" :key="tipoActividad.id"
										:value="tipoActividad.id">
										{{ tipoActividad.description }}
									</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-9">
								<label for="observation" class="block text-sm font-medium text-gray-700">Observaciones
								</label>
								<div class="mt-1">
									<textarea v-model="form.observation" id="observation" name="observation" rows="3"
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" />
								</div>
								<p class="mt-2 text-sm text-gray-500">
									Ingrese información adicional sobre la Entidad.
								</p>
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
							<div class="flex-shrink-0">
								<button type="button" @click="addAutoridad()"
									class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md"
									:class="showAutoridad
										? 'bg-red-200 text-red-900 hover:bg-red-600 hover:text-white'
										: 'bg-green-200 text-green-900 hover:bg-green-600 hover:text-white'
										">
									{{ this.textBtnAutoridad }}
								</button>
							</div>
						</div>
						<hr v-if="this.showAutoridad">
						<div class="grid grid-cols-12 gap-6" v-if="this.showAutoridad">
							<div class="col-span-12 sm:col-span-3">
								<label for="cargo_id" class="block text-sm font-medium text-gray-700">Cargo de
									Autoridad</label>
								<select v-model="form_temp.cargo_id" id="cargo_id" name="cargo_id" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un tipo de documento
									</option>
									<option v-for="cargo in cargos" :key="cargo.id" :value="cargo.id">{{
										cargo.description
									}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
								<input v-model="form_temp.name" type="text" name="name" id="name" autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="phone" class="block text-sm font-medium text-gray-700">Telefono</label>
								<input v-model="form_temp.phone" type="text" name="phone" id="phone" autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-3">
								<button type="button" @click="storeAutoridad()"
									class="mt-7 relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">
									Agregar Autoridad
								</button>
							</div>

						</div>


						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-12">
								<table class="min-w-full divide-y divide-gray-200 w-full col-span-6 sm:col-span-12 ">
									<thead class="bg-gray-50">
										<tr>
											<th scope="col"
												class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12">
												Cargo
											</th>
											<th scope="col"
												class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12">
												Nombre
											</th>
											<th scope="col"
												class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12">
												Telefono
											</th>
											<th scope="col"
												class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12">
												Acciones
											</th>
										</tr>
									</thead>
									<tbody>
										<ListItem v-for="autoridad in this.form_autoridades" :key="autoridad.id"
											:item=autoridad :cargos=cargos @edit-item="editItem" @hide-item="hideItem"
											@destroy-item="destroyItem" />

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

			</form>
		</div>

		<div class="px-4 mt-6 sm:px-6 lg:px-8 flex justify-end w-full">
			<button
				class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"
				:class="btnGuardar ? 'bg-gray-600 hover:bg-gray-700' : 'bg-green-600 hover:bg-green-700'" @click="submit"
				:disabled="btnGuardar">
				Guardar
			</button>
		</div>
	</main>
</template>

<script>

import { ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, helpers, minLength } from '@vuelidate/validators'
import { ArrowLeftCircleIcon, ArrowDownCircleIcon } from '@heroicons/vue/24/outline';
import Toast from "@/Layouts/Components/Toast.vue";
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import ListItem from './ListItem.vue';

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
		ArrowDownCircleIcon,
		Toast,
		Datepicker,
		required,
		useVuelidate,
		helpers,
		minLength,
		ListItem
	},
	data() {
		return {
			form: {},
			form_autoridades: [],
			form_temp: {},
			/* MENSAJERIA */
			toastMessage: "",
			labelType: "info",
			message: "",
			showToast: false,
			btnGuardar: false,
			textBtnAutoridad: "Agregar Autoridad",
			showAutoridad: false
		}
	},
	setup() {
		const format = (date) => {
			const day = date.getDate();
			const month = date.getMonth() + 1;
			const year = date.getFullYear();

			return `${day}/${month}/${year}`;
		}

		return {
			format,
			v$: useVuelidate()
		}
	},
	validations() {
		return {
			form: {
				num_entidad: { required: helpers.withMessage('El campo Numero es Obligatorio', required) },
				name: { required: helpers.withMessage('El campo Nombre es Obligatorio', required) }
			},
		}
	},
	methods: {
		clearMessage() {
			this.toastMessage = "";
		},
		async submit() {
			const result = await this.v$.$validate()
			if (!result) {
				return
			}
			this.btnGuardar = true
			let rt = route('entidad.update', this.form.id);

			const formReduce = { ...this.form };

			// Excluir una propiedad del objeto clonado
			delete formReduce.autoridades;
			try {
				const response = await axios.post(rt, { form: formReduce });
				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
					setTimeout(() => {
						window.location.href = '/entidad';
					}, 1000)
				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
					this.btnGuardar = false
				}
			} catch (error) {
				console.log(error)
			}

		},
		async storeAutoridad() {
			if (this.form_autoridades.find(autoridad => autoridad.cargo_id === this.form_temp.cargo_id)) {
				this.labelType = "danger";
				this.toastMessage = "El cargo ya se ha ingresado previamente";
			} else {
				try {
					this.form_temp.id_entidad = this.form.id

					const response = await axios.post(route('entidad.addAutoridad'), this.form_temp);

					if (response.status == 200) {
						this.labelType = "success";
						this.toastMessage = response.data.message;
						let data
						data = response.data.autoridad
						data.cargo = response.data.cargo
						this.form_autoridades.push(data)
						this.form_temp = {}
						this.showAutoridad = false
						this.textBtnAutoridad = "Agregar Autoridad"

					} else {
						this.labelType = "danger";
						this.toastMessage = response.data.message;
					}
				} catch (error) {
					console.log(error)
				}
			}

		},
		async editItem(item) {
			let formData = new FormData();
			formData.append('id', item.id);
			formData.append('name', item.name);
			formData.append('phone', item.phone);

			try {
				const response = await axios.post(route('entidad.updateAutoridad'), formData);

				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;

					this.autoridades = this.form_autoridades.find(item => item.id != id)
					this.autoridades.name = item.name
					this.autoridades.phone = item.phone

				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
				}
			} catch (error) {
				console.log(error)
			}
		},
		async destroyItem(id) {
			const response = await axios.post(route('entidad.destroyAutoridad'), { id: id });

			if (response.status == 200) {
				this.labelType = "success";
				this.toastMessage = response.data.message;

				this.form_autoridades = this.form_autoridades.filter(item => item.id != id)

			} else {
				this.labelType = "danger";
				this.toastMessage = response.data.message;
			}
		},
		addAutoridad() {
			if (this.showAutoridad) {
				this.textBtnAutoridad = "Agregar Autoridad";
				this.form_temp = {};
			} else {
				this.textBtnAutoridad = "Borrar Autoridad";
			}
			this.showAutoridad = !this.showAutoridad;
		},
	},
	mounted() {
		this.form = this.entidad[0]
		this.form_autoridades = this.entidad[0].autoridades

		this.form.fecha_inscripcion = new Date(this.form.fecha_inscripcion + "T00:00:00.000-03:00")
		this.form.fecha_fundacion = new Date(this.form.fecha_fundacion + "T00:00:00.000-03:00")
		this.form.fecha_asamblea = new Date(this.form.fecha_asamblea + "T00:00:00.000-03:00")
		this.form.fecha_memoria = new Date(this.form.fecha_memoria + "T00:00:00.000-03:00")
		this.form.fecha_fin_mandato = new Date(this.form.fecha_fin_mandato + "T00:00:00.000-03:00")
	},
}
</script>



