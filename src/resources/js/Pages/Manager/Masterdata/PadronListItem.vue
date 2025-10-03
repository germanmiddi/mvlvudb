<template>
    <tr class="hover:bg-gray-50">
        <td>
            <div v-if="!editMode" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <div class="font-medium text-gray-900">{{ item.nombre }}</div>
                <div class="text-xs text-gray-400">{{ item.descripcion }}</div>
            </div>
            <div v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <input v-model="edit.nombre" class="border rounded py-1 pl-2 w-full mb-2" placeholder="Nombre del padrón" />
                <textarea v-model="edit.descripcion" rows="2" class="border rounded py-1 pl-2 w-full text-xs" placeholder="Descripción"></textarea>
            </div>
        </td>
        <td>
            <div v-if="!editMode" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
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
            <div v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-xs text-gray-600">Inicio:</label>
                        <input v-model="edit.fecha_inicio" type="date" class="border rounded py-1 pl-2 w-full text-xs" />
                    </div>
                    <div>
                        <label class="text-xs text-gray-600">Fin:</label>
                        <input v-model="edit.fecha_fin" type="date" class="border rounded py-1 pl-2 w-full text-xs" />
                    </div>
                </div>
            </div>
        </td>
        <td>
            <div v-if="!editMode" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <span v-if="item.activo" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Activo
                </span>
                <span v-else class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    Inactivo
                </span>
            </div>
            <div v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <label class="flex items-center">
                    <input v-model="edit.activo" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                    <span class="ml-2 text-xs text-gray-700">Activo</span>
                </label>
            </div>
        </td>
        <td>
            <div v-if="!editMode" class="flex justify-between w-1/2 mx-auto">
                <div>
                    <EyeIcon v-if="item.activo == true" @click="hideItem(item.id)"
                        class="w-5 h-5 text-green-400 hover:text-green-600 cursor-pointer" />
                    <EyeSlashIcon v-else @click="hideItem(item.id)"
                        class="w-5 h-5 text-yellow-700 hover:text-yellow-900 cursor-pointer" />
                </div>
                <PencilSquareIcon @click="editMode = true" class="w-5 h-5 hover:text-blue-600 cursor-pointer" />
                <TrashIcon @click="openModal(item.id)" class="w-5 h-5 hover:text-red-500 cursor-pointer" />
            </div>
            <div v-else class="flex justify-between w-1/2 mx-auto">
                <button @click="editItem" class="bg-blue-400 text-white px-2 py-1 rounded text-sm mr-3">
                    Guardar</button>
                <button @click="editMode = false" class="bg-red-400 text-white px-2 py-1 rounded text-sm">
                    Cancelar</button>
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
    PencilSquareIcon,
    EyeIcon,
    EyeSlashIcon
} from '@heroicons/vue/24/outline'
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
        EyeIcon,
        EyeSlashIcon,
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
        hideItem(id) {
            this.$emit('hide-item', id)
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
        }
    },
    created() {
        this.edit = {
            id: this.item.id,
            nombre: this.item.nombre,
            descripcion: this.item.descripcion,
            activo: this.item.activo,
            fecha_inicio: this.item.fecha_inicio,
            fecha_fin: this.item.fecha_fin
        }
    }
}
</script>
