<template>
    <div class="min-h-screen flex flex-col">
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

        <main class="flex-1 max-w-7xl mx-auto pb-10 lg:py-12 lg:px-8 w-full">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5 h-[calc(100vh-10rem)] ">
                <aside :class="[
                    'py-6 px-2 sm:px-6 lg:py-0 lg:px-0 transition-all duration-300 ease-in-out relative',
                    isAsideCollapsed ? 'lg:col-span-1' : 'lg:col-span-3'
                ]">
                    <!-- Botón toggle -->
                    <button @click="toggleAside"
                            class="absolute top-2 right-2 p-1 rounded-full hover:bg-gray-200 transition-colors duration-200 z-10">
                        <ChevronLeftIcon v-if="!isAsideCollapsed" class="w-5 h-5" />
                        <ChevronRightIcon v-else class="w-5 h-5" />
                    </button>

                    <nav class="space-y-1">
                        <a v-for="(item, index) in subNavigation" :key="item.name" @click.prevent="selectItem(index)"
                            :class="[
                                selectedIndex === index ? 'bg-gray-50 text-indigo-600 hover:bg-white' : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50',
                                'group rounded-md px-3 py-2 flex items-center text-sm font-medium cursor-pointer transition-all duration-200'
                            ]">
                            <component :is="item.icon" class="w-5 h-5 flex-shrink-0" />
                            <span v-if="!isAsideCollapsed" class="ml-3 truncate">{{ item.name }}</span>
                        </a>
                    </nav>
                </aside>
                <div :class="[
                    'space-y-6 px-2 pt-2 h-full overflow-y-auto transition-all duration-300 ease-in-out',
                    isAsideCollapsed ? 'lg:col-span-11' : 'lg:col-span-9'
                ]">
                    <component :is="selectedItem.componentName" :data="selectedItem.componentData"
                        :name="selectedItem.name" :dependencia_id="selectedItem.dependencia_id"
                        @toast-message="setMessage" />
                </div>
            </div>
        </main>
    </div>
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
import CentrosBarriales from './CentrosBarriales.vue';
import ProgramasSociales from './ProgramasSociales.vue';
import EscuelasGeneral from './EscuelasGeneral/EscuelasGeneral.vue';
import ModuloCajas from './ModuloCajas/ModuloCajas.vue';
import {
    ChevronLeftIcon,
    ChevronRightIcon,
    BuildingOfficeIcon,
    UserGroupIcon,
    UsersIcon,
    HeartIcon,
    BuildingLibraryIcon,
    HandRaisedIcon,
    SparklesIcon,
    HomeModernIcon,
    FaceSmileIcon,
    UserIcon,
    HomeIcon,
    DocumentTextIcon,
    ArchiveBoxIcon
} from '@heroicons/vue/24/outline';

const subNavigation = [
    { dependencia_id: 0, name: 'Centros Barriales', componentName: 'CentrosBarriales', icon: BuildingOfficeIcon },
    { dependencia_id: 12, name: 'Centros Barriales Infancia', componentName: 'Cbi', icon: UserGroupIcon },
    { dependencia_id: 13, name: 'Centros Barriales Juventud', componentName: 'Cbj', icon: UsersIcon },
    { dependencia_id: 2, name: 'Discapacidad', componentName: 'Discapacidad', icon: HeartIcon },
    { dependencia_id: 3, name: 'Entidades', componentName: 'Entidades', icon: BuildingLibraryIcon },
    { dependencia_id: 5, name: 'Fortalecimiento Comunitario', componentName: 'Fortalecimiento', icon: HandRaisedIcon },
    { dependencia_id: 6, name: 'Género y Diversidad', componentName: 'Genero', icon: SparklesIcon },
    { dependencia_id: 7, name: 'Hábitat', componentName: 'Habitat', icon: HomeModernIcon },
    { dependencia_id: 8, name: 'Niñez y Adolescencia', componentName: 'Ninez', icon: FaceSmileIcon },
    { dependencia_id: 14, name: 'Personas Mayores', componentName: 'Mayores', icon: UserIcon },
    { dependencia_id: 11, name: 'Vivienda social', componentName: 'Vivienda', icon: HomeIcon },
    { dependencia_id: 0, name: 'Programas Sociales', componentName: 'ProgramasSociales', icon: DocumentTextIcon },
    { dependencia_id: 0, name: 'Módulo Cajas de Alimentos', componentName: 'ModuloCajas', icon: ArchiveBoxIcon },
    // { dependencia_id: 0, name: 'Escuelas General', componentName: 'EscuelasGeneral' },

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
        Vivienda,
        CentrosBarriales,
        ProgramasSociales,
        EscuelasGeneral,
        ModuloCajas,
        ChevronLeftIcon,
        ChevronRightIcon,
        BuildingOfficeIcon,
        UserGroupIcon,
        UsersIcon,
        HeartIcon,
        BuildingLibraryIcon,
        HandRaisedIcon,
        SparklesIcon,
        HomeModernIcon,
        FaceSmileIcon,
        UserIcon,
        HomeIcon,
        DocumentTextIcon,
        ArchiveBoxIcon,
    },

    setup() {
        return {
            subNavigation
        }
    },

    data() {

        return {
            toastMessage: "",
            labelType: "info",
            selectedIndex: 0,
            isAsideCollapsed: false

        }
    },
    mounted() {
        // Cargar estado del aside desde localStorage
        const savedState = localStorage.getItem('asideCollapsed');
        if (savedState !== null) {
            this.isAsideCollapsed = JSON.parse(savedState);
        }
    },
    watch: {

    },
    methods: {
        clearMessage() {
            this.toastMessage = "";
        },
        selectItem(index) {
            this.selectedIndex = index;
        },
        setMessage(message) {
            this.toastMessage = message.message;
            this.labelType = message.type;
        },
        toggleAside() {
            this.isAsideCollapsed = !this.isAsideCollapsed;
            localStorage.setItem('asideCollapsed', JSON.stringify(this.isAsideCollapsed));
        }
    },

    computed: {
        selectedItem() {
            return this.subNavigation[this.selectedIndex];
        }
    }
}
</script>
