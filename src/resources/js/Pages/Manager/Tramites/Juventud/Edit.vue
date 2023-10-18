
<template>
	<main class="flex-1 bg-gray-50 pb-40">
		<!-- Page title & actions -->
		<div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
			<div class="flex-1 min-w-0 flex items-center">
				<a class="btn-blue" :href="route('juventud')">
					<ArrowLeftCircleIcon class="w-5 h-5 text-purple-700 mr-2" />
				</a>
				<h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Nuevo Tramite Centros Barriales Juventud
					| CBJ</h1>
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
				<p v-for="error of v$.form_beneficiario.$errors" :key="error.$uid">
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
									>
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
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"/>
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
										<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
											{{ tramite.titulo }}
										</td>
										<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
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
					</div>
				</div>

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">Datos del Centro Barrial Juventud |
									CBJ</h3>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="sede_id" class="block text-sm font-medium text-gray-700">Sede</label>
								<select v-model="form_tramite.sede_id" id="sede_id" name="sede_id" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione una sede</option>
									<option v-for="sede in sedes" :key="sede.id" :value="sede.id">{{
										sede.description
									}}</option>

								</select>
							</div>

							<div class="col-span-12 sm:col-span-3 ">
								<label for="anio_inicio" class="block text-sm font-medium text-gray-700">Año de
									inicio CBJ</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form_tramite.anio_inicio" auto-apply year-picker>
								</Datepicker>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="estado_cbj_id" class="block text-sm font-medium text-gray-700">Estado en
									CBJ</label>
								<select v-model="form_tramite.estado_cbj_id" id="estado_cbj_id" name="estado_cbj_id"
									autocomplete="estado_cbj_id"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione un estado</option>
									<option v-for="estadocbj in estadosCbj" :key="estadocbj.id" :value="estadocbj.id">{{
										estadocbj.description
									}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="comedor_id" class="block text-sm font-medium text-gray-700">Inscripcion a
									Comedor</label>
								<select v-model="form_tramite.comedor_id" id="comedor_id" name="comedor_id" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione un Comedor</option>
									<option v-for="comedor in comedores" :key="comedor.id" :value="comedor.id">{{
										comedor.description
									}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="actividad_cbj_id" class="block text-sm font-medium text-gray-700">Actividades en
									CBJ</label>
								<select v-model="form_tramite.actividad_cbj_id" id="actividad_cbj_id" name="actividad_cbj_id"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione una actividad</option>
									<option v-for="actividadCbj in actividadesCbj" :key="actividadCbj.id"
										:value="actividadCbj.id">{{
											actividadCbj.description
										}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="apoyo_escolar" class="block text-sm font-medium text-gray-700">Apoyo
									Escolar</label>
								<select v-model="form_tramite.apoyo_escolar" id="apoyo_escolar" name="apoyo_escolar"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione una opcion</option>
									<option value="1" selected>Activo</option>
									<option value="0" selected>Inactivo</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="act_empleo" class="block text-sm font-medium text-gray-700">Actividades por area
									de empleo</label>
								<select v-model="form_tramite.act_empleo" id="act_empleo" name="act_empleo" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione una opcion</option>
									<option value="1" selected>Activo</option>
									<option value="0" selected>Inactivo</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="acompanamiento_cbj_id"
									class="block text-sm font-medium text-gray-700">Acompañamiento CBJ</label>
								<select v-model="form_tramite.acompanamiento_cbj_id" id="acompanamiento_cbj_id"
									name="acompanamiento_cbj_id" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione un Acompañamiento</option>
									<option v-for="acompanamientoCbj in acompanamientosCbj" :key="acompanamientoCbj.id"
										:value="acompanamientoCbj.id">{{
											acompanamientoCbj.description
										}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="aut_firmada" class="block text-sm font-medium text-gray-700">Autorizacion Firmada</label>
								<select v-model="form_tramite.aut_firmada" id="aut_firmada" name="aut_firmada"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1">Si</option>
									<option value="0">No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="aut_retirarse" class="block text-sm font-medium text-gray-700">Autorizacion para retirarse solo</label>
								<select v-model="form_tramite.aut_retirarse" id="aut_retirarse" name="aut_retirarse"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1">Si</option>
									<option value="0">No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="aut_uso_imagen" class="block text-sm font-medium text-gray-700">Autorizacion uso de imagen</label>
								<select v-model="form_tramite.aut_uso_imagen" id="aut_uso_imagen" name="aut_uso_imagen"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1">Si</option>
									<option value="0">No</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="certificado_escolar" class="block text-sm font-medium text-gray-700">Certificado Escolar año en curso</label>
								<select v-model="form_tramite.certificado_escolar" id="certificado_escolar" name="certificado_escolar"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1">Si</option>
									<option value="0">No</option>
								</select>
							</div>

						</div>
					</div>
				</div>

				<!-- DATOS DEL TITULAR.. -->

				<div v-if="isMayor != ''" class="shadow sm:rounded-md sm:overflow-hidden mt-6">
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
									autocomplete="off" :class="v$.form.tipo_documento_id.$error ? 'border-red-500' : ''"
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
								<input v-model="form.num_documento" @focusout="getPerson()" type="text" name="num_documento"
									id="num_documento" autocomplete="level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 bg-gray-100 rounded-md"
									:class="v$.form.num_documento.$error ? 'border-red-500' : ''" disabled/>
								<span v-if="v$.form.num_documento.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>

							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
								<input v-model="form.name" type="text" name="name" id="name" autocomplete="name"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form.name.$error ? 'border-red-500' : ''" />
								<span v-if="v$.form.name.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
								<input v-model="form.lastname" type="text" name="lastname" id="lastname" autocomplete="name"
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
								<input v-model="form.email" type="text" name="email" id="email" autocomplete="email"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
								<input v-model="form.phone" type="text" name="phone" id="phone" autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
								<input v-model="form.celular" type="text" name="celular" id="phone" autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>
					</div>
				</div>

				<div v-if="isMayor != ''" class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
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

				<div v-if="isMayor != ''" class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
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

				<div v-if="isMayor != ''" class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
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

				<div v-if="isMayor != ''" class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
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

				<!-- DATOS DEL NIÑO.. -->

				<div v-if="isMayor == 'Menor'" class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">
									Datos del Beneficiario
								</h3>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Tipo de
									Documento</label>
								<select v-model="form_beneficiario.tipo_documento_id" id="tipo_documento_id"
									name="tipo_documento_id" autocomplete="off"
									:class="v$.form.tipo_documento_id.$error ? 'border-red-500' : ''"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un tipo de documento
									</option>
									<option v-for="tipoDocumento in tiposDocumento" :key="tipoDocumento.id"
										:value="tipoDocumento.id">
										{{ tipoDocumento.description }}
									</option>
								</select>
								<span v-if="v$.form_beneficiario.tipo_documento_id.$error"
									class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de
									Documento</label>
								<input v-model="form_beneficiario.num_documento" @focusout="getPersonBenef()" type="text"
									name="num_documento" id="num_documento" autocomplete="level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 bg-gray-100 rounded-md"
									:class="v$.form_beneficiario.num_documento.$error ? 'border-red-500' : ''" disabled/>
								<span v-if="v$.form_beneficiario.num_documento.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>

							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
								<input v-model="form_beneficiario.name" type="text" name="name" id="name"
									autocomplete="name"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form_beneficiario.name.$error ? 'border-red-500' : ''" />
								<span v-if="v$.form_beneficiario.name.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
								<input v-model="form_beneficiario.lastname" type="text" name="lastname" id="lastname"
									autocomplete="name"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v$.form_beneficiario.lastname.$error ? 'border-red-500' : ''" />
								<span v-if="v$.form_beneficiario.lastname.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-3">
								<label for="fecha_nac" class="block text-sm font-medium text-gray-700">Fecha de
									Nacimiento</label>
								<Datepicker
									class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:style="v$.form_beneficiario.fecha_nac.$error ? datepickerStyle : ''"
									v-model="form_beneficiario.fecha_nac" :enableTimePicker="false"
									:monthChangeOnScroll="false" autoApply :format="format">
								</Datepicker>
								<span v-if="v$.form_beneficiario.fecha_nac.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="email" class="block text-sm font-medium text-gray-700">Mail</label>
								<input v-model="form_beneficiario.email" type="text" name="email" id="email"
									autocomplete="email"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-3">
								<label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
								<input v-model="form_beneficiario.phone" type="text" name="phone" id="phone"
									autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
								<input v-model="form_beneficiario.celular" type="text" name="celular" id="phone"
									autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>
					</div>
				</div>

				<div v-if="isMayor == 'Menor'" class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 class="text-lg leading-6 font-medium text-gray-900">Dirección | Beneficiario</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="localidad_id" class="block text-sm font-medium text-gray-700">Localidad</label>
								<select v-model="form_beneficiario.localidad_id" id="localidad_id" name="localidad_id"
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
								<select v-model="form_beneficiario.barrio_id" id="barrio_id" name="barrio_id"
									autocomplete="barrio_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>Seleccione un barrio</option>
									<option v-for="barrio in barriosBenefComputed" :key="barrio.id" :value="barrio.id">{{
										barrio.description
									}}</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-4 ">
								<label for="calle" class="block text-sm font-medium text-gray-700">Calle</label>
								<input v-model="form_beneficiario.calle" type="text" name="calle" id="calle"
									autocomplete="calle-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-2 ">
								<label for="number" class="block text-sm font-medium text-gray-700">Número</label>
								<input v-model="form_beneficiario.number" type="text" name="number" id="number"
									autocomplete="number-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-2 ">
								<label for="piso" class="block text-sm font-medium text-gray-700">Piso</label>
								<input v-model="form_beneficiario.piso" type="text" name="piso" id="piso"
									autocomplete="piso-level2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

							<div class="col-span-12 sm:col-span-2 ">
								<label for="dpto" class="block text-sm font-medium text-gray-700">Departamento</label>
								<input v-model="form_beneficiario.dpto" type="text" name="dpto" id="dpto"
									autocomplete="dptolevel2"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>
					</div>
				</div>

				<!-- FIN DATOS DEL NIÑO -->

				<div v-if="isMayor != ''" class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 v-if="isMayor == 'Mayor'" class="text-lg leading-6 font-medium text-gray-900">Estudios |
								Titular</h3>
							<h3 v-if="isMayor == 'Menor'" class="text-lg leading-6 font-medium text-gray-900">Estudios |
								Beneficiario</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="nivel_educativo_id" class="block text-sm font-medium text-gray-700">Nivel
									educativo en curso</label>
								<select v-model="form_education.nivel_educativo_id" id="nivel_educativo_id"
									name="nivel_educativo_id" autocomplete="nivel_educativo_id-name"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un nivel educativo</option>
									<option v-for="nivelEducativo in nivelesEducativo" :key="nivelEducativo.id"
										:value="nivelEducativo.id">{{
											nivelEducativo.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="estado_educativo_id" class="block text-sm font-medium text-gray-700">Nivel
									educativo alcanzado</label>
								<select v-model="form_education.estado_educativo_id" id="estado_educativo_id"
									name="estado_educativo_id" autocomplete="off"
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
								<label for="escuela_primaria_id" class="block text-sm font-medium text-gray-700">Escuela
									Primaria</label>
								<select v-model="form_education.escuela_primaria_id" id="escuela_primaria_id"
									name="escuela_primaria_id" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una escuela</option>
									<option v-for="escuelaPrimaria in escuelasPrimarias" :key="escuelaPrimaria.id"
										:value="escuelaPrimaria.id"
										:bind:select="escuelaPrimaria.id == form.escuela_primaria_id">{{
											escuelaPrimaria.description
										}}</option>
								</select>
							</div>
						</div>
						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="escuela_secundaria_id" class="block text-sm font-medium text-gray-700">Escuela
									Secundaria</label>
								<select v-model="form_education.escuela_secundaria_id" id="escuela_secundaria_id"
									name="escuela_secundaria_id" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una escuela</option>
									<option v-for="escuelaSecundaria in escuelasSecundarias" :key="escuelaSecundaria.id"
										:value="escuelaSecundaria.id"
										:bind:select="escuelaSecundaria.id == form.escuela_secundaria_id">{{
											escuelaSecundaria.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3 ">
								<label for="orientacion_secundario_id"
									class="block text-sm font-medium text-gray-700">Orientación</label>
								<select v-model="form_education.orientacion_secundario_id" id="orientacion_secundario_id"
									name="orientacion_secundario_id" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una orientacion</option>
									<option v-for="orientacion in orientaciones" :key="orientacion.id"
										:value="orientacion.id"
										:bind:select="orientacion.id == form.orientacion_secundario_id">{{
											orientacion.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="nivel_secundario_id" class="block text-sm font-medium text-gray-700">Nivel en
									Curso</label>
								<select v-model="form_education.nivel_secundario_id" id="nivel_secundario_id"
									name="nivel_secundario_id" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una escuela</option>
									<option v-for="estadoEducativo in estadosEducativo" :key="estadoEducativo.id"
										:value="estadoEducativo.id">{{
											estadoEducativo.description
										}}</option>
								</select>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="escuela_nocturna_id"
									class="block text-sm font-medium text-gray-700">Terminalidad Educativa</label>
								<select v-model="form_education.escuela_nocturna_id" id="escuela_nocturna_id"
									name="escuela_nocturna_id" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una escuela</option>
									<option v-for="escuelaNocturna in escuelasNocturnas" :key="escuelaNocturna.id"
										:value="escuelaNocturna.id"
										:bind:select="escuelaNocturna.id == form.escuela_nocturna_id">{{
											escuelaNocturna.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="dependencia_nocturno_id"
									class="block text-sm font-medium text-gray-700">Dependencia</label>
								<select v-model="form_education.dependencia_nocturno_id" id="dependencia_nocturno_id"
									name="dependencia_nocturno_id" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una escuelaDependencia</option>
									<option v-for="escuelaDependencia in escuelasDependencias" :key="escuelaDependencia.id"
										:value="escuelaDependencia.id"
										:bind:select="escuelaDependencia.id == form.escuelaDependencia">{{
											escuelaDependencia.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="turno_nocturno_id" class="block text-sm font-medium text-gray-700">Turno</label>
								<select v-model="form_education.turno_nocturno_id" id="turno_nocturno_id"
									name="turno_nocturno_id" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones una escuela</option>
									<option v-for="escuelaTurno in escuelasTurnos" :key="escuelaTurno.id"
										:value="escuelaTurno.id" :bind:select="escuelaTurno.id == form.turno_nocturno_id">{{
											escuelaTurno.description
										}}</option>
								</select>
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="terciario" class="block text-sm font-medium text-gray-700">Estudios
									Terciarios</label>
								<select v-model="form_education.terciario" id="terciario" name="terciario"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3 ">
								<label for="name_terciaria" class="block text-sm font-medium text-gray-700">Nombre
									Institución</label>
								<input v-model="form_education.name_terciario" type="text" name="name_terciaria"
									id="name_terciaria" autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-3 ">
								<label for="carrera_terciaria" class="block text-sm font-medium text-gray-700">Nombre
									Carrera</label>
								<input v-model="form_education.carrera_terciario" type="text" name="carrera_terciaria"
									id="carrera_terciaria" autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-3 ">
								<label for="anio_terciario" class="block text-sm font-medium text-gray-700">Año
									Cursada</label>
								<input v-model="form_education.anio_terciario" type="text" name="anio_terciario"
									id="anio_terciario" autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>

						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-3">
								<label for="universitario" class="block text-sm font-medium text-gray-700">Estudios
									Universitarios</label>
								<select v-model="form_education.universitario" id="universitario" name="universitario"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1">Si</option>
									<option value="0">No</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3 ">
								<label for="name_universitaria" class="block text-sm font-medium text-gray-700">Nombre
									Institución</label>
								<input v-model="form_education.name_universitario" type="text" name="name_universitaria"
									id="name_universitaria" autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-3 ">
								<label for="carrera_universitaria" class="block text-sm font-medium text-gray-700">Nombre
									Carrera</label>
								<input v-model="form_education.carrera_universitario" type="text"
									name="carrera_universitaria" id="carrera_universitaria" autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-3 ">
								<label for="anio_universitario" class="block text-sm font-medium text-gray-700">Año
									Cursada</label>
								<input v-model="form_education.anio_universitario" type="text" name="anio_universitario"
									id="anio_universitario" autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
						</div>

					</div>
				</div>

				<div v-if="isMayor != ''" class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
						<div>
							<h3 v-if="isMayor == 'Mayor'" class="text-lg leading-6 font-medium text-gray-900">Salud |
								Titular</h3>
							<h3 v-if="isMayor == 'Menor'" class="text-lg leading-6 font-medium text-gray-900">Salud |
								Beneficiario</h3>
						</div>

						<div class="grid grid-cols-12 gap-6">

							<div class="col-span-12 sm:col-span-3">
								<label for="apto_medico" class="block text-sm font-medium text-gray-700">Apto médico
									presentado</label>
								<select v-model="form_salud.apto_medico" id="apto_medico" name="apto_medico"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1">Si</option>
									<option value="0">No</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="fecha_apto_medico" class="block text-sm font-medium text-gray-700">Fecha Apto
									Médico</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form_salud.fecha_apto_medico" :enableTimePicker="false"
									:monthChangeOnScroll="false" autoApply :format="format">
								</Datepicker>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="electrocardiograma"
									class="block text-sm font-medium text-gray-700">Electrocardiograma presentado</label>
								<select v-model="form_salud.electrocardiograma" id="electrocardiograma"
									name="electrocardiograma" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1">Si</option>
									<option value="0">No</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="fecha_electrocardiograma" class="block text-sm font-medium text-gray-700">Fecha
									Electrocardiograma</label>
								<Datepicker
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="form_salud.fecha_electrocardiograma" :enableTimePicker="false"
									:monthChangeOnScroll="false" autoApply :format="format">
								</Datepicker>
							</div>


							<div class="col-span-12 sm:col-span-3">
								<label for="libreta_vacunacion" class="block text-sm font-medium text-gray-700">Libreta de
									vacunación presentada</label>
								<select v-model="form_salud.libreta_vacunacion" id="libreta_vacunacion"
									name="libreta_vacunacion" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1">Si</option>
									<option value="0">No</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="centro_salud_id" class="block text-sm font-medium text-gray-700">Lugar de
									Atención</label>
								<select v-model="form_salud.centro_salud_id" id="centro_salud_id" name="centro_salud_id"
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
									(A tener presente)</label>
								<select v-model="form_salud.estado_salud_id" id="estado_salud_id" name="estado_salud_id"
									autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="">Selecciones un programa social</option>
									<option v-for="estadoSalud in estadosSalud" :key="estadoSalud.id"
										:value="estadoSalud.id">{{
											estadoSalud.description
										}}</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3">
								<label for="medicacion" class="block text-sm font-medium text-gray-700">Medicación</label>
								<select v-model="form_salud.medicacion" id="medicacion" name="medicacion" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="1" selected>Si</option>
									<option value="0" selected>No</option>
								</select>
							</div>
							<div class="col-span-12 sm:col-span-3 ">
								<label for="name_medicacion" class="block text-sm font-medium text-gray-700">Nombre
									Medicamento</label>
								<input v-model="form_salud.name_medicacion" type="text" name="name_medicacion"
									id="name_medicacion" autocomplete="name_medicacion"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>
							<div class="col-span-12 sm:col-span-3 ">
								<label for="dosis" class="block text-sm font-medium text-gray-700">Dosis Diaria</label>
								<input v-model="form_salud.dosis" type="text" name="dosis" id="dosis" autocomplete="off"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
							</div>

						</div>
						<div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-9">
								<label for="observacion_salud" class="block text-sm font-medium text-gray-700">Observaciones
								</label>
								<div class="mt-1">
									<textarea v-model="form_salud.observacion_salud" id="observacion_salud"
										name="observacion_salud" rows="3"
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" />
								</div>
								<p class="mt-2 text-sm text-gray-500">Ingrese información adicional sobre la salud del
									joven.</p>
							</div>
						</div>
					</div>
				</div>

				<!-- FIN DATOS DEL TITULAR.. -->

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
											:item=familiar @edit-item="editItem" @hide-item="hideItem"
											@destroy-item="destroyItem" />

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
		comedores: Object,
		estadosCbj: Object,
		actividadesCbj: Object,
		acompanamientosCbj: Object,
		sedes: Object,
		escuelasPrimarias: Object,
		escuelasSecundarias: Object,
		escuelasNocturnas: Object,
		orientaciones: Object,
		escuelasTurnos: Object,
		escuelasDependencias: Object,
		centrosSalud: Object,
		estadosSalud: Object,
		tramite: Object,
	},
	components: {
		ArrowLeftCircleIcon,
		ArrowDownCircleIcon,
		GoogleMap,
		VueGoogleAutocomplete,
		Toast,
		Datepicker,
		FormBeneficiario,
		required,
		useVuelidate,
		helpers,
		minLength,
		ListFamiliar,
		store
	},
	data() {
		return {
			form: {},
			form_salud: {},
			form_education: {},
			form_tramite: {},
			form_temp: {},
			form_google: "",
			form_beneficiario: {},
			form_nino: {},
			form_archivo: {},
			form_familiar: {},
			form_familiares: [],
			address: "",
			/* BENEFICIARIO */
			textBtnBenef: "Agregar Beneficiario",
			textBenef: 'Titular',
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
			isMayor: '',
			datepickerStyle: {
				color: 'red',
				border: '1px solid red',
			},
			textBtnFamiliar: "Agregar Familiar",
			showFamiliar: false,
			fileInvalid: false
		}
	},
	validations() {
		return {
			form: {
				fecha: { required: helpers.withMessage('El campo Fecha es Obligatorio', required) },
				canal_atencion_id: { required: helpers.withMessage('El campo Canal de Atencion es Obligatorio', required) },
				tipo_documento_id: { required: helpers.withMessage('El campo Tipo de Documento es Obligatorio', required) },
				num_documento: { required: helpers.withMessage('El campo N° de documento es Obligatorio', required) },
				name: { required: helpers.withMessage('El campo Nombre es Obligatorio', required) },
				lastname: { required: helpers.withMessage('El campo Apellido es Obligatorio', required) },
				fecha_nac: { required: helpers.withMessage('El campo Fecha de Nacimiento es Obligatorio', required) },
			},
			form_beneficiario: {
				tipo_documento_id: { required: helpers.withMessage('El campo Tipo de Documento del Beneficiario es Obligatorio', required) },
				num_documento: { required: helpers.withMessage('El campo N° de documento del Beneficiario es Obligatorio', required) },
				name: { required: helpers.withMessage('El campo Nombre del Beneficiario es Obligatorio', required) },
				lastname: { required: helpers.withMessage('El campo Apellido  del Beneficiarioes Obligatorio', required) },
				fecha_nac: { required: helpers.withMessage('El campo Fecha de Nacimiento del Beneficiario es Obligatorio', required) },
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
			if(this.isMayor == 'Menor'){
				const result = await this.v$.$validate()
				if(!result){
					return
				}
			}else if (this.isMayor == 'Mayor') {
				const result = await this.v$.form.$validate()
						if(!result){
							return
						}
				} else {
					this.labelType = "danger";
					this.toastMessage = 'Debe completar el formulario';
					return
			}
			
			let rt = route('juventud.update', this.form.tramite_id);

			const formData = new FormData();

			/* 
			** Se formatea las fechas para que las mismas sean enviadas en formato 
			** Output: 2023-06-22T01:33:00.000Z
			** a traves del formData
			*/

			this.form.fecha = (this.form.fecha) ? new Date(this.form.fecha).toISOString() : null;
			this.form.fecha_nac = (this.form.fecha_nac) ? new Date(this.form.fecha_nac).toISOString() : null;
			this.form_salud.fecha_apto_medico = (this.isValidDate(this.form_salud.fecha_apto_medico)) ? new Date(this.form_salud.fecha_apto_medico).toISOString() : null;
			this.form_salud.fecha_electrocardiograma = (this.isValidDate(this.form_salud.fecha_electrocardiograma)) ? new Date(this.form_salud.fecha_electrocardiograma).toISOString() : null;

			for (var clave in this.form) {
				if (this.form.hasOwnProperty(clave)) {
					formData.append(clave, this.form[clave]);
				}
			}

			for (var clave in this.form_salud) {
				if (this.form_salud.hasOwnProperty(clave)) {
					formData.append(clave, this.form_salud[clave]);
				}
			}

			for (var clave in this.form_education) {
				if (this.form_education.hasOwnProperty(clave)) {
					formData.append(clave, this.form_education[clave]);
				}
			}

			for (var clave in this.form_tramite) {
				if (this.form_tramite.hasOwnProperty(clave)) {
					formData.append(clave, this.form_tramite[clave]);
				}
			}

			if(this.isMayor == 'Menor'){
				this.form_beneficiario.fecha_nac = (this.form_beneficiario.fecha_nac) ? new Date(this.form_beneficiario.fecha_nac).toISOString() : null;
				
				for (var clave in this.form_beneficiario) {
					if (this.form_beneficiario.hasOwnProperty(clave)) {
						formData.append('beneficiario_' + clave, this.form_beneficiario[clave]);
					}
				}
			}
			
			formData.append('beneficiario_control', this.beneficiario_control)
			
			try {
				const response = await axios.post(rt, formData);
				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
					setTimeout(() => {
						window.location.href = '/juventud';
					}, 1000)
				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
				}
			} catch (error) {
				console.log(error)
			}

		},
		async getPerson() {
			this.form_temp.num_documento = this.form.num_documento;
			this.form_temp.tipo_documento_id = this.form.tipo_documento_id;
			this.form_temp.fecha = this.form.fecha;
			this.form_temp.tipo_tramite_id = this.form.tipo_tramite_id;
			this.form_temp.canal_atencion_id = this.form.canal_atencion_id;
			this.form_temp.observacion = this.form.observacion;

			const get = `${route('persons.getPersonDni', this.form.num_documento)}`
			const response = await fetch(get, { method: 'GET' })
			let data = await response.json()
			if (!data.data.length == 0) {
				data = data.data[0].person
				/// Recuperar datos.
				this.form.person_id = data.id
				this.form.tipo_documento_id = data.tipo_documento_id
				this.form.fecha_nac = data.fecha_nac
				this.form.fecha_nac = new Date(this.form.fecha_nac + "T00:00:00.000-03:00")
				this.form.name = data.name
				this.form.lastname = data.lastname
				this.form.email = data.contact[0].email
				this.form.phone = data.contact[0].phone
				this.form.celular = data.contact[0].celular
				if (data.aditional[0]) {
					this.form.cant_hijos = data.aditional[0].cant_hijos
					this.form.situacion_conyugal_id = data.aditional[0].situacion_conyugal_id

				}
				if (data.social[0]) {
					this.form.tipo_ocupacion_id = data.social[0].tipo_ocupacion_id
					this.form.cobertura_medica_id = data.social[0].cobertura_medica_id
					this.form.tipo_pension_id = data.social[0].tipo_pension_id
					this.form.programa_social_id = data.social[0].programa_social_id
				}

				if (data.education[0] && this.isMayor == 'Mayor') {
					this.form_education.nivel_educativo_id = data.education[0].nivel_educativo_id
					this.form_education.estado_educativo_id = data.education[0].estado_educativo_id
					this.form_education.escuela_primaria_id = data.education[0].escuela_primaria_id
					this.form_education.escuela_secundaria_id = data.education[0].escuela_secundaria_id
					this.form_education.escuela_nocturna_id = data.education[0].escuela_nocturna_id
					this.form_education.orientacion_secundario_id = data.education[0].orientacion_secundario_id
					this.form_education.nivel_secundario_id = data.education[0].nivel_secundario_id
					this.form_education.turno_nocturno_id = data.education[0].turno_nocturno_id
					this.form_education.dependencia_nocturno_id = data.education[0].dependencia_nocturno_id
					this.form_education.terciario = data.education[0].terciario
					this.form_education.name_terciario = data.education[0].name_terciario
					this.form_education.carrera_terciario = data.education[0].carrera_terciario
					this.form_education.anio_terciario = data.education[0].anio_terciario
					this.form_education.universitario = data.education[0].universitario
					this.form_education.name_universitario = data.education[0].name_universitario
					this.form_education.carrera_universitario = data.education[0].carrera_universitario
					this.form_education.anio_universitario = data.education[0].anio_universitario
				}

				if (data.salud != null && this.isMayor == 'Mayor') {
					this.form_salud.apto_medico = data.salud.apto_medico
					this.form_salud.libreta_vacunacion = data.salud.libreta_vacunacion
					this.form_salud.observacion = data.salud.observacion_salud
					//if(data.salud.fecha_apto_medico){
						this.form_salud.fecha_apto_medico = data.salud.fecha_apto_medico
						this.form_salud.fecha_apto_medico = new Date(this.form_salud.fecha_apto_medico + "T00:00:00.000-03:00")
					//}
					//if(data.salud.fecha_electrocardiograma){
						this.form_salud.fecha_electrocardiograma = data.salud.fecha_electrocardiograma
						this.form_salud.fecha_electrocardiograma = new Date(this.form_salud.fecha_electrocardiograma + "T00:00:00.000-03:00")
				//	}
					this.form_salud.electrocardiograma = data.salud.electrocardiograma
					this.form_salud.medicacion = data.salud.medicacion
					this.form_salud.name_medicacion = data.salud.name_medicacion
					this.form_salud.dosis = data.salud.dosis
					this.form_salud.centro_salud_id = data.salud.centro_salud_id
					this.form_salud.estado_salud_id = data.salud.estado_salud_id
					this.form_salud.observacion_salud = data.salud.observacion
				}
				if (data.address[0]) {
					this.form.calle = data.address[0].calle
					this.form.number = data.address[0].number
					this.form.piso = data.address[0].piso
					this.form.dpto = data.address[0].dpto
					if (data.address[0].latitude && data.address[0].longitude && this.isMayor == 'Menor') {
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
					this.form.pais_id = data.address[0].pais_id
				}
				this.form = this.removeNullValues(this.form);
				this.form_tramite = this.removeNullValues(this.form_tramite);
				this.form_salud = this.removeNullValues(this.form_salud);
				this.form_education = this.removeNullValues(this.form_education);

			} else {
				this.labelType = "info";
				this.toastMessage = "El DNI indicado no se encuentra registrado";
				this.form = {}
				this.form_beneficiario = {}
				this.form = this.form_temp
				this.form_temp = {}
			}
		},
		removeNullValues(data) {
			return Object.fromEntries(Object.entries(data).filter(([key, value]) => value !== null && value !== undefined));
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
		async getPersonBenef() {
			let numDoc = this.form_beneficiario.num_documento;
			let tipoDoc = this.form_beneficiario.tipo_documento_id;

			const get = `${route('persons.getPersonDni', this.form_beneficiario.num_documento)}`
			const response = await fetch(get, { method: 'GET' })
			let data = await response.json()
			if (!data.data.length == 0) {
			
				data = data.data[0].person
				/// Recuperar datos.
				this.form_beneficiario.beneficiario_id = data.id
				this.form_beneficiario.tipo_documento_id = data.tipo_documento_id
				this.form_beneficiario.num_cuit = data.num_cuit
				this.form_beneficiario.fecha_nac = data.fecha_nac
				this.form_beneficiario.fecha_nac = new Date(this.form_beneficiario.fecha_nac + "T00:00:00.000-03:00")
				this.form_beneficiario.name = data.name
				this.form_beneficiario.lastname = data.lastname
				this.form_beneficiario.email = data.contact[0].email
				this.form_beneficiario.phone = data.contact[0].phone
				this.form_beneficiario.celular = data.contact[0].celular

				if (data.education[0]) {
					this.form_education.nivel_educativo_id = data.education[0].nivel_educativo_id
					this.form_education.estado_educativo_id = data.education[0].estado_educativo_id
					this.form_education.escuela_primaria_id = data.education[0].escuela_primaria_id
					this.form_education.escuela_secundaria_id = data.education[0].escuela_secundaria_id
					this.form_education.escuela_nocturna_id = data.education[0].escuela_nocturna_id
					this.form_education.orientacion_secundario_id = data.education[0].orientacion_secundario_id
					this.form_education.nivel_secundario_id = data.education[0].nivel_secundario_id
					this.form_education.turno_nocturno_id = data.education[0].turno_nocturno_id
					this.form_education.dependencia_nocturno_id = data.education[0].dependencia_nocturno_id
					this.form_education.terciario = data.education[0].terciario
					this.form_education.name_terciario = data.education[0].name_terciario
					this.form_education.carrera_terciario = data.education[0].carrera_terciario
					this.form_education.anio_terciario = data.education[0].anio_terciario
					this.form_education.universitario = data.education[0].universitario
					this.form_education.name_universitario = data.education[0].name_universitario
					this.form_education.carrera_universitario = data.education[0].carrera_universitario
					this.form_education.anio_universitario = data.education[0].anio_universitario
				}

				if (data.salud != null) {
					this.form_salud.apto_medico = data.salud.apto_medico
					this.form_salud.libreta_vacunacion = data.salud.libreta_vacunacion
					this.form_salud.observacion = data.salud.observacion_salud
					this.form_salud.fecha_apto_medico = data.salud.fecha_apto_medico
					this.form_salud.fecha_apto_medico = new Date(this.form_salud.fecha_apto_medico + "T00:00:00.000-03:00")
					this.form_salud.electrocardiograma = data.salud.electrocardiograma
					this.form_salud.fecha_electrocardiograma = data.salud.fecha_electrocardiograma
					this.form_salud.fecha_electrocardiograma = new Date(this.form_salud.fecha_electrocardiograma + "T00:00:00.000-03:00")
					this.form_salud.medicacion = data.salud.medicacion
					this.form_salud.name_medicacion = data.salud.name_medicacion
					this.form_salud.dosis = data.salud.dosis
					this.form_salud.centro_salud_id = data.salud.centro_salud_id
					this.form_salud.estado_salud_id = data.salud.estado_salud_id
					this.form_salud.observacion_salud = data.salud.observacion
				}
				if (data.address[0]) {
					this.form_beneficiario.calle = data.address[0].calle
					this.form_beneficiario.number = data.address[0].number
					this.form_beneficiario.piso = data.address[0].piso
					this.form_beneficiario.dpto = data.address[0].dpto

					this.form_beneficiario.localidad_id = data.address[0].localidad_id
					this.form_beneficiario.barrio_id = data.address[0].barrio_id
				}
				this.form = this.removeNullValues(this.form);
				this.form_tramite = this.removeNullValues(this.form_tramite);
				this.form_salud = this.removeNullValues(this.form_salud);
				this.form_education = this.removeNullValues(this.form_education);
			} else {
				this.labelType = "info";
				this.toastMessage = "El DNI indicado no se encuentra registrado";
				this.form_beneficiario = {}
				this.form_beneficiario.num_documento = numDoc
				this.form_beneficiario.tipo_documento_id = tipoDoc
			}
		},
		isValidDate(date) {
			return date instanceof Date && !isNaN(date);
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
		async destroyItem(id) {
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
		async editItem(item) {
			console.log(item)
			let formData = new FormData();
			formData.append('familiar_id', item.id);
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

	},
	created() {

	},
	computed: {
		barriosComputed: function () {
			/* this.form.barrio_id = this.form.get_barrio_id
			this.form.get_barrio_id = null */
			return this.barrios.filter(barrio => barrio.localidad_id == this.form.localidad_id)
		},
		barriosBenefComputed: function () {
			/* this.form.barrio_id = this.form.get_barrio_id
			this.form.get_barrio_id = null */
			return this.barrios.filter(barrio => barrio.localidad_id == this.form_beneficiario.localidad_id)
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
		this.form_tramite.sede_id = this.tramite[0].sede_id

		if (this.tramite[0].cbj_data) {
			this.form_tramite.anio_inicio = this.tramite[0].cbj_data.anio_inicio
			this.form_tramite.estado_cbj_id = this.tramite[0].cbj_data.estado_cbj_id
			this.form_tramite.comedor_id = this.tramite[0].cbj_data.comedor_id
			this.form_tramite.actividad_cbj_id = this.tramite[0].cbj_data.actividad_cbj_id
			this.form_tramite.apoyo_escolar = this.tramite[0].cbj_data.apoyo_escolar
			this.form_tramite.act_empleo = this.tramite[0].cbj_data.act_empleo
			this.form_tramite.acompanamiento_cbj_id = this.tramite[0].cbj_data.acompanamiento_cbj_id
			this.form_tramite.aut_firmada = this.tramite[0].cbj_data.aut_firmada
			this.form_tramite.aut_retirarse = this.tramite[0].cbj_data.aut_retirarse
			this.form_tramite.aut_uso_imagen = this.tramite[0].cbj_data.aut_uso_imagen
			this.form_tramite.certificado_escolar = this.tramite[0].cbj_data.certificado_escolar
			
		}
		// Archivos
		this.form_archivo = this.tramite[0].archivos
		// Familiares
		this.form_familiares = this.tramite[0].familiares

		/**
		 * Recuperando datos del titular
		 */
		this.form.num_documento = titular[0].num_documento
		if(beneficiario != ''){
			this.form_beneficiario.num_documento = beneficiario[0].num_documento
			this.isMayor = 'Menor'
			this.beneficiario_control=true
			this.getPersonBenef()
		}else{
			this.isMayor = 'Mayor'
		}
		this.getPerson()
	},

}
</script>



