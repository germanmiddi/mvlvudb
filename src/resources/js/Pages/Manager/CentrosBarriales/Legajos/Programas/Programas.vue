<template>
    <!-- eslint-disable -->
    <ul v-if="!showDetail" role="list" class="grid gap-6 grid-cols-2 mt-10 px-4">
        <li v-for="programa in programas" :key="programa.email"
            class="col-span-1 bg-white rounded-lg shadow divide-y divide-gray-200">
            <div class="w-full flex items-center justify-between p-6 space-x-6">
                <div class="flex-1 truncate">
                    <div class="flex items-center space-x-3">
                        <h3 class="text-gray-900 text-base font-medium truncate">{{ programa.name }}</h3>
                        <span v-if="programa.role"
                            class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 text-xs font-medium bg-green-100 rounded-full">
                            {{ programa.role }}</span>
                    </div>
                    <p class="mt-1 text-gray-500 text-sm truncate">{{ programa.title }}</p>
                    <div class="mt-3">
                        <div class="flex text-sm">
                            <UserCircleIcon class="w-5 text-gray-300"/> <span class="ml-2">Valeria Perez</span>
                        </div>
                        <div class="flex text-sm mt-1">
                            <CalendarIcon class="w-5 text-gray-300"/><span class="ml-2">01/06/2024</span>
                        </div>
                    </div>
                </div>
                <!-- <img class="w-10 h-10 bg-gray-300 rounded-full flex-shrink-0" :src="programa.imageUrl" alt="" /> -->
            </div>
            <div>
                <div class="-mt-px flex divide-x divide-gray-200">
                    <div class="w-0 flex-1 flex">
                        <button @click="showDetail = !showDetail, showEditor = false"
                            class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                            <!-- <MailIcon class="w-5 h-5 text-gray-400" aria-hidden="true" /> -->
                            <span  class="ml-3">Detalle</span>
                        </button>
                    </div>
                    <div class="-ml-px w-0 flex-1 flex">
                        <button @click="showDetail = !showDetail, showEditor = true"
                            class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                            <!-- <PhoneIcon class="w-5 h-5 text-gray-400" aria-hidden="true" /> -->
                            <span class="ml-3">Interveción</span>
                        </button>
                    </div>
                </div>
            </div>
        </li>
    </ul>

    <div v-if="showDetail && !showEditor" aria-labelledby="message-heading"
        class="min-w-0 flex-1 h-full flex flex-col overflow-hidden xl:order-last mt-10 px-4">

        <div class="min-h-0 flex-1 overflow-y-auto">
            <div class="bg-white pt-5 pb-6 shadow mt-2 rounded-lg">
                <div class="px-4 sm:flex sm:justify-between sm:items-center sm:px-6 lg:px-8">
                    <div class="sm:w-0 sm:flex-1">
                        <h1 id="message-heading" class="text-lg font-medium text-gray-900">
                            {{ programaSelected.title }}
                        </h1>
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
                                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                        </svg>
                                        <div @click="showDetail = !showDetail"
                                            class="ml-1 text-sm font-medium text-gray-500 hover:text-gray-700" :aria-current="page.current ? 'page' : undefined">
                                            {{ page.name }}</div>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="mt-4 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <svg class="-ml-1 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                        {{ programaSelected.status }}</span>                            
                        <Menu as="div" class="ml-3 relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="-my-2 p-2 rounded-full bg-white flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                    <span class="sr-only">Open options</span>
                                    <Bars4Icon class="h-5 w-5" aria-hidden="true" />
                                </MenuButton>
                            </div>

                            <transition enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95">
                                <MenuItems
                                    class="z-50 origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="py-1">
                                        <MenuItem v-slot="{ active }">
                                            <button type="button" @click="showEditor = !showEditor"
                                                :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                                <span>Nueva Intervención</span>
                                            </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <button type="button"
                                                :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                                <span>Estado</span>
                                            </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <a href="#"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex justify-between px-4 py-2 text-sm']">
                                            <span>Asignar</span>
                                        </a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <a href="#"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex justify-between px-4 py-2 text-sm']">
                                            <span>Finalizar</span>
                                        </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </div>
            <!-- Thread section-->
            <ul role="list" class="py-4 space-y-2 sm:space-y-4 ">
                <li v-for="item in intervenciones" :key="item.id"
                    class="bg-white px-4 py-6 shadow sm:rounded-lg sm:px-6">
                    <!-- <div class="sm:flex sm:justify-between sm:items-baseline">
                        <h3 class="text-base font-medium">
                            <span class="text-gray-900">{{ item.user }}</span>
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 whitespace-nowrap sm:mt-0 sm:ml-3">
                            <time :datetime="item.datetime">{{ item.date }}</time>
                        </p>
                    </div> -->
                    <div class="flex space-x-3">
                        <div class="min-w-0 flex-1">
                          <h3 class="text-base font-medium text-gray-900">{{ item.user }}</h3>
                          <p class="text-sm text-gray-500">
                            <a href="#" class="hover:underline">
                              <time datetime="2020-12-08T18:02:00">28 Junio 2024 - 18:02 </time>
                            </a>
                          </p>
                        </div>
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <!-- <MenuButton class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"> -->
                                    <MenuButton class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Opciones
                                    <ChevronDownIcon class="-mr-1 ml-2 h-5 w-5" aria-hidden="true" />
                                </MenuButton>
                            </div>

                            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                <MenuItems class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
                                    <div class="py-1">
                                    <MenuItem v-slot="{ active }">
                                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                                        <PencilSquareIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                        Editar
                                        </a>
                                    </MenuItem>
                                    <!-- <MenuItem v-slot="{ active }">
                                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                                        <Bars4Icon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                        Duplicate
                                        </a>
                                    </MenuItem>
                                    </div>
                                    <div class="py-1">
                                    <MenuItem v-slot="{ active }">
                                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                                        <Bars4Icon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                        Archive
                                        </a>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                                        <Bars4Icon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                        Move
                                        </a>
                                    </MenuItem>
                                    </div>
                                    <div class="py-1">
                                    <MenuItem v-slot="{ active }">
                                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                                        <Bars4Icon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                        Share
                                        </a>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                                        <Bars4Icon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                        Add to favorites
                                        </a>
                                    </MenuItem> -->
                                    </div>
                                    <div class="py-1">
                                    <MenuItem v-slot="{ active }">
                                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                                        <TrashIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                        Borrar
                                        </a>
                                    </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                      </div>                    
                    <div class="mt-4 space-y-6 text-sm text-gray-800 mb-4 text-justify" v-html="item.content" />
                </li>
            </ul>
        </div>
    </div>

    <div v-if="showEditor" aria-labelledby="message-heading"
        class="min-w-0 flex-1 h-full flex flex-col overflow-hidden xl:order-last mt-10 px-4">

        <div class="min-h-0 flex-1 overflow-y-auto">
            <div class="bg-white pt-5 pb-6 shadow mt-2 rounded-lg">
                <div class="px-4 sm:flex sm:justify-between sm:items-center sm:px-6 lg:px-8">
                    <div class="sm:w-0 sm:flex-1">
                        <h1 id="message-heading" class="text-lg font-medium text-gray-900">
                            {{ programaSelected.title }}
                        </h1>
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
                                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                        </svg>
                                        <div @click="showDetail = !showDetail"
                                            class="ml-1 text-sm font-medium text-gray-500 hover:text-gray-700" :aria-current="page.current ? 'page' : undefined">
                                            {{ page.name }}</div>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="mt-4 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <svg class="-ml-1 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                        {{ programaSelected.status }}</span>                            
                        <Menu as="div" class="ml-3 relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="-my-2 p-2 rounded-full bg-white flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                    <span class="sr-only">Open options</span>
                                    <Bars4Icon class="h-5 w-5" aria-hidden="true" />
                                </MenuButton>
                            </div>

                            <transition enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95">
                                <MenuItems
                                    class="z-50 origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="py-1">
                                        <MenuItem v-slot="{ active }">
                                            <button type="button" @click="showEditor = true"
                                                :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                                <span>Nueva Intervención</span>
                                            </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <button type="button"
                                                :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                                <span>Estado</span>
                                            </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <a href="#"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex justify-between px-4 py-2 text-sm']">
                                            <span>Asignar</span>
                                        </a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <a href="#"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex justify-between px-4 py-2 text-sm']">
                                            <span>Finalizar</span>
                                        </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </div>

            <div class="shadow mt-2 rounded-lg">
                <div class="bg-white pt-5 pb-6 mt-2  px-4">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Detalle de la Intervención</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum, odit magnam.</p>
                    </div>            
                
                    <div class="grid grid-cols-3 gap-4 pt-5">
                        <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Fecha: </label>
                        <div class="mt-1 col-span-2">
                            <input type="text" name="first-name" id="first-name" autocomplete="given-name" 
                                class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-lg sm:text-sm border-gray-300 rounded-md" />
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-4 py-5">
                        <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Profesional: </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input type="text" name="first-name" id="first-name" autocomplete="given-name" 
                                class="w-full block shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-lg sm:text-sm border-gray-300 rounded-md" />
                        </div>
                    </div>
                    <QuillEditor theme="snow"/>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-end">
                    <button @click="showEditor = false" type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">Cancelar</button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                </div>

            </div>

        </div>
    </div>

