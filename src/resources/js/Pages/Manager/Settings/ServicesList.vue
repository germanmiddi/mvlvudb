<template>
<!-- eslint-disable -->
    <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-3">
                            <div class="px-4 sm:px-0 flex justify-between items-center mb-3">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Lista de Servicios</h3>
                                <input type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 w-96  shadow-sm sm:text-sm border-gray-300 rounded-md"  placeholder="Buscar"/>
                                <button class="btn-blue">Nuevo Servicio</button>
                                
                            </div>
                        </div>
                    </div>                        
                    <div class="md:col-span-3 mt-5">
                        <div class="overflow-x-auto">
                            <table class="w-full whitespace-nowrap">
                                <tr class="text-left font-bold bg-blue-500 text-white">
                                    <th class="px-6 py-3 text-center">Detalle</th>
                                    <th class="px-6 py-3 text-center">Tipo</th>
                                    <th class="px-6 py-3 text-center">Espera</th>
                                    <th class="px-6 py-3 text-center">Equipaje</th>
                                    <th class="px-6 py-3 text-center">Guia</th>
                                    <th class="px-6 py-3 text-center">Cant Pax</th>
                                    <th class="px-6 py-3 text-center">Duración</th>
                                </tr>
                                <tr v-for="service in services" :key="service.id"
                                    class="hover:bg-gray-100 focus-within:bg-gray-100 text-sm ">
                                        <td class="border-t px-4 py-2 text-left">{{service.detail}}</td>
                                        <td class="border-t px-4 py-2 text-left">{{service.type}}</td>
                                        <td class="border-t px-4 py-2 text-center">{{service.wait_time}}</td>
                                        <td class="border-t px-4 py-2 text-center">{{service.baggage}}</td>
                                        <td class="border-t px-4 py-2 text-center">{{service.guide}}</td>
                                        <td class="border-t px-4 py-2 text-center">{{service.passenger_capacity}}</td>
                                        <td class="border-t px-4 py-2 text-center">{{service.duration}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
         </div>
</template>

<script>

export default {

    data(){
            const services = [
                {
                    detail: 'Transfer Ezeiza / Hotel Céntrico o Viceversa',
                    type: 'TRF',
                    wait_time: 1,
                    baggage: 0,
                    guide: 0,
                    passenger_capacity: 4,
                    duration: null,
                },
                {
                    detail: 'Transfer Ezeiza / Hotel Céntrico o Viceversa',
                    type: 'TRF VAN',
                    wait_time: 1,
                    baggage: 0,
                    guide: 0,
                    passenger_capacity: 7,
                    duration: null,
                },
                {
                    detail: 'Transfer Ezeiza / Hotel Céntrico o Viceversa',
                    type: 'TRF COMBI',
                    wait_time: 1,
                    baggage: 0,
                    guide: 0,
                    passenger_capacity: 19,
                    duration: null,
                },
                {
                    detail: 'Transfer Ezeiza / Hotel Céntrico o Viceversa',
                    type: 'TRF MINUBUS',
                    wait_time: 1,
                    baggage: 0,
                    guide: 0,
                    passenger_capacity: 24,
                    duration: null,
                },
                {
                    detail: 'Transfer Ezeiza / Hotel Céntrico o Viceversa',
                    type: 'TRF',
                    wait_time: 1,
                    baggage: 1,
                    guide: 1,
                    passenger_capacity: 2,
                    duration: null,
                },
                {
                    detail: 'Transfer Ezeiza / Hotel Céntrico o Viceversa',
                    type: 'TRF VAN',
                    wait_time: 1,
                    baggage: 1,
                    guide: 1,
                    passenger_capacity: 6,
                    duration: null,
                },
                {
                    detail: 'Transfer Ezeiza / Hotel Céntrico o Viceversa',
                    type: 'TRF COMBI',
                    wait_time: 1,
                    baggage: 1,
                    guide: 1,
                    passenger_capacity: 12,
                    duration: null,
                },
                {
                    detail: 'Transfer Ezeiza / Hotel Céntrico o Viceversa',
                    type: 'TRF MINUBUS',
                    wait_time: 1,
                    baggage: 1,
                    guide: 1,
                    passenger_capacity: 17,
                    duration: null,
                },
                {
                    detail: 'Transfer Ezeiza / Palermo o Viceversa',
                    type: 'TRF',
                    wait_time: 1,
                    baggage: 0,
                    guide: 0,
                    passenger_capacity: 4,
                    duration: null,
                },
                {
                    detail: 'Transfer Ezeiza / Palermo o Viceversa',
                    type: 'TRF VAN',
                    wait_time: 1,
                    baggage: 0,
                    guide: 0,
                    passenger_capacity: 7,
                    duration: null,
                },
                {
                    detail: 'Transfer Ezeiza / Palermo o Viceversa',
                    type: 'TRF COMBI',
                    wait_time: 1,
                    baggage: 0,
                    guide: 0,
                    passenger_capacity: 19,
                    duration: null,
                },
                {
                    detail: 'Transfer Ezeiza / Palermo o Viceversa',
                    type: 'TRF MINUBUS',
                    wait_time: 1,
                    baggage: 0,
                    guide: 0,
                    passenger_capacity: 24,
                    duration: null,
                },
                {
                    detail: 'Transfer Ezeiza / Palermo o Viceversa',
                    type: 'TRF',
                    wait_time: 1,
                    baggage: 1,
                    guide: 1,
                    passenger_capacity: 2,
                    duration: null,
                },
                {
                    detail: 'Transfer Ezeiza / Palermo o Viceversa',
                    type: 'TRF VAN',
                    wait_time: 1,
                    baggage: 1,
                    guide: 1,
                    passenger_capacity: 6,
                    duration: null,
                },
                {
                    detail: 'Transfer Ezeiza / Palermo o Viceversa',
                    type: 'TRF COMBI',
                    wait_time: 1,
                    baggage: 1,
                    guide: 1,
                    passenger_capacity: 12,
                    duration: null,
                },
                {
                    detail: 'Transfer Ezeiza / Palermo o Viceversa',
                    type: 'TRF MINUBUS',
                    wait_time: 1,
                    baggage: 1,
                    guide: 1,
                    passenger_capacity: 17,
                    duration: null,
                },
                {
                    detail: 'Transfer Buquebus / Hotel o Viceversa',
                    type: 'TRF',
                    wait_time: 0,
                    baggage: 0,
                    guide: 0,
                    passenger_capacity: 4,
                    duration: null,
                },
                {
                    detail: 'Transfer Buquebus / Hotel o Viceversa',
                    type: 'TRF VAN',
                    wait_time: 0,
                    baggage: 0,
                    guide: 0,
                    passenger_capacity: 7,
                    duration: null,
                },
                {
                    detail: 'Transfer Buquebus / Hotel o Viceversa',
                    type: 'TRF COMBI',
                    wait_time: 0,
                    baggage: 0,
                    guide: 0,
                    passenger_capacity: 19,
                    duration: null,
                },
                {
                    detail: 'Transfer Buquebus / Hotel o Viceversa',
                    type: 'TRF MINUBUS',
                    wait_time: 0,
                    baggage: 0,
                    guide: 0,
                    passenger_capacity: 24,
                    duration: null,
                },    
                {
                    detail: 'Transfer Terminal Bus Retiro / Hotel o Viceversa',
                    type: 'TRF',
                    wait_time: 0,
                    baggage: 0,
                    guide: 0,
                    passenger_capacity: 4,
                    duration: null,
                },
                {
                    detail: 'Transfer Terminal Bus Retiro / Hotel o Viceversa',
                    type: 'TRF VAN',
                    wait_time: 0,
                    baggage: 0,
                    guide: 0,
                    passenger_capacity: 7,
                    duration: null,
                },
                {
                    detail: 'Transfer Terminal Bus Retiro / Hotel o Viceversa',
                    type: 'TRF COMBI',
                    wait_time: 0,
                    baggage: 0,
                    guide: 0,
                    passenger_capacity: 19,
                    duration: null,
                },
                {
                    detail: 'Transfer Terminal Bus Retiro / Hotel o Viceversa',
                    type: 'TRF MINUBUS',
                    wait_time: 0,
                    baggage: 0,
                    guide: 0,
                    passenger_capacity: 24,
                    duration: null,
                },
                {
                    detail: 'Transfer Terminal Bus Retiro / Hotel o Viceversa',
                    type: 'TRF',
                    wait_time: 1,
                    baggage: 1,
                    guide: 1,
                    passenger_capacity: 2,
                    duration: null,
                },
                {
                    detail: 'Transfer Terminal Bus Retiro / Hotel o Viceversa',
                    type: 'TRF VAN',
                    wait_time: 1,
                    baggage: 1,
                    guide: 1,
                    passenger_capacity: 6,
                    duration: null,
                },
                {
                    detail: 'Transfer Terminal Bus Retiro / Hotel o Viceversa',
                    type: 'TRF COMBI',
                    wait_time: 1,
                    baggage: 1,
                    guide: 1,
                    passenger_capacity: 12,
                    duration: null,
                },
                {
                    detail: 'Transfer Terminal Bus Retiro / Hotel o Viceversa',
                    type: 'TRF MINUBUS',
                    wait_time: 1,
                    baggage: 1,
                    guide: 1,
                    passenger_capacity: 17,
                    duration: null,
                },                
                



            ];



        return {
            services,
        }
    },

    // methods: {
    //     async getServices() {
            
    //         let response = await fetch(route('services.list'), { method: 'GET' })
    //         this.services = await response.json()

    //     },
    // },

    // created() {
    //     this.getServices();
    // },

}
</script>

<style>

</style>