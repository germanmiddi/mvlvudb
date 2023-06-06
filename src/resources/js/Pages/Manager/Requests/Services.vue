<template>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">                        
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Agregar Servicios</h3>
                            <p class="mt-1 text-sm text-gray-600">Indique los datos generales del servicio.</p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-6 gap-6">

                            <div class="col-span-6 sm:col-span-3">
                                <label for="date" class="block text-sm font-medium text-gray-700">Fecha:</label>

                                <Datepicker id="date" class="w-full mt-1" v-model="form.date"
                                    :enableTimePicker="false" :monthChangeOnScroll="false"
                                    :minDate="new Date(new Date().setDate(new Date().getDate() - 1))"
                                    autoApply :format="format"></Datepicker>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="time" class="block text-sm font-medium text-gray-700">Hora:</label>

                                <Datepicker id="time" class="w-full mt-1" v-model="form.time"
                                    :startTime="startTime" timePicker>
                                </Datepicker>
                            </div>


                            <div class="col-span-6 sm:col-span-2">
                                <label for="cellphone"
                                    class="block text-sm font-medium text-gray-700">Pasajeros</label>
                                <input type="number" name="cant_pax" id="cant_pax" @change="getServices"
                                    v-model="form.cant_pax"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            
                            <div class="col-span-6 sm:col-span-2">
                                <label for="guia"
                                    class="block text-sm font-medium text-gray-700">Guia</label>
                                <select id="guia" name="guia" @change="getServices" v-model="form.guia"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="0">Sin Guia</option>
                                    <option value="1">Con Guia</option>
                                </select>
                            </div>                                    

                            <div class="col-span-6 sm:col-span-2">
                                <label for="equipaje"
                                    class="block text-sm font-medium text-gray-700">Equipaje</label>
                                <select id="equipaje" name="equipaje" @change="getServices" v-model="form.equipaje"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="0">Sin Equipaje</option>
                                    <option value="1">Con Equipaje</option>
                                </select>
                            </div>                                    


                            <div class="col-span-6 sm:col-span-6">
                                <label for="service_id"
                                    class="block text-sm font-medium text-gray-700">Servicio</label>
                                <select id="service_id" name="service_id" v-model="form.service" 
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option disabled value="">Seleccione un Servicio</option>
                                    <option v-for="service in services" :key="service.id" :value="service">
                                        {{ service.detail }} | {{ service.type }} | Precio: {{ service.price }}
                                    </option>

                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="guide_name"
                                    class="block text-sm font-medium text-gray-700">Nombre Guia</label>
                                <input type="text" name="guide_name" id="guide_name" v-model="form.guide_name"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="flight_number"
                                    class="block text-sm font-medium text-gray-700">Nro Vuelo</label>
                                <input type="text" name="flight_number" id="flight_number" v-model="form.flight_number"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-6">
                                <label for="location_from" class="block text-sm font-medium text-gray-700">Origen:</label>
                                <input type="text" list="locations_from" v-model="form.location_from" id="location_from" 
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <datalist id="locations_from">
                                <option v-for="loc in locations" :value="loc.name" :key="loc.id" >{{ loc.name }}</option>
                                </datalist>
                            </div>

                            <div class="col-span-6 sm:col-span-6">
                                <label for="location_to" class="block text-sm font-medium text-gray-700">Destino:</label>
                                <input type="text" list="locations_to" v-model="form.location_to" id="location_to"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <datalist id="locations_to">
                                <option v-for="loc in locations" :value="loc.name" :key="loc.id" >{{ loc.name }}</option>
                                </datalist>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button @click="createService" class="btn-blue">CREAR</button>
            </div>                
        </div>
    </div>
</template>

<script>


import { defineComponent, ref } from 'vue'
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

export default {

    props: {
        locations: Object,
        client: String
    },
    
    components: {
        Datepicker
    },

    data(){
        return {
            form:{},
            services: {},
            cant_pax: "",
            guia: "",
            equipaje : "",
        }
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



    methods: {
        createService(){

            if(this.form.service === undefined ){
                return 
            }else{
                this.$emit('createService', this.form)
                this.form = {}

            }
            
        },

        async getServices(){
            
            if (this.client === undefined) {
                return
            }

            let filter = `client_id=${this.client}`


            if (this.form.cant_pax > 0) {
				filter += `&pax=${this.form.cant_pax}`
			}

            // let type = typeof(this.form.guia)
            // console.log(type)

            if (this.form.guia !== undefined) {
				filter += `&guia=${this.form.guia}`
			}

            if (this.form.equipaje !== undefined) {
				filter += `&equipaje=${this.form.equipaje}`
			}


            let get = `${route('services.filter')}?${filter}`  ;

            let response = await fetch(get, {method: 'GET',})             

            if (response.status == 200){
                this.services = await response.json()

            }

        },

    },

}
</script>

<style>

</style>