<template>
    <div>

        <LegajoComponent :legajo="legajo" :sedes="sedes" :canalesAtencion="canalesAtencion" :tiposLegajo="tiposLegajo"
            :estados="estados" @message="messageToast" />

        <DireccionComponent :legajo="legajo" :localidades="localidades" @message="messageToast" />

        <ResponsableComponent v-if="legajo[0].responsable" :legajo="legajo" :paises="paises" :parentescos="parentescos"
            :situacionesConyugal="situacionesConyugal" :tiposOcupacion="tiposOcupacion"
            :estadosEducativo="estadosEducativo" :nivelesEducativo="nivelesEducativo" @message="messageToast" />

        <AutorizacionesComponent :legajo="legajo" @message="messageToast" />

        <SaludComponent :centrosSalud="centrosSalud" :legajo="legajo" @message="messageToast" />

        <EducacionComponent :escuelas="escuelas" :estadosEducativo="estadosEducativo"
            :nivelesEducativo="nivelesEducativo" :turnosEducativo="turnosEducativo"
            :escuelasDependencia="escuelasDependencia" :localidades="localidades" 
            :escuelasNivel="escuelasNivel" :legajo="legajo" @message="messageToast" />

        <GabineteComponent :estadosGabinete="estadosGabinete" :legajo="legajo" @message="messageToast" />

        <EmprendedorComponent v-if="this.legajo[0].tipo_legajo?.id === 2" :legajo="legajo" @message="messageToast" />

        <!-- Datos PEdagogia -->
        <div class="px-4 mt-6">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
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

// Card Legajo
import LegajoComponent from './Components/Legajo.vue';
import DireccionComponent from './Components/Direccion.vue';
import ResponsableComponent from './Components/Responsable.vue';
import AutorizacionesComponent from './Components/Autorizaciones.vue';
import SaludComponent from './Components/Salud.vue';
import EducacionComponent from './Components/Educacion.vue';
import GabineteComponent from './Components/Gabinete.vue';
import EmprendedorComponent from './Components/Emprendedor.vue';

import { defineEmits } from 'vue';

const props = defineProps({
    legajo: Object,
    sedes: Object,
    canalesAtencion: Object,
    tiposLegajo: Object,
    estados: Object,
    localidades: Object,
    paises: Object,
    parentescos: Object,
    situacionesConyugal: Object,
    tiposOcupacion: Object,
    estadosEducativo: Object,
    nivelesEducativo: Object,
    centrosSalud: Object,
    escuelas: Object,
    turnosEducativo: Object,
    escuelasDependencia: Object,
	escuelasNivel: Object,
    estadosGabinete: Object
    
});

const legajo = props.legajo;
const emit = defineEmits(['message']);

function messageToast(data) {
    emit('message', data);
}

</script>
