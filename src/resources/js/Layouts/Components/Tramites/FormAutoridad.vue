<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">

            <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

            <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Datos de Contactos de autoridades.
                    </h3>
                </div>
                <div class="flex-shrink-0">
                    <div class="flex-shrink-0">
                        <button type="button" @click="addAutoridad()"
                            class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md"
                            :class="showBenef ? 'bg-red-200 text-red-900 hover:bg-red-600 hover:text-white' : 'bg-green-200 text-green-900 hover:bg-green-600 hover:text-white'">Agregar autoridad</button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 sm:col-span-3">
                    <label for="cargo_id" class="block text-sm font-medium text-gray-700">Cargo de Autoridad</label>
                    <select v-model="form_autoridad.cargo_id" id="cargo_id" name="cargo_id"
                        autocomplete="off"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" disabled>
                            Seleccione un tipo de documento
                        </option>
                        <option v-for="cargo in cargos" :key="cargo.id"
									:value="cargo.id">{{
											cargo.description
                        }}</option>
                    </select>
                </div>

                <div class="col-span-12 sm:col-span-3">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input v-model="form_autoridad.name" type="text" 
                        name="name" id="name" autocomplete="off"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" 
                        />
                </div>

                <div class="col-span-12 sm:col-span-3">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Telefono</label>
                    <input v-model="form_autoridad.phone" type="text" name="phone" id="phone" autocomplete="off"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>

            </div>

            <div class="grid grid-cols-12 gap-12">
                <table class="min-w-full divide-y divide-gray-200 w-full col-span-12 ">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
                                Cargo
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">
                                Nombre
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
                                Telefono
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                                Accion
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(cutoridad, index) in autoridades" :key="index">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ cutoridad.cargo_description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ cutoridad.name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ cutoridad.phone }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <button type="button"
                                    class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-red-200 text-red-900 hover:bg-red-600 hover:text-white"
                                    @click="deleteAutoridad(index)">
                                    Borrar
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import Toast from "@/Layouts/Components/Toast.vue"
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

export default ({
    props: {
        tiposDocumento: Object,
        cargos: Object,
    },
    components: {
        Toast,
        Datepicker
    },
    data() {
        return {
            form_autoridad: {},
            form_temp: {},
			autoridades: [],
            /* MENSAJERIA */
			toastMessage: "",
			labelType: "info",
			message: "",
			showToast: false
        };
    },
    setup() {
        const format = (date) => {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            return `${day}/${month}/${year}`;
        }

        return {
            format,
        }
    },
    methods: {
        clearMessage() {
			this.toastMessage = "";
		},

        /* ***************************
		** * MANEJO DE contactos
		*/
		addAutoridad() {
			if (this.autoridades.find(autoridad => autoridad.cargo_id === this.form_autoridad.cargo_id)) {
				this.labelType = "danger";
				this.toastMessage = "El cargo ya se ha ingresado previamente";
			} else {
				if (this.form_autoridad.cargo_id && this.form_autoridad.name  && this.form_autoridad.phone) {
					this.autoridades.push(
						{
							name: this.form_autoridad.name,
                            phone: this.form_autoridad.phone,
							cargo_description: this.cargos.find(cargos => cargos.id === this.form_autoridad.cargo_id).description,
							cargo_id: this.cargos.find(cargos => cargos.id === this.form_autoridad.cargo_id).id,
						}
                    )
                    this.form_autoridad= {}
				} else {
					this.labelType = "danger";
					this.toastMessage = "Debe completar todos los datos";
				}
			}
		},
		deleteAutoridad(index) {
			this.autoridades.splice(index, 1);
		},
		/* 
		** * FIN MANEJO DE contactos
		**********************************
		*/
    },
    watch: {
        autoridades: {
            deep: true,
            handler(newValue, oldValue) {
            console.log(newValue)
            this.$emit('data_autoridades', newValue)
            }
        }
    },
    /* created() {
        console.log(this.dni);
    }, */

});

</script>