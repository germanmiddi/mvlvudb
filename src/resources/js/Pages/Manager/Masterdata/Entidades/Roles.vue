<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios'
import RolesItem from './RolesItem.vue'

const emit = defineEmits(['toast-message'])

const props = defineProps({
    name: {
        type: String,
        required: true
    }
})

const showNew = ref(false)
const newName = ref("")
const newDescription = ref("")
const entidadRoles = ref([])

onMounted(() => {
    getData()
})

const sendMessage = (message, type) => {
    emit('toast-message', { message, type })
}

const getData = async () => {
    let response = await fetch(route('masterdata.get_entidad_roles'), { method: 'GET' })
    entidadRoles.value = await response.json()
}

const newItem = async () => {
    let formData = new FormData();
    formData.append('name', newName.value);
    formData.append('description', newDescription.value);

    try {
        const response = await axios.post(route('masterdata.store_entidad_roles'), formData);

        if (response.status == 200) {
            sendMessage(response.data.message, 'success')

            // Agregar el nuevo rol directamente al array local
            if (response.data.rol) {
                entidadRoles.value.push(response.data.rol);
                // Ordenar por nombre
                entidadRoles.value.sort((a, b) => a.name.localeCompare(b.name));
            }

            newName.value = ""
            newDescription.value = ""
            showNew.value = false

        } else {
            sendMessage(response.data.message, 'danger')
        }
    } catch (error) {
        console.log(error)
        sendMessage('Error al crear el rol', 'danger')
    }
}

const editItem = async (item) => {
    let formData = new FormData();
    formData.append('id', item.id);
    formData.append('name', item.name);
    formData.append('description', item.description);

    try {
        const response = await axios.post(route('masterdata.update_entidad_roles'), formData);

        if (response.status == 200) {
            sendMessage(response.data.message, 'success')

            // Actualizar el item en el array local para mostrar los cambios inmediatamente
            const index = entidadRoles.value.findIndex(rol => rol.id === item.id);
            if (index !== -1) {
                entidadRoles.value[index] = { ...entidadRoles.value[index], ...item };
            }

        } else {
            sendMessage(response.data.message, 'danger')
        }
    } catch (error) {
        console.log(error)
        sendMessage('Error al actualizar el rol', 'danger')
    }
}

const hideItem = async (id) => {
    try {
        const response = await axios.post(route('masterdata.hide_entidad_roles'), {id : id});

        if (response.status == 200) {
            sendMessage(response.data.message, 'success')

            // Refrescar la lista para mostrar los cambios
            await getData()

        } else {
            sendMessage(response.data.message, 'danger')
        }
    } catch (error) {
        console.log(error)
        sendMessage('Error al ocultar el rol', 'danger')
    }
}

const destroyItem = async (id) => {
    const response = await axios.post(route('masterdata.destroy_entidad_roles'), {id : id});

    if (response.status == 200) {
        sendMessage(response.data.message, 'success')

        entidadRoles.value = entidadRoles.value.filter(item => item.id != id)

    } else {
        sendMessage(response.data.message, 'danger')
    }
}
</script>

<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div>
                <div class="flex justify-between">
                    <h2 id="" class="text-lg leading-6 font-medium text-gray-900">{{name}} - Roles de Entidad</h2>
                    <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                            @click="showNew = !showNew">Crear</button>
                </div>
                <div v-if="showNew" class="my-5 space-y-3">
                    <div class="flex space-x-2">
                        <input v-model="newName"
                               placeholder="Nombre del rol"
                               class="w-5/12 border rounded font-base py-2 text-sm pl-2" />
                        <input v-model="newDescription"
                               placeholder="Descripción del rol"
                               class="w-5/12 border rounded font-base py-2 text-sm pl-2" />
                        <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                                @click="newItem">Guardar</button>
                    </div>
                </div>
            </div>
            <div class="">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="border-b-1 border-indigo-600 ">
                        <tr>
                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-2/6 text-left">Nombre</th>
                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-3/6 text-left">Descripción</th>
                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-1/6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <RolesItem v-for="rol in entidadRoles" :key="rol.id" :item="rol"
                                   @edit-item="editItem"
                                   @hide-item="hideItem"
                                   @destroy-item="destroyItem" />
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
