<template>
<div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
    <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Declaración Jurada del Tramite
            </h3>
        </div>

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 sm:col-span-3">
                <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha de Admisión</label>
                <Datepicker
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    v-model="form.fecha" :enableTimePicker="false" :monthChangeOnScroll="true" autoApply
                    :format="format"
                        >
                </Datepicker>
                <span v-if="v$.form.fecha.$error" class="text-red-500 text-xs">Campo obligatorio</span>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="sede_id" class="block text-sm font-medium text-gray-700">Sede</label>
                <select v-model="form.sede_id" id="sede_id" name="sede_id"
                    autocomplete="off"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" disabled>Seleccione una sede</option>
                    <option v-for="sede in this.sedes" :key="sede.id"
                        :value="sede.id">{{
                            sede.description
                    }}</option>
                </select>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="tratamiento" class="block text-sm font-medium text-gray-700">Tratamiento</label>
                <select v-model="form.tratamiento_id" id="tratamiento_id" name="tratamiento_id"
                    autocomplete="off"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" disabled>
                        Seleccione un Tratamiento
                    </option>
                    <!--  <option v-for="canalAtencion in canalesAtencion" :key="canalAtencion.id"
                        :value="canalAtencion.id">
                        {{ canalAtencion.description }}
                    </option> -->
                </select>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="estado_id" class="block text-sm font-medium text-gray-700">Estado</label>
                <select v-model="form.estado_id" id="estado_id" name="estado_id"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" disabled>
                        Seleccione un estado
                    </option>
                </select>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="origen_demanda_id" class="block text-sm font-medium text-gray-700">Origen Demanda</label>
                <select v-model="form.origen_demanda_id" id="origen_demanda_id" name="origen_demanda_id"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" disabled>
                        Seleccione un origen de demanda
                    </option>
                    <!--  <option class="capitalize" v-for="modatencion in modalidadesAtencion" :key="modatencion.id"
                        :value="modatencion.id">
                        {{ modatencion.description }}
                    </option> -->
                </select>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="motivo_baja_id" class="block text-sm font-medium text-gray-700">Motivo de baja</label>
                <select v-model="form.motivo_baja_id" id="motivo_baja_id" name="motivo_baja_id"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" disabled>
                        Seleccione un motivo de baja
                    </option>
                    <!--  <option class="capitalize" v-for="modatencion in modalidadesAtencion" :key="modatencion.id"
                        :value="modatencion.id">
                        {{ modatencion.description }}
                    </option> -->
                </select>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="derivacion_id" class="block text-sm font-medium text-gray-700">Derivación</label>
                <select v-model="form.derivacion_id" id="derivacion_id" name="derivacion_id"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" disabled>
                        Seleccione una derivacion
                    </option>
                    <!--  <option class="capitalize" v-for="modatencion in modalidadesAtencion" :key="modatencion.id"
                        :value="modatencion.id">
                        {{ modatencion.description }}
                    </option> -->
                </select>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label for="articulacion_id" class="block text-sm font-medium text-gray-700">Articulación</label>
                <select v-model="form.articulacion_id" id="articulacion_id" name="articulacion_id"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" disabled>
                        Seleccione una articulacion
                    </option>
                    <!--  <option class="capitalize" v-for="modatencion in modalidadesAtencion" :key="modatencion.id"
                        :value="modatencion.id">
                        {{ modatencion.description }}
                    </option> -->
                </select>
            </div>

        </div>
        <hr>
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 sm:col-span-3">
                <label for="motivo_select" class="block text-sm font-medium text-gray-700">Motivo de la Consulta</label>
                <select v-model="motivo_select" id="motivo_select" name="motivo_select"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" disabled>
                        Seleccione un motivo de consulta
                    </option>
                    <option class="capitalize" v-for="motivo in motivo_consultas" :key="motivo.id"
                        :value="motivo.id">
                        {{ motivo.description }}
                    </option>
                </select>
            </div>

            <div class="col-span-12 sm:col-span-3">
                <button type="button"
                    class="mt-6 relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                    @click.prevent="add_motivo()">
                    Agregar Motivo
                </button>
            </div>

            <div class="col-span-12 sm:col-span-12">
                <div v-for="mo in this.form.motivo_consultas_id" :key="mo.id" class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 mr-2">
                    {{mo.description}} <button @click="delete_motivo(mo.id)"><XMarkIcon class="ml-2 flex-shrink-0 h-4 w-4 text-red-500"></XMarkIcon></button>
                </div>

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
        sedes: Object,
        motivo_consultas: Object
    },
    components: {
        required,
		useVuelidate,
		helpers,
		minLength,
        Datepicker,
        XMarkIcon,
    },
    data() {
        return {
            datepickerStyle: {
				color: 'red',
				border: '1px solid red',
			},
            viewModal: false,
            motivos_select: [],
            motivo_select: ''
        }
    },
	validations() {
		return {
			form: {
				fecha: { required: helpers.withMessage('El campo Fecha es Obligatorio', required) }
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
        add_motivo(){
            let resultado = this.motivo_consultas.find( motivo => motivo.id === this.motivo_select );
            if(resultado){
                let existe_motivo = this.form.motivo_consultas_id.find( motivo => motivo.id === this.motivo_select );
                if(existe_motivo){
                    this.$emit('message', {labelType: 'danger', toastMessage: 'El motivo fue incluido previamente'});
                }else{
                    this.form.motivo_consultas_id.push(resultado)
                    this.$emit('message', {labelType: 'success', toastMessage: 'El motivo se ha incluido correctamente'});
                }
            }
        },
        delete_motivo(id){
                let index_motivo = this.form.motivo_consultas_id.findIndex( motivo => motivo.id === id );
                this.form.motivo_consultas_id.splice(index_motivo,1)
                this.$emit('message', {labelType: 'success', toastMessage: 'El motivo se ha eliminado correctamente'});
            }
    },
    
    watch:{
        
    },
    created(){
       //this.form.motivo_consultas_id = []
    }
});

</script>