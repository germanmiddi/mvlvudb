<template>
    <!-- Vista normal (no edición) -->
    <tr v-if="!editMode" class="hover:bg-gray-50">
        <td class="min-w-[200px]">
            <div class="px-6 py-4 text-sm text-gray-500">
                <div class="font-medium text-gray-900">{{ item.nombre }}</div>
                <div class="text-xs text-gray-400">{{ item.descripcion }}</div>
            </div>
        </td>
        <td class="min-w-[150px]">
            <div class="px-6 py-4 text-sm text-gray-500">
                <div class="text-xs">
                    <span class="font-medium">Inicio:</span> {{ formatDate(item.fecha_inicio) }}
                </div>
                <div v-if="item.fecha_fin" class="text-xs">
                    <span class="font-medium">Fin:</span> {{ formatDate(item.fecha_fin) }}
                </div>
                <div v-else class="text-xs text-gray-400">
                    Sin fecha de fin
                </div>
            </div>
        </td>
        <td class="min-w-[120px]">
            <div class="px-6 py-4 text-sm text-gray-500">
                <div class="flex items-center justify-center">
                    <Switch
                        :model-value="item.estado_entrevistas === 'activo'"
                        @click="$emit('toggle-entrevistas', item.id)"
                        :class="item.estado_entrevistas === 'activo' ? 'bg-green-600' : 'bg-gray-400'"
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                    >
                        <span
                            :class="item.estado_entrevistas === 'activo' ? 'translate-x-6' : 'translate-x-1'"
                            class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform duration-200 ease-in-out"
                        />
                    </Switch>
                </div>
            </div>
        </td>
        <td class="min-w-[120px]">
            <div class="px-6 py-4 text-sm text-gray-500">
                <div class="flex items-center justify-center">
                    <Switch
                        :model-value="item.estado_entregas === 'activo'"
                        @click="$emit('toggle-entregas', item.id)"
                        :class="item.estado_entregas === 'activo' ? 'bg-blue-600' : 'bg-gray-400'"
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        <span
                            :class="item.estado_entregas === 'activo' ? 'translate-x-6' : 'translate-x-1'"
                            class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform duration-200 ease-in-out"
                        />
                    </Switch>
                </div>
            </div>
        </td>
        <td class="min-w-[120px]">
            <div class="px-6 py-4 text-sm text-gray-500">
                <div class="flex flex-wrap gap-2 justify-center">
                    <PencilSquareIcon @click="editMode = true" class="w-5 h-5 hover:text-blue-600 cursor-pointer" />
                    <TrashIcon @click="openModal(item.id)" class="w-5 h-5 hover:text-red-500 cursor-pointer" />
                </div>
            </div>
        </td>
    </tr>

    <!-- Vista de edición (colspan=5) -->
    <tr v-else class="bg-blue-50">
        <td colspan="5" class="px-6 py-4">
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                    <!-- Nombre y Descripción -->
                    <div class="lg:col-span-2">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Padrón</label>
                                <input v-model="edit.nombre"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                       placeholder="Nombre del padrón" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                                <textarea v-model="edit.descripcion" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                          placeholder="Descripción del padrón"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Fechas -->
                    <div class="lg:col-span-2">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio</label>
                                <input v-model="edit.fecha_inicio" type="date"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin</label>
                                <input v-model="edit.fecha_fin" type="date"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" />
                            </div>
                        </div>
                    </div>

                    <!-- Estados y Acciones -->
                    <div class="lg:col-span-1">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado Entrevistas</label>
                                <select v-model="edit.estado_entrevistas"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado Entregas</label>
                                <select v-model="edit.estado_entregas"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-2 pt-4">
                                <button @click="editItem"
                                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                    Guardar
                                </button>
                                <button @click="editMode = false"
                                        class="w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>

    <DeleteModal v-if="showModal" :id="selectedItemId" :show="showModal"
        :title="'¿Estás seguro de que deseas eliminar este padrón?'" @responseDeleted="destroyItem"
        @viewDeleted="closeModal" />
</template>

<script>
import {
    TrashIcon,
    PencilSquareIcon
} from '@heroicons/vue/24/outline'
import { Switch } from '@headlessui/vue'
import DeleteModal from '@/Layouts/Components/DeleteModal.vue';

export default {
    props: {
        item: {
            type: Object,
            required: true
        }
    },
    components: {
        TrashIcon,
        PencilSquareIcon,
        Switch,
        DeleteModal,
    },
    data() {
        return {
            edit: {},
            editMode: false,
            showModal: false,
            selectedItemId: null,
        }
    },
    methods: {
        editItem() {
            this.$emit('edit-item', this.edit)
            this.editMode = false
        },
        destroyItem(id) {
            this.showModal = false;
            this.$emit('destroy-item', id);
        },
        openModal(id) {
            this.selectedItemId = id;
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
        formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-AR');
        },
        formatDateForInput(dateString) {
            if (!dateString) return '';
            // Si ya está en formato YYYY-MM-DD, devolverlo tal como está
            if (dateString.match(/^\d{4}-\d{2}-\d{2}$/)) {
                return dateString;
            }
            // Si está en formato DD/MM/YYYY o similar, convertir a YYYY-MM-DD
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return '';
            return date.toISOString().split('T')[0];
        }
    },
    created() {
        this.edit = {
            id: this.item.id,
            nombre: this.item.nombre,
            descripcion: this.item.descripcion,
            estado_entrevistas: this.item.estado_entrevistas,
            estado_entregas: this.item.estado_entregas,
            fecha_inicio: this.formatDateForInput(this.item.fecha_inicio),
            fecha_fin: this.formatDateForInput(this.item.fecha_fin)
        }
    }
}
</script>
