<template>
    <main class="flex-1">
        <!-- Page title & actions -->
        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Dashboard | Centros Barriales Juventud</h1>
            </div>
            <div v-if="formImport" class="mt-4 flex sm:mt-0 sm:ml-4">
                <!-- <button type="button" class="order-1 ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:order-0 sm:ml-0">Share</button> -->
                <input @change="handleFileChange" accept=".jpg, .jpeg, .png, .gif, .pdf, .doc, .docx, .xls, .xlsx"
                    type="file" name="file" id="file" ref="inputfile" autocomplete="off"
                    class="mr-2 block w-full h-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" />

                <select v-model="sede_id" id="sede_id" name="sede_id" autocomplete="off"
                    class="block w-full px-4 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" disabled>Seleccione una sede</option>
                    <option v-for="item in sedes" :key="item.id" :value="item.id">{{
                        item.description
                        }}</option>

                </select>

                <a @click="importFile()" v-if="!processImport"
                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Importar</a>

                <a v-else
                    class="border-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">
                    <ArrowPathIcon class="h-5 w-5 text-red-500 animate-spin mr-2" /> Procesando...
                </a>

                <a @click="formImport = false"
                    class="order-0 inline-flex items-center px-4 py-2 border border-red-700 shadow-sm text-sm font-medium rounded-md text-red-700 hover:text-white hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:order-1 sm:ml-3">Cancelar</a>
            </div>
            <div v-else class="mt-4 flex sm:mt-0 sm:ml-4">
                <a :href="route('inscripcionCBJ.create')"
                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Inscripción</a>

                <a @click="formImport = true" v-show="store.userCan('ALL-ADM', $page.props.userGroups)"
                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:order-1 sm:ml-3">Importar</a>
            </div>
        </div>
        <div v-if="status" class="px-4 mt-6 sm:px-6 lg:px-8">
            <button type="button" @click="this.status = ''"
                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-red-200 text-red-900 hover:bg-red-600 hover:text-white">
                Cerrar resultado
            </button>
            <div class="px-4 mt-6 sm:px-6 lg:px-8 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md"
                role="alert" v-html="status">
            </div>
        </div>
        <!-- Pinned projects -->
        <div class="px-4 mt-6 sm:px-6 lg:px-8">
            <h2 class="text-gray-500 text-xs font-medium uppercase tracking-wide">Sedes</h2>
            <ul role="list" class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2 xl:grid-cols-2 mt-3">
                <li v-for="project in data" :key="project.id" class="relative col-span-1 flex shadow-sm rounded-md">
                    <div :class="[project.bgColorClass, 'flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md']">{{ project.initials }}
                    </div>
                    <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                        <div class="flex flex-col px-4 py-2 text-sm truncate">
                            <a class="text-gray-900 font-medium hover:text-gray-600">
                                {{ project.title }}
                            </a>
                            <p class="text-gray-400">{{project.totalInscripciones}} Inscripciones</p>
                            <a :href="route('legajoCB')" class="text-gray-500 hover:underline hover:text-gray-700">Ver Inscripciones</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </main>
</template>

<script>
import { ref } from 'vue'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { ChevronRightIcon, EllipsisVerticalIcon } from '@heroicons/vue/24/solid'
import Toast from "@/Layouts/Components/Toast.vue"
import store from '@/store.js'

const projects = [

    {
        id: 1,
        title: 'La Loma',
        initials: 'LL',
        bgColorClass: 'bg-red-600',
        route: '#',
        //module: 'CBI'
    },
    {
        id: 2,
        title: 'El Ceibo',
        initials: 'EC',
        bgColorClass: 'bg-yellow-600',
        route: '#',
        //module: 'CBJ'
    },
    {
        id: 5,
        title: 'Munro',
        initials: 'MUN',
        bgColorClass: 'bg-pink-600',
        route: '#',
        //module:'DIS'
    },
    {
        id: 6,
        title: 'Villa Martelli',
        initials: 'VM',
        bgColorClass: 'bg-green-600',
        route: '#',
        //module: 'ENT'
    }

    // More projects...
    ]
const pinnedProjects = projects.filter((project) => project.pinned)

export default {
    props: {
        sedes: Object
    },
    components:{
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        EllipsisVerticalIcon,
        ChevronRightIcon,
        Toast
    },
    data() {
        return {
            data: "",            
            sede_id: '',
            formImport: false,
            processImport: false,
            file: '',
            /* MENSAJERIA */
			toastMessage: "",
            labelType: "info",
            message: "",
            showToast: false,
            status: '',
        };
    },

    setup() {
       const sidebarOpen = ref(false)

      return {
        projects,
        pinnedProjects,
        sidebarOpen,
        store
      }
    },
    methods: {
        clearMessage() {
            this.toastMessage = "";
        },
        async getStatistics(link) {

            const get = `${route('dashboard.cbj')}`

            const response = await fetch(get, { method: "GET" });
            let tramites = await response.json();
            this.data = this.projects
            this.data.forEach(element => {

                const dat = tramites.find((objeto) => objeto.sede_id === element.id);
                  if(dat){
                      element.totalInscripciones = dat.total
                  }else{
                      element.totalInscripciones = 0
                  }

            });
        },
        async importFile() {
            if (this.file != '') {
                if(this.sede_id != ''){
                    this.status = ''
                    this.processImport = true
                    this.status = ''
                    let rt = route("import.juventudCB");
                    const formData = new FormData();
                    formData.append('file', this.file);
                    formData.append('sede_id', this.sede_id);
                    try {
                        const response = await axios.post(rt, formData);
                        if (response.status == 200) {
                            this.labelType = "success";
                            this.toastMessage = response.data.message;
                            this.status = response.data.status;
                            this.getTramites();
                        } else {
                            this.labelType = "danger";
                            this.toastMessage = response.data.message;
                        }
                    } catch (error) {
                        console.log(error);
                    }
                    this.processImport = false
                }else{
                    this.labelType = "info";
                    this.toastMessage = "Debe seleccionar una sede";
                }
            } else {
                this.labelType = "info";
                this.toastMessage = "Debe seleccionar un archivo";
            }
        },
        handleFileChange(event) {
            this.file = event.target.files[0];
        },
    },
    mounted() {
        this.getStatistics()
    }


}
</script>

<style>

</style>
