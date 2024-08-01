<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Gabinete
                    </h3>
                </div>
                <div class="flex-shrink-0">

                </div>
            </div>
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
					<label for="escuela_primaria_id" class="block text-sm font-medium text-gray-700">Estado</label>
					<select id="escuela_primaria_id" name="escuela_primaria_id"
						autocomplete="off"
						:class="input_disable ? bg_disable : ''"
						:disabled="input_disable"
						class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
						<option value="" disabled>
							Seleccione un estado
						</option>
						<option value="1">No participa</option>
                        <option value="2">Alta</option>
                        <option value="3">Derivado</option>
                        <option value="4">Psicología</option>
                        <option value="5">Psicopedagogía</option>
                        <option value="6">Ambos</option>
					</select>
				</div>
            </div>
            <hr>
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 sm:col-span-9 md:col-span-9 xl:col-span-9">
                    <label for="programa_social_id" class="block text-sm font-medium text-gray-700">Observación</label>
                    <div class="mt-1">
                    <textarea id="observacion" name="observacion" rows="3" :disabled="input_disable"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"
                    :class="input_disable ? bg_disable : ''"/>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  props: {
    form: Object,
    input_disable: Boolean,
    localidades: Object
  },
  data() {
    return {
      localData: this.data,
      //input_disable: this.disabled
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
      this.$emit('data_gabinete', this.localData);
    }
  }
};
</script>
