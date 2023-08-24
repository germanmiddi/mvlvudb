<template>
<!-- eslint-disable -->
    <div class="w-full">
        <header class="">
            <div class="flex justify-between max-w-7xl mx-auto py-6 px-10">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center">
                   <ChevronLeftIcon class="w-5 mr-2 rounded-full hover:bg-white" @click="goBack" /> Clientes - Crear Cliente
                </h2>
                <button class="btn-blue" @click="submit">
                    Guardar
                </button>
            </div>
        </header>

        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">                        
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Información</h3>
                                <p class="mt-1 text-sm text-gray-600">Indique los datos del solicitante.</p>
                            </div>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-6 gap-6">

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="company_name"
                                        class="block text-sm font-medium text-gray-700">Nombre / Razón Social
                                        </label>
                                    <input type="text" name="company_name" id="company_name" v-model="form.company_name"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="client_type_id"
                                        class="block text-sm font-medium text-gray-700">Tipo Cliente</label>
                                    <select id="client_type_id" name="client_type_id" v-model="form.client_type_id"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option disabled value="">Seleccione un tipo de Cliente</option>
                                        <option value="1">Agencia</option>
                                        <option value="2">Particular</option>
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="fullname"
                                        class="block text-sm font-medium text-gray-700">Nombre Contacto</label>
                                    <input type="text" name="fullname" id="fullname" v-model="form.fullname"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="text" name="email" id="email" v-model="form.email"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>


                                <div class="col-span-6 sm:col-span-3">
                                    <label for="cellphone"
                                        class="block text-sm font-medium text-gray-700">Whatsapp / Celular</label>
                                    <input type="text" name="cellphone" id="cellphone"
                                        v-model="form.cellphone"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="phone"
                                        class="block text-sm font-medium text-gray-700">Teléfono</label>
                                    <input type="text" name="phone" id="phone" v-model="form.phone"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="cuit"
                                        class="block text-sm font-medium text-gray-700">CUIT</label>
                                    <input type="text" name="cuit" id="cuit" v-model="form.cuit"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>


                                <div class="col-span-6 sm:col-span-3">
                                    <label for="client_type"
                                        class="block text-sm font-medium text-gray-700">Tipo Factura</label>
                                    <select id="client_type" name="client_type" v-model="form.invoice_type"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option disabled value="">Seleccione un tipo de Factura</option>
                                        <option value="1">Factura A</option>
                                        <option value="2">Factura B</option>
                                        <option value="2">Factura X</option>
                                    </select>
                                </div>


                                <div class="col-span-6 sm:col-span-6">
                                    <label for="address"
                                        class="block text-sm font-medium text-gray-700">Direccion</label>
                                    <input type="text" name="address" id="address" v-model="form.address"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>


                                <div class="col-span-6 sm:col-span-6">
                                    <label for="notes"
                                        class="block text-sm font-medium text-gray-700">Notas</label>
                                    <textarea type="text" rows=5 name="notes" id="notes"
                                        v-model="form.notes"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"> </textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
 
        </div>

        <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-3">
                            <div class="px-4 sm:px-0 flex justify-between items-center mb-3">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Lista de Servicios</h3>
                                <input type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 w-96  shadow-sm sm:text-sm border-gray-300 rounded-md"  placeholder="Buscar"/>
                                <button class="btn-blue"> Nuevo Servicio</button>
                                
                            </div>
                        </div>
                    </div>                        
                    <div class="md:col-span-3 mt-5">
                        <table class="w-full whitespace-nowrap">
                            <tr class="text-left font-bold bg-blue-500 text-white">
                                <th class="px-6 py-3 text-left"  >Detalle</th>
                                <th class="px-6 py-3 text-center"  >Tipo</th>
                                <th class="px-6 py-3 text-center">Espera</th>
                                <th class="px-6 py-3 text-center">Equipaje</th>
                                <th class="px-6 py-3 text-center">Guia</th>
                                <th class="px-6 py-3 text-center">Cant Pax</th>
                                <th class="px-6 py-3 text-center">Duración</th>
                                <th class="px-6 py-3 text-center">Precio</th>
                                <th class="px-6 py-3 text-center">Activo</th>
                            </tr>
                            <tr v-for="service in cliente.service_price_lists" :key="service.id"
                                class="hover:bg-gray-100 focus-within:bg-gray-100 text-sm ">
                                <td class="border-t px-6 py-4 text-left">{{ service.detail }}</td>
                                <td class="border-t px-6 py-4 text-left">  {{ service.type }}</td>
                                <td class="border-t px-6 py-4 text-center">{{ service.wait_time }} Hs.</td>
                                <td class="border-t px-6 py-4 text-center">{{ service.baggage }}</td>
                                <td class="border-t px-6 py-4 text-center">{{ service.guide }}</td>
                                <td class="border-t px-6 py-4 text-center">{{ service.passenger_capacity }}</td>
                                <td class="border-t px-6 py-4 text-center">{{ service.duration }}</td>
                                <td class="border-t px-6 py-4 text-right">USD {{ service.price }}</td>
                                <td class="border-t px-6 py-4 text-center">{{ service.active }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
         </div>
    </div> 
</template>


<script>

import { defineComponent } from 'vue'
import Icons from '@/Layouts/Components/Icons.vue'
import Toast from '@/Layouts/Components/Toast.vue'

import {
         ChevronLeftIcon
        } from '@heroicons/vue/24/outline'

import { Inertia } from '@inertiajs/inertia';
export default defineComponent({
    props: {
        cliente: Object,
    },

    components: {
        Icons,
        Toast,
        ChevronLeftIcon,
        Inertia        
    },

    data() {
        return {
            form: {},
            toastMessage: ""
        }
    },

    methods: {
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
        this.form = this.cliente
    }
})
</script>
