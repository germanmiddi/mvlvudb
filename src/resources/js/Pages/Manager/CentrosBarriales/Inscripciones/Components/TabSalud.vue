<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Salud
                    </h3>
                </div>
                <div class="flex-shrink-0">
                    
                </div>
            </div>
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
                  <label for="apto_medico" class="block text-sm font-medium text-gray-700">Apto Médico</label>
                    <Switch v-model="localData.apto_medico"
                        @click="localData.apto_medico = !localData.apto_medico"
                        :class="localData.apto_medico ? 'bg-blue-600' : 'bg-gray-200'"
                        class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
                        <span :class="localData.apto_medico ? 'translate-x-6' : 'translate-x-1'"
                          class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
                    </Switch>   
                </div>

                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
                  <label for="fecha_apto_medico" class="block text-sm font-medium text-gray-700">Fecha Apto Médico</label>
                  <Datepicker
                    class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    v-model="localData.fecha_apto_medico"
                    :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                    :enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
                  </Datepicker>
                  
                </div>

                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
                  <label for="programa_social_id" class="block text-sm font-medium text-gray-700">Electrocardiograma</label>
                    <Switch v-model="localData.electrocardiograma"
                        @click="localData.electrocardiograma = !localData.electrocardiograma"
                        :class="localData.electrocardiograma ? 'bg-blue-600' : 'bg-gray-200'"
                        class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
                        <span :class="localData.electrocardiograma ? 'translate-x-6' : 'translate-x-1'"
                          class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
                    </Switch>   
                </div>

                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
                  <label for="fecha_electrocardiograma" class="block text-sm font-medium text-gray-700">Fecha Electrocardiograma</label>
                  <Datepicker
                    class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    v-model="localData.fecha_electrocardiograma"
                    :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                    :enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
                  </Datepicker>
                </div>

                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
                  <label for="programa_social_id" class="block text-sm font-medium text-gray-700">CUD</label>
                    <Switch v-model="form.posee_cud"
                        @click="localData.posee_cud = !localData.posee_cud"
                        :class="localData.posee_cud ? 'bg-blue-600' : 'bg-gray-200'"
                        class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
                        <span :class="localData.posee_cud ? 'translate-x-6' : 'translate-x-1'"
                          class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
                    </Switch>   
                </div>


                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
                  <label for="programa_social_id" class="block text-sm font-medium text-gray-700">Cud Presentado</label>
                    <Switch v-model="localData.presento_cud"
                        @click="localData.presento_cud = !localData.presento_cud"
                        :class="localData.presento_cud ? 'bg-blue-600' : 'bg-gray-200'"
                        class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
                        <span :class="localData.presento_cud ? 'translate-x-6' : 'translate-x-1'"
                          class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
                    </Switch>   
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
      this.$emit('data_salud', this.localData);
    }
  }
};
</script>