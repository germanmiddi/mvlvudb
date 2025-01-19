<template>
    <main>
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl">
                <div class="flex justify-between items-center p-4 border-b">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Cargar Entrega</h3>
                    <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">
                        <svg width="20px" height="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>window-close</title><path fill="currentColor" d="M13.46,12L19,17.54V19H17.54L12,13.46L6.46,19H5V17.54L10.54,12L5,6.46V5H6.46L12,10.54L17.54,5H19V6.46L13.46,12Z" /></svg>
                    </button>
                </div>

                <div class="p-4">
                    <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Punto de Entrega -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Punto de entrega</dt>
                            <dd class="mt-1">
                                <select
                                    v-model="form.puntoEntrega"
                                    :class="{'border-red-500': errors.puntoEntrega}"
                                    class="w-full border-gray-300 rounded-md p-2 focus:ring-green-500 focus:border-green-500"
                                >
                                    <option value="">Selecciona un punto</option>
                                    <option
                                        v-for="punto in puntosEntrega"
                                        :key="punto.id"
                                        :value="punto.id"
                                    >
                                        {{ punto.description ?? "" }}
                                    </option>
                                </select>
                                <p v-if="errors.puntoEntrega" class="text-red-500 text-sm mt-1">{{ errors.puntoEntrega }}</p>
                            </dd>
                        </div>

                        <!-- Entrega a realizar por -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Entrega a realizar por</dt>
                            <dd class="mt-1">
                                <select
                                    v-model="form.user"
                                    :class="{'border-red-500': errors.user}"
                                    class="w-full border-gray-300 rounded-md p-2 focus:ring-green-500 focus:border-green-500"
                                >
                                    <option value="">Selecciona un usuario</option>
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }} {{ user.lastname }}
                                    </option>
                                </select>
                                <p v-if="errors.user" class="text-red-500 text-sm mt-1">{{ errors.user }}</p>
                            </dd>
                        </div>

                        <!-- Producto -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Producto</dt>
                            <dd class="mt-1">
                                <select
                                    v-model="form.product"
                                    :class="{'border-red-500': errors.product}"
                                    class="w-full border-gray-300 rounded-md p-2 focus:ring-green-500 focus:border-green-500"
                                >
                                    <option value="">Selecciona un producto</option>
                                    <option
                                        v-for="product in products"
                                        :key="product.id"
                                        :value="product.id"
                                    >
                                        {{ product.name }}
                                    </option>
                                </select>
                                <p v-if="errors.product" class="text-red-500 text-sm mt-1">{{ errors.product }}</p>
                            </dd>
                        </div>

                        <!-- Fecha de Entrega -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Entrega</dt>
                            <!-- <Datepicker
                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500"
                                v-model="form.date"
                                :class="{'border-red-500': errors.date}"
                                multiCalendars
                                :closeOnAutoApply="true"
                                :enableTimePicker="false"
                                :monthChangeOnScroll="false"
                                :format="customFormat"
                            /> -->
                            <Datepicker
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                v-model="form.date"
                                multiCalendars
                                :closeOnAutoApply="true"
                                :enableTimePicker="false"
                                :format="customFormat"
                                
                            ></Datepicker>
                            <p v-if="errors.date" class="text-red-500 text-sm mt-1">{{ errors.date }}</p>
                        </div>

                        <!-- Dirección -->
                        <div class="col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                            <dd class="mt-1">
                                <input
                                    type="text"
                                    v-model="form.address"
                                    :class="{'border-red-500': errors.address}"
                                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500"
                                />
                                <p v-if="errors.address" class="text-red-500 text-sm mt-1">{{ errors.address }}</p>
                            </dd>
                        </div>
                    </dl>

                    <!-- Botón de envío -->
                    <div class="mt-6 flex justify-end">
                        <button
                            @click="submitCollection"
                            class="bg-green-600 text-white px-6 py-2 rounded-md shadow-sm hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:outline-none flex items-center"
                        >
                            <CheckCircleIcon class="h-5 w-5 text-white mr-2" aria-hidden="true" />
                            Guardar Entrega
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import { CheckCircleIcon } from "@heroicons/vue/24/solid";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

export default {
    props: {
        puntosEntrega: Array,
        products: Array,
        users: Array,
    },
    components: {
        CheckCircleIcon,
        Datepicker,
    },
    data() {
        return {
            form: {
                puntoEntrega: "",
                user: "",
                product: "",
                date: null,
                address: "",
            },
            errors: {},
            customFormat: "d-M-Y",
        };
    },
    methods: {
        validateForm() {
            this.errors = {};
            if (!this.form.puntoEntrega) this.errors.puntoEntrega = "El punto de entrega es requerido.";
            if (!this.form.user) this.errors.user = "Debe seleccionar un usuario.";
            if (!this.form.product) this.errors.product = "Debe seleccionar un producto.";
            if (!this.form.date) this.errors.date = "Debe seleccionar una fecha.";
            if (!this.form.address) this.errors.address = "La dirección es requerida.";

            return Object.keys(this.errors).length === 0;
        },
        submitCollection() {
            if (this.validateForm()) {
                this.$emit("submit", this.form);
            }
        },
    },
};
</script>
