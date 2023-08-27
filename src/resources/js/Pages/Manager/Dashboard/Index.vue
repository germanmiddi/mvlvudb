<template>
    <main class="flex-1">
        <!-- Page title & actions -->
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Inicio</h1>
            </div>
            <div class="mt-4 flex sm:mt-0 sm:ml-4">

            </div>
        </div>
        <!-- Pinned projects -->
        <div class="px-4 mt-6 sm:px-6 lg:px-8">
            <h2 class="text-gray-500 text-xs font-medium uppercase tracking-wide">Destacados</h2>
            <ul role="list" class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2 xl:grid-cols-4 mt-3">
                <li v-for="project in data" :key="project.id" class="relative col-span-1 flex shadow-sm rounded-md" v-show="store.userCan(project.module, $page.props.userGroups)">
                    <div :class="[project.bgColorClass, 'flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md']">{{ project.initials }}
                    </div>
                    <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                        <div class="flex flex-col px-4 py-2 text-sm truncate">
                            <a href="#" class="text-gray-900 font-medium hover:text-gray-600">
                                {{ project.title }}
                            </a>
                            <p class="text-gray-400">{{ project.totalTramites }} Tramites</p>
                            <a :href="route(project.route)" class="text-gray-500 hover:underline hover:text-gray-700">Ver Bandeja</a>
                        </div>
                    </div>
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

import { ChevronRightIcon, EllipsisVerticalIcon } from '@heroicons/vue/24/solid'
import store from '@/store.js'

const projects = [
    {
      id: 2,
      title: 'Discapacidad',
      initials: 'DI',
      bgColorClass: 'bg-pink-600',
      route: 'discapacidad',
      module:'DIS'
    },
    {
      id: 6,
      title: 'Género y Diversidad',
      initials: 'GD',
      bgColorClass: 'bg-green-600',
      route: 'genero',
      module: 'GEN'
    },
    {
      id: 8,
      title: 'Niñez y Adolescencia',
      initials: 'NA',
      bgColorClass: 'bg-blue-600',
      route: 'ninez',
      module: 'NIN'
    },
    {
      id: 12,
      title: 'Centro Barriales Infancia | CBI',
      initials: 'CBI',
      bgColorClass: 'bg-red-600',
      route: 'infancia',
      module: 'CBI'
    },
    {
      id: 13,
      title: 'Centro Barriales Juventud | CBJ',
      initials: 'CBJ',
      bgColorClass: 'bg-gray-600',
      route: 'juventud',
      module: 'CBJ'
    },
    {
      id: 5,
      title: 'Fortalecimiento Comunitario',
      initials: 'FC',
      bgColorClass: 'bg-yellow-600',
      route: 'fortalecimiento',
      module: 'FOR'
    },
    {
      id: 7,
      title: 'Habitat',
      initials: 'HA',
      bgColorClass: 'bg-pink-600',
      route: 'habitat',
      module: 'HAB'
    },
    {
      id: 9,
      title: 'Promoción y Protección de Derechos',
      initials: 'PP',
      bgColorClass: 'bg-yellow-600',
      route: 'promocion',
      module: ''
    },
    {
      id: 14,
      title: 'Personas Mayores',
      initials: 'PM',
      bgColorClass: 'bg-green-600',
      route: 'mayores',
      module: 'PM'
    },
    {
      id: 11,
      title: 'Vivienda Social',
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
        ChevronRightIcon
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

            const get = `${route('dashboard.statistics')}`

            const response = await fetch(get, { method: "GET" });
            let dependencias = await response.json();

            this.data = this.projects
            this.data.forEach(element => {
 
                
                const dat = dependencias.find((objeto) => objeto.dependencia_id === element.id);
                if(dat){
                    element.totalTramites = dat.count
                }else{
                    element.totalTramites = 0
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