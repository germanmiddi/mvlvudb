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
					<label for="escuela_primaria_id" class="block text-sm font-medium text-gray-700">Escuela</label>
					<select v-model="localData.escuela_primaria_id" id="escuela_primaria_id" name="escuela_primaria_id"
						autocomplete="off"
						:class="input_disable ? bg_disable : ''"
						:disabled="input_disable"
						class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
						<option value="" disabled>
							Seleccione una Escuela
						</option>
						<option v-for="escuela in escuelas" :key="escuela.id" :value="escuela.id">
							{{ escuela.description }}
						</option>
					</select>
				</div>
			<!-- </div>

            <div class="grid grid-cols-12 gap-6"> -->
              <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
					<label for="nivel_educativo_id" class="block text-sm font-medium text-gray-700">Nivel Educativo</label>
					<select v-model="localData.nivel_educativo_id" id="nivel_educativo_id" name="nivel_educativo_id"
						autocomplete="off"
						:class="input_disable ? bg_disable : ''"
						:disabled="input_disable"
						class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
						<option value="" disabled>
							Seleccione un Nivel Educativo
						</option>
						<option v-for="nivel in nivelesEducativo" :key="nivel.id" :value="nivel.id">
							{{ nivel.description }}
						</option>
					</select>
				</div>
			<!-- </div>
            
            <div class="grid grid-cols-12 gap-6"> -->
				<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
					<label for="escuela_turno_id" class="block text-sm font-medium text-gray-700">Turno</label>
					<select v-model="localData.escuela_turno_id" id="escuela_turno_id" name="escuela_turno_id"
						autocomplete="off"
						:class="input_disable ? bg_disable : ''"
						:disabled="input_disable"
						class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
						<option value="" disabled>
							Seleccione un turno
						</option>
						<option v-for="turno in turnosEducativo" :key="turno.id" :value="turno.id">
							{{ turno.description }}
						</option>
					</select>
				</div>

				<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
					<label for="escuela_dependencia_id" class="block text-sm font-medium text-gray-700">Dependencia</label>
					<select v-model="localData.escuela_dependencia_id" id="escuela_dependencia_id" name="escuela_dependencia_id"
						autocomplete="off"
						:class="input_disable ? bg_disable : ''"
						:disabled="input_disable"
						class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
						<option value="" disabled>
							Seleccione una dependencia
						</option>
						<option v-for="dependencia in escuelasDependencia" :key="dependencia.id" :value="dependencia.id">
							{{ dependencia.description }}
						</option>
					</select>
				</div>

				<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
					<label for="escuela_localidad_id" class="block text-sm font-medium text-gray-700">Localidad</label>
					<select v-model="localData.escuela_localidad_id" id="escuela_localidad_id" name="escuela_localidad_id"
						autocomplete="off"
						:class="input_disable ? bg_disable : ''"
						:disabled="input_disable"
						class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
						<option value="" disabled>
							Seleccione una Localidad
						</option>
						<option v-for="localidad in localidades" :key="localidad.id" :value="localidad.id">
							{{ localidad.description }}
						</option>
					</select>
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
    nivelesEducativo: Object,
	turnosEducativo: Object,
	escuelas: Object,
	escuelasDependencia: Object,
	localidades: Object
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