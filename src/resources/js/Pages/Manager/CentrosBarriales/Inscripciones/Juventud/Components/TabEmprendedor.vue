<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Emprendedor
                    </h3>
                </div>
                <div class="flex-shrink-0">
                    
                </div>
            </div>
            <div class="grid grid-cols-12 gap-6">
                <!-- <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
                    <label for="localidad_id" class="block text-sm font-medium text-gray-700">Localidad</label>
                    <select v-model="localData.localidad_id" id="localidad_id" name="localidad_id" autocomplete="off"
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

                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-4">
                    <label for="calle" class="block text-sm font-medium text-gray-700">Calle</label>
                    <input v-model="localData.calle" type="text" name="calle" id="calle" autocomplete="off"
                        :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>
              </div>
              
              <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
                    <label for="number" class="block text-sm font-medium text-gray-700">Número</label>
                    <input v-model="localData.number" type="text" name="number" id="number" autocomplete="off"
                        :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>
                
                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
                    <label for="piso" class="block text-sm font-medium text-gray-700">Piso</label>
                    <input v-model="localData.piso" type="text" name="piso" id="piso" autocomplete="off"
                        :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>
                
                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
                    <label for="dpto" class="block text-sm font-medium text-gray-700">Departamento</label>
                    <input v-model="localData.dpto" type="text" name="dpto" id="dpto" autocomplete="off"
                        :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div> -->
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
      this.$emit('data_emprendedor', this.localData);
    }
  }
};
</script>