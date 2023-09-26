<template lang="">
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div>
                <div class="flex justify-between">
                    <h2 id="" class="text-lg leading-6 font-medium text-gray-900">Escuelas</h2>
                    <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white" 
                            @click="showNew = !showNew">Crear</button>
                </div>
                <div v-if="showNew" class="my-5">
                    <input v-model="newDescription" class="w-10/12 border rounded mr-2 font-base py-2 text-sm pl-2" />
                
                    <div class="flex mt-4">
                        <div class="flex items-center mr-4">
                            <input v-model="turnos.infante" id="turnos_infante" type="checkbox" value="1" class="w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="red-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Jardin de Infantes</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input v-model="turnos.primaria" id="turnos_primaria" type="checkbox" value="1" class="w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="red-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Primaria</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input v-model="turnos.secundaria" id="turnos_secundaria" type="checkbox" value="2" class="w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="green-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Secundaria</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input v-model="turnos.nocturna" id="turnos_nocturna" type="checkbox" value="3" class="w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="purple-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Nocturna</label>
                        </div>
                    </div>
                    
                    <button class="mt-4 relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                            @click="newItem">Guardar</button>
                </div>
            </div>
            <div class="">
                <table class="min-w-full divide-y divide-gray-200">    
                    <thead class="border-b-1 border-indigo-600 ">
                        <tr>
                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-2/6  text-left">Descripción</th>
                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-2/6  text-center">Turnos (Jar-Prim-Sec-Noc)</th>
                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-2/6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                           <ListEscuela v-for="t in this.escuelas" :key="t.id" :item=t 
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
import ListEscuela from './ListEscuela.vue'

export default {

    props: {
        dependencia_id: {
            type: Number,
            required: true
        }
    },
    components: {
        ListEscuela
    },
    setup() {

    },

    data() {

        return {
            escuelas: "",
            showNew: false,
            newDescription: "",
            turnos: {},
        }
    },
    created() {
        this.getData()
    },
    methods: {
        async getData() {
            let response = await fetch(route('masterdata.get_escuela', this.dependencia_id), { method: 'GET' })
            this.escuelas = await response.json()
        },

        async newItem() {
            let formData = new FormData();
            formData.append('dependencia_id', this.dependencia_id);
            formData.append('description', this.newDescription);
            formData.append('infante', this.turnos.infante ?? false);
            formData.append('primaria', this.turnos.primaria ?? false);
            formData.append('secundaria', this.turnos.secundaria ?? false);
            formData.append('nocturna', this.turnos.nocturna ?? false);

            try {
                const response = await axios.post(route('masterdata.store_escuela'), formData);

                if (response.status == 200) {
                    this.$emit('toast-message',
                        {
                            'message': response.data.message,
                            'type': 'success'
                        })

                    this.newDescription = ""
                    this.turnos = {}
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
            formData.append('infante', item.infante);
            formData.append('primaria', item.primaria);
            formData.append('secundaria', item.secundaria);
            formData.append('nocturna', item.nocturna);

            formData.append('activo', item.activo);


            try {
                const response = await axios.post(route('masterdata.update_escuela'), formData);

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

            const response = await axios.post(route('masterdata.hide_escuela'), { id: id });

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
