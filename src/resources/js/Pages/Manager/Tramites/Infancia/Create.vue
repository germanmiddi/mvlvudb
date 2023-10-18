
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
							<h3 class="text-lg leading-6 font-medium text-gray-900">
								Declaración Jurada
							</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form.fecha" :enableTimePicker="false" :monthChangeOnScroll="true" autoApply
									:format="format" :style="v$.form.fecha.$error
										? datepickerStyle
										: ''
										">
								</Datepicker>
								<span v-if="v$.form.fecha.$error" class="text-red-500 text-xs">Campo obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="canal_atencion" class="block text-sm font-medium text-gray-700">Canal de
									Atención</label>
								<select v-model="form.canal_atencion_id" id="canal_atencion" name="canal_atencion"
									autocomplete="canal_atencion-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
									:class="v$.form.canal_atencion_id.$error
										? 'border-red-500'
										: ''
										">
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
						</div>
						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_tramite_id" class="block text-sm font-medium text-gray-700">Tipo de
									Tramite</label>
								<select v-model="form.tipo_tramite_id" id="tipo_tramite_id" name="tipo_tramite_id"
									autocomplete="tipo_tramite_id_name"
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
							</div>

							<div class="col-span-12 sm:col-span-9">
								<label for="observacion" class="block text-sm font-medium text-gray-700">Observaciones
								</label>
								<div class="mt-1">
									<textarea v-model="form.observacion" id="observacion" name="observacion" rows="3"
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"
										:class="v$.tramites.$error ? 'border-red-500' : ''" />
								</div>
								<p class="mt-2 text-sm text-gray-500">
									Ingrese información adicional del tramite.
								</p>
							</div>
						</div>
						<div class="flex items-center justify-end flex-wrap sm:flex-nowrap">
							<div class="flex-shrink-0">
								<button type="button"
									class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
									@click="addTramite()">
									Agregar Tramite
								</button>
							</div>
						</div>
						<div class="grid grid-cols-12 gap-12">
							<table class="min-w-full divide-y divide-gray-200 w-full col-span-12">
								<thead class="bg-gray-50">
									<tr>
										<th scope="col"
											class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">
											Tramite
										</th>
										<th scope="col"
											class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8/12">
											Observacion
										</th>
										<th scope="col"
											class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
											Accion
										</th>
									</tr>
								</thead>
								<tbody class="bg-white divide-y divide-gray-200">
									<tr v-for="(tramite, index) in tramites" :key="index">
										<td class="px-6 py-4 whitespace-wrap text-sm font-medium text-gray-900">
											{{ tramite.titulo }}
										</td>
										<td class="px-6 py-4 whitespace-wrap text-sm text-gray-500 text-justify">
											{{ tramite.observacion }}
										</td>
										<td class="px-6 py-4 text-center text-sm font-medium">
											<button type="button"
												class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-red-200 text-red-900 hover:bg-red-600 hover:text-white"
												@click="deleteTramite(tramite)">
												Borrar
											</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<span v-if="v$.tramites.$error" class="text-red-500 text-xs">No ha seleccionado tramites</span>
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
								<select v-model="form_cbi.sede_id" id="sede_id" name="sede_id"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione una sede</option>
									<option v-for="sede in sedes" :key="sede.id"
										:value="sede.id">{{
											sede.description
									}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3 ">
								<label for="anio_inicio" class="block text-sm font-medium text-gray-700">Fecha de
									inicio CBI</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form_cbi.anio_inicio" auto-apply
									year-picker>
								</Datepicker>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="estado_cbi_id" class="block text-sm font-medium text-gray-700">Estado en CBI</label>
								<select v-model="form_cbi.estado_cbi_id" id="estado_cbi_id" name="estado_cbi_id"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione un estado</option>
									<option v-for="estadoCbi in estadosCbi" :key="estadoCbi.id"
										:value="estadoCbi.id">{{
											estadoCbi.description
									}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="aut_firmada" class="block text-sm font-medium text-gray-700">Autorizacion firmada</label>
								<select v-model="form_cbi.aut_firmada" id="aut_firmada" name="aut_firmada"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="aut_retirarse" class="block text-sm font-medium text-gray-700">Autorizacion para retirarse solo</label>
								<select v-model="form_cbi.aut_retirarse" id="aut_retirarse" name="aut_retirarse"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="aut_uso_imagen" class="block text-sm font-medium text-gray-700">Autorizacion uso de imagen</label>
								<select v-model="form_cbi.aut_uso_imagen" id="aut_uso_imagen" name="aut_uso_imagen"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="act_varias" class="block text-sm font-medium text-gray-700">Actividades varias</label>
								<select v-model="form_cbi.act_varias" id="act_varias" name="act_varias"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="act_esporadicas" class="block text-sm font-medium text-gray-700">Actividades esporadicas</label>
								<select v-model="form_cbi.act_esporadicas" id="act_esporadicas" name="act_esporadicas"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="comedor" class="block text-sm font-medium text-gray-700">Comedor</label>
								<select v-model="form_cbi.comedor" id="comedor" name="comedor"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="estado_gabinete_id" class="block text-sm font-medium text-gray-700">Gabinete Psicologico</label>
								<select v-model="form_cbi.estado_gabinete_id" id="estado_gabinete_id" name="estado_gabinete_id"
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

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<!-- <div>
						<h3 class="text-lg leading-6 font-medium text-gray-900"></h3>
					</div> -->
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
									autocomplete="off" :class="v$.form.tipo_documento_id.$error ? 'border-red-500' : input_disable ? bg_disable : ''" :disabled="input_disable"
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
								<input v-model="form.name" type="text" name="name" id="name" autocomplete="name" ref="inputName" 
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.name.$error ? 'border-red-500' : input_disable ? bg_disable : ''" :disabled="input_disable" />
								<span v-if="v$.form.name.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
								<input v-model="form.lastname" type="text" name="lastname" id="lastname" autocomplete="name"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.lastname.$error ? 'border-red-500' : input_disable ? bg_disable : ''" :disabled="input_disable" />
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
									:style="v$.form.fecha_nac.$error ? datepickerStyle : ''" v-model="form.fecha_nac" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
									:enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
								</Datepicker>
								<span v-if="v$.form.fecha_nac.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="email" class="block text-sm font-medium text-gray-700">Mail</label>
								<input v-model="form.email" type="text" name="email" id="email" autocomplete="email" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
								<input v-model="form.phone" type="text" name="phone" id="phone" autocomplete="off" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
								<input v-model="form.celular" type="text" name="celular" id="phone" autocomplete="off" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>
						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_documento_id"
									class="block text-sm font-medium text-gray-700">Vinculo con el Menor</label>
								<select v-model="form.parentesco_id" id="parentesco_id" name="parentesco_id"
									autocomplete="parentesco_id-name" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
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
									autocomplete="localidad_id-name" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione una localidad</option>
									<option v-for="localidad in localidades" :key="localidad.id" :value="localidad.id">{{
										localidad.description
									}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="barrio_id" class="block text-sm font-medium text-gray-700">Barrio</label>
								<select v-model="form.barrio_id" id="barrio_id" name="barrio_id" autocomplete="barrio_id-name" 
							        :disabled="barriosComputed.length === 0 || input_disable"
							        :class="barriosComputed.length === 0 || input_disable ? bg_disable : ''"		
							        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione un barrio</option>
									<option v-for="barrio in barriosComputed" :key="barrio.id"
										:value="barrio.id">{{
												barrio.description
										}}</option>
								</select>
							</div>

						</div>

						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-4 ">
								<label for="calle" class="block text-sm font-medium text-gray-700">Calle</label>
								<input v-model="form.calle" type="text" name="calle" id="calle" autocomplete="calle-level2" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-2 ">
								<label for="number" class="block text-sm font-medium text-gray-700">Número</label>
								<input v-model="form.number" type="text" name="number" id="number"
									autocomplete="number-level2" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-2 ">
								<label for="piso" class="block text-sm font-medium text-gray-700">Piso</label>
								<input v-model="form.piso" type="text" name="piso" id="piso" autocomplete="piso-level2" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-2 ">
								<label for="dpto" class="block text-sm font-medium text-gray-700">Departamento</label>
								<input v-model="form.dpto" type="text" name="dpto" id="dpto" autocomplete="dptolevel2" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>


						</div>
						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-6 ">
								<label for="google_address" class="block text-sm font-medium text-gray-700">Dirección
									Google</label>
								<!-- <input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" /> -->
								<vue-google-autocomplete ref="address" id="map" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
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
								<a @click="this.showMap = !this.showMap" v-show="input_disable"
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
								<select v-model="form.pais_id" id="pais_id" name="pais_id" autocomplete="pais_id-name" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
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
									name="situacion_conyugal_id" autocomplete="situacion_conyugal_id-name" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
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
									autocomplete="address-level2" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
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
									autocomplete="nivel_educativo_id-name" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
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
									name="estado_educativo_id" autocomplete="estado_educativo_id-name" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
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
									autocomplete="tipo_ocupacion_id-name" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
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
									autocomplete="tipo_pension_id-name" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
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
									name="cobertura_medica_id" autocomplete="cobertura_medica_id-name" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
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
									autocomplete="programa_social_id-name" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
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

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<!-- <div>
						<h3 class="text-lg leading-6 font-medium text-gray-900"></h3>
					</div> -->
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Datos del Niño
								</h3>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Tipo de
									Documento</label>
								<select v-model="form_nino.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
									autocomplete="off" :class="v$.form_nino.tipo_documento_id.$error ? 'border-red-500' : input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un tipo de documento
									</option>
									<option v-for="tipoDocumento in tiposDocumento" :key="tipoDocumento.id"
										:value="tipoDocumento.id">
										{{ tipoDocumento.description }}
									</option>
								</select>
								<span v-if="v$.form_nino.tipo_documento_id.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de
									Documento</label>
								<div class="relative">
									<input type="text" v-model="form_nino.num_documento" @keyup.enter="getPersonNino()" :class="v$.form_nino.num_documento.$error ? 'border-red-500' : ''"
										class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
									<a @click="getPersonNino()" 
										class="absolute inset-y-0 right-0 px-4 py-2 bg-green-200 text-white text-xs rounded-r-md hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-600  shadow-sm text-xs font-medium flex items-center  text-green-900 hover:text-white">
										Verificar
									</a>
								</div>
								<span v-if="v$.form_nino.num_documento.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>

							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
								<input v-model="form_nino.name" type="text" name="name" id="name" autocomplete="name" ref="inputNameNino"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form_nino.name.$error ? 'border-red-500' : input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable" />
								<span v-if="v$.form_nino.name.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
								<input v-model="form_nino.lastname" type="text" name="lastname" id="lastname" autocomplete="name"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form_nino.lastname.$error ? 'border-red-500' : input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable" />
								<span v-if="v$.form_nino.lastname.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-3">
								<label for="fecha_nac" class="block text-sm font-medium text-gray-700">Fecha de
									Nacimiento</label>
								<Datepicker
									class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:style="v$.form_nino.fecha_nac.$error ? datepickerStyle : ''" v-model="form_nino.fecha_nac" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
									:enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
								</Datepicker>
								<form_nino v-if="v$.form_nino.fecha_nac.$error" class="text-red-500 text-xs">Campo
									obligatorio</form_nino>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="email" class="block text-sm font-medium text-gray-700">Mail</label>
								<input v-model="form_nino.email" type="text" name="email" id="email" autocomplete="email" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
								<input v-model="form_nino.phone" type="text" name="phone" id="phone" autocomplete="off" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
								<input v-model="form_nino.celular" type="text" name="celular" id="phone" autocomplete="off" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
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
									autocomplete="localidad_id-name" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
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
									autocomplete="barrio_id-name" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
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
									autocomplete="calle-level2" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-2 ">
								<label for="number" class="block text-sm font-medium text-gray-700">Número</label>
								<input v-model="form_nino.number" type="text" name="number" id="number"
									autocomplete="number-level2" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-2 ">
								<label for="piso" class="block text-sm font-medium text-gray-700">Piso</label> 
								<input v-model="form_nino.piso" type="text" name="piso" id="piso" autocomplete="piso-level2" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-2 ">
								<label for="dpto" class="block text-sm font-medium text-gray-700">Departamento</label>
								<input v-model="form_nino.dpto" type="text" name="dpto" id="dpto" autocomplete="dptolevel2" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>


						</div>
						<!-- <div class="grid grid-cols-12 gap-6">

						<div class="col-span-12 sm:col-span-6 ">
							<label for="google_address" class="block text-sm font-medium text-gray-700">Dirección Google</label>
							
							<vue-google-autocomplete ref="address" id="map"
								classname="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
								placeholder="Ingrese la dirección"
								v-on:placechanged="getAddressData">
							</vue-google-autocomplete>
						</div> 
						<div class="col-span-12 sm:col-span-2 ">
							<label for="latitude" class="block text-sm font-medium text-gray-700">Latitud</label>
							<input v-model="form_nino.latitude" type="text" name="latitude" id="latitude" autocomplete="latitude-level2" disabled class="bg-gray-100 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div> 

						<div class="col-span-12 sm:col-span-2 ">
							<label for="longitude" class="block text-sm font-medium text-gray-700">Longitud</label>
							<input v-model="form.longitude" type="text" name="longitude" id="longitude" autocomplete="longitude-level2" disabled class="bg-gray-100 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div> 
						<div class="col-span-12 sm:col-span-2 ">
							<label class="block text-transparent ">Button</label>
							<a @click="this.showMap = !this.showMap" class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Ver Mapa</a>
						</div> 
						<p class="mt-2 text-sm text-gray-500 col-span-12 sm:col-span-12">{{ this.form.google_address }}</p>
						<div class="col-span-12 sm:col-span-12 ">
							<GoogleMap v-if="this.showMap" :form_map="form_google" @coordenadas_google="coord_google">
								
							</GoogleMap>
						</div> 
						
					</div> -->

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
									name="escuela_infante_id" autocomplete="off" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un escuela</option>
									<option v-for="escuela in escuelasInfante" :key="escuela.id" :value="escuela.id">{{
										escuela.description
									}}</option>

								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="escuela_id"
									class="block text-sm font-medium text-gray-700">Escuela Primaria</label>
								<select v-model="form_nino.escuela_id" id="escuela_id"
									name="escuela_id" autocomplete="off" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
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
									name="escuela_dependencia_id" autocomplete="off" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una dependencia</option>
									<option v-for="escuelaDependencia in escuelasDependencias" :key="escuelaDependencia.id" :value="escuelaDependencia.id">{{
										escuelaDependencia.description
									}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="estado_educativo_id"
									class="block text-sm font-medium text-gray-700">Localidad</label>
								<select v-model="form_nino.escuela_localidad_id" id="escuela_localidad_id"
									name="escuela_localidad_id" autocomplete="off" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
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
									name="nivel_educativo_id" autocomplete="nivel_educativo_id-name" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
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
									name="estado_educativo_id" autocomplete="estado_educativo_id-name" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
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
								<select v-model="form_nino.escuela_nivel_id" id="escuela_nivel_id"
									name="escuela_nivel_id" autocomplete="off" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un estado educativo</option>
									<option v-for="escuelaNivel in escuelasNiveles" :key="escuelaNivel.id" :value="escuelaNivel.id">{{
										escuelaNivel.description
									}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="escuela_turno_id"
									class="block text-sm font-medium text-gray-700">Turno</label>
								<select v-model="form_nino.escuela_turno_id" id="escuela_turno_id"
									name="escuela_turno_id" autocomplete="off" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un estado educativo</option>
									<option v-for="escuelaTurno in escuelasTurnos" :key="escuelaTurno.id" :value="escuelaTurno.id">{{
										escuelaTurno.description
									}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="permanencia" class="block text-sm font-medium text-gray-700">Realizo
									permanencia</label>
								<select v-model="form_nino.permanencia" id="permanencia"
									name="permanencia" autocomplete="off" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="certificado_escolar" class="block text-sm font-medium text-gray-700">Certificado
									escolar</label>
								<select v-model="form_nino.certificado_escolar" id="certificado_escolar"
									name="certificado_escolar" autocomplete="off" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>

								</select>
							</div>
						</div>
						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-9">
								<label for="nino_observacion_educacion" class="block text-sm font-medium text-gray-700">Observaciones
								</label>
								<div class="mt-1">
									<textarea v-model="form_nino.observacion_educacion" id="observacion_educacion" name="observacion_educacion" rows="3" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" />
								</div>
								<p class="mt-2 text-sm text-gray-500">Ingrese información adicional sobre la educación del niño.</p>
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
									autocomplete="off" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="libreta_vacunacion" class="block text-sm font-medium text-gray-700">Libreta de vacunación
									presentada</label>
								<select v-model="form_nino.libreta_vacunacion" id="libreta_vacunacion" name="libreta_vacunacion"
									autocomplete="off" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="centro_salud_id" class="block text-sm font-medium text-gray-700">Lugar de
									Atención</label>
								<select v-model="form_nino.centro_salud_id" id="centro_salud_id"
									name="centro_salud_id" autocomplete="off" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un programa social</option>
									<option v-for="centroSalud in centrosSalud" :key="centroSalud.id"
										:value="centroSalud.id">{{
											centroSalud.description
										}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="estado_salud_id" class="block text-sm font-medium text-gray-700">Estado de salud (A tener
									presente)</label>
								<select v-model="form_nino.estado_salud_id" id="estado_salud_id"
									name="estado_salud_id" autocomplete="programa_social_id-name" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
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
									<textarea v-model="form_nino.observacion_salud" id="nino_observacion_salud" name="nino_observacion_salud" rows="3" :class="input_nino_disable ? bg_disable : ''" :disabled="input_nino_disable"
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" />
								</div>
								<p class="mt-2 text-sm text-gray-500">Ingrese información adicional a la salud del niño.</p>
							</div>
						</div>
					</div>
				</div>

				<FormFamiliar v-show="!input_disable" :parentescos="parentescos" :tiposDocumento="tiposDocumento" :txtFamiliar="'Vinculo con el Menor'" @data_familiares="familiares_data"></FormFamiliar>

				<FormContacto v-show="!input_disable" :parentescos="parentescos" :tiposDocumento="tiposDocumento" @data_contactos="contactos_data"></FormContacto>

				<!-- FIN DATOS DEL NIÑO -->

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 " v-show="!input_disable">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">

						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">Archivos Adjuntos</h3>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-8">
								<label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
								<div class="flex">
									<input v-model="form.description_file" type="text" name="descripcion" id="descripcion"
										autocomplete="off"
										class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-1/2 shadow-sm sm:text-sm border-gray-300 rounded-md mr-6" />
									<input @change="handleFileChange" accept=".jpg, .jpeg, .png, .gif, .pdf" type="file" name="file" id="file" ref="inputfile"
										autocomplete="off"
										class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-1/2 rounded-md" />
										<div class="flex-shrink-0">
											<button @click="addFile()" type="button"
											class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">
											Agregar Archivo
										</button>
									</div>
								</div>
								<p v-show="this.fileInvalid" class="mt-2 text-red-500 text-xs"> - Por favor, seleccione un archivo de imagen o PDF.</p>
							</div>
							<div class="col-span-12 sm:col-span-12">
							<table class="min-w-full divide-y divide-gray-200 w-full col-span-6 sm:col-span-12 ">
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
                                    	{{file.description}}
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
				</div>
			</form>
		</div>

		<div class="px-4 mt-6 sm:px-6 lg:px-8 flex justify-end w-full">
			<button
					class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"
					:class="btnGuardar ? 'bg-gray-600 hover:bg-gray-700' : 'bg-green-600 hover:bg-green-700'"
					@click="submit" :disabled="btnGuardar">
					Guardar
				</button>
		</div>
		<ViewFile :file="fileView"  :show="openModal" @closeModal="closeModal" />
	</main>
</template>

<script>
import { ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, helpers, minLength } from '@vuelidate/validators'
import { ArrowLeftCircleIcon } from '@heroicons/vue/24/outline'
import GoogleMap from '@/Layouts/Components/GoogleMap.vue'
import VueGoogleAutocomplete from "vue-google-autocomplete"
import FormBeneficiario from '@/Layouts/Components/Tramites/FormBeneficiario.vue'
import FormFamiliar from '@/Layouts/Components/Tramites/FormFamiliar.vue'
import FormContacto from '@/Layouts/Components/Tramites/FormContacto.vue'
import Toast from "@/Layouts/Components/Toast.vue"
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import ViewFile from "../Detail/ViewFile.vue";
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
		GoogleMap,
		VueGoogleAutocomplete,
		Toast,
		Datepicker,
		FormBeneficiario,
		FormFamiliar,
		FormContacto,
		required,
		useVuelidate,
		helpers,
		minLength,
		ViewFile,
		store
	},
	data() {
		return {
			form: {},
			form_temp: {},
			form_nino: {},
			form_cbi: {},
			form_google: "",
			form_beneficiario: {},
			form_familiares: [],
			form_contactos: [],
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
			input_disable: true,
			input_nino_disable: true,
			fileView: '',
			openModal: false,
			fileInvalid: false
		}
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
			form_nino: {
				tipo_documento_id: { required: helpers.withMessage('El campo Tipo de Documento del Niño es Obligatorio', required) },
				num_documento: { required: helpers.withMessage('El campo N° de documento del Niño es Obligatorio', required) }, // Matches this.contact.email
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

		const format_year = (date) => {
			const year = date.getFullYear();

			return `${year}`;
		}

		return {
			format,
			format_year,
			v$: useVuelidate()
		}
	},
	methods: {
		closeModal() {
            this.openModal = false
        },
		viewFile(data) {
			this.fileView = data
			this.openModal = true
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
			let rt = route('infancia.store');

			const formData = new FormData();

			Object.entries(this.tramites).forEach(([clave, valor]) => {
				formData.append('tramites_id[]', valor.id);
				formData.append('tramites_observacion[]', valor.observacion);
			});

			Object.entries(this.files).forEach(([clave, valor]) => {
				formData.append('files[]', valor.file);
				formData.append('files_descripcion[]', valor.description);
			});

			/* 
			** Se formatea las fechas para que las mismas sean enviadas en formato 
			** Output: 2023-06-22T01:33:00.000Z
			** a traves del formData
			*/

			this.form.fecha = (this.form.fecha) ? new Date(this.form.fecha).toISOString() : null;
			this.form.fecha_nac = (this.form.fecha_nac) ? new Date(this.form.fecha_nac).toISOString() : null;

			for (var clave in this.form) {
				if (this.form.hasOwnProperty(clave)) {
					formData.append(clave, this.form[clave]);
				}
			}

			//this.form_cbi.anio_inicio = (this.form_cbi.anio_inicio) ? new Date(this.form_cbi.anio_inicio).toISOString() : null;
			for (var clave in this.form_cbi) {
				if (this.form_cbi.hasOwnProperty(clave)) {
					formData.append(clave, this.form_cbi[clave]);
				}
			}

			// Datos del Niño
			this.form_nino.fecha_nac = (this.form_nino.fecha_nac) ? new Date(this.form_nino.fecha_nac).toISOString() : null;

			for (var clave in this.form_nino) {
				if (this.form_nino.hasOwnProperty(clave)) {
					formData.append('nino_'+clave, this.form_nino[clave]);
				}
			}

			Object.entries(this.form_familiares).forEach(([clave, valor]) => {
				formData.append('familiar_id[]', valor.id);
				formData.append('familiar_name[]', valor.name);
				formData.append('familiar_lastname[]', valor.lastname);
				formData.append('familiar_num_documento[]', valor.num_documento);
				formData.append('familiar_tipo_documento_id[]', valor.tipo_documento_id);
				formData.append('familiar_fecha_nac[]', valor.fecha_nac);
				formData.append('familiar_parentesco_id[]', valor.parentesco_id);
			});

			Object.entries(this.form_contactos).forEach(([clave, valor]) => {
				formData.append('contacto_id[]', valor.id);
				formData.append('contacto_name[]', valor.name);
				formData.append('contacto_lastname[]', valor.lastname);
				formData.append('contacto_num_documento[]', valor.num_documento);
				formData.append('contacto_tipo_documento_id[]', valor.tipo_documento_id);
				formData.append('contacto_fecha_nac[]', valor.fecha_nac);
				formData.append('contacto_phone[]', valor.phone);
				formData.append('contacto_email[]', valor.email);
				formData.append('contacto_parentesco_id[]', valor.parentesco_id);
			});


			/* this.form_beneficiario.fecha_nac = (this.form_beneficiario.fecha_nac) ? new Date(this.form_beneficiario.fecha_nac).toISOString() : null;
			for (var clave in this.form_beneficiario) {
				if (this.form_beneficiario.hasOwnProperty(clave)) {
					formData.append('beneficiario_' + clave, this.form_beneficiario[clave]);
				}
			} */

			formData.append('beneficiario_control', this.beneficiario_control)

			try {
				const response = await axios.post(rt, formData);
				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
					setTimeout(() => {
						response.data.idTramites.forEach((element) => {
							window.open(
								route("pdf.acusepdf", element),
								"_blank"
							);
						});
					}, 1000)
					setTimeout(() => {
						window.location.href = '/infancia';
					}, 3100)
				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
					this.btnGuardar = false
				}
			} catch (error) {
				console.log(error)
			}

		},
		async getPerson() {
			this.input_disable = false
			this.form_temp.num_documento = this.form.num_documento;
			this.form_temp.tipo_documento_id = this.form.tipo_documento_id;
			this.form_temp.fecha = this.form.fecha;
			this.form_temp.tipo_tramite_id = this.form.tipo_tramite_id;
			this.form_temp.canal_atencion_id = this.form.canal_atencion_id;
			this.form_temp.observacion = this.form.observacion;

			/* DATA DE CBI */

			const get = `${route('persons.getPersonDni', this.form.num_documento)}`
			const response = await fetch(get, { method: 'GET' })
			let data = await response.json()
			if (!data.data.length == 0) {
				this.labelType = "success";
				this.toastMessage = "El DNI indicado se encuentra registrado";

				data = data.data[0].person
				/// Recuperar datos.
				this.form.tipo_documento_id = data.tipo_documento_id
				this.form.fecha_nac = data.fecha_nac
				this.form.fecha_nac = new Date(this.form.fecha_nac + "T00:00:00.000-03:00")
				this.form.name = data.name
				this.form.lastname = data.lastname
				this.form.email = data.contact[0].email
				this.form.phone = data.contact[0].phone
				this.form.celular = data.contact[0].celular
				this.form.cant_hijos = data.aditional[0].cant_hijos
				this.form.situacion_conyugal_id = data.aditional[0].situacion_conyugal_id
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
				this.form.pais_id = data.address[0].pais_id
				this.form.localidad_id = data.address[0].localidad_id
				this.form.barrio_id = data.address[0].barrio_id
				this.form = this.removeNullValues(this.form);
			} else {
				this.labelType = "info";
				this.toastMessage = "El DNI indicado no se encuentra registrado";
				this.form = {}
				this.form = this.form_temp
				this.form_temp = {}
			}
			// FOCUS EN CAMPO NAME.
			const inputRef = this.$refs[`inputName`];
			inputRef.focus();
		},
		removeNullValues(data) {
			return Object.fromEntries(Object.entries(data).filter(([key, value]) => value !== null && value !== undefined));
		},
		async getPersonNino() {
			this.input_nino_disable = false
			let numDoc = this.form_nino.num_documento;
			let tipoDoc = this.form_nino.tipo_documento_id;

			const get = `${route('persons.getPersonDni', this.form_nino.num_documento)}`
			const response = await fetch(get, { method: 'GET' })
			let data = await response.json()
			if (!data.data.length == 0) {
				this.labelType = "success";
				this.toastMessage = "El DNI indicado se encuentra registrado";

				data = data.data[0].person
				/// Recuperar datos.
				this.form_nino.tipo_documento_id = data.tipo_documento_id
				this.form_nino.num_cuit = data.num_cuit
				this.form_nino.fecha_nac = data.fecha_nac
				this.form_nino.fecha_nac = new Date(this.form_nino.fecha_nac + "T00:00:00.000-03:00")
				this.form_nino.name = data.name
				this.form_nino.lastname = data.lastname
				this.form_nino.email = data.contact[0].email
				this.form_nino.phone = data.contact[0].phone
				this.form_nino.celular = data.contact[0].celular
				this.form_nino.cant_hijos = data.aditional[0].cant_hijos
				this.form_nino.situacion_conyugal_id = data.aditional[0].situacion_conyugal_id
				this.form_nino.tipo_ocupacion_id = data.social[0].tipo_ocupacion_id
				this.form_nino.cobertura_medica_id = data.social[0].cobertura_medica_id
				this.form_nino.tipo_pension_id = data.social[0].tipo_pension_id
				this.form_nino.nivel_educativo_id = data.education[0].nivel_educativo_id
				this.form_nino.estado_educativo_id = data.education[0].estado_educativo_id
				this.form_nino.escuela_id = data.education[0].escuela_id
				this.form_nino.escuela_infante_id = data.education[0].escuela_infante_id
				this.form_nino.escuela_dependencia_id = data.education[0].escuela_dependencia_id
				this.form_nino.escuela_localidad_id = data.education[0].escuela_localidad_id
				this.form_nino.anio_curso = data.education[0].anio_curso
				this.form_nino.escuela_turno_id = data.education[0].escuela_turno_id
				this.form_nino.escuela_nivel_id = data.education[0].escuela_nivel_id
				this.form_nino.permanencia = data.education[0].permanencia
				this.form_nino.certificado_escolar = data.education[0].certificado_escolar
				this.form_nino.observacion_educacion = data.education[0].observacion

				if(data.salud){
					this.form_nino.apto_medico = data.salud.apto_medico
					this.form_nino.libreta_vacunacion = data.salud.libreta_vacunacion
					this.form_nino.centro_salud_id = data.salud.centro_salud_id
					this.form_nino.estado_salud_id = data.salud.estado_salud_id
					this.form_nino.observacion_salud = data.salud.observacion
				}

				this.form_nino.calle = data.address[0].calle
				this.form_nino.number = data.address[0].number
				this.form_nino.piso = data.address[0].piso
				this.form_nino.dpto = data.address[0].dpto
				if (data.address[0].latitude && data.address[0].longitude) {
					this.form_nino.latitude = data.address[0].latitude
					this.form_nino.longitude = data.address[0].longitude

					// Carga de datos para visualizar el mapa.
					this.form_temp = {}
					this.form_temp.latitude = parseFloat(data.address[0].latitude)
					this.form_temp.longitude = parseFloat(data.address[0].longitude)
					this.form_temp.route = data.address[0].google_address
					this.form_google_nino = this.form_temp
					this.showMap = true
				}



				this.form_nino.google_address = data.address[0].google_address
				this.form_nino.pais_id = data.address[0].pais_id
				this.form_nino.localidad_id = data.address[0].localidad_id
				this.form_nino.barrio_id = data.address[0].barrio_id
				this.form_nino = this.removeNullValues(this.form_nino);
			} else {
				this.labelType = "info";
				this.toastMessage = "El DNI indicado no se encuentra registrado";
				this.form_nino = {}
				this.form_nino.num_documento = numDoc
				this.form_nino.tipo_documento_id = tipoDoc
			}
			// FOCUS EN CAMPO NAME.
			const inputRef = this.$refs[`inputNameNino`];
			inputRef.focus();
		},
		addBeneficiario() {
			if (this.showBenef) {
				this.textBtnBenef = 'Agregar Beneficiario'
				this.form_beneficiario = {}
				this.beneficiario_control = false
			} else {
				this.beneficiario_control = true
				this.textBtnBenef = 'Borrar Beneficiario'
			}
			this.showBenef = !this.showBenef
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

		/* ********************
		** * MANEJO DE ARCHIVOS
		*/
		handleFileChange(event) {
			this.fileInvalid = false
			const file = event.target.files[0];
			if (file) {
				// Verificar el tipo de archivo
				if (store.isValidFileType(file)) {
					// El archivo es válido
					const reader = new FileReader();
					reader.onload = () => {
						this.selectedFile = reader.result; // Obtiene los datos en Base64 sin la cabecera
					};
					reader.readAsDataURL(file);
				} else {
					// Archivo no válido
					this.selectedFile = null;
					const fileValue = this.$refs.inputfile;
					fileValue.value = null;
					this.selectedFile = null;
					this.fileInvalid = true;
				}
			}
		},
		addFile() {

			if (this.selectedFile && this.form.description_file) {
				this.files.push({
					description: this.form.description_file,
					file: this.selectedFile,
					ext: this.selectedFile.split(",")[0]
				});
				this.selectedFile = null;
				const fileValue = this.$refs.inputfile;
				fileValue.value = null;
				this.form.description_file = "";
			} else {
				this.labelType = "danger";
				this.toastMessage =
					"Debe completar completar los datos del archivo, Verifique si el archivo es valido.";
			}
		},
		deleteFile(index) {
			this.files.splice(index, 1);
		},

		/* 
		** * FIN MANEJO DE ARCHIVOS
		***************************
		*/

		/* ***************************
		** * MANEJO DE TIPO DE TRAMITE
		*/
		addTramite() {
			if (this.tramites.find(tramite => tramite.id === this.form.tipo_tramite_id)) {
				this.labelType = "danger";
				this.toastMessage = "El tipo de tramite ya se ha ingresado previamente";
			} else {
				if (this.form.tipo_tramite_id != '' && this.form.observacion != '') {
					this.tramites.push(
						{
							id: this.form.tipo_tramite_id,
							titulo: this.tiposTramite.find(tramite => tramite.id === this.form.tipo_tramite_id).description,
							observacion: this.form.observacion,
						}
					)
				} else {
					this.labelType = "danger";
					this.toastMessage = "Debe completar todos los datos";
				}
			}
			this.form.tipo_tramite_id = ''
			this.form.observacion = ''
		},
		deleteTramite(index) {
			this.tramites.splice(index, 1);
		},
		/* 
		** * FIN MANEJO DE TIPO DE TRAMITE
		**********************************
		*/

		beneficiario(data) {
			this.form_beneficiario = data;
		},
		familiares_data(data){
			this.form_familiares = data;
		},
		contactos_data(data){
			this.form_contactos = data;
		}

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
		this.form.tipo_tramite_id = ''
		this.form.observacion = ''
	}
}
</script>



