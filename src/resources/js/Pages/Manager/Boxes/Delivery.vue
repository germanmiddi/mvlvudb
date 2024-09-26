<template>
    <main>
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-xl font-medium leading-6 text-gray-900 sm:truncate">
                   Puntos de entrega
                </h1>
            </div>
        </div>
        <!-- <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast> -->

        <div class="px-4 mt-6 sm:px-6 lg:px-8">
          <ul role="list" class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2 xl:grid-cols-3 mt-3">
            <li v-for="project in data" :key="project.id" class="relative col-span-1 flex rounded-md shadow-md hover:opacity-70 duration-300 cursor-pointer" v-show="store.userCan(project.module, $page.props.userGroups)">
                  <a :href="route(project.route)" class="w-full flex">
                    <div class="flex-shrink-0 flex items-center justify-center w-4 text-white text-sm font-medium rounded-l-md bg-gray-600">
                    </div>
                    <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 rounded-r-md truncate w-full bg-gray-200">
                        <div class="flex flex-col space-y-1 px-4 py-2 text-sm truncate w-full">
                            <p class="text-gray-900 text-lg font-medium">
                                {{ project.title }}
                            </p>
                        <div class="flex flex-wrap gap-2">
                          <p class="bg-green-600 text-white text-sm px-1 py-1 rounded-md flex gap-x-1">
                            <CheckCircleIcon class="w-5"/>
                            {{ project.totalTramites }} Entregas realizadas
                          </p>
                          <p class="bg-yellow-500 text-white text-sm px-1 py-1 rounded-md flex gap-x-1">
                            <ClockIcon class="w-5"/>
                              {{ (project.totalTramites - 4) + 5}} Entregas pendientes
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
import { Menu, 
         MenuButton,
         MenuItems,
         MenuItem
        }from '@headlessui/vue'

import { ChevronRightIcon, EllipsisVerticalIcon, ClockIcon, CheckCircleIcon, EyeIcon } from '@heroicons/vue/24/solid'
import store from '@/store.js'

const projects = [
      
    {
      id: 12,
      title: 'Ramos Mejia',
      initials: 'CBI',
      bgColorClass: 'bg-red-600',
      route: 'infancia',
      module: 'CBI'
    },
    {
      id: 13,
      title: 'Liniers',
      initials: 'CBJ',
      bgColorClass: 'bg-gray-600',
      route: 'juventud',
      module: 'CBJ'
    },
    {
      id: 2,
      title: 'Caballito',
      initials: 'DI',
      bgColorClass: 'bg-pink-600',
      route: 'discapacidad',
      module:'DIS'
    },
    {
      id: 3,
      title: 'Ranelagh',
      initials: 'EI',
      bgColorClass: 'bg-gray-600',
      route: 'entidad',
      module: 'ENT'
    },
    {
      id: 5,
      title: 'Quilmes',
      initials: 'FC',
      bgColorClass: 'bg-yellow-600',
      route: 'fortalecimiento',
      module: 'FOR'
    },
    {
      id: 6,
      title: 'Kosteki',
      initials: 'GD',
      bgColorClass: 'bg-green-600',
      route: 'genero',
      module: 'GEN'
    },
    {
      id: 7,
      title: 'Haedo',
      initials: 'HA',
      bgColorClass: 'bg-pink-600',
      route: 'habitat',
      module: 'HAB'
    },
    {
      id: 8,
      title: 'Merlo',
      initials: 'NA',
      bgColorClass: 'bg-blue-600',
      route: 'ninez',
      module: 'NIN'
    },
    {
      id: 9,
      title: 'Ciudadela',
      initials: 'PP',
      bgColorClass: 'bg-yellow-600',
      route: 'promocion',
      module: 'PPD'
    },
    {
      id: 14,
      title: 'Villa Luro',
      initials: 'PM',
      bgColorClass: 'bg-green-600',
      route: 'mayores',
      module: 'PM'
    },
    {
      id: 11,
      title: 'Florencio Varela',
      initials: 'VS',
      bgColorClass: 'bg-indigo-600',
      route: 'vivienda',
      module: 'VIV'
    },
    
    // More projects...
  ]
const pinnedProjects = projects.filter((project) => project.pinned)
  
export default {
    props: {

    },
    components:{
        Menu, 
        MenuButton,
        MenuItems,
        MenuItem,
        EllipsisVerticalIcon,
        ChevronRightIcon,
        ClockIcon,
        CheckCircleIcon,
        EyeIcon,
    },
    data() {
        return {
            data: "",
        };
    },

    setup() {
       const sidebarOpen = ref(false)
  
      return {
        projects,
        pinnedProjects,
        sidebarOpen,
        store
      }
    },
    methods: {
        async getStatistics(link) {

            const get = `${route('dashboard.tramites')}`

            const response = await fetch(get, { method: "GET" });
            let dependencias = await response.json();

            this.data = this.projects
            this.data.forEach(element => {

                const dat = dependencias.tramites.find((objeto) => objeto.dependencia_id === element.id);
                if(element.id == 3){
                  element.totalTramites = dependencias.entidades
                }else{
                  if(dat){
                      element.totalTramites = dat.count
                  }else{
                      element.totalTramites = 0
                  }
                }
            });
        },
    },
    mounted() {
        this.getStatistics()
    }
    

}
</script>

<style>

</style>