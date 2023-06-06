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
                <li v-for="project in pinnedProjects" :key="project.id" class="relative col-span-1 flex shadow-sm rounded-md">
                    <div :class="[project.bgColorClass, 'flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md']">
                    </div>
                    <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                        <div class="flex flex-col px-4 py-2 text-sm truncate">
                            <a href="#" class="text-gray-900 font-medium hover:text-gray-600">
                                {{ project.title }}
                            </a>
                            <!-- <p class="text-gray-500">{{ project.totalTramites }} Tramites</p> -->
                            <a :href="route('discapacidad')" class="text-gray-500 hover:underline hover:text-gray-700">Ver Bandeja</a>
                        </div>
                        <!-- <Menu as="div" class="flex-shrink-0 pr-2">
                            <MenuButton class="w-8 h-8 bg-white inline-flex items-center justify-center text-gray-400 rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                <span class="sr-only">Open options</span>
                                <EllipsisVerticalIcon class="w-5 h-5" aria-hidden="true" />
                            </MenuButton>
                            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                <MenuItems class="z-10 mx-3 origin-top-right absolute right-10 top-3 w-48 mt-1 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-200 focus:outline-none">
                                <div class="py-1">
                                    <MenuItem v-slot="{ active }">
                                    <a :href="route('discapacidad')" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Ver</a>
                                    </MenuItem>
                                </div>
                                <div class="py-1">
                                    <MenuItem v-slot="{ active }">
                                    <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Removed from pinned</a>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                    <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Share</a>
                                    </MenuItem>
                                </div>
                                </MenuItems>
                            </transition>
                        </Menu> -->
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

const projects = [
    {
      id: 1,
      title: 'Discapacidad',
      initials: 'GA',
      team: 'Engineering',
      members: [
      ],
      totalTramites: 12,
      lastUpdated: 'March 17, 2020',
      pinned: true,
      bgColorClass: 'bg-pink-600',
    },
    // More projects...
  ]
const pinnedProjects = projects.filter((project) => project.pinned)
  
export default {
    components:{
        Menu, 
        MenuButton,
        MenuItems,
        MenuItem,
        EllipsisVerticalIcon,
        ChevronRightIcon
    },

    setup() {
       const sidebarOpen = ref(false)
  
      return {
        projects,
        pinnedProjects,
        sidebarOpen,
      }
    },
    

}
</script>

<style>

</style>