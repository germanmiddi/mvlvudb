<template>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-4">
        <div class="sm:flex sm:justify-between sm:items-center">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Asignado</h3>
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
                <button type="submit" @click="this.showConfirmed=true"
                    class="ml-1 inline-flex items-center px-4 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Asignar</button>
                <button type="submit" @click="editData = false, resetForm()"
                    class="ml-1 inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancelar</button>
            </div>
            <!-- <div class="mt-4 pr-4 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                <button type="submit"
                    class="inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Reasignar</button>
            </div> -->
            
        </div>

        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">

                <div class="pl-4 py-4 grid grid-cols-2 gap-4">
                    <dt class="text-sm font-medium text-gray-500 col-span-1">Usuario</dt>
                    <dd v-if="!editData" class="mt-1 mr-4 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                        {{ this.form.assigned ?? '-' }}</dd>

                    <dd v-else class="mt-1 mr-4 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                        <select v-model="form.assigned_id" id="assigned_id" name="assigned_id" autocomplete="off"
                            :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                            class="uppercase sm:col-span-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione una Profesional
                            </option>
                            <option v-for="item in users" :key="item.id" :value="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <ConfirmModal :show="showConfirmed" :id="this.form.assigned_id"
        :title="`¿Está seguro que desea asignar el legajo?`" @viewConfirmed="fnShowConfirmed"
        @responseConfirmed="fnConfirmed" />
</template>

<script>
import { PencilSquareIcon } from '@heroicons/vue/24/solid'
import ConfirmModal from '@/Layouts/Components/ConfirmModal.vue';
import store from '@/store.js'

export default {
    props: {
        legajo: Object,
        users: Object
    },
    components: {
        PencilSquareIcon,
        ConfirmModal
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
            form_temp: {},
            showConfirmed: false
        }
    },
    methods: {
        initForm() {
            this.form = {}
            this.form.id = this.legajo[0].id

            this.form.assigned = this.legajo[0].assigned?.name ?? null
            this.form.assigned_id = this.legajo[0].assigned?.id ?? null

            // Registro datos temporales PreEdicion
            this.form_temp = JSON.parse(JSON.stringify(this.form));
        },
        resetForm() {
            this.form = JSON.parse(JSON.stringify(this.form_temp));
        },
        async fnConfirmed() {
            let data = {}
            // RUTA
            let rt = route("legajoCB.assignedResponsable");

            // Actualiza el Form
            this.form.assigned = this.users.find(user => user.id === this.form.assigned_id)?.name || null;

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
            this.showConfirmed = false
            this.$emit('message', data)
        },
        fnShowConfirmed() {
            this.showConfirmed = false
        },
    },
    created() {
        this.initForm()
    },
}
</script>
