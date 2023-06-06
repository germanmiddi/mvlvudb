<template>


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