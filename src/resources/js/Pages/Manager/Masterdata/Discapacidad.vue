<template lang="">
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div>
                <h2 id="" class="text-lg leading-6 font-medium text-gray-900">Tipo de Trámite</h2>
            </div>
            <div class=" border-b border-gray-200 ">
                <table class="min-w-full divide-y divide-gray-200">    
                    <thead class="border-b-1 border-gray-200 ">
                        <tr>
                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider ">Descripción</th>
                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td v-for="t in tipoTramite">
                                <div class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    {{ t.descripcion }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table> 
            </div>
        </div>

    </div>

</template>

<script>


export default {

    components:{

    },
    setup(){

    },

    data(){

        return{
            cant_opciones: 0,
            hora_limit: "",
            date_limit: "",
            startTime: "",
            tipoTramite: [],
        }
    },
    created(){
        this.getDiscapacidadData()
    },
    methods:{
		async getDiscapacidadData() {

            let response = await axios.get('masterdata.get_discapacidad_tipo_tramite')

		}
    },
}
</script>
