<template>
    <main>
        <div class="border-b border-gray-200 px-4 py-4 flex items-center justify-between sm:px-6 lg:px-8">
            <h1 class="text-xl font-medium leading-6 text-gray-900 sm:truncate">
                Últimas entregas
            </h1>
            <div class="mt-4 flex sm:mt-0">
                <!-- <a @click="newEntrega()" -->
                <a
                    class="order-0 inline-flex items-center px-4 py-2 
                          border border-transparent shadow-sm text-sm font-medium rounded-md 
                          text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">
                    Exportar</a>
                <a @click="showForm = !showForm"
                    class="order-0 inline-flex items-center px-4 py-2 
                           border border-transparent shadow-sm text-sm font-medium rounded-md 
                           text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">
                    Nueva Entrega</a>
            </div>
            <!-- <button class="bg-green-600 text-white px-4 rounded-md">Nueva Entrega</button> -->
        </div>
        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

        <div v-if="showForm" class="px-4 mt-6 sm:px-6 lg:px-8 w-full">
            <div class="flex items-center bg-white rounded-md w-full" :class="loadingPerson ? 'opacity-50' : ''">
                <!-- Campo de entrada -->
                <input v-model="filter.documento" type="text" id="num_documento" placeholder="Ingrese un documento"
                    class="flex-grow px-4 py-2 sm:text-sm border border-gray-300 focus:border-green-600 focus:ring-0 rounded-l-md outline-none placeholder-italic"
                    :disabled="loadingPerson" />
                <!-- Botón de búsqueda -->
                <button @click="searchPerson" :disabled="loadingPerson"
                    class="w-[150px] py-2 rounded-r-md flex items-center justify-center  bg-green-200 text-green-900 hover:bg-green-600 hover:text-white border border-green-200 hover:border-green-600 duration-200">
                    <div v-if="loadingPerson">
                        <svg width="20px" height="20px" class="animate-spin" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24">
                            <title>loading</title>
                            <path fill="currentColor" d="M12,4V2A10,10 0 0,0 2,12H4A8,8 0 0,1 12,4Z" />
                        </svg>
                    </div>
                    <div v-else class="flex items-center gap-x-2">
                        <span class="ml-2 text-sm">Buscar</span>
                        <svg width="20px" height="20px" hxmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <title>magnify</title>
                            <path fill="currentColor"
                                d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                        </svg>
                    </div>
                </button>
            </div>
        </div>


        <Persona v-if="showPersona" :person="person" :puntosEntrega="puntosEntrega" :products="products" :user="user"
            :status="status" :canGetBox="canGetBox" @clearPerson="clearPerson" />

        <History v-if="showPersona" :history="history" />

        <Dashboard v-if="!showPersona && !showForm" :products="products" :puntosEntrega="puntosEntrega"
            :users="users" />

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
import Toast from '@/Layouts/Components/Toast.vue'
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
        Dashboard,
        Toast,
    },
    data() {
        return {
            showPersona: false,
            showForm: false,
            data: {},
            puntosEntrega: {},
            filter: {
                name: "",
                num_documento: "11111111",
                documento: ""
            },
            person: {},
            products: [],
            user: [],
            status: '',

            /*Mensajeria*/
            toastMessage: "",
            labelType: "info",
            showToast: false,

            /*Loader Search*/
            loadingPerson: false,
        };
    },

    // computed: {
    //     isFormVisible() {
    //         return this.showForm
    //     },
    // },

    setup() {
        const sidebarOpen = ref(false)

        return {
            sidebarOpen,
            store,

        }
    },
    methods: {
        async searchPerson() {
            if (this.filter.documento == "") {
                this.labelType = "danger";
                this.toastMessage = "Debe Ingresar un Documento para realizar la búsqueda"
            } else {
                this.loadingPerson = true;
                try {
                    const response = await axios.get(route('collections.getPerson', this.filter.documento));
                    if (await response.data.status != 404) {
                        this.labelType = response.data.status == 204 ? "info" : "success";
                        this.toastMessage = response.data.message;
                        this.person = await response.data.person;
                        this.history = await response.data.history;
                        this.canGetBox = await response.data.canGetBox;
                        this.status = await response.data.status;
                        this.showPersona = true;
                        this.showForm = false;
                    } else {
                        this.labelType = "danger";
                        this.toastMessage = response.data.message;
                        this.showForm = false;
                    }
                } catch (error) {
                    // this.labelType = "danger";
                    // this.toastMessage = response.data.message;
                    this.labelType = "danger";
                    this.toastMessage = "Se ha producido un error | Por Favor Comuniquese con el Administrador!"
                } finally {
                    this.loadingPerson = false;
                }
            }
        },

        clearPerson() {
            this.person = ''
            this.showPersona = false
            this.showForm = true
        },

        clearMessage() {
            this.toastMessage = "";
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

<style>
.placeholder-italic::placeholder {
    font-style: italic;
}
</style>