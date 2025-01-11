<template>
    <main>
        <div class="border-b border-gray-200 px-4 py-4 flex items-center justify-between sm:px-6 lg:px-8">
            <h1 class="text-xl font-medium leading-6 text-gray-900 sm:truncate">
                Últimas entregas
            </h1>
            <div class="mt-4 flex sm:mt-0">
                <a @click="showForm = !showForm"
                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">
                    Nueva Entrega</a>
            </div>
            <!-- <button class="bg-green-600 text-white px-4 rounded-md">Nueva Entrega</button> -->
        </div>
        <!-- <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast> -->

        <div v-if="showForm" class="px-4 mt-6 sm:px-6 lg:px-8">

            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">

                    <div class="grid grid-cols-12 gap-6">

                        <h3 class="col-span-12 text-lg leading-6 font-medium text-gray-900">Nueva Entrega</h3>

                        <!-- <div class="col-span-12 sm:col-span-4 ">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input v-model="filter.name" type="text" name="name" id="name" autocomplete="name-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div> -->

                        <div class="col-span-12 sm:col-span-4 ">
                            <label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de
                                Documento</label>
                            <input v-model="filter.documento" type="text" name="num_documento" id="num_documento"
                                autocomplete="address-level2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>

                        <!-- <button @click="showForm = !showForm; showPersona = !showPersona" -->
                        <button @click="searchPerson"
                            class="col-span-12 sm:col-span-4 bg-green-600 text-white px-4 rounded-md py-2">
                            Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <Persona v-if="showPersona" 
                :person="person" 
                :puntosEntrega="puntosEntrega"
                :products="products"
                :user="user"
                @clearPerson="clearPerson" />

        <History v-if="showPersona" :history="history" />

        <Dashboard v-if="!showPersona && !showForm"  
                   :products="products" 
                   :puntosEntrega="puntosEntrega" 
                   :users="users"/>

    </main>
</template>

<script>
import { ref } from 'vue'
import {
    Menu,
    MenuButton,
    MenuItems,
    MenuItem
} from '@headlessui/vue'

import { ChevronRightIcon, EllipsisVerticalIcon, ClockIcon, CheckCircleIcon, EyeIcon } from '@heroicons/vue/24/solid'
import store from '@/store.js'
import History from './History.vue'
import Persona from './Persona.vue'
import Dashboard from './Dashboard.vue'
export default {
    props: {
        puntosEntrega: Array,
        products: Array,
        users: Array
    },
    components: {
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        EllipsisVerticalIcon,
        ChevronRightIcon,
        ClockIcon,
        CheckCircleIcon,
        EyeIcon,
        History,
        Persona,
        Dashboard
    },
    data() {
        return {
            showPersona: false,
            showForm: false,
            data: "",
            puntosEntrega: "",
            filter: {
                name: "",
                num_documento: "11111111",
            },
            person: '',
            products: "",
            user: ""            
        };
    },

    setup() {
        const sidebarOpen = ref(false)

        return {
            sidebarOpen,
            store,

        }
    },
    methods: {
        async searchPerson() {
            const response = await axios.get(route('collections.getPerson', this.filter.documento))

            if (response.status == 200) {
                this.person = await response.data.person
                this.history = await response.data.history
                this.showPersona = true
                this.showForm = false
            }
            console.log(this.filter)
        },
        clearPerson() {
            this.person = ''
            this.showPersona = false
            this.showForm = true
        },
        async getData() {
            const response = await axios.get(route('collections.getCollectionsFormData'))
            this.puntosEntrega = await response.data.puntosEntrega
            this.products = await response.data.products
            this.user = await response.data.user
        }
    },

    created() {
        this.getData()
    }


}
</script>

<style></style>