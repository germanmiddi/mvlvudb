<template>
    <main>
        <div
            v-if="person.collections.length > 0"
            class="mt-10 bg-white shadow overflow-hidden sm:rounded-lg"
        >
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Ver Entrega
                </h3>
            </div>
            <div class="">
                <dl>
                    <div
                        class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Punto de entrega
                        </dt>

                        <dd
                            v-if="puntosEntrega.length == 0"
                            class="mt-1 text-base text-gray-900 sm:mt-0 sm:col-span-2"
                        >
                            No hay puntos de entrega disponibles
                        </dd>
                        <dd
                            v-else
                            class="mt-1 text-base text-gray-900 sm:mt-0 sm:col-span-2"
                        >
                            <select
                                v-model="form.puntoEntrega"
                                class="w-full border-gray-300 rounded-md"
                            >
                                <option
                                    v-for="punto in puntosEntrega"
                                    :key="punto.id"
                                    :value="punto.id"
                                >
                                    {{ punto.description ?? "" }}
                                </option>
                            </select>
                        </dd>
                    </div>
                    <div
                        class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Entregado por
                        </dt>
                        <dd
                            class="mt-1 text-base text-gray-900 sm:mt-0 sm:col-span-2"
                        >
                            {{ user.name }}
                        </dd>
                    </div>
                    <div
                        class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Producto
                        </dt>
                        <dd
                            class="mt-1 text-base text-gray-900 sm:mt-0 sm:col-span-2 capitalize"
                        >
                            <select
                                v-model="form.product"
                                class="w-full border-gray-300 rounded-md"
                            >
                                <option
                                    v-for="product in products"
                                    :key="product.id"
                                    :value="product.id"
                                >
                                    {{ product.name }}
                                </option>
                            </select>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-10 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class=" flex items-center justify-between px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Detalles de la Entrega
                </h3>

                <div class="mt-4 flex sm:mt-0">
                    <a class="order-0 inline-flex items-center px-4 py-2 
                          border border-transparent shadow-sm text-sm font-medium rounded-md 
                          text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1">
                    Editar</a>
                </div>
            </div>

            <div class="">
                <dl>
                    <div
                        class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Punto de entrega
                        </dt>

                        <dd
                            v-if="puntosEntrega.length == 0"
                            class="mt-1 text-base text-gray-900 sm:mt-0 sm:col-span-2"
                        >
                            No hay puntos de entrega disponibles
                        </dd>
                        <dd
                            v-else
                            class="mt-1 text-base text-gray-900 sm:mt-0 sm:col-span-2"
                        >
                            <select
                                v-model="form.puntoEntrega"
                                class="w-full border-gray-300 rounded-md"
                            >
                                <option
                                    v-for="punto in puntosEntrega"
                                    :key="punto.id"
                                    :value="punto.id"
                                >
                                    {{ punto.description ?? "" }}
                                </option>
                            </select>
                        </dd>
                    </div>
                    <div
                        class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Entrega a realizar por
                        </dt>
                        <dd
                            v-if="users.length == 0"
                            class="mt-1 text-base text-gray-900 sm:mt-0 sm:col-span-2"
                        >
                            No hay personal de entrega disponibles
                        </dd>
                        <dd
                            v-else
                            class="mt-1 text-base text-gray-900 sm:mt-0 sm:col-span-2"
                        >
                            <select
                                v-model="form.user"
                                class="w-full border-gray-300 rounded-md"
                            >
                                <option
                                    v-for="user in users"
                                    :key="user.id"
                                    :value="user.id"
                                >
                                    {{ user.name }} {{ user.lastname }}
                                </option>
                            </select>
                        </dd>
                    </div>
                    <div
                        class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Producto
                        </dt>
                        <dd
                            class="mt-1 text-base text-gray-900 sm:mt-0 sm:col-span-2 capitalize"
                        >
                            <select
                                v-model="form.product"
                                class="w-full border-gray-300 rounded-md"
                            >
                                <option
                                    v-for="product in products"
                                    :key="product.id"
                                    :value="product.id"
                                >
                                    {{ product.name }}
                                </option>
                            </select>
                        </dd>
                    </div>

                    <div
                        class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Fecha de Entrega
                        </dt>
                        <dd
                            class="mt-1 text-base text-gray-900 sm:mt-0 sm:col-span-2 capitalize"
                        >
                            <Datepicker
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                v-model="form.date"
                                multiCalendars
                                :closeOnAutoApply="true"
                                :enableTimePicker="false"
                                :format="customFormat"
                            ></Datepicker>
                        </dd>
                    </div>

                    <div
                        class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Dirección
                        </dt>
                        <!-- <dd v-if="person.address.statusAddress" -->
                         <!-- person.address.textAddress -->
                        <dd
                            class="mt-1 text-base text-gray-900 sm:mt-0 sm:col-span-2 capitalize"
                        >
                            <input
                                type="text"
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-900"
                                v-model="form.address"
                            />
                        </dd>
                    </div>
                </dl>
                <!-- <div class="mt-6 flex justify-end">
                    <button
                        @click="submitCollection"
                        class="bg-green-600 text-white px-6 py-2 rounded-md shadow-sm hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:outline-none flex items-center"
                    >
                        <CheckCircleIcon
                            class="h-5 w-5 text-white mr-2"
                            aria-hidden="true"
                        />
                        Guardar Entrega
                    </button>
                </div> -->
            </div>

            <!-- <div class="mt-6">
                <button
                    @click="submitCollection"
                    class="bg-green-600 text-white px-4 rounded-md py-4 flex items-center w-full justify-center"
                >
                    <CheckCircleIcon
                        class="h-5 w-5 text-white mr-3"
                        aria-hidden="true"
                    />
                    Entregar
                </button>
            </div> -->
        </div>

        

        <div class="mt-6 w-full">
            <button @click="openFormEntregaModal" class="w-full py-2 rounded-md border border-green-600 bg-white text-lg text-green-900 hover:bg-green-700 hover:text-white duration-200">+ Añadir Entrega</button>
        </div>

        <EntregaFormModal 
            v-if="entregaFormModal" 
            :puntosEntrega="puntosEntrega"
            :products="products"
            :users="users"
            @close="closeFormEntregaModal"
            @submit="submitCollection"
        />
    </main>
