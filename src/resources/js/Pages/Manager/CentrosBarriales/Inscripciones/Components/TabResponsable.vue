<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Datos de Adulto Responsable
                    </h3>
                </div>
                <div class="flex-shrink-0">
                    
                </div>
            </div>
            <div class="grid grid-cols-12 gap-6">
							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Tipo de
									Documento</label>
								<select v-model="localData.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
									autocomplete="off"
									:class="v.form.responsable?.tipo_documento_id?.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
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
								<span v-if="v.form.responsable?.tipo_documento_id?.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de
									Documento</label>
								<div class="relative">
									<input type="text" v-model="localData.num_documento" @keyup.enter="getPerson()" :class="v.form.tipo_documento_id?.name?.$error ? 'border-red-500' : input_disable ? bg_disable : ''" :disabled="input_disable"
										class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
									<a @click="getPerson()"
										class="absolute inset-y-0 right-0 px-4 py-2 bg-green-200 text-white text-xs rounded-r-md hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-600  shadow-sm text-xs font-medium flex items-center  text-green-900 hover:text-white">
										Verificar
									</a>
								</div>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
								<input v-model="localData.name" type="text" name="name" id="name" autocomplete="name"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v.form.responsable?.name?.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable" />
									<span v-if="v.form.responsable?.name?.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
								<input v-model="localData.lastname" type="text" name="lastname" id="lastname" autocomplete="name"
									class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									:class="v.form.responsable?.lastname?.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:disabled="input_disable" />
								<span v-if="v.form.responsable?.lastname?.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
							</div>

							<div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
								<label for="fecha_nac" class="block text-sm font-medium text-gray-700">Fecha de
									Nacimiento</label>
								<Datepicker
									class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
									v-model="localData.fecha_nac"
									:disabled="input_disable" :class="v.form.responsable?.fecha_nac?.$error ? 'border-red-500' : input_disable ? bg_disable : ''"
									:enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
								</Datepicker>
								<span v-if="v.form.responsable?.fecha_nac?.$error" class="text-red-500 text-xs">Campo
									obligatorio</span>
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
    tiposDocumento: Object,
	v: Object
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
    async getPerson() {
		let num_documento = this.localData.num_documento;
		const get = `${route('persons.getPersonDni', this.localData.num_documento)}`
		const response = await fetch(get, { method: 'GET' })
		let data = await response.json()
		if (!data.data.length == 0) {
			data = data.data[0].person
			
				this.localData.num_documento = num_documento;
				/// Recuperar datos.
				this.localData.tipo_documento_id = data.tipo_documento_id
				this.localData.fecha_nac = data.fecha_nac
				this.localData.fecha_nac = new Date(this.localData.fecha_nac + "T00:00:00.000-03:00")
				this.localData.name = data.name
				this.localData.lastname = data.lastname
			
		} else {
			this.labelType = "info";
			this.toastMessage = "El DNI indicado no se encuentra registrado";
			this.localData.num_documento = num_documento;
		}
	},
	updateParent() {
      this.$emit('data_salud', this.localData);
    },
  }
};
</script>