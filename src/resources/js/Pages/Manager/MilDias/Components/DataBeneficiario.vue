<template>
<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
    <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Datos del Niño/Benefeciario
            </h3>
        </div>

        <div v-if="v$.form.$error" class="px-4 mt-6 sm:px-6 lg:px-8">
			<div class="px-4 mt-6 sm:px-6 lg:px-8 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md"
				role="alert">
				<p class="font-bold">Campos requeridos</p>
				<p v-for="error of v$.form.$errors" :key="error.$uid">
					{{ error.$message }}
				</p>
			</div>
		</div>

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 sm:col-span-3">
                <label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Tipo de
                    Documento</label>
                <select v-model="form.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
                    autocomplete="off"
                    :class="v$.form.tipo_documento_id.$error ? 'border-red-500' : ''"
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
                <span v-if="v$.form.tipo_documento_id.$error" class="text-red-500 text-xs">Campo obligatorio</span>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de
                    Documento</label>
                <div class="relative">
                    <input type="text" v-model="form.num_documento" @keyup.enter="getPerson()"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" 
                        :class="v$.form.num_documento.$error ? 'border-red-500' : ''"/>
                    <a @click="getPerson()" 
                        class="absolute inset-y-0 right-0 px-4 py-2 bg-green-200 text-white text-xs rounded-r-md hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-600  shadow-sm text-xs font-medium flex items-center  text-green-900 hover:text-white">
                        Verificar
                    </a>
                </div>
                <span v-if="v$.form.num_documento.$error" class="text-red-500 text-xs">Campo obligatorio</span>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input v-model="form.name" type="text" name="name" id="name" autocomplete="off"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    :class="v$.form.name.$error ? 'border-red-500' : ''"
                    :disabled="input_disable" />
                    <span v-if="v$.form.name.$error" class="text-red-500 text-xs">Campo obligatorio</span>
                
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
                <input v-model="form.lastname" type="text" name="lastname" id="lastname" autocomplete="off"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    :class="v$.form.lastname.$error ? 'border-red-500' : ''"
                    :disabled="input_disable" />
                    <span v-if="v$.form.lastname.$error" class="text-red-500 text-xs">Campo obligatorio</span>
                
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="fecha_nac" class="block text-sm font-medium text-gray-700">Fecha de
                    Nacimiento</label>
                <Datepicker
                    class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    v-model="form.fecha_nac"
                    :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                    :style="v$.form.fecha_nac.$error ? datepickerStyle : ''"
                    :enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
                </Datepicker>
                <span v-if="v$.form.fecha_nac.$error" class="text-red-500 text-xs">Campo obligatorio</span>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="pais_id" class="block text-sm font-medium text-gray-700">Nacionalidad/Pais</label>
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

            <div class="col-span-12 sm:col-span-3">
                <label for="escuela" class="block text-sm font-medium text-gray-700">Escuela</label>
                <input v-model="form.escuela" type="text" name="escuela" id="escuela" autocomplete="off"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    />
                
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="grado" class="block text-sm font-medium text-gray-700">Grado</label>
                <input v-model="form.grado" type="text" name="grado" id="grado" autocomplete="off"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    />
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="repitencia" class="block text-sm font-medium text-gray-700">Repitencia</label>
                <select v-model="form.repitencia" id="repitencia" name="repitencia" autocomplete="off"
                    :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="1" selected>Si</option>
					<option value="0" selected>No</option>
                    
                </select>
            </div>
        </div>
        
        <hr>
        <div class="flex items-center justify-end flex-wrap sm:flex-nowrap">
            <div class="flex-shrink-0">
                <button type="button"
                    class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                    @click="next()">
                    Siguiente
                </button>
            </div>
        </div>
    </div>
</div>
</template>

<script>

import { defineComponent } from 'vue'
/* Validator */
import { useVuelidate } from '@vuelidate/core'
import { required, helpers, minLength } from '@vuelidate/validators'
/* DatePicker */
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
/* Icons */
import { XMarkIcon } from "@heroicons/vue/24/outline";



export default defineComponent({
    props: {
        form: Object,
        tiposDocumento: Object,
        paises: Object,
        localidades: Object,
        barrios: Object
    },
    components: {
        required,
		useVuelidate,
		helpers,
		minLength,
        Datepicker,
        XMarkIcon
    },
    data() {
        return {
            datepickerStyle: {
				color: 'red',
				border: '1px solid red',
			},
            form_temp: {}
        }
    },
	validations() {
		return {
			form: {
				fecha_nac: { required: helpers.withMessage('El campo Fecha de Nacimiento es Obligatorio', required) },
				name: { required: helpers.withMessage('El campo nombre es Obligatorio', required) },
                lastname: { required: helpers.withMessage('El campo apellido es Obligatorio', required) },
				tipo_documento_id: { required: helpers.withMessage('El campo Tipo de Documento es Obligatorio', required) },
				num_documento: { required: helpers.withMessage('El campo N° de documento es Obligatorio', required) },
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
            v$: useVuelidate(),
		};
	},
    methods: {
        async next(){
            const result = await this.v$.$validate()
			if (!result) {
				return
			}

            this.$emit('updateData', this.form)
        },
        async getPerson() {
			const get = `${route(
				"persons.getPersonDni",
				this.form.num_documento
			)}`;
			const response = await fetch(get, { method: "GET" });
			let data = await response.json();
			if (!data.data.length == 0) {

                this.$emit('message', {labelType: 'success', toastMessage: 'El DNI indicado se encuentra registrado'});

				data = data.data[0].person
				/* Recuperar datos */
				this.form.tipo_documento_id = data.tipo_documento_id
				this.form.fecha_nac = data.fecha_nac
				this.form.fecha_nac = new Date(this.form.fecha_nac + "T00:00:00.000-03:00")
				this.form.name = data.name
				this.form.lastname = data.lastname
				
				this.form.pais_id = data.address[0].pais_id
				this.form.localidad_id = data.address[0].localidad_id
				this.form.barrio_id = data.address[0].barrio_id

				//this.form = this.removeNullValues(this.form);
			} else {
				this.labelType = "info";
				this.toastMessage = "El DNI indicado no se encuentra registrado";
				/*this.form = {};
				this.form = this.form_temp;
				this.form_temp = {};*/
			}
			this.input_disable = false
		},
        removeNullValues(data) {
			return Object.fromEntries(Object.entries(data).filter(([key, value]) => value !== null && value !== undefined));
		},
    },
    watch:{
        
    },
    computed: {
		barriosComputed: function () {
			return this.barrios.filter(
				(barrio) => barrio.localidad_id == this.form.localidad_id
			);
		},
	},
});

</script>