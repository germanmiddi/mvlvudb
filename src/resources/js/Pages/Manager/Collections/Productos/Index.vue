<template>
    <main class="flex-1">
        <!-- Page title & actions -->


        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Entrega de Productos - Productos
                </h1>
            </div>
            <div class="mt-4 flex sm:mt-0 sm:ml-4">
                
            </div>
        </div>

        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

        <main class="max-w-7xl mx-auto pb-10 py-8 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <div class="space-y-6 px-4 sm:px-6 lg:px-0 lg:col-span-9">
                    <div class="shadow sm:rounded-md sm:overflow-hidden w-full ">
                        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">

                            <div class="flex justify-between">
                                <h2 id="" class="text-lg leading-6 font-medium text-gray-900">Productos</h2>
                                <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white" 
                                        @click="showNew = !showNew">Crear</button>
                            </div>
                            <div v-if="showNew" class="my-5">
                                <div class="flex flex-col">
                                    <label for="name" class="text-sm text-gray-700 mb-1">Nombre</label>                                                                
                                    <input v-model="newName" class="w-10/12 border rounded mr-2 font-base py-2 text-sm pl-2" />
                                </div>
                                <div class="flex flex-col mt-2">
                                    <label for="description" class="text-sm text-gray-700 mb-1">Descripción</label>                                                                
                                    <input v-model="newDescription" class="w-10/12 border rounded mr-2 font-base py-2 text-sm pl-2" />
                                </div>
                                <button class="mt-4 relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                                        @click="newItem">Guardar</button>
                            </div>

                            <div class="">
                                <table class="min-w-full divide-y divide-gray-200">    
                                    <thead class="border-b-1 border-indigo-600 ">
                                        <tr>
                                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-2/6  text-left">Nombre</th>
                                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-4/6  text-left">Descripción</th>
                                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-1/6 text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <Item v-for="t in this.productos" :key="t.id" :item=t 
                                                    @edit-item="editItem" 
                                                    @hide-item="hideItem" 
                                                    @destroy-item="destroyItem" />

                                    </tbody>
                                </table> 
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </main>    



   

</template>

<script>

import axios from 'axios'
import Item from './Item.vue'

export default {

    props: {
        name: {
            type: String,
            required: true
        },
        dependencia_id: {
            type: Number,
            required: true
        }
    },
    components: {
        Item
    },
    data() {
        return {
            productos: "",
            showNew: false,
            newDescription: "",
            newName: "",
            filter: {},
        }
    },
    created() {
        this.getData()
    },
    methods: {
        async getData() {
            let response = await axios.get(route('masterdata.fortalecimiento.get_productos'))
            let list = await response.data
            this.productos = list
        },

        async newItem() {
            let formData = new FormData();
            formData.append('name', this.newName);
            formData.append('description', this.newDescription);

            try {
                const response = await axios.post(route('masterdata.fortalecimiento.store_productos'), formData);

                if (response.status == 200) {
                    this.$emit('toast-message',
                        {
                            'message': response.data.message,
                            'type': 'success'
                        })

                    this.newDescription = ""    
                    this.newName = ""
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
                const response = await axios.post(route('masterdata.fortalecimiento.update_puntos_entrega'), formData);

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

            const response = await axios.post(route('masterdata.fortalecimiento.hide_puntos_entrega'), { id: id });

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

        },

        async destroyItem(id) {
            const response = await axios.post(route('masterdata.fortalecimiento.destroy_puntos_entrega'), { id: id });

            if (response.status == 200) {
                this.$emit('toast-message',
                    {
                        'message': response.data.message,
                        'type': 'success'
                    })

                this.puntosEntrega = this.puntosEntrega.filter(item => item.id != id)

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
