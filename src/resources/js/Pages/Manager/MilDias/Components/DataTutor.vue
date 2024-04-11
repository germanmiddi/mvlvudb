<template>
<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
    <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">
               Datos del Tutor
            </h3>
        </div>

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 sm:col-span-3">
                <label for="tutor_name" class="block text-sm font-medium text-gray-700">Nombre Adulto Responsable</label>
                <input v-model="form.tutor_name" type="text" name="tutor_name" id="tutor_name" autocomplete="tutor_name"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="tutor_vinculo_id" class="block text-sm font-medium text-gray-700">Vinculo con NN/A</label>
                <select v-model="form.tutor_vinculo_id" id="tutor_vinculo_id" name="tutor_vinculo_id" autocomplete="off"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option disabled value="">
                        Selecciones un vinculo
                    </option>
                    <option v-for="parentesco in parentescos" :key="parentesco.id" :value="parentesco.id"
                        :bind:select="parentesco.id == form.tutor_vinculo_od">
                        {{ parentesco.description }}
                    </option>
                </select>
            </div>
            <div class="col-span-12 sm:col-span-3">
                <label for="cant_convivientes" class="block text-sm font-medium text-gray-700">Cantidad de convivientes</label>
                <input v-model="form.cant_convivientes" type="text" name="cant_convivientes" id="cant_convivientes" autocomplete="off"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                
            </div>
        </div>
        <hr>
        <h3>Datos de la Madre</h3>
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 sm:col-span-3">
                <label for="madre_name" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input v-model="form.madre_name" type="text" name="madre_name" id="madre_name" autocomplete="off"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    
                    :disabled="input_disable" />
                
            </div>

            <div class="col-span-12 sm:col-span-2">
                <label for="madre_edad" class="block text-sm font-medium text-gray-700">Edad</label>
                <input v-model="form.madre_edad" type="text" name="madre_edad" id="madre_edad" autocomplete="off"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                
            </div>

            <div class="col-span-12 sm:col-span-2">
                <label for="madre_pais_id" class="block text-sm font-medium text-gray-700">Nacionalidad</label>
                <select v-model="form.madre_pais_id" id="madre_pais_id" name="madre_pais_id" autocomplete="off"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option disabled value="">
                        Selecciones un pais
                    </option>
                    <option v-for="pais in paises" :key="pais.id" :value="pais.id"
                        :bind:select="pais.id == form.madre_pais_id">
                        {{ pais.description }}
                    </option>
                </select>
            </div>

            <div class="col-span-12 sm:col-span-2">
                <label for="madre_nivel_educativo_id" class="block text-sm font-medium text-gray-700">Nivel educativo alcanzado</label>
                <select v-model="form.madre_nivel_educativo_id" id="madre_nivel_educativo_id" name="madre_nivel_educativo_id" autocomplete="off"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option disabled value="">
                        Selecciones un nivel educativo
                    </option>
                    <option v-for="nivel_educativo in nivelesEducativo" :key="nivel_educativo.id" :value="nivel_educativo.id"
                        :bind:select="nivel_educativo.id == form.pais_id">
                        {{ nivel_educativo.description }}
                    </option>
                </select>
            </div>
            <div class="col-span-12 sm:col-span-3">
                <label for="madre_tipo_ocupacion_id" class="block text-sm font-medium text-gray-700">Ocupación</label>
                <select v-model="form.madre_tipo_ocupacion_id" id="madre_tipo_ocupacion_id" name="madre_tipo_ocupacion_id" autocomplete="off"
                    
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option disabled value="">
                        Selecciones un tipo de educacion
                    </option>
                    <option v-for="tipo_ocupacion in tiposOcupacion" :key="tipo_ocupacion.id" :value="tipo_ocupacion.id"
                        :bind:select="tipo_ocupacion.id == form.madre_tipo_ocupacion_id">
                        {{ tipo_ocupacion.description }}
                    </option>
                </select>
            </div>
        </div>

        <hr>
        <h3>Datos del Padre</h3>
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 sm:col-span-3">
                <label for="padre_name" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input v-model="form.padre_name" type="text" name="padre_name" id="padre_name" autocomplete="off"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    
                    :disabled="input_disable" />
                
            </div>

            <div class="col-span-12 sm:col-span-2">
                <label for="padre_edad" class="block text-sm font-medium text-gray-700">Edad</label>
                <input v-model="form.padre_edad" type="text" name="padre_edad" id="padre_edad" autocomplete="off"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                
            </div>

            <div class="col-span-12 sm:col-span-2">
                <label for="padre_pais_id" class="block text-sm font-medium text-gray-700">Nacionalidad</label>
                <select v-model="form.padre_pais_id" id="padre_pais_id" name="padre_pais_id" autocomplete="off"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option disabled value="">
                        Selecciones un pais
                    </option>
                    <option v-for="pais in paises" :key="pais.id" :value="pais.id"
                        :bind:select="pais.id == form.padre_pais_id">
                        {{ pais.description }}
                    </option>
                </select>
            </div>

            <div class="col-span-12 sm:col-span-2">
                <label for="padre_nivel_educativo_id" class="block text-sm font-medium text-gray-700">Nivel educativo alcanzado</label>
                <select v-model="form.padre_nivel_educativo_id" id="padre_nivel_educativo_id" name="padre_nivel_educativo_id" autocomplete="off"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option disabled value="">
                        Selecciones un nivel educativo
                    </option>
                    <option v-for="nivel_educativo in nivelesEducativo" :key="nivel_educativo.id" :value="nivel_educativo.id"
                        :bind:select="nivel_educativo.id == form.padre_nivel_educativo_id">
                        {{ nivel_educativo.description }}
                    </option>
                </select>
            </div>
            <div class="col-span-12 sm:col-span-3">
                <label for="padre_tipo_ocupacion_id" class="block text-sm font-medium text-gray-700">Ocupación</label>
                <select v-model="form.padre_tipo_ocupacion_id" id="padre_tipo_ocupacion_id" name="padre_tipo_ocupacion_id" autocomplete="off"
                    
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option disabled value="">
                        Selecciones un tipo de educacion
                    </option>
                    <option v-for="tipo_ocupacion in tiposOcupacion" :key="tipo_ocupacion.id" :value="tipo_ocupacion.id"
                        :bind:select="tipo_ocupacion.id == form.padre_tipo_ocupacion_id">
                        {{ tipo_ocupacion.description }}
                    </option>
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
        barrios: Object,
        parentescos: Object,
        paises: Object,
        nivelesEducativo: Object,
        tiposOcupacion: Object
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
        }
    },
	validations() {
		return {
			form: {
				/* fecha: { required: helpers.withMessage('El campo Fecha es Obligatorio', required) },
				tratamiento_id: { required: helpers.withMessage('El campo Tratamiento es Obligatorio', required) },
				tipo_documento_id: { required: helpers.withMessage('El campo Tipo de Documento es Obligatorio', required) },
				num_documento: { required: helpers.withMessage('El campo N° de documento es Obligatorio', required) }, // Matches this.contact.email
				name: { required: helpers.withMessage('El campo Nombre es Obligatorio', required) },
				lastname: { required: helpers.withMessage('El campo Apellido es Obligatorio', required) },
				fecha_nac: { required: helpers.withMessage('El campo Fecha de Nacimiento es Obligatorio', required) }, */
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
        }
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