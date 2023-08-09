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
                    <component :is="selectedItem.componentName" :data="selectedItem.componentData" />
                </div>
            </div>
        </main>


        <!-- <div class="px-4 mt-6 sm:px-6 lg:px-8">


        </div>


        <div class="flex flex-col mt-8 mx-4 sm:mx-6 lg:mx-8">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">


                    </div>
                </div>
            </div>
        </div> -->
    </main>




    <!-- 
        <AppLayout>
            <template #content>
                <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>
    
                <main class="max-w-7xl mx-auto pb-10 lg:py-12 lg:px-8">
                    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                        <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">
                            <nav class="space-y-1">
                                <a v-for="(item,index) in subNavigation" :key="item.name" @click.prevent="selectItem(index)"
                                    :class="[selectedIndex === index ? 'bg-gray-50 text-indigo-600 hover:bg-white' : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50', 'group rounded-md px-3 py-2 flex items-center text-sm font-medium cursor-pointer']">
                                    <component :is="item.icon" :class="[selectedIndex === index ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500', 'flex-shrink-0 -ml-1 mr-3 h-6 w-6']" aria-hidden="true" />
                                    <span class="truncate">{{ item.name }}</span>
                                </a>
                            </nav>
                        </aside>
                
                        
                        <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
                            <component :is="selectedItem.componentName" :data="selectedItem.componentData" />
                        </div>
                    </div>
                </main>
    
            </template>
        </AppLayout> -->
    
    </template>
    
    
    <script>
    // import AppLayout from '@/Layouts/AppLayout.vue';
    import Toast from '@/Layouts/Components/Toast.vue'
    import Discapacidad from './Discapacidad.vue';
    // import Turnos from './Turnos.vue';
    // import Whatsapp from './Whatsapp.vue';
    // import Mensajes from './Mensajes.vue';
    // import Chatbot from './Chatbot.vue';
    
    
    const subNavigation = [
        // { name: 'General', componentName: 'General' },
        { name: 'Discapacidad',  componentName: 'Discapacidad' },
        // { name: 'Género y Diversidad',componentName: 'Genero' },
        // { name: 'Habitat',  componentName: 'Habitat' },
        // { name: 'Niñez y Adolescencia', componentName: 'Ninez' },
        
    ]
    
    export default {
        props: {
            toast: Object,
        },
    
        components: {
            // AppLayout,
            Toast,
            Discapacidad,
            // Turnos,
            // Whatsapp,
            // Mensajes,
            // Chatbot
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
          selectItem(index) {
            this.selectedIndex = index;
          }
        },
        computed: {
          selectedItem() {
            return this.subNavigation[this.selectedIndex];
          }
        }
    }
    </script>