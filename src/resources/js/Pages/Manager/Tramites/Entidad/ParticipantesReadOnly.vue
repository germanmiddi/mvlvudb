<script setup>
const props = defineProps({
    participantes: {
        type: Array,
        required: false,
        default: () => []
    }
})
</script>

<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Participantes
                </h3>
            </div>

            <div v-if="participantes && participantes.length > 0">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rol
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Documento
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Teléfono
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="participante in participantes" :key="participante.id" class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ participante.role.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ participante.person.name }} {{ participante.person.lastname }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ participante.person.num_documento }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ (participante.person.contact && participante.person.contact.length > 0) ? participante.person.contact[0].phone : 'Sin teléfono' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div v-else class="text-center py-8">
                <div class="text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A9.971 9.971 0 0124 24c4.004 0 7.625 2.31 9.287 5.286" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Sin participantes</h3>
                    <p class="mt-1 text-sm text-gray-500">Esta entidad no tiene participantes registrados.</p>
                </div>
            </div>
        </div>
    </div>
</template>
