<template>
    <div>
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                <div>
                    <div class="flex justify-between">
                        <h2 id="" class="text-lg leading-6 font-medium text-gray-900">Módulo Cajas - Padrones</h2>
                        <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                                @click="showNew = !showNew">Crear</button>
                    </div>
                    <div v-if="showNew" class="my-5">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombre del Padrón</label>
                                <input v-model="newPadron.nombre" class="mt-1 w-full border rounded py-2 text-sm pl-2"
                                       placeholder="Ej: 2025 - Entrega Regular" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                                <input v-model="newPadron.fecha_inicio" type="date" class="mt-1 w-full border rounded py-2 text-sm pl-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha de Fin (opcional)</label>
                                <input v-model="newPadron.fecha_fin" type="date" class="mt-1 w-full border rounded py-2 text-sm pl-2" />
                            </div>
                            <div class="flex items-center">
                                <input v-model="newPadron.activo" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                                <label class="ml-2 block text-sm text-gray-900">Activo</label>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Descripción</label>
                            <textarea v-model="newPadron.descripcion" rows="3" class="mt-1 w-full border rounded py-2 text-sm pl-2"
                                      placeholder="Descripción del padrón..."></textarea>
                        </div>
                        <div class="mt-4 flex space-x-2">
                            <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                                    @click="newItem">Guardar</button>
                            <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-gray-200 text-gray-900 hover:bg-gray-600 hover:text-white"
                                    @click="cancelNew">Cancelar</button>
                        </div>
                    </div>
                </div>
                <div class="">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fechas
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <PadronListItem v-for="padron in padrones" :key="padron.id" :item="padron"
                                           @edit-item="editItem" @hide-item="hideItem" @destroy-item="destroyItem" />
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PadronListItem from './PadronListItem.vue';

export default {
    components: {
        PadronListItem,
    },
    data() {
        return {
            padrones: [],
            showNew: false,
            newPadron: {
                nombre: '',
                descripcion: '',
                activo: true,
                fecha_inicio: '',
                fecha_fin: ''
            }
        }
    },
    created() {
        this.getData()
    },
    methods: {
        async getData() {
            try {
                let response = await fetch(route('masterdata.get_padrones'), { method: 'GET' })
                this.padrones = await response.json()
            } catch (error) {
                console.error('Error al cargar padrones:', error)
            }
        },

        async newItem() {
            if (!this.newPadron.nombre || !this.newPadron.fecha_inicio) {
                this.$emit('toast-message', {
                    'message': 'Los campos Nombre y Fecha de Inicio son obligatorios',
                    'type': 'danger'
                })
                return
            }

            let formData = new FormData();
            formData.append('nombre', this.newPadron.nombre);
            formData.append('descripcion', this.newPadron.descripcion);
            formData.append('activo', this.newPadron.activo ? '1' : '0');
            formData.append('fecha_inicio', this.newPadron.fecha_inicio);
            formData.append('fecha_fin', this.newPadron.fecha_fin || '');

            try {
                const response = await axios.post(route('masterdata.store_padron'), formData);

                if (response.status == 200) {
                    this.$emit('toast-message', {
                        'message': response.data.message,
                        'type': 'success'
                    })

                    this.cancelNew()
                    this.getData()
                } else {
                    this.$emit('toast-message', {
                        'message': response.data.message,
                        'type': 'danger'
                    })
                }
            } catch (error) {
                console.log(error)
                this.$emit('toast-message', {
                    'message': 'Error al crear el padrón',
                    'type': 'danger'
                })
            }
        },

        cancelNew() {
            this.showNew = false
            this.newPadron = {
                nombre: '',
                descripcion: '',
                activo: true,
                fecha_inicio: '',
                fecha_fin: ''
            }
        },

        async editItem(item) {
            let formData = new FormData();
            formData.append('id', item.id);
            formData.append('nombre', item.nombre);
            formData.append('descripcion', item.descripcion);
            formData.append('activo', item.activo ? '1' : '0');
            formData.append('fecha_inicio', item.fecha_inicio);
            formData.append('fecha_fin', item.fecha_fin || '');

            try {
                const response = await axios.post(route('masterdata.update_padron'), formData);

                if (response.status == 200) {
                    this.$emit('toast-message', {
                        'message': response.data.message,
                        'type': 'success'
                    })
                    this.getData()
                } else {
                    this.$emit('toast-message', {
                        'message': response.data.message,
                        'type': 'danger'
                    })
                }
            } catch (error) {
                console.log(error)
                this.$emit('toast-message', {
                    'message': 'Error al actualizar el padrón',
                    'type': 'danger'
                })
            }
        },

        async hideItem(id) {
            try {
                const response = await axios.post(route('masterdata.hide_padron'), { id: id });

                if (response.status == 200) {
                    this.$emit('toast-message', {
                        'message': response.data.message,
                        'type': 'success'
                    })
                    this.getData()
                } else {
                    this.$emit('toast-message', {
                        'message': response.data.message,
                        'type': 'danger'
                    })
                }
            } catch (error) {
                console.log(error)
                this.$emit('toast-message', {
                    'message': 'Error al cambiar el estado del padrón',
                    'type': 'danger'
                })
            }
        },

        async destroyItem(id) {
            try {
                const response = await axios.post(route('masterdata.destroy_padron'), { id: id });

                if (response.status == 200) {
                    this.$emit('toast-message', {
                        'message': response.data.message,
                        'type': 'success'
                    })
                    this.getData()
                } else {
                    this.$emit('toast-message', {
                        'message': response.data.message,
                        'type': 'danger'
                    })
                }
            } catch (error) {
                console.log(error)
                this.$emit('toast-message', {
                    'message': 'Error al eliminar el padrón',
                    'type': 'danger'
                })
            }
        }
    }
}
</script>
