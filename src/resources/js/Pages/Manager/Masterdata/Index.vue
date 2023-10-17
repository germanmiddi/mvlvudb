<template>
    <main class="flex-1">
        <!-- Page title & actions -->


        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Datos Maestros
                </h1>
            </div>
            <div class="mt-4 flex sm:mt-0 sm:ml-4">
                <button
					class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3"
					@click="exportDatos">
					Exportar Datos
				</button>
            </div>
        </div>

        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

        <main class="max-w-7xl mx-auto pb-10 lg:py-12 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">
                    <nav class="space-y-1">
                        <a v-for="(item,index) in subNavigation" :key="item.name" @click.prevent="selectItem(index)"
                            :class="[selectedIndex === index ? 'bg-gray-50 text-indigo-600 hover:bg-white' : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50', 'group rounded-md px-3 py-2 flex items-center text-sm font-medium cursor-pointer']">
                            <span class="truncate">{{ item.name }}</span>
                        </a>
                    </nav>
                </aside>
        
                
                <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
                    <component :is="selectedItem.componentName" 
                               :data="selectedItem.componentData" 
                               :name="selectedItem.name"
                               :dependencia_id="selectedItem.dependencia_id"
                               @toast-message="setMessage"/>
                </div>
            </div>
        </main>
    </main>    

    </template>
    
    
    <script>
    import Toast from '@/Layouts/Components/Toast.vue'
    import Cbi from './Cbi.vue';
    import Cbj from './Cbj.vue';
    import Discapacidad from './Discapacidad.vue';
    import Entidades from './Entidades.vue';
    import Fortalecimiento from './Fortalecimiento.vue';
    import Genero from './Genero.vue';
    import Habitat from './Habitat.vue';
    import Ninez from './Ninez.vue';
    import Mayores from './Mayores.vue';
    import Vivienda from './Vivienda.vue';
    
    const subNavigation = [
        { dependencia_id:12 , name: 'Centros Barriales Infancia', componentName: 'Cbi'},
        { dependencia_id:13 , name: 'Centros Barriales Juventud', componentName: 'Cbj'},
        { dependencia_id:2 ,  name: 'Discapacidad', componentName: 'Discapacidad'},
        { dependencia_id:3 ,  name: 'Entidades', componentName: 'Entidades'},
        { dependencia_id:5 ,  name: 'Fortalecimiento Comunitario', componentName: 'Fortalecimiento'},
        { dependencia_id:6 ,  name: 'Género y Diversidad', componentName: 'Genero'},
        { dependencia_id:7 ,  name: 'Hábitat', componentName: 'Habitat'},
        { dependencia_id:8 ,  name: 'Niñez y Adolescencia', componentName: 'Ninez'},
        { dependencia_id:14 , name: 'Personas Mayores', componentName: 'Mayores'},
        { dependencia_id:11 , name: 'Vivienda social', componentName: 'Vivienda'},
        
    ]
    
    export default {
        props: {
            toast: Object,
        },
    
        components: {
            // AppLayout,
            Toast,
            Cbi,
            Cbj,
            Discapacidad,
            Entidades,
            Fortalecimiento,
            Genero,
            Habitat,
            Ninez,
            Mayores,
            Vivienda
        },
    
        setup() {
            return{
                subNavigation
            }
        },
    
        data() {
    
            return {
                toastMessage: "",
                labelType:    "info",
                selectedIndex: 0
            
            }
        },
        watch: {
    
        },
    
        created() {
    
        },

        methods: {
            clearMessage() {
                this.toastMessage = "";
            },            
            selectItem(index) {
                this.selectedIndex = index;
            },
            setMessage(message){
                this.toastMessage = message.message;
                this.labelType = message.type;
            },
            async exportDatos() {

                this.processReport = true
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
                    a.download = 'Datos Maestros.xlsx'; // Nombre del archivo
                    a.style.display = 'none';

                    // Agregar el enlace al cuerpo del documento y hacer clic en él
                    document.body.appendChild(a);
                    a.click();

                    // Liberar la URL del objeto después de la descarga
                    window.URL.revokeObjectURL(url);
                } catch (error) {
                    console.error(error);
                }
                this.processReport = false
                }
        },

        computed: {
            selectedItem() {
                return this.subNavigation[this.selectedIndex];
            }
        }
    }
    </script>