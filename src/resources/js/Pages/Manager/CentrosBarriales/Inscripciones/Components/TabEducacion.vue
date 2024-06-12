<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Datos de Educación
                    </h3>
                </div>
                <div class="flex-shrink-0">
                    
                </div>
            </div>
            <div class="grid grid-cols-12 gap-6">
              <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Situación Educativa</label>
								<select v-model="localData.situacion_educativa_id" id="tipo_documento_id" name="tipo_documento_id"
									autocomplete="off"
									:class="input_disable ? bg_disable : ''"
									:disabled="input_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un comedor
									</option>
									<option value="PRIMARIA_INCOMPLETA">PRIMARIA INCOMPLETA</option>
									<option value="PRIMARIA_COMPLETA">PRIMARIA COMPLETA</option>
									<option value="SECUNDARIA_INCOMPLETA">SECUNDARIA INCOMPLETA</option>
									<option value="SECUNDARIA_COMPLETA">SECUNDARIA COMPLETA</option>
									<option value="TERCIARIO_INCOMPLETO">TERCIARIO INCOMPLETO</option>
									<option value="TERCIARIO_COMPLETO">TERCIARIO COMPLETO</option>
									<option value="UNIVERSITARIO_INCOMPLETO">UNIVERSITARIO INCOMPLETO</option>
									<option value="UNIVERSITARIO_COMPLETO">UNIVERSITARIO COMPLETO</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Institucion Educativa</label>
								<select v-model="localData.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
									autocomplete="off"
									:class="input_disable ? bg_disable : ''"
									:disabled="input_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione una institucion
									</option>
									<option value="ESCUELA_ALMAFUERTE">ESCUELA ALMAFUERTE</option>
									<option value="ESCUELA_AMEGHINO">ESCUELA AMEGHINO</option>
									<option value="ESCUELA_ESPECIAL_N_502">ESCUELA ESPECIAL N 502</option>
									<option value="ESCUELA_ESPECIAL_N_504">ESCUELA ESPECIAL N 504</option>
									<option value="ESCUELA_GRANADEROS">ESCUELA GRANADEROS</option>
									<option value="ESCUELA_MANUEL_DORREGO">ESCUELA MANUEL DORREGO</option>
									<option value="ESCUELA_N_1">ESCUELA N 1</option>
									<option value="ESCUELA_N_2">ESCUELA N 2</option>
									<option value="ESCUELA_N_4">ESCUELA N 4</option>
									<option value="ESCUELA_N_6">ESCUELA N 6</option>
									<option value="ESCUELA_N_7">ESCUELA N 7</option>
									<option value="ESCUELA_N_8">ESCUELA N 8</option>
									<option value="ESCUELA_N_9">ESCUELA N 9</option>
									<option value="ESCUELA_N_10">ESCUELA N 10</option>
									<option value="ESCUELA_N_11">ESCUELA N 11</option>
									<option value="ESCUELA_N_12">ESCUELA N 12</option>
									<option value="ESCUELA_N_13">ESCUELA N 13</option>
									<option value="ESCUELA_N_14">ESCUELA N 14</option>
									<option value="ESCUELA_N_15">ESCUELA N 15</option>
									<option value="ESCUELA_N_16">ESCUELA N 16</option>
									<option value="ESCUELA_N_17">ESCUELA N 17</option>
									<option value="ESCUELA_N_18">ESCUELA N 18</option>
									<option value="ESCUELA_N_19">ESCUELA N 19</option>
									<option value="ESCUELA_N_20">ESCUELA N 20</option>
									<option value="ESCUELA_N_21">ESCUELA N 21</option>
									<option value="ESCUELA_N_22">ESCUELA N 22</option>
									<option value="ESCUELA_N_23">ESCUELA N 23</option>
									<option value="ESCUELA_N_24">ESCUELA N 24</option>
									<option value="ESCUELA_N_32">ESCUELA N 32</option>
									<option value="ESCUELA_N_36">ESCUELA N 36</option>
									<option value="ESCUELA_N_39">ESCUELA N 39</option>
									<option value="ESCUELA_N_48">ESCUELA N 48</option>
									<option value="ESCUELA_N_62">ESCUELA N 62</option>
									<option value="ESCUELA_GUEMES">ESCUELA GUEMES</option>
									<option value="INSTITUTO_CRISTIANO_VTE_LOPEZ">INSTITUTO CRISTIANO VTE LOPEZ</option>
									<option value="INSTITUTO_DULCISIMO_NOMBRE_DE_JESUS">INSTITUTO DULCISIMO NOMBRE DE JESUS</option>
									<option value="INSTITUTO_FATIMA">INSTITUTO FATIMA</option>
									<option value="INSTITUTO_MAIPU">INSTITUTO MAIPU</option>
									<option value="INSTITUTO_MARIA_SANTISIMA_DE_LA_LUZ">INSTITUTO MARIA SANTISIMA DE LA LUZ</option>
									<option value="INSTITUTO_MI_MAÑANA">INSTITUTO MI MAÑANA</option>
									<option value="INSTITUTO_NUESTRA_SEÑORA_DE_LA_MERCED">INSTITUTO NUESTRA SEÑORA DE LA MERCED</option>
									<option value="INSTITUTO_PASTEUR">INSTITUTO PASTEUR</option>
									<option value="INSTITUTO_MARIA_AUXILIADORA">INSTITUTO MARIA AUXILIADORA</option>
									<option value="COLEGIO_SAN_LADISLAO">COLEGIO SAN LADISLAO</option>
									<option value="COLEGIO_SANTA_MAGDALENA">COLEGIO SANTA MAGDALENA</option>
									<option value="COLEGIO_VIRGEN_DEL_CARMEN">COLEGIO VIRGEN DEL CARMEN</option>
									<option value="PRIMARIA_EMMA_PEREZ_FERREIRA">PRIMARIA EMMA PEREZ FERREIRA</option>
									<option value="OTRO">OTRO</option>

								</select>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Curso</label>
								<select v-model="localData.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
									autocomplete="off"
									:class="input_disable ? bg_disable : ''"
									:disabled="input_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un Curso
									</option>
									<option value="1">1°</option>
									<option value="2">2°</option>
									<option value="3">3°</option>
									<option value="4">4°</option>
									<option value="5">5°</option>
									<option value="6">6°</option>
									<option value="7">7°</option>
								</select>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="turno_id" class="block text-sm font-medium text-gray-700">Turno</label>
								<select v-model="localData.turno_id" id="turno_id" name="turno_id"
									autocomplete="off"
									:class="input_disable ? bg_disable : ''"
									:disabled="input_disable"
									class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
									<option value="" disabled>
										Seleccione un comedor
									</option>
									<option value="manana">Mañana</option>
									<option value="tarde">Tarde</option>
									<option value="vespertino">Vespertino</option>
									<option value="doble_turno">Doble Turno</option>
								</select>
							</div>
							
							<div class="col-span-12 xl:col-span-6">
								<label for="observacion" class="block text-sm font-medium text-gray-700">Observaciones
								</label>
								<div class="mt-1">
									<textarea v-model="localData.observacion_educacion" id="observacion" name="observacion" rows="3"
										class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"/>
								</div>
								<p class="mt-2 text-sm text-gray-500">
									Ingrese información adicional del tramite.
								</p>
							</div>
            </div>
        </div>
    </div>
</template>

<script>
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css"; 

export default {
  props: {
    form: Object,
    input_disable: Boolean,
    //localidades: Object
  },
  components: {
		Datepicker,
	},
  data() {
    return {
      localData: this.data,
      //input_disable: this.disabled
    };
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
		};
	},
  watch: {
    value(newValue) {
      this.localData = newValue;
    }
  },
  created() {
    // Inicializar localForm con los valores del form prop si existen
    this.localData = this.form;
    //if (this.form.email) this.localForm.email = this.form.email;
  },
  methods: {
    updateParent() {
      this.$emit('data_educacion', this.localData);
    }
  }
};
</script>