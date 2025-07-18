<script setup>
import { TrashIcon, PencilSquareIcon } from '@heroicons/vue/24/outline';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    item: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['get-participantes', 'toast-message'])

const editMode = ref(false)
const roles = ref([])
const editForm = ref({
    id: props.item.id,
    name: props.item.person.name,
    lastname: props.item.person.lastname,
    phone: (props.item.person.contact && props.item.person.contact.length > 0) ? props.item.person.contact[0].phone : '',
    role_id: props.item.role.id
})

const getRoles = async () => {
    const get = `${route('entidad.get_roles')}`
    const response = await fetch(get, { method: 'GET' })
    roles.value = await response.json()
}

const editItem = async () => {
    try {
        const formData = new FormData();
        formData.append('id', editForm.value.id);
        formData.append('name', editForm.value.name);
        formData.append('lastname', editForm.value.lastname);
        formData.append('phone', editForm.value.phone);
        formData.append('role_id', editForm.value.role_id);

        const response = await axios.post(route('entidad.update_participante'), formData);

        if (response.status == 200) {
            emit('toast-message', {
                message: response.data.message,
                type: "success"
            })
            emit('get-participantes')
            editMode.value = false
        } else {
            emit('toast-message', {
                message: response.data.message,
                type: "error"
            })
        }
    } catch (error) {
        emit('toast-message', {
            message: 'Error al actualizar el participante',
            type: "error"
        })
    }
}

const destroyItem = async (id) => {
    if (confirm('¿Está seguro que desea eliminar este participante?')) {
        try {
            const response = await axios.post(route('entidad.destroy_participante'), { id: id });

            if (response.status == 200) {
                emit('toast-message', {
                    message: response.data.message,
                    type: "success"
                })
                emit('get-participantes')
            } else {
                emit('toast-message', {
                    message: response.data.message,
                    type: "error"
                })
            }
        } catch (error) {
            emit('toast-message', {
                message: 'Error al eliminar el participante',
                type: "error"
            })
        }
    }
}

const cancelEdit = () => {
    editMode.value = false
    // Restaurar valores originales
    editForm.value = {
        id: props.item.id,
        name: props.item.person.name,
        lastname: props.item.person.lastname,
        phone: (props.item.person.contact && props.item.person.contact.length > 0) ? props.item.person.contact[0].phone : '',
        role_id: props.item.role.id
    }
}

onMounted(() => {
    getRoles()
})
</script>

<template>
<tr class="hover:bg-gray-50">
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        <div v-if="!editMode">{{ item.role.name }}</div>
        <select v-else v-model="editForm.role_id" class="mt-1 block w-full py-1 px-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option v-for="role in roles" :key="role.id" :value="role.id">
                {{ role.name }}
            </option>
        </select>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        <div v-if="!editMode">{{ item.person.name }} {{ item.person.lastname }}</div>
        <div v-else class="space-y-2">
            <input v-model="editForm.name" type="text" placeholder="Nombre" class="block w-full py-1 px-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
            <input v-model="editForm.lastname" type="text" placeholder="Apellido" class="block w-full py-1 px-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        <div v-if="!editMode">
            <div>{{ item.person.num_documento }}</div>
            <div class="text-xs text-gray-400">{{ (item.person.contact && item.person.contact.length > 0) ? item.person.contact[0].phone : 'Sin teléfono' }}</div>
        </div>
        <input v-else v-model="editForm.phone" type="text" placeholder="Teléfono" class="block w-full py-1 px-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div v-if="!editMode" class="flex justify-center space-x-3">
            <PencilSquareIcon @click="editMode = true" class="w-5 h-5 text-blue-600 hover:text-blue-800 cursor-pointer"/>
            <TrashIcon @click="destroyItem(item.id)" class="w-5 h-5 text-red-600 hover:text-red-800 cursor-pointer"/>
        </div>
        <div v-else class="flex justify-center space-x-2">
            <button @click="editItem" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                Guardar
            </button>
            <button @click="cancelEdit" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-sm">
                Cancelar
            </button>
        </div>
    </td>
</tr>
</template>
