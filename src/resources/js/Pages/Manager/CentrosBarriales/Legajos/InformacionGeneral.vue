<template>
    <!-- <h1>soy el informacion general</h1> -->
    <div>
        <div class="px-4 mt-10">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Legajo N°: {{legajo[0].id}}</h3>
            </div> -->
                <div class="sm:flex sm:justify-between sm:items-center">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Legajo N°: {{ legajo[0].id }}</h3>
                    </div>
                    <div
                        class="mt-4 mr-2 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                        <a href="#" title="Editar"
                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-2 py-2 text-sm']">
                            <PencilSquareIcon class="h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                        </a>
                    </div>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Semaforo:</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">

                                <div
                                    class="mt-4 mr-2 flex items-center justify-between sm:mt-0 sm:flex-shrink-0 sm:justify-start">
                                    <Menu as="div" class="relative inline-block text-left">
                                        <div>
                                            <MenuButton
                                                class=" p-2 rounded-full bg-white flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                                <SunIcon
                                                    class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                                                    aria-hidden="true" />
                                                <!-- <SunIcon v-else-if="semaforo_id === 2"
                                                    class="mr-3 h-6 w-6 text-red-400 group-hover:text-red-500"
                                                    aria-hidden="true" />
                                                <SunIcon v-else-if="semaforo_id === 3"
                                                    class="mr-3 h-6 w-6 text-yellow-400 group-hover:text-yellow-500"
                                                    aria-hidden="true" />
                                                <SunIcon v-else-if="semaforo_id === 4"
                                                    class="mr-3 h-6 w-6 text-green-400 group-hover:text-green-500"
                                                    aria-hidden="true" /> -->
                                                    
                                                <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
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
                                                <div class="py-1 z-50">
                                                    <MenuItem v-slot="{ active }">
                                                    <button type="button" 
                                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                                        <span>
                                                            <SunIcon
                                                                class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                                                                aria-hidden="true" />
                                                        </span>
                                                    </button>
                                                    </MenuItem>
                                                    <MenuItem v-slot="{ active }">
                                                    <button type="button" 
                                                        :class="[active ? 'bg-gray-100 text-red-900' : 'text-red-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                                        <span>
                                                            <SunIcon
                                                                class="mr-3 h-6 w-6 text-red-400 group-hover:text-red-500"
                                                                aria-hidden="true" />
                                                        </span>
                                                    </button>
                                                    </MenuItem>
                                                    <MenuItem v-slot="{ active }">
                                                    <button type="button"
                                                        :class="[active ? 'bg-yellow-100 text-red-900' : 'text-yellow-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                                        <span>
                                                            <SunIcon
                                                                class="mr-3 h-6 w-6 text-yellow-400 group-hover:text-yellow-500"
                                                                aria-hidden="true" />
                                                        </span>
                                                    </button>
                                                    </MenuItem>
                                                    <MenuItem v-slot="{ active }">
                                                    <button type="button"
                                                        :class="[active ? 'bg-gray-100 text-green-900' : 'text-green-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                                        <span>
                                                            <SunIcon
                                                                class="mr-3 h-6 w-6 text-green-400 group-hover:text-green-500"
                                                                aria-hidden="true" />
                                                        </span>
                                                    </button>
                                                    </MenuItem>
                                                </div>
                                            </MenuItems>
                                        </transition>
                                    </Menu>
                                </div>


                            </dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Tipo Legajo:</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                                legajo[0].tipo_legajo?.description ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Fecha de Inscripcion:</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{ legajo[0].fecha_inscripcion ?
                                store.dateFormateada(legajo[0].fecha_inscripcion) : '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Fecha de Inicio:</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{ legajo[0].fecha_inicio ?
                                store.dateTimeFormateada(legajo[0].fecha_inicio) : '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Fecha de Ingreso:</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{ legajo[0].created_at ?
                                store.fechaFormateada(legajo[0].created_at) : '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Última actualización</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ legajo[0].updated_at ?
                                store.fechaFormateada(legajo[0].updated_at) : '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Estado Actual</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ legajo[0].estadocbj?.description
                                ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Canal de Atención:</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{
                                legajo[0].canal_atencion?.description ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Sede</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ legajo[0].sede?.description ??
                                '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Observación</dt>
                            <dd class="mt-1 text-sm text-justify text-gray-900 sm:mt-0 sm:col-span-2">{{
                                legajo[0].observacion ?? '-' }}</dd>
                        </div>

                    </dl>
                </div>

            </div>
        </div>

        <div class="px-4 mt-10">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Legajo N°: {{legajo[0].id}}</h3>
            </div> -->
                <div class="sm:flex sm:justify-between sm:items-center">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Dirección</h3>
                    </div>
                    <div
                        class="mt-4 mr-2 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                        <a href="#" title="Editar"
                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-2 py-2 text-sm']">
                            <PencilSquareIcon class="h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                        </a>
                    </div>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Localidad:</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                                legajo[0].person.address[0]?.localidad?.description ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Calle:</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                                legajo[0].person.address[0]?.calle ??
                                '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Piso:</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                                legajo[0].person.address[0]?.piso ??
                                '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Departamento:</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                                legajo[0].person.address[0]?.dpto ??
                                '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Observación</dt>
                            <dd class="mt-1 text-sm text-justify text-gray-900 sm:mt-0 sm:col-span-2">{{
                                legajo[0].person.address[0]?.observacion ?? '-' }}</dd>
                        </div>

                    </dl>
                </div>

            </div>
        </div>

        <!-- Datos Responsale -->
        <div class="px-4 mt-6" v-if="legajo[0].responsable">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Datos del Adulto Responsable</h3>
            </div> -->
                <div class="sm:flex sm:justify-between sm:items-center">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Datos del Adulto Responsable</h3>
                    </div>
                    <div
                        class="mt-4 mr-2 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                        <a href="#" title="Editar"
                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-2 py-2 text-sm']">
                            <PencilSquareIcon class="h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                        </a>
                    </div>
                </div>

                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].responsable.lastname }}, {{ legajo[0].responsable.name }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Documento</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].responsable.num_documento }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ legajo[0].responsable?.fecha_nac
                                ? store.dateFormateada(legajo[0].responsable.fecha_nac) : '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Telefono</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].responsable.contact[0]?.phone ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Celular</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].responsable.contact[0]?.celular ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Pais</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].responsable?.address[0]?.pais?.description ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Situación Laboral</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].responsable?.social[0]?.tipo_ocupacion?.description ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Situación Conyugal</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].responsable?.aditional[0]?.situacion_conyugal?.description ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Nivel Educativo</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].responsable?.education[0]?.nivel_educativo?.description ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Estado Educativo</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].responsable?.education[0]?.estado_educativo?.description ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Parentesco</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{
                                legajo[0].parentesco?.description ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Teléfono de Emergencia</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{
                                legajo[0].phone_emergency ?? '-' }}</dd>
                        </div>

                    </dl>
                </div>
            </div>
        </div>
        <!-- Fin  Datos Titular -->

        <!-- Datos Autorizaciones -->
        <div class="px-4 mt-6">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Autorizaciones</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles de las autorizaciones Vigentes.</p>
            </div> -->
                <div class="sm:flex sm:justify-between sm:items-center">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Autorizaciones</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles de las autorizaciones Vigentes.</p>
                    </div>
                    <div
                        class="mt-4 mr-2 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
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
                                            <span>Editar</span>
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <button type="button"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                            <span>Nuevo Informe</span>
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <a href="#"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex justify-between px-4 py-2 text-sm']">
                                            <span>Adjuntar Archivo</span>
                                        </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>


                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Apoyo Escolar</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].autorizacion?.apoyo_escolar ? 'SI' : 'NO' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Actividad por Area Empleo</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].autorizacion?.actividad_empleo ? 'SI' : 'NO' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Autoriazción Firmada</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].autorizacion?.autorizacion_firmada ? 'SI' : 'NO' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Autorización para Retirarse</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].autorizacion?.autorizacion_retirarse ? 'SI' : 'NO' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Autorización Uso de Imagen</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].autorizacion?.autorizacion_uso_imagen ? 'SI' : 'NO' }}</dd>
                        </div>
                    </dl>
                </div>

            </div>
        </div>
        <!-- Fin  Autorizaciones -->

        <!-- Datos Salud -->
        <div class="px-4 mt-6">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Salud</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles Salud</p>
            </div> -->
                <div class="sm:flex sm:justify-between sm:items-center">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Salud</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles Salud</p>
                    </div>
                    <div
                        class="mt-4 mr-2 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
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
                                            <span>Editar</span>
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <button type="button"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                            <span>Nuevo Informe</span>
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <a href="#"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex justify-between px-4 py-2 text-sm']">
                                            <span>Adjuntar Archivo</span>
                                        </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>

                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Apto Medico</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].person?.salud?.apto_medico ? 'SI' : 'NO' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Fecha Apto Médico</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{
                                legajo[0].person?.salud?.fecha_apto_medico ?
                                store.dateFormateada(legajo[0].person?.salud?.fecha_apto_medico) : '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Vencimiento Apto Médico</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{
                                legajo[0].person?.salud?.vencimiento_apto_medico ?
                                store.dateFormateada(legajo[0].person?.salud?.vencimiento_apto_medico) : '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Electrocardiograma</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].person?.salud?.electrocardiograma ? 'SI' : 'NO' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Fecha Electrocardiograma</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{
                                legajo[0].person?.salud?.fecha_electrocardiograma ?
                                store.dateFormateada(legajo[0].person?.salud?.fecha_electrocardiograma) : '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Libreta vacunación</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].person?.salud?.libreta_vacunacion ? 'SI' : 'NO' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Lugar de atención</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].person?.salud?.centro_salud?.description ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Posee CUD</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> {{
                                legajo[0].person?.cud?.posee_cud
                                ? 'SI' : 'NO' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Presento CUD</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].person?.cud?.presento_cud ? 'SI' : 'NO' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Fecha vencimiento CUD</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{
                                legajo[0].person?.cud?.vencimiento_cud ?
                                store.dateTimeFormateada(legajo[0].person?.cud?.vencimiento_cud) : '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Observación</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 text-justify">
                                {{ legajo[0].person?.salud?.observacion ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>

            </div>
        </div>
        <!-- Fin  Salud -->

        <!-- Datos Educación -->
        <div class="px-4 mt-6">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Educación</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles Educación</p>
            </div> -->
                <div class="sm:flex sm:justify-between sm:items-center">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Educación</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles Educación</p>
                    </div>
                    <div
                        class="mt-4 mr-2 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
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
                                            <span>Editar</span>
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <button type="button"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                            <span>Nuevo Informe</span>
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <a href="#"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex justify-between px-4 py-2 text-sm']">
                                            <span>Adjuntar Archivo</span>
                                        </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>

                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Escuela</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].person?.education[0]?.escuela_primaria?.description ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Nivel Educativo</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].person?.education[0]?.nivel_educativo?.description ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Grado/Año</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].person?.education[0]?.nivel_escuela?.description ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Estado Educativo</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].person?.education[0]?.estado_educativo?.description ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Turno</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].person?.education[0]?.escuela_turno?.description ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Dependencia</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].person?.education[0]?.escuela_dependencia?.description ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Localidad</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].person?.education[0]?.escuela_localidad?.description ?? '-' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Certificado Escolar</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].person?.education[0]?.certificado_escolar ? 'SI' : 'NO' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Realizo Permanencia</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].person?.education[0]?.permanencia ? 'SI' : 'NO' }}</dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Observación</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ legajo[0].person?.education[0]?.observacion ?? '-' }} </dd>
                        </div>
                    </dl>
                </div>

            </div>
        </div>
        <!-- Fin  Educación -->

        <!-- Datos Gabinete -->
        <div class="px-4 mt-6">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Educación</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles Educación</p>
            </div> -->
                <div class="sm:flex sm:justify-between sm:items-center">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Gabinete</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles Gabinete</p>
                    </div>
                    <div
                        class="mt-4 mr-2 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
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
                                            <span>Editar</span>
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <button type="button"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                            <span>Nuevo Informe</span>
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <a href="#"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex justify-between px-4 py-2 text-sm']">
                                            <span>Adjuntar Archivo</span>
                                        </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>

                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Estado</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> - </dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Observación</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> - </dd>
                        </div>

                    </dl>
                </div>

            </div>
        </div>
        <!-- Fin  Gabinete -->

        <!-- Datos Emprendedores -->
        <div class="px-4 mt-6">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Educación</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles Educación</p>
            </div> -->
                <div class="sm:flex sm:justify-between sm:items-center">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Emprendedores</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles Emprendedores</p>
                    </div>
                    <div
                        class="mt-4 mr-2 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
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
                                    <div class="py-1 z-50">
                                        <MenuItem v-slot="{ active }">
                                        <button type="button" @click="showEditor = true"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                            <span>Editar</span>
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <button type="button"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                            <span>Nuevo Informe</span>
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <a href="#"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex justify-between px-4 py-2 text-sm']">
                                            <span>Adjuntar Archivo</span>
                                        </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>

                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Participa</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> SI </dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Fecha Inscripción</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> 09/07/2024 </dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Fecha Finalización</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> 19/10/2024 </dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Oficio</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> Indumentaria </dd>
                        </div>

                    </dl>
                </div>

            </div>
        </div>
        <!-- Fin  Emprendedores -->

        <!-- Datos PEdagogia -->
        <div class="px-4 mt-6">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Educación</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles Educación</p>
            </div> -->
                <div class="sm:flex sm:justify-between sm:items-center">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Pedagogía</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles Pedagogía</p>
                    </div>
                    <div
                        class="mt-4 mr-2 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
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
                                    <div class="py-1 z-50">
                                        <MenuItem v-slot="{ active }">
                                        <button type="button" @click="showEditor = true"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                            <span>Editar</span>
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <button type="button"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'w-full flex justify-between px-4 py-2 text-sm']">
                                            <span>Nuevo Informe</span>
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <a href="#"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex justify-between px-4 py-2 text-sm']">
                                            <span>Adjuntar Archivo</span>
                                        </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>

                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Estado</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> - </dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Observación</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> - </dd>
                        </div>

                    </dl>
                </div>

            </div>
        </div>
        <!-- Fin  Pedagogia -->
    </div>
</template>

<script setup>
import store from '@/store.js'
import { Bars4Icon, PencilSquareIcon, SunIcon, ChevronDownIcon } from '@heroicons/vue/24/solid';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';

const props = defineProps({
    legajo: Object,
});

/* const semaforo_id = ref("1"); */

const legajo = props.legajo;

/* function semaforo(id) {
    semaforo_id.value = id
} */

</script>

<style></style>
