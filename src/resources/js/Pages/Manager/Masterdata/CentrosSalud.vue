<template lang="">
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div>
                <div class="flex justify-between">
                    <h2 id="" class="text-lg leading-6 font-medium text-gray-900">Centros de Salud</h2>
                    <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white" 
                            @click="showNew = !showNew">Crear</button>
                </div>
                <div v-if="showNew" class="my-5">
                    <input v-model="newDescription" class="w-10/12 border rounded mr-2 font-base py-2 text-sm pl-2" />
                    
                    <button class="mt-4 relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
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
                           <ListCentrosSalud v-for="t in this.areas" :key="t.id" :item=t 
                                      @edit-item="editItem" 
                                      @hide-item="hideItem" 
                                      />

                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import ListCentrosSalud from './ListCentrosSalud.vue'

export default {

    props: {
        dependencia_id: {
            type: Number,
            required: true
        }
    },
    components: {
        ListCentrosSalud
    },
    setup() {

    },

    data() {

        return {
            areas: "",
            showNew: false,
            newDescription: ""
        }
    },
    created() {
        this.getData()
    },
    methods: {
        async getData() {
            let response = await fetch(route('masterdata.get_centro_salud'), { method: 'GET' })
            this.areas = await response.json()
        },

        async newItem() {
            let formData = new FormData();
            formData.append('description', this.newDescription);

            try {
                const response = await axios.post(route('masterdata.store_centro_salud'), formData);

                if (response.status == 200) {
                    this.$emit('toast-message',
                        {
                            'message': response.data.message,
                            'type': 'success'
                        })

                    this.newDescription = ""
                    this.showNew = false
                    this.getData()

                } else {
                    this.$emit('toast-message',
                        {
                            'message': response.data.message,
                            'type': 'danger'
                        })
                }
            } catch (error) {
                console.log(error)
            }

        },
        async editItem(item) {
            let formData = new FormData();
            formData.append('id', item.id);
            formData.append('description', item.description);

            formData.append('activo', item.activo);


            try {
                const response = await axios.post(route('masterdata.update_centro_salud'), formData);

                if (response.status == 200) {
                    this.$emit('toast-message',
                        {
                            'message': response.data.message,
                            'type': 'success'
                        })

                } else {
                    this.$emit('toast-message',
                        {
                            'message': response.data.message,
                            'type': 'danger'
                        })
                }
            } catch (error) {
                console.log(error)
            }
        },

        async hideItem(id) {

            const response = await axios.post(route('masterdata.hide_centro_salud'), { id: id });

            if (response.status == 200) {
                this.$emit('toast-message',
                    {
                        'message': response.data.message,
                        'type': 'success'
                    })

            } else {
                this.$emit('toast-message',
                    {
                        'message': response.data.message,
                        'type': 'danger'
                    })
            }

        }

    },
}
</script>
