<script setup>
import { ref } from 'vue'
import ParticipantesForm from './ParticipantesForm.vue'
// import ParticipantesList from './ParticipantesList.vue'

const showParticipanteForm = ref(false)
defineProps({
    entidad_id: {
        type: Number,
        required: false
    }
})
const addParticipante = () => {
    showParticipanteForm.value = !showParticipanteForm.value
}

const toastMessage = (message) => {
    console.log(message)
}
</script>

<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden mt-6 ">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">

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
            <ParticipantesForm v-if="showParticipanteForm" @toast-message="toastMessage" :entidad_id="entidad_id" />
            <!-- <ParticipantesList /> -->
        </div>
    </div>


</template>
