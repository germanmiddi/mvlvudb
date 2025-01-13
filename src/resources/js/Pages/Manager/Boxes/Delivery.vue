<template>
  <main>
    <div class="border-b border-gray-200 px-4 py-4 flex items-center justify-between sm:px-6 lg:px-8">
      <h1 class="text-xl font-medium leading-6 text-gray-900 sm:truncate">
        Puntos de entrega
      </h1>
      <div class="mt-4 flex sm:mt-0">
        <a @click="showForm = !showForm" class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">
          Nueva Entrega</a>
      </div>
      <!-- <button class="bg-green-600 text-white px-4 rounded-md">Nueva Entrega</button> -->
    </div>
    <!-- <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast> -->

    <div v-if="showForm" class="px-4 mt-6 sm:px-6 lg:px-8">

      <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">

          <div class="flex ">
            
            <h3 class="col-span-12 text-lg leading-6 font-medium text-gray-900">Nueva Entrega</h3>

            <div class="col-span-12 sm:col-span-4 ">
              <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
              <input v-model="filter.name" type="text" name="name" id="name" autocomplete="name-level2"
                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
            </div>

            <div class="col-span-12 sm:col-span-4 ">
              <label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de Documento</label>
              <input v-model="filter.num_documento" type="text" name="num_documento" id="num_documento"
                autocomplete="address-level2"
                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
            </div>

            <button @click="showForm = !showForm;  showPersona = !showPersona" class="col-span-12 sm:col-span-4 bg-green-600 text-white px-4 rounded-md py-2">
              Buscar
            </button>
          </div>
        </div>
      </div>
    </div>

    <Persona v-if="showPersona" />
    <History v-if="showPersona" />

    <div v-if="!showPersona && !showForm" class="px-4 mt-6 sm:px-6 lg:px-8">
      <ul role="list" class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2 xl:grid-cols-3 mt-3">
        <li v-for="item in puntosEntrega" :key="item.id"
          class="relative col-span-1 flex rounded-md hover:opacity-70 duration-300 cursor-pointer my-3">
          <a href="#" class="w-full flex">
            <div class="flex-1 flex items-center justify-between rounded-md truncate w-full bg-gray-100 py-2">
              <div class="flex flex-col space-y-1 px-4 py-2 text-sm truncate w-full">
                <p class="text-gray-900 text-lg font-medium">
                  {{ item.description }}
                </p>
                <div class="flex flex-wrap gap-2">
                  <p class="bg-green-600 text-white text-sm px-1 py-1 rounded-md flex gap-x-1">
                    <CheckCircleIcon class="w-5" />
                    20 Entregas realizadas
                  </p>
                </div>




                <!-- cambiar de ver bandeja a ojito
                        gris fondo - iconos 
                        cambiar letras por una tarjeta de color, verde apra entregadas y amarillo/naranja para las pendientes
                        Quiza el ver mas ver un modal con detalles, que detalles?
                        -->

                <!-- Cuando tenga la bd, hacer un forreach por cada punto de entrega con sus respectivas enmtregas pendientes y realizadas, ytodo esto traido desde el back -->
              </div>
            </div>
          </a>
        </li>
      </ul>
    </div>

  </main>
</template>

<script>
import { ref } from 'vue'
import {
  Menu,
  MenuButton,
  MenuItems,
  MenuItem
} from '@headlessui/vue'

import { ChevronRightIcon, EllipsisVerticalIcon, ClockIcon, CheckCircleIcon, EyeIcon } from '@heroicons/vue/24/solid'
import store from '@/store.js'
import History from './History.vue'
import Persona from './Persona.vue'

export default {
  props: {

  },
  components: {
    Menu,
    MenuButton,
    MenuItems,
    MenuItem,
    EllipsisVerticalIcon,
    ChevronRightIcon,
    ClockIcon,
    CheckCircleIcon,
    EyeIcon,
    History,
    Persona
  },
  data() {
    return {
      showPersona: false,
      showForm: false,
      data: "",
      puntosEntrega: "",
      filter: {
        name: "",
        num_documento: "",
      }
    };
  },

  setup() {
    const sidebarOpen = ref(false)

    return {
      sidebarOpen,
      store
    }
  },
  methods: {
    async getData() {
      let response = await axios.get(route('masterdata.fortalecimiento.get_puntos_entrega'))
      let list = await response.data
      this.puntosEntrega = list
    },
    async getStatistics(link) {

      const get = `${route('dashboard.tramites')}`

      const response = await fetch(get, { method: "GET" });
      let dependencias = await response.json();

      this.data = this.projects
      this.data.forEach(element => {

        const dat = dependencias.tramites.find((objeto) => objeto.dependencia_id === element.id);
        if (element.id == 3) {
          element.totalTramites = dependencias.entidades
        } else {
          if (dat) {
            element.totalTramites = dat.count
          } else {
            element.totalTramites = 0
          }
        }
      });
    },
  },
  created() {
    this.getData()
  }


}
</script>

<style></style>