<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">

            <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

            <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Datos del Familiar
                    </h3>
                </div>
                <div class="flex-shrink-0">
                    <div class="flex-shrink-0">
                        <button type="button" @click="addFamiliar()"
                            class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md"
                            :class="showBenef ? 'bg-red-200 text-red-900 hover:bg-red-600 hover:text-white' : 'bg-green-200 text-green-900 hover:bg-green-600 hover:text-white'">Agregar Familiar</button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 sm:col-span-3">
                    <label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Tipo de
                        Documento</label>
                    <select v-model="form_familiar.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
                        autocomplete="tipo_documento_id-name"  :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" disabled>
                            Seleccione un tipo de documento
                        </option>
                        <option v-for="tipoDocumento in tiposDocumento" :key="tipoDocumento.id"
									:value="tipoDocumento.id">{{
											tipoDocumento.description
                        }}</option>
                    </select>
                </div>

                <div class="col-span-12 sm:col-span-3">
                    <label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de
                        Documento</label>
                        <div class="relative">
                        <input type="text" v-model="form_familiar.num_documento" @keyup.enter="getPerson()"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        <a @click="getPerson()"
                            class="absolute inset-y-0 right-0 px-4 py-2 bg-green-200 text-white text-xs rounded-r-md hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-600  shadow-sm text-xs font-medium flex items-center  text-green-900 hover:text-white">
                            Verificar
                        </a>
                    </div>
                </div>

                <div class="col-span-12 sm:col-span-3">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input v-model="form_familiar.name" type="text" name="name" id="name" autocomplete="name-level2" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>

                <div class="col-span-12 sm:col-span-3">
                    <label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
                    <input v-model="form_familiar.lastname" type="text" name="lastname" id="lastname"
                        autocomplete="lastname-level2" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>

            </div>

            <div class="grid grid-cols-12 gap-6">
        
                <div class="col-span-12 sm:col-span-3">
                    <label for="fecha_nac" class="block text-sm font-medium text-gray-700">Fecha de
                        Nacimiento</label>
                    <Datepicker
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                        v-model="form_familiar.fecha_nac" :enableTimePicker="false" :monthChangeOnScroll="false"
                        autoApply :format="format">
                    </Datepicker>
                </div>
                <div class="col-span-12 sm:col-span-3">
                    <label for="tipo_documento_id"
                        class="block text-sm font-medium text-gray-700">{{ this.txtFamiliar }}</label>
                    <select v-model="form_familiar.parentesco_id" id="parentesco_id" name="parentesco_id"
                        autocomplete="parentesco_id-name" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" disabled>
                            Seleccione un tipo un parentesco
                        </option>
                        <option v-for="parentesco in parentescos" :key="parentesco.id" :value="parentesco.id">
                            {{ parentesco.description }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-12 gap-12">
                <table class="min-w-full divide-y divide-gray-200 w-full col-span-12 ">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
                                DNI
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">
                                Nombre
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
                                Apellido
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
                                Parentesco
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                                Accion
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(familiar, index) in familiares" :key="index">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ familiar.num_documento }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ familiar.name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ familiar.lastname }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ familiar.parentesco_description }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <button type="button"
                                    class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-red-200 text-red-900 hover:bg-red-600 hover:text-white"
                                    @click="deleteFamiliar(index)">
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
        parentescos: Object,
        txtFamiliar: {
            type: String,
            default: 'Parentesco'
        }
    },
    components: {
        Toast,
        Datepicker
    },
    data() {
        return {
            form_familiar: {},
            form_temp: {},
			familiares: [],
            /* MENSAJERIA */
			toastMessage: "",
			labelType: "info",
			message: "",
			showToast: false,
            bg_disable: 'bg-gray-100',
			input_disable: true
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

        async getPerson() {
            this.form_temp.num_documento = this.form_familiar.num_documento;
            this.form_temp.tipo_documento_id = this.form_familiar.tipo_documento_id;

            const get = `${route('persons.getPersonDni', this.form_familiar.num_documento)}`
            const response = await fetch(get, { method: 'GET' })
            let data = await response.json()
            if (!data.data.length == 0) {
                data = data.data[0].person
                /// Recuperar datos.
                this.form_familiar.id = data.id 
                this.form_familiar.tipo_documento_id = data.tipo_documento_id
                this.form_familiar.fecha_nac = data.fecha_nac
                this.form_familiar.fecha_nac = new Date(this.form_familiar.fecha_nac + "T00:00:00.000-03:00")
                this.form_familiar.name = data.name
                this.form_familiar.lastname = data.lastname
                this.form_familiar.email = data.contact[0].email
                this.form_familiar.phone = data.contact[0].phone
                if(data.cud && this.showCud){
					this.form_familiar.codigo = data.cud.codigo
					this.form_familiar.diagnostico = data.cud.diagnostico
				}
            } else {
                this.labelType = "info";
                this.toastMessage = "El DNI indicado no se encuentra registrado";
                this.form_familiar = {}
                this.form_familiar = this.form_temp
                this.form_temp = {}
            }
            this.input_disable = false
        },
        
        /* ***************************
		** * MANEJO DE FAMILIARES
		*/
		addFamiliar() {
			if (this.familiares.find(familiar => familiar.num_documento === this.form_familiar.num_documento)) {
				this.labelType = "danger";
				this.toastMessage = "La persona ya se ha ingresado previamente";
			} else {
				if (this.form_familiar.name && this.form_familiar.lastname  && this.form_familiar.num_documento && this.form_familiar.fecha_nac && this.form_familiar.parentesco_id) {
					this.familiares.push(
						{
							id: this.form_familiar.id,
							name: this.form_familiar.name,
							lastname: this.form_familiar.lastname,
							num_documento: this.form_familiar.num_documento,
                            tipo_documento_id: this.form_familiar.tipo_documento_id,
							fecha_nac: new Date(this.form_familiar.fecha_nac).toISOString(),
							parentesco_description: this.parentescos.find(parentesco => parentesco.id === this.form_familiar.parentesco_id).description,
							parentesco_id: this.parentescos.find(parentesco => parentesco.id === this.form_familiar.parentesco_id).id,
						}
                    )
                    this.form_familiar = {}
				} else {
					this.labelType = "danger";
					this.toastMessage = "Debe completar todos los datos";
				}
			}
		},
		deleteFamiliar(index) {
			this.familiares.splice(index, 1);
		},
		/* 
		** * FIN MANEJO DE FAMILIARES
		**********************************
		*/
    },
    watch: {
        familiares: {
            deep: true,
            handler(newValue, oldValue) {
            console.log(newValue)
            this.$emit('data_familiares', newValue)
            }
        },
        dni: {
            handler(newValue, oldValue) {
                this.form_familiar.num_documento = newValue;
                this.getPerson()
            }
        }
    },
    /* created() {
        console.log(this.dni);
    }, */

});

</script>