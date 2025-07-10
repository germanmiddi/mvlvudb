<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const emit = defineEmits(['toast-message', 'get-participantes', 'close-form'])

const form = ref({
    num_documento: '',
    tipo_documento_id: '1',
    name: '',
    lastname: '',
    phone: ''
})

const roles = ref([])
const props = defineProps({
    entidad_id: {
        type: Number,
        required: false
    }
})

const getPerson = async () => {
    //TODO verificar si el participante ya existe en la entidad
    let num_documento = form.value.num_documento;
    const get = `${route('persons.getPersonDni', form.value.num_documento)}`
    const response = await fetch(get, { method: 'GET' })
    let data = await response.json()
    if (!data.data.length == 0) {
        data = data.data[0].person

            form.value.num_documento = num_documento;
            /// Recuperar datos.
            form.value.tipo_documento_id = data.tipo_documento_id
            form.value.name = data.name
            form.value.lastname = data.lastname
            if (data.contact != '') {
                form.value.phone = data.contact[0].phone
            }

    } else {
        emit('toast-message', {
            message: "El DNI indicado no se encuentra registrado",
            type: "info"
        })
    }
}

const getRoles = async () => {
    const get = `${route('entidad.get_roles')}`
    const response = await fetch(get, { method: 'GET' })
    roles.value = await response.json()

}

const clearForm = () => {
    form.value = {
        num_documento: '',
        tipo_documento_id: '1',
        name: '',
        lastname: '',
        phone: '',
        role_id: ''
    }
}

const addParticipante = async () => {

    const formData = new FormData();

    formData.append('num_documento', form.value.num_documento);
    formData.append('tipo_documento_id', form.value.tipo_documento_id);
    formData.append('name', form.value.name);
    formData.append('lastname', form.value.lastname);
    formData.append('phone', form.value.phone);
    formData.append('role_id', form.value.role_id);
    if (props.entidad_id) {
        formData.append('entidad_id', props.entidad_id);
    }

    const post = `${route('entidad.add_participante')}`
    const response = await axios.post(post, formData)
    if (response.status == 200) {
        emit('toast-message', {
            message: response.data.message,
            type: "success"
        })
        emit('get-participantes')
        clearForm()
        emit('close-form')
    } else {
        emit('toast-message', {
            message: response.data.message,
            type: "error"
        })

    }
}

onMounted(() => {
    getRoles()
})
</script>




<template>
    <div class="grid grid-cols-12 gap-6 border-b pb-6 border-gray-200">
        <div class="col-span-12 sm:col-span-4">
            <label
                for="num_documento"
                class="block text-sm font-medium text-gray-700"
                >Nro de Documento</label
            >
            <div class="relative">
                <input
                    type="text"
                    v-model="form.num_documento"
                    @keyup.enter="getPerson()"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                />
                <a
                    @click="getPerson()"
                    class="absolute inset-y-0 right-0 px-4 py-2 bg-green-200 text-white text-xs rounded-r-md hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-600 shadow-sm text-xs font-medium flex items-center text-green-900 hover:text-white"
                >
                    Verificar
                </a>
            </div>
        </div>

        <div class="col-span-12 sm:col-span-4">
            <label
                for="cargo_id"
                class="block text-sm font-medium text-gray-700"
                >Rol de Integrante</label
            >
            <select
                v-model="form.role_id"
                id="role_id"
                name="role_id"
                autocomplete="off"
                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
                <option value="" disabled>Seleccione un rol</option>
                <option
                    v-for="role in roles"
                    :key="role.id"
                    :value="role.id"
                >
                    {{ role.name }}
                </option>
            </select>
        </div>

        <div class="col-span-12 sm:col-span-4">
            <label for="name" class="block text-sm font-medium text-gray-700"
                >Nombre</label
            >
            <input
                v-model="form.name"
                type="text"
                name="name"
                id="name"
                autocomplete="off"
                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
            />
        </div>
        <div class="col-span-12 sm:col-span-4">
            <label
                for="lastname"
                class="block text-sm font-medium text-gray-700"
                >Apellido</label
            >
            <input
                v-model="form.lastname"
                type="text"
                name="lastname"
                id="lastname"
                autocomplete="off"
                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
            />
        </div>

        <div class="col-span-12 sm:col-span-4">
            <label for="phone" class="block text-sm font-medium text-gray-700"
                >Teléfono</label
            >
            <input
                v-model="form.phone"
                type="text"
                name="phone"
                id="phone"
                autocomplete="off"
                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
            />
        </div>
        <div class="col-span-12 sm:col-span-4">
            <button
                type="button"
                @click="addParticipante()"
                class="mt-7 relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
            >
                Agregar Participante
            </button>
        </div>
    </div>

</template>
