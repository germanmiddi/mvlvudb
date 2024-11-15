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
                                <!-- cambiar de ver bandeja a ojito
                          gris fondo - iconos 
                          cambiar letras por una tarjeta de color, verde apra entregadas y amarillo/naranja para las pendientes
                          Quiza el ver mas ver un modal con detalles, que detalles?
                          -->

                                <!-- Cuando tenga la bd, hacer un forreach por cada punto de entrega con sus respectivas enmtregas pendientes y realizadas, ytodo esto traido desde el back -->
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
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
export default {
    components: {
        CheckCircleIcon
    },
    data() {
        return {
            puntosEntrega: [],
            collections: []
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
