<script setup>
import { ref } from 'vue'
import ParticipantesForm from './ParticipantesForm.vue'
import ParticipantesList from './ParticipantesList.vue'
import Toast from "@/Layouts/Components/Toast.vue";

const showParticipanteForm = ref(false)
const toastMessage = ref("")
const labelType = ref("info")

const props = defineProps({
    entidad_id: {
        type: Number,
        required: false
    },
    participantes: {
        type: Array,
        required: false
    }
})

const addParticipante = () => {
    showParticipanteForm.value = !showParticipanteForm.value
}

const handleToastMessage = (message) => {
    toastMessage.value = message.message
    labelType.value = message.type
}

const clearMessage = () => {
    toastMessage.value = ""
}

const listParticipantes = ref(props.participantes)

const getParticipantes = async () => {
    const get = `${route('entidad.get_participantes', props.entidad_id)}`
    const response = await fetch(get, { method: 'GET' })
    listParticipantes.value = await response.json()
}

const closeForm = () => {
    showParticipanteForm.value = false
}
</script>

<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <Toast :toast="toastMessage" :type="labelType" @clear="clearMessage"></Toast>

            <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Participantes
                    </h3>
                </div>
                <div class="flex-shrink-0">
                    <button type="button" @click="addParticipante()"
                        class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md"
                        :class="showParticipanteForm ? 'bg-red-200 text-red-900 hover:bg-red-600 hover:text-white' : 'bg-green-200 text-green-900 hover:bg-green-600 hover:text-white'">
                        {{ showParticipanteForm ? 'Cerrar' : 'Agregar Participante' }}
                    </button>
                </div>
            </div>

            <ParticipantesForm
                v-if="showParticipanteForm"
                @toast-message="handleToastMessage"
                @get-participantes="getParticipantes"
                @close-form="closeForm"
                :entidad_id="entidad_id"
            />

            <ParticipantesList
                :participantes="listParticipantes"
                @get-participantes="getParticipantes"
                @toast-message="handleToastMessage"
            />
        </div>
    </div>
</template>