</template>

<script>
import { PhoneIcon, 
         Bars4Icon, 
         HomeIcon, 
         EllipsisVerticalIcon, 
         ChevronDownIcon, 
         TrashIcon, 
         PencilSquareIcon,
         UserCircleIcon,
         CalendarIcon } from '@heroicons/vue/24/solid'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'

import ProgramasGrid from './ProgramasGrid.vue'

import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const programaSelected = {
    title: "Psicopedagogía",
    status: "Activo"
}
const programas = [
    {
        name: 'Familias',
        title: 'Regional Paradigm Technician',
        role: 'Activo',
        email: 'janecooper@example.com',
        telephone: '+1-202-555-0170',
        imageUrl:
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
    },
    {
        name: '1000 días',
        title: 'Regional Paradigm Technician',
        role: 'Activo',
        email: 'janecooper@example.com',
        telephone: '+1-202-555-0170',
        imageUrl:
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
    },
    {
        name: 'Vivamos sin violencia',
        title: 'Regional Paradigm Technician',
        role: 'Activo',
        email: 'janecooper@example.com',
        telephone: '+1-202-555-0170',
        imageUrl:
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
    },
    {
        name: 'Prevención del delito infanto juvenil',
        title: 'Regional Paradigm Technician',
        role: 'Activo',
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
        ProgramasGrid
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