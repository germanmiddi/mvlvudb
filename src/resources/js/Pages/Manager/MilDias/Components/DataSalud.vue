<template>
<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
    <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">
               Datos de Salud
            </h3>
        </div>

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 sm:col-span-3">
                <label for="intervencion_servicio_local" class="block text-sm font-medium text-gray-700">Intervencion del Servicio Local</label>
                <select v-model="form.intervencion_servicio_local" id="intervencion_servicio_local" name="intervencion_servicio_local" autocomplete="off"
                    
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option disabled value="">
                        Selecciones intervencion de servicio local
                    </option>
                    <option value="1" selected>Si</option>
					<option value="0" selected>No</option>
                </select>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="proteccion_integral" class="block text-sm font-medium text-gray-700">Medidas de Protección Integral</label>
                <select v-model="form.proteccion_integral" id="proteccion_integral" name="proteccion_integral" autocomplete="off"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option disabled value="">
                        Selecciones proteccion integral
                    </option>
                    <option value="1" selected>Si</option>
					<option value="0" selected>No</option>
                </select>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="enfermedad_cronica" class="block text-sm font-medium text-gray-700">Enfermedades Cronicas</label>
                <select v-model="form.enfermedad_cronica" id="enfermedad_cronica" name="enfermedad_cronica" autocomplete="off"
                    
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option disabled value="">
                        Seleccione estado de enfermedad cronica
                    </option>
					<option class="capitalize" v-for="enfermedad in tipoEnfermedades" :key="enfermedad.id"
                        :value="enfermedad.id">
                        {{ enfermedad.description }}
                    </option>
                </select>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="parto_prematuro" class="block text-sm font-medium text-gray-700">Parto Prematuro</label>
                <select v-model="form.parto_prematuro" id="parto_prematuro" name="parto_prematuro" autocomplete="off"
                    
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option disabled value="">
                        Seleccione parto prematuro
                    </option>
                    <option value="1" selected>Si</option>
					<option value="0" selected>No</option>
                </select>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="lactancia" class="block text-sm font-medium text-gray-700">Lactancia</label>
                <select v-model="form.lactancia" id="lactancia" name="lactancia" autocomplete="off"
                    
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option disabled value="">
                        Selecciones estado lactancia
                    </option>
                    <option value="1" selected>Si</option>
					<option value="0" selected>No</option>
                </select>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="consumo_durante_embarazo" class="block text-sm font-medium text-gray-700">Consumo durante el Embarazo</label>
                <select v-model="form.consumo_durante_embarazo" id="consumo_durante_embarazo" name="consumo_durante_embarazo" autocomplete="off"
                    
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option disabled value="">
                        Seleccione consumo
                    </option>
                    <option value="1" selected>Si</option>
					<option value="0" selected>No</option>
                </select>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="antecedente_familiar" class="block text-sm font-medium text-gray-700">Antecedentes Familiares en Salud</label>
                <select v-model="form.antecedente_familiar" id="antecedente_familiar" name="antecedente_familiar" autocomplete="off"
                    
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option disabled value="">
                        Seleccione antecedente salud
                    </option>
                    <option value="1" selected>Si</option>
					<option value="0" selected>No</option>
                </select>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="antecedente_libertad" class="block text-sm font-medium text-gray-700">Progenitores con Antecedentes o Priv. de Libertad</label>
                <select v-model="form.antecedente_libertad" id="antecedente_libertad" name="antecedente_libertad" autocomplete="off"
                    
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option disabled value="">
                        Selecciones antecedente familiar
                    </option>
					<option class="capitalize" v-for="antecedente in familarAntecedentes" :key="antecedente.id"
                        :value="antecedente.id">
                        {{ antecedente.description }}
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
        familarAntecedentes: Object,
        tipoEnfermedades: Object
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