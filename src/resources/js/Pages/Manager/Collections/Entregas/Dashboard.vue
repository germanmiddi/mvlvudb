<template>
    <div>
        <div class="px-4 mt-6 sm:px-6 lg:px-8">
            <ul role="list" class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2 xl:grid-cols-3 mt-3">
                <li v-for="item in puntosEntrega" :key="item.id"
                    class="relative col-span-1 flex rounded-md hover:opacity-70 duration-300 cursor-pointer my-3">
                    <a href="#" class="w-full flex">
                        <div
                            class="flex-1 flex items-center justify-between rounded-md truncate w-full bg-gray-100 py-2">
                            <div class="flex flex-col space-y-1 px-4 py-2 text-sm truncate w-full">
                                <p class="text-gray-900 text-lg font-medium">
                                    {{ item.punto_entrega.description }}
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    <p class="bg-green-600 text-white text-sm px-1 py-1 rounded-md flex gap-x-1">
                                        <CheckCircleIcon class="w-5" />
                                        {{ item.cantidad }} Entregas realizadas
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <div class="px-4 mt-6 sm:px-6 lg:px-8">

            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
                        <div class="">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Filtro</h3>
                        </div>
                        <div class="flex-shrink-0 flex item-center">
                            <button v-if="Object.keys(this.filter).length" class="text-xs font-medium text-gray-500 hover:text-gray-700 mr-2"
                                    @click="clearFilter">Limpiar Filtro</button>
                            <button type="button"
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white" @click="getTramites()">Aplicar Filtro</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 sm:col-span-3 ">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input v-model="filter.name" type="text" name="name" id="name" autocomplete="name-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>

                        <div class="col-span-12 sm:col-span-3 ">
                            <label for="num_documento" class="block text-sm font-medium text-gray-700">Documento</label>
                            <input v-model="filter.num_documento" type="text" name="num_documento" id="num_documento"
                                autocomplete="address-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>

                        <div class="col-span-12 sm:col-span-3">
                            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                            <Datepicker class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" v-model="filter.date" range multiCalendars
                                    :closeOnAutoApply="true" :enableTimePicker="false" :format="customFormat"></Datepicker>
                        </div>
                        
                        <div class="col-span-12 sm:col-span-3"></div>
                        <div class="col-span-12 sm:col-span-3">
                            <label for="product_id" class="block text-sm font-medium text-gray-700">Producto</label>
                            <select v-model="filter.product_id" name="product_id" id="product_id" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="" selected>Selecciones un producto</option>
                                    <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }}</option>
                            </select> 
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                            <label for="punto_entrega_id" class="block text-sm font-medium text-gray-700">Punto de entrega</label>
                            <select v-model="filter.punto_entrega_id" name="punto_entrega_id" id="punto_entrega_id" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="" selected>Selecciones un punto de entrega</option>
                                    <option v-for="punto in puntosEntrega" :key="punto.id" :value="punto.id">{{ punto.punto_entrega.description }}</option>
                            </select> 
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="flex flex-col mt-8 mx-4 sm:mx-6 lg:mx-8">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documento</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Punto de entrega</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr v-for="item in collections" :key="item.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.person.name }} {{ item.person.lastname }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.person.num_documento }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.punto_entrega.description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.product.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.date }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue'
import { CheckCircleIcon } from '@heroicons/vue/24/solid'
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

export default {
    components: {
        CheckCircleIcon,
        Datepicker
    },
    data() {
        return {
            puntosEntrega: [],
            collections: [],
            filter: {}
        }
    },
    mounted() {
        this.getData()
        this.getCollectionList()
    },
    methods: {
        async getData() {
            let response = await axios.get(route('collections.puntosEntregaStatistics'))
            let list = await response.data
            this.puntosEntrega = list
        },
        async getCollectionList() {
            let response = await axios.get(route('collections.getCollectionList'))
            let list = await response.data
            this.collections = list
        }
    }
}

</script>
