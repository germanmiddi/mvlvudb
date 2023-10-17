<template lang="">
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div>
                <div class="flex justify-between">
                    <h2 id="" class="text-lg leading-6 font-medium text-gray-900">{{this.name}} - Tipo de Trámite</h2>
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
                            <ListItem v-for="t in this.tipoTramite" :key="t.id" :item=t 
                                      @edit-item="editItem" 
                                      @hide-item="hideItem" 
                                      @destroy-item="destroyItem" />

                    </tbody>
                </table> 
            </div>
        </div>
    </div>
    <CbiEscuelas    :dependencia_id="this.dependencia_id" 
                    @toast-message="setMessage" />
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div>
                <div class="flex justify-between">
                    <h2 id="" class="text-lg leading-6 font-medium text-gray-900">Datos Maestros Formulario CBI</h2>
                    <a v-if="!processExport"
                        class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                        @click="exportDatos">
                        Exportar Datos
                    </a>
                    <a v-else
                        class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-yellow-900"
                        @click="exportDatos">
                        <ArrowPathIcon class="h-5 w-5 text-red-500 animate-spin mr-2" /> Exportar Datos
                    </a>
                    
                </div>
            </div>
           
        </div>
    </div>

</template>

<script>
import axios from 'axios'
import ListItem from './ListItem.vue'
import CbiEscuelas from './CbiEscuelas.vue'
import {ArrowPathIcon} from "@heroicons/vue/24/solid";

export default {

    props:{
        name: {
            type: String,
            required: true
        },
        dependencia_id: {
            type: Number,
            required: true
        }
    },
    components:{
        ListItem,
        CbiEscuelas,
        ArrowPathIcon
    },
    setup(){

    },

    data(){

        return{
            tipoTramite: "",
            showNew: false,
            newDescription: "",   
            processExport: false 
        }
    },
    created(){
        this.getData()
    },
    methods:{
		async getData() {
            let response = await fetch(route('masterdata.get_tipo_tramite',this.dependencia_id ), { method: 'GET' })
            this.tipoTramite = await response.json()
		},

        async newItem(){
            let formData = new FormData();
            formData.append('dependencia_id', this.dependencia_id);
            formData.append('description', this.newDescription);

			try {
				const response = await axios.post(route('masterdata.store_tipo_tramite') , formData  ); 
                
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
				const response = await axios.post(route('masterdata.update_tipo_tramite') , formData  ); 
                
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

            const response = await axios.post(route('masterdata.hide_tipo_tramite' ), {id : id} ); 
                
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
            const response = await axios.post(route('masterdata.destroy_tipo_tramite' ), {id : id} ); 
                
            if (response.status == 200) {
                this.$emit('toast-message', 
                                {'message' : response.data.message, 
                                 'type' : 'success'} )

                this.tipoTramite = this.tipoTramite.filter( item => item.id != id)

            } else {
                this.$emit('toast-message', 
                                {'message' : response.data.message, 
                                 'type' : 'danger'} )
            }            
        },
        async exportDatos() {

            this.processExport = true
            let rt = route("masterdata.exportDatos");

            try {
                const response = await axios.post(rt, this.filter, {
                    responseType: 'blob', // Especifica que esperamos un archivo binario (Blob)
                });

                // Crear un objeto Blob con la respuesta
                const blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

                // Crear una URL de objeto para el Blob
                const url = window.URL.createObjectURL(blob);

                // Crear un enlace <a> para iniciar la descarga
                const a = document.createElement('a');
                a.href = url;
                a.download = 'Datos Maestros CBI.xlsx'; // Nombre del archivo
                a.style.display = 'none';

                // Agregar el enlace al cuerpo del documento y hacer clic en él
                document.body.appendChild(a);
                a.click();

                // Liberar la URL del objeto después de la descarga
                window.URL.revokeObjectURL(url);
            } catch (error) {
                console.error(error);
            }
            this.processExport = false
        },
        setMessage(message){
            this.$emit('toast-message', message )
            },

    },
}
</script>
