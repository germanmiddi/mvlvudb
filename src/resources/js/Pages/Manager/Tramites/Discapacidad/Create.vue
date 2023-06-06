
<template>
    <main class="flex-1 bg-gray-50 pb-40">
        <!-- Page title & actions -->
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0 flex items-center">
                <ArrowLeftCircleIcon class="w-5 h-5 text-purple-700 mr-2" />
				<h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Nuevo tramite Discapacidad</h1>
            </div>
            <div class="mt-4 flex sm:mt-0 sm:ml-4">
              <button class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Guardar</button>
            </div>
        </div>
   
        <div class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="shadow sm:rounded-md sm:overflow-hidden">
				<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
					<div>
						<h3 class="text-lg leading-6 font-medium text-gray-900">Declaración Jurada</h3>
						<!-- <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly so be careful what you share.</p> -->
					</div>

					<div class="grid grid-cols-12 gap-6">

						<div class="col-span-12 sm:col-span-3 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Fecha</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div>

						<div class="col-span-12 sm:col-span-5">
							<label for="country" class="block text-sm font-medium text-gray-700">Tipo de Tramite</label>
							<select id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option>Seleccione</option>
							<option></option>
							<option></option>
							</select>
						</div>  

						<div class="col-span-12 sm:col-span-3">
							<label for="country" class="block text-sm font-medium text-gray-700">Canal de Atención</label>
							<select id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option>Seleccione</option>
							<option></option>
							<option></option>
							</select>
						</div>   
					</div>
					<div class="grid grid-cols-12 gap-6">
						<div class="sm:col-span-8">
							<label for="about" class="block text-sm font-medium text-gray-700">Observaciones </label>
							<div class="mt-1">
							<textarea id="about" name="about" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" />
							</div>
							<p class="mt-2 text-sm text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
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
							<h3 class="text-lg leading-6 font-medium text-gray-900">Datos del Titular</h3>
						</div>
						<div class="flex-shrink-0">
							<button type="button" class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">Agregar Beneficiario</button>
						</div>
					</div>

					<div class="grid grid-cols-12 gap-6">
						<div class="col-span-12 sm:col-span-3">
							<label for="country" class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
							<select id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option>DNI</option>
							<option></option>
							<option></option>
							</select>
						</div>  

						<div class="col-span-12 sm:col-span-3 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Nro de Documento</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div> 
						<div class="col-span-12 sm:col-span-3 ">
							<label for="city" class="block text-sm font-medium text-gray-700">CUIT / CUIL</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div> 

						<div class="col-span-12 sm:col-span-3 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div> 

					</div>

					<div class="grid grid-cols-12 gap-6">

						<div class="col-span-12 sm:col-span-3 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Nombre</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div> 

						<div class="col-span-12 sm:col-span-3 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Apellido</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div> 
						<div class="col-span-12 sm:col-span-3 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Nro CUD</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div> 

						<div class="col-span-12 sm:col-span-3 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Diagnóstico</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div> 


					</div>
					<div class="grid grid-cols-12 gap-6">

						<div class="col-span-12 sm:col-span-3 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Mail</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div> 

						<div class="col-span-12 sm:col-span-3 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Teléfono</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
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
							<label for="country" class="block text-sm font-medium text-gray-700">Tipo de Vivienda</label>
							<select id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option>DNI</option>
							<option></option>
							<option></option>
							</select>
						</div>  
						<div class="col-span-12 sm:col-span-3">
							<label for="country" class="block text-sm font-medium text-gray-700">Localidad</label>
							<select id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option>DNI</option>
							<option></option>
							<option></option>
							</select>
						</div>  
						<div class="col-span-12 sm:col-span-3">
							<label for="country" class="block text-sm font-medium text-gray-700">Barrio</label>
							<select id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option>DNI</option>
							<option></option>
							<option></option>
							</select>
						</div>  

					</div>

					<div class="grid grid-cols-12 gap-6">

						<div class="col-span-12 sm:col-span-4 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Calle</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div> 

						<div class="col-span-12 sm:col-span-2 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Número</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div> 
						<div class="col-span-12 sm:col-span-2 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Piso</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div> 

						<div class="col-span-12 sm:col-span-2 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Departamento</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div> 


					</div>
					<div class="grid grid-cols-12 gap-6">

						<div class="col-span-12 sm:col-span-2 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Latitud</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div> 

						<div class="col-span-12 sm:col-span-2 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Longitud</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div> 
						<div class="col-span-12 sm:col-span-6 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Dirección Google</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
						</div> 
						<div class="col-span-12 sm:col-span-2 ">
							<label class="block text-transparent ">Button</label>
							<button class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Ver Mapa</button>
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
							<label for="country" class="block text-sm font-medium text-gray-700">Pais de Origen</label>
							<select id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option>Argentina</option>
							<option></option>
							<option></option>
							</select>
						</div>  
						<div class="col-span-12 sm:col-span-3">
							<label for="country" class="block text-sm font-medium text-gray-700">Situación Conyugal</label>
							<select id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option>DNI</option>
							<option></option>
							<option></option>
							</select>
						</div>  
						<div class="col-span-12 sm:col-span-4 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Cantidad Hijos</label>
							<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
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
							<label for="country" class="block text-sm font-medium text-gray-700">Nivel educativo en curso</label>
							<select id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option>Secundario</option>
							<option></option>
							<option></option>
							</select>
						</div>  
						<div class="col-span-12 sm:col-span-3">
							<label for="country" class="block text-sm font-medium text-gray-700">Nivel educativo alcanzado</label>
							<select id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option></option>
							<option></option>
							<option></option>
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
							<label for="country" class="block text-sm font-medium text-gray-700">Ocupación</label>
							<select id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option>Seleccione</option>
							<option></option>
							<option></option>
							</select>
						</div>  
						<div class="col-span-12 sm:col-span-3">
							<label for="country" class="block text-sm font-medium text-gray-700">Persive Jubilación / Pensión</label>
							<select id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option>Seleccione</option>
							<option></option>
							<option></option>
							</select>
						</div>  
					</div>
				</div>
			</div>

			<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
				<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
					<div>
						<h3 class="text-lg leading-6 font-medium text-gray-900">sin nombre</h3>
					</div>

					<div class="grid grid-cols-12 gap-6">
						<div class="col-span-12 sm:col-span-3">
							<label for="country" class="block text-sm font-medium text-gray-700">Cobertura de Salud</label>
							<select id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option>Seleccione</option>
							<option></option>
							<option></option>
							</select>
						</div>  
						<div class="col-span-12 sm:col-span-3">
							<label for="country" class="block text-sm font-medium text-gray-700">Recibe Subsidio</label>
							<select id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option>Seleccione</option>
							<option></option>
							<option></option>
							</select>
						</div>  
						<div class="col-span-12 sm:col-span-3">
							<label for="country" class="block text-sm font-medium text-gray-700">Recibe Programa Social</label>
							<select id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option>Seleccione</option>
							<option></option>
							<option></option>
							</select>
						</div>  
						<div class="col-span-12 sm:col-span-3">
							<label for="country" class="block text-sm font-medium text-gray-700">Recibe Beca Educativa</label>
							<select id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							<option>Seleccione</option>
							<option></option>
							<option></option>
							</select>
						</div>  
					</div>
				</div>
			</div>

			<div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
				<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
					<div>
						<h3 class="text-lg leading-6 font-medium text-gray-900">Archivos Adjuntos</h3>
					</div>

					<div class="grid grid-cols-12 gap-6">
						<div class="col-span-12 sm:col-span-8 ">
							<label for="city" class="block text-sm font-medium text-gray-700">Descripción</label>
							<div class="flex ">
								<input type="text" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-1/2 shadow-sm sm:text-sm border-gray-300 rounded-md mr-6" />
								<input type="file" name="city" id="city" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-1/2 rounded-md" />
							</div>
						</div> 
						
					</div>
				</div>
			</div>
        </div>

		<div class="px-4 mt-6 sm:px-6 lg:px-8 flex justify-end w-full">
			<button class=" items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Guardar</button>
		</div>
     
    </main>


</template>

<script>
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import {ArrowLeftCircleIcon} from '@heroicons/vue/24/outline'

export default {
	components: {
		ArrowLeftCircleIcon
	},
	setup() {
		
	},
}
</script>



