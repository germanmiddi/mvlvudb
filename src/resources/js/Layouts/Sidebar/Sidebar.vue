<template>
    <TransitionRoot as="template" :show="store.mobileSidebar">
      <Dialog as="div" class="fixed inset-0 flex z-40 lg:hidden" @close="store.mobileSidebar = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
          <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-75" />
        </TransitionChild>
        <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
          <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-blue-700">
            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
              <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="store.mobileSidebar = false">
                  <span class="sr-only">Close sidebar</span>
                  <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                </button>
              </div>
            </TransitionChild>

            <div class="flex-shrink-0 flex items-center px-4">
              <!-- <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/easywire-logo-cyan-300-mark-white-text.svg" alt="Easywire logo" /> -->
            </div>

            <nav class="mt-5 flex-shrink-0 h-full divide-y divide-blue-800 overflow-y-auto" aria-label="Sidebar">
              <div class="px-2 space-y-1">
                <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-blue-800 text-white' : 'text-blue-100 hover:text-white hover:bg-blue-600', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']" :aria-current="item.current ? 'page' : undefined">
                  <component :is="item.icon" class="mr-4 flex-shrink-0 h-6 w-6 text-blue-200" aria-hidden="true" />
                  {{ item.name }}
                </a>
              </div>
            </nav>

          </div>
        </TransitionChild>
        <div class="flex-shrink-0 w-14" aria-hidden="true">
          <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
      </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div v-if="store.sidebarCollapse && !store.showNavbar" class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0">

      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="flex flex-col flex-grow border-r border-gray-200 bg-gray-100 pt-5 pb-4 overflow-y-auto">
        
        <ArrowLeftOnRectangleIcon class="w-4" @click="store.hideSidebar()"/>
        <div class="flex items-center flex-shrink-0 px-4">
          <img v-if="logo" class="w-40 mx-auto"  alt="" src="/images/logo-joji2.webp">
          <div v-else class="w-20 h-40 mx-auto">
            <RocketLaunchIcon class="text-gray-600 w-20"  />
          </div>
        </div>

        <nav class="flex-1 flex flex-col divide-y divide-cyan-800 overflow-y-auto" aria-label="Sidebar">
            <div class="px-2 space-y-1">
                <div @click="store.collapseSidebar()" class="px-2 py-2">
                    <ChevronDoubleLeftIcon class="w-6 text-blue-500" />
                </div>

                <Link v-for="item in navigation" :key="item.name" :href="route(item.href)" 
                   :class="[ route().current(item.href) ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']">
                    
                    <component :is="item.icon" 
                               :class="[ route().current(item.href) ? 'text-blue-500' : 'text-blue-400 group-hover:text-blue-500', 'mr-3 h-6 w-6']" 
                               aria-hidden="true" />
                    {{ item.name }}

                </Link>
            </div>
        </nav>

        <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
            <a href="#" class="flex-shrink-0 group block">
            <div class="flex items-center">
                <div>
                    <UserCircleIcon class="inline-block h-11 w-11 text-blue-600"/>
                </div>
                <div class="ml-3 flex flex-col">
                    <span class="text-base font-medium text-gray-700 group-hover:text-gray-900">{{ $page.props.user.name }}</span>
                    <span @click="logout" class="text-sm font-medium text-gray-500 group-hover:text-red-600">Cerrar Sesión</span>
                </div>
            </div>
            </a>
        </div>        
      </div>
    </div>
    
    <!-- Static mini sidebar for desktop -->
    <div v-else-if="this.miniSidebarCollapse" class="hidden lg:flex lg:w-16 lg:flex-col lg:fixed lg:inset-y-0">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="flex flex-col flex-grow bg-gray-100 mt-1 pb-4 overflow-y-auto">
        <nav class="mt-28 flex-1 flex flex-col divide-y divide-cyan-800 overflow-y-auto" aria-label="Sidebar">
          <div class="px-2 space-y-1">
            <div @click="store.collapseSidebar()" class="flex justify-center text-sm font-medium rounded-md mx-auto py-2">
                <ChevronDoubleRightIcon class="w-6 text-blue-500" />
            </div>            
            <a v-for="item in navigation" :key="item.name" :href="item.href" 
                :class="[ item.current ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 
                          'group flex items-center justify-center py-2 text-sm font-medium rounded-md mx-auto']">
                <component :is="item.icon" :class="[item.current ? 'text-blue-500' : 'text-blue-400 group-hover:text-blue-500', 'h-6 w-6']" aria-hidden="true" />
            </a>
          </div>
        </nav>
        <div class="flex-shrink-0 flex border-t border-gray-200 py-4 mx-auto">
            <a href="#" class="flex-shrink-0 group block">
                <div class="flex items-center">
                    <div>
                        <UserCircleIcon class="inline-block h-11 w-11 text-blue-600"/>
                    </div>
                </div>
            </a>
        </div> 
      </div>
    </div>

    <!-- Static mini sidebar for small desktop -->
    <div v-if="!this.showNavbar" class="hidden md:flex md:w-16 md:flex-col md:fixed md:inset-y-0 lg:hidden">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="flex flex-col flex-grow bg-gray-100 mt-1 pb-4 overflow-y-auto">
        <nav class="mt-28 flex-1 flex flex-col divide-y divide-cyan-800 overflow-y-auto" aria-label="Sidebar">
          <div class="px-2 space-y-1">
            
            <a v-for="item in navigation" :key="item.name" :href="item.href" 
                :class="[ item.current ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 
                          'group flex items-center justify-center py-2 text-sm font-medium rounded-md mx-auto']">
                <component :is="item.icon" :class="[item.current ? 'text-blue-500' : 'text-blue-400 group-hover:text-blue-500', 'h-6 w-6']" aria-hidden="true" />
            </a>
          </div>
        </nav>
        <div class="flex-shrink-0 flex border-t border-gray-200 py-4 mx-auto">
            <a href="#" class="flex-shrink-0 group block">
                <div class="flex items-center">
                    <div>
                        <UserCircleIcon class="inline-block h-11 w-11 text-blue-600"/>
                    </div>
                </div>
            </a>
        </div> 
      </div>
    </div>  

