<template>
    <div class="min-h-full">
      <TransitionRoot as="template" :show="sidebarOpen">
        <Dialog as="div" class="fixed inset-0 flex z-40 lg:hidden" @close="sidebarOpen = false">
          <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
            <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-75" />
          </TransitionChild>
          <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
            <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-white">
              <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                  <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="sidebarOpen = false">
                    <span class="sr-only">Close sidebar</span>
                    <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                  </button>
                </div>
              </TransitionChild>
              <div class="flex-shrink-0 flex items-center px-4">
                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-purple-500-mark-gray-700-text.svg" alt="Workflow" />
              </div>
              <div class="mt-5 flex-1 h-0 overflow-y-auto">
                <nav class="px-2">
                  <div class="space-y-1">
                    <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-base leading-5 font-medium rounded-md']" :aria-current="item.current ? 'page' : undefined">
                      <component :is="item.icon" :class="[item.current ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']" aria-hidden="true" />
                      {{ item.name }}
                    </a>
                  </div>
                  <div class="mt-8">
                    <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider" id="mobile-teams-headline">Teams</h3>
                    <div class="mt-1 space-y-1" role="group" aria-labelledby="mobile-teams-headline">
                      <a v-for="team in teams" :key="team.name" :href="team.href" class="group flex items-center px-3 py-2 text-base leading-5 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
                        <span :class="[team.bgColorClass, 'w-2.5 h-2.5 mr-4 rounded-full']" aria-hidden="true" />
                        <span class="truncate">
                          {{ team.name }}
                        </span>
                      </a>
                    </div>
                  </div>
                </nav>
              </div>
            </div>
          </TransitionChild>
          <div class="flex-shrink-0 w-14" aria-hidden="true">
            <!-- Dummy element to force sidebar to shrink to fit close icon -->
          </div>
        </Dialog>
      </TransitionRoot>
  
      <!-- Static sidebar for desktop -->
      <div class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 lg:border-r lg:border-gray-200 lg:pt-5 lg:pb-4 lg:bg-gray-100">
        <div class="flex items-center flex-shrink-0 px-6 font-bold text-xl">
          <a :href="route('dashboard')">Desarrollo Social</a>
        </div>
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="mt-6 h-0 flex-1 flex flex-col overflow-y-auto">
          <!-- User account dropdown -->
          <Menu as="div" class="px-3 relative inline-block text-left">

            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
              <MenuItems class="z-10 mx-3 origin-top absolute right-0 left-0 mt-1 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-200 focus:outline-none">
                <div class="py-1">
                  <MenuItem v-slot="{ active }">
                    <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">View profile</a>
                  </MenuItem>
                  <MenuItem v-slot="{ active }">
                    <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Settings</a>
                  </MenuItem>
                  <MenuItem v-slot="{ active }">
                    <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Notifications</a>
                  </MenuItem>
                </div>
                <div class="py-1">
                  <MenuItem v-slot="{ active }">
                    <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Get desktop app</a>
                  </MenuItem>
                  <MenuItem v-slot="{ active }">
                    <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Support</a>
                  </MenuItem>
                </div>
                <div class="py-1">
                  <MenuItem v-slot="{ active }">
                    <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Logout</a>
                  </MenuItem>
                </div>
              </MenuItems>
            </transition>

          </Menu>

          <!-- Sidebar Search -->
          <!-- <div class="px-3 mt-5">
            <label for="search" class="sr-only">Search</label>
            <div class="mt-1 relative rounded-md shadow-sm">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none" aria-hidden="true">
                <MagnifyingGlassIcon class="mr-3 h-4 w-4 text-gray-400" aria-hidden="true" />
              </div>
              <input type="text" name="search" id="search" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-9 sm:text-sm border-gray-300 rounded-md" placeholder="Search" />
            </div>
          </div> -->
          <!-- Navigation -->
          <nav class="px-3 mt-6">
            <!-- {{ user.grupos }} -->

            <div class="space-y-1">
              <a :href="route('general')" v-show="store.userCan('VUDS-VU', $page.props.userGroups)">
                <div class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50 flex">
                  <InboxIcon class="w-5 h-5 mr-3" /> <label> Bandeja General</label>
                </div>
              </a>
              <!-- Render a `div` for the root `Disclosure` component -->
              <Disclosure as="div">
                <!-- Don't render any element (only children) for the `DisclosureButton` component -->
                <DisclosureButton as="template" class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50">
                  <button class="flex items-center" ><Bars3Icon class="mr-3 flex-shrink-0 h-6 w-6"/>Dependencias</button>
                </DisclosureButton>

                <!-- Render a `ul` for the `DisclosurePanel` component -->
                  <DisclosurePanel as="ul" class="pl-4">

                    <a :href="route('infancia')" v-show="store.userCan('CBI', $page.props.userGroups)">
                      <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md" >
                        Centros Barriales Infancia
                      </li>
                    </a>
                    <a :href="route('juventud')" v-show="store.userCan('CBJ', $page.props.userGroups)">
                      <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md" >
                        Centros Barriales Juventud
                      </li>
                    </a>
                    <a :href="route('discapacidad')" v-show="store.userCan('DIS', $page.props.userGroups)">
                      <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md" >
                        Discapacidad
                      </li>
                    </a>
                    <a :href="route('entidad')" v-show="store.userCan('ENT', $page.props.userGroups)">
                      <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md" >
                        Entidades
                      </li>
                    </a>
                    <a :href="route('fortalecimiento')" v-show="store.userCan('FOR', $page.props.userGroups)">
                      <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md" >
                        Fortalecimiento Comunitario
                      </li>
                    </a>
                    <a :href="route('genero')" v-show="store.userCan('GEN', $page.props.userGroups)">
                      <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md" >
                        Género y Diversidad
                      </li>
                    </a>
                    <a :href="route('habitat')" v-show="store.userCan('HAB', $page.props.userGroups)">
                      <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md" >
                        Hábitat
                      </li>
                    </a>
                    <a :href="route('ninez')" v-show="store.userCan('NIN', $page.props.userGroups)">
                      <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md" >
                        Niñez y Adolescencia
                      </li>
                    </a>
                    <a :href="route('promocion')" v-show="store.userCan('PRO', $page.props.userGroups)">
                      <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md" >
                        Promoción y Protección de derechos
                      </li>
                    </a>
                    <a :href="route('mayores')" v-show="store.userCan('PM', $page.props.userGroups)">
                      <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md" >
                        Personas Mayores
                      </li>
                    </a>
                    <li class="bg-gray-300 px-2 py-2 my-2 text-sm font-medium rounded-md" v-show="store.userCan('ALL', $page.props.userGroups)" >Operativos</li>
                    <a :href="route('vivienda')" v-show="store.userCan('VIV', $page.props.userGroups)">
                      <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md" >
                        Vivienda social
                      </li>
                    </a>
                  </DisclosurePanel>

              </Disclosure>

              <a :href="route('report')"  v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
                <div class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50 flex mt-1">
                  <DocumentChartBarIcon class="w-5 h-5 mr-3" /> <label> Reportes</label>
                </div>
              </a>

              <a :href="route('persons')"  v-show="store.userCan('-PROF', $page.props.userGroups)">
                <div class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50 flex mt-1">
                  <UserGroupIcon class="w-5 h-5 mr-3" /> <label> Personas</label>
                </div>
              </a>

              <Disclosure as="div" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
                <!-- Don't render any element (only children) for the `DisclosureButton` component -->
                <DisclosureButton as="template" class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50">
                  <button class="flex items-center" ><Cog6ToothIcon class="mr-3 flex-shrink-0 h-6 w-6"/>Configuraciones</button>
                </DisclosureButton>

                <!-- Render a `ul` for the `DisclosurePanel` component -->
                  <DisclosurePanel as="ul" class="pl-4">
                    
                    <a :href="route('users')" >
                      <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md" >
                        Usuarios y Permisos
                      </li>
                    </a>
                    
                    <a :href="route('masterdata')">
                      <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md" >
                        Datos Maestros
                      </li>
                    </a>
                    <a :href="route('logs')">
                      <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md" >
                        Registro de Logs
                      </li>
                    </a>
                    <a :href="route('import')">
                      <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md" >
                        Importador de Registro
                      </li>
                    </a>
                  </DisclosurePanel>

              </Disclosure>

              <div class="flex items-center px-2 py-2 hover:text-red-600 hover:bg-gray cursor-pointer text-gray-500 hover:bg-gray-200 rounded-md">
                <PowerIcon class="mr-3 flex-shrink-0 h-5 w-5" />
                <span @click="logout" class="text-sm font-medium ">Cerrar Sesión</span>

              </div>   
            </div>

          </nav>
        </div>
      </div>
      <!-- Main column -->
      <div class="lg:pl-64 flex flex-col">
        <!-- Search header -->
        <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white border-b border-gray-200 lg:hidden">
          <button type="button" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500 lg:hidden" @click="sidebarOpen = true">
            <span class="sr-only">Open sidebar</span>
            <Bars3CenterLeftIcon class="h-6 w-6" aria-hidden="true" />
          </button>
          <div class="flex-1 flex justify-between px-4 sm:px-6 lg:px-8">
            <div class="flex-1 flex">
              <form class="w-full flex md:ml-0" action="#" method="GET">
                <label for="search-field" class="sr-only">Search</label>
                <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                  <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                    <MagnifyingGlassIcon class="h-5 w-5" aria-hidden="true" />
                  </div>
                  <input id="search-field" name="search-field" class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-0 focus:border-transparent focus:placeholder-gray-400 sm:text-sm" placeholder="Search" type="search" />
                </div>
              </form>
            </div>
            <div class="flex items-center">
              <!-- Profile dropdown -->
              <Menu as="div" class="ml-3 relative">
                <div>
                  <MenuButton class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <span class="sr-only">Open user menu</span>
                    <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                  </MenuButton>
                </div>
                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                  <MenuItems class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-200 focus:outline-none">
                    <div class="py-1">
                      <MenuItem v-slot="{ active }">
                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">View profile</a>
                      </MenuItem>
                      <MenuItem v-slot="{ active }">
                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Settings</a>
                      </MenuItem>
                      <MenuItem v-slot="{ active }">
                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Notifications</a>
                      </MenuItem>
                    </div>
                    <div class="py-1">
                      <MenuItem v-slot="{ active }">
                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Get desktop app</a>
                      </MenuItem>
                      <MenuItem v-slot="{ active }">
                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Support</a>
                      </MenuItem>
                    </div>
                    <div class="py-1">
                      <MenuItem v-slot="{ active }">
                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Logout</a>
                      </MenuItem>
                    </div>
                  </MenuItems>
                </transition>
              </Menu>
            </div>
          </div>
        </div>
        <slot> </slot>
            
      </div>
    </div>
  </template>
  
  <script>

 import { Inertia } from '@inertiajs/inertia-vue3';
  import { ref } from 'vue'
  import {
    Dialog,
    DialogOverlay,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
  } from '@headlessui/vue'

  import { ClockIcon, HomeIcon, Bars3CenterLeftIcon, Bars3Icon, XMarkIcon, InboxIcon, Cog6ToothIcon, PowerIcon, DocumentChartBarIcon } from '@heroicons/vue/24/outline'
  import { ChevronRightIcon, EllipsisVerticalIcon, MagnifyingGlassIcon, ChevronUpDownIcon, UserGroupIcon } from '@heroicons/vue/24/solid'

  import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
  import { ChevronUpIcon } from '@heroicons/vue/20/solid'

  import store from '@/store.js'

  const navigation = [
    { name: 'Consultas', href: '#', icon: HomeIcon, current: true },
    { name: 'Alta Trámite', href: '#', icon: HomeIcon, current: true },
    { name: 'Mi Bandeja', href: '#', icon: HomeIcon, current: true },
    { name: 'Usuarios', href: '#', icon: Bars3Icon, current: false },
    { name: 'Configuración', href: '#', icon: ClockIcon, current: false },
  ]
  const teams = [
    { name: 'Engineering', href: '#', bgColorClass: 'bg-indigo-500' },
    { name: 'Human Resources', href: '#', bgColorClass: 'bg-green-500' },
    { name: 'Customer Success', href: '#', bgColorClass: 'bg-yellow-500' },
  ]

  // const projects = [
  //   {
  //     id: 1,
  //     title: 'GraphQL API',
  //     initials: 'GA',
  //     team: 'Engineering',
  //     members: [
  //       {
  //         name: 'Dries Vincent',
  //         handle: 'driesvincent',
  //         imageUrl:
  //           'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
  //       },
  //       {
  //         name: 'Lindsay Walton',
  //         handle: 'lindsaywalton',
  //         imageUrl:
  //           'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
  //       },
  //       {
  //         name: 'Courtney Henry',
  //         handle: 'courtneyhenry',
  //         imageUrl:
  //           'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
  //       },
  //       {
  //         name: 'Tom Cook',
  //         handle: 'tomcook',
  //         imageUrl:
  //           'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
  //       },
  //     ],
  //     totalMembers: 12,
  //     lastUpdated: 'March 17, 2020',
  //     pinned: true,
  //     bgColorClass: 'bg-pink-600',
  //   },
  //   // More projects...
  // ]
  // const pinnedProjects = projects.filter((project) => project.pinned)

  export default {
    components: {
      Dialog,
      DialogOverlay,
      Menu,
      MenuButton,
      MenuItem,
      MenuItems,
      TransitionChild,
      TransitionRoot,
      ChevronRightIcon,
      EllipsisVerticalIcon,
      Bars3CenterLeftIcon,
      MagnifyingGlassIcon,
      ChevronUpDownIcon,
      Bars3Icon,
      XMarkIcon,
      DocumentChartBarIcon,
      Disclosure, 
      DisclosureButton, 
      DisclosurePanel, 
      InboxIcon,
      Inertia,
      Cog6ToothIcon,
      PowerIcon,
      UserGroupIcon
      
    },
    setup() {
      const sidebarOpen = ref(false)
  
      return {

        navigation,
        teams,
        // projects,
        // pinnedProjects,
        sidebarOpen,
        store
        
      }
    },
    data() {
      return {
        
      }
    },
    methods: {
      logout() {
          this.$inertia.post(route('logout'));
      },
      
    },

  
  }
  </script>