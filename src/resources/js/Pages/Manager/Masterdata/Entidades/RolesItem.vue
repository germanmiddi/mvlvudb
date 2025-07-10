<script setup>
import { ref, onMounted } from 'vue'
import {
    TrashIcon,
    PencilSquareIcon,
    EyeIcon,
    EyeSlashIcon
} from '@heroicons/vue/24/outline'
import DeleteModal from '@/Layouts/Components/DeleteModal.vue'

const props = defineProps({
    item: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['edit-item', 'hide-item', 'destroy-item'])

const editName = ref("")
const editDescription = ref("")
const editMode = ref(false)
const showModal = ref(false)
const selectedItemId = ref(null)

onMounted(() => {
    editName.value = props.item.name
    editDescription.value = props.item.description
})

const editItem = () => {
    const updatedItem = {
        ...props.item,
        name: editName.value,
        description: editDescription.value
    }
    emit('edit-item', updatedItem)
    editMode.value = false
}

const hideItem = (id) => {
    emit('hide-item', id)
}

const destroyItem = (id) => {
    showModal.value = false
    emit('destroy-item', id)
}

const openModal = (id) => {
    selectedItemId.value = id
    showModal.value = true
}

const closeModal = () => {
    showModal.value = false
    selectedItemId.value = null
}

const cancelEdit = () => {
    editName.value = props.item.name
    editDescription.value = props.item.description
    editMode.value = false
}
</script>

<template>
    <tr class="hover:bg-gray-50">
        <!-- Columna Name -->
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            <div v-if="!editMode">
                {{ item.name }}
            </div>
            <div v-else>
                <input v-model="editName"
                       placeholder="Nombre del rol"
                       class="border rounded py-1 pl-2 w-full" />
            </div>
        </td>

        <!-- Columna Description -->
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            <div v-if="!editMode">
                {{ item.description }}
            </div>
            <div v-else>
                <input v-model="editDescription"
                       placeholder="Descripción del rol"
                       class="border rounded py-1 pl-2 w-full" />
            </div>
        </td>

        <!-- Columna Acciones -->
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            <div v-if="!editMode" class="flex justify-center space-x-2">
                <PencilSquareIcon @click="editMode = true"
                                  class="w-5 h-5 hover:text-blue-600 cursor-pointer" />
                <TrashIcon @click="openModal(item.id)"
                           class="w-5 h-5 hover:text-red-500 cursor-pointer" />
            </div>
            <div v-else class="flex justify-center space-x-2">
                <button @click="editItem"
                        class="bg-blue-400 text-white px-2 py-1 rounded text-sm hover:bg-blue-500">
                    Guardar
                </button>
                <button @click="cancelEdit"
                        class="bg-red-400 text-white px-2 py-1 rounded text-sm hover:bg-red-500">
                    Cancelar
                </button>
            </div>
        </td>
    </tr>

    <DeleteModal v-if="showModal"
                 :id="selectedItemId"
                 :show="showModal"
                 :title="'¿Estás seguro de que deseas eliminar este rol?'"
                 @responseDeleted="destroyItem"
                 @viewDeleted="closeModal" />
</template>

<style></style>
