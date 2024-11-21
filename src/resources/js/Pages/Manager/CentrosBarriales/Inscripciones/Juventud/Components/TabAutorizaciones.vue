<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Autorizaciones
                    </h3>
                </div>
                <div class="flex-shrink-0">
                    
                </div>
            </div>
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
                    <label for="programa_social_id" class="block text-sm font-medium text-gray-700">Aut. Firmada</label>
                        <Switch v-model="localData.autorizacion_firmada" :disabled="input_disable"
                                @click="localData.autorizacion_firmada = !localData.autorizacion_firmada"
                                :class="localData.autorizacion_firmada ? 'bg-blue-600' : 'bg-gray-200'"
                                class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
                                <span :class="localData.autorizacion_firmada ? 'translate-x-6' : 'translate-x-1'"
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
                        </Switch>   
                </div>

                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
                    <label for="programa_social_id" class="block text-sm font-medium text-gray-700">Aut. Retirarse</label>
                        <Switch v-model="localData.autorizacion_retirarse" :disabled="input_disable"
                                @click="localData.autorizacion_retirarse = !localData.autorizacion_retirarse"
                                :class="localData.autorizacion_retirarse ? 'bg-blue-600' : 'bg-gray-200'"
                                class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
                                <span :class="localData.autorizacion_retirarse ? 'translate-x-6' : 'translate-x-1'"
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
                        </Switch>   
                </div>
              </div>
              <hr>
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
                    <label for="programa_social_id" class="block text-sm font-medium text-gray-700">Aut. Uso Imagen</label>
                        <Switch v-model="localData.autorizacion_uso_imagen" :disabled="input_disable"
                                @click="localData.autorizacion_uso_imagen = !localData.autorizacion_uso_imagen"
                                :class="localData.autorizacion_uso_imagen ? 'bg-blue-600' : 'bg-gray-200'"
                                class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
                                <span :class="localData.autorizacion_uso_imagen ? 'translate-x-6' : 'translate-x-1'"
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
                        </Switch>   
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
      this.$emit('data_autorizaciones', this.localData);
    }
  }
};
</script>