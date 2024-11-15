<template>
  <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
    <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
      <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
        <div>
          <h3 class="text-lg leading-6 font-medium text-gray-900">
            Pedagogía
          </h3>
        </div>
      </div>
      <div class="grid grid-cols-12 gap-6">
        <!-- Realizó Prueba -->
        <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
          <label for="realizo_prueba" class="block text-sm font-medium text-gray-700">Realizó Prueba</label>
          <Switch v-model="localData.realizo_prueba" :disabled="input_disable"
            @click="localData.realizo_prueba = !localData.realizo_prueba"
            :class="localData.realizo_prueba ? 'bg-blue-600' : 'bg-gray-200'"
            class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
            <span :class="localData.realizo_prueba ? 'translate-x-6' : 'translate-x-1'"
              class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
          </Switch>
        </div>

        <!-- Estado -->
        <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
          <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
          <select v-model="localData.estado_id" id="estado" name="estado" autocomplete="off"
            :class="input_disable ? bg_disable : ''"
            :disabled="input_disable"
            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="" disabled>Seleccione un estado</option>
            <option v-for="estadoPedagogia in estadosPedagogia" :key="estadoPedagogia.id"
                  :value="estadoPedagogia.id">
                  {{ estadoPedagogia.description }}
                </option>
          </select>
        </div>

        <!-- Fecha de Prueba -->
        <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
            <label for="fecha_prueba" class="block text-sm font-medium text-gray-700">Fecha de la Prueba</label>
            <Datepicker
              class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
              v-model="localData.fecha_prueba" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
              :enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
            </Datepicker>
        </div>
      </div>
      
      <hr>

      <!-- Profesional -->
      <div>
      <label for="profesional" class="block text-gray-700 font-medium">Profesional</label>
      <input
        type="text"
        id="profesional"
        v-model="localData.profesional"
        placeholder="Escribe el nombre del profesional..."
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
      />
    </div>
      <!-- Observación -->
      <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
          <label for="detalles" class="block text-sm font-medium text-gray-700">Observación</label>
          <div class="mt-1">
            <textarea v-model="localData.detalles" id="detalles" name="detalles" rows="3"
              class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"
              :disabled="input_disable" :class="input_disable ? bg_disable : ''"></textarea>
          </div>
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
    estadosPedagogia: Object,
  },
  components: {
    Datepicker,
  },
  data() {
    return {
      localData: this.data,
      dateTest: {}
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
      console.log(this.localData);
      this.$emit('data_pedagogia', this.localData);
    }
  }
};
</script>