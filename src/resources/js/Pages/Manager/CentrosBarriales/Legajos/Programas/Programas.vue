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
                        <button type="submit" v-if="this.showList" @click="showView('new_programa')"
                            class="inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Nuevo
                            Programa</button>
                        <button type="submit" v-if="this.showCreate" @click="showView('init')"
                            class="inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancelar</button>
                        <Menu v-if="this.showDetail" as="div" class="ml-3 relative inline-block text-left">
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
                                        <button type="button" @click="this.showView('new_intervencion')"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                            <span>Nueva Intervención</span>
                                        </button>
                                        </MenuItem>
                                        <!-- <MenuItem v-slot="{ active }">
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
                                        </MenuItem> -->
                                        <MenuItem v-slot="{ active }">
                                        <a @click="showView('init')"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex justify-between px-4 py-2 text-sm']">
                                            <span>Cancelar</span>
                                        </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                        <!--  <button type="submit" v-else @click="showEditor = false"
                            class="inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancelar</button> -->
                    </div>
                </div>
            </div>

            <div class="bg-white pt-5 pb-2 shadow mt-2 rounded-lg" v-if="showDetail">
                <div class="w-full flex items-center justify-between p-6 space-x-6">
                    <div class="flex-1 truncate">
                        <div class="flex items-center space-x-3">
                            <h3 class="text-gray-900 text-base font-medium truncate">{{
                                this.programaSelected?.programa_social?.description ?? '-' }}</h3>
                        </div>
                        <p class="mt-1 text-gray-500 text-xs truncate">Estado: <span
                                class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 text-xs font-medium bg-green-100 rounded-full">
                                {{ this.programaSelected?.estado?.description }}</span></p>
                        <div class="mt-3">
                            <div class="flex text-sm">
                                <UserCircleIcon class="w-5 text-gray-300" /> <span class="ml-2">{{
                                    store.capitalize(this.programaSelected?.profesional?.name ?? '-') }}</span>
                            </div>
                            <div class="flex text-sm mt-1">
                                <CalendarIcon class="w-5 text-gray-300" /><span class="ml-2">{{
                                    store.dateTimeFormateada(this.programaSelected?.fecha_inscripcion) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white pt-5 pb-2 shadow mt-2 rounded-lg" v-if="this.showCreate">
                <div class="bg-white pt-5 pb-6 mt-2  px-4">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Alta de Programa</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Ingrese un nuevo programa asociado al legajo.
                        </p>
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-5">
                        <label for="first-name"
                            class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Programa Social:
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select v-model="form.programa_social_id" id="programa_social_id" name="programa_social_id"
                                autocomplete="off" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled>
                                    Seleccione un Programa
                                </option>
                                <option v-for="a in programasSociales" :key="a.id" :value="a.id">
                                    {{ a.description ?? '' }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-5">
                        <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Fecha:
                        </label>
                        <div class="mt-1 col-span-2">
                            <Datepicker
                                class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                v-model="form.fecha_inscripcion" :disabled="input_disable"
                                :class="input_disable ? bg_disable : ''" :enableTimePicker="false"
                                :monthChangeOnScroll="false" autoApply :format="format">
                            </Datepicker>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-5 pb-5">
                        <label for="first-name"
                            class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Profesional:
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select v-model="form.profesional_id" id="profesional_id" name="profesional_id"
                                autocomplete="off" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled>
                                    Seleccione un Profesional
                                </option>
                                <option v-for="p in users" :key="p.id" :value="p.id">
                                    {{ p.name ?? '' }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-end">
                    <button @click="showView('init'), this.form = {}" type="button"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">Cancelar</button>
                    <button @click="storePrograma()"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                </div>
            </div>

            <ul role="list" class="py-4 space-y-2 sm:space-y-4 " v-if="this.showDetail">
                <li v-for="item in this.programaSelected.intervenciones" :key="item.id"
                    class="bg-white px-4 py-6 shadow sm:rounded-lg sm:px-6">
                    <div class="flex space-x-3">
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base font-medium text-gray-900">{{ item.profesional?.name ?? '-' }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                <time datetime="2020-12-08T18:02:00">{{ store.dateFormateada(item.fecha) }}
                                </time>
                            </p>
                        </div>
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Opciones
                                    <ChevronDownIcon class="-mr-1 ml-2 h-5 w-5" aria-hidden="true" />
                                </MenuButton>
                            </div>

                            <transition enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95">
                                <MenuItems
                                    class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
                                    <div class="py-1">
                                        <MenuItem v-slot="{ active }">
                                        <a href="#"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                                            <PencilSquareIcon
                                                class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                                aria-hidden="true" />
                                            Editar
                                        </a>
                                        </MenuItem>
                                    </div>
                                    <div class="py-1">
                                        <MenuItem v-slot="{ active }">
                                        <a href="#"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                                            <TrashIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                                aria-hidden="true" />
                                            Borrar
                                        </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                    <div class="mt-4 space-y-6 text-sm text-gray-800 mb-4 text-justify"
                        v-html="item.description ?? '-'" />
                </li>
            </ul>

            <div class="bg-white pt-5 pb-2 shadow mt-2 rounded-lg" v-if="this.showIntervencion">
                <div class="bg-white pt-5 pb-6 mt-2  px-4">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Alta de Nueva intervención</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Ingrese un nuevo detalle de la intervención.
                        </p>
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-5">
                        <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Fecha:
                        </label>
                        <div class="mt-1 col-span-2">
                            <Datepicker
                                class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                v-model="form.fecha_intervencion" :disabled="input_disable"
                                :class="input_disable ? bg_disable : ''" :enableTimePicker="false"
                                :monthChangeOnScroll="false" autoApply :format="format">
                            </Datepicker>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 py-5">
                        <label for="first-name"
                            class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Profesional:
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select v-model="form.profesional_id" id="profesional_id" name="profesional_id"
                                autocomplete="off" :class="input_disable ? bg_disable : ''" :disabled="input_disable"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled>
                                    Seleccione un Profesional
                                </option>
                                <option v-for="p in users" :key="p.id" :value="p.id">
                                    {{ p.name ?? '' }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <QuillEditor theme="snow" ref="editor" v-model:content="form.description" content-type="html" />

                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-end">
                    <button @click="showView('detail'), this.form = {}" type="button"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">Cancelar</button>
                    <button @click="storeIntervencion()"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                </div>
            </div>

            <!-- eslint-disable -->
            <ul v-if="showList" role="list" class="grid gap-6 grid-cols-2 mt-10">
                <li v-for="programa in legajo[0].programas_sociales" :key="programa.key"
                    class="col-span-1 bg-white rounded-lg shadow divide-y divide-gray-200">
                    <ProgramasGrid :programa="programa" @fnEditor="fnEditor" />
                </li>
            </ul>


            <!--  <div v-if="showDetail && !showEditor" aria-labelledby="message-heading"
                class="min-w-0 flex-1 h-full flex flex-col overflow-hidden xl:order-last mt-10 px-4">
                <div class="min-h-0 flex-1 overflow-y-auto">
                    <div class="bg-white pt-5 pb-6 shadow mt-2 rounded-lg">
                        <div class="px-4 sm:flex sm:justify-between sm:items-center sm:px-6 lg:px-8">
                            <div class="sm:w-0 sm:flex-1">
                                <h1 id="message-heading" class="text-lg font-medium text-gray-900">
                                    Programa: {{ this.programaSelected.programa_social.description ?? '' }}
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
                                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300"
                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 20 20" aria-hidden="true">
                                                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                                </svg>
                                                <div @click="showDetail = !showDetail"
                                                    class="ml-1 text-sm font-medium text-gray-500 hover:text-gray-700"
                                                    :aria-current="page.current ? 'page' : undefined">
                                                    {{ page.name }}</div>
                                            </div>
                                        </li>
                                    </ol>
                                </nav>
                            </div>

                            <div
                                class="mt-4 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                                <span
                                    class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="-ml-1 mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                        viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    {{ this.programaSelected.estado.description ?? '' }}</span>
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
                 
                    <ul role="list" class="py-4 space-y-2 sm:space-y-4 ">
                        <li v-for="item in this.programaSelected.intervenciones" :key="item.id"
                            class="bg-white px-4 py-6 shadow sm:rounded-lg sm:px-6">
                            <div class="flex space-x-3">
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-base font-medium text-gray-900">{{ item.profesional?.name ?? '-' }}
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        <time datetime="2020-12-08T18:02:00">{{ store.dateFormateada(item.fecha) }}
                                        </time>
                                    </p>
                                </div>
                                <Menu as="div" class="relative inline-block text-left">
                                    <div>
                                        <MenuButton
                                            class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Opciones
                                            <ChevronDownIcon class="-mr-1 ml-2 h-5 w-5" aria-hidden="true" />
                                        </MenuButton>
                                    </div>

                                    <transition enter-active-class="transition ease-out duration-100"
                                        enter-from-class="transform opacity-0 scale-95"
                                        enter-to-class="transform opacity-100 scale-100"
                                        leave-active-class="transition ease-in duration-75"
                                        leave-from-class="transform opacity-100 scale-100"
                                        leave-to-class="transform opacity-0 scale-95">
                                        <MenuItems
                                            class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
                                            <div class="py-1">
                                                <MenuItem v-slot="{ active }">
                                                <a href="#"
                                                    :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                                                    <PencilSquareIcon
                                                        class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                                        aria-hidden="true" />
                                                    Editar
                                                </a>
                                                </MenuItem>
                                            </div>
                                            <div class="py-1">
                                                <MenuItem v-slot="{ active }">
                                                <a href="#"
                                                    :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                                                    <TrashIcon
                                                        class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                                        aria-hidden="true" />
                                                    Borrar
                                                </a>
                                                </MenuItem>
                                            </div>
                                        </MenuItems>
                                    </transition>
                                </Menu>
                            </div>
                            <div class="mt-4 space-y-6 text-sm text-gray-800 mb-4 text-justify"
                                v-html="item.description ?? '-'" />
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
                                    {{ this.programaSelected.programa_social.description ?? '' }}
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
                                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300"
                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 20 20" aria-hidden="true">
                                                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                                </svg>
                                                <div @click="showDetail = !showDetail"
                                                    class="ml-1 text-sm font-medium text-gray-500 hover:text-gray-700"
                                                    :aria-current="page.current ? 'page' : undefined">
                                                    {{ page.name }}</div>
                                            </div>
                                        </li>
                                    </ol>
                                </nav>
                            </div>

                            <div
                                class="mt-4 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                                <span
                                    class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="-ml-1 mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                        viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    {{ this.programaSelected.estado.description ?? '' }}</span>
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

                    <div class="shadow mt-2 rounded-lg">
                        <div class="bg-white pt-5 pb-6 mt-2  px-4">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Detalle de la Intervención</h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">Lorem ipsum dolor sit amet consectetur
                                    adipisicing elit. Ipsum, odit magnam.</p>
                            </div>

                            <div class="grid grid-cols-3 gap-4 pt-5">
                                <label for="first-name"
                                    class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Fecha:
                                </label>
                                <div class="mt-1 col-span-2">
                                    <Datepicker
                                        class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        v-model="form.fecha_intervencion" :disabled="input_disable"
                                        :class="input_disable ? bg_disable : ''" :enableTimePicker="false"
                                        :monthChangeOnScroll="false" autoApply :format="format">
                                    </Datepicker>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 py-5">
                                <label for="first-name"
                                    class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Profesional:
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <select v-model="form.profesional_id" id="profesional_id" name="profesional_id"
                                        autocomplete="off" :class="input_disable ? bg_disable : ''"
                                        :disabled="input_disable"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="" disabled>
                                            Seleccione un Profesional
                                        </option>
                                        <option v-for="p in users" :key="p.id" :value="p.id">
                                            {{ p.name ?? '' }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <QuillEditor theme="snow" ref="editor" v-model:content="form.description"
                                content-type="html" />
                        </div>
                        <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-end">
                            <button @click="this.showEditor = false" type="button"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">Cancelar</button>
                            <button @click="storeIntervencion()"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                        </div>
                    </div>
                </div>
            </div> -->

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

import ProgramasGrid from './ProgramasGrid.vue'

import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import store from '@/store.js'


const programas = [
    {
        name: 'Emprendedores',
        title: 'Regional Paradigm Technician',
        role: null,
        email: 'janecooper@example.com',
        telephone: '+1-202-555-0170',
        imageUrl:
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
    },
    {
        name: 'Gabinete',
        title: 'Regional Paradigm Technician',
        role: 'Activo',
        email: 'janecooper@example.com',
        telephone: '+1-202-555-0170',
        imageUrl:
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
    },
    {
        name: 'Psicopedagogía',
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
        users: Object,
        programasSociales: Object,
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
        ProgramasGrid,
        Datepicker,
    },

    setup() {
        const format = (date) => {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            return `${day}/${month}/${year}`;
        };

        return {
            format,
            programas,
            intervenciones,
            pages,
            store
        }
    },
    data() {
        return {
            form: {},
            programaSelected: {},

            showList: true,
            showCreate: false,
            showEditor: false,
            showDetail: false,
            showIntervencion: false
        }
    },
    methods: {
        async storePrograma() {
            let data = {}
            this.form.legajo_id = this.legajo[0].id
            let rt = route("legajoCB.storeProgramaSocial");
            try {
                const response = await axios.post(rt, this.form);
                if (response.status == 200) {
                    data.message = response.data.message
                    data.labelType = 'success'
                    this.showView('init')
                    this.legajo[0].programas_sociales = response.data.programas[0].programas_sociales
                } else {
                    data.message = response.data.message
                    data.labelType = 'info'
                }
            } catch (error) {
                console.log(error)
                data.labelType = "danger";
                data.message = "Se ha producido un error | Por Favor Comuniquese con el Administrador!"
            }
            this.$emit('message', data)
        },
        async storeIntervencion() {
            let data = {}
            this.form.programa_social_id = this.programaSelected.id
            // RUTA
            let rt = route("legajoCB.storeIntervencion");

            try {
                const response = await axios.post(rt, this.form);
                if (response.status == 200) {
                    data.message = response.data.message
                    data.labelType = 'success'
                    this.showDetail = false
                    this.showEditor = false
                    this.form = {}
                    this.legajo[0].programas_sociales.forEach(element => {
                        if (element.id === response.data.programas[0].id) {
                            element.intervenciones = response.data.programas[0].intervenciones
                        }
                    });
                    this.showView('detail')
                } else {
                    data.message = response.data.message
                    data.labelType = 'info'
                }
            } catch (error) {
                data.message = "Se ha producido un error | Por Favor Comuniquese con el Administrador!"
                data.labelType = 'danger'
            }
            this.$emit('message', data)
        },
        fnEditor(data) {
            this.showView(data.action)
            this.programaSelected = data.data
        },
        showView(accion) {
            switch (accion) {
                case 'init':
                    this.showList = true
                    this.showCreate = false
                    this.showEditor = false
                    this.showDetail = false
                    this.showIntervencion = false
                    break;
                case 'new_programa':
                    this.showList = false
                    this.showCreate = true
                    this.showEditor = false
                    this.showDetail = false
                    this.showIntervencion = false
                    break;
                case 'detail':
                    this.showList = false
                    this.showCreate = false
                    this.showEditor = false
                    this.showDetail = true
                    this.showIntervencion = false
                    break;
                case 'new_intervencion':
                    this.showList = false
                    this.showCreate = false
                    this.showEditor = false
                    this.showDetail = false
                    this.showIntervencion = true
                    break;
                default:
                    break;
            }
        }
    },

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
