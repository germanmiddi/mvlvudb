<template>
	<main class="flex-1 bg-gray-50 pb-40">
		<!-- Page title & actions -->
		<div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
			<div class="flex-1 min-w-0 flex items-center">
				<!-- <a class="btn-blue" :href="route('inscripcionCBJ')">
					<ArrowLeftCircleIcon class="w-5 h-5 text-purple-700 mr-2" />
				</a> -->
				<h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
					Nueva Inscripcion CBJ
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
				<p v-for="error of v$.tramites.$errors" :key="error.$uid">
					{{ error.$message }}
				</p>
				<p v-for="error of v$.form.$errors" :key="error.$uid">
					{{ error.$message }}
				</p>
			</div>
		</div>

		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<form action="#" method="POST" enctype="multipart/form-data">

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
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
								<select v-model="form.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
									autocomplete="off"
									:class="v$.form.tipo_documento_id.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
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
								<span v-if="v$.form.tipo_documento_id.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de
									Documento</label>
								<div class="relative">
									<input type="text" v-model="form.num_documento" @keyup.enter="getPerson()" :class="v$.form.num_documento.$error ? 'border-red-500' : ''"
										class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
									<a @click="getPerson()" 
										class="absolute inset-y-0 right-0 px-4 py-2 bg-green-200 text-white text-xs rounded-r-md hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-600  shadow-sm text-xs font-medium flex items-center  text-green-900 hover:text-white">
										Verificar
									</a>
								</div>
								<span v-if="v$.form.num_documento.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>

							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
								<input v-model="form.name" type="text" name="name" id="name" autocomplete="name"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.name.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable" />
								<span v-if="v$.form.name.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
								<input v-model="form.lastname" type="text" name="lastname" id="lastname" autocomplete="name"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.lastname.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable" />
								<span v-if="v$.form.lastname.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="fecha_nac" class="block text-sm font-medium text-gray-700">Fecha de
									Nacimiento</label>
								<Datepicker
									class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:style="v$.form.fecha_nac.$error ? datepickerStyle : ''" v-model="form.fecha_nac"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									:enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
								</Datepicker>
								<span v-if="v$.form.fecha_nac.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="email" class="block text-sm font-medium text-gray-700">Mail</label>
								<input v-model="form.email" type="text" name="email" id="email" autocomplete="email"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
								<input v-model="form.celular" type="text" name="celular" id="phone" autocomplete="off"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

						</div>

					</div>
				</div>

				<!-- DATOS INSCRIPCION -->
				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">
								Datos de Inscripcion
							</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
								<Datepicker
									class="focus:ring-indigo-500 mt-1 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md"
									v-model="form.fecha" :enableTimePicker="false" :monthChangeOnScroll="true" autoApply
									:formatinscripcionCBJ="format" :style="v$.form.fecha.$error ? datepickerStyle : ''">
								</Datepicker>
								<span v-if="v$.form.fecha.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="canal_atencion" class="block text-sm font-medium text-gray-700">Canal de
									Atención</label>
								<select v-model="form.canal_atencion_id" id="canal_atencion" name="canal_atencion"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
									:class="v$.form.canal_atencion_id.$error ? 'border-red-500' : ''">
									<option value="" disabled>
										Selecciones un canal de atencion
									</option>
									<option v-for="canalAtencion in canalesAtencion" :key="canalAtencion.id"
										:value="canalAtencion.id">
										{{ canalAtencion.description }}
									</option>
								</select>
								<span v-if="v$.form.canal_atencion_id.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>
						
							<!-- <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="tipo_tramite_id" class="block text-sm font-medium text-gray-700">Tipo de
									Tramite</label>
								<select v-model="form.tipo_tramite_id" id="tipo_tramite_id" name="tipo_tramite_id"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
									:class="v$.tramites.$error ? 'border-red-500' : ''">
									<option value="" disabled>
										Selecciones un tipo de tramite
									</option>
									<option v-for="tipoTramite in tiposTramite" :key="tipoTramite.id"
										:value="tipoTramite.id">
										{{ tipoTramite.description }}
									</option>
								</select>
							</div> -->

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="sede_id" class="block text-sm font-medium text-gray-700">Sede</label>
								<select v-model="form.sede_id" id="sede_id" name="sede_id" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione una sede</option>
									<option v-for="sede in sedes" :key="sede.id" :value="sede.id">{{
										sede.description
									}}</option>

								</select>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="anio_inicio" class="block text-sm font-medium text-gray-700">Año de
									inicio CBJ</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form.anio_inicio" auto-apply year-picker>
								</Datepicker>
							</div>

							<!-- <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="estado_cbj_id" class="block text-sm font-medium text-gray-700">Estado en
									CBJ</label>
								<select v-model="form.estado_cbj_id" id="estado_cbj_id" name="estado_cbj_id"
									autocomplete="estado_cbj_id"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione un estado</option>
									<option value="activo">Activo</option>
									<option valur="solo_vacaciones" disabled>Solo en vacaciones</option>
									<option value="regular" disabled>Regular</option>
									<option value="no_participa" disabled>No Participa</option>
									<option value="Baja" disabled>Baja</option>
								</select>
							</div> -->

							<div class="col-span-12 xl:col-span-6">
								<label for="observacion" class="block text-sm font-medium text-gray-700">Observaciones
								</label>
								<div class="mt-1">
									<textarea v-model="form.observacion" id="observacion" name="observacion" rows="1"
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"
										:class="v$.tramites.$error ? 'border-red-500' : ''" />
								</div>
								<p class="mt-2 text-sm text-gray-500">
									Ingrese información adicional del tramite.
								</p>
							</div>
						</div>
					</div>
				</div>

				<!-- <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Datos del Titular
								</h3>
							</div>
							<div class="flex-shrink-0">
								<button type="button" @click="addBeneficiario()"
									class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md"
									:class="showBenef
										? 'bg-red-200 text-red-900 hover:bg-red-600 hover:text-white'
										: 'bg-green-200 text-green-900 hover:bg-green-600 hover:text-white'
										">
									{{ this.textBtnBenef }}
								</button>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Tipo de
									Documento</label>
								<select v-model="form.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
									autocomplete="off"
									:class="v$.form.tipo_documento_id.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
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
								<span v-if="v$.form.tipo_documento_id.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de
									Documento</label>
								<div class="relative">
									<input type="text" v-model="form.num_documento" @keyup.enter="getPerson()" :class="v$.form.num_documento.$error ? 'border-red-500' : ''"
										class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
									<a @click="getPerson()" 
										class="absolute inset-y-0 right-0 px-4 py-2 bg-green-200 text-white text-xs rounded-r-md hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-600  shadow-sm text-xs font-medium flex items-center  text-green-900 hover:text-white">
										Verificar
									</a>
								</div>
								<span v-if="v$.form.num_documento.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>

							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
								<input v-model="form.name" type="text" name="name" id="name" autocomplete="name"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.name.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable" />
								<span v-if="v$.form.name.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
								<input v-model="form.lastname" type="text" name="lastname" id="lastname" autocomplete="name"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.lastname.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable" />
								<span v-if="v$.form.lastname.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-3">
								<label for="fecha_nac" class="block text-sm font-medium text-gray-700">Fecha de
									Nacimiento</label>
								<Datepicker
									class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:style="v$.form.fecha_nac.$error ? datepickerStyle : ''" v-model="form.fecha_nac"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									:enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
								</Datepicker>
								<span v-if="v$.form.fecha_nac.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="email" class="block text-sm font-medium text-gray-700">Mail</label>
								<input v-model="form.email" type="text" name="email" id="email" autocomplete="email"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
								<input v-model="form.phone" type="text" name="phone" id="phone" autocomplete="off"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
								<input v-model="form.celular" type="text" name="celular" id="phone" autocomplete="off"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>
						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="codigo" class="block text-sm font-medium text-gray-700">Nro CUD</label>
								<input v-model="form.codigo" type="text" name="codigo" id="codigo" autocomplete="off"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="diagnostico" class="block text-sm font-medium text-gray-700">Diagnóstico</label>
								<input v-model="form.diagnostico" type="text" name="diagnostico" id="diagnostico"
									autocomplete="off" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>
					</div>
				</div> -->

				<!-- DOMICILIO -->
				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Datos de Dirección
								</h3>
							</div>
							<div class="flex-shrink-0">
								<button type="button" @click="card_direccion=!card_direccion"
									class=" bg-transparent relative inline-flex items-center px-2 py-2 shadow-sm text-xs font-medium rounded-md border-red-500"
									:class="card_direccion
										? 'bg-transparent text-red-900 hover:bg-red-300 hover:text-white border-red-500'
										: 'bg-transparent text-green-900 hover:bg-green-300 hover:text-white border-green-500'
										">
									<ArrowsPointingInIcon class="h-6 w-6 mr-2"></ArrowsPointingInIcon> {{card_direccion ? 'Ocultar' : 'Agregar'}}
								</button>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6" v-show="card_direccion">
							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="localidad_id" class="block text-sm font-medium text-gray-700">Localidad</label>
								<select v-model="form.localidad_id" id="localidad_id" name="localidad_id" autocomplete="off"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione una localidad
									</option>
									<option v-for="localidad in localidades" :key="localidad.id" :value="localidad.id">
										{{ localidad.description }}
									</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="calle" class="block text-sm font-medium text-gray-700">Calle</label>
								<input v-model="form.calle" type="text" name="calle" id="calle" autocomplete="off"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							
							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
								<label for="number" class="block text-sm font-medium text-gray-700">Número</label>
								<input v-model="form.number" type="text" name="number" id="number" autocomplete="off"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							
							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
								<label for="piso" class="block text-sm font-medium text-gray-700">Piso</label>
								<input v-model="form.piso" type="text" name="piso" id="piso" autocomplete="off"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							
							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
								<label for="dpto" class="block text-sm font-medium text-gray-700">Departamento</label>
								<input v-model="form.dpto" type="text" name="dpto" id="dpto" autocomplete="off"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>
					</div>
				</div>

				<!-- <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">
								Situación Social
							</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="pais_id" class="block text-sm font-medium text-gray-700">Pais de Origen</label>
								<select v-model="form.pais_id" id="pais_id" name="pais_id" autocomplete="off"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">
										Selecciones un pais
									</option>
									<option v-for="pais in paises" :key="pais.id" :value="pais.id"
										:bind:select="pais.id == form.pais_id">
										{{ pais.description }}
									</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="situacion_conyugal_id" class="block text-sm font-medium text-gray-700">Situación
									Conyugal</label>
								<select v-model="form.situacion_conyugal_id" id="situacion_conyugal_id"
									name="situacion_conyugal_id" autocomplete="off" :disabled="input_disable"
									:class="input_disable ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">
										Selecciones una situacion conyugal
									</option>
									<option v-for="situacionConyugal in situacionesConyugal" :key="situacionConyugal.id"
										:value="situacionConyugal.id" :bind:select="situacionConyugal.id ==
											form.situacion_conyugal_id
											">
										{{ situacionConyugal.description }}
									</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-4">
								<label for="cant_hijos" class="block text-sm font-medium text-gray-700">Cantidad
									Hijos</label>
								<input v-model="form.cant_hijos" type="text" name="cant_hijos" id="cant_hijos"
									autocomplete="off" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>
					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">
								Estudios
							</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="nivel_educativo_id" class="block text-sm font-medium text-gray-700">Nivel
									educativo en curso</label>
								<select v-model="form.nivel_educativo_id" id="nivel_educativo_id" name="nivel_educativo_id"
									autocomplete="off" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">
										Selecciones un nivel educativo
									</option>
									<option v-for="nivelEducativo in nivelesEducativo" :key="nivelEducativo.id"
										:value="nivelEducativo.id" :bind:select="nivelEducativo.id ==
											form.nivel_educativo_id
											">
										{{ nivelEducativo.description }}
									</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="estado_educativo_id" class="block text-sm font-medium text-gray-700">Nivel
									educativo alcanzado</label>
								<select v-model="form.estado_educativo_id" id="estado_educativo_id"
									name="estado_educativo_id" autocomplete="off" :disabled="input_disable"
									:class="input_disable ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">
										Selecciones un estado educativo
									</option>
									<option v-for="estadoEducativo in estadosEducativo" :key="estadoEducativo.id"
										:value="estadoEducativo.id" :bind:select="estadoEducativo.id ==
											form.estado_educativo_id
											">
										{{ estadoEducativo.description }}
									</option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">
								Situación Laboral
							</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_ocupacion_id"
									class="block text-sm font-medium text-gray-700">Ocupación</label>
								<select v-model="form.tipo_ocupacion_id" id="tipo_ocupacion_id" name="tipo_ocupacion_id"
									autocomplete="off" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">
										Selecciones una ocupacion
									</option>
									<option v-for="tipoOcupacion in tiposOcupacion" :key="tipoOcupacion.id"
										:value="tipoOcupacion.id" :bind:select="tipoOcupacion.id ==
											form.tipo_ocupacion_id
											">
										{{ tipoOcupacion.description }}
									</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_pension_id" class="block text-sm font-medium text-gray-700">Percibe
									Jubilación / Pensión</label>
								<select v-model="form.tipo_pension_id" id="tipo_pension_id" name="tipo_pension_id"
									autocomplete="off" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">
										Selecciones un tipo de pension
									</option>
									<option v-for="tipoPension in tiposPension" :key="tipoPension.id"
										:value="tipoPension.id" :bind:select="tipoPension.id ==
											form.tipo_pension_id
											">
										{{ tipoPension.description }}
									</option>
								</select>
							</div>
						</div>
					</div>
				</div> -->	

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Datos de Salud
								</h3>
							</div>
							<div class="flex-shrink-0">
								<button type="button" @click="card_salud=!card_salud"
									class=" bg-transparent relative inline-flex items-center px-2 py-2 shadow-sm text-xs font-medium rounded-md border-red-500"
									:class="card_salud
										? 'bg-transparent text-red-900 hover:bg-red-300 hover:text-white border-red-500'
										: 'bg-transparent text-green-900 hover:bg-green-300 hover:text-white border-green-500'
										">
									<ArrowsPointingInIcon class="h-6 w-6 mr-2"></ArrowsPointingInIcon>{{card_salud ? 'Ocultar' : 'Agregar'}}
								</button>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6" v-show="card_salud">
							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
								<label for="programa_social_id" class="block text-sm font-medium text-gray-700">Apto Fisico</label>
									<Switch v-model="form.apto_fisico"
											@click="form.apto_fisico = !form.apto_fisico"
											:class="form.apto_fisico ? 'bg-blue-600' : 'bg-gray-200'"
											class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
											<span :class="form.apto_fisico ? 'translate-x-6' : 'translate-x-1'"
												class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
									</Switch>   
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
								<label for="fecha_apto_fisico" class="block text-sm font-medium text-gray-700">Fecha Apto Fisico</label>
								<Datepicker
									class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form.fecha_apto_fisico"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									:enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
								</Datepicker>
								
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
								<label for="programa_social_id" class="block text-sm font-medium text-gray-700">Electrocardiograma</label>
									<Switch v-model="form.electro"
											@click="form.electro = !form.electro"
											:class="form.electro ? 'bg-blue-600' : 'bg-gray-200'"
											class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
											<span :class="form.electro ? 'translate-x-6' : 'translate-x-1'"
												class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
									</Switch>   
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
								<label for="fecha_electro" class="block text-sm font-medium text-gray-700">Fecha Electrocardiograma</label>
								<Datepicker
									class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form.fecha_electro"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									:enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
								</Datepicker>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
								<label for="programa_social_id" class="block text-sm font-medium text-gray-700">CUD</label>
									<Switch v-model="form.cud"
											@click="form.cud = !form.cud"
											:class="form.cud ? 'bg-blue-600' : 'bg-gray-200'"
											class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
											<span :class="form.cud ? 'translate-x-6' : 'translate-x-1'"
												class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
									</Switch>   
							</div>


							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
								<label for="programa_social_id" class="block text-sm font-medium text-gray-700">Cud Presentado</label>
									<Switch v-model="form.cud_presentado"
											@click="form.cud_presentado = !form.cud_presentado"
											:class="form.cud_presentado ? 'bg-blue-600' : 'bg-gray-200'"
											class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
											<span :class="form.cud_presentado ? 'translate-x-6' : 'translate-x-1'"
												class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
									</Switch>   
							</div>
						</div>
					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Autorizaciones
								</h3>
							</div>
							<div class="flex-shrink-0">
								<button type="button" @click="card_autorizacion=!card_autorizacion"
									class=" bg-transparent relative inline-flex items-center px-2 py-2 shadow-sm text-xs font-medium rounded-md border-red-500"
									:class="card_autorizacion
										? 'bg-transparent text-red-900 hover:bg-red-300 hover:text-white border-red-500'
										: 'bg-transparent text-green-900 hover:bg-green-300 hover:text-white border-green-500'
										">
									<ArrowsPointingInIcon class="h-6 w-6 mr-2"></ArrowsPointingInIcon>{{card_autorizacion ? 'Ocultar' : 'Agregar'}}
								</button>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6" v-show="card_autorizacion">
							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
								<label for="programa_social_id" class="block text-sm font-medium text-gray-700">Apoyo Escolar</label>
									<Switch v-model="form.apoyo_escolar"
											@click="form.apoyo_escolar = !form.apoyo_escolar"
											:class="form.apoyo_escolar ? 'bg-blue-600' : 'bg-gray-200'"
											class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
											<span :class="form.apoyo_escolar ? 'translate-x-6' : 'translate-x-1'"
												class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
									</Switch>   
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
								<label for="programa_social_id" class="block text-sm font-medium text-gray-700">Act. por Area Empleo</label>
									<Switch v-model="form.act_empleo"
											@click="form.act_empleo = !form.act_empleo"
											:class="form.act_empleo ? 'bg-blue-600' : 'bg-gray-200'"
											class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
											<span :class="form.act_empleo ? 'translate-x-6' : 'translate-x-1'"
												class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
									</Switch>   
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
								<label for="programa_social_id" class="block text-sm font-medium text-gray-700">Aut. Firmada</label>
									<Switch v-model="form.aut_firmada"
											@click="form.aut_firmada = !form.aut_firmada"
											:class="form.aut_firmada ? 'bg-blue-600' : 'bg-gray-200'"
											class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
											<span :class="form.aut_firmada ? 'translate-x-6' : 'translate-x-1'"
												class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
									</Switch>   
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
								<label for="programa_social_id" class="block text-sm font-medium text-gray-700">Aut. Retirarse</label>
									<Switch v-model="form.aut_retirarse"
											@click="form.aut_retirarse = !form.aut_retirarse"
											:class="form.aut_retirarse ? 'bg-blue-600' : 'bg-gray-200'"
											class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
											<span :class="form.aut_retirarse ? 'translate-x-6' : 'translate-x-1'"
												class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
									</Switch>   
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
								<label for="programa_social_id" class="block text-sm font-medium text-gray-700">Aut. Uso Imagen</label>
									<Switch v-model="form.aut_imagen"
											@click="form.aut_imagen = !form.aut_imagen"
											:class="form.aut_imagen ? 'bg-blue-600' : 'bg-gray-200'"
											class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
											<span :class="form.aut_imagen ? 'translate-x-6' : 'translate-x-1'"
												class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
									</Switch>   
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
								<label for="programa_social_id" class="block text-sm font-medium text-gray-700">Cert. escolar</label>
									<Switch v-model="form.cert_escolar"
											@click="form.cert_escolar = !form.cert_escolar"
											:class="form.cert_escolar ? 'bg-blue-600' : 'bg-gray-200'"
											class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
											<span :class="form.cert_escolar ? 'translate-x-6' : 'translate-x-1'"
												class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
									</Switch>   
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Inscripcion Comedor</label>
								<select v-model="form.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
									autocomplete="off"
									:class="v$.form.tipo_documento_id.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un comedor
									</option>
									<option v-for="comedor in comedores" :key="comedor.id" :value="comedor.id">{{
										comedor.description
									}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="actividad_cbj" class="block text-sm font-medium text-gray-700">Actividad CBJ</label>
								<div class="flex items-center mb-2">
									<select v-model="actividadSelect" id="actividad_cbj" name="actividad_cbj"
										autocomplete="off"
										:disabled="input_disable"
										class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
										<option value="" disabled>
											Seleccione un tipo de documento
										</option>
										<option v-for="actividad in actividadesCbj" :key="actividad.id"
											:value="actividad ">
											{{ actividad.description }}
										</option>
									</select>
									<a class="ml-2 items-center" @click="addActividad"><PlusCircleIcon class="h-8 w-8 text-green-700"></PlusCircleIcon></a>
								</div>
								<span  v-for="(act, index) in this.actividadesSelected" :key="index" 
									class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-700/10 mr-2 mt-2">
									{{act.description}} <TrashIcon @click="removeActividad(act)" class="h-5 w-5 text-red-700 ml-2"></TrashIcon>
								</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="aconpanamiento_id" class="block text-sm font-medium text-gray-700">Acompañamiento CBJ</label>
								<div class="flex items-center mb-2">
									<select v-model="acompanamientoSelect" id="aconpanamiento_id" name="aconpanamiento_id"
										autocomplete="off"
										
										:disabled="input_disable"
										class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
										<option value="" disabled>
											Seleccione un tipo de documento
										</option>
										<option v-for="acompanamiento in acompanamientosCbj" :key="acompanamiento.id"
											:value="acompanamiento">
											{{ acompanamiento.description }}
										</option>
									</select>
									<a class="ml-2 items-center" @click="addAcompanamiento"><PlusCircleIcon class="h-8 w-8 text-green-700"></PlusCircleIcon></a>
								</div>
								<span  v-for="(act, index) in this.acompanamientosSelected" :key="index" 
									class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-700/10 mr-2 mt-2">
									{{act.description}} <TrashIcon @click="removeAcompanamiento(act)" class="h-5 w-5 text-red-700 ml-2"></TrashIcon>
								</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="taller_id" class="block text-sm font-medium text-gray-700">Talleres</label>
								<div class="flex items-center mb-2">
									<select v-model="tallerSelect" id="taller_id" name="taller_id"
										autocomplete="off"
										
										:disabled="input_disable"
										class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
										<option value="" disabled>
											Seleccione un taller
										</option>
										<option value="Ajedrez">Ajedrez</option>
										<option value="Arte">Arte</option>
										<option value="Huerta">Huerta</option>
										<option value="Ensamble_musical">Ensamble musical</option>
										<option value="Indumentaria">Indumentaria</option>
										<option value="Futbol">Futbol</option>
										<option value="Percusion">Percusion</option>
										<option value="Tecnologia">Tecnologia</option>
										<option value="Artesanias">Artesanias</option>
										<option value="Carpinteria">Carpinteria</option>
										<option value="Manicuria">Manicuria</option>
										<option value="Programacion">Programacion</option>
										<option value="Panaderia">Panaderia</option>
										<option value="Coreografia">Coreografia</option>
										<option value="Cocina">Cocina</option>
										<option value="Barberia">Barberia</option>
										<option value="Karate">Karate</option>
										<option value="Ping_Pong">Ping Pong</option>
										<option value="Musica">Musica</option>
										<option value="Reparacion_de_PC">Reparacion de PC</option>
										<option value="Otro">Otro</option>
									</select>
									<a class="ml-2 items-center" @click="addTaller"><PlusCircleIcon class="h-8 w-8 text-green-700"></PlusCircleIcon></a>
								</div>
								<span  v-for="(act, index) in this.talleresSelected" :key="index" 
									class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-700/10 mr-2 mt-2">
									{{act}} <TrashIcon @click="removeTaller(act)" class="h-5 w-5 text-red-700 ml-2"></TrashIcon>
								</span>
							</div>
						</div>
					</div>
				</div>

				<!-- <div class="shadow sm:rounded-md sm:overflow-hidden mt-6" v-show="!input_disable">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Archivos Adjuntos
								</h3>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-8">
								<label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
								<div class="flex">
									<input v-model="form.description_file" type="text" name="descripcion" id="descripcion"
										autocomplete="off"
										class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-1/2 shadow-sm sm:text-sm border-gray-300 rounded-md mr-6" />
									<input @change="handleFileChange" accept=".jpg, .jpeg, .png, .gif, .pdf, .doc, .docx, .xls, .xlsx" type="file" name="file" id="file" ref="inputfile"
										autocomplete="off"
										class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-1/2 rounded-md" />
										<div class="flex-shrink-0">
											<button @click="addFile()" type="button"
											class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">
											Agregar Archivo
										</button>
									</div>
								</div>
								<p v-show="this.fileInvalid" class="mt-2 text-red-500 text-xs"> - Por favor, seleccione un archivo de imagen, office o PDF.</p>
							</div>
							<div class="col-span-12 sm:col-span-12">
								<table class="min-w-full divide-y divide-gray-200 w-full col-span-6 sm:col-span-12">
									<thead class="bg-gray-50">
										<tr>
											<th scope="col"
												class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/6">
												Descripcion
											</th>
	
											<th scope="col"
												class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/6">
												Accion
											</th>
										</tr>
									</thead>
									<tbody class="bg-white divide-y divide-gray-200">
										<tr v-for="(file, index) in files" :key="index">
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
												{{ file.description }}
											</td>
											<td class="px-6 py-4 text-center text-sm font-medium">
												
												<button type="button"
													class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-red-200 text-red-900 hover:bg-red-600 hover:text-white"
													@click="deleteFile(index)">
													Eliminar
												</button>
												<button type="button"
													class="ml-4 relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
													@click="viewFile(file.file)">
													Ver/Descargar
												</button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div> -->

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Datos de Educación
								</h3>
							</div>
							<div class="flex-shrink-0">
								<button type="button" @click="card_educacion=!card_educacion"
									class=" bg-transparent relative inline-flex items-center px-2 py-2 shadow-sm text-xs font-medium rounded-md border-red-500"
									:class="card_educacion
										? 'bg-transparent text-red-900 hover:bg-red-300 hover:text-white border-red-500'
										: 'bg-transparent text-green-900 hover:bg-green-300 hover:text-white border-green-500'
										">
									<ArrowsPointingInIcon class="h-6 w-6 mr-2"></ArrowsPointingInIcon>{{card_educacion ? 'Ocultar' : 'Agregar'}}
								</button>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6" v-show="card_educacion">

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Situación Educativa</label>
								<select v-model="form.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
									autocomplete="off"
									:class="v$.form.tipo_documento_id.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un comedor
									</option>
									<option value="PRIMARIA_INCOMPLETA">PRIMARIA INCOMPLETA</option>
									<option value="PRIMARIA_COMPLETA">PRIMARIA COMPLETA</option>
									<option value="SECUNDARIA_INCOMPLETA">SECUNDARIA INCOMPLETA</option>
									<option value="SECUNDARIA_COMPLETA">SECUNDARIA COMPLETA</option>
									<option value="TERCIARIO_INCOMPLETO">TERCIARIO INCOMPLETO</option>
									<option value="TERCIARIO_COMPLETO">TERCIARIO COMPLETO</option>
									<option value="UNIVERSITARIO_INCOMPLETO">UNIVERSITARIO INCOMPLETO</option>
									<option value="UNIVERSITARIO_COMPLETO">UNIVERSITARIO COMPLETO</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Institucion Educativa</label>
								<select v-model="form.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
									autocomplete="off"
									:class="v$.form.tipo_documento_id.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione una institucion
									</option>
									<option value="ESCUELA_ALMAFUERTE">ESCUELA ALMAFUERTE</option>
									<option value="ESCUELA_AMEGHINO">ESCUELA AMEGHINO</option>
									<option value="ESCUELA_ESPECIAL_N_502">ESCUELA ESPECIAL N 502</option>
									<option value="ESCUELA_ESPECIAL_N_504">ESCUELA ESPECIAL N 504</option>
									<option value="ESCUELA_GRANADEROS">ESCUELA GRANADEROS</option>
									<option value="ESCUELA_MANUEL_DORREGO">ESCUELA MANUEL DORREGO</option>
									<option value="ESCUELA_N_1">ESCUELA N 1</option>
									<option value="ESCUELA_N_2">ESCUELA N 2</option>
									<option value="ESCUELA_N_4">ESCUELA N 4</option>
									<option value="ESCUELA_N_6">ESCUELA N 6</option>
									<option value="ESCUELA_N_7">ESCUELA N 7</option>
									<option value="ESCUELA_N_8">ESCUELA N 8</option>
									<option value="ESCUELA_N_9">ESCUELA N 9</option>
									<option value="ESCUELA_N_10">ESCUELA N 10</option>
									<option value="ESCUELA_N_11">ESCUELA N 11</option>
									<option value="ESCUELA_N_12">ESCUELA N 12</option>
									<option value="ESCUELA_N_13">ESCUELA N 13</option>
									<option value="ESCUELA_N_14">ESCUELA N 14</option>
									<option value="ESCUELA_N_15">ESCUELA N 15</option>
									<option value="ESCUELA_N_16">ESCUELA N 16</option>
									<option value="ESCUELA_N_17">ESCUELA N 17</option>
									<option value="ESCUELA_N_18">ESCUELA N 18</option>
									<option value="ESCUELA_N_19">ESCUELA N 19</option>
									<option value="ESCUELA_N_20">ESCUELA N 20</option>
									<option value="ESCUELA_N_21">ESCUELA N 21</option>
									<option value="ESCUELA_N_22">ESCUELA N 22</option>
									<option value="ESCUELA_N_23">ESCUELA N 23</option>
									<option value="ESCUELA_N_24">ESCUELA N 24</option>
									<option value="ESCUELA_N_32">ESCUELA N 32</option>
									<option value="ESCUELA_N_36">ESCUELA N 36</option>
									<option value="ESCUELA_N_39">ESCUELA N 39</option>
									<option value="ESCUELA_N_48">ESCUELA N 48</option>
									<option value="ESCUELA_N_62">ESCUELA N 62</option>
									<option value="ESCUELA_GUEMES">ESCUELA GUEMES</option>
									<option value="INSTITUTO_CRISTIANO_VTE_LOPEZ">INSTITUTO CRISTIANO VTE LOPEZ</option>
									<option value="INSTITUTO_DULCISIMO_NOMBRE_DE_JESUS">INSTITUTO DULCISIMO NOMBRE DE JESUS</option>
									<option value="INSTITUTO_FATIMA">INSTITUTO FATIMA</option>
									<option value="INSTITUTO_MAIPU">INSTITUTO MAIPU</option>
									<option value="INSTITUTO_MARIA_SANTISIMA_DE_LA_LUZ">INSTITUTO MARIA SANTISIMA DE LA LUZ</option>
									<option value="INSTITUTO_MI_MAÑANA">INSTITUTO MI MAÑANA</option>
									<option value="INSTITUTO_NUESTRA_SEÑORA_DE_LA_MERCED">INSTITUTO NUESTRA SEÑORA DE LA MERCED</option>
									<option value="INSTITUTO_PASTEUR">INSTITUTO PASTEUR</option>
									<option value="INSTITUTO_MARIA_AUXILIADORA">INSTITUTO MARIA AUXILIADORA</option>
									<option value="COLEGIO_SAN_LADISLAO">COLEGIO SAN LADISLAO</option>
									<option value="COLEGIO_SANTA_MAGDALENA">COLEGIO SANTA MAGDALENA</option>
									<option value="COLEGIO_VIRGEN_DEL_CARMEN">COLEGIO VIRGEN DEL CARMEN</option>
									<option value="PRIMARIA_EMMA_PEREZ_FERREIRA">PRIMARIA EMMA PEREZ FERREIRA</option>
									<option value="OTRO">OTRO</option>

								</select>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Curso</label>
								<select v-model="form.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
									autocomplete="off"
									:class="v$.form.tipo_documento_id.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un Curso
									</option>
									<option value="1">1°</option>
									<option value="2">2°</option>
									<option value="3">3°</option>
									<option value="4">4°</option>
									<option value="5">5°</option>
									<option value="6">6°</option>
									<option value="7">7°</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="turno_id" class="block text-sm font-medium text-gray-700">Turno</label>
								<select v-model="form.turno_id" id="turno_id" name="turno_id"
									autocomplete="off"
									:class="v$.form.tipo_documento_id.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un comedor
									</option>
									<option value="manana">Mañana</option>
									<option value="tarde">Tarde</option>
									<option value="vespertino">Vespertino</option>
									<option value="doble_turno">Doble Turno</option>
								</select>
							</div>
							
							<div class="col-span-12 xl:col-span-6">
								<label for="observacion" class="block text-sm font-medium text-gray-700">Observaciones
								</label>
								<div class="mt-1">
									<textarea v-model="form.observacion_educacion" id="observacion" name="observacion" rows="1"
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"
										:class="v$.tramites.$error ? 'border-red-500' : ''" />
								</div>
								<p class="mt-2 text-sm text-gray-500">
									Ingrese información adicional del tramite.
								</p>
							</div>

						</div>
					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Datos de Adulto Responsable
								</h3>
							</div>
							<div class="flex-shrink-0">
								<button type="button" @click="card_adulto=!card_adulto"
									class=" bg-transparent relative inline-flex items-center px-2 py-2 shadow-sm text-xs font-medium rounded-md border-red-500"
									:class="card_adulto
										? 'bg-transparent text-red-900 hover:bg-red-300 hover:text-white border-red-500'
										: 'bg-transparent text-green-900 hover:bg-green-300 hover:text-white border-green-500'
										">
									<ArrowsPointingInIcon class="h-6 w-6 mr-2"></ArrowsPointingInIcon>{{card_adulto ? 'Ocultar' : 'Agregar'}}
								</button>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6" v-show="card_adulto">
							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Tipo de
									Documento</label>
								<select v-model="form.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
									autocomplete="off"
									:class="v$.form.tipo_documento_id.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
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
								<span v-if="v$.form.tipo_documento_id.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de
									Documento</label>
								<div class="relative">
									<input type="text" v-model="form.num_documento_adulto" @keyup.enter="getPerson()" :class="v$.form.num_documento.$error ? 'border-red-500' : ''"
										class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
									<a @click="getPerson()" 
										class="absolute inset-y-0 right-0 px-4 py-2 bg-green-200 text-white text-xs rounded-r-md hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-600  shadow-sm text-xs font-medium flex items-center  text-green-900 hover:text-white">
										Verificar
									</a>
								</div>
								<span v-if="v$.form.num_documento.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>

							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
								<input v-model="form.name_adulto" type="text" name="name" id="name" autocomplete="name"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.name.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable" />
								<span v-if="v$.form.name.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
								<input v-model="form.lastname_adulto" type="text" name="lastname" id="lastname" autocomplete="name"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.lastname.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable" />
								<span v-if="v$.form.lastname.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="fecha_nac" class="block text-sm font-medium text-gray-700">Fecha de
									Nacimiento</label>
								<Datepicker
									class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:style="v$.form.fecha_nac.$error ? datepickerStyle : ''" v-model="form.fecha_nac_adulto"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									:enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
								</Datepicker>
								<span v-if="v$.form.fecha_nac.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Situación Empleo</label>
								<select v-model="form.tipo_documento_id_adulto" id="tipo_documento_id" name="tipo_documento_id"
									autocomplete="off"
									:class="v$.form.tipo_documento_id.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un comedor
									</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
								<label for="programa_social_id" class="block text-sm font-medium text-gray-700">Busca Trabajo</label>
									<Switch v-model="form.busca_trabajo_adulto"
											@click="form.busca_trabajo = !form.busca_trabajo"
											:class="form.busca_trabajo ? 'bg-blue-600' : 'bg-gray-200'"
											class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
											<span :class="form.busca_trabajo ? 'translate-x-6' : 'translate-x-1'"
												class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
									</Switch>   
							</div>
							
							<div class="col-span-12 xl:col-span-6">
								<label for="observacion" class="block text-sm font-medium text-gray-700">Observaciones
								</label>
								<div class="mt-1">
									<textarea v-model="form.observacion_adulto" id="observacion" name="observacion" rows="1"
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"
										:class="v$.tramites.$error ? 'border-red-500' : ''" />
								</div>
								<p class="mt-2 text-sm text-gray-500">
									Ingrese información adicional del tramite.
								</p>
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
			:disabled="btnGuardar || input_disable">
			Guardar
			</button>
		</div>
	</main>
</template>

<script>
import { ref } from "vue";
import { useVuelidate } from '@vuelidate/core'
import { required, helpers, minLength } from '@vuelidate/validators'

import { ArrowLeftCircleIcon, ArrowsPointingInIcon ,PlusCircleIcon, TrashIcon} from "@heroicons/vue/24/outline";
import GoogleMap from "@/Layouts/Components/GoogleMap.vue";
import VueGoogleAutocomplete from "vue-google-autocomplete";
import FormBeneficiario from "@/Layouts/Components/Tramites/FormBeneficiario.vue";
import Toast from "@/Layouts/Components/Toast.vue";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import {
	Listbox,
	ListboxButton,
	ListboxOptions,
	ListboxOption,
	Switch
} from "@headlessui/vue";
import store from '@/store.js'

const people = [
	{ id: 1, name: "Durward Reynolds", unavailable: false },
	{ id: 2, name: "Kenton Towne", unavailable: false },
	{ id: 3, name: "Therese Wunsch", unavailable: false },
	{ id: 4, name: "Benedict Kessler", unavailable: true },
	{ id: 5, name: "Katelyn Rohan", unavailable: false },
];

export default {
	props: {
		paises: Object,
		barrios: Object,
		localidades: Object,
		canalesAtencion: Object,
		coberturasMedica: Object,
		estadosEducativo: Object,
		nivelesEducativo: Object,
		tiposDocumento: Object,
		tiposOcupacion: Object,
		tiposPension: Object,
		tiposVivienda: Object,
		situacionesConyugal: Object,
		rolesTramite: Object,
		tiposTramite: Object,
		programasSocial: Object,
		sedes: Object,
		comedores: Object,
		actividadesCbj: Object,
		acompanamientosCbj: Object
	},
	components: {
		ArrowLeftCircleIcon,
		GoogleMap,
		VueGoogleAutocomplete,
		Toast,
		Datepicker,
		FormBeneficiario,
		Listbox,
		ListboxButton,
		ListboxOptions,
		ListboxOption,
		people,
		required,
		useVuelidate,
		helpers,
		minLength,
		store,
		Switch,
		ArrowsPointingInIcon,
		PlusCircleIcon,
		TrashIcon
	},
	data() {
		return {
			form: {},
			form_temp: {},
			form_google: "",
			form_beneficiario: {},
			address: "",
			/* BENEFICIARIO */
			textBtnBenef: "Agregar Beneficiario",
			showBenef: false,
			beneficiario_control: false,
			/* MAPA */
			textMap: "Ver Mapa",
			showMap: false,
			/* MENSAJERIA */
			toastMessage: "",
			labelType: "info",
			message: "",
			showToast: false,
			/* CARGA MASIVA DE FILE */
			file: "",
			file_tmp: {},
			files: [],
			selectedFile: null,
			tramites: [],
			selectPlanes: [],
			btnGuardar: false,
			datepickerStyle: {
				color: 'red',
				border: '1px solid red',
			},
			bg_disable: 'bg-gray-100',
			input_disable: false,
			fileView: '',
			openModal: false,
			fileInvalid: false,
			card_direccion:false,
			card_salud:false,
			card_autorizacion:false,
			card_educacion:false,
			card_adulto:false,

			// Multiselect
			actividadSelect: '',
            actividadesSelected: [],
			acompanamientoSelect: '',
            acompanamientosSelected: [],
			tallerSelect: '',
            talleresSelected: []
		};
	},
	validations() {
		return {
			tramites: { required: helpers.withMessage('Debe seleccionar minimo un tramite', required) },
			form: {
				fecha: { required: helpers.withMessage('El campo Fecha es Obligatorio', required) },
				canal_atencion_id: { required: helpers.withMessage('El campo Canal de Atencion es Obligatorio', required) },
				tipo_documento_id: { required: helpers.withMessage('El campo Tipo de Documento es Obligatorio', required) },
				num_documento: { required: helpers.withMessage('El campo N° de documento es Obligatorio', required) }, // Matches this.contact.email
				name: { required: helpers.withMessage('El campo Nombre es Obligatorio', required) },
				lastname: { required: helpers.withMessage('El campo Apellido es Obligatorio', required) },
				fecha_nac: { required: helpers.withMessage('El campo Fecha de Nacimiento es Obligatorio', required) },
			},
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
		viewFile(data) {
		},
		clearMessage() {
			this.toastMessage = "";
		},
		async submit() {
		},
		async getPerson() {
		},
		removeNullValues(data) {
		},
		addBeneficiario() {
		},

		/* ***********************
		 ** * MANEJO DE GOOGLE MAPS
		 */
		getAddressData: function (addressData, placeResultData, id) {
		},
		coord_google($coord) {
		},

		/*
		 ** * FIN MANEJO DE GOOGLE MAPS
		 ******************************
		 */

		/* ********************
		 ** * MANEJO DE ARCHIVOS
		 */
		handleFileChange(event) {
		},
		addFile() {
		},
		deleteFile(index) {
		},

		/*
		 ** * FIN MANEJO DE ARCHIVOS
		 ***************************
		 */

		/* ***************************
		 ** * MANEJO DE TIPO DE TRAMITE
		 */
		addTramite() {
		},
		deleteTramite(index) {
		},
		/*
		 ** * FIN MANEJO DE TIPO DE TRAMITE
		 **********************************
		 */

		beneficiario(data) {
			this.form_beneficiario = data;
		},
		addActividad(){
			console.log(this.actividadSelect)
            let existe_actividad = this.actividadesSelected.find( label => label.id === this.actividadSelect.id );
            if(this.labelSelect === ''){
                this.labelType = "info";
                this.toastMessage = "Debe ingresar un valor de Actividad";
            }else{
                if(!existe_actividad)
                {
                    this.actividadesSelected.push(this.actividadSelect);
                }else{
                    this.labelType = "info";
                    this.toastMessage = "La Actividad ya se encuentra asignada";
                }
            }
            this.actividadSelect = '';
        },
		removeActividad(actividad){
            const index = this.actividadesSelected.findIndex(item => item.id === actividad.id);
            this.actividadesSelected.splice(index, 1);
            this.labelType = "success";
            this.toastMessage = "Se ha eliminado correctamente la etiqueta";
        },

		addAcompanamiento(){
            let existe_actividad = this.acompanamientosSelected.find( label => label.id === this.acompanamientoSelect.id );
            if(this.labelSelect === ''){
                this.labelType = "info";
                this.toastMessage = "Debe ingresar un valor de Acompañamiento";
            }else{
                if(!existe_actividad)
                {
                    this.acompanamientosSelected.push(this.acompanamientoSelect);
                }else{
                    this.labelType = "info";
                    this.toastMessage = "El acompañamiento ya se encuentra asignada";
                }
            }
            this.acompanamientoSelect = '';
        },
		removeAcompanamiento(actividad){
            const index = this.acompanamientosSelected.findIndex(item => item.id === actividad.id);
            this.acompanamientosSelected.splice(index, 1);
            this.labelType = "success";
            this.toastMessage = "Se ha eliminado correctamente el acompañamiento";
        },
		removeActividad(actividad){
            const index = this.actividadesSelected.findIndex(item => item.id === actividad.id);
            this.actividadesSelected.splice(index, 1);
            this.labelType = "success";
            this.toastMessage = "Se ha eliminado correctamente la etiqueta";
        },

		addTaller(){
            let existe_actividad = this.talleresSelected.find( label => label === this.tallerSelect );
            if(this.labelSelect === ''){
                this.labelType = "info";
                this.toastMessage = "Debe ingresar un valor de Taller";
            }else{
                if(!existe_actividad)
                {
                    this.talleresSelected.push(this.tallerSelect);
                }else{
                    this.labelType = "info";
                    this.toastMessage = "El taller ya se encuentra asignada";
                }
            }
            this.tallerSelect = '';
        },
		removeTaller(actividad){
            const index = this.talleresSelected.findIndex(item => item === actividad);
            this.talleresSelected.splice(index, 1);
            this.labelType = "success";
            this.toastMessage = "Se ha eliminado correctamente el taller";
        },
	},
	computed: {
	},

	mounted() {
		this.form.tipo_tramite_id = "";
		this.form.observacion = "";
	},
};
</script>