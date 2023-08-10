<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
                <div class="">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Datos del Titular</h3>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 sm:col-span-3">
                    <label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
                    <select v-model="form.tipo_documento_id" id="tipo_documento_id" name="tipo_documento_id"
                        autocomplete="tipo_documento_id-name"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" selected>Seleccione un tipo de documento</option>
                        <option v-for="tipoDocumento in tiposDocumento" :key="tipoDocumento.id" :value="tipoDocumento.id">{{
                            tipoDocumento.description
                        }}</option>
                    </select>
                </div>

                <!-- <div class="col-span-12 sm:col-span-3 ">
                    <label for="num_documento" class="block text-sm font-medium text-gray-700">Nro de Documento</label>
                    <input v-model="form.num_documento" @focusout="getPerson()" type="text" name="num_documento"
                        id="num_documento" autocomplete="address-level2"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>
                <div class="col-span-12 sm:col-span-3 ">
                    <label for="num_cuit" class="block text-sm font-medium text-gray-700">CUIT / CUIL</label>
                    <input v-model="form.num_cuit" type="text" name="num_cuit" id="num_cuit" autocomplete="num_cuit-level2"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>

                <div class="col-span-12 sm:col-span-3 ">
                    <label for="fecha_nac" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
                    <Datepicker
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        v-model="form.fecha_nac" :enableTimePicker="false" :monthChangeOnScroll="false" autoApply
                        :format="format">
                    </Datepicker>
                </div> -->
            </div>

            <div class="grid grid-cols-12 gap-6">
                <!-- <div class="col-span-12 sm:col-span-3 ">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input v-model="form.name" type="text" name="name" id="name" autocomplete="name-level2"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>

                <div class="col-span-12 sm:col-span-3 ">
                    <label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
                    <input v-model="form.lastname" type="text" name="lastname" id="lastname" autocomplete="lastname-level2"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>

                <div class="col-span-12 sm:col-span-3 ">
                    <label for="email" class="block text-sm font-medium text-gray-700">Mail</label>
                    <input v-model="form.email" type="text" name="email" id="email" autocomplete="email-level2"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>

                <div class="col-span-12 sm:col-span-3 ">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input v-model="form.phone" type="text" name="phone" id="phone" autocomplete="phone-level2"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>

                <div class="col-span-12 sm:col-span-3">
                    <label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Parentesco</label>
                    <select v-model="form.parentesco_id" id="parentesco_id" name="parentesco_id"
                        autocomplete="parentesco_id-name"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" selected>
                            Seleccione un tipo de documento
                        </option>
                        <option v-for="parentesco in parentescos" :key="parentesco.id" :value="parentesco.id">
                            {{ parentesco.description }}
                        </option>
                    </select>
                </div> -->
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
       
    },
    components: {
        Toast,
        Datepicker
    },
    data() {
        return {
            form: {},
            
            tiposDocumento: ''
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
                if (data.cud && this.showCud) {
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
        },

        /* ***************************
        ** * MANEJO DE FAMILIARES
        */
        addFamiliar() {
            if (this.familiares.find(familiar => familiar.num_documento === this.form_familiar.num_documento)) {
                this.labelType = "danger";
                this.toastMessage = "La persona ya se ha ingresado previamente";
            } else {
                if (this.form_familiar.name && this.form_familiar.lastname && this.form_familiar.num_documento && this.form_familiar.fecha_nac && this.form_familiar.parentesco_id) {
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
        async getData() {

            const get = `${route('juventud.getDataFormMayor')}`

            const response = await fetch(get, { method: "GET" });
            let data = await response.json();
            console.log(data.tiposDocumento)
            this.tiposDocumento = data.tiposDocumento
        },
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
    created() {
        this.getData();
    },

});

</script>