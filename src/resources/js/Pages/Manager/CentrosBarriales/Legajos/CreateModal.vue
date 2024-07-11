<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <TransitionRoot as="template" :show="open">
      <Dialog as="div" class="fixed z-10 inset-0 overflow-y-auto" @close="$emit('closeForm')" >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
            <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
          </TransitionChild>
  
          <!-- This element is to trick the browser into centering the modal contents. -->
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full sm:p-6">
              <div>
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                  <CheckIcon class="h-6 w-6 text-green-600" aria-hidden="true" />
                </div>
                <div class="mt-3 text-center sm:mt-5">
                  <div class="px-1">
                      <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                          <div class="px-4 py-5 sm:px-6">
                              <h3 class="text-lg leading-6 font-medium text-gray-900">Nueva Inscripción</h3>
                              <p class="mt-1 max-w-2xl text-sm text-gray-500">Formulario de inscripción a Programas Sociales y Actividades</p>
                          </div>

                          <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                              <dl class="sm:divide-y sm:divide-gray-200">
                                  <div class="bg-white pt-5 pb-6 mt-2 px-4">

                                      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                          <div class="flex items-center justify-center border border-gray-200 rounded dark:border-gray-700">
                                              <input v-model="selectedOption" :checked="selectedOption === 'programa_social'" id="programa_social" type="radio" value="programa_social" name="bordered-radio" class="ml-4 rounded-md w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                              <label for="programa_social" class="flex-1 py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Programa Social</label>
                                          </div>
                                          <div class="flex items-center justify-center border border-gray-200 rounded dark:border-gray-700">
                                              <input v-model="selectedOption" :checked="selectedOption === 'actividades'" id="actividades" type="radio" value="actividades" name="bordered-radio" class="ml-4 rounded-md w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                              <label for="actividades" class="flex-1 py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Actividades</label>
                                          </div>
                                      </div>
                                  </div>
                              </dl>
                          </div>

                          <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                              <dl class="sm:divide-y sm:divide-gray-200">
                                  <div class="bg-white pt-5 pb-6 mt-2 px-4">

                                      <div class="grid grid-cols-5 gap-4 pt-5" v-if="selectedOption==='programa_social'">
                                          <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Programa Social: </label>
                                          <div class="mt-1 col-span-4">
                                              <select v-model="form.programa_social_id" id="programa_social_id" name="programa_social_id"
                                                  autocomplete="off"
                                                  :class="input_disable ? bg_disable : ''"
                                                  :disabled="input_disable"
                                                  class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                  <option value="" disabled>
                                                      Seleccione un Programa Social
                                                  </option>
                                                  <option v-for="p in programasSociales" :key="p.id" :value="p.id">
                                                      {{ p.description ?? '' }}
                                                  </option>
                                              </select>
                                          </div>
                                      </div>

                                      <div class="grid grid-cols-5 gap-4 pt-5" v-if="selectedOption==='actividades'">
                                          <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Actividades: </label>
                                          <div class="mt-1 col-span-4">
                                              <select v-model="form.actividad_id" id="actividad_id" name="actividad_id"
                                                  autocomplete="off"
                                                  :class="input_disable ? bg_disable : ''"
                                                  :disabled="input_disable"
                                                  class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                  <option value="" disabled>
                                                      Seleccione una Actividad
                                                  </option>
                                                  <option v-for="a in actividades" :key="a.id" :value="a.id">
                                                      {{ a.description ?? '' }}
                                                  </option>
                                              </select>
                                          </div>
                                      </div>

                                      <div class="grid grid-cols-5 gap-4 pt-5">
                                          <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Fecha Inscripción: </label>
                                          <div class="mt-1 col-span-4">
                                              <Datepicker
                                                  class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                  v-model="form.fecha_inscripcion"
                                                  :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                                                  :enableTimePicker="false" :monthChangeOnScroll="false" autoApply :format="format">
                                              </Datepicker>
                                          </div>
                                      </div>
                                      <div class="grid grid-cols-5 gap-4 pt-5" v-if="selectedOption==='programa_social'">
                                          <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Profesional: </label>
                                          <div class="mt-1 col-span-4">
                                              <select v-model="form.profesional_id" id="profesional_id" name="profesional_id"
                                                  autocomplete="off"
                                                  :class="input_disable ? bg_disable : ''"
                                                  :disabled="input_disable"
                                                  class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                  <option value="" disabled>
                                                      Seleccione un Profesional
                                                  </option>
                                                  <option v-for="p in users" :key="p.id" :value="p.id">
                                                      {{ p.name ?? '' }}
                                                  </option>
                                              </select>
                                          </div>
                                      </div>

                                  </div>
                              </dl>
                              <dl class="sm:divide-y sm:divide-gray-200">
                              <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-end">
                                  <button type="submit" @click="$emit('closeForm')" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancelar</button>
                                  <button type="submit" @click="submit()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ml-2">Guardar</button>
                              </div>
                          </dl>
                          </div>

                      </div>
                  </div>
                </div>
              </div>
            </div>
          </TransitionChild>
        </div>
      </Dialog>
    </TransitionRoot>
  </template>
  
  <script>
  import { ref, defineProps } from 'vue'
  import { Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
  import { CheckIcon } from '@heroicons/vue/24/outline'
  import Datepicker from "@vuepic/vue-datepicker";
  import "@vuepic/vue-datepicker/dist/main.css";

  export default {
    props: {
      open: Boolean,
      users: Object,
      programasSociales: Object,
      actividades: Object
    },
    components: {
      Dialog,
      DialogOverlay,
      DialogTitle,
      TransitionChild,
      TransitionRoot,
      CheckIcon,
      Datepicker,
    },
    data() {
        return {
            selectedOption: 'programa_social',
            form: {}
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
		};
	},
    methods: {
        async submit(){
            // RUTA
            let rt = route("legajoCB.storeProgramaSocial");

            this.form.selectedOption = this.selectedOption
            this.$emit('submitStore', this.form);
        }
    }

  }
  </script>