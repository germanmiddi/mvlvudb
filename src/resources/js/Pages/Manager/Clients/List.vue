
<template>
<!-- eslint-disable -->
    <div class="w-full" >
        <header class="">
            <div class="flex justify-between max-w-7xl mx-auto py-6 px-10">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Clientes
                </h2>
                <a class="btn-blue" :href="route('client.create')">
                    Nuevo Cliente
                </a>
            </div>
        </header>

        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div v-if="showToast" class="rounded-md bg-green-50 p-4 mb-5  ">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <CheckCircleIcon class="h-5 w-5 text-green-400" aria-hidden="true" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ this.message }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" @click="showToast = false"
                                class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">
                                <span class="sr-only">Dismiss</span>
                                <XIcon class="h-5 w-5" aria-hidden="true" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <table class="w-full whitespace-nowrap">
                    <tr class="text-left font-bold bg-blue-500 text-white">
                        <th class="px-6 py-3 text-center">ID</th>
                        <th class="px-6 py-3 text-center">Nombre</th>
                        <!-- <th class="px-6 py-3 ">Dirección</th> -->
                        <th class="px-6 py-3 ">Contacto</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                    <tr v-for="client in clients.data" :key="client.id"
                        class="hover:bg-gray-100 focus-within:bg-gray-100 text-sm ">
                        <td class="border-t px-6 py-4 text-center">
                            {{ client.id }}
                        </td>
                        <td class="border-t px-6 py-4 text-center">
                            {{ client.company_name }}
                        </td>

                        <!-- <td class="border-t px-6 py-4 text-left">
                            {{ client.address }}
                        </td> -->

                        <td class="border-t px-6 py-4 text-center">
                            <div class="flex"> 
                                <PhoneIcon class="w-3 mr-2 text-blue-500"/> {{ client.phone }} </div>
                            <div class="flex"> 
                            <EnvelopeIcon class="w-3 mr-2 text-blue-500"/>{{ client.email }}</div>
                        </td>
                        <td class="border-t px-6 py-4 text-center">
                            <!-- <a type="button" :href="route('clients.edit', client.id)" -->
                            <a type="button" :href="route('client.edit', client.id)" class="inline-flex items-center p-1 border border-gray-200 rounded-md text-white bg-gray-100 
                                        hover:bg-gray-300">
                                <PencilIcon class="h-4 w-4 text-gray-700" aria-hidden="true" /></a>
                            
                            <a type="button" href="#" class="ml-2 inline-flex items-center p-1 border border-gray-200 rounded-md text-white bg-gray-100 
                                        hover:bg-gray-300">
                                <ChevronRightIcon @click="open = true" class="h-4 w-4 text-gray-700" aria-hidden="true" /></a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
    </div>


    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="fixed inset-0 overflow-hidden" @close="open = false">
            <div class="absolute inset-0 overflow-hidden">
                <DialogOverlay class="absolute inset-0" />

                <div class="fixed inset-y-0 pl-16 max-w-full right-0 flex">
                    <TransitionChild as="template"
                        enter="transform transition ease-in-out duration-500 sm:duration-700"
                        enter-from="translate-x-full" enter-to="translate-x-0"
                        leave="transform transition ease-in-out duration-500 sm:duration-700"
                        leave-from="translate-x-0" leave-to="translate-x-full">
                        <div class="w-screen max-w-md">
                            <form class="h-full divide-y divide-gray-200 flex flex-col bg-white shadow-xl">
                                <div class="flex-1 h-0 overflow-y-auto">
                                    <div class="py-6 px-4 bg-blue-500 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <DialogTitle class="text-lg font-medium text-white"> Detalle del Cliente
                                            </DialogTitle>

                                            <div class="ml-3 h-7 flex items-center">
                                                <button type="button"
                                                    class="bg-blue-500 rounded-md text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                                                    @click="open = false">
                                                    <span class="sr-only">Cerrar</span>
                                                    <XMarkIcon class="h-6 w-6" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-1 flex flex-col justify-between">
                                        <div class="px-4 divide-y divide-gray-200 sm:px-6">
                                            <div class="space-y-2 pt-2 pb-5">
                                                <div>
                                                    <label for="time"
                                                        class="block text-xl font-medium text-gray-700 ">Agencia ABC</label>
                                                </div>
                                                <hr>
                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-24 font-bold">Nro Cliente:</label>
                                                    <span>1</span>
                                                </div>

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-24 font-bold">Razón Social:</label>
                                                    <span>Agencia SRL</span>
                                                </div>
                                                
                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-24 font-bold">CUIT:</label>
                                                    <span>20-12345678-1</span>
                                                </div>

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-24 font-bold">Dirección:</label>
                                                    <span>Av. Libertador 1234, CABA</span>
                                                </div>

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-24 font-bold">Teléfono:</label>
                                                    <span>+54 1234 5678</span>
                                                </div>

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-24 font-bold">Email:</label>
                                                    <span>miemail@gmail.com</span>
                                                </div>

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-24 font-bold">Estado:</label>
                                                    <span>ACTIVO</span>
                                                </div>

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-24 font-bold">Tipo de Factura:</label>
                                                    <span>A</span>
                                                </div>
                                                
                                                <hr>
                                                <div>
                                                    <label for="time"
                                                        class="block text-xl font-medium text-gray-800">Últimos Viajes</label>
                                                </div>
                                                <div class="p-2">
                                                    <label for="time"
                                                        class="block text-sm font-medium text-gray-700">
                                                        <b>Fecha: </b>25/02/2023 - 10:30</label>

                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Tipo: </b> Translado</label>

                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Chofer: </b> Jorge L. Borges</label>
                                                    
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Origen: </b>Aerop. Ezeiza</label>

                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Destino: </b>Hotel Colonial</label>
                                                    
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Estado Servicio: </b>PROGRAMADO</label>

                                                    <hr>

                                                    <label for="time"
                                                        class="block text-sm font-medium text-gray-700">
                                                        <b>Fecha: </b>27/02/2023 - 07:00</label>

                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Tipo: </b> Excursión</label>

                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Chofer: </b> Jorge L. Borges</label>
                                                    
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Origen: </b>Hotel Alvear</label>

                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Destino: </b>Estancia La Linda</label>
                                                    
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Estado Servicio: </b>PROGRAMADO</label>

                                                    <hr>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 px-4 py-4 flex justify-end">
                                    <button type="button"
                                        class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        @click="open = false">Cerrar</button>
                                    <!-- <button class="ml-4 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">Actualizar Nota</button> -->
                                </div>
                            </form>
                        </div>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>


