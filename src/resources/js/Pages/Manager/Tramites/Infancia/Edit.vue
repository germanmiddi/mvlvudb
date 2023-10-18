
<template>
	<main class="flex-1 bg-gray-50 pb-40">
		<!-- Page title & actions -->
		<div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
			<div class="flex-1 min-w-0 flex items-center">
				<a class="btn-blue" :href="route('infancia')">
					<ArrowLeftCircleIcon class="w-5 h-5 text-purple-700 mr-2" />
				</a>
				<h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Nuevo Tramite Centros Barriales Infancia
					| CBI</h1>
			</div>
			<div class="mt-4 flex sm:mt-0 sm:ml-4">
				<button
					class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"
					@click="submit">
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
				<p v-for="error of v$.form_nino.$errors" :key="error.$uid">
					{{ error.$message }}
				</p>
			</div>
		</div>

		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<form action="#" method="POST" enctype="multipart/form-data">
				<div class="shadow sm:rounded-md sm:overflow-hidden">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">Declaración Jurada</h3>
							<!-- <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly so be careful what you share.</p> -->
						</div>

						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-3 ">
								<label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form.fecha" :enableTimePicker="false" :monthChangeOnScroll="true" autoApply
									:format="format" :style="v$.form.fecha.$error ? datepickerStyle : ''">
								</Datepicker>
								<span v-if="v$.form.fecha.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-5">
								<label for="tipo_tramite_id" class="block text-sm font-medium text-gray-700">Tipo de
									Tramite</label>
								<select v-model="form.tipo_tramite_id" id="tipo_tramite_id" name="tipo_tramite_id"
									autocomplete="tipo_tramite_id_name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
									:class="v$.form.tipo_tramite_id.$error ? 'border-red-500' : ''">
									<option value="" disabled>Selecciones un tipo de tramite</option>
									<option v-for="tipoTramite in tiposTramite" :key="tipoTramite.id"
										:value="tipoTramite.id">{{
											tipoTramite.description
										}}</option>
								</select>
								<span v-if="v$.form.tipo_tramite_id.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="canal_atencion" class="block text-sm font-medium text-gray-700">Canal de
									Atención</label>
								<select v-model="form.canal_atencion_id" id="canal_atencion" name="canal_atencion"
									autocomplete="canal_atencion-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
									:class="v$.form.canal_atencion_id.$error ? 'border-red-500' : ''">
									<option value="" disabled>Selecciones un canal de atencion</option>
									<option v-for="canalAtencion in canalesAtencion" :key="canalAtencion.id"
										:value="canalAtencion.id">{{
											canalAtencion.description
										}}</option>
								</select>
								<span v-if="v$.form.canal_atencion_id.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>
						</div>
						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-8">
								<label for="observacion" class="block text-sm font-medium text-gray-700">Observaciones
								</label>
								<div class="mt-1">
									<textarea v-model="form.observacion" id="observacion" name="observacion" rows="3"
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" />
								</div>
								<p class="mt-2 text-sm text-gray-500">Ingrese información adicional del tramite.</p>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<!-- <div>
						<h3 class="text-lg leading-6 font-medium text-gray-900"></h3>
					</div> -->
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">Datos del Centro Barrial Infancia |
									CBI</h3>
							</div>
						</div>
						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="sede_id" class="block text-sm font-medium text-gray-700">Sede</label>
								<select v-model="form.sede_id" id="sede_id" name="sede_id" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione una sede</option>
									<option v-for="sede in sedes" :key="sede.id" :value="sede.id">{{
										sede.description
									}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3 ">
								<label for="anio_inicio" class="block text-sm font-medium text-gray-700">Fecha de
									inicio CBI</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form.anio_inicio" auto-apply year-picker>
								</Datepicker>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="estado_cbi_id" class="block text-sm font-medium text-gray-700">Estado en
									CBI</label>
								<select v-model="form.estado_cbi_id" id="estado_cbi_id" name="estado_cbi_id"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione un estado</option>
									<option v-for="estadoCbi in estadosCbi" :key="estadoCbi.id" :value="estadoCbi.id">{{
										estadoCbi.description
									}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="aut_firmada" class="block text-sm font-medium text-gray-700">Autorizacion
									firmada</label>
								<select v-model="form.aut_firmada" id="aut_firmada" name="aut_firmada" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="aut_retirarse" class="block text-sm font-medium text-gray-700">Autorizacion para
									retirarse solo</label>
								<select v-model="form.aut_retirarse" id="aut_retirarse" name="aut_retirarse"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="aut_uso_imagen" class="block text-sm font-medium text-gray-700">Autorizacion uso
									de imagen</label>
								<select v-model="form.aut_uso_imagen" id="aut_uso_imagen" name="aut_uso_imagen"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="act_varias" class="block text-sm font-medium text-gray-700">Actividades
									varias</label>
								<select v-model="form.act_varias" id="act_varias" name="act_varias" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="act_esporadicas" class="block text-sm font-medium text-gray-700">Actividades
									esporadicas</label>
								<select v-model="form.act_esporadicas" id="act_esporadicas" name="act_esporadicas"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="comedor" class="block text-sm font-medium text-gray-700">Comedor</label>
								<select v-model="form.comedor" id="comedor" name="comedor" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="estado_gabinete_id" class="block text-sm font-medium text-gray-700">Gabinete
									Psicologico</label>
								<select v-model="form.estado_gabinete_id" id="estado_gabinete_id" name="estado_gabinete_id"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione una opcion</option>
									<option v-for="estadoGabinete in estadosGabinete" :key="estadoGabinete.id"
										:value="estadoGabinete.id">{{
											estadoGabinete.description
										}}</option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<!-- DATOS DEL TITULAR.. -->

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<!-- <div>
						<h3 class="text-lg leading-6 font-medium text-gray-900"></h3>
					</div> -->
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">Datos del Titular</h3>
							</div>
							<!-- <div class="flex-shrink-0">
								<button type="button"
									class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">Agregar
									Beneficiario</button>
							</div> -->
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Tipo de
									Documento</label>
								<select v-model="form.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
									autocomplete="tipo_documento_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
									:class="v$.form.tipo_documento_id.$error ? 'border-red-500' : ''">
									<option value="" disabled>Seleccione un tipo de documento</option>
									<option v-for="tipoDocumento in tiposDocumento" :key="tipoDocumento.id"
										:value="tipoDocumento.id">{{
											tipoDocumento.description
										}}</option>
								</select>
								<span v-if="v$.form.tipo_documento_id.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3 ">
								<label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de
									Documento</label>
								<input v-model="form.num_documento" @focusout="getPerson()" type="text" name="num_documento"
									id="num_documento" autocomplete="address-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-100"
									:class="v$.form.num_documento.$error ? 'border-red-500' : ''" :disabled="true" />
								<span v-if="v$.form.num_documento.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3 ">
								<label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
								<input v-model="form.name" type="text" name="name" id="name" autocomplete="name-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.name.$error ? 'border-red-500' : ''" />
								<span v-if="v$.form.name.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3 ">
								<label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
								<input v-model="form.lastname" type="text" name="lastname" id="lastname"
									autocomplete="lastname-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.lastname.$error ? 'border-red-500' : ''" />
								<span v-if="v$.form.lastname.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>



						</div>

						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-3 ">
								<label for="fecha_nac" class="block text-sm font-medium text-gray-700">Fecha de
									Nacimiento</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form.fecha_nac" :enableTimePicker="false" :monthChangeOnScroll="false"
									autoApply :format="format">
								</Datepicker>
							</div>

							<div class="col-span-12 sm:col-span-3 ">
								<label for="email" class="block text-sm font-medium text-gray-700">Mail</label>
								<input v-model="form.email" type="text" name="email" id="email" autocomplete="email-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3 ">
								<label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
								<input v-model="form.phone" type="text" name="phone" id="phone" autocomplete="phone-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-3 ">
								<label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
								<input v-model="form.celular" type="text" name="celular" id="celular"
									autocomplete="phone-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_documento_id"
									class="block text-sm font-medium text-gray-700">Vinculo con el Menor</label>
								<select v-model="form.parentesco_id" id="parentesco_id" name="parentesco_id"
									autocomplete="parentesco_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un tipo de vinculo
									</option>
									<option v-for="parentesco in parentescos" :key="parentesco.id" :value="parentesco.id">
										{{ parentesco.description }}
									</option>
								</select>
							</div>

						</div>

					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">Dirección | Titular</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="localidad_id" class="block text-sm font-medium text-gray-700">Localidad</label>
								<select v-model="form.localidad_id" id="localidad_id" name="localidad_id"
									autocomplete="localidad_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione una localidad</option>
									<option v-for="localidad in localidades" :key="localidad.id" :value="localidad.id">{{
										localidad.description
									}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="barrio_id" class="block text-sm font-medium text-gray-700">Barrio</label>
								<select v-model="form.barrio_id" id="barrio_id" name="barrio_id"
									autocomplete="barrio_id-name"
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
								<input v-model="form.calle" type="text" name="calle" id="calle" autocomplete="calle-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-2 ">
								<label for="number" class="block text-sm font-medium text-gray-700">Número</label>
								<input v-model="form.number" type="text" name="number" id="number"
									autocomplete="number-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-2 ">
								<label for="piso" class="block text-sm font-medium text-gray-700">Piso</label>
								<input v-model="form.piso" type="text" name="piso" id="piso" autocomplete="piso-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-2 ">
								<label for="dpto" class="block text-sm font-medium text-gray-700">Departamento</label>
								<input v-model="form.dpto" type="text" name="dpto" id="dpto" autocomplete="dptolevel2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>


						</div>
						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-6 ">
								<label for="google_address" class="block text-sm font-medium text-gray-700">Dirección
									Google</label>
								<!-- <input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" /> -->
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
							<p class="mt-2 text-sm text-gray-500 col-span-12 sm:col-span-12">{{ this.form.google_address }}
							</p>
							<div class="col-span-12 sm:col-span-12 ">
								<GoogleMap v-if="this.showMap" :form_map="form_google" @coordenadas_google="coord_google">

								</GoogleMap>
							</div>

						</div>

					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">Situación Social | Titular</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="pais_id" class="block text-sm font-medium text-gray-700">Pais de Origen</label>
								<select v-model="form.pais_id" id="pais_id" name="pais_id" autocomplete="pais_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un pais</option>
									<option v-for="pais in paises" :key="pais.id" :value="pais.id"
										:bind:select="pais.id == form.pais_id">{{
											pais.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="situacion_conyugal_id" class="block text-sm font-medium text-gray-700">Situación
									Conyugal</label>
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
							<div class="col-span-12 sm:col-span-4 ">
								<label for="cant_hijos" class="block text-sm font-medium text-gray-700">Cantidad
									Hijos</label>
								<input v-model="form.cant_hijos" type="text" name="cant_hijos" id="cant_hijos"
									autocomplete="address-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

						</div>

					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">Estudios | Titular</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="nivel_educativo_id" class="block text-sm font-medium text-gray-700">Nivel
									educativo en curso</label>
								<select v-model="form.nivel_educativo_id" id="nivel_educativo_id" name="nivel_educativo_id"
									autocomplete="nivel_educativo_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un nivel educativo</option>
									<option v-for="nivelEducativo in nivelesEducativo" :key="nivelEducativo.id"
										:value="nivelEducativo.id"
										:bind:select="nivelEducativo.id == form.nivel_educativo_id">{{
											nivelEducativo.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
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
							<h3 class="text-lg leading-6 font-medium text-gray-900">Situación Laboral | Titular</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_ocupacion_id"
									class="block text-sm font-medium text-gray-700">Ocupación</label>
								<select v-model="form.tipo_ocupacion_id" id="tipo_ocupacion_id" name="tipo_ocupacion_id"
									autocomplete="tipo_ocupacion_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una ocupacion</option>
									<option v-for="tipoOcupacion in tiposOcupacion" :key="tipoOcupacion.id"
										:value="tipoOcupacion.id" :bind:select="tipoOcupacion.id == form.tipo_ocupacion_id">
										{{
											tipoOcupacion.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
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
						</div>
					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">Datos | Titular</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="cobertura_medica_id" class="block text-sm font-medium text-gray-700">Cobertura
									de Salud</label>
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
							<div class="col-span-12 sm:col-span-3">
								<label for="programa_social_id" class="block text-sm font-medium text-gray-700">Recibe
									Programa Social</label>
								<select v-model="form.programa_social_id" id="programa_social_id" name="programa_social_id"
									autocomplete="programa_social_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un programa social</option>
									<option v-for="programaSocial in programasSocial" :key="programaSocial.id"
										:value="programaSocial.id"
										:bind:select="programaSocial.id == form.programa_social_id">{{
											programaSocial.description
										}}</option>
								</select>
							</div>
							
						</div>
					</div>
				</div>

				<!-- FIN DATOS DEL TITULAR.. -->

				<!-- DATOS DEL NIÑO.. -->

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<!-- <div>
						<h3 class="text-lg leading-6 font-medium text-gray-900"></h3>
					</div> -->
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">Datos del Niño</h3>
							</div>
							<!-- <div class="flex-shrink-0">
								<button type="button"
									class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">Agregar
									Beneficiario</button>
							</div> -->
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Tipo de
									Documento</label>
								<select v-model="form_nino.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
									autocomplete="tipo_documento_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
									:class="v$.form_nino.tipo_documento_id.$error ? 'border-red-500' : ''">
									<option value="" disabled>Seleccione un tipo de documento</option>
									<option v-for="tipoDocumento in tiposDocumento" :key="tipoDocumento.id"
										:value="tipoDocumento.id">{{
											tipoDocumento.description
										}}</option>
								</select>
								<span v-if="v$.form_nino.tipo_documento_id.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3 ">
								<label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de
									Documento</label>
								<input v-model="form_nino.num_documento" @focusout="getPerson()" type="text" name="num_documento"
									id="num_documento" autocomplete="address-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-100"
									:disabled="true" />
								
							</div>

							<div class="col-span-12 sm:col-span-3 ">
								<label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
								<input v-model="form_nino.name" type="text" name="name" id="name" autocomplete="name-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form_nino.name.$error ? 'border-red-500' : ''" />
								<span v-if="v$.form_nino.name.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3 ">
								<label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
								<input v-model="form_nino.lastname" type="text" name="lastname" id="lastname"
									autocomplete="lastname-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form_nino.lastname.$error ? 'border-red-500' : ''" />
								<span v-if="v$.form_nino.lastname.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>



						</div>

						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-3 ">
								<label for="fecha_nac" class="block text-sm font-medium text-gray-700">Fecha de
									Nacimiento</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form_nino.fecha_nac" :enableTimePicker="false" :monthChangeOnScroll="false"
									autoApply :format="format">
								</Datepicker>
							</div>

							<div class="col-span-12 sm:col-span-3 ">
								<label for="email" class="block text-sm font-medium text-gray-700">Mail</label>
								<input v-model="form_nino.email" type="text" name="email" id="email" autocomplete="email-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3 ">
								<label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
								<input v-model="form_nino.phone" type="text" name="phone" id="phone" autocomplete="phone-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-3 ">
								<label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
								<input v-model="form_nino.celular" type="text" name="celular" id="celular"
									autocomplete="phone-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

						</div>

					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">Dirección | Niño</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							
							<div class="col-span-12 sm:col-span-3">
								<label for="localidad_id" class="block text-sm font-medium text-gray-700">Localidad</label>
								<select v-model="form_nino.localidad_id" id="localidad_id" name="localidad_id"
									autocomplete="localidad_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione una localidad</option>
									<option v-for="localidad in localidades" :key="localidad.id" :value="localidad.id">{{
										localidad.description
									}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="barrio_id" class="block text-sm font-medium text-gray-700">Barrio</label>
								<select v-model="form_nino.barrio_id" id="barrio_id" name="barrio_id"
									autocomplete="barrio_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione un barrio</option>
									<option v-for="barrio in barriosNinoComputed" :key="barrio.id" :value="barrio.id">{{
										barrio.description
									}}</option>
								</select>
							</div>

						</div>

						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-4 ">
								<label for="calle" class="block text-sm font-medium text-gray-700">Calle</label>
								<input v-model="form_nino.calle" type="text" name="calle" id="calle"
									autocomplete="calle-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-2 ">
								<label for="number" class="block text-sm font-medium text-gray-700">Número</label>
								<input v-model="form_nino.number" type="text" name="number" id="number"
									autocomplete="number-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-2 ">
								<label for="piso" class="block text-sm font-medium text-gray-700">Piso</label>
								<input v-model="form_nino.piso" type="text" name="piso" id="piso" autocomplete="piso-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-2 ">
								<label for="dpto" class="block text-sm font-medium text-gray-700">Departamento</label>
								<input v-model="form_nino.dpto" type="text" name="dpto" id="dpto" autocomplete="dptolevel2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>


						</div>

					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">Estudios | Niño</h3>
						</div>
						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="escuela_infante_id"
									class="block text-sm font-medium text-gray-700">Escuela Infante</label>
								<select v-model="form_nino.escuela_infante_id" id="escuela_id"
									name="escuela_infante_id" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un escuela</option>
									<option v-for="escuela in escuelasInfante" :key="escuela.id" :value="escuela.id">{{
										escuela.description
									}}</option>

								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="escuela_id" class="block text-sm font-medium text-gray-700">Escuela</label>
								<select v-model="form_nino.escuela_id" id="escuela_id" name="escuela_id" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un escuela</option>
									<option v-for="escuela in escuelas" :key="escuela.id" :value="escuela.id">{{
										escuela.description
									}}</option>

								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="estado_educativo_id"
									class="block text-sm font-medium text-gray-700">Dependencia</label>
								<select v-model="form_nino.escuela_dependencia_id" id="escuela_dependencia_id"
									name="escuela_dependencia_id" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una dependencia</option>
									<option v-for="escuelaDependencia in escuelasDependencias" :key="escuelaDependencia.id"
										:value="escuelaDependencia.id">{{
											escuelaDependencia.description
										}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="estado_educativo_id"
									class="block text-sm font-medium text-gray-700">Localidad</label>
								<select v-model="form_nino.escuela_localidad_id" id="escuela_localidad_id"
									name="escuela_localidad_id" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un estado educativo</option>
									<option v-for="localidad in localidades" :key="localidad.id" :value="localidad.id">{{
										localidad.description
									}}</option>
								</select>
							</div>


							<div class="col-span-12 sm:col-span-3">
								<label for="nivel_educativo_id" class="block text-sm font-medium text-gray-700">Nivel
									educativo en curso</label>
								<select v-model="form_nino.nivel_educativo_id" id="nivel_educativo_id"
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
							<div class="col-span-12 sm:col-span-3">
								<label for="estado_educativo_id" class="block text-sm font-medium text-gray-700">Nivel
									educativo alcanzado</label>
								<select v-model="form_nino.estado_educativo_id" id="estado_educativo_id"
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

							<div class="col-span-12 sm:col-span-3">
								<label for="escuela_nivel_id" class="block text-sm font-medium text-gray-700">Año en
									Curso</label>
								<select v-model="form_nino.escuela_nivel_id" id="escuela_nivel_id" name="escuela_nivel_id"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un estado educativo</option>
									<option v-for="escuelaNivel in escuelasNiveles" :key="escuelaNivel.id"
										:value="escuelaNivel.id">{{
											escuelaNivel.description
										}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="escuela_turno_id" class="block text-sm font-medium text-gray-700">Turno</label>
								<select v-model="form_nino.escuela_turno_id" id="escuela_turno_id" name="escuela_turno_id"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un estado educativo</option>
									<option v-for="escuelaTurno in escuelasTurnos" :key="escuelaTurno.id"
										:value="escuelaTurno.id">{{
											escuelaTurno.description
										}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="permanencia" class="block text-sm font-medium text-gray-700">Realizo
									permanencia</label>
								<select v-model="form_nino.permanencia" id="permanencia" name="permanencia"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="certificado_escolar" class="block text-sm font-medium text-gray-700">Certificado
									escolar</label>
								<select v-model="form_nino.certificado_escolar" id="certificado_escolar"
									name="certificado_escolar" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>

								</select>
							</div>
						</div>
						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-9">
								<label for="nino_observacion_educacion"
									class="block text-sm font-medium text-gray-700">Observaciones
								</label>
								<div class="mt-1">
									<textarea v-model="form_nino.observacion_educacion" id="observacion_educacion"
										name="observacion_educacion" rows="3"
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" />
								</div>
								<p class="mt-2 text-sm text-gray-500">Ingrese información adicional del tramite.</p>
							</div>

						</div>

					</div>
				</div>


				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">Salud | Niño</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-3">
								<label for="apto_medico" class="block text-sm font-medium text-gray-700">Apto médico
									presentado</label>
								<select v-model="form_nino.apto_medico" id="apto_medico" name="apto_medico"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="libreta_vacunacion" class="block text-sm font-medium text-gray-700">Libreta de
									vacunación
									presentada</label>
								<select v-model="form_nino.libreta_vacunacion" id="libreta_vacunacion"
									name="libreta_vacunacion" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="centro_salud_id" class="block text-sm font-medium text-gray-700">Lugar de
									Atención</label>
								<select v-model="form_nino.centro_salud_id" id="centro_salud_id" name="centro_salud_id"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un programa social</option>
									<option v-for="centroSalud in centrosSalud" :key="centroSalud.id"
										:value="centroSalud.id">{{
											centroSalud.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="estado_salud_id" class="block text-sm font-medium text-gray-700">Estado de salud
									(A tener
									presente)</label>
								<select v-model="form_nino.estado_salud_id" id="estado_salud_id" name="estado_salud_id"
									autocomplete="programa_social_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un estado de salud</option>
									<option v-for="estadoSalud in estadosSalud" :key="estadoSalud.id"
										:value="estadoSalud.id">{{
											estadoSalud.description
										}}</option>
								</select>
							</div>
						</div>
						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-9">
								<label for="nino_observacion_salud" class="block text-sm font-medium text-gray-700">Observaciones
								</label>
								<div class="mt-1">
									<textarea v-model="form_nino.observacion_salud" id="nino_observacion_salud" name="nino_observacion_salud" rows="3"
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" />
								</div>
								<p class="mt-2 text-sm text-gray-500">Ingrese información adicional a la salud del niño.</p>
							</div>
						</div>
					</div>
				</div>

				<!-- FIN DATOS DEL NIÑO -->

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">

						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Familiares
								</h3>
							</div>
							<div class="flex-shrink-0">
								<button type="button" @click="addFamiliar()"
									class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md"
									:class="showFamiliar
										? 'bg-red-200 text-red-900 hover:bg-red-600 hover:text-white'
										: 'bg-green-200 text-green-900 hover:bg-green-600 hover:text-white'
										">
									{{ this.textBtnFamiliar }}
								</button>
							</div>
						</div>



						<hr v-if="showFamiliar">
						<div v-if="showFamiliar" class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Tipo de
									Documento</label>
								<select v-model="form_familiar.tipo_documento_id" id="tipo_documento_id"
									name="tipo_documento_id" autocomplete="tipo_documento_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" selected>
										Seleccione un tipo de documento
									</option>
									<option v-for="tipoDocumento in tiposDocumento" :key="tipoDocumento.id"
										:value="tipoDocumento.id">{{
											tipoDocumento.description
										}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de
									Documento</label>
								<input v-model="form_familiar.num_documento" @focusout="getPersonFamiliar()" type="text"
									name="num_documento" id="num_documento" autocomplete="address-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
								<input v-model="form_familiar.name" type="text" name="name" id="name"
									autocomplete="name-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
								<input v-model="form_familiar.lastname" type="text" name="lastname" id="lastname"
									autocomplete="lastname-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

						</div>

						<div v-if="showFamiliar" class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="fecha_nac" class="block text-sm font-medium text-gray-700">Fecha de
									Nacimiento</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form_familiar.fecha_nac" :enableTimePicker="false" :monthChangeOnScroll="false"
									autoApply :format="format">
								</Datepicker>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_documento_id"
									class="block text-sm font-medium text-gray-700">Parentesco</label>
								<select v-model="form_familiar.parentesco_id" id="parentesco_id" name="parentesco_id"
									autocomplete="parentesco_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un tipo de parentesco
									</option>
									<option v-for="parentesco in parentescos" :key="parentesco.id" :value="parentesco.id">
										{{ parentesco.description }}
									</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<button type="button" @click="storeFamiliar()"
									class="mt-7 relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">
									Agregar Familiar
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
												Dni
											</th>
											<th scope="col"
												class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12">
												Nombre
											</th>
											<th scope="col"
												class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12">
												Apellido
											</th>
											<th scope="col"
												class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12">
												Parentesco
											</th>
											<th scope="col"
												class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12">
												Acciones
											</th>
										</tr>
									</thead>
									<tbody class="bg-white divide-y divide-gray-200">
										<ListFamiliar v-for="familiar in this.form_familiares" :parentescos=parentescos :key="familiar.id"
											:item=familiar @edit-item="editFamiliar" 
											@destroy-item="destroyFamiliar" />

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>


				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">

						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Contactos de Emergencias
								</h3>
							</div>
							<div class="flex-shrink-0">
								<button type="button" @click="addContacto()"
									class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md"
									:class="showContacto
										? 'bg-red-200 text-red-900 hover:bg-red-600 hover:text-white'
										: 'bg-green-200 text-green-900 hover:bg-green-600 hover:text-white'
										">
									{{ this.textBtnContacto }}
								</button>
							</div>
						</div>



						<hr v-if="showContacto">
						<div v-if="showContacto" class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Tipo de
									Documento</label>
								<select v-model="form_contacto.tipo_documento_id" id="tipo_documento_id"
									name="tipo_documento_id" autocomplete="tipo_documento_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un tipo de documento
									</option>
									<option v-for="tipoDocumento in tiposDocumento" :key="tipoDocumento.id"
										:value="tipoDocumento.id">{{
											tipoDocumento.description
										}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de
									Documento</label>
								<input v-model="form_contacto.num_documento" @focusout="getPersonContacto()" type="text"
									name="num_documento" id="num_documento" autocomplete="address-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
								<input v-model="form_contacto.name" type="text" name="name" id="name"
									autocomplete="name-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
								<input v-model="form_contacto.lastname" type="text" name="lastname" id="lastname"
									autocomplete="lastname-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

						</div>

						<div v-if="showContacto" class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="fecha_nac" class="block text-sm font-medium text-gray-700">Fecha de
									Nacimiento</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form_contacto.fecha_nac" :enableTimePicker="false" :monthChangeOnScroll="false"
									autoApply :format="format">
								</Datepicker>
							</div>
							
							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_documento_id"
									class="block text-sm font-medium text-gray-700">Parentesco</label>
								<select v-model="form_contacto.parentesco_id" id="parentesco_id" name="parentesco_id"
									autocomplete="parentesco_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un tipo de parentesco
									</option>
									<option v-for="parentesco in parentescos" :key="parentesco.id" :value="parentesco.id">
										{{ parentesco.description }}
									</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="phone" class="block text-sm font-medium text-gray-700">Telefono</label>
								<input v-model="form_contacto.phone" type="text" name="phone" id="phone"
									autocomplete="lastname-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3">
								<button type="button" @click="storeContacto()"
									class="mt-7 relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">
									Agregar Contacto
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
												Dni
											</th>
											<th scope="col"
												class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12">
												Nombre
											</th>
											<th scope="col"
												class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12">
												Apellido
											</th>
											<th scope="col"
												class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12">
												Parentesco
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
									<tbody class="bg-white divide-y divide-gray-200">
										<ListContacto v-for="contacto in this.form_contactos" :parentescos=parentescos :key="contacto.id"
											:item=contacto @edit-item="editContacto"
											@destroy-item="destroyContacto" />

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">

						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">Archivos Adjuntos</h3>
							</div>

						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-8 ">
								<label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
								<div class="flex ">
									<input v-model="form.description_file" type="text" name="descripcion" id="descripcion"
										autocomplete="descripcion-level2"
										class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-1/2 shadow-sm sm:text-sm border-gray-300 rounded-md mr-6" />
										<input @change="handleFileUpload" accept=".jpg, .jpeg, .png, .gif, .pdf" type="file" name="file" id="file" ref="inputfile"
										autocomplete="off"
										class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-1/2 rounded-md" />
									<div class="flex-shrink-0">
										<button @click="uploadFile()" type="button"
											class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">
											Subir Archivo</button>
									</div>
								</div>
								<p v-show="this.fileInvalid" class="mt-2 text-red-500 text-xs"> - Por favor, seleccione un archivo de imagen o PDF.</p>
							</div>
							<div class="col-span-6 sm:col-span-6 ">
								<table class="min-w-full divide-y divide-gray-200 w-full col-span-6">
									<thead class="bg-gray-50">
										<tr>
											<th scope="col"
												class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8/12">
												Observacion
											</th>
											<th scope="col"
												class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12">
												Accion
											</th>
										</tr>
									</thead>
									<tbody  class="bg-white divide-y divide-gray-200">
										<tr v-for="archivo in form_archivo " :key="archivo.id">
											<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
												{{ archivo.description }}
											</td>
											<td class="px-6 py-4 text-center text-sm font-medium">
												<a class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-blue-200 text-blue-900 hover:bg-blue-600 hover:text-white"
													:href="'/file/download/' + archivo.id"
													title="Descargar Archivo">
													Descargar
												</a>
												<a class="ml-2 relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-red-200 text-red-900 hover:bg-red-600 hover:text-white"
													@click="deleteFile(archivo.id)" title="Eliminar Archivo" >
													Eliminar
												</a>
											</td>
										</tr>
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
				class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"
				@click="submit">
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
import VueGoogleAutocomplete from "vue-google-autocomplete"
import GoogleMap from '@/Layouts/Components/GoogleMap.vue'
import FormBeneficiario from '@/Layouts/Components/Tramites/FormBeneficiario.vue'
import Toast from "@/Layouts/Components/Toast.vue";
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import ListFamiliar from '@/Layouts/Components/Tramites/ListFamiliar.vue';
import ListContacto from '@/Layouts/Components/Tramites/ListContacto.vue';
import store from '@/store.js'

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
		tramite: Object,
		parentescos: Object,
		sedes: Object,
		estadosCbi: Object,
		estadosGabinete: Object,
		escuelas: Object,
		escuelasInfante: Object,
		escuelasDependencias: Object,
		escuelasNiveles: Object,
		escuelasTurnos: Object,
		centrosSalud: Object,
		estadosSalud: Object
	},
	components: {
		ArrowLeftCircleIcon,
		ArrowDownCircleIcon,
		GoogleMap,
		VueGoogleAutocomplete,
		Toast,
		Datepicker,
		FormBeneficiario,required,
		useVuelidate,
		helpers,
		minLength,
		ListFamiliar,
		ListContacto,
		store
	},
	data() {
		return {
			form: {},
			form_temp: {},
			form_nino: {},
			form_google: "",
			form_beneficiario: {},
			form_familiares: [],
			form_contactos: [],
			address: "",
			showMap: false,
			toastMessage: "",
			labelType: "info",
			message: "",
			showToast: false,
			file: "",
			form_archivo: {},
			form_familiar: {},
			form_contacto: {},
			form_beneficiario: {},
			showBenef: false,btnGuardar: false,
			datepickerStyle: {
				color: 'red',
				border: '1px solid red',
			},
			textBtnFamiliar: "Agregar Familiar",
			showFamiliar: false,
			textBtnContacto: "Agregar Contacto",
			showContacto: false,
			fileInvalid: false
		}
	},
	validations() {
		return {
			form: {
				fecha: { required: helpers.withMessage('El campo Fecha es Obligatorio', required) },
				canal_atencion_id: { required: helpers.withMessage('El campo Canal de Atencion es Obligatorio', required) },
				tipo_tramite_id: { required: helpers.withMessage('El campo Tipo de tramite es Obligatorio', required) },
				tipo_documento_id: { required: helpers.withMessage('El campo Tipo de Documento es Obligatorio', required) },
				num_documento: { required: helpers.withMessage('El campo N° de documento es Obligatorio', required) }, // Matches this.contact.email
				name: { required: helpers.withMessage('El campo Nombre es Obligatorio', required) },
				lastname: { required: helpers.withMessage('El campo Apellido es Obligatorio', required) },
				fecha_nac: { required: helpers.withMessage('El campo Fecha de Nacimiento es Obligatorio', required) },
			},
			form_nino: {
				tipo_documento_id: { required: helpers.withMessage('El campo Tipo de Documento del Niño es Obligatorio', required) },
				name: { required: helpers.withMessage('El campo Nombre del Niño es Obligatorio', required) },
				lastname: { required: helpers.withMessage('El campo Apellido del Niño es Obligatorio', required) },
				fecha_nac: { required: helpers.withMessage('El campo Fecha de Nacimiento del Niño es Obligatorio', required) },
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
		clearMessage() {
			this.toastMessage = "";
		},
		async submit() {
			const result = await this.v$.$validate()
			if (!result) {
				return
			}
			this.btnGuardar = true
			let rt = route('infancia.update', this.form.tramite_id);

			const formData = new FormData();

			this.form.fecha = (this.form.fecha) ? new Date(this.form.fecha).toISOString() : null;
			this.form.fecha_nac = (this.form.fecha_nac) ? new Date(this.form.fecha_nac).toISOString() : null;

			for (var clave in this.form) {
				if (this.form.hasOwnProperty(clave)) {
					formData.append(clave, this.form[clave]);
				}
			}

			// Datos del Niño
			this.form_nino.fecha_nac = (this.form_nino.fecha_nac) ? new Date(this.form_nino.fecha_nac).toISOString() : null;

			for (var clave in this.form_nino) {
				if (this.form_nino.hasOwnProperty(clave)) {
					formData.append('nino_'+clave, this.form_nino[clave]);
				}
			}

			try {
				const response = await axios.post(rt, formData);
				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
					setTimeout(() => {
						window.location.href = '/infancia';
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
		async getPersonFamiliar() {
			let num_documento = this.form_familiar.num_documento;
			let tipo_documento_id = this.form_familiar.tipo_documento_id;

			const get = `${route('persons.getPersonDni', this.form_familiar.num_documento)}`
			const response = await fetch(get, { method: 'GET' })
			let data = await response.json()
			if (!data.data.length == 0) {
				data = data.data[0].person
				/// Recuperar datos.
				this.form_familiar.person_id = data.id
				this.form_familiar.tipo_documento_id = data.tipo_documento_id
				this.form_familiar.fecha_nac = data.fecha_nac
				this.form_familiar.fecha_nac = new Date(this.form_familiar.fecha_nac + "T00:00:00.000-03:00")
				this.form_familiar.name = data.name
				this.form_familiar.lastname = data.lastname
			} else {
				this.labelType = "info";
				this.toastMessage = "El DNI indicado no se encuentra registrado";
				this.form_familiar = {}
				this.form_familiar.num_documento = num_documento
				this.form_familiar.tipo_documento_id = tipo_documento_id
			}
		},
		async getPersonContacto() {
			let num_documento = this.form_contacto.num_documento;
			let tipo_documento_id = this.form_contacto.tipo_documento_id;

			const get = `${route('persons.getPersonDni', this.form_contacto.num_documento)}`
			const response = await fetch(get, { method: 'GET' })
			let data = await response.json()
			if (!data.data.length == 0) {
				data = data.data[0].person
				/// Recuperar datos.
				this.form_contacto.person_id = data.id
				this.form_contacto.tipo_documento_id = data.tipo_documento_id
				this.form_contacto.fecha_nac = data.fecha_nac
				this.form_contacto.fecha_nac = new Date(this.form_contacto.fecha_nac + "T00:00:00.000-03:00")
				this.form_contacto.name = data.name
				this.form_contacto.lastname = data.lastname
				this.form_contacto.phone = data.contact[0].phone
			} else {
				this.labelType = "info";
				this.toastMessage = "El DNI indicado no se encuentra registrado";
				this.form_contacto = {}
				this.form_contacto.num_documento = num_documento
				this.form_contacto.tipo_documento_id = tipo_documento_id
			}
		},
		
		getAddressData: function (addressData, placeResultData, id) {
			this.form.google_address = placeResultData['formatted_address']
			this.form.latitude = addressData['latitude']
			this.form.longitude = addressData['longitude']

			this.form_google = addressData

			this.showMap = true
		},

		handleFileUpload(event) {
			this.fileInvalid = false
			const fileUpload = event.target.files[0];
			if (fileUpload) {
				// Verificar el tipo de archivo
				if (store.isValidFileType(fileUpload)) {
					// El archivo es válido
					this.file = fileUpload
				} else {
					// Archivo no válido
					this.file = null
					const fileValue = this.$refs.inputfile;
					fileValue.value = null;
					this.fileInvalid = true;
				}
			}
		},
		coord_google($coord) {
			this.form.latitude = $coord.position.lat.toString()
			this.form.longitude = $coord.position.lng.toString()
			this.form.google_address = $coord.address

			// TODO: Mapa: Ver como cargar el nombre de la calle en el Auto-complete-google
		},

		beneficiario(data) {
			this.form_beneficiario = data;
		},
		async deleteFile(id) {

			let rt = route('file.delete', id);

			try {
				const response = await axios.delete(rt);
				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
					this.form_archivo = this.form_archivo.filter(function (file) {
						return file.id !== id;
					});
				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
				}
			} catch (error) {
				console.log(error)
			}
		},
		async uploadFile() {

			let rt = route('file.upload');
			const formData = new FormData();

			formData.append('file', this.file);
			formData.append('tramite_id', this.form.tramite_id);
			formData.append('description', this.form.description_file);


			try {
				const response = await axios.post(rt, formData);
				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
					this.form_archivo.push(response.data.archivo)
					this.form.description_file = ''

					this.file = null
					const fileValue = this.$refs.inputfile;
					fileValue.value = null;
				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
				}
			} catch (error) {
				console.log(error)
			}
		},
		removeNullValues(data) {
			return Object.fromEntries(Object.entries(data).filter(([key, value]) => value !== null && value !== undefined));
		},
		async destroyFamiliar(id) {
			const response = await axios.post(route('persons.destroyFamiliar'), { id: id });

			if (response.status == 200) {
				this.labelType = "success";
				this.toastMessage = response.data.message;

				this.form_familiares = this.form_familiares.filter(item => item.id != id)

			} else {
				this.labelType = "danger";
				this.toastMessage = response.data.message;
			}
		},
		async storeFamiliar() {
			if (this.form_familiares.find(familiar => familiar.person.num_documento === parseInt(this.form_familiar.num_documento,10))) {
				this.labelType = "danger";
				this.toastMessage = "La persona ya se ha ingresado previamente";
			} else {
				if (this.form_familiar.name && this.form_familiar.lastname && this.form_familiar.num_documento && this.form_familiar.fecha_nac && this.form_familiar.parentesco_id) {
					try {
						this.form_familiar.tramite_id = this.form.tramite_id
						this.form_familiar.fecha_nac = (this.form_familiar.fecha_nac) ? new Date(this.form_familiar.fecha_nac).toISOString() : null;

						const response = await axios.post(route('persons.addFamiliar'), this.form_familiar);

						if (response.status == 200) {
							this.labelType = "success";
							this.toastMessage = response.data.message;
							let data = response.data.familiar
							data.person= response.data.person
							data.parentesco= response.data.parentesco
							this.form_familiares.push(data)
							this.showFamiliar = false
							this.textBtnFamiliar = "Agregar Familiar"

						} else {
							this.labelType = "danger";
							this.toastMessage = response.data.message;
						}
					} catch (error) {
						console.log(error)
					}

					this.form_familiar = {}
				} else {
					this.labelType = "danger";
					this.toastMessage = "Debe completar todos los datos";
				}
			}
		},
		addFamiliar() {
			if (this.showFamiliar) {
				this.textBtnFamiliar = "Agregar Familiar";
				this.form_familiar = {};
			} else {
				this.textBtnFamiliar = "Borrar Familiar";
			}
			this.showFamiliar = !this.showFamiliar;
		},
		async editFamiliar(item) {
			console.log(item)
			let formData = new FormData();
			formData.append('contacto_id', item.id);
			formData.append('person_id', item.person_id);
			formData.append('parentesco_id', item.parentesco.id);
			formData.append('name', item.person.name);
			formData.append('lastname', item.person.lastname);
			try {
				const response = await axios.post(route('persons.updateFamiliar'), formData);

				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
					this.form_familiares.find(familiar => familiar.id === item.id).parentesco.description = this.parentescos.find(parentesco => parentesco.id === item.parentesco.id).description
					this.form_familiares.find(familiar => familiar.id === item.id).parentesco.id = item.parentesco.id
				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
				}
			} catch (error) {
				console.log(error)
			} 
		},
		async destroyContacto(id) {
			const response = await axios.post(route('persons.destroyContacto'), { id: id });

			if (response.status == 200) {
				this.labelType = "success";
				this.toastMessage = response.data.message;

				this.form_contactos = this.form_contactos.filter(item => item.id != id)

			} else {
				this.labelType = "danger";
				this.toastMessage = response.data.message;
			}
		},
		async storeContacto() {
			if (this.form_contactos.find(contacto => contacto.person.num_documento === parseInt(this.form_contacto.num_documento,10))) {
				this.labelType = "danger";
				this.toastMessage = "La persona ya se ha ingresado previamente";
			} else {
				if (this.form_contacto.name && this.form_contacto.lastname && this.form_contacto.num_documento && this.form_contacto.fecha_nac && this.form_contacto.parentesco_id && this.form_contacto.phone) {
					try {
						this.form_contacto.tramite_id = this.form.tramite_id
						this.form_contacto.fecha_nac = (this.form_contacto.fecha_nac) ? new Date(this.form_contacto.fecha_nac).toISOString() : null;

						const response = await axios.post(route('persons.addContacto'), this.form_contacto);
						if (response.status == 200) {

							this.labelType = "success";
							///
							this.toastMessage = response.data.message;
							this.form_contactos.push(response.data.contacto) 
							this.showContacto = false
							this.textBtnContacto = "Agregar Contacto"

						} else {
							console.log('NO')
							this.labelType = "danger";
							this.toastMessage = response.data.message;
						}
					} catch (error) {
						console.log(error)
					}

					this.form_contacto = {}
				} else {
					this.labelType = "danger";
					this.toastMessage = "Debe completar todos los datos";
				}
			}
		},
		addContacto() {
			if (this.showContacto) {
				this.textBtnContacto = "Agregar Contacto";
				this.form_contacto = {};
			} else {
				this.textBtnContacto = "Borrar Contacto";
			}
			this.showContacto = !this.showContacto;
		},
		async editContacto(item) {
			let formData = new FormData();
			formData.append('contacto_id', item.id);
			formData.append('person_id', item.person_id);
			formData.append('parentesco_id', item.parentesco.id);
			formData.append('name', item.person.name);
			formData.append('lastname', item.person.lastname);
			formData.append('phone', item.person.contact[0].phone);
			try {
				const response = await axios.post(route('persons.updateContacto'), formData);

				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
					this.form_contactos.find(contacto => contacto.id === item.id).parentesco.description = this.parentescos.find(parentesco => parentesco.id === item.parentesco.id).description
					this.form_contactos.find(contacto => contacto.id === item.id).parentesco.id = item.parentesco.id
				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
				}
			} catch (error) {
				console.log(error)
			} 
		},

	},
	created() {

	},
	computed: {
		barriosComputed: function () {
			/* this.form.barrio_id = this.form.get_barrio_id
			this.form.get_barrio_id = null */
			return this.barrios.filter(barrio => barrio.localidad_id == this.form.localidad_id)
		},
		barriosNinoComputed: function () {
			/* this.form_nino.barrio_id = this.form_nino.get_barrio_id
			this.form_nino.get_barrio_id = null */
			return this.barrios.filter(barrio => barrio.localidad_id == this.form_nino.localidad_id)
		}
	},
	mounted() {
		this.form.tramite_id = this.tramite[0].id

		//console.log(this.tramite[0].persons[0].pivot.rol_tramite_id)
		let titular
		let beneficiario
		titular = (this.tramite[0].persons.filter(person => person.pivot.rol_tramite_id == 1))
		beneficiario = (this.tramite[0].persons.filter(person => person.pivot.rol_tramite_id == 2))

		// Recuperando datos del tramite.
		this.form.tipo_tramite_id = this.tramite[0].tipo_tramite_id
		this.form.canal_atencion_id = this.tramite[0].canal_atencion_id
		this.form.observacion = this.tramite[0].observacion
		this.form.fecha = new Date(this.tramite[0].fecha + "T00:00:00.000-03:00")
		this.form.sede_id = this.tramite[0].sede_id
		this.form.parentesco_id = this.tramite[0].parentesco_id
		if(this.tramite[0].cbi_data){
			this.form.anio_inicio = this.tramite[0].cbi_data.anio_inicio
			this.form.estado_cbi_id = this.tramite[0].cbi_data.estado_cbi_id
			this.form.aut_firmada = this.tramite[0].cbi_data.aut_firmada
			this.form.aut_retirarse = this.tramite[0].cbi_data.aut_retirarse
			this.form.act_esporadicas = this.tramite[0].cbi_data.act_esporadicas
			this.form.aut_uso_imagen = this.tramite[0].cbi_data.aut_uso_imagen
			this.form.act_varias = this.tramite[0].cbi_data.act_varias
			this.form.comedor = this.tramite[0].cbi_data.comedor
			this.form.estado_gabinete_id = this.tramite[0].cbi_data.estado_gabinete_id
		}
			// Archivos
		this.form_archivo = this.tramite[0].archivos
			// Familiares
		this.form_familiares = this.tramite[0].familiares
			// Contactos
		this.form_contactos = this.tramite[0].contactos

		/**
		 * Recuperando datos del titular
		 */
		this.form.person_id = titular[0].id
		this.form.tipo_documento_id = titular[0].tipo_documento_id
		this.form.num_documento = titular[0].num_documento
		this.form.num_cuit = titular[0].num_cuit
		this.form.fecha_nac = titular[0].fecha_nac
		this.form.fecha_nac = new Date(this.form.fecha_nac + "T00:00:00.000-03:00")
		this.form.name = titular[0].name
		this.form.lastname = titular[0].lastname
		this.form.email = titular[0].contact[0].email
		this.form.phone = titular[0].contact[0].phone
		this.form.celular = titular[0].contact[0].celular
		this.form.cant_hijos = titular[0].aditional[0].cant_hijos
		this.form.situacion_conyugal_id = titular[0].aditional[0].situacion_conyugal_id
		this.form.tipo_ocupacion_id = titular[0].social[0].tipo_ocupacion_id
		this.form.cobertura_medica_id = titular[0].social[0].cobertura_medica_id
		this.form.tipo_pension_id = titular[0].social[0].tipo_pension_id
		this.form.nivel_educativo_id = titular[0].education[0].nivel_educativo_id
		this.form.estado_educativo_id = titular[0].education[0].estado_educativo_id
		this.form.calle = titular[0].address[0].calle
		this.form.number = titular[0].address[0].number
		this.form.piso = titular[0].address[0].piso
		this.form.dpto = titular[0].address[0].dpto
		if (titular[0].address[0].latitude && titular[0].address[0].longitude) {
			this.form.latitude = titular[0].address[0].latitude
			this.form.longitude = titular[0].address[0].longitude

			// Carga de datos para visualizar el mapa.
			this.form_temp = {}
			this.form_temp.latitude = parseFloat(titular[0].address[0].latitude)
			this.form_temp.longitude = parseFloat(titular[0].address[0].longitude)
			this.form_temp.route = titular[0].address[0].google_address
			this.form_google = this.form_temp
			this.showMap = true
		}

		this.form.google_address = titular[0].address[0].google_address
		this.form.pais_id = titular[0].address[0].pais_id
		this.form.localidad_id = titular[0].address[0].localidad_id
		this.form.barrio_id = titular[0].address[0].barrio_id
		/**
		 * Fin Datos del Titular
		 */

		 /**
		 * Recuperando datos del Beneficiario
		 */
		this.form_nino.person_id = beneficiario[0].id
		this.form_nino.tipo_documento_id = beneficiario[0].tipo_documento_id
		this.form_nino.num_documento = beneficiario[0].num_documento
		this.form_nino.num_cuit = beneficiario[0].num_cuit
		this.form_nino.fecha_nac = beneficiario[0].fecha_nac
		this.form_nino.fecha_nac = new Date(this.form_nino.fecha_nac + "T00:00:00.000-03:00")
		this.form_nino.name = beneficiario[0].name
		this.form_nino.lastname = beneficiario[0].lastname
		this.form_nino.email = beneficiario[0].contact[0].email
		this.form_nino.phone = beneficiario[0].contact[0].phone
		this.form_nino.celular = beneficiario[0].contact[0].celular
		this.form_nino.nivel_educativo_id = beneficiario[0].education[0].nivel_educativo_id
		this.form_nino.estado_educativo_id = beneficiario[0].education[0].estado_educativo_id

		this.form_nino.escuela_id = beneficiario[0].education[0].escuela_id
		this.form_nino.escuela_infante_id = beneficiario[0].education[0].escuela_infante_id
		this.form_nino.escuela_dependencia_id = beneficiario[0].education[0].escuela_dependencia_id
		this.form_nino.escuela_localidad_id = beneficiario[0].education[0].escuela_localidad_id
		this.form_nino.escuela_nivel_id = beneficiario[0].education[0].escuela_nivel_id
		this.form_nino.escuela_turno_id = beneficiario[0].education[0].escuela_turno_id
		this.form_nino.permanencia = beneficiario[0].education[0].permanencia
		this.form_nino.certificado_escolar = beneficiario[0].education[0].certificado_escolar
		this.form_nino.observacion_educacion = beneficiario[0].education[0].observacion

		if(beneficiario[0].salud){
			this.form_nino.apto_medico = beneficiario[0].salud.apto_medico
			this.form_nino.libreta_vacunacion = beneficiario[0].salud.libreta_vacunacion
			this.form_nino.centro_salud_id = beneficiario[0].salud.centro_salud_id
			this.form_nino.estado_salud_id = beneficiario[0].salud.estado_salud_id
			this.form_nino.observacion_salud = beneficiario[0].salud.observacion
		}

		this.form_nino.calle = beneficiario[0].address[0].calle
		this.form_nino.number = beneficiario[0].address[0].number
		this.form_nino.piso = beneficiario[0].address[0].piso
		this.form_nino.dpto = beneficiario[0].address[0].dpto
		this.form_nino.localidad_id = beneficiario[0].address[0].localidad_id
		this.form_nino.barrio_id = beneficiario[0].address[0].barrio_id
		/**
		 * Fin Datos del Beneficiario
		 */
		 this.form = this.removeNullValues(this.form);
		 this.form_nino = this.removeNullValues(this.form_nino);
	},
}
</script>



