<template>
<!-- eslint-disable -->
    <div class="w-full">
        <header class="">
            <div class="flex justify-between max-w-7xl mx-auto py-6 px-10">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center">
                   <ChevronLeftIcon class="w-5 mr-2 rounded-full hover:bg-white" @click="goBack" /> Solicitudes - Crear Solicitud
                </h2>
                <div class="space-x-2" >
                    <!-- <button class="btn-blue" @click="showNewService = !showNewService">
                        Agregar Servicio
                    </button> -->
                    <a class="btn-blue" :href="route('client.create')" >
                        Guardar
                    </a>

                </div>
            </div>
        </header>

        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">                        
                    <div class="border-b border-gray-900/10 pb-12">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Datos Generales</h3>
                                    <p class="mt-1 text-sm text-gray-600">Indique los datos generales del servicio.</p>
                                </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <form action="#" method="POST">
                                    <div class="grid grid-cols-6 gap-6">

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="client_type"
                                                class="block text-sm font-medium text-gray-700">Cliente</label>
                                            <select id="client_type" name="client_type" v-model="form.client_id"
                                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option disabled value="">Seleccione un Cliente</option>
                                                <option v-for="client in clients" :key="client.id" :value="client.id">
                                                    {{ client.company_name }}
                                                </option>

                                            </select>
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="responsible"
                                                class="block text-sm font-medium text-gray-700">Responsable</label>
                                            <input type="text" name="responsible" id="responsible" v-model="form.responsible"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>

                                        <div class="col-span-6 sm:col-span-6">
                                            <label for="observations"
                                                class="block text-sm font-medium text-gray-700">Notas</label>
                                            <textarea type="text" rows=5 name="observations" id="observations"
                                                v-model="form.observations"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"> </textarea>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Servicios</h3>
                                    <p class="mt-1 text-sm text-gray-600">Detalle de los servicios requeridos.</p>
                                </div>
                            </div>

                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="w-full flex justify-end">
                                    <button class="btn-blue" @click="showNewService = !showNewService">
                                        Agregar Servicio
                                    </button>
                                </div>

                                <!-- <div v-for="service in services" :key="service.id" > -->
                                    <div v-for="service in services" :key="service.id" class="bg-gray-50 sm:rounded-lg">
                                        <div class="px-4 py-5 sm:px-6 mt-8">
                                            
                                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{service.service.detail}}</h3>
                                            <p class="mt-1 max-w-2xl text-sm text-gray-500 mb-8">Fecha: {{formatDate(service.date)}}</p>
                                        
                                            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">Origen</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">{{service.location_from}}</dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">Destino</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">{{service.location_to}}</dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">Nombre Guia</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">{{service.guide_name}}</dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">Nro Vuelo</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">{{service.flight_number}}</dd>
                                                </div>
                                                <!-- <div class="sm:col-span-2">
                                                <dt class="text-sm font-medium text-gray-500">About</dt>
                                                <dd class="mt-1 text-sm text-gray-900">Fugiat ipsum ipsum deserunt culpa aute sint do nostrud anim incididunt cillum culpa consequat. Excepteur qui ipsum aliquip consequat sint. Sit id mollit nulla mollit nostrud in ea officia proident. Irure nostrud pariatur mollit ad adipisicing reprehenderit deserunt qui eu.</dd>
                                                </div> -->

                                            </dl>
                                        </div>
                                    </div>





                                    <!-- <div class="bg-gray-50 rounded-xl p-8 my-4">
                                        <div class="flex justify-between">
                                            <div class="text-xl">
                                                <div class="inline-block"> {{ service.service.detail }} </div>
                                            </div>
                                            <div >
                                                <div class="font-bold inline-block">Fecha: </div>
                                                <div class="inline-block mr-3 "> {{ formatDate(service.date) }} </div> 
                                                <div class="font-bold inline-block">Hora: </div> 
                                                <div class="inline-block"> {{ formatTime(service.time)  }} </div>

                                            </div>
                                        </div>    
                                        <div><div class="font-bold w-24">Origen:</div> <span class="tracking-wide">{{ service.location_from }}</span></div>
                                        <div><div class="font-bold w-20">Destino:</div> <span class="tracking-wide">{{ service.location_to }}</span></div>
                                    </div> -->

                                   

                                <!-- </div> -->
 
                            </div>
                        </div>
                    </div>



                </div>
            </div>
 
        </div>

         <Services v-show="showNewService" 
                  :locations="locations" 
                  :client="form.client_id" 
                  @createService="createService"  />
    </div> 
</template>


<script>

import { defineComponent, ref } from 'vue'
import Icons from '@/Layouts/Components/Icons.vue'
import Toast from '@/Layouts/Components/Toast.vue'
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import Services from '@/Pages/Manager/Requests/Services.vue'

import {
         ChevronLeftIcon
        } from '@heroicons/vue/24/outline'

import { Inertia } from '@inertiajs/inertia';
export default defineComponent({
    props: {
        clients: Object,
        locations: Object,
    },

    components: {
        Icons,
        Toast,
        ChevronLeftIcon,
        Inertia,
        Datepicker,
        Services                
    },

    setup() {

        const format = (date) => {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            return `${day}/${month}/${year}`;
        }

        const startTime = ref({ hours: 9, minutes: 0 });

        return {
            format,
            startTime
        }
    },


    data() {
    
        return {
            form: {},
            toastMessage: "",
            showNewService: false,
            services: [{
                        "date":"[native Date Thu May 11 2023 14:26:00 GMT-0300 (Argentina Standard Time)]",
                        "time":{"hours":9,"minutes":0,"seconds":0},"cant_pax":3,"guia":"1","equipaje":"1",
                        "service":{"id":30,"client_id":1,"detail":"Transfer Ezeiza / Palermo o Viceversa","type":"TRF VAN","wait_time":1,"baggage":true,"guide":true,"passenger_capacity":6,"duration":null,"price":137,"active":true,"created_by":1,"deleted_at":null,"created_at":null,"updated_at":null},
                        "guide_name":"asdasd",
                        "flight_number":"asdasd",
                        "location_from":"Aeropuerto Internacional Ministro Pistarini (Ezeiza)",
                        "location_to":"Hotel Pulitzer Buenos Aires"
                    }],

            

        }
    },

    methods: {
        formatDate(date) {
            const formattedDate = new Date(date).toLocaleDateString('es-AR', {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric'
            });
            return formattedDate;
        },

        formatTime(time) {
            const formattedTime = new Date(`1970-01-01T${time}`).toLocaleTimeString('es-AR', {
                hour: 'numeric',
                minute: 'numeric'
            });
            return formattedTime;
        },        

        createService(service) {
            
            console.log(service)
            this.services.push(service)

        },

        getServices(){
          


        },

        goBack() {
           Inertia.visit(document.referrer);
        },
        clearMessage() {
            this.toastMessage = ""
        },

        submit() {
            this.$inertia.post(route('client.store'), this.form)
        },
    },
    created() {
        //this.getCity()
    }
})
</script>
