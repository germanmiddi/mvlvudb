<template>
	<main class="flex-1 bg-gray-50 pb-40">
		<!-- Page title & actions -->
		<div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
			<div class="flex-1 min-w-0 flex items-center">
				<a class="btn-blue" :href="route('collections.entrevistas.index')">
					<ArrowLeftCircleIcon class="w-5 h-5 text-purple-700 mr-2" />
				</a>
				<h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Entrevistas Entrega de Cajas</h1>
			</div>
			<div class="mt-4 flex sm:mt-0 sm:ml-4">
				<!-- <button
					class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"
					:class="btnGuardar ? 'bg-gray-400' : 'bg-green-600 hover:bg-green-700'" @click="submit"
					:disabled="btnGuardar">
					Guardar
				</button> -->
				<button
					class="hover:cursor-pointer order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"
					:class="loading ? 'bg-gray-400 hover:bg-gray-400' : 'bg-green-600 hover:bg-green-700'"
					@click="submit" :disabled="loading">
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
								<select v-model="form.sede_id" id="sede_id" name="sede_id" autocomplete="off"
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
									:class="v$.form.tipo_documento_id.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable"
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

								<div class="relative">
									<input type="text" v-model="form.num_documento" @keyup.enter="getPerson()"
										:class="v$.form.num_documento.$error ? 'border-red-500' : ''"
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
									ref="inputName"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.name.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable" />
								<span v-if="v$.form.name.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
								<input v-model="form.lastname" type="text" name="lastname" id="lastname"
									autocomplete="name"
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
									autocomplete="localidad_id-name" :disabled="input_disable"
									:class="input_disable ? bg_disable : ''"
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
									autocomplete="barrio_id-name"
									:disabled="barriosComputed.length === 0 || input_disable"
									:class="barriosComputed.length === 0 || input_disable ? bg_disable : ''"
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
									autocomplete="calle-level2" :disabled="input_disable"
									:class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-2 ">
								<label for="number" class="block text-sm font-medium text-gray-700">Número</label>
								<input v-model="form.number" type="text" name="number" id="number"
									autocomplete="number-level2" :disabled="input_disable"
									:class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-2 ">
								<label for="piso" class="block text-sm font-medium text-gray-700">Piso</label>
								<input v-model="form.piso" type="text" name="piso" id="piso" autocomplete="piso-level2"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-2 ">
								<label for="dpto" class="block text-sm font-medium text-gray-700">Departamento</label>
								<input v-model="form.dpto" type="text" name="dpto" id="dpto" autocomplete="dptolevel2"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>


						</div>
						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-6 ">
								<label for="google_address" class="block text-sm font-medium text-gray-700">Dirección
									Google</label>
								<!-- <input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" /> -->
								<vue-google-autocomplete ref="address" id="map" :disabled="input_disable"
									:class="input_disable ? bg_disable : ''"
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
								<a @click="this.showMap = !this.showMap" v-show="!input_disable"
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
							<div class="col-span-12 sm:col-span-3">
								<label for="pais_id" class="block text-sm font-medium text-gray-700">Pais de
									Origen</label>
								<select v-model="form.pais_id" id="pais_id" name="pais_id" autocomplete="pais_id-name"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un pais</option>
									<option v-for="pais in paises" :key="pais.id" :value="pais.id"
										:bind:select="pais.id == form.pais_id">{{
											pais.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="situacion_conyugal_id"
									class="block text-sm font-medium text-gray-700">Situación Conyugal</label>
								<select v-model="form.situacion_conyugal_id" id="situacion_conyugal_id"
									name="situacion_conyugal_id" autocomplete="situacion_conyugal_id-name"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
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
									autocomplete="address-level2" :disabled="input_disable"
									:class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
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
							<div class="col-span-12 sm:col-span-3">
								<label for="vive_solo" class="block text-sm font-medium text-gray-700">Vive Solo</label>
								<input v-model="form.vive_solo" type="text" name="vive_solo" id="vive_solo"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="cant_convivientes" class="block text-sm font-medium text-gray-700">Cant.
									Convivientes</label>
								<input v-model="form.cant_convivientes" type="number" name="cant_convivientes"
									id="cant_convivientes" autocomplete="cant_convivientes-level2"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="tenencia" class="block text-sm font-medium text-gray-700 ">Tipo
									tenencia</label>

								<div class="space-y-2 mt-1">
									<select v-model="form.tenencia" id="tenencia" name="tenencia"
										autocomplete="tenencia-name" :disabled="input_disable"
										:class="input_disable ? bg_disable : ''"
										class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
										<option disabled value="">Selecciones una tenencia</option>
										<option value="propia">Propia</option>
										<option value="alquilada">Alquilada</option>
										<option value="cedida">Cedida</option>
									</select>
								</div>

							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="ambientes" class="block text-sm font-medium text-gray-700">Cant.
									ambientes</label>
								<input v-model="form.ambientes" type="number" name="ambientes" id="ambientes"
									autocomplete="ambientes-level2" :disabled="input_disable"
									:class="input_disable ? bg_disable : ''"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="pago_inquilino" class="block text-sm font-medium text-gray-700">Es
									Inquilino: Cuanto paga?</label>
								<input v-model="form.pago_inquilino" type="number" name="pago_inquilino"
									id="pago_inquilino" autocomplete="pago_inquilino-level2" :disabled="input_disable"
									:class="input_disable ? bg_disable : ''"
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
							<div class="col-span-12 sm:col-span-3">
								<label for="nivel_educativo_id" class="block text-sm font-medium text-gray-700">Nivel
									educativo en curso</label>
								<select v-model="form.nivel_educativo_id" id="nivel_educativo_id"
									name="nivel_educativo_id" autocomplete="nivel_educativo_id-name"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
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
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
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
							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_ocupacion_id"
									class="block text-sm font-medium text-gray-700">Ocupación</label>
								<select v-model="form.tipo_ocupacion_id" id="tipo_ocupacion_id" name="tipo_ocupacion_id"
									autocomplete="tipo_ocupacion_id-name" :disabled="input_disable"
									:class="input_disable ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una ocupacion</option>
									<option v-for="tipoOcupacion in tiposOcupacion" :key="tipoOcupacion.id"
										:value="tipoOcupacion.id"
										:bind:select="tipoOcupacion.id == form.tipo_ocupacion_id">{{
											tipoOcupacion.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_ocupacion_id" class="block text-sm font-medium text-gray-700">Ingresos
								</label>
								<input v-model="form.ingresos_trabajo" id="ingresos_trabajo" name="ingresos_trabajo"
									type="number" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
							</div>

						</div>
						<div class="grid grid-cols-12 gap-6">


							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_pension_id" class="block text-sm font-medium text-gray-700">Percibe
									Jubilación / Pensión</label>
								<select v-model="form.tipo_pension_id" id="tipo_pension_id" name="tipo_pension_id"
									autocomplete="tipo_pension_id-name" :disabled="input_disable"
									:class="input_disable ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un tipo de pension</option>
									<option v-for="tipoPension in tiposPension" :key="tipoPension.id"
										:value="tipoPension.id" :bind:select="tipoPension.id == form.tipo_pension_id">{{
											tipoPension.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_ocupacion_id" class="block text-sm font-medium text-gray-700">Ingresos
								</label>
								<input v-model="form.ingresos_planes" id="ingresos_planes" name="ingresos_planes"
									type="number" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
							</div>
						</div>
					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">Datos Adicionales</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="cobertura_medica_id"
									class="block text-sm font-medium text-gray-700">Cobertura de Salud</label>
								<select v-model="form.cobertura_medica_id" id="cobertura_medica_id"
									name="cobertura_medica_id" autocomplete="cobertura_medica_id-name"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un tipo de cobertura medica</option>
									<option v-for="coberturaMedica in coberturasMedica" :key="coberturaMedica.id"
										:value="coberturaMedica.id"
										:bind:select="coberturaMedica.id == form.cobertura_medica_id">{{
											coberturaMedica.description
										}}</option>
								</select>
							</div>

							<!-- <div class="col-span-12 sm:col-span-3">
								<label for="programa_social_id" class="block text-sm font-medium text-gray-700">Recibe
									Programa Social</label>
								<select v-model="form.programa_social_id" id="programa_social_id"
									name="programa_social_id" autocomplete="programa_social_id-name"
									:disabled="input_disable" :class="input_disable ? bg_disable : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un programa social</option>
									<option v-for="programaSocial in programasSocial" :key="programaSocial.id"
										:value="programaSocial.id"
										:bind:select="programaSocial.id == form.programa_social_id">{{
											programaSocial.description
										}}</option>
								</select>
							</div> -->

							<div class="col-span-12 sm:col-span-4">
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
										:disabled="input_disable" :class="input_disable ? bg_disable : ''"
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
							<div class="col-span-12 sm:col-span-6">
								<label for="message" class="block text-sm font-semibold leading-6 text-gray-900 mb-2">
									Programas seleccionados</label>
								<span v-for="(programa, index) in this.programasSelected" :key="index"
									class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-700/10 mr-2 mb-2">
									{{ programa.description }}
									<TrashIcon @click="removePrograma(programa.id)" class="h-5 w-5 text-red-700 ml-2" />
								</span>
							</div>
						</div>
					</div>
				</div>

			</form>
		</div>

		<div class="px-4 mt-6 sm:px-6 lg:px-8 flex justify-end w-full">
			<!-- <button
				class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"
				:class="btnGuardar ? 'bg-gray-600 hover:bg-gray-700' : 'bg-green-600 hover:bg-green-700'"
				@click="submit" :disabled="btnGuardar || input_disable">
				Guardar
			</button> -->

			<button
				class="hover:cursor-pointer order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"
				:class="loading ? 'bg-gray-400 hover:bg-gray-400' : 'bg-green-600 hover:bg-green-700'" @click="submit"
				:disabled="loading">
				Guardar
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
// import FormBeneficiario from '@/Layouts/Components/Tramites/FormBeneficiario.vue'
import Toast from "@/Layouts/Components/Toast.vue"
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
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
		puntosEntrega: Object,
		entrevistadores: Object
	},
	components: {
		ArrowLeftCircleIcon,
		GoogleMap,
		VueGoogleAutocomplete,
		Toast,
		Datepicker,
		// FormBeneficiario,
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
			tenencias: [
				{ id: 1, description: 'Propia' },
				{ id: 2, description: 'Alquilada' },
				{ id: 3, description: 'Cedida' },
			],
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
			input_disable: true,
			openModal: false,
			programaSelect: '',
			programasSelected: [],

		}
	},
	validations() {
		return {
			form: {
				entrevistador_id: { required: helpers.withMessage('El campo Entrevistador es Obligatorio', required) },
				sede_id: { required: helpers.withMessage('El campo Sede es Obligatorio', required) },
				fecha_entrevista: { required: helpers.withMessage('El campo Fecha de Entrevista es Obligatorio', required) },

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

		async submit() {
			const result = await this.v$.$validate()
			if (!result) {
				return
			}
			this.btnGuardar = true
			this.loading = true
			let rt = route('collections.entrevistas.store');

			const formData = new FormData();

			this.form.fecha_entrevista = (this.form.fecha_entrevista) ? new Date(this.form.fecha_entrevista).toISOString() : null;
			this.form.fecha_nac = (this.form.fecha_nac) ? new Date(this.form.fecha_nac).toISOString() : null;

			this.form.selected_programs = [];
			this.form.selected_programs = this.programasSelected.map((item) => item.id);

			for (var clave in this.form) {
				if (this.form.hasOwnProperty(clave)) {
					formData.append(clave, this.form[clave]);
				}
			}

			console.log(formData)

			try {
				const response = await axios.post(rt, formData);
				console.log(response)

				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
					// setTimeout(()=> { 
					// 	response.data.idTramites.forEach(element => {
					// 		console.log(element)
					// 		window.open(route('pdf.acusepdf',element), '_blank');
					// 	});
					// }, 1000)

					this.loading = false

					// setTimeout(() => {
					// 	window.location.href = '/collections/entrevistas';
					// }, 2500)

				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
					this.btnGuardar = false
					this.loading = false
				}
			} catch (error) {
				console.log(error)
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

		async getPerson() {
			this.form_temp.num_documento = this.form.num_documento;
			this.form_temp.tipo_documento_id = this.form.tipo_documento_id;
			this.form_temp.fecha = this.form.fecha;

			this.form_temp.entrevistador_id = this.form.entrevistador_id
			this.form_temp.sede_id = this.form.sede_id
			this.form_temp.fecha_entrevista = this.form.fecha_entrevista

			const get = `${route('persons.getPersonDni', this.form.num_documento)}`
			const response = await fetch(get, { method: 'GET' })
			let data = await response.json()
			if (!data.data.length == 0) {
				this.labelType = "success";
				this.toastMessage = "El DNI indicado se encuentra registrado";

				data = data.data[0].person


				if (data.entrevista) {
					this.labelType = "danger";
					this.toastMessage = "El DNI ya posee una entrevista registrada";

					this.input_disable = true;
					return
				} else {

					/// Recuperar datos.
					this.form.tipo_documento_id = data.tipo_documento_id
					this.form.num_cuit = data.num_cuit
					this.form.fecha_nac = data.fecha_nac
					this.form.fecha_nac = new Date(this.form.fecha_nac + "T00:00:00.000-03:00")
					this.form.name = data.name
					this.form.lastname = data.lastname
					this.form.email = data.contact[0].email
					this.form.phone = data.contact[0].phone
					this.form.celular = data.contact[0].celular

					this.form.cant_hijos = data.aditional[0].cant_hijos
					this.form.situacion_conyugal_id = data.aditional[0].situacion_conyugal_id
					this.form.pais_id = data.aditional[0].nacionalidad


					this.form.tipo_ocupacion_id = data.social[0].tipo_ocupacion_id
					this.form.cobertura_medica_id = data.social[0].cobertura_medica_id
					this.form.programa_social_id = data.social[0].programa_social_id
					this.form.tipo_pension_id = data.social[0].tipo_pension_id
					this.form.nivel_educativo_id = data.education[0].nivel_educativo_id
					this.form.estado_educativo_id = data.education[0].estado_educativo_id
					this.form.calle = data.address[0].calle
					this.form.number = data.address[0].number
					this.form.piso = data.address[0].piso
					this.form.dpto = data.address[0].dpto
					if (data.address[0].latitude && data.address[0].longitude) {
						this.form.latitude = data.address[0].latitude
						this.form.longitude = data.address[0].longitude

						// Carga de datos para visualizar el mapa.
						this.form_temp = {}
						this.form_temp.latitude = parseFloat(data.address[0].latitude)
						this.form_temp.longitude = parseFloat(data.address[0].longitude)
						this.form_temp.route = data.address[0].google_address
						this.form_google = this.form_temp
						this.showMap = true
					}

					this.form.google_address = data.address[0].google_address
					this.form.localidad_id = data.address[0].localidad_id
					this.form.barrio_id = data.address[0].barrio_id
					this.form = this.removeNullValues(this.form);

				}

			} else {
				this.labelType = "info";
				this.toastMessage = "El DNI indicado no se encuentra registrado";
				this.form = {}
				this.form = this.form_temp
				this.form_temp = {}
			}
			this.input_disable = false

		},
		removeNullValues(data) {
			return Object.fromEntries(Object.entries(data).filter(([key, value]) => value !== null && value !== undefined));
		},


		/* ***********************
		** * MANEJO DE GOOGLE MAPS
		*/
		getAddressData: function (addressData, placeResultData, id) {
			this.form.google_address = placeResultData['formatted_address']
			this.form.latitude = addressData['latitude']
			this.form.longitude = addressData['longitude']

			console.log(typeof addressData['route']);

			this.form_google = addressData

			this.showMap = true
		},
		coord_google($coord) {
			this.form.latitude = $coord.position.lat
			this.form.longitude = $coord.position.lng
			this.form.google_address = $coord.address

			// TODO: Mapa: Ver como cargar el nombre de la calle en el Auto-complete-google
		},

		/* 
		** * FIN MANEJO DE GOOGLE MAPS
		******************************
		*/



	},
	computed: {
		barriosComputed: function () {
			/* this.form.barrio_id = this.form.get_barrio_id
			this.form.get_barrio_id = null */
			return this.barrios.filter(barrio => barrio.localidad_id == this.form.localidad_id)
		}
	},

}
</script>