</template>
<script>

import { defineComponent } from 'vue'
import { PencilIcon,
         PlusCircleIcon,
         XMarkIcon,
         CheckCircleIcon,
         ChevronRightIcon,
         PhoneIcon,
         EnvelopeIcon          
        } from '@heroicons/vue/24/outline';
import Toast from '@/Layouts/Components/Toast.vue';

import {
         TransitionRoot, 
         Dialog, 
         DialogOverlay, 
         TransitionChild, 
         DialogTitle, 
         
        //  Menu,
        //  MenuButton,
        //  MenuItem,
        //  MenuItems,
        } from '@headlessui/vue'


export default defineComponent({
    props: {
        toast: Object
    },
    components: {
        PencilIcon,
        PlusCircleIcon,
        Toast,
        XMarkIcon,
        CheckCircleIcon,
        ChevronRightIcon,
        PhoneIcon,
        EnvelopeIcon,
        TransitionRoot, 
        Dialog, 
        DialogOverlay, 
        TransitionChild, 
        DialogTitle,        
    },
    data() {

        // const clients = [
        //     { id: '1' ,
        //       name: 'Agencia ABC',
        //       address: 'Av. Libertador 1234, CABA ',
        //       cellphone: '+54 9 1234 5678'
        //     },
        //     { id: '2' ,
        //       name: 'Juan Sanchez',
        //       address: 'Parana 1234, CABA ',
        //       cellphone: '+54 9 1234 5678'
        //     },
        //     { id: '3' ,
        //       name: 'Travel Show',
        //       address: 'Peña 1234, CABA ',
        //       cellphone: '+54 9 1234 5678'
        //     }

        // ]

        return {
            open: false,
            clients: {},
            toastMessage: "",
            labelType: "info",
            message: "",
            showToast: false,
        }
    },
    methods: {
        async getClients() {

            const get = `${route('clients.list')}`

            const response = await fetch(get, { method: 'GET' })
            this.clients = await response.json()

        },
        clearMessage() {
            this.toastMessage = ""
        },
    },

    created() {
        this.getClients()
    },
    // mounted() {
    //     if (this.toast) {
    //         if (this.toast['status'] == 200) {
    //             this.message = this.toast['message']
    //             this.showToast = true
    //         } else {
    //             this.labelType = "danger"
    //             this.toastMessage = this.toast['message']
    //         }
    //     }
    // }

})
</script>
