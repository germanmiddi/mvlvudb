<template>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="sm:flex sm:justify-between sm:items-center">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Datos del Titular</h3>
            </div>
            <div v-if="!editData"
                class="mt-4 mr-2 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                <a @click="editData = true" title="Editar"
                    :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-2 py-2 text-sm']">
                    <PencilSquareIcon class="h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                </a>
            </div>
            <div v-else
                class="mt-4 mr-4 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                <button type="submit" @click="editData = false, updateLegajo()"
                    class="ml-1 inline-flex items-center px-4 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                <button type="submit" @click="editData = false, resetForm()"
                    class="ml-1 inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancelar</button>
            </div>
        </div>

        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">

                <div class="pl-4 py-4 grid grid-cols-2 gap-4">
                    <dt class="text-sm font-medium text-gray-500 col-span-1">Apellido:</dt>
                    <dd v-if="!editData" class="mt-1 mr-4 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                        {{ this.form.lastname }}</dd>

                    <dd v-else class="mt-1 mr-4 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                        <input v-model="form.lastname" type="text" name="name" id="name" autocomplete="name-level2"
                            class="sm:col-span-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                    </dd>
                </div>

                <div class="pl-4 py-4 grid grid-cols-2 gap-4">
                    <dt class="text-sm font-medium text-gray-500 col-span-1">Nombre:</dt>
                    <dd v-if="!editData" class="mt-1 mr-4 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                        {{ this.form.name }}</dd>

                    <dd v-else class="mt-1 mr-4 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                        <input v-model="form.name" type="text" name="name" id="name" autocomplete="name-level2"
                            class="sm:col-span-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                    </dd>
                </div>

                <div class="pl-4 py-4 grid grid-cols-2 gap-4">
                    <dt class="text-sm font-medium text-gray-500 col-span-1">Documento:</dt>
                    <dd v-if="!editTitular" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                        {{ legajo[0].person.num_documento }}</dd>
                    <dd v-else class="mt-1 mr-4 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                        <input v-model="legajo[0].person.num_documento" type="text" name="name" id="name"
                            autocomplete="name-level2"
                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                    </dd>
                </div>

                <div class="pl-4 py-4 grid grid-cols-2 gap-4">
                    <dt class="text-sm font-medium text-gray-500 col-span-1">Fecha de Nac:</dt>
                    <dd v-if="!editData" class="mt-1 mr-4 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                        {{ store.dateTimeFormateada(this.form.fecha_nac) }}</dd>
                    <dd v-else class="mt-1 mr-4 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                        <Datepicker
                            class="sm:col-span-2 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            v-model="this.form.fecha_nac" :disabled="input_disable"
                            :class="input_disable ? bg_disable : ''" :enableTimePicker="false"
                            :monthChangeOnScroll="false" autoApply :format="format">
                        </Datepicker>
                    </dd>
                </div>

                <div class="pl-4 py-4 grid grid-cols-2 gap-4">
                    <dt class="text-sm font-medium text-gray-500 col-span-1">Edad:</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">{{ this.form.age
                        ?? '-' }}</dd>
                </div>

                <div class="pl-4 py-4 grid grid-cols-2 gap-4">
                    <dt class="text-sm font-medium text-gray-500 col-span-1">Genero:</dt>
                    <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">{{
                        this.form.genero ?? '-' }}</dd>
                    <dd v-else class="mt-1 mr-4 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                        <select v-model="this.form.genero" id="genero" name="genero" autocomplete="off"
                            :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <option value="" disabled>
                                Seleccione un Genero
                            </option>
                            <option value="F">Femenino</option>
                            <option value="M">Masculino</option>
                        </select>
                    </dd>
                </div>

                <div class="pl-4 py-4 grid grid-cols-2 gap-4">
                    <dt class="text-sm font-medium text-gray-500 col-span-1">Teléfono</dt>
                    <dd v-if="!editData" class="mt-1 mr-4 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                        {{ this.form.phone }}</dd>

                    <dd v-else class="mt-1 mr-4 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                        <input v-model="form.phone" type="text" name="phone" id="phone" autocomplete="name-level2"
                            class="sm:col-span-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                    </dd>
                </div>

                <div class="pl-4 py-4 grid grid-cols-2 gap-4">
                    <dt class="text-sm font-medium text-gray-500 col-span-1">Localidad</dt>
                    <dd v-if="!editData" class="mt-1 mr-4 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                        {{ this.form.localidad }}</dd>

                    <dd v-else class="mt-1 mr-4 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                        <select v-model="form.localidad_id" id="localidad_id" name="localidad_id" autocomplete="off"
                            :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                            class="sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione una localidad
                            </option>
                            <option v-for="item in localidades" :key="item.id" :value="item.id">
                                {{ item.description }}
                            </option>
                        </select>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</template>

<script>
import { PencilSquareIcon } from '@heroicons/vue/24/solid'
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import store from '@/store.js'

export default {
    props: {
        legajo: Object,
        localidades: Object
    },
    components: {
        PencilSquareIcon, Datepicker
    },

    setup() {
        const format = (date) => {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            return `${day}/${month}/${year}`;
        };

        return {
            format,
            store
        }
    },
    data() {
        return {
            editData: false,
            form: {},
            form_temp: {}
        }
    },
    methods: {
        initForm() {
            this.form = {}
            this.form.id = this.legajo[0].id

            this.form.name = this.legajo[0].person.name ?? null
            this.form.lastname = this.legajo[0].person.lastname ?? null
            this.form.fecha_nac = this.legajo[0].person.fecha_nac ?? null
            this.form.fecha_nac = new Date(this.form.fecha_nac + "T00:00:00.000-03:00")
            this.form.phone = this.legajo[0].person.contact[0]?.phone ?? null
            this.form.genero = this.legajo[0].person.genero ?? null
            this.form.age = this.legajo[0].person.age ?? null

            this.form.localidad = this.legajo[0].person?.address[0]?.localidad?.description ?? null
            this.form.localidad_id = this.legajo[0].person?.address[0]?.localidad?.id ?? null
            // Genero
            // Localidad

            // Registro datos temporales PreEdicion
            this.form_temp = JSON.parse(JSON.stringify(this.form));
        },
        resetForm() {
            this.form = JSON.parse(JSON.stringify(this.form_temp));
        },
        async updateLegajo() {
            let data = {}
            // RUTA
            let rt = route("legajoCB.updateLegajoTitular");
            // Actualiza el Form
            this.form.localidad = this.localidades.find(localidad => localidad.id === this.form.localidad_id)?.description || null;

            try {
                const response = await axios.put(rt, this.form);
                if (response.status == 200) {
                    data.message = response.data.message
                    data.labelType = 'success'
                    this.editData = false
                    this.form_temp = this.form
                } else {
                    data.message = response.data.message
                    data.labelType = 'info'
                    this.form = this.form_temp
                }
            } catch (error) {
                data.message = "Se ha producido un error | Por Favor Comuniquese con el Administrador!"
                data.labelType = 'danger'
                this.form = this.form_temp
            }
            this.$emit('message', data)
        },
		calculateAge() {
			if (this.form.fecha_nac) {
				const today = new Date();
				const birthDate = new Date(this.form.fecha_nac);
				let age = today.getFullYear() - birthDate.getFullYear();
				const m = today.getMonth() - birthDate.getMonth();
				if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
				    age--;
				}
				this.form.age = age;
			} else {
				this.form.age = null;
			}
		}
    },
	watch: {
		'form.fecha_nac'(newValue) {
			this.calculateAge();
		}
	},
    created() {
        this.initForm()
    },
}
</script>
