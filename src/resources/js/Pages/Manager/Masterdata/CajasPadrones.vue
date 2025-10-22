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
                    <div v-if="showNew" class="bg-gray-50 border border-gray-200 rounded-lg p-6 my-4">
                        <div class="grid grid-cols-12 gap-6">
                            <div class="col-span-12 sm:col-span-6">
                                <label for="nombre_padron" class="block text-sm font-medium text-gray-700">Nombre del Padrón</label>
                                <input v-model="newPadron.nombre" type="text" id="nombre_padron" name="nombre_padron"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                       placeholder="Ej: 2025 - Entrega Regular" />
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                                <input v-model="newPadron.fecha_inicio" type="date" id="fecha_inicio" name="fecha_inicio"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-6 mt-4">
                            <div class="col-span-12 sm:col-span-4">
                                <label for="fecha_fin" class="block text-sm font-medium text-gray-700">Fecha de Fin (opcional)</label>
                                <input v-model="newPadron.fecha_fin" type="date" id="fecha_fin" name="fecha_fin"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <label for="estado_entrevistas" class="block text-sm font-medium text-gray-700">Estado Entrevistas</label>
                                <select v-model="newPadron.estado_entrevistas" id="estado_entrevistas" name="estado_entrevistas"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <label for="estado_entregas" class="block text-sm font-medium text-gray-700">Estado Entregas</label>
                                <select v-model="newPadron.estado_entregas" id="estado_entregas" name="estado_entregas"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-6 mt-4">
                            <div class="col-span-12">
                                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                                <textarea v-model="newPadron.descripcion" id="descripcion" name="descripcion" rows="3"
                                          class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                          placeholder="Descripción del padrón..."></textarea>
                            </div>
                        </div>
                        <div class="mt-6 flex space-x-3">
                            <button type="button"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                    @click="newItem">Guardar</button>
                            <button type="button"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    @click="cancelNew">Cancelar</button>
                        </div>
                    </div>
                </div>
                <!-- Contenedor con scroll horizontal para pantallas pequeñas -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[200px]">
                                    Nombre
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px]">
                                    Fechas
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px]">
                                    Entrevistas
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px]">
                                    Entregas
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px]">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <PadronListItem v-for="padron in padrones" :key="padron.id" :item="padron"
                                           @edit-item="editItem" @toggle-entrevistas="toggleEntrevistas" @toggle-entregas="toggleEntregas" @destroy-item="destroyItem" />
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
                estado_entrevistas: 'activo',
                estado_entregas: 'inactivo',
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
            formData.append('estado_entrevistas', this.newPadron.estado_entrevistas);
            formData.append('estado_entregas', this.newPadron.estado_entregas);
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
                estado_entrevistas: 'activo',
                estado_entregas: 'inactivo',
                fecha_inicio: '',
                fecha_fin: ''
            }
        },

        async editItem(item) {
            let formData = new FormData();
            formData.append('id', item.id);
            formData.append('nombre', item.nombre);
            formData.append('descripcion', item.descripcion);
            formData.append('estado_entrevistas', item.estado_entrevistas);
            formData.append('estado_entregas', item.estado_entregas);
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
        },

        async toggleEntrevistas(id) {
            try {
                const response = await axios.post(route('masterdata.toggle_estado_entrevistas'), { id: id });

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
                    'message': 'Error al cambiar el estado de entrevistas',
                    'type': 'danger'
                })
            }
        },

        async toggleEntregas(id) {
            try {
                const response = await axios.post(route('masterdata.toggle_estado_entregas'), { id: id });

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
                    'message': 'Error al cambiar el estado de entregas',
                    'type': 'danger'
                })
            }
        }
    }
}
</script>
