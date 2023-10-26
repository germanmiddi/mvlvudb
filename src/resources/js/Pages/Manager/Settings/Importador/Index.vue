<template>
    <main class="flex-1">
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Importador de Datos
                </h1>
            </div>
        </div>
        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

        <div
            class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8 px-4 mt-6 sm:px-6 lg:px-8">
            <!-- Importador de Tramites -->
            <div class="group relative bg-gray-50 rounded-md">
                <div class="p-4 sm:mx-auto sm:w-full sm:max-w-sm">
                    <div>
                        <h4 class="text-center font-bold">Importador de Tramites</h4>
                        <div class="col-span-12 mt-2">
                            <label v-if="!loadingDependencia"
                                class="w-full flex flex-col items-center px-2 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:border-gray-150 hover:bg-gray-100 hover:text-gray-500">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                </svg>
                                <span v-if="!fileDependencia" class="mt-2 text-base leading-normal">Seleccione
                                    Archivo</span>
                                <span v-else class="mt-2 text-base leading-normal text-center">{{ fileDependenciaName
                                }}</span>
                                <input @change="handleFileDependenciaChange" type="file" name="file" id="file"
                                    ref="inputfile" autocomplete="off" class="hidden" />
                            </label>

                            <label v-else
                                class="w-full flex flex-col items-center px-2 py-6 bg-green-50 text-blue rounded-lg shadow-lg tracking-wide uppercase cursor-pointer hover:border-green-150 hover:bg-green-100 hover:text-green-500">
                                <ArrowPathIcon class="h-8 w-8 text-red-500 animate-spin mr-2" />
                                <span class="mt-2 text-base text-center leading-normal">Procesando Archivo...</span>
                                <input disabled @change="handleFileDependenciaChange" type="file" name="file" id="file"
                                    ref="inputfile" autocomplete="off" class="hidden" />
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="dependencia_id" class="block text-sm font-medium text-gray-700 mt-2">Dependencia</label>
                        <select id="dependencia_id" name="dependencia_id" autocomplete="off" v-model="dependencia_id"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled selected>
                                Seleccione una dependencia
                            </option>
                            <option v-for="dependencia in dependencias" :key="dependencia.id" :value="dependencia.id">
                                {{ dependencia.description }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <button type="button" @click="importarDependencia()" v-if="!loadingDependencia"
                            class="mt-4 w-full justify-center  relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">
                            Importar
                        </button>

                        <button type="button" disabled v-else
                            class="mt-4 w-full justify-center  relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-white">
                            <ArrowPathIcon class="h-5 w-5 text-red-500 animate-spin mr-2" /> Procesando...
                        </button>
                    </div>
                </div>
            </div>
            <!-- Importador de Entidades -->
            <div class="group relative bg-gray-50 rounded-md">
                <div class="p-4 sm:mx-auto sm:w-full sm:max-w-sm">
                    <div>
                        <h4 class="text-center font-bold">Importador de Entidades</h4>
                        <div class="col-span-12 mt-2">
                            <label v-if="!loadingEntidad"
                                class=" w-full justify-center relative flex flex-col items-center px-2 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:border-gray-150 hover:bg-gray-100 hover:text-gray-500">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                </svg>
                                <span v-if="!fileEntidad" class="mt-2 text-base leading-normal">Seleccione Archivo</span>
                                <span v-else class="mt-2 text-base leading-normal text-center">{{ fileName }}</span>
                                <input @change="handleFileEntidadChange" type="file" name="file" id="file" ref="inputfile"
                                    autocomplete="off" class="hidden" />
                            </label>

                            <label v-else
                                class="w-64 flex flex-col items-center px-2 py-6 bg-green-50 text-blue rounded-lg shadow-lg tracking-wide uppercase cursor-pointer hover:border-green-150 hover:bg-green-100 hover:text-green-500">
                                <ArrowPathIcon class="h-8 w-8 text-red-500 animate-spin mr-2" />
                                <span class="mt-2 text-base text-center leading-normal">Procesando Archivo...</span>
                                <input disabled @change="handleFileEntidadChange" type="file" name="file" id="file"
                                    ref="inputfile" autocomplete="off" class="hidden" />
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="button" @click="importarEntidad()" v-if="!loadingEntidad"
                            class="mt-4 w-full justify-center relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">
                            Importar
                        </button>

                        <button type="button" disabled v-else
                            class="mt-4 w-full justify-center relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-white">
                            <ArrowPathIcon class="h-5 w-5 text-red-500 animate-spin mr-2" /> Procesando...
                        </button>
                    </div>
                </div>
            </div>
            <!-- Importador de Personas -->
            <div class="group relative bg-gray-50 rounded-md">
                <div class="p-4 sm:mx-auto sm:w-full sm:max-w-sm">
                    <div>
                        <h4 class="text-center font-bold">Importador de Personas</h4>
                        <div class="col-span-12 mt-2">
                            <label v-if="!loadingPersona"
                                class="w-full flex flex-col items-center px-2 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:border-gray-150 hover:bg-gray-100 hover:text-gray-500">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                </svg>
                                <span v-if="!filePersona" class="mt-2 text-base leading-normal">Seleccione
                                    Archivo</span>
                                <span v-else class="mt-2 text-base leading-normal text-center">{{ filePersonaName
                                }}</span>
                                <input @change="handleFilePersonaChange" type="file" name="file" id="file" ref="inputfile"
                                    autocomplete="off" class="hidden" />
                            </label>

                            <label v-else
                                class="w-full flex flex-col items-center px-2 py-6 bg-green-50 text-blue rounded-lg shadow-lg tracking-wide uppercase cursor-pointer hover:border-green-150 hover:bg-green-100 hover:text-green-500">
                                <ArrowPathIcon class="h-8 w-8 text-red-500 animate-spin mr-2" />
                                <span class="mt-2 text-base text-center leading-normal">Procesando Archivo...</span>
                                <input disabled @change="handleFilePersonaChange" type="file" name="file" id="file"
                                    ref="inputfile" autocomplete="off" class="hidden" />
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="button" @click="importarPersonas()" v-if="!loadingPersona"
                            class="mt-4 w-full justify-center  relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">
                            Importar
                        </button>

                        <button type="button" disabled v-else
                            class="mt-4 w-full justify-center  relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-white">
                            <ArrowPathIcon class="h-5 w-5 text-red-500 animate-spin mr-2" /> Procesando...
                        </button>
                    </div>
                </div>
            </div>
            <!-- Importador de Estados -->
            <div class="group relative bg-gray-50 rounded-md">
                <div class="p-4 sm:mx-auto sm:w-full sm:max-w-sm">
                    <div>
                        <h4 class="text-center font-bold">Importador de Estados</h4>
                        <div class="col-span-12 mt-2">
                            <label v-if="!loadingEstado"
                                class="w-full flex flex-col items-center px-2 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:border-gray-150 hover:bg-gray-100 hover:text-gray-500">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                </svg>
                                <span v-if="!fileEstado" class="mt-2 text-base leading-normal">Seleccione
                                    Archivo</span>
                                <span v-else class="mt-2 text-base leading-normal text-center">{{ fileEstadoName
                                }}</span>
                                <input @change="handleFileEstadoChange" type="file" name="file" id="file" ref="inputfile"
                                    autocomplete="off" class="hidden" />
                            </label>

                            <label v-else
                                class="w-full flex flex-col items-center px-2 py-6 bg-green-50 text-blue rounded-lg shadow-lg tracking-wide uppercase cursor-pointer hover:border-green-150 hover:bg-green-100 hover:text-green-500">
                                <ArrowPathIcon class="h-8 w-8 text-red-500 animate-spin mr-2" />
                                <span class="mt-2 text-base text-center leading-normal">Procesando Archivo...</span>
                                <input disabled @change="handleFileEstadoChange" type="file" name="file" id="file"
                                    ref="inputfile" autocomplete="off" class="hidden" />
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="button" @click="importarEstados()" v-if="!loadingEstado"
                            class="mt-4 w-full justify-center  relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">
                            Importar
                        </button>

                        <button type="button" disabled v-else
                            class="mt-4 w-full justify-center  relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-white">
                            <ArrowPathIcon class="h-5 w-5 text-red-500 animate-spin mr-2" /> Procesando...
                        </button>
                    </div>
                </div>
            </div>
            <!-- Importador de Files -->
            <div class="group relative bg-gray-50 rounded-md">
                <div class="p-4 sm:mx-auto sm:w-full sm:max-w-sm">
                    <div>
                        <h4 class="text-center font-bold">Importador de Archivos</h4>
                    </div>
                    <div>
                        <button type="button" @click="importarArchivos()" v-if="!loadingArchivo"
                            class="mt-4 w-full justify-center  relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">
                            Importar Archivos
                        </button>

                        <button type="button" disabled v-else
                            class="mt-4 w-full justify-center  relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-white">
                            <ArrowPathIcon class="h-5 w-5 text-red-500 animate-spin mr-2" /> Procesando...
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-4 mt-6 sm:px-6 lg:px-8">
            <!-- <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
                        <div class="">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Importador de Entidades</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <button type="button" @click="importarEntidad()" v-if="!loadingEntidad"
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">
                                Importar
                            </button>

                            <button type="button" disabled v-else
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-white">
                                <ArrowPathIcon class="h-5 w-5 text-red-500 animate-spin mr-2" /> Procesando...
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 sm:col-span-6">
                            <label v-if="!loadingEntidad"
                                class="w-64 flex flex-col items-center px-2 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:border-gray-150 hover:bg-gray-100 hover:text-gray-500">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                </svg>
                                <span v-if="!fileEntidad" class="mt-2 text-base leading-normal">Seleccione Archivo</span>
                                <span v-else class="mt-2 text-base leading-normal text-center">{{ fileName }}</span>
                                 <input @change="handleFileEntidadChange" type="file" name="file" id="file" ref="inputfile"
                                    autocomplete="off" class="hidden" />
                            </label>

                            <label v-else
                                class="w-64 flex flex-col items-center px-2 py-6 bg-green-50 text-blue rounded-lg shadow-lg tracking-wide uppercase cursor-pointer hover:border-green-150 hover:bg-green-100 hover:text-green-500">
                                <ArrowPathIcon class="h-8 w-8 text-red-500 animate-spin mr-2" />
                                <span class="mt-2 text-base text-center leading-normal">Procesando Archivo...</span>
                                <input disabled @change="handleFileEntidadChange" type="file" name="file" id="file"
                                    ref="inputfile" autocomplete="off" class="hidden" />
                            </label>
                        </div>
                    </div>
                </div>

            </div> -->

            <!--  <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
                        <div class="">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Importador de Tramites</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <button type="button" @click="importarDependencia()" v-if="!loadingDependencia"
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">
                                Importar
                            </button>

                            <button type="button" disabled v-else
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-white">
                                <ArrowPathIcon class="h-5 w-5 text-red-500 animate-spin mr-2" /> Procesando...
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 sm:col-span-3">
                            <label for="dependencia_id" class="block text-sm font-medium text-gray-700">Dependencia</label>
                            <select id="dependencia_id" name="dependencia_id" autocomplete="off" v-model="dependencia_id"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled selected>
                                    Seleccione una dependencia
                                </option>
                                <option v-for="dependencia in dependencias" :key="dependencia.id" :value="dependencia.id">
                                    {{ dependencia.description }}
                                </option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label v-if="!loadingDependencia"
                                class="w-64 flex flex-col items-center px-2 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:border-gray-150 hover:bg-gray-100 hover:text-gray-500">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                </svg>
                                <span v-if="!fileDependencia" class="mt-2 text-base leading-normal">Seleccione
                                    Archivo</span>
                                <span v-else class="mt-2 text-base leading-normal text-center">{{ fileDependenciaName
                                }}</span>
                                <input @change="handleFileDependenciaChange" type="file" name="file" id="file"
                                    ref="inputfile" autocomplete="off" class="hidden" />
                            </label>

                            <label v-else
                                class="w-64 flex flex-col items-center px-2 py-6 bg-green-50 text-blue rounded-lg shadow-lg tracking-wide uppercase cursor-pointer hover:border-green-150 hover:bg-green-100 hover:text-green-500">
                                <ArrowPathIcon class="h-8 w-8 text-red-500 animate-spin mr-2" />
                                <span class="mt-2 text-base text-center leading-normal">Procesando Archivo...</span>
                                <input disabled @change="handleFileDependenciaChange" type="file" name="file" id="file"
                                    ref="inputfile" autocomplete="off" class="hidden" />
                            </label>
                        </div>

                    </div>
                </div>
            </div> -->

           <!--  <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
                        <div class="">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Importador de Personas</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <button type="button" @click="importarPersonas()" v-if="!loadingPersona"
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">
                                Importar
                            </button>

                            <button type="button" disabled v-else
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-white">
                                <ArrowPathIcon class="h-5 w-5 text-red-500 animate-spin mr-2" /> Procesando...
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 sm:col-span-12">
                            <label v-if="!loadingPersona"
                                class="w-64 flex flex-col items-center px-2 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:border-gray-150 hover:bg-gray-100 hover:text-gray-500">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                </svg>
                                <span v-if="!filePersona" class="mt-2 text-base leading-normal">Seleccione
                                    Archivo</span>
                                <span v-else class="mt-2 text-base leading-normal text-center">{{ filePersonaName
                                }}</span>
                                <input @change="handleFilePersonaChange" type="file" name="file" id="file" ref="inputfile"
                                    autocomplete="off" class="hidden" />
                            </label>

                            <label v-else
                                class="w-64 flex flex-col items-center px-2 py-6 bg-green-50 text-blue rounded-lg shadow-lg tracking-wide uppercase cursor-pointer hover:border-green-150 hover:bg-green-100 hover:text-green-500">
                                <ArrowPathIcon class="h-8 w-8 text-red-500 animate-spin mr-2" />
                                <span class="mt-2 text-base text-center leading-normal">Procesando Archivo...</span>
                                <input disabled @change="handleFilePersonaChange" type="file" name="file" id="file"
                                    ref="inputfile" autocomplete="off" class="hidden" />
                            </label>
                        </div>

                    </div>
                </div>
            </div> -->

           <!--  <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
                        <div class="">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Importador de Estados</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <button type="button" @click="importarEstados()" v-if="!loadingEstado"
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white">
                                Importar
                            </button>

                            <button type="button" disabled v-else
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-white">
                                <ArrowPathIcon class="h-5 w-5 text-red-500 animate-spin mr-2" /> Procesando...
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 sm:col-span-12">
                            <label v-if="!loadingEstado"
                                class="w-64 flex flex-col items-center px-2 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:border-gray-150 hover:bg-gray-100 hover:text-gray-500">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                </svg>
                                <span v-if="!fileEstado" class="mt-2 text-base leading-normal">Seleccione
                                    Archivo</span>
                                <span v-else class="mt-2 text-base leading-normal text-center">{{ fileEstadoName
                                }}</span>
                                <input @change="handleFileEstadoChange" type="file" name="file" id="file" ref="inputfile"
                                    autocomplete="off" class="hidden" />
                            </label>

                            <label v-else
                                class="w-64 flex flex-col items-center px-2 py-6 bg-green-50 text-blue rounded-lg shadow-lg tracking-wide uppercase cursor-pointer hover:border-green-150 hover:bg-green-100 hover:text-green-500">
                                <ArrowPathIcon class="h-8 w-8 text-red-500 animate-spin mr-2" />
                                <span class="mt-2 text-base text-center leading-normal">Procesando Archivo...</span>
                                <input @change="handleFileEstadoChange" type="file" name="file" id="file" ref="inputfile"
                                    autocomplete="off" class="hidden" />
                            </label>
                        </div>

                    </div>
                </div>
            </div> -->
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


    </main>
</template>

<script>
import { ref } from "vue";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

import {
    ChevronRightIcon,
    EllipsisVerticalIcon,
    PencilSquareIcon,
    ArrowsPointingOutIcon,
    ArrowPathIcon
} from "@heroicons/vue/24/solid";
import Toast from "@/Layouts/Components/Toast.vue";

export default {
    props: {
        toast: Object,
        dependencias: Object
    },
    components: {
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        EllipsisVerticalIcon,
        ChevronRightIcon,
        PencilSquareIcon,
        ArrowsPointingOutIcon,
        ArrowPathIcon,
        Toast,
        Datepicker
    },
    data() {
        return {
            logs: "",
            toastMessage: "",
            labelType: "info",
            message: "",
            showToast: false,
            length: 100,
            fileEntidad: '',
            fileName: '',
            fileDependencia: '',
            fileDependenciaName: '',
            fileEstado: '',
            fileEstadoName: '',
            filePersona: '',
            filePersonaName: '',
            loadingEntidad: false,
            loadingDependencia: false,
            loadingEstado: false,
            loadingPersona: false,
            loadingArchivo: false,
            status: '',
            dependencia_id: ''
        };
    },
    setup() {
    },
    methods: {
        clearMessage() {
            this.toastMessage = "";
        },
        handleFileEntidadChange(event) {
            this.fileEntidad = event.target.files[0];
            this.fileName = this.fileEntidad ? this.fileEntidad.name : '';
        },
        handleFileDependenciaChange(event) {
            this.fileDependencia = event.target.files[0];
            this.fileDependenciaName = this.fileDependencia ? this.fileDependencia.name : '';
        },
        handleFileInfanciaChange(event) {
            this.fileInfancia = event.target.files[0];
            this.fileInfanciaName = this.fileInfancia ? this.fileInfancia.name : '';
        },
        handleFileEstadoChange(event) {
            this.fileEstado = event.target.files[0];
            this.fileEstadoName = this.fileEstado ? this.fileEstado.name : '';
        },
        handleFilePersonaChange(event) {
            this.filePersona = event.target.files[0];
            this.filePersonaName = this.filePersona ? this.filePersona.name : '';
        },
        async importarEntidad() {
            if (this.fileEntidad != '') {
                this.loadingEntidad = true
                this.status = ''
                let rt = route("import.entidad");
                const formData = new FormData();
                formData.append('file', this.fileEntidad);
                try {
                    const response = await axios.post(rt, formData);
                    if (response.status == 200) {
                        this.labelType = "success";
                        this.toastMessage = response.data.message;
                        this.status = response.data.status;
                        console.log(response)
                    } else {
                        this.labelType = "danger";
                        this.toastMessage = response.data.message;
                    }
                } catch (error) {
                    console.log(error);
                }
                this.loadingEntidad = false
            } else {
                this.labelType = "info";
                this.toastMessage = "Debe seleccionar un archivo";
            }
        },
        async importarDependencia() {
            if (this.dependencia_id != '') {
                if (this.fileDependencia != '') {
                    this.loadingDependencia = true
                    this.status = ''
                    let rt = route("import.dependencia");
                    const formData = new FormData();
                    formData.append('file', this.fileDependencia);
                    formData.append('dependencia_id', this.dependencia_id);
                    try {
                        const response = await axios.post(rt, formData);
                        if (response.status == 200) {
                            this.labelType = "success";
                            this.toastMessage = response.data.message;
                            this.status = response.data.status;
                            console.log(response)
                        } else {
                            this.labelType = "danger";
                            this.toastMessage = response.data.message;
                        }
                    } catch (error) {
                        console.log(error);
                        this.labelType = "info";
                        this.toastMessage = "El proceso de importación continuará ejecutandose en segundo plano, puede verificarlo en los Logs.";
                    }
                    this.loadingDependencia = false
                } else {
                    this.labelType = "info";
                    this.toastMessage = "Debe seleccionar un archivo";
                }
            } else {
                this.labelType = "info";
                this.toastMessage = "Debe seleccionar una dependencia";
            }
        },
        async importarEstados() {
            if (this.fileEstado != '') {
                this.loadingEstado = true
                this.status = ''
                let rt = route("import.estado");
                const formData = new FormData();
                formData.append('file', this.fileEstado);
                try {
                    const response = await axios.post(rt, formData);
                    if (response.status == 200) {
                        this.labelType = "success";
                        this.toastMessage = response.data.message;
                        this.status = response.data.status;
                        console.log(response)
                    } else {
                        this.labelType = "danger";
                        this.toastMessage = response.data.message;
                    }
                } catch (error) {
                    console.log(error);
                    this.labelType = "info";
                    this.toastMessage = "El proceso de importación continuará ejecutandose en segundo plano, puede verificarlo en los Logs.";
                }
                this.loadingEstado = false
            } else {
                this.labelType = "info";
                this.toastMessage = "Debe seleccionar un archivo";
            }

        },

        async importarPersonas() {
            if (this.filePersona != '') {
                this.loadingPersona = true
                this.status = ''
                let rt = route("import.personas");
                const formData = new FormData();
                formData.append('file', this.filePersona);
                try {
                    const response = await axios.post(rt, formData);
                    if (response.status == 200) {
                        this.labelType = "success";
                        this.toastMessage = response.data.message;
                        this.status = response.data.status;
                        console.log(response)
                    } else {
                        this.labelType = "danger";
                        this.toastMessage = response.data.message;
                    }
                } catch (error) {
                    console.log(error);
                    this.labelType = "info";
                    this.toastMessage = "El proceso de importación continuará ejecutandose en segundo plano, puede verificarlo en los Logs.";
                }
                this.loadingPersona = false
            } else {
                this.labelType = "info";
                this.toastMessage = "Debe seleccionar un archivo";
            }
        },
        async importarArchivos() {
            this.loadingArchivo = true
            this.status = ''
            let rt = route("import.files");
            try {
                const response = await axios.post(rt);
                if (response.status == 200) {
                    this.labelType = "success";
                    this.toastMessage = response.data.message;
                    this.status = response.data.status;
                } else {
                    this.labelType = "danger";
                    this.toastMessage = response.data.message;
                }
            } catch (error) {
                console.log(error);
                this.labelType = "info";
                this.toastMessage = "El proceso de importación continuará ejecutandose en segundo plano, puede verificarlo en los Logs.";
            }
            this.loadingArchivo = false
        }

    },
    mounted() {
        if (this.toast) {
            if (this.toast["status"] == 200) {
                this.labelType = "success";
                this.toastMessage = this.toast["message"];
            } else {
                this.labelType = "danger";
                this.toastMessage = this.toast["message"];
            }
        }
    }
};
</script>

<style></style>
