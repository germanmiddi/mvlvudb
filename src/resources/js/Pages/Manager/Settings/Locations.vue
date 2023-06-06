<template>
<!-- eslint-disable -->
    <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-3">
                            <div class="px-4 sm:px-0 flex justify-between items-center mb-3">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Lista de Locaciones</h3>
                                <input type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 w-96  shadow-sm sm:text-sm border-gray-300 rounded-md"  placeholder="Buscar"/>
                                <button class="btn-blue"> Nueva Locacion</button>
                                
                            </div>
                        </div>
                    </div>                        
                    <div class="md:col-span-3 mt-5">
                        <table class="w-full whitespace-nowrap">
                            <tr class="text-left font-bold bg-blue-500 text-white">
                                <th class="px-6 py-3 text-center">Tipo</th>
                                <th class="px-6 py-3 text-left">Descripción</th>
                                <!-- <th class="px-6 py-3 text-center">Ciudad</th>
                                <th class="px-6 py-3 text-center">Provincia</th>
                                <th class="px-6 py-3 text-center">CP</th> -->
                            </tr>
                            <tr v-for="location in locations" :key="location.id"
                                class="hover:bg-gray-100 focus-within:bg-gray-100 text-sm ">
                                <td class="border-t px-4 py-2 text-center">{{ location.type }}</td>
                                <td class="border-t px-4 py-2 text-left">
                                    <span class="font-bold text-sm">{{ location.name }} </span><br>
                                    <span class="text-xs ">{{ location.address }} {{ location.city }} {{ location.state }} {{ location.zip }}</span>

                                </td>
                                <!-- <td class="border-t px-6 py-4 text-center">{{ location.address }}</td>
                                <td class="border-t px-6 py-4 text-center">{{ location.city }}</td>
                                <td class="border-t px-6 py-4 text-center">{{ location.state }}</td>
                                <td class="border-t px-6 py-4 text-center">{{ location.zip }}</td> -->
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
         </div>
</template>

<script>

export default {

    data(){
        return {
            locations: [],
        }
    },

    methods: {
        async getLocations() {
            
            let response = await fetch(route('location.list'), { method: 'GET' })
            this.locations = await response.json()

        },
    },

    created() {
        this.getLocations();
    },

}
</script>

<style>

</style>