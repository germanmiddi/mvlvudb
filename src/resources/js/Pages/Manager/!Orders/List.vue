<template>
<!-- eslint-disable -->
    <div class="w-full" >
        <header class="">
            <div class="flex justify-between max-w-7xl mx-auto py-6 px-10">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Viajes
                </h2>
                <div class="flex"> 
                    <button class="btn-blue mr-2" @click.prevent="showMap = !showMap ">
                        Ver Mapa
                    </button>
                    <button class="btn-blue mr-2">
                        Nuevo Viaje
                    </button>
                    <button class="btn-blue flex" @click="filterBtn = !filterBtn">Filtros
                        <ChevronDownIcon v-if="!filterBtn" class="w-5" />
                        <ChevronUpIcon v-else class="w-5" />
                    </button>                    
                </div>
            </div>
        </header>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <ul class="top-filter w-full my-3 card">
                <li class="top-filter-item top-filter-item-active">TODOS:<span class="top-filter-number"> 58</span></li>
                <li class="top-filter-item">SOLICITUDES:<span class="top-filter-number"> 20</span></li>
                <li class="top-filter-item">PROGRAMADOS:<span class="top-filter-number"> 15</span></li>
                <li class="top-filter-item">EN CURSO:<span class="top-filter-number"> 8</span></li>
                <li class="top-filter-item">FINALIZADOS:<span class="top-filter-number"> 10</span></li>
                <li class="top-filter-item">CANCELADOS:<span class="top-filter-number"> 5</span></li>
            </ul>

            <div class="card-filter bg-gray-100 border-gray-300 p-2 rounded-md" v-if="filterBtn">
                <div class="filter-input-group">
                    <Datepicker
                        v-model="filter.date"
                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        range multiCalendars :closeOnAutoApply="true"
                        :enableTimePicker="false" :clearable="false" :hide-input-icon="true" format="dd/MM/yyyy" ></Datepicker>
                </div>
                <div class="filter-input-group">
                    <input type="text" name="street" id="street" placeholder="Origen" 
                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>
                <div class="filter-input-group">
                    <input type="text" name="street" id="street" placeholder="Destino" 
                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>
                <div class="filter-input-group">
                    <select id="client" name="client" 
                        class="border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Seleccione un cliente</option>
                    </select>
                </div>
                <!-- <div class="filter-input-group">
                    <select id="driver" name="driver"
                        class="border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Seleccione un Chofer</option>
                    </select>
                </div> -->
                <div class="flex items-stretch">
                    <div class="filter-button ml-2 bg-white">
                        <button class="button" @click.prevent="getOrders">
                            <MagnifyingGlassIcon class="w-5 text-gray-700" />
                        </button>
                    </div>
                    <div class="filter-button ml-2 bg-white">
                        <button class="button" @click.prevent="clearFilter">
                            <XMarkIcon class="w-5 text-gray-700" />
                        </button>
                    </div>
                </div>
            </div>

        </div>        

        <div v-if="showMap" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <img src="/images/mapa.png" alt="">
        </div>
        <div v-else class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <div class="bg-white shadow-lg sm:rounded-lg">
                <table class="w-full whitespace-nowrap rounded-t-lg">
                    <tr class="text-left font-bold bg-blue-500 text-white rounded-t-lg ">
                        <th class="px-6 py-3 text-center pl-2">ID</th>
                        <th class="px-6 py-3 ">Fecha</th>
                        <th class="px-6 py-3 ">Hora</th>
                        <th class="px-6 py-3 ">Cliente</th>
                        <th class="px-6 py-3 ">Origen</th>
                        <th class="px-6 py-3 ">Destino</th>
                        <th class="px-6 py-3 ">Pax</th>
                        <th class="px-6 py-3 ">Estado</th>
                        <th class="px-6 py-3  text-center">Acciones</th>
                    </tr> 
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100 text-sm" 
                         v-for="order in this.orders" :key="order.id">
                        <td class="border-t px-6 py-4">{{order.id}}</td>
                        <td class="border-t px-6 py-4">{{order.fecha}}</td>
                        <td class="border-t px-6 py-4">{{order.hora}}</td>
                        <td class="border-t px-6 py-4">{{order.client}}</td>
                        <td class="border-t px-6 py-4">{{order.origen}}</td>
                        <td class="border-t px-6 py-4">{{order.destino}}</td>
                        <td class="border-t px-6 py-4 text-center">{{order.pasajeros}}</td>
                        <td class="border-t px-6 py-4">{{order.status}}</td>
                        <td class="border-t px-6 py-4 text-center">
                            <!-- <a type="button" :href="route('clients.edit', client.id)" -->
                            <div class="flex">
                                <Menu as="div" class="inline-node relative">
                                    <div>
                                        <MenuButton class="border border-gray-200 p-1 rounded-md hover:bg-gray-100">
                                            <EllipsisVerticalIcon class="w-4 text-gray-700" aria-hidden="true"/>
                                        </MenuButton>
                                    </div>
                                    <transition enter-active-class="transition ease-out duration-100"
                                                enter-from-class="transform opacity-0 scale-95"
                                                enter-to-class="transform opacity-100 scale-100"
                                                leave-active-class="transition ease-in duration-75"
                                                leave-from-class="transform opacity-100 scale-100"
                                                leave-to-class="transform opacity-0 scale-95">
                                        <MenuItems class="origin-top-left absolute z-50 right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
                                            <div class="py-1">
                                                <MenuItem v-slot="{ active }">
                                                    <a href="#" class="text-gray-900 block px-4 py-2 text-sm pointer-events hover:bg-gray-100 text-left">Editar</a>
                                                </MenuItem>
                                            </div>

                                            <div class="py-1">
                                                <MenuItem v-slot="{ active }">
                                                    <a href="#" class="text-gray-900 block px-4 py-2 text-sm pointer-events hover:bg-gray-100 text-left">
                                                    Confirmar</a>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }">
                                                    <a href="#" class="text-gray-900 block px-4 py-2 text-sm pointer-events hover:bg-gray-100 text-left">
                                                    Asignar Chofer</a>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }">
                                                    <a href="#" class="text-gray-900 block px-4 py-2 text-sm pointer-events hover:bg-gray-100 text-left">
                                                    Lorem ipsum</a>
                                                </MenuItem>
                                            </div>
                                            <div class="py-1">
                                                <MenuItem v-slot="{ active }">
                                                    <a href="#" class="text-gray-900 block px-4 py-2 text-sm pointer-events hover:bg-gray-100 text-left">
                                                    Cancelar</a>
                                                </MenuItem>

                                            </div>
                                        </MenuItems>
                                    </transition>
                                </Menu>
                                
                                <a type="button" href="#" class="ml-2 inline-flex items-center p-1 border border-gray-200 rounded-md text-white bg-gray-100 
                                            hover:bg-gray-300">
                                    <ChevronRightIcon @click="open = true" class="h-4 w-4 text-gray-700" aria-hidden="true" /></a>
                            </div>
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
                                            <DialogTitle class="text-lg font-medium text-white"> Detalle del Servicio
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
                                                    <label class="text-bold w-24 font-bold">Fecha:</label>
                                                    <span>25/02/2023</span>
                                                </div>

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-24 font-bold">Hora:</label>
                                                    <span>10:30</span>
                                                </div>
                                                
                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-24 font-bold">Origen:</label>
                                                    <span class="underline">Ezeiza</span>
                                                </div>

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-24 font-bold">Destino:</label>
                                                    <span class="underline">Hotel Colonial</span>
                                                </div>

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-24 font-bold">Pasajeros:</label>
                                                    <span>4</span>
                                                </div>
                                                

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-24 font-bold">Teléfono:</label>
                                                    <span>+54 15 123456</span>
                                                </div>

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-24 font-bold">Estado:</label>
                                                    <span>PROGRAMADO</span>
                                                </div>

                                                <hr>
                                                <div>
                                                    <label class="block text-xl font-medium text-gray-800">Pasajeros</label>
                                                </div>
                                                <div class="p-2">
                                                    <label class="block text-sm font-medium text-gray-800">
                                                        <b>Pasajero 1 </b></label>
                                                    
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Nombre y Apellido: </b> Hugo Ibarra</label>

                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>DNI: </b> 12.345.678</label>

                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Tel: </b> +54911 1234 5678</label>
                                                    <hr>
                                                    <label class="block text-sm font-medium text-gray-800">
                                                        <b>Pasajero 2 </b></label>
                                                    
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Nombre y Apellido: </b> Hugo Ibarra</label>

                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>DNI: </b> 12.345.678</label>

                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Tel: </b> +54911 1234 5678</label>
                                                    <hr>
                                                    <label class="block text-sm font-medium text-gray-800">
                                                        <b>Pasajero 3 </b></label>
                                                    
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Nombre y Apellido: </b> Hugo Ibarra</label>

                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>DNI: </b> 12.345.678</label>

                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Tel: </b> +54911 1234 5678</label>
                                                    <hr>
                                                    <label class="block text-sm font-medium text-gray-800">
                                                        <b>Pasajero 4 </b></label>
                                                    
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Nombre y Apellido: </b> Hugo Ibarra</label>

                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>DNI: </b> 12.345.678</label>

                                                    <label class="block text-sm font-medium text-gray-700">
                                                        <b>Tel: </b> +54911 1234 5678</label>

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
    import Datepicker from '@vuepic/vue-datepicker'
    import '@vuepic/vue-datepicker/dist/main.css'
    import Icons from '@/Layouts/Components/Icons.vue'
    import store from '@/store.js'
    import { Bars3Icon,
             ChevronDownIcon,
             ChevronUpIcon,
             MagnifyingGlassIcon,
             XMarkIcon,
             CalendarIcon,
             ChevronRightIcon,
             EllipsisVerticalIcon
            } from '@heroicons/vue/24/outline'

    import {
            TransitionRoot, 
            Dialog, 
            DialogOverlay, 
            TransitionChild, 
            DialogTitle, 
            Menu,
            MenuButton,
            MenuItem,
            MenuItems,
            } from '@headlessui/vue'


    export default {
        props:{

        },
        components: {
            Datepicker,
            Icons,
            Bars3Icon,
            ChevronDownIcon,
            ChevronUpIcon,
            MagnifyingGlassIcon,
            XMarkIcon,
            CalendarIcon,
            ChevronRightIcon,
            EllipsisVerticalIcon,
            TransitionRoot, 
            Dialog, 
            DialogOverlay, 
            TransitionChild, 
            DialogTitle,   
            Menu,
            MenuButton,
            MenuItem,
            MenuItems            
            
        },
    
        setup(){
            
        },

        data() {

            const orders = [
                {
                    id: '1',
                    fecha : '25/02/2023',
                    hora: '10:30',
                    client: 'Agencia ABC',
                    origen : 'Ezeiza',
                    destino: 'Hotel Colonial',
                    pasajeros: '4',
                    status: 'PROGRAMADO',
                },
                {
                    id: '2',
                    fecha : '27/02/2023',
                    hora: '07:00',
                    client: 'Agencia ABC',
                    origen : 'Hotel Alvear',
                    destino: 'Estancia La Linda',
                    pasajeros: '4',
                    status: 'PROGRAMADO',
                },
                {
                    id: '3',
                    fecha : '27/02/2023',
                    hora: '07:00',
                    client: 'Agencia ABC',
                    origen : 'Hotel Alvear',
                    destino: 'Estancia La Linda',
                    pasajeros: '4',
                    status: 'PROGRAMADO',
                },
                {
                    id: '3',
                    fecha : '',
                    hora: '',
                    client: '',
                    origen : '',
                    destino: '',
                    pasajeros: '',
                    status: '',
                },

            ];



            return {
                open: false,
                store,    
                btnTextMap: '', 
                filterBtn: false,
                showFilter: true,
                orders: orders,
                filter: {
                    street: "",
                    client: "",
                    driver: "",
                    status: "TODOS",
                    date: [
                        new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000 - 3600000 * 3),
                        new Date(new Date().getTime() - 3600000 * 3)
                    ]
                    //new Date(this.form.date + "T00:00:00.000-03:00")
                },  
                showMap: false                 
            }
        },
        methods:{
            // showMap() {
            //     this.showFilter = !this.showFilter
            //     if (this.showFilter) {
            //         this.btnTextMap = 'Ver Listado'
            //     } else {
            //         this.btnTextMap = 'Ver Mapa'
            //     }
            // },
        }
    }
</script>