<template>
    <div>
        <div class="px-4 mt-6 sm:px-6 lg:px-8">
            <ul role="list" class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2 xl:grid-cols-3 mt-3">
                <li v-for="item in statistics" :key="item.id"
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
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white" @click="getCollectionList()">Aplicar Filtro</button>
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

                        <div class="col-span-12 sm:col-span-5">
                            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                            <Datepicker class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" v-model="filter.date" range multiCalendars
                                    :closeOnAutoApply="true" :enableTimePicker="false" :format="customFormat"></Datepicker>
                        </div>
                        
                        
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
                                    <option v-for="punto in puntosEntrega" :key="punto.id" :value="punto.id">{{ punto.description }}</option>
                            </select> 
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                            <label for="entregado_por" class="block text-sm font-medium text-gray-700">Entregado por</label>
                            <select v-model="filter.entregado_por" name="entregado_por" id="entregado_por" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="" selected>Selecciones un entrevistador</option>
                                    <option v-for="entrevistador in users" :key="entrevistador.id" :value="entrevistador.id">{{ entrevistador.name }}</option>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documento</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Punto de entrega</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entregado por</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">                                
                                <tr v-for="item in collections.data" :key="item.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ store.dateFormateada(item.date) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.person }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.num_documento }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.punto_entrega }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.entregado_por }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.producto }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <div class="flex justify-between mx-5 my-3 px-2 items-center">
                            <div>
                                Mostrando: {{ this.collections.from }} a {{ this.collections.to }} - Entradas encontradas:
                                {{ this.collections.total }}
                            </div>

                            <div class="flex flex-wrap -mb-1">
                                <template v-for="link in collections.links" :key="link.url">
                                    <div v-if="link.url === null"
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded-md"
                                        v-html="link.label"> </div>
                                    <div v-else
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-gray-300 rounded-md hover:bg-blue-500 hover:text-white cursor-pointer"
                                        :class="{ 'bg-blue-500': link.active }, { 'text-white': link.active }"
                                        @click="getListPaginate(link.url)" v-html="link.label"> </div>
                                </template>
                            </div>
                        </div>                        
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
import store from '@/store.js'

export default {
    props: {
        puntosEntrega: Array,
        products: Array,    
        users: Array
    },
    components: {
        CheckCircleIcon,
        Datepicker
    },
    data() {
        return {
            statistics: [],
            collections: [],
            filter: {},
            length: 30,
            customFormat: 'd-M-Y',
        }
    },
    setup() {
        return {
            store
        }
    },
    mounted() {
        this.getData()
        this.getCollectionList()
    },
    methods: {
        clearFilter(){
            this.filter = {}
            this.getCollectionList()
        },
        
        async getData() {
            let response = await axios.get(route('collections.puntosEntregaStatistics'))
            let list = await response.data
            this.statistics = list
        },

        async getCollectionList() {
            
            this.collections = ''
            let filter = `&length=${this.length}`

            if(this.filter.name){
                filter += `&name=${this.filter.name}`
            }
            if(this.filter.num_documento){
                filter += `&num_documento=${this.filter.num_documento}`
            }
            if(this.filter.date) {
                filter += `&date=${JSON.stringify(this.filter.date)}`
            }
            if(this.filter.product_id){
                filter += `&product_id=${this.filter.product_id}`
            }
            if(this.filter.punto_entrega_id){
                filter += `&punto_entrega_id=${this.filter.punto_entrega_id}`
            }

            if(this.filter.entregado_por){
                filter += `&entregado_por=${this.filter.entregado_por}`
            }
            const get = `${route('collections.getCollectionList')}?${filter}`

            const response = await fetch(get, { method: "GET" });

            this.collections = await response.json();
        },
        // async getListPaginate(link) {
        //     var get = `${link}`;
        //     const response = await fetch(get, { method: 'GET' })
        //     this.collections = await response.data
        // },        
    }
}

</script>
