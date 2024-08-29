<template>
        <div aria-labelledby="message-heading"
        class="min-w-0 flex-1 h-full flex flex-col overflow-hidden xl:order-last mt-10 px-4">
        <div class="min-h-0 flex-1 overflow-y-auto">
            <div class="bg-white pt-5 pb-6 shadow mt-2 rounded-lg">
                <div class="px-4 sm:flex sm:justify-between sm:items-center sm:px-6 lg:px-8">
                    <div class="sm:w-0 sm:flex-1">
                        <nav class="flex mt-1" aria-label="Breadcrumb">
                            <ol role="list" class="flex items-center space-x-2 text-xs">
                                <li>
                                    <div>
                                        <a href="#" class="text-gray-400 hover:text-gray-500">
                                            <HomeIcon class="flex-shrink-0 h-5 w-5" aria-hidden="true" />
                                            <span class="sr-only">Home</span>
                                        </a>
                                    </div>
                                </li>
                                <li v-for="page in pages" :key="page.name">
                                    <div class="flex items-center">
                                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"
                                            aria-hidden="true">
                                            <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                        </svg>
                                        <div class="ml-1 text-sm font-medium text-gray-500 hover:text-gray-700"
                                            :aria-current="page.current ? 'page' : undefined">
                                            {{ page.name }}</div>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div
                        class="mt-4 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                        <button type="submit" v-if="!this.showEditor" @click="showEditor = true"
                            class="inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Nueva
                            Actividad</button>
                        <button type="submit" v-else @click="showEditor = false"
                            class="inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancelar</button>
                    </div>
                </div>
            </div>

    <ul v-if="!showDetail" role="list" class="grid gap-6 grid-cols-2 mt-10">
        <li v-for="actividad in legajo[0].actividades" :key="actividad.key"
            class="col-span-1 bg-white rounded-lg shadow divide-y divide-gray-200">
            <ActividadesGrid :actividad="actividad" />
        </li>
    </ul>
</div>
</div>

</template>

<script>
import {
    PhoneIcon,
    Bars4Icon,
    HomeIcon,
    EllipsisVerticalIcon,
    ChevronDownIcon,
    TrashIcon,
    PencilSquareIcon,
    UserCircleIcon,
    CalendarIcon
} from '@heroicons/vue/24/solid'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'

import ActividadesGrid from './ActividadesGrid.vue'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const programaSelected = {
    title: "Psicopedagogía",
    status: "Activo"
}
const programas = [
    {
        name: 'Ajedrez',
        title: 'Regional Paradigm Technician',
        role: null,
        email: 'janecooper@example.com',
        telephone: '+1-202-555-0170',
        imageUrl:
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
    },
    {
        name: 'Futbol',
        title: 'Regional Paradigm Technician',
        role: 'Activo',
        email: 'janecooper@example.com',
        telephone: '+1-202-555-0170',
        imageUrl:
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
    },
    {
        name: 'Tecnología',
        title: 'Regional Paradigm Technician',
        role: 'Activo',
        email: 'janecooper@example.com',
        telephone: '+1-202-555-0170',
        imageUrl:
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
    },
    {
        name: 'Karate',
        title: 'Regional Paradigm Technician',
        role: null,
        email: 'janecooper@example.com',
        telephone: '+1-202-555-0170',
        imageUrl:
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
    },
    // More people...
]


const intervenciones = [
    //build faker
    {
        user: 'John Doe',
        content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet accumsan arcu. Nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla.',
        date: '01/06/2024'
    },
    {
        user: 'John Doe',
        content: 'Lorem ipsum dolor sit amet.<br> Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla.',
        date: '01/06/2024'
    },
    {
        user: 'John Doe',
        content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet accumsan arcu. Nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. <br>Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla. Nullam nec nunc nec nulla sit amet turpis tincidunt fringilla.',
        date: '01/06/2024'
    },

]

const pages = [
    { name: 'Legajo', href: '#', current: false },
    { name: 'Actividades', href: '#', current: true },
]
export default {
    props: {
        legajo: Object,
    },
    components: {
        PhoneIcon,
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        Bars4Icon,
        HomeIcon,
        EllipsisVerticalIcon,
        ChevronDownIcon,
        TrashIcon,
        PencilSquareIcon,
        UserCircleIcon,
        CalendarIcon,
        QuillEditor,
        ActividadesGrid
    },

    setup() {
        return {
            programas,
            programaSelected,
            intervenciones,
            pages
        }
    },
    data() {
        return {
            showDetail: false,
            showEditor: false
        }
    }
}
</script>
<style scope>
.ql-toolbar {
    border-radius: 15px 15px 0px 0px;
}

.ql-container {
    border-radius: 0px 0px 15px 15px;
    height: 300px;
}
</style>
