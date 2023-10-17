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
            }
        },

        computed: {
            selectedItem() {
                return this.subNavigation[this.selectedIndex];
            }
        }
    }
    </script>