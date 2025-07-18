<script setup>
import ParticipantesListItem from './ParticipantesListItem.vue';

const props = defineProps({
    participantes: {
        type: Array,
        required: true
    }
})

const emit = defineEmits(['get-participantes', 'toast-message'])

const handleGetParticipantes = () => {
    emit('get-participantes')
}

const handleToastMessage = (message) => {
    emit('toast-message', message)
}
</script>

<template>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 sm:col-span-12">
            <table
                class="min-w-full divide-y divide-gray-200 w-full col-span-6 sm:col-span-12"
            >
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12"
                        >
                            Rol
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12"
                        >
                            Nombre
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12"
                        >
                            Documento / Teléfono
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12"
                        >
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <ParticipantesListItem
                        v-for="participante in participantes"
                        :key="participante.id"
                        :item="participante"
                        @get-participantes="handleGetParticipantes"
                        @toast-message="handleToastMessage"
                    />
                </tbody>
            </table>
            <div v-if="!participantes || participantes.length === 0" class="text-center py-8 text-gray-500">
                No hay participantes registrados
            </div>
        </div>
    </div>
</template>
