<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <!-- <div>
						<h3 class="text-lg leading-6 font-medium text-gray-900"></h3>
					</div> -->
            <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Datos del Beneficiario
                    </h3>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 sm:col-span-3">
                    <label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Tipo de
                        Documento</label>
                    <select v-model="form_beneficiario.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
                        autocomplete="tipo_documento_id-name" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" selected>
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
                        <input type="text" v-model="form_beneficiario.num_documento" @keyup.enter="getPerson()"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        <a @click="getPerson()"
                            class="absolute inset-y-0 right-0 px-4 py-2 bg-green-200 text-white text-xs rounded-r-md hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-600  shadow-sm text-xs font-medium flex items-center  text-green-900 hover:text-white">
                            Verificar
                        </a>
                    </div>
                   <!--  <input v-model="form_beneficiario.num_documento" @focusout="getPerson()" type="text" 
                        name="num_documento" id="num_documento" autocomplete="address-level2"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" 
                        :class="disabledDni ? 'bg-gray-100' : ''" :disabled="disabledDni" /> -->
                </div>

                <div class="col-span-12 sm:col-span-3">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input v-model="form_beneficiario.name" type="text" name="name" id="name" autocomplete="name-level2" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>

                <div class="col-span-12 sm:col-span-3">
                    <label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
                    <input v-model="form_beneficiario.lastname" type="text" name="lastname" id="lastname" 
                        autocomplete="lastname-level2" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>

            </div>

            <div class="grid grid-cols-12 gap-6">
        
                <div class="col-span-12 sm:col-span-3">
                    <label for="fecha_nac" class="block text-sm font-medium text-gray-700">Fecha de
                        Nacimiento</label>
                    <Datepicker
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        v-model="form_beneficiario.fecha_nac" :enableTimePicker="false" :monthChangeOnScroll="false" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                        autoApply :format="format">
                    </Datepicker>
                </div>

                <div class="col-span-12 sm:col-span-3">
                    <label for="email" class="block text-sm font-medium text-gray-700">Mail</label>
                    <input v-model="form_beneficiario.email" type="text" name="email" id="email" autocomplete="email-level2" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>

                <div class="col-span-12 sm:col-span-3" v-show="showCud">
                    <label for="codigo" class="block text-sm font-medium text-gray-700">Nro CUD</label> 
                    <input v-model="form_beneficiario.codigo" type="text" name="codigo" id="codigo" autocomplete="codigo-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" 
                    :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                    />
                </div> 

                <div class="col-span-12 sm:col-span-3" v-show="showCud">
                    <label for="diagnostico" class="block text-sm font-medium text-gray-700">Diagnóstico</label>
                    <input v-model="form_beneficiario.diagnostico" type="text" name="diagnostico" id="diagnostico" autocomplete="diagnostico-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" 
                    :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                    />
                </div>
                
                <div class="col-span-12 sm:col-span-3">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input v-model="form_beneficiario.phone" type="text" name="phone" id="phone" autocomplete="phone-level2" :disabled="input_disable" :class="input_disable ? bg_disable : ''"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>
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
        showCud: {
            type: Boolean,
            default: false
        },
        dni: String
    },
    components: {
        Toast,
        Datepicker
    },
    data() {
        return {
            form_beneficiario: {},
            form_temp: {},
            toastMessage: "",
            labelType: "info",
            message: "",
            showToast: false,
            disabledDni: false,
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

        async getPerson() {
            this.form_temp.num_documento = this.form_beneficiario.num_documento;
            this.form_temp.tipo_documento_id = this.form_beneficiario.tipo_documento_id;

            const get = `${route('persons.getPersonDni', this.form_beneficiario.num_documento)}`
            const response = await fetch(get, { method: 'GET' })
            let data = await response.json()
            if (!data.data.length == 0) {
                this.labelType = "success";
                this.toastMessage = "El DNI indicado se encuentra registrado";

                data = data.data[0].person
                /// Recuperar datos.
                this.form_beneficiario.id = data.id 
                this.form_beneficiario.tipo_documento_id = data.tipo_documento_id
                this.form_beneficiario.fecha_nac = data.fecha_nac
                this.form_beneficiario.fecha_nac = new Date(this.form_beneficiario.fecha_nac + "T00:00:00.000-03:00")
                this.form_beneficiario.name = data.name
                this.form_beneficiario.lastname = data.lastname
                this.form_beneficiario.email = data.contact[0].email
                this.form_beneficiario.phone = data.contact[0].phone
                if(data.cud && this.showCud){
					this.form_beneficiario.codigo = data.cud.codigo
					this.form_beneficiario.diagnostico = data.cud.diagnostico
				}
            } else {
                this.labelType = "info";
                this.toastMessage = "El DNI indicado no se encuentra registrado";
                this.form_beneficiario = {}
                this.form_beneficiario = this.form_temp
                this.form_temp = {}
            }
            this.input_disable = false
        },
    },
    watch: {
        form_beneficiario: {
            deep: true,
            handler(newValue, oldValue) {
            this.$emit('data_beneficiario', newValue)
            }
        },
        dni: {
            handler(newValue, oldValue) {
                this.form_beneficiario.num_documento = newValue;
                this.getPerson()
                this.disabledDni = true
            }
        }
    },
    /* created() {
        console.log(this.dni);
    }, */

});

</script>