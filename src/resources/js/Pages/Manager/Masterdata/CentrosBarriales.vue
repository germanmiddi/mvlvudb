<template lang="">
    <div>
        <!-- Tira de botones para scrollear -->
        <div class="flex space-x-2 mb-4">
            <button class="px-3 py-1 rounded bg-blue-200 hover:bg-blue-400" @click="scrollTo('centros-barriales')">Centros Barriales</button>
            <button class="px-3 py-1 rounded bg-blue-200 hover:bg-blue-400" @click="scrollTo('actividades-cb')">Actividades</button>
            <button class="px-3 py-1 rounded bg-blue-200 hover:bg-blue-400" @click="scrollTo('areas-cb')">Áreas</button>
            <button class="px-3 py-1 rounded bg-blue-200 hover:bg-blue-400" @click="scrollTo('centros-salud')">Centros de Salud</button>
        </div>
        <!-- Contenido principal -->
        <div class="shadow sm:rounded-md sm:overflow-hidden my-4">
            <div class="bg-white py-6 px-4 space-y-6 sm:p-6" id="centros-barriales">
                <div>
                    <div class="flex justify-between">
                        <h2 id="" class="text-lg leading-6 font-medium text-gray-900">Centros Barriales - Programas Sociales</h2>
                        <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                                @click="showNew = !showNew">Crear</button>
                    </div>
                    <div v-if="showNew" class="my-5">
                        <input v-model="newDescription" class="w-10/12 border rounded mr-2 font-base py-2 text-sm pl-2" />
                        <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
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
                                <ListItem v-for="t in this.programas" :key="t.id" :item=t
                                          @edit-item="editItem"
                                          @hide-item="hideItem"
                                          @destroy-item="destroyItem" />

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Componentes con IDs para scroll -->
        <ActividadesCB id="actividades-cb" @toast-message="setMessage" class="my-4"/>
        <AreasCB id="areas-cb" @toast-message="setMessage" class="my-4"/>
        <CentrosSalud id="centros-salud" @toast-message="setMessage" class="my-4"/>
    </div>
</template>

<script>
import axios from 'axios'
import ListItem from './ListItem.vue'
import ActividadesCB from './ActividadesCB.vue'
import AreasCB from './AreasCB.vue'
import CentrosSalud from './CentrosSalud.vue'

export default {

    props:{

    },
    components:{
        ListItem,
        ActividadesCB,
        AreasCB,
        CentrosSalud,
    },
    setup(){

    },

    data(){

        return{
            programas: "",
            showNew: false,
            newDescription: "",
        }
    },
    created(){
        this.getData()
    },
    methods:{
		async getData() {
            let response = await fetch(route('masterdata.centros_barriales.get_programas_sociales_cb'), { method: 'GET' })
            this.programas = await response.json()
		},

        async newItem(){
            let formData = new FormData();
            formData.append('dependencia_id', this.dependencia_id);
            formData.append('description', this.newDescription);

			try {
				const response = await axios.post(route('masterdata.centros_barriales.store_programas_sociales_cb') , formData  );

				if (response.status == 200) {
                    this.$emit('toast-message',
                                {'message' : response.data.message,
                                 'type' : 'success'} )

                    this.newDescription = ""
                    this.showNew = false
                    this.getData()

				} else {
                    this.$emit('toast-message',
                                {'message' : response.data.message,
                                 'type' : 'danger'} )
				}
			} catch (error) {
				console.log(error)
			}

        },
        async editItem(item){
            let formData = new FormData();
            formData.append('id', item.id);
            formData.append('description', item.description);
            formData.append('activo', item.activo);


			try {
				const response = await axios.post(route('masterdata.centros_barriales.update_programas_sociales_cb') , formData  );

				if (response.status == 200) {
                    this.$emit('toast-message',
                                {'message' : response.data.message,
                                 'type' : 'success'} )

				} else {
                    this.$emit('toast-message',
                                {'message' : response.data.message,
                                 'type' : 'danger'} )
				}
			} catch (error) {
				console.log(error)
			}
        },

        async hideItem(id){

            const response = await axios.post(route('masterdata.centros_barriales.hide_programas_sociales_cb' ), {id : id} );

            if (response.status == 200) {
                this.$emit('toast-message',
                                {'message' : response.data.message,
                                 'type' : 'success'} )

            } else {
                this.$emit('toast-message',
                                {'message' : response.data.message,
                                 'type' : 'danger'} )
            }

        },
        async destroyItem(id){
            const response = await axios.post(route('masterdata.centros_barriales.destroy_programas_sociales_cb' ), {id : id} );

            if (response.status == 200) {
                this.$emit('toast-message',
                                {'message' : response.data.message,
                                 'type' : 'success'} )

                this.programas = this.programas.filter( item => item.id != id)

            } else {
                this.$emit('toast-message',
                                {'message' : response.data.message,
                                 'type' : 'danger'} )
            }
        },
        setMessage(message){
            this.$emit('toast-message', message )
        },
        scrollTo(id) {
            const el = document.getElementById(id);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },
    },
}
</script>
