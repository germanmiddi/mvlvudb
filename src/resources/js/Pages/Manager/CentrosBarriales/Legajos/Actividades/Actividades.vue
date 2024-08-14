<template>
    <ul v-if="!showDetail" role="list" class="grid gap-6 grid-cols-2 mt-10 px-4">
        <li v-for="actividad in legajo[0].actividades" :key="actividad.key"
            class="col-span-1 bg-white rounded-lg shadow divide-y divide-gray-200">
            <ActividadesGrid :actividad="actividad" />
        </li>
    </ul>
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
    { name: 'Programas', href: '#', current: true },
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
