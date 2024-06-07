<template>
	<main class="flex-1 bg-gray-50 pb-40">
		<!-- Page title & actions -->
		<div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
			<div class="flex-1 min-w-0 flex items-center">
				<a class="btn-blue" :href="route('inscripcionCBJ')">
					<ArrowLeftCircleIcon class="w-5 h-5 text-purple-700 mr-2" />
				</a>
				<h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
					Nueva Inscripción CBJ
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
						<a href="#" @click="this.tabs = 2" :class="this.tabs === 2 ? 'border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'" class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group">
							Dirección
						</a>
					</li>
					<li class="me-2">
						<a href="#" @click="this.tabs = 3" :class="this.tabs === 3 ? 'border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'" class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group">
							Salud
						</a>
					</li>
					<li class="me-2">
						<a href="#" @click="this.tabs = 4" :class="this.tabs === 4 ? 'border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'" class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group">
							Autorizaciones
						</a>
					</li>
					<li class="me-2">
						<a href="#" @click="this.tabs = 5" :class="this.tabs === 5 ? 'border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'" class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group">
							Educación
						</a>
					</li>
					<li class="me-2">
						<a href="#" @click="this.tabs = 6" :class="this.tabs === 6 ? 'border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'" class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group">
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
								<select v-model="form.inscripcion.canal_atencion_id" id="canal_atencion" name="canal_atencion"
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
								<label for="anio_inicio" class="block text-sm font-medium text-gray-700">Año de
									inicio CBJ</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form.inscripcion.anio_inicio" auto-apply year-picker
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
				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6" v-show="this.tabs === 2">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Datos de Dirección
								</h3>
							</div>
							<div class="flex-shrink-0">
								
							</div>
						</div>

						<!-- <div class="grid grid-cols-12 gap-6">
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
						</div> -->
					</div>
				</div>
				
				<!-- SALUD -->
				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6" v-show="this.tabs === 3">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Datos de Salud
								</h3>
							</div>
							<div class="flex-shrink-0">
								
							</div>
						</div>

						<!-- <div class="grid grid-cols-12 gap-6" >
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
						</div> -->
					</div>
				</div>
				
				<!-- AUTORIZACIONES -->
				<TabAutorizaciones 	v-if="this.tabs === 4" 
									:form="form.autorizaciones" 
									:input_disable="input_disable"
									:comedores="comedores"
									@submit="handleAutorizaciones">
				</TabAutorizaciones>

				<!-- Educacion -->
				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6" v-show="this.tabs === 5">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Datos de Educación
								</h3>
							</div>
							<div class="flex-shrink-0">
								
							</div>
						</div>

						<!-- <div class="grid grid-cols-12 gap-6">

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
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"/>
								</div>
								<p class="mt-2 text-sm text-gray-500">
									Ingrese información adicional del tramite.
								</p>
							</div>

						</div> -->
					</div>
				</div>

				<!-- ADULTO RESPONSABLE -->
				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6" v-show="this.tabs === 6">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Datos de Adulto Responsable
								</h3>
							</div>
							<div class="flex-shrink-0">
							</div>
						</div>

						<!-- <div class="grid grid-cols-12 gap-6">
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
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"/>
								</div>
								<p class="mt-2 text-sm text-gray-500">
									Ingrese información adicional del tramite.
								</p>
							</div>

						</div> -->
					</div>
				</div>

			</form>
		</div>
		
		<!-- <div class="px-4 mt-6 sm:px-6 lg:px-8 flex justify-end w-full">
			<button
			class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"
			:class="btnGuardar ? 'bg-gray-600 hover:bg-gray-700' : 'bg-green-600 hover:bg-green-700'" @click="submit"
			:disabled="btnGuardar || input_disable">
			Guardar
			</button>
		</div> -->
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
		Toast,
		Datepicker,
		required,
		useVuelidate,
		helpers,
		minLength,
		store,
		Switch,
		ArrowsPointingInIcon,
		PlusCircleIcon,
		TrashIcon,
		// Tabs
		TabAutorizaciones,
	},
	data() {
		return {
			tabs: 1,
			// Datos formulario
			form: {
				person:{},
				contact: {},
				inscripcion: {},
				autorizaciones: {}
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
				}
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
				person: {},
				contact: {},
				inscripcion: {},
				autorizaciones: {}
			}
		},
		async submit() {
			// VALIDACION CAMPOS OBLIGATORIOS
			const result = await this.v$.$validate()
			if(!result){
				return
			}

			// RUTA
			//this.btnGuardar = true
			let rt = route("inscripcionCBJ.store");

			// FORMATEO DE FECHAS
			this.form.fecha = this.form.fecha
				? new Date(this.form.fecha).toISOString()
				: null;
			this.form.fecha_nac = this.form.fecha_nac
				? new Date(this.form.fecha_nac).toISOString()
				: null;

			// AXIOS STORE
			try {
				const response = await axios.post(rt, this.form);
				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
					this.btnGuardar = false
					setTimeout(() => {
						window.location.href = "/inscripcion-cbj";
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
			const get = `${route('persons.getPersonDni', this.form.person.num_documento)}`
			const response = await fetch(get, { method: 'GET' })
			let data = await response.json()
			if (!data.data.length == 0) {
				this.labelType = "success";
				this.toastMessage = "El DNI indicado se encuentra registrado";

				data = data.data[0].person
				/// Recuperar datos.
				this.form.person.tipo_documento_id = data.tipo_documento_id
				this.form.person.fecha_nac = data.fecha_nac
				this.form.person.fecha_nac = new Date(this.form.person.fecha_nac + "T00:00:00.000-03:00")
				this.form.person.name = data.name
				this.form.person.lastname = data.lastname
				this.form.contact.email = data.contact[0].email
				this.form.contact.phone = data.contact[0].phone
				this.form = this.removeNullValues(this.form);

			} else {
				this.labelType = "info";
				this.toastMessage = "El DNI indicado no se encuentra registrado";
				this.clearFormData()
			}
			this.input_disable = false;
		},
		removeNullValues(data) {
			return Object.fromEntries(Object.entries(data).filter(([key, value]) => value !== null && value !== undefined));
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
		handleAutorizaciones(data){
			this.form.autorizaciones = data;
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