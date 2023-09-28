
<template>
	<main class="flex-1 bg-gray-50 pb-40">
		<!-- Page title & actions -->
		<div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
			<div class="flex-1 min-w-0 flex items-center">
				<button class="btn-blue" @click.prevent="goBack()">
					<ArrowLeftCircleIcon class="w-5 h-5 text-purple-700 mr-2" />
				</button>
				<h1 class="font-sm font-medium text-gray-600 sm:truncate">
					Detalle del Trámite 
					<span class="text-indigo-700 text-xl font-semibold ">{{tramite[0].dependencia.description}}</span>
				</h1>
			</div>
			<div class="mt-4 flex sm:mt-0 sm:ml-4">
				<button v-if="tramite[0].estado_id == 1" class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 bg-blue-500 focus:ring-blue-500 sm:order-1 sm:ml-3"
						@click="changeStatus(2)">
						Cerrar Trámite
				</button>
				<button v-else class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 bg-indigo-500  focus:ring-indigo-500 sm:order-1 sm:ml-3"
						@click="changeStatus(1)">
					    Re Abrir Trámite					
				</button>
				<a target="_blank" :href="route('pdf.acusepdf', tramite[0].id)" class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 bg-green-500 focus:ring-green-500 sm:order-1 sm:ml-3">
					Imprimir Acuse					
				</a>
			</div>
		</div>

		<Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="bg-white shadow overflow-hidden sm:rounded-lg">
				<div class="px-4 py-5 sm:px-6">
					<h3 class="text-lg leading-6 font-medium text-gray-900">Declaración Jurada</h3>
					<p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles del tramite.</p>
				</div>

				<div class="border-t border-gray-200 px-4 py-5 sm:p-0">
					<dl class="sm:divide-y sm:divide-gray-200">
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Fecha de Ingreso</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{ store.dateFormateada(tramite[0].fecha) }}</dd>
						</div>
						
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Tipo de Trámite</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ tramite[0].tipo_tramite.description }}</dd>
						</div>
						
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Canal de Atención</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ tramite[0].canal_atencion.description }}</dd>
						</div>
						
						<div v-if="tramite[0].dependencia_id == 6" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Modalidad de Atención</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ tramite[0].modalidad_atencion?.description }}</dd>
						</div>
						
						<div v-if="tramite[0].dependencia_id == 6" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Cetegoría</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ tramite[0].category?.nombre }}</dd>
						</div>
						
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Observaciones</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ tramite[0].observacion }}</dd>
						</div>
						
					</dl>
				</div>

			</div>
		</div>	


		<!-- Datos Titular -->
		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="bg-white shadow overflow-hidden sm:rounded-lg">
				<div class="px-4 py-5 sm:px-6">
					<h3 class="text-lg leading-6 font-medium text-gray-900">Datos del Titular</h3>
					<p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles del tramite.</p>
				</div>

				<div class="border-t border-gray-200 px-4 py-5 sm:p-0">
					<dl class="sm:divide-y sm:divide-gray-200">
			
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{tramite[0].persons[0].lastname}}, {{ tramite[0].persons[0].name }}</dd>
						</div>
			
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Documento</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{tramite[0].persons[0].num_documento}}</dd>
						</div>
			
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{tramite[0].persons[0].fecha_nac}}</dd>
						</div>
			
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Dirección</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
								{{ tramite[0].persons[0].address[0].calle }} {{ tramite[0].persons[0].address[0].number }}  
								<span v-if="tramite[0].persons[0].address[0].piso">, Piso: {{ tramite[0].persons[0].address[0].piso }}</span>
								<span v-if="tramite[0].persons[0].address[0].dpto">, DPTO: {{ tramite[0].persons[0].address[0].dpto }}</span>
								<span v-if="tramite[0].persons[0].address[0].dpto">, {{ tramite[0].persons[0].address[0].localidad.description }}</span>						
							</dd>
						</div>

						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Email</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{tramite[0].persons[0].contact[0].email ? tramite[0].persons[0].contact[0].email : "" }}</dd>
						</div>

						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Telefono</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{tramite[0].persons[0].contact[0].phone}}</dd>
						</div>

						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Celular</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{tramite[0].persons[0].contact[0].celular}}</dd>
						</div>

						<div v-if="tramite[0].dependencia_id == 2" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">CUD</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{tramite[0].persons[0].cud?.codigo}}</dd>
						</div>

						<div v-if="tramite[0].dependencia_id == 2" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Diagnostico</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{tramite[0].persons[0].cud?.diagnostico}}</dd>
						</div>

					</dl>
				</div>
				
			</div>
		</div>	
		<!-- Fin  Datos Titular -->

		<!-- Datos Beneficiario -->
		<div v-if="dataBeneficiario != ''" class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="bg-white shadow overflow-hidden sm:rounded-lg">
				<div class="px-4 py-5 sm:px-6">
					<h3 class="text-lg leading-6 font-medium text-gray-900">Datos del Beneficiario</h3>
					<p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles del tramite.</p>
				</div>

				<div class="border-t border-gray-200 px-4 py-5 sm:p-0">
					<dl class="sm:divide-y sm:divide-gray-200">
			
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{ dataBeneficiario.lastname}}, {{ dataBeneficiario.name }}</dd>
						</div>
			
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Documento</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ dataBeneficiario.num_documento}}</dd>
						</div>
			
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{  dataBeneficiario.fecha_nac}}</dd>
						</div>
			
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Email</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{dataBeneficiario.contact[0] ? dataBeneficiario.contact[0].email : ''}}</dd>
						</div>

						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Telefono</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{dataBeneficiario.contact[0] ? dataBeneficiario.contact[0].phone : ''}}</dd>
						</div>

						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Celular</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{dataBeneficiario.contact[0] ? dataBeneficiario.contact[0].celular : ''}}</dd>
						</div>


					</dl>
				</div>
				
			</div>
		</div>			
		<!-- Fin Datos Beneficiario -->

		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="bg-white shadow overflow-hidden sm:rounded-lg">
				<div class="px-4 py-5 sm:px-6">
					<h3 class="text-lg leading-6 font-medium text-gray-900">Información Adicional</h3>
					<p class="mt-1 max-w-2xl text-sm text-gray-500">Situación social, educativo y laboral.</p>
				</div>
				<div class="border-t border-gray-200 px-4 py-5 sm:p-0">
					<dl class="sm:divide-y sm:divide-gray-200">
						<div v-if="nivelEducativo != '' " class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Nivel Educativo</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{ nivelEducativo }}</dd>
						</div>				

						<div v-if="ocupacion !=''" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Ocupación</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ocupacion}}</dd>
						</div>

						<div v-if="coberturaMedica != ''" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Cobertura Médica</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{coberturaMedica}}</dd>
						</div>

						<div v-if="programaSocial != ''" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Programa Social</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{programaSocial}}</dd>
						</div>

						<div v-if="tipoPension != ''" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Tipo Pensión</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{tipoPension}}</dd>
						</div> 
					</dl>
				</div>	
			</div>
		</div>	

		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="bg-white shadow overflow-hidden sm:rounded-lg">
				<div class="px-4 py-5 sm:px-6">
					<h3 class="text-lg leading-6 font-medium text-gray-900">Actualizaciones</h3>
					<p class="mt-1 max-w-2xl text-sm text-gray-500"></p>
				</div>
				<div class="border-t border-b border-gray-200 px-4 py-5 sm:p-0">
					<dl class="sm:divide-y sm:divide-gray-200">
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Estado</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 uppercase" >
								<span :class="estado[estadoTramite]"> {{ estadoTramite }}</span>	
							
							</dd>
						</div>		
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 flex items-center">
							<dt class="text-sm font-medium text-gray-500">Responsable</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 uppercase flex items-center " >
								<select v-model="assignment" id="assignment" name="assignment" autocomplete="off"
									class=" block w-80 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option disabled value="" :bind:select="tramite[0].assigned == null " >Seleccione un Responsable</option>
									<option v-for="u in users" :key="u.id" :value="u.id"
										:bind:select="u.id == tramite[0].assigned">
										{{ u.name }}
									</option>
								</select>	
								<button type="button"
										class="relative ml-4 inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
										@click="changeAssignment()">
										Confirmar</button>						
							</dd>
						</div>		
						<!-- Si el tramite esta cerrado no se puede re asignar -->
						<div v-if="tramite[0].estado_id != 2"  class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Re Asignar</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > 
								<select v-model="newDependencia" id="newDependencia" name="newDependencia" autocomplete="off"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option v-for="d in dependencias" :key="d.id" :value="d.id"
										:bind:select="d.id == tramite[0].dependencia_id">
										{{ d.description }}
									</option>
								</select>

								<label for="newDepObservacion" class="block text-xs font-medium text-gray-500 mt-5 mb-1">Ingrese los detalles relacionados al cambio de Dependencia.</label>
								<div class="mb-5">
									<textarea v-model="newDepObservacion" id="newDepObservacion" name="newDepObservacion" rows="3"
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" />
								</div>
					
								<button type="button"
										class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
										@click="changeDependencia()">
										Confirmar
								</button>
							</dd>
						</div>				
					</dl>
				</div>	

			

			</div>
		</div>	

		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="bg-white shadow overflow-hidden sm:rounded-lg">
				<div class="px-4 py-5 sm:px-6">
					<h3 class="text-lg leading-6 font-medium text-gray-900">Observaciones</h3>
					<p class="mt-1 max-w-2xl text-sm text-gray-500"></p>
				</div>
				<!-- Si el tramite esta cerrado no se puede agregar observaciones -->
				<div v-if="tramite[0].estado_id != 2" class="border-t border-b border-gray-200 px-4 py-5 sm:p-0">
					<dl class="sm:divide-y sm:divide-gray-200">
		
						<div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
							<dt class="text-sm font-medium text-gray-500">Nueva Observación</dt>
							<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > 
								<div class="mt-1">
									<textarea v-model="form.newObservacion" id="observacion" name="observacion" rows="3"
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" />
								</div>
								<p class="mt-1 mb-5 text-xs text-gray-500">
									Ingrese información adicional del tramite.
								</p>
					
								<button type="button"
										class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
										@click="addObservacion()">
										Agregar Observación
								</button>
							</dd>
						</div>				
					</dl>
				</div>	
				
				<div class="grid grid-cols-12 gap-12">
					<table class="min-w-full divide-y divide-gray-200 w-full col-span-12">
						<thead class="bg-gray-50">
							<tr>
								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
									Fecha</th>
								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">
									Dependencia</th>
								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">
									Usuario</th>
								<th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12">
									Observación</th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y divide-gray-200">
							<tr v-for="(comment, index) in comments" :key="index">
								
								<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
									{{ store.fechaFormateada(comment.created_at) }}
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
									{{ comment.dependencia ? comment.dependencia.description : '' }}
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
									{{ comment.user ? comment.user.name : '' }}
								</td>
								<td class="px-6 py-4 whitespace-wrap text-sm text-gray-500 text-justify">
									{{ comment.content }}
								</td>

							</tr>
						</tbody>
					</table>
				</div>				
			</div>
		</div>	

		<div class="px-4 mt-6 sm:px-6 lg:px-8">
			<form action="#" method="POST" enctype="multipart/form-data">

				<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
					<div class="bg-white py-6 px-4 space-y-6 sm:p-6">

						<div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
							<div class="">
								<h3 class="text-lg leading-6 font-medium text-gray-900">Archivos Adjuntos</h3>
							</div>

						</div>
						<!-- Si el tramite esta cerrado no se puede agregar archivos -->
						<div v-if="tramite[0].estado_id != 2" class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-10 ">
								<label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
								<div class="flex ">
									<input v-model="form.description_file" type="text" name="descripcion" id="descripcion"
										autocomplete="descripcion-level2"
										class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-1/2 shadow-sm sm:text-sm border-gray-300 rounded-md mr-6" />
									<input @change="handleFileUpload" type="file" name="file" id="file" ref="file"
										autocomplete="file-level2"
										class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-1/2 rounded-md" />
									<div class="flex-shrink-0">
										<button @click="uploadFile()" type="button"
											class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">
											Subir Archivo</button>
									</div>
								</div>
							</div>
							<div class="col-span-12 sm:col-span-10 ">
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
									<tbody class="bg-white divide-y divide-gray-200">
										<tr v-for="archivo in form_archivo " :key="archivo.id">
											<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
												{{ archivo.description }}
											</td>
											<td class="px-6 py-4 text-center text-sm font-medium">
												<a class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-blue-200 text-blue-900 hover:bg-blue-600 hover:text-white"
													:href="'/file/download/' + archivo.id" target="_blank"
													title="Descargar Archivo">
													Descargar
												</a>
												<a class="ml-2 relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-red-200 text-red-900 hover:bg-red-600 hover:text-white"
													@click="deleteFile(archivo.id)" title="Eliminar Archivo">
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

import store from '@/store.js'

const estado = {
	'abierto' : 'px-2 py-1 bg-green-50 text-green-800 border border-green-400',
	'cerrado' : 'px-2 py-1 bg-red-50 text-red-800 border border-red-300',
	'en proceso': 'px-2 py-1 bg-blue-50 text-blue-800 border border-blue-300',
}

export default {

	props: {
		estados: Object,
		dependencias: Object,
		tramite: Object,
		users: Object,
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
	},
	data() {
		return {
			form: {},
			form_google: "",
			address: "",
			showMap: false,
			toastMessage: "",
			labelType: "info",
			message: "",
			showToast: false,
			file: "",
			form_archivo: {},
			form_beneficiario: {},
			showBenef: false,
			btnGuardar: false,
			datepickerStyle: {
				color: 'red',
				border: '1px solid red',
			},
			comments: [],
			newDependencia: this.tramite[0].dependencia_id,
			newDepObservacion: "",
			assignment: this.tramite[0].assigned,
		}
	},
	setup() {
		// const format = (date) => {
		// 	const day = date.getDate();
		// 	const month = date.getMonth() + 1;
		// 	const year = date.getFullYear();

		// 	return `${day}/${month}/${year}`;
		// }

		return {
			// format,
			estado,
			store
		}
	},

	methods: {
		goBack(){
			window.history.back();
		},
		async changeAssignment(){
			
			if(this.assignment == this.tramite[0].assigned){
				this.labelType = "danger";
				this.toastMessage = "Debe seleccionar un responsable distinto";
				return
			}

			let rt = route('detail.changeAssigment');

			let formData = new FormData();
			formData.append('user_id', this.assignment)
			formData.append('tramite_id', this.tramite[0].id)

			try {
				const response = await axios.post(rt, formData);
				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
					this.tramite[0].assignment = this.assignment
					this.tramite[0].estado_id = 3 // En proceso, siempre que se asigna se pone en proceso
					this.getComments()

				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
				}
			} catch (error) {
				console.log(error)
			}


		},

		async changeStatus(newEstado){

			let rt = route('detail.changeEstado');

			let formData = new FormData();
			formData.append('estado_id', newEstado)
			formData.append('tramite_id', this.tramite[0].id)

			try {
				const response = await axios.post(rt, formData);
				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
					this.tramite[0].estado_id = newEstado
					this.getComments()

				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
				}
			} catch (error) {
				console.log(error)
			}

		},

		async changeDependencia(){
			if(this.newDependencia == this.tramite[0].dependencia_id){
				this.labelType = "danger";
				this.toastMessage = "Debe seleccionar una dependencia distinta";
				return
			}

			if(this.newDepObservacion == ""){
				this.labelType = "danger";
				this.toastMessage = "Debe ingresar una observación para el cambio de dependencia";
				return
			}


			let rt = route('detail.changeDependencia', this.tramite[0].id);
			let formData = new FormData();
				formData.append('dependencia_id', this.newDependencia)
				formData.append('tramite_id', this.tramite[0].id)
				formData.append('observacion', this.newDepObservacion)

			try {
				const response = await axios.post(rt, formData);
				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
					this.tramite[0].dependencia_id = this.newDependencia
					this.getComments()
				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
				}
			} catch (error) {
				console.log(error)
			}
		},
		async getComments(){
			let rt = route('detail.getComments', this.tramite[0].id);

			try {
				const response = await axios.get(rt);
				if (response.status == 200) {
					console.log(response)
					this.comments = response.data
				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
				}
			} catch (error) {
				console.log(error)
			}
	
		},

		async addObservacion(){
			
				let rt = route('detail.addComment');

				let formData = new FormData();
				formData.append('observacion', this.form.newObservacion)
				formData.append('tramite_id', this.tramite[0].id)
				
				try {
					const response = await axios.post(rt, formData);
					if (response.status == 200) {
						this.labelType = "success";
						this.toastMessage = response.data.message;
						this.getComments()
					} else {
						this.labelType = "danger";
						this.toastMessage = response.data.message;
						this.btnGuardar = false
					}
				} catch (error) {
					console.log(error)
				}
			
		},

		clearMessage() {
			this.toastMessage = "";
		},

		removeNullValues(data) {
			return Object.fromEntries(Object.entries(data).filter(([key, value]) => value !== null && value !== undefined));
		},

		getAddressData: function (addressData, placeResultData, id) {
			this.form.google_address = placeResultData['formatted_address']
			this.form.latitude = addressData['latitude']
			this.form.longitude = addressData['longitude']

			this.form_google = addressData

			this.showMap = true
		},

		handleFileUpload(event) {
			this.file = event.target.files[0];
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
			formData.append('tramite_id', this.tramite[0].id);
			formData.append('description', this.form.description_file);


			try {
				const response = await axios.post(rt, formData);
				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
					this.form_archivo.push(response.data.archivo)
					this.form.description_file = ''
					this.file = ''
				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
				}
			} catch (error) {
				console.log(error)
			}
		}

	},

	computed: {
		estadoTramite: function() {
			return  this.estados.find(estado => estado.id === this.tramite[0].estado_id).description;
  		},
  		nivelEducativo: function() {
    		return this.tramite[0]?.persons[0]?.education[0]?.nivel_educativo?.description ?? '';
  		},
		ocupacion: function() {
			return this.tramite[0]?.persons[0]?.social[0]?.tipo_ocupacion?.description ?? '';
  		},
		coberturaMedica: function() {
			return this.tramite[0]?.persons[0]?.social[0]?.cobertura_medica?.description ?? '';
  		},
		programaSocial: function() {
			return this.tramite[0]?.persons[0]?.social[0]?.programa_social?.description ?? '';
  		},
		tipoPension: function() {
			return this.tramite[0]?.persons[0]?.social[0]?.tipo_pension?.description ?? '';
	  	},
		dataTitular() {
			// Filtrar la lista de personas para obtener solo el titular (rol_tramite_id === 1)
			const titular = this.tramite[0].persons.find(person => person.pivot.rol_tramite_id === 1);
			return titular || {}; // Devolver objeto vacío si no se encuentra el titular
		},
		dataBeneficiario() {
			// Filtrar la lista de personas para obtener solo el beneficiario (rol_tramite_id === 2)
			const beneficiario = this.tramite[0].persons.find(person => person.pivot.rol_tramite_id === 2);
			return beneficiario || ''; // Devolver objeto vacío si no se encuentra el beneficiario
		},
	},

	mounted() {
		this.getComments()
	 	this.form_archivo = this.tramite[0].archivos
	},
}
</script>



