<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div>
                <div class="flex justify-between">
                    <h2 class="text-lg leading-6 font-medium text-gray-900">Motivos de Suspensión - Entrevistas Cajas</h2>
                    <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                            @click="showNew = !showNew">Crear</button>
                </div>
                <div v-if="showNew" class="my-5">
                    <input v-model="newDescripcion"
                           class="w-10/12 border rounded mr-2 font-base py-2 text-sm pl-2"
                           placeholder="Descripción del motivo" />
                    <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                            @click="newItem">Guardar</button>
                </div>
            </div>
            <div class="">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="border-b-1 border-indigo-600">
                        <tr>
                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-4/6 text-left">Descripción</th>
                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-2/6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <ListItem v-for="motivo in motivos"
                                  :key="motivo.id"
                                  :item="motivo"
                                  @edit-item="editItem"
                                  @hide-item="hideItem"
                                  @destroy-item="destroyItem" />
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import ListItem from './ListItem.vue'

export default {
    components: {
        ListItem,
    },

    data() {
        return {
            motivos: [],
            showNew: false,
            newDescripcion: "",
        }
    },

    created() {
        this.getData()
    },

    methods: {
        async getData() {
            let response = await fetch(route('masterdata.get_motivos_suspension'), { method: 'GET' })
            this.motivos = await response.json()
        },

        async newItem() {
            if (!this.newDescripcion.trim()) {
                this.$emit('toast-message', {
                    'message': 'La descripción es requerida',
                    'type': 'danger'
                })
                return
            }

            let formData = new FormData();
            formData.append('description', this.newDescripcion);

            try {
                const response = await axios.post(route('masterdata.store_motivo_suspension'), formData);

                if (response.status == 200) {
                    this.$emit('toast-message', {
                        'message': response.data.message,
                        'type': 'success'
                    })

                    this.newDescripcion = ""
                    this.showNew = false
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
                    'message': 'Error al crear el motivo',
                    'type': 'danger'
                })
            }
        },

        async editItem(item) {
            let formData = new FormData();
            formData.append('id', item.id);
            formData.append('description', item.description);
            formData.append('activo', item.activo);

            try {
                const response = await axios.post(route('masterdata.update_motivo_suspension'), formData);

                if (response.status == 200) {
                    this.$emit('toast-message', {
                        'message': response.data.message,
                        'type': 'success'
                    })
                } else {
                    this.$emit('toast-message', {
                        'message': response.data.message,
                        'type': 'danger'
                    })
                }
            } catch (error) {
                console.log(error)
                this.$emit('toast-message', {
                    'message': 'Error al actualizar el motivo',
                    'type': 'danger'
                })
            }
        },

        async hideItem(id) {
            const response = await axios.post(route('masterdata.hide_motivo_suspension'), { id: id });

            if (response.status == 200) {
                this.$emit('toast-message', {
                    'message': response.data.message,
                    'type': 'success'
                })
            } else {
                this.$emit('toast-message', {
                    'message': response.data.message,
                    'type': 'danger'
                })
            }
        },

        async destroyItem(id) {
            const response = await axios.post(route('masterdata.destroy_motivo_suspension'), { id: id });

            if (response.status == 200) {
                this.$emit('toast-message', {
                    'message': response.data.message,
                    'type': 'success'
                })

                this.motivos = this.motivos.filter(item => item.id != id)
            } else {
                this.$emit('toast-message', {
                    'message': response.data.message,
                    'type': 'danger'
                })
            }
        },
    },
}
</script>

