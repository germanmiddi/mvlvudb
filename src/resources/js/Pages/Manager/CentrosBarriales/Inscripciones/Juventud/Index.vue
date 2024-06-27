<template>
    <main class="flex-1">
        <!-- Page title & actions -->
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Dashboard | Centros Barriales Juventud</h1>
            </div>
            <div class="mt-4 flex sm:mt-0 sm:ml-4">
                <a :href="route('inscripcionCBJ.create')"
                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Inscripción</a>
            </div>
        </div>
        {{tramitesSede}}
        <!-- Pinned projects -->
        <div class="px-4 mt-6 sm:px-6 lg:px-8">
            <h2 class="text-gray-500 text-xs font-medium uppercase tracking-wide">Sedes</h2>
            <ul role="list" class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2 xl:grid-cols-2 mt-3">
                <li v-for="project in data" :key="project.id" class="relative col-span-1 flex shadow-sm rounded-md">
                    <div :class="[project.bgColorClass, 'flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md']">{{ project.initials }}
                    </div>
                    <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                        <div class="flex flex-col px-4 py-2 text-sm truncate">
                            <a href="#" class="text-gray-900 font-medium hover:text-gray-600">
                                {{ project.title }}
                            </a>
                            <p class="text-gray-400">{{project.totalInscripciones}} Inscripciones</p>
                            <a href="#" class="text-gray-500 hover:underline hover:text-gray-700">Ver Inscripciones</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </main>
</template>

<script>
import { ref } from 'vue'
import { Menu, MenuButton,MenuItems,MenuItem }from '@headlessui/vue'
import { ChevronRightIcon, EllipsisVerticalIcon } from '@heroicons/vue/24/solid'
import store from '@/store.js'

const projects = [

    {
        id: 1,
        title: 'La Loma',
        initials: 'LL',
        bgColorClass: 'bg-red-600',
        route: '#',
        //module: 'CBI'
    },
    {
        id: 2,
        title: 'El Ceibo',
        initials: 'EC',
        bgColorClass: 'bg-yellow-600',
        route: '#',
        //module: 'CBJ'
    },
    {
        id: 5,
        title: 'Munro',
        initials: 'MUN',
        bgColorClass: 'bg-pink-600',
        route: '#',
        //module:'DIS'
    },
    {
        id: 6,
        title: 'Villa Martelli',
        initials: 'VM',
        bgColorClass: 'bg-green-600',
        route: '#',
        //module: 'ENT'
    }

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

            const get = `${route('dashboard.cbj')}`

            const response = await fetch(get, { method: "GET" });
            let tramites = await response.json();
            this.data = this.projects
            this.data.forEach(element => {

                const dat = tramites.find((objeto) => objeto.sede_id === element.id);
                  if(dat){
                      element.totalInscripciones = dat.total
                  }else{
                      element.totalInscripciones = 0
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
