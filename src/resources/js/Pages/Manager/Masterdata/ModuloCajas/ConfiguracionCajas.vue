<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Configuración de Entregas</h3>
                <p class="mt-1 text-sm text-gray-500">Configuraciones generales para la entrega de cajas de alimentos.</p>
            </div>
            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-4">
                    <label for="dias" class="block text-sm font-medium text-gray-700">
                        Cantidad de días para entrega de cajas
                    </label>
                    <p class="mt-1 text-sm text-gray-500">Por defecto 30 días.</p>
                    <div class="mt-1 flex items-center gap-x-2">
                        <input
                            type="number"
                            min="0"
                            name="dias"
                            id="dias"
                            v-model="dias"
                            class="w-1/2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md"
                        />
                        <button
                            class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                            @click="saveDias">
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            dias: 30,
        }
    },

    created() {
        this.getData()
    },

    methods: {
        async getData() {
            try {
                let settings = await fetch(route('setting.list', {module: 'CAJAS', key: 'dias_entrega_cajas'}), { method: 'GET' })
                let settingsData = await settings.json()
                if(settingsData.length > 0) {
                    this.dias = settingsData[0].value
                } else {
                    this.dias = 30
                }
            } catch(error) {
                console.error('Error al cargar configuración:', error)
            }
        },

        async saveDias() {
            let formData = new FormData();
            formData.append('module', 'CAJAS');
            formData.append('key', 'dias_entrega_cajas');
            formData.append('value', this.dias);

            try {
                let response = await axios.post(route('setting.update'), formData)
                if(response.status == 200) {
                    this.$emit('toast-message', {
                        'message': response.data.message,
                        'type': 'success'
                    })
                } else {
                    this.$emit('toast-message', {
                        'message': 'Error al guardar',
                        'type': 'danger'
                    })
                }
            } catch(error) {
                this.$emit('toast-message', {
                    'message': 'Error al guardar los datos',
                    'type': 'danger'
                })
            }
        },
    },
}
</script>