</template>

<script>

import { ref } from 'vue'
import store from '@/store.js'
import {Link } from '@inertiajs/inertia-vue3'

import {
   Dialog,
   DialogOverlay,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue' 

import {
//     XMarkIcon,
     UserCircleIcon,
     ChevronDoubleLeftIcon,
     ChevronDoubleRightIcon,
     HomeIcon,
     RocketLaunchIcon,
     ArrowLeftOnRectangleIcon
//     ClockIcon,
//     ScaleIcon,
//     CreditCardIcon,
//     UserGroupIcon,
//     DocumentReportIcon     
} from '@heroicons/vue/24/outline'

const navigation = [
  { name: 'Home',     href: 'dashboard',  icon: HomeIcon,  current: true },
  // { name: 'Pedidos',  href: 'order',      icon: ClockIcon, current: false },
  // { name: 'Envios',   href: 'shipment',   icon: ScaleIcon, current: false },
  // { name: 'Facturas', href: 'invoices',   icon: CreditCardIcon, current: false },
  // { name: 'Usuarios', href: 'users.list', icon: UserGroupIcon, current: false },
  // { name: 'Procesos', href: '/jobs',      icon: DocumentReportIcon, current: false },
]

export default {
    components:{
        Dialog,
        DialogOverlay,
        TransitionChild,
        TransitionRoot,
        // XMarkIcon,
        UserCircleIcon,
        ChevronDoubleLeftIcon,
        ChevronDoubleRightIcon,
        HomeIcon,
        RocketLaunchIcon,
        ArrowLeftOnRectangleIcon
        // ClockIcon,
        // ScaleIcon,
        // CreditCardIcon,
        // UserGroupIcon,
        // DocumentReportIcon,
        // Link  
    },
    data(){
      return{
        store,
      }
    },
    methods:{
      logout() {
          this.$inertia.post(route('logout'));
      },
    },
    setup() {
        const sidebarOpen = ref(false)
        const sidebarCollpase = ref(true)

        return {
            navigation,
            sidebarOpen,
            sidebarCollpase
        }
    },    

}
</script>

<style>

</style>