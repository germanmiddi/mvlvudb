<template>
    <div>
        <div class="shadow sm:rounded-md sm:overflow-hidden my-4" >
            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Módulo Cajas de Alimentos</h3>
                <p class="mt-1 text-sm text-gray-500">Configuraciónes para la entrega de cajas de alimentos.</p>
                </div>
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="dias" class="block text-sm font-medium text-gray-700"> Cantidad de días para entrega de cajas </label>
                        <p class="mt-1 text-sm text-gray-500">Por defecto 30 días.</p>
                        <div class="mt-1 flex items-center gap-x-2">
                            <input type="number" min="0" name="dias" id="dias" v-model="dias" class="w-1/2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md" />
                            <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                                    @click="saveDias">Guardar</button>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                    </div>
                </div>
            </div>
        </div>

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
    </div>
</template>

<script>
import axios from 'axios'
import ListItem from './ListItem.vue'

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
    },
    setup(){

    },

    data(){

        return{
            tipoTramite: "",
            showNew: false,
            newDescription: "",
            dias: 0,
        }
    },
    created(){
        this.getData()
    },
    methods:{
		async getData() {
            let response = await fetch(route('masterdata.get_tipo_tramite',this.dependencia_id ), { method: 'GET' })
            this.tipoTramite = await response.json()

            let settings = await fetch(route('setting.list',{module: 'CAJAS', key: 'dias_entrega_cajas'}), { method: 'GET' })
            let settingsData = await settings.json()
            if(settingsData.length > 0){
                this.dias = settingsData[0].value
            }else{
                this.dias = 30
            }

		},

        async saveDias(){
            let formData = new FormData();
            formData.append('module', 'CAJAS');
            formData.append('key', 'dias_entrega_cajas');
            formData.append('value', this.dias);
            try{
                let response = await axios.post(route('setting.update'), formData )
                console.log(response)
                if(response.status == 200){
                    this.$emit('toast-message',
                                    {'message' : response.data.message,
                                     'type' : 'success'} )
                }else{
                    this.$emit('toast-message',
                                    {'message' : Error,
                                     'type' : 'danger'} )
                }
            }catch(error){
                this.$emit('toast-message',
                                    {'message' : 'Error al guardar los datos',
                                     'type' : 'danger'} )
            }
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
        }

    },
}
</script>