</template>

<script>
import { CheckCircleIcon } from "@heroicons/vue/24/solid";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import EntregaFormModal from "./Components/EntregaFormModal.vue";

export default {
    props: {
        person: Array,
        puntosEntrega: Array,
        products: Array,
        users: Array,
    },
    components: {
        CheckCircleIcon,
        Datepicker,
        EntregaFormModal,
    },

    data() {
        return {
            form: {
                // puntoEntrega: this.puntosEntrega[0].id,
                // product: this.products[0].id,
                // address: this.person.address.textAddress,
                address: "calle 377 entre 45 y 46",
            },
            customFormat: "d-M-Y",

            entregaFormModal: false,
        };
    },

    methods: {
        async submitCollection() {
            //format the address, if any value is null, it will not be included
            let address = this.person.address[0].calle
                ? `calle:${this.person.address[0].calle} `
                : "";
            address += this.person.address[0].number
                ? `num:${this.person.address[0].number} `
                : "";
            address += this.person.address[0].piso
                ? `piso:${this.person.address[0].piso} `
                : "";
            address += this.person.address[0].dpto
                ? `dpto:${this.person.address[0].dpto} `
                : "";
            address += this.person.address[0].localidad_id
                ? `localidad:${this.person.address[0].localidad_id} `
                : "";
            address += this.person.address[0].barrio_id
                ? `barrio:${this.person.address[0].barrio_id} `
                : "";

            address = address.replace(/ /g, "");

            const response = await axios.post(
                route("collections.storeCollection"),
                {
                    person_id: this.person.id,
                    punto_entrega_id: this.form.puntoEntrega,
                    product_id: this.form.product,
                    address: address,
                }
            );

            if (response.status == 200) {
                alert("Entrega realizada correctamente");
                this.$emit("clearPerson");
            }
        },
        clearPerson() {
            this.$emit("clearPerson");
        },

        openFormEntregaModal(){
            this.entregaFormModal = true;
        },

        closeFormEntregaModal() {
            this.entregaFormModal = false; // Cerrar modal
        },
    },
};
</script>
