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
        <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
          <label for="participa" class="block text-sm font-medium text-gray-700">Participa</label>
          <select id="participa" name="participa" autocomplete="off" v-model="localData.participa"
            :class="input_disable ? bg_disable : ''" :disabled="input_disable"
            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="" disabled>
              Seleccione participación
            </option>
            <option value="1">SI</option>
            <option value="2">NO</option>
          </select>
        </div>

        <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
          <label for="fecha_vencimiento_cud" class="block text-sm font-medium text-gray-700">Fecha de Inscripción</label>
          <Datepicker v-model="localData.fecha_inscripcion"
            class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
            :disabled="input_disable" :class="input_disable ? bg_disable : ''" :enableTimePicker="false"
            :monthChangeOnScroll="false" autoApply :format="format">
          </Datepicker>
        </div>

        <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
          <label for="fecha_vencimiento_cud" class="block text-sm font-medium text-gray-700">Fecha de Finalización</label>
          <Datepicker
            class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
            v-model="localData.fecha_finalizacion" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
            :enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
          </Datepicker>
        </div>

        <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
          <label for="oficio_id" class="block text-sm font-medium text-gray-700">Oficio</label>
          <select id="oficio_id" name="oficio_id" autocomplete="off" v-model="localData.oficio_id"
            :class="input_disable ? bg_disable : ''" :disabled="input_disable"
            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="" disabled>
              Seleccione un oficio
            </option>
            <option value="1">Artesanías</option>
            <option value="2">Indumentaria</option>
            <option value="3">Panadería</option>
            <option value="4">Manicuría</option>
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
    localidades: Object
  },
  components: {
    Datepicker,
  },
  data() {
    return {
      localData: this.data
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
    this.localData = this.form;
  },
  methods: {
    updateParent() {
      this.$emit('data_emprendedor', this.localData);
    }
  }
};
</script>
