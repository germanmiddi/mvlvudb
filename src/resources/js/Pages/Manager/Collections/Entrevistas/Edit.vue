<template>
	<main class="flex-1 bg-gray-50 pb-40 relative">
		<!-- Loading Overlay -->
		<div v-if="loading" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
			<div class="bg-white rounded-lg p-6 shadow-xl">
				<div class="flex items-center space-x-4">
					<svg class="animate-spin h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
						<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
						<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
					</svg>
					<span class="text-lg font-medium text-gray-900">Guardando...</span>
				</div>
			</div>
		</div>

		<!-- Page title & actions -->
		<div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
			<div class="flex-1 min-w-0 flex items-center">
				<a class="btn-blue" :href="route('collections.entrevistas.index')">
					<ArrowLeftCircleIcon class="w-5 h-5 text-purple-700 mr-2" />
				</a>
				<h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Editar Entrevista</h1>
			</div>
			<div class="mt-4 flex sm:mt-0 sm:ml-4">
				<button
					class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"
					:class="loading ? 'bg-gray-400 cursor-not-allowed opacity-60' : 'bg-green-600 hover:bg-green-700'"
					@click="submit" :disabled="loading">
					<svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
						<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
						<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
					</svg>
					{{ loading ? 'Guardando...' : 'Guardar' }}
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
			<form action="#" method="POST" enctype="multipart/form-data">

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<h3 class="text-lg leading-6 font-medium text-gray-900">
								Datos de la Entrevista
							</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-4">
								<label for="padron_id" class="block text-sm font-medium text-gray-700">Padrón</label>
								<select v-model="form.padron_id" id="padron_id" name="padron_id"
									autocomplete="off" :class="v$.form.padron_id.$error ? 'border-red-500' : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un padrón
									</option>
									<option v-for="padron in padrones" :key="padron.id"
										:value="padron.id">
										{{ padron.nombre }}
									</option>
								</select>
								<span v-if="v$.form.padron_id.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-4">
								<label for="entrevistador_id"
									class="block text-sm font-medium text-gray-700">Entrevistador</label>
								<select v-model="form.entrevistador_id" id="entrevistador_id" name="entrevistador_id"
									autocomplete="off" :class="v$.form.entrevistador_id.$error ? 'border-red-500' : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un entrevistador
									</option>
									<option v-for="entrevistador in entrevistadores" :key="entrevistador.id"
										:value="entrevistador.id">
										{{ entrevistador.name }}
									</option>
								</select>
								<span v-if="v$.form.entrevistador_id.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-4">
								<label for="sede_id" class="block text-sm font-medium text-gray-700">Sede</label>
								<select v-model="form.sede_id" id="sede_id" name="sede_id"
									:class="v$.form.sede_id.$error ? 'border-red-500' : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione una sede
									</option>
									<option v-for="sede in puntosEntrega" :key="sede.id" :value="sede.id">
										{{ sede.description }}
									</option>
								</select>
								<span v-if="v$.form.sede_id.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>


							<div class="col-span-12 sm:col-span-4">
								<label for="fecha_entrevista" class="block text-sm font-medium text-gray-700">Fecha de
									Entrevista</label>
								<Datepicker
									class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:style="v$.form.fecha_entrevista.$error ? datepickerStyle : ''"
									v-model="form.fecha_entrevista" :enableTimePicker="false"
									:monthChangeOnScroll="false" autoApply :format="format">
								</Datepicker>
								<span v-if="v$.form.fecha_entrevista.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>


						</div>
						<div class="col-span-12 sm:col-span-9">
							<label for="observacion" class="block text-sm font-medium text-gray-700">Observaciones
							</label>
							<div class="mt-1">
								<textarea v-model="form.observaciones" id="observacion" name="observacion" rows="3"
									class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" />
							</div>
							<p class="mt-2 text-sm text-gray-500">
								Ingrese información adicional de la entrevista.
							</p>
						</div>

					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Datos del Titular
								</h3>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Tipo de
									Documento</label>
								<select v-model="form.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
									autocomplete="off"
									:class="v$.form.tipo_documento_id.$error ? 'border-red-500' : bg_disable"
									disabled
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
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
								<input type="text" v-model="form.num_documento" disabled
									:class="v$.form.num_documento.$error ? 'border-red-500' : bg_disable"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
								<span v-if="v$.form.num_documento.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
								<input v-model="form.name" type="text" name="name" id="name"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.name.$error ? 'border-red-500' : ''" />
								<span v-if="v$.form.name.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
								<input v-model="form.lastname" type="text" name="lastname" id="lastname"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.lastname.$error ? 'border-red-500' : ''" />
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
									:enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
								</Datepicker>
								<span v-if="v$.form.fecha_nac.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="email" class="block text-sm font-medium text-gray-700">Mail</label>
								<input v-model="form.email" type="text" name="email" id="email"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
								<input v-model="form.phone" type="text" name="phone" id="phone"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
								<input v-model="form.celular" type="text" name="cellphone" id="cellphone"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>
					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">Dirección</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-3">
								<label for="localidad_id"
									class="block text-sm font-medium text-gray-700">Localidad</label>
								<select v-model="form.localidad_id" id="localidad_id" name="localidad_id"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione una localidad</option>
									<option v-for="localidad in localidades" :key="localidad.id" :value="localidad.id">
										{{
											localidad.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="barrio_id" class="block text-sm font-medium text-gray-700">Barrio</label>
								<select v-model="form.barrio_id" id="barrio_id" name="barrio_id"
									:disabled="barriosComputed.length === 0"
									:class="barriosComputed.length === 0 ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione un barrio</option>
									<option v-for="barrio in barriosComputed" :key="barrio.id" :value="barrio.id">{{
										barrio.description
									}}</option>
								</select>
							</div>

						</div>

						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-4 ">
								<label for="calle" class="block text-sm font-medium text-gray-700">Calle</label>
								<input v-model="form.calle" type="text" name="calle" id="calle"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-2 ">
								<label for="number" class="block text-sm font-medium text-gray-700">Número</label>
								<input v-model="form.number" type="text" name="number" id="number"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-2 ">
								<label for="piso" class="block text-sm font-medium text-gray-700">Piso</label>
								<input v-model="form.piso" type="text" name="piso" id="piso"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-2 ">
								<label for="dpto" class="block text-sm font-medium text-gray-700">Departamento</label>
								<input v-model="form.dpto" type="text" name="dpto" id="dpto"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>


						</div>
						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-6 ">
								<label for="google_address" class="block text-sm font-medium text-gray-700">Dirección
									Google</label>
								<vue-google-autocomplete ref="address" id="map"
									classname="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									placeholder="Ingrese la dirección" v-on:placechanged="getAddressData">
								</vue-google-autocomplete>
							</div>
							<div class="col-span-12 sm:col-span-2 ">
								<label for="latitude" class="block text-sm font-medium text-gray-700">Latitud</label>
								<input v-model="form.latitude" type="text" name="latitude" id="latitude"
									autocomplete="latitude-level2" disabled
									class="bg-gray-100 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-2 ">
								<label for="longitude" class="block text-sm font-medium text-gray-700">Longitud</label>
								<input v-model="form.longitude" type="text" name="longitude" id="longitude"
									autocomplete="longitude-level2" disabled
									class="bg-gray-100 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-2 ">
								<label class="block text-transparent ">Button</label>
								<a @click="this.showMap = !this.showMap"
									class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Ver
									Mapa</a>
							</div>
							<p class="mt-2 text-sm text-gray-500 col-span-12 sm:col-span-12">{{ this.form.google_address
								}}</p>
							<div class="col-span-12 sm:col-span-12 ">
								<GoogleMap v-if="this.showMap" :form_map="form_google"
									@coordenadas_google="coord_google">

								</GoogleMap>
							</div>

						</div>

					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">Situación Social</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-4">
								<label for="pais_id" class="block text-sm font-medium text-gray-700">Pais de
									Origen</label>
								<select v-model="form.pais_id" id="pais_id" name="pais_id" autocomplete="pais_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un pais</option>
									<option v-for="pais in paises" :key="pais.id" :value="pais.id"
										:bind:select="pais.id == form.pais_id">{{
											pais.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-4">
								<label for="situacion_conyugal_id"
									class="block text-sm font-medium text-gray-700">Situación Conyugal</label>
								<select v-model="form.situacion_conyugal_id" id="situacion_conyugal_id"
									name="situacion_conyugal_id" autocomplete="situacion_conyugal_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una situacion conyugal</option>
									<option v-for="situacionConyugal in situacionesConyugal" :key="situacionConyugal.id"
										:value="situacionConyugal.id"
										:bind:select="situacionConyugal.id == form.situacion_conyugal_id">{{
											situacionConyugal.description
										}}</option>
								</select>
							</div>
						</div>

					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">Redes Socio Vinculares</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-4">
								<label for="vive_solo" class="block text-sm font-medium text-gray-700">Vive Solo</label>
								<select v-model="form.vive_solo" id="vive_solo" name="vive_solo"
									autocomplete="vive_solo-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una opción</option>
									<option value="true">Si</option>
									<option value="false">No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-4">
								<label for="cant_convivientes" class="block text-sm font-medium text-gray-700">Cant.
									Convivientes</label>
								<input v-model="form.cant_convivientes" type="number" name="cant_convivientes"
									id="cant_convivientes" autocomplete="cant_convivientes-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-4">
								<label for="vive_solo" class="block text-sm font-medium text-gray-700">Tiene hijos
									menores a cargo:</label>
								<select v-model="form.has_hijos" id="has_hijos" name="has_hijos"
									autocomplete="has_hijos"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una opción</option>
									<option value="true">Si</option>
									<option value="false">No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-4">
								<label for="ambientes" class="block text-sm font-medium text-gray-700">Cuantos hijos
									tiene?</label>
								<input v-model="form.cant_hijos" type="number" name="cant_hijos" id="cant_hijos"
									autocomplete="ambientes-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>
						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-4">
								<label for="ambientes" class="block text-sm font-medium text-gray-700">Cuantas
									personas trabajan en el hogar?</label>
								<input v-model="form.cant_trabajadores" type="number" name="cant_trabajadores"
									id="cant_trabajadores"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-4">
								<label for="vive_solo" class="block text-sm font-medium text-gray-700">¿Algún
									conviviente tiene alguna discapacidad?</label>
								<select v-model="form.has_discapacidad_conviviente" id="has_discapacidad_conviviente"
									name="has_discapacidad_conviviente"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una opción</option>
									<option value="true">Si</option>
									<option value="false">No</option>
								</select>
							</div>


						</div>
					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">Situación Habitacional</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-4">
								<label for="tenencia" class="block text-sm font-medium text-gray-700 ">Tipo
									tenencia</label>

								<div class="space-y-2 mt-1">
									<select v-model="form.tenencia" id="tenencia" name="tenencia"
										autocomplete="tenencia-name"
										class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
										<option disabled value="">Selecciones una tenencia</option>
										<option v-for="tipo in tipoTenencia" :key="tipo.id" :value="tipo.id"
											:bind:select="tipo.id == form.tenencia">{{
												tipo.descripcion
											}}</option>
									</select>
								</div>

							</div>

							<div class="col-span-12 sm:col-span-4">
								<label for="ambientes" class="block text-sm font-medium text-gray-700">Cant.
									ambientes</label>
								<input v-model="form.ambientes" type="number" name="ambientes" id="ambientes"
									autocomplete="ambientes-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>
					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">Estudios</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-4">
								<label for="nivel_educativo_id" class="block text-sm font-medium text-gray-700">Nivel
									educativo en curso</label>
								<select v-model="form.nivel_educativo_id" id="nivel_educativo_id"
									name="nivel_educativo_id" autocomplete="nivel_educativo_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un nivel educativo</option>
									<option v-for="nivelEducativo in nivelesEducativo" :key="nivelEducativo.id"
										:value="nivelEducativo.id"
										:bind:select="nivelEducativo.id == form.nivel_educativo_id">{{
											nivelEducativo.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-4">
								<label for="estado_educativo_id" class="block text-sm font-medium text-gray-700">Nivel
									educativo alcanzado</label>
								<select v-model="form.estado_educativo_id" id="estado_educativo_id"
									name="estado_educativo_id" autocomplete="estado_educativo_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un estado educativo</option>
									<option v-for="estadoEducativo in estadosEducativo" :key="estadoEducativo.id"
										:value="estadoEducativo.id"
										:bind:select="estadoEducativo.id == form.estado_educativo_id">{{
											estadoEducativo.description
										}}</option>
								</select>
							</div>

						</div>

					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">Situación Laboral</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-4">
								<label for="tipo_ocupacion_id"
									class="block text-sm font-medium text-gray-700">Ocupación</label>
								<select v-model="form.tipo_ocupacion_id" id="tipo_ocupacion_id" name="tipo_ocupacion_id"
									autocomplete="tipo_ocupacion_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una ocupacion</option>
									<option v-for="tipoOcupacion in tiposOcupacion" :key="tipoOcupacion.id"
										:value="tipoOcupacion.id"
										:bind:select="tipoOcupacion.id == form.tipo_ocupacion_id">{{
											tipoOcupacion.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-4">
								<label for="tipo_ocupacion_id" class="block text-sm font-medium text-gray-700">Ingresos
								</label>
								<input v-model="form.ingresos_trabajo" id="ingresos_trabajo" name="ingresos_trabajo"
									type="number"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
							</div>

						</div>
						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-4">
								<label for="tipo_pension_id" class="block text-sm font-medium text-gray-700">Percibe
									Jubilación / Pensión</label>
								<select v-model="form.tipo_pension_id" id="tipo_pension_id" name="tipo_pension_id"
									autocomplete="tipo_pension_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un tipo de pension</option>
									<option v-for="tipoPension in tiposPension" :key="tipoPension.id"
										:value="tipoPension.id" :bind:select="tipoPension.id == form.tipo_pension_id">{{
											tipoPension.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-4">
								<label for="tipo_ocupacion_id" class="block text-sm font-medium text-gray-700">Ingresos
								</label>
								<input v-model="form.ingresos_planes" id="ingresos_planes" name="ingresos_planes"
									type="number"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-8">
								<div class="flex items-center justify-between">
									<label for="name" class="block text-sm font-medium text-gray-700">Programa
										Social</label>
									<a class="ml-2 flex items-center space-x-2 bg-blue-500 rounded-md py-1 px-2 hover:bg-blue-800 hover:cursor-pointer"
										@click="addPrograma">
										<PlusIcon class="h-5 w-5 text-white" />
										<span class="text-xs text-white text-bold">AGREGAR</span>
									</a>
								</div>
								<div>
									<select v-model="programaSelect" id="label_id" name="label_id" autocomplete="off"
										class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
										<option disabled value="">
											Seleccione un programa
										</option>
										<option v-for="programa in programasSocial" :key="programa.id"
											:value="programa">
											{{ programa.description }}
										</option>
									</select>
								</div>
							</div>
						</div>

						<div v-if="programasSelected.length > 0" class="grid grid-cols-12 gap-6 mt-4">
							<div class="col-span-12 sm:col-span-8">
								<label for="message" class="block text-base  font-semibold leading-6 text-gray-900">
									Programas seleccionados</label>
								<ul class="w-full bg-gray-50 rounded-sm mt-4">
									<li v-for="(programa, index) in this.programasSelected" :key="index"
										class="w-full inline-flex items-center justify-between px-6 py-4 text-base font-medium text-gray-600 mr-2 border-b border-gray-300">
										{{ programa.description }}
										<TrashIcon @click="removePrograma(programa.id)"
											class="h-5 w-5 text-red-500 ml-2 cursor-pointer hover:text-red-700" />
									</li>

								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">Situación de Salud</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="cobertura_medica_id"
									class="block text-sm font-medium text-gray-700">Cobertura de Salud</label>
								<select v-model="form.cobertura_medica_id" id="cobertura_medica_id"
									name="cobertura_medica_id" autocomplete="cobertura_medica_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un tipo de cobertura medica</option>
									<option v-for="coberturaMedica in coberturasMedica" :key="coberturaMedica.id"
										:value="coberturaMedica.id"
										:bind:select="coberturaMedica.id == form.cobertura_medica_id">{{
											coberturaMedica.description
										}}</option>
								</select>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="vive_solo" class="block text-sm font-medium text-gray-700">Recibe
									tratamiento médico</label>
								<select v-model="form.recibe_tratamiento_medico" id="recibe_tratamiento_medico"
									name="recibe_tratamiento_medico"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una opción</option>
									<option value="true">Si</option>
									<option value="false">No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-4">
								<label for="ambientes" class="block text-sm font-medium text-gray-700">Cual?</label>
								<input v-model="form.tratamiento_medico" type="text" name="tratamiento_medico"
									id="tratamiento_medico"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>
						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="vive_solo" class="block text-sm font-medium text-gray-700">Recibe
									medicación</label>
								<select v-model="form.recibe_medicacion" id="recibe_medicacion" name="recibe_medicacion"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una opción</option>
									<option value="true">Si</option>
									<option value="false">No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-4">
								<label for="ambientes" class="block text-sm font-medium text-gray-700">Cual?</label>
								<input v-model="form.medicacion" type="text" name="medicacion" id="medicacion"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="vive_solo" class="block text-sm font-medium text-gray-700">Tiene
									discapacidad:</label>
								<select v-model="form.has_discapacidad" id="has_discapacidad" name="has_discapacidad"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una opción</option>
									<option value="true">Si</option>
									<option value="false">No</option>
								</select>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-3 ">
								<label for="cud" class="block text-sm font-medium text-gray-700">Nro CUD</label>
								<input v-model="form.cud" type="text" name="cud" id="cud"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-4 ">
								<label for="diagnostico"
									class="block text-sm font-medium text-gray-700">Diagnóstico</label>
								<input v-model="form.diagnostico" type="text" name="diagnostico" id="diagnostico"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>


						</div>

					</div>
				</div>

			</form>
		</div>

		<div class="px-4 mt-6 sm:px-6 lg:px-8 flex justify-end w-full">

			<button
				class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"
				:class="loading ? 'bg-gray-400 cursor-not-allowed opacity-60' : 'bg-green-600 hover:bg-green-700'" @click="submit"
				:disabled="loading">
				<svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
					<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
					<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
				</svg>
				{{ loading ? 'Guardando...' : 'Guardar' }}
			</button>
		</div>

	</main>


</template>

<script>

import { ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, helpers, minLength } from '@vuelidate/validators'
import { ArrowLeftCircleIcon, PlusIcon, TrashIcon } from '@heroicons/vue/24/outline'
import GoogleMap from '@/Layouts/Components/GoogleMap.vue'
import VueGoogleAutocomplete from "vue-google-autocomplete"
import Toast from "@/Layouts/Components/Toast.vue"
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import store from '@/store.js'

export default {

	props: {
		entrevista: Object,
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
		puntosEntrega: Object,
		entrevistadores: Object,
		tipoTenencia: Object,
		padrones: Object
	},
	components: {
		ArrowLeftCircleIcon,
		GoogleMap,
		VueGoogleAutocomplete,
		Toast,
		Datepicker,
		required,
		useVuelidate,
		helpers,
		minLength,
		store,
		PlusIcon,
		TrashIcon
	},
	data() {
		return {
			form: {},
			form_temp: {},
			form_google: "",

			address: "",

			/* MAPA */
			textMap: "Ver Mapa",
			showMap: false,

			/* MENSAJERIA */
			toastMessage: "",
			labelType: "info",
			message: "",
			showToast: false,

			/* CARGA MASIVA DE FILE */
			btnGuardar: false,
			loading: false,
			datepickerStyle: {
				color: 'red',
				border: '1px solid red',
			},
			bg_disable: 'bg-gray-100',
			programaSelect: '',
			programasSelected: [],

			// Sistema de detección de cambios
			originalData: {},
			isLoadingData: true, // Flag para evitar detectar cambios durante la carga inicial
			modified: {
				entrevista: false,
				person: false,
				address: false,
				contact: false,
				aditional: false,
				social: false,
				education: false,
				cud: false,
				programas: false
			},
			changedData: {
				entrevista: {},
				person: {},
				address: {},
				contact: {},
				aditional: {},
				social: {},
				education: {},
				cud: {},
				programas: []
			}

		}
	},
	validations() {
		return {
			form: {
				padron_id: { required: helpers.withMessage('El campo Padrón es Obligatorio', required) },
				entrevistador_id: { required: helpers.withMessage('El campo Entrevistador es Obligatorio', required) },
				sede_id: { required: helpers.withMessage('El campo Sede es Obligatorio', required) },
				fecha_entrevista: { required: helpers.withMessage('El campo Fecha de Entrevista es Obligatorio', required) },

				tipo_documento_id: { required: helpers.withMessage('El campo Tipo de Documento es Obligatorio', required) },
				num_documento: { required: helpers.withMessage('El campo N° de documento es Obligatorio', required) },
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
		}

		return {
			format,
			v$: useVuelidate()
		}
	},
	methods: {
		closeModal() {
			this.openModal = false
		},

		clearMessage() {
			this.toastMessage = "";
		},

		/**
		 * Marca un campo como modificado y guarda el nuevo valor
		 */
		markChanged(table, field, value) {
			// No detectar cambios durante la carga inicial
			if (this.isLoadingData) return;

			const originalValue = this.originalData[`${table}.${field}`];

			// Comparar con el valor original
			if (JSON.stringify(originalValue) !== JSON.stringify(value)) {
				this.modified[table] = true;
				this.changedData[table][field] = value;
				console.log(`Cambio detectado en ${table}.${field}:`, { original: originalValue, nuevo: value });
			} else {
				// Si volvió al valor original, eliminarlo de los cambios
				delete this.changedData[table][field];

				// Si no hay más cambios en esta tabla, desmarcarla
				if (Object.keys(this.changedData[table]).length === 0) {
					this.modified[table] = false;
				}
			}
		},

		/**
		 * Guardar datos originales para comparar posteriormente
		 */
		storeOriginalData() {
			const person = this.entrevista.person;

			// Entrevista
			this.originalData['entrevista.padron_id'] = this.entrevista.padron_id;
			this.originalData['entrevista.entrevistador_id'] = this.entrevista.entrevistador_id;
			this.originalData['entrevista.puntos_entrega_id'] = this.entrevista.puntos_entrega_id;
			this.originalData['entrevista.fecha'] = this.entrevista.fecha;
			this.originalData['entrevista.observaciones'] = this.entrevista.observaciones;
			this.originalData['entrevista.vive_solo'] = this.entrevista.vive_solo;
			this.originalData['entrevista.cant_convivientes'] = this.entrevista.cant_convivientes;
			this.originalData['entrevista.has_hijos'] = this.entrevista.has_hijos;
			this.originalData['entrevista.cant_hijos'] = this.entrevista.cant_hijos;
			this.originalData['entrevista.cant_personas_trabajando'] = this.entrevista.cant_personas_trabajando;
			this.originalData['entrevista.conviviente_discapacidad'] = this.entrevista.conviviente_discapacidad;
			this.originalData['entrevista.tenencia'] = this.entrevista.tenencia;
			this.originalData['entrevista.ambientes'] = this.entrevista.ambientes;
			this.originalData['entrevista.ingresos_trabajo'] = this.entrevista.ingresos_trabajo;
			this.originalData['entrevista.ingresos_planes'] = this.entrevista.ingresos_planes;
			this.originalData['entrevista.recibe_tratamiento_medico'] = this.entrevista.recibe_tratamiento_medico;
			this.originalData['entrevista.tratamiento_medico'] = this.entrevista.tratamiento_medico;
			this.originalData['entrevista.recibe_medicacion'] = this.entrevista.recibe_medicacion;
			this.originalData['entrevista.medicacion'] = this.entrevista.medicacion;
			this.originalData['entrevista.discapacidad'] = this.entrevista.discapacidad;

			// Person
			this.originalData['person.name'] = person.name;
			this.originalData['person.lastname'] = person.lastname;
			this.originalData['person.fecha_nac'] = person.fecha_nac;

			// Contact
			if (person.contact && person.contact[0]) {
				this.originalData['contact.email'] = person.contact[0].email;
				this.originalData['contact.phone'] = person.contact[0].phone;
				this.originalData['contact.celular'] = person.contact[0].celular;
			}

			// Address
			if (person.address && person.address[0]) {
				this.originalData['address.calle'] = person.address[0].calle;
				this.originalData['address.number'] = person.address[0].number;
				this.originalData['address.piso'] = person.address[0].piso;
				this.originalData['address.dpto'] = person.address[0].dpto;
				this.originalData['address.google_address'] = person.address[0].google_address;
				this.originalData['address.localidad_id'] = person.address[0].localidad_id;
				this.originalData['address.barrio_id'] = person.address[0].barrio_id;
				this.originalData['address.latitude'] = person.address[0].latitude;
				this.originalData['address.longitude'] = person.address[0].longitude;
			}

			// Aditional
			if (person.aditional && person.aditional[0]) {
				this.originalData['aditional.situacion_conyugal_id'] = person.aditional[0].situacion_conyugal_id;
				this.originalData['aditional.nacionalidad'] = person.aditional[0].nacionalidad;
			}

			// Social
			if (person.social && person.social[0]) {
				this.originalData['social.tipo_ocupacion_id'] = person.social[0].tipo_ocupacion_id;
				this.originalData['social.cobertura_medica_id'] = person.social[0].cobertura_medica_id;
				this.originalData['social.tipo_pension_id'] = person.social[0].tipo_pension_id;
			}

			// Education
			if (person.education && person.education[0]) {
				this.originalData['education.nivel_educativo_id'] = person.education[0].nivel_educativo_id;
				this.originalData['education.estado_educativo_id'] = person.education[0].estado_educativo_id;
			}

			// CUD
			if (person.cud) {
				this.originalData['cud.codigo'] = person.cud.codigo;
				this.originalData['cud.diagnostico'] = person.cud.diagnostico;
			}

			// Programas
			if (person.programa_social) {
				this.originalData['programas'] = person.programa_social.map(p => p.id);
			}
		},

		async submit() {
			const result = await this.v$.$validate()
			if (!result) {
				return
			}

			this.btnGuardar = true
			this.loading = true

			// Formatear fechas
			if (this.form.fecha_entrevista) {
				this.markChanged('entrevista', 'fecha', new Date(this.form.fecha_entrevista).toISOString().split('T')[0]);
			}
			if (this.form.fecha_nac) {
				this.markChanged('person', 'fecha_nac', new Date(this.form.fecha_nac).toISOString().split('T')[0]);
			}

			// Verificar cambios en programas sociales
			const currentProgramas = this.programasSelected.map(p => p.id);
			if (JSON.stringify(currentProgramas) !== JSON.stringify(this.originalData['programas'])) {
				this.modified.programas = true;
				this.changedData.programas = currentProgramas;
			}

			const payload = {
				person_id: this.entrevista.person_id,
				modified: this.modified,
				data: this.changedData
			};

			console.log('Payload a enviar:', payload);

			try {
				const response = await axios.post(
					route('collections.entrevistas.update', { id: this.entrevista.id }),
					payload,
					{
						headers: {
							'Content-Type': 'application/json'
						}
					}
				);

			if (response.status == 200) {
				this.labelType = "success";
				this.toastMessage = response.data.message;

				// Redireccionar manteniendo el loader visible
				setTimeout(() => {
					this.loading = false;
					window.location.href = '/collections/entrevistas';
				}, 1500)

				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
					this.btnGuardar = false
					this.loading = false
				}
			} catch (error) {
				console.log(error)
				this.labelType = "danger";
				this.toastMessage = error.response?.data?.message || "Error al actualizar la entrevista";
				this.btnGuardar = false
				this.loading = false
			}

		},

		addPrograma() {
			let existe_programa = this.programasSelected.find(programa => programa.id === this.programaSelect.id);
			if (this.programaSelect === '') {
				this.programaType = "info";
				this.toastMessage = "Debe ingresar un Programa";
			} else {
				if (!existe_programa) {
					this.programasSelected.push(this.programaSelect);
				} else {
					this.labelType = "info";
					this.toastMessage = "El Programa ya se encuentra asignada";
				}
			}
			this.programaSelect = '';
		},

		removePrograma(id) {
			const index = this.programasSelected.findIndex(item => item.id === id);
			this.programasSelected.splice(index, 1);
			this.labelType = "success";
			this.toastMessage = "Se ha eliminado correctamente el Programa";
		},

		getAddressData: function (addressData, placeResultData, id) {
			this.form.google_address = placeResultData['formatted_address']
			this.form.latitude = addressData['latitude']
			this.form.longitude = addressData['longitude']

			this.form_google = addressData

			this.showMap = true
		},
		coord_google($coord) {
			this.form.latitude = $coord.position.lat
			this.form.longitude = $coord.position.lng
			this.form.google_address = $coord.address
		},

	},
	computed: {
		barriosComputed: function () {
			return this.barrios.filter(barrio => barrio.localidad_id == this.form.localidad_id)
		}
	},
	watch: {
		// Entrevista
		'form.padron_id'(newVal) { this.markChanged('entrevista', 'padron_id', newVal) },
		'form.entrevistador_id'(newVal) { this.markChanged('entrevista', 'entrevistador_id', newVal) },
		'form.sede_id'(newVal) { this.markChanged('entrevista', 'puntos_entrega_id', newVal) },
		'form.observaciones'(newVal) { this.markChanged('entrevista', 'observaciones', newVal) },
		'form.vive_solo'(newVal) { this.markChanged('entrevista', 'vive_solo', newVal) },
		'form.cant_convivientes'(newVal) { this.markChanged('entrevista', 'cant_convivientes', newVal) },
		'form.has_hijos'(newVal) { this.markChanged('entrevista', 'has_hijos', newVal) },
		'form.cant_hijos'(newVal) { this.markChanged('entrevista', 'cant_hijos', newVal) },
		'form.cant_trabajadores'(newVal) { this.markChanged('entrevista', 'cant_personas_trabajando', newVal) },
		'form.has_discapacidad_conviviente'(newVal) { this.markChanged('entrevista', 'conviviente_discapacidad', newVal) },
		'form.tenencia'(newVal) { this.markChanged('entrevista', 'tenencia', newVal) },
		'form.ambientes'(newVal) { this.markChanged('entrevista', 'ambientes', newVal) },
		'form.ingresos_trabajo'(newVal) { this.markChanged('entrevista', 'ingresos_trabajo', newVal) },
		'form.ingresos_planes'(newVal) { this.markChanged('entrevista', 'ingresos_planes', newVal) },
		'form.recibe_tratamiento_medico'(newVal) { this.markChanged('entrevista', 'recibe_tratamiento_medico', newVal) },
		'form.tratamiento_medico'(newVal) { this.markChanged('entrevista', 'tratamiento_medico', newVal) },
		'form.recibe_medicacion'(newVal) { this.markChanged('entrevista', 'recibe_medicacion', newVal) },
		'form.medicacion'(newVal) { this.markChanged('entrevista', 'medicacion', newVal) },
		'form.has_discapacidad'(newVal) { this.markChanged('entrevista', 'discapacidad', newVal) },

		// Person
		'form.name'(newVal) { this.markChanged('person', 'name', newVal) },
		'form.lastname'(newVal) { this.markChanged('person', 'lastname', newVal) },

		// Address
		'form.calle'(newVal) { this.markChanged('address', 'calle', newVal) },
		'form.number'(newVal) { this.markChanged('address', 'number', newVal) },
		'form.piso'(newVal) { this.markChanged('address', 'piso', newVal) },
		'form.dpto'(newVal) { this.markChanged('address', 'dpto', newVal) },
		'form.google_address'(newVal) { this.markChanged('address', 'google_address', newVal) },
		'form.localidad_id'(newVal) { this.markChanged('address', 'localidad_id', newVal) },
		'form.barrio_id'(newVal) { this.markChanged('address', 'barrio_id', newVal) },
		'form.latitude'(newVal) { this.markChanged('address', 'latitude', newVal) },
		'form.longitude'(newVal) { this.markChanged('address', 'longitude', newVal) },

		// Contact
		'form.email'(newVal) { this.markChanged('contact', 'email', newVal) },
		'form.phone'(newVal) { this.markChanged('contact', 'phone', newVal) },
		'form.celular'(newVal) { this.markChanged('contact', 'celular', newVal) },

		// Aditional
		'form.situacion_conyugal_id'(newVal) { this.markChanged('aditional', 'situacion_conyugal_id', newVal) },
		'form.pais_id'(newVal) { this.markChanged('aditional', 'nacionalidad', newVal) },

		// Social
		'form.tipo_ocupacion_id'(newVal) { this.markChanged('social', 'tipo_ocupacion_id', newVal) },
		'form.cobertura_medica_id'(newVal) { this.markChanged('social', 'cobertura_medica_id', newVal) },
		'form.tipo_pension_id'(newVal) { this.markChanged('social', 'tipo_pension_id', newVal) },

		// Education
		'form.nivel_educativo_id'(newVal) { this.markChanged('education', 'nivel_educativo_id', newVal) },
		'form.estado_educativo_id'(newVal) { this.markChanged('education', 'estado_educativo_id', newVal) },

		// CUD
		'form.cud'(newVal) { this.markChanged('cud', 'codigo', newVal) },
		'form.diagnostico'(newVal) { this.markChanged('cud', 'diagnostico', newVal) },
	},
	mounted() {
		// Guardar datos originales PRIMERO
		this.storeOriginalData();

		// Cargar datos de la entrevista
		this.form.padron_id = this.entrevista.padron_id;
		this.form.entrevistador_id = this.entrevista.entrevistador_id;
		this.form.sede_id = this.entrevista.puntos_entrega_id;
		this.form.fecha_entrevista = new Date(this.entrevista.fecha + "T00:00:00.000-03:00");
		this.form.observaciones = this.entrevista.observaciones;

		// Datos de la persona
		const person = this.entrevista.person;
		this.form.tipo_documento_id = person.tipo_documento_id;
		this.form.num_documento = person.num_documento;
		this.form.name = person.name;
		this.form.lastname = person.lastname;
		this.form.fecha_nac = new Date(person.fecha_nac + "T00:00:00.000-03:00");

		// Contacto
		if (person.contact && person.contact[0]) {
			this.form.email = person.contact[0].email;
			this.form.phone = person.contact[0].phone;
			this.form.celular = person.contact[0].celular;
		}

		// Direccion
		if (person.address && person.address[0]) {
			this.form.calle = person.address[0].calle;
			this.form.number = person.address[0].number;
			this.form.piso = person.address[0].piso;
			this.form.dpto = person.address[0].dpto;
			this.form.google_address = person.address[0].google_address;
			this.form.localidad_id = person.address[0].localidad_id;
			this.form.barrio_id = person.address[0].barrio_id;

			if (person.address[0].latitude && person.address[0].longitude) {
				this.form.latitude = person.address[0].latitude;
				this.form.longitude = person.address[0].longitude;

				this.form_temp = {};
				this.form_temp.latitude = parseFloat(person.address[0].latitude);
				this.form_temp.longitude = parseFloat(person.address[0].longitude);
				this.form_temp.route = person.address[0].google_address;
				this.form_google = this.form_temp;
				this.showMap = true;
			}
		}

		// Aditional
		if (person.aditional && person.aditional[0]) {
			this.form.situacion_conyugal_id = person.aditional[0].situacion_conyugal_id;
			this.form.pais_id = person.aditional[0].nacionalidad;
		}

		// Social
		if (person.social && person.social[0]) {
			this.form.tipo_ocupacion_id = person.social[0].tipo_ocupacion_id;
			this.form.cobertura_medica_id = person.social[0].cobertura_medica_id;
			this.form.tipo_pension_id = person.social[0].tipo_pension_id;
		}

		// Education
		if (person.education && person.education[0]) {
			this.form.nivel_educativo_id = person.education[0].nivel_educativo_id;
			this.form.estado_educativo_id = person.education[0].estado_educativo_id;
		}

		// CUD
		if (person.cud) {
			this.form.cud = person.cud.codigo;
			this.form.diagnostico = person.cud.diagnostico;
		}

		// Programas sociales
		if (person.programa_social && person.programa_social.length > 0) {
			this.programasSelected = person.programa_social;
		}

		// Datos de la entrevista - CORREGIDO: cant_hijos debe venir de la entrevista
		this.form.vive_solo = this.entrevista.vive_solo;
		this.form.cant_convivientes = this.entrevista.cant_convivientes;
		this.form.has_hijos = this.entrevista.has_hijos;
		this.form.cant_hijos = this.entrevista.cant_hijos; // CORREGIDO: de entrevista, no de aditional
		this.form.cant_trabajadores = this.entrevista.cant_personas_trabajando;
		this.form.has_discapacidad_conviviente = this.entrevista.conviviente_discapacidad;
		this.form.tenencia = this.entrevista.tenencia;
		this.form.ambientes = this.entrevista.ambientes;
		this.form.ingresos_trabajo = this.entrevista.ingresos_trabajo;
		this.form.ingresos_planes = this.entrevista.ingresos_planes;
		this.form.recibe_tratamiento_medico = this.entrevista.recibe_tratamiento_medico;
		this.form.tratamiento_medico = this.entrevista.tratamiento_medico;
		this.form.recibe_medicacion = this.entrevista.recibe_medicacion;
		this.form.medicacion = this.entrevista.medicacion;
		this.form.has_discapacidad = this.entrevista.discapacidad;

		// Activar watchers después de cargar todos los datos
		this.$nextTick(() => {
			this.isLoadingData = false;
		console.log('Datos cargados. Watchers activados.');
	});
}

}
</script>

