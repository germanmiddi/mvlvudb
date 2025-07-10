<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios'
import ListItem from '../ListItem.vue'

const emit = defineEmits(['toast-message'])

const props = defineProps({
    name: {
        type: String,
        required: true
    },
    dependencia_id: {
        type: Number,
        required: true
    }
})

const showNew = ref(false)
const newDescription = ref("")
const tipoTramite = ref([])

onMounted(() => {
    getData()
})

const sendMessage = (message, type) => {
    emit('toast-message', { message, type })
}

const getData = async () => {
    let response = await fetch(route('masterdata.get_tipo_tramite',props.dependencia_id ), { method: 'GET' })
    tipoTramite.value = await response.json()
}


const newItem = async () => {
    let formData = new FormData();
    formData.append('dependencia_id', props.dependencia_id);
    formData.append('description', newDescription.value);

    try {
        const response = await axios.post(route('masterdata.store_tipo_tramite') , formData  );

        if (response.status == 200) {
            sendMessage(response.data.message, 'success')

            newDescription.value = ""
            showNew.value = false
            getData()

        } else {
            sendMessage(response.data.message, 'danger')
        }
    } catch (error) {
        console.log(error)
    }

}


const editItem = async (item) => {
    let formData = new FormData();
    formData.append('id', item.id);
    formData.append('description', item.description);
    formData.append('activo', item.activo);


    try {
        const response = await axios.post(route('masterdata.update_tipo_tramite') , formData  );

        if (response.status == 200) {
            sendMessage(response.data.message, 'success')

        } else {
            sendMessage(response.data.message, 'danger')
        }
    } catch (error) {
        console.log(error)
    }
}

const hideItem = async (id) => {

    const response = await axios.post(route('masterdata.hide_tipo_tramite' ), {id : id} );

    if (response.status == 200) {
        sendMessage(response.data.message, 'success')

    } else {
        sendMessage(response.data.message, 'danger')
    }
}

const destroyItem = async (id) => {
    const response = await axios.post(route('masterdata.destroy_tipo_tramite' ), {id : id} );

    if (response.status == 200) {
        sendMessage(response.data.message, 'success')

        tipoTramite.value = tipoTramite.value.filter( item => item.id != id)

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
                    <h2 id="" class="text-lg leading-6 font-medium text-gray-900">{{name}} - Tipo de Trámite</h2>
                    <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                            @click="showNew = !showNew">Crear</button>
                </div>
                <div v-if="showNew" class="my-5">
                    <input v-model="newDescription" class="w-10/12 border rounded mr-2 font-base py-2 text-sm pl-2" />
                    <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                            @click="newItem">Guardar</button>
                </div>
            </div>
            <div class="">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="border-b-1 border-indigo-600 ">
                        <tr>
                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-4/6  text-left">Descripción</th>
                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-2/6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                            <ListItem v-for="t in tipoTramite" :key="t.id" :item=t
                                      @edit-item="editItem"
                                      @hide-item="hideItem"
                                      @destroy-item="destroyItem" />

                    </tbody>
                </table>
            </div>
        </div>

    </div>


</template>
