<template>
    <div class="px-4 mt-10">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="sm:flex sm:justify-between sm:items-center">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Autorizaciones</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles de las autorizaciones Vigentes.</p>
                </div>
                <div v-if="!editData"
                    class="mt-4 mr-2 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                    <Menu as="div" class="ml-3 relative inline-block text-left">
                        <div>
                            <MenuButton
                                class="-my-2 p-2 rounded-full bg-white flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <span class="sr-only">Open options</span>
                                <Bars4Icon class="h-5 w-5" aria-hidden="true" />
                            </MenuButton>
                        </div>

                        <transition enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <MenuItems
                                class="z-50 origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <div class="py-1">
                                    <MenuItem v-slot="{ active }">
                                    <button type="button" @click="editData = true"
                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                        <span>Editar</span>
                                    </button>
                                    </MenuItem>
                                    <!-- <MenuItem v-slot="{ active }" :disabled="true">
                                    <button type="button"
                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                        <span>Nuevo Informe</span>
                                    </button>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                    <a href="#"
                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex justify-between px-4 py-2 text-sm']">
                                        <span>Adjuntar Archivo</span>
                                    </a>
                                    </MenuItem> -->
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>
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

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Apoyo Escolar</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.apoyo_escolar ? 'SI' : (this.form.apoyo_escolar != null ? 'NO' : '-') }}</dd>

                        <Switch v-else v-model="form.apoyo_escolar" @click="form.apoyo_escolar = !form.apoyo_escolar"
                            :class="form.apoyo_escolar ? 'bg-blue-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11  items-center rounded-full">
                            <span :class="form.apoyo_escolar ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                        </Switch>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Actividad por Area Empleo</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.actividad_empleo ? 'SI' : (this.form.actividad_empleo != null ? 'NO' : '-') }}</dd>

                        <Switch v-else v-model="form.actividad_empleo"
                            @click="form.actividad_empleo = !form.actividad_empleo"
                            :class="form.actividad_empleo ? 'bg-blue-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11  items-center rounded-full">
                            <span :class="form.actividad_empleo ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                        </Switch>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Autoriazción Firmada</dt>
                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.autorizacion_firmada ? 'SI' : (this.form.autorizacion_firmada != null ? 'NO' : '-') }}</dd>

                        <Switch v-else v-model="form.autorizacion_firmada"
                            @click="form.autorizacion_firmada = !form.autorizacion_firmada"
                            :class="form.autorizacion_firmada ? 'bg-blue-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11  items-center rounded-full">
                            <span :class="form.autorizacion_firmada ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                        </Switch>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Autorización para Retirarse</dt>

                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.autorizacion_retirarse ? 'SI' : (this.form.autorizacion_retirarse != null ? 'NO' : '-') }}</dd>

                        <Switch v-else v-model="form.actividad_empleo"
                            @click="form.autorizacion_retirarse = !form.autorizacion_retirarse"
                            :class="form.autorizacion_retirarse ? 'bg-blue-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11  items-center rounded-full">
                            <span :class="form.autorizacion_retirarse ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                        </Switch>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Autorización Uso de Imagen</dt>

                        <dd v-if="!editData" class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ this.form.autorizacion_uso_imagen ? 'SI' : (this.form.autorizacion_uso_imagen != null ? 'NO' : '-') }}</dd>

                        <Switch v-else v-model="form.autorizacion_uso_imagen"
                            @click="form.autorizacion_uso_imagen = !form.autorizacion_uso_imagen"
                            :class="form.autorizacion_uso_imagen ? 'bg-blue-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11  items-center rounded-full">
                            <span :class="form.autorizacion_uso_imagen ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                        </Switch>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</template>

<script>
import { PencilSquareIcon, Bars4Icon } from '@heroicons/vue/24/solid'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import store from '@/store.js'

export default {
    props: {
        legajo: Object,
        localidades: Object
    },
    components: {
        PencilSquareIcon, Bars4Icon, Menu, MenuButton, MenuItems, MenuItem
    },

    setup() {
        return {
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

            this.form.apoyo_escolar = this.legajo[0].autorizacion?.apoyo_escolar ?? null
            this.form.actividad_empleo = this.legajo[0].autorizacion?.actividad_empleo ?? null
            this.form.autorizacion_firmada = this.legajo[0].autorizacion?.autorizacion_firmada ?? null
            this.form.autorizacion_retirarse = this.legajo[0].autorizacion?.autorizacion_retirarse ?? null
            this.form.autorizacion_uso_imagen = this.legajo[0].autorizacion?.autorizacion_uso_imagen ?? null

            // Registro datos temporales PreEdicion
            this.form_temp = JSON.parse(JSON.stringify(this.form));
            //this.form_temp = this.form
        },
        resetForm() {
            this.form = JSON.parse(JSON.stringify(this.form_temp));
        },
        async updateLegajo() {
            let data = {}
            // RUTA
            let rt = route("legajoCB.updateLegajoAutorizaciones");

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
        }
    },
    created() {
        this.initForm()
    },
}
</script>
