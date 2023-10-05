<template>
    <main class="flex-1">
        <!-- Page title & actions -->
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Gestión de Usuarios
                </h1>
            </div>
        <div class="mt-4 flex sm:mt-0 sm:ml-4">
                <!-- <button type="button" class="order-1 ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:order-0 sm:ml-0">Share</button> -->
                <button @click="showNewUserCard = !showNewUserCard"
                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Nuevo Usuario</button>
            </div>
        </div>

        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

        <!-- Card Nuevo usuario -->
        <div v-if="showNewUserCard" class="px-4 mt-6 sm:px-6 lg:px-8">

            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
                        <div class="">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Nuevo Usuarios</h3>
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 sm:col-span-8 ">
                            <label for="newUserName" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input v-model="newUserName" type="text" name="newUserName" id="newUserName"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-3/5  shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <div class="col-span-12 sm:col-span-8 ">
                            <label for="newUserEmail" class="block text-sm font-medium text-gray-700">Email</label>
                            <input v-model="newUserEmail" type="text" name="newUserEmail" id="newUserEmail"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-3/5  shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>
                    </div>


                </div>
                <div class="w-full bg-gray-50 rounded-b  px-4 py-4 border-t border-gray-200">
                    <div class="flex justify-between">
                        <button type="button"
                            class="flex item-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                            @click="createUser()">
                            <svg v-if="newUserLoading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Agregar Usuario </button>
                        <button type="button"
                                class="px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-white text-gray-700 border border-gray-100 hover:bg-gray-200 "
                                @click="showNewUserCard = !showNewUserCard" >
                                Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Card Nuevo Usurio -->

        <!-- Card Ver grupos de usuario -->
        <!-- <div class="px-4 mt-6 sm:px-6 lg:px-8">

            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
                        <div class="">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Nuevo Usuarios</h3>
                        </div>

                    </div>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 sm:col-span-8 ">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <div class="flex items-center">
                                <input v-model="userEmail" type="text" name="email" id="email"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-3/5  shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                <button type="button"
                                    class="items-center ml-6 px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                                    @click="checkUser()">Consultar</button>
                            </div>
                        </div>
                        <div class="col-span-12 shadow-md rounded border-t border-gray-50 ">
                            <div class="w-full bg-white rounded-t px-4 py-4">
                                <div class="pb-4">
                                    <h3 class="text-xl font-bold">Detalles del Usuario</h3>
                                </div>
                                <h4 class="text-lg font-bold pb-4 ml-2">Grupos</h4>
                                <div class="list-groups ml-12 flex w-4/5 flex-wrap gap-3">
                                    <div class="mb-5"><span class="rounded-md uppercase text-sm py-2 px-3 bg-white border b-green-500 text-green-800">Administrador</span></div>
                                    <div class="mb-5"><span class="rounded-md uppercase text-sm py-2 px-3 bg-white border b-green-500 text-green-800">Cbj</span></div>
                                    <div class="mb-5"><span class="rounded-md uppercase text-sm py-2 px-3 bg-white border b-green-500 text-green-800">Discapacidad</span></div>
                                    <div class="mb-5"><span class="rounded-md uppercase text-sm py-2 px-3 bg-white border b-green-500 text-green-800">Entidades</span></div>
                                    <div class="mb-5"><span class="rounded-md uppercase text-sm py-2 px-3 bg-white border b-green-500 text-green-800">Fortalecimiento</span></div>
                                    <div class="mb-5"><span class="rounded-md uppercase text-sm py-2 px-3 bg-white border b-green-500 text-green-800">Genero</span></div>
                                    <div class="mb-5"><span class="rounded-md uppercase text-sm py-2 px-3 bg-white border b-green-500 text-green-800">Habitat</span></div>
                                    <div class="mb-5"><span class="rounded-md uppercase text-sm py-2 px-3 bg-white border b-green-500 text-green-800">Ninez</span></div>
                                    <div class="mb-5"><span class="rounded-md uppercase text-sm py-2 px-3 bg-white border b-green-500 text-green-800">Mayores</span></div>
                                    <div class="mb-5"><span class="rounded-md uppercase text-sm py-2 px-3 bg-white border b-green-500 text-green-800">Operativos</span></div>
                                    <div class="mb-5"><span class="rounded-md uppercase text-sm py-2 px-3 bg-white border b-green-500 text-green-800">Vivienda</span></div>
                                </div>

                            </div>

                            <div class="w-full bg-gray-50 rounded-b  px-4 py-4 border-t border-gray-200">
                                <div class="flex justify-between">
                                    <button type="button"
                                        class="px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                                        @click="checkUser()">Agregar Usuario</button>
                                    <button type="button"
                                        class="px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-white text-gray-700 border border-gray-100 
                                               hover:bg-gray-200 "
                                        >Cerrar</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div> -->
        <!-- Fin Card Ver grupos de usuario -->

        <div class="flex items-center justify-between px-4 mt-6 sm:px-6 lg:px-9">
            <div class="flex items-center">
                <div for="search" class="text-sm mr-2">Buscar:</div>  
                <input type="text" v-model="search"  name="search" id="search" class="h-9 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white ml-2" @click="getUsers">Buscar</button>
            </div>    
            <div class="flex items-center">
                <div class="mr-2 text-sm">Ver:</div>
                <select v-model="length" @change="getUsers" class="h-9 block w-14 py-1 px-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>

        <div class="flex flex-col mt-8 mx-4 sm:mx-6 lg:mx-8">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Grupos
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs text-center font-medium text-gray-500 uppercase tracking-wider">
                                        <span>Acciones</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="user in users.data" :key="user.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ user.name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ user.email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                       <span v-for="r in user.roles" :key="r.id"
                                             class="bg-gray-50 border b-gray-700 mx-2 text-xs px-2 py-1 text-gray-800" >
                                                {{ r }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                       
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <div class="flex justify-between mx-5 my-3 px-2 items-center">
                            <div>
                                <!-- Mostrando: {{ this.tramites.from }} a {{ this.tramites.to }} - Entradas encontradas:
                                {{ this.tramites.total }} -->
                            </div>

                            <div class="flex flex-wrap -mb-1">
                                <template v-for="link in users.links" :key="link.id">
                                    <div v-if="link.url === null"
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded-md"
                                        v-html="link.label"> </div>
                                    <div v-else
                                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-gray-300 rounded-md hover:bg-blue-500 hover:text-white cursor-pointer"
                                        :class="{ 'bg-blue-500': link.active }, { 'text-white': link.active }"
                                        @click="getUsersPaginate(link.url)" v-html="link.label"> </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import { ref } from "vue";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { Inertia } from '@inertiajs/inertia-vue3';

import {
    ChevronRightIcon,
    EllipsisVerticalIcon,
    PencilSquareIcon,
    ArrowsPointingOutIcon
} from "@heroicons/vue/24/solid";
import Toast from "@/Layouts/Components/Toast.vue";

export default {
    props: {
        toast: Object,
    },
    components: {
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        EllipsisVerticalIcon,
        ChevronRightIcon,
        PencilSquareIcon,
        ArrowsPointingOutIcon,
        Toast
    },
    data() {
        return {
            users: "",
            toastMessage: "",
            labelType: "info",
            message: "",
            showToast: false,
            filter: {},
            length: 10,
            customFormat: 'd-M-Y',
            userEmail:"",
            userGroups: [],
            showNewUserCard: false,
            newUserName: "",
            newUserEmail: "",
            newUserLoading: false,

        };
    },
    setup() {
    },
    methods: {

		async createUser(){
            this.newUserLoading = true;

			let rt = route('user.store');

            let data = new FormData();

            data.append('name', this.newUserName);
            data.append('email', this.newUserEmail);

			try {
				
                const response = await axios.post(rt, data);

				if (response.status == 200) {
					this.labelType = "success";
					this.toastMessage = response.data.message;
					console.log(response.data)
                    this.newUserName = "";
                    this.newUserEmail = "";
                    this.showNewUserCard = false;
                    this.newUserLoading = false;
                    this.getUsers();
				} else {
					this.labelType = "danger";
					this.toastMessage = response.data.message;
                    this.newUserLoading = false;
				}
			} catch (error) {
				console.log(error)
			}

		},

        clearMessage() {
            this.toastMessage = "";
        },

        async getUsers() {
            this.users = ''
            let filter = `&length=${this.length}`

            if (this.search) {
                filter += `&search=${this.search}`
            }
            
            const get = `${route('users.list')}?${filter}`

            const response = await fetch(get, { method: "GET" });
            this.users = await response.json();

        },

        async getUsersPaginate(link) {
            var get = `${link}`;
            const response = await fetch(get, { method: 'GET' })

            this.users = await response.json()
            
        },

        fechaFormateada(fecha) {
            const fechaObjeto = new Date(fecha);
            fechaObjeto.setDate(fechaObjeto.getDate() + 1); // Restar un día

            const dia = fechaObjeto.getDate();
            const mes = fechaObjeto.getMonth() + 1; // Los meses en JavaScript son indexados desde 0
            const anio = fechaObjeto.getFullYear();

            // Agregar ceros iniciales si es necesario
            const diaFormateado = dia < 10 ? `0${dia}` : dia;
            const mesFormateado = mes < 10 ? `0${mes}` : mes;

            return `${diaFormateado}-${mesFormateado}-${anio}`;
        },

    },
    mounted() {
        if (this.toast) {
            if (this.toast["status"] == 200) {
                this.labelType = "success";
                this.toastMessage = this.toast["message"];
            } else {
                this.labelType = "danger";
                this.toastMessage = this.toast["message"];
            }
        }
        this.getUsers();
    }  
};
</script>

<style>

</style>
