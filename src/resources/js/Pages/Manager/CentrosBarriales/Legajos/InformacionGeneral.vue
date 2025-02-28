<template>
    <div>

        <LegajoComponent :legajo="legajo" :sedes="sedes" :canalesAtencion="canalesAtencion" :tiposLegajo="tiposLegajo"
            :estados="estados" @message="messageToast" />

        <DireccionComponent :legajo="legajo" :localidades="localidades" @message="messageToast" />

        <ResponsableComponent :legajo="legajo" :paises="paises" :parentescos="parentescos"
            :situacionesConyugal="situacionesConyugal" :tiposOcupacion="tiposOcupacion"
            :estadosEducativo="estadosEducativo" :nivelesEducativo="nivelesEducativo" :tipoDocumento="tipoDocumento"
            @message="messageToast" />

        <AutorizacionesComponent :legajo="legajo" @message="messageToast" />

        <SaludComponent :centrosSalud="centrosSalud" :legajo="legajo" @message="messageToast" />

        <EducacionComponent :escuelas="escuelas" :estadosEducativo="estadosEducativo"
            :nivelesEducativo="nivelesEducativo" :turnosEducativo="turnosEducativo"
            :escuelasDependencia="escuelasDependencia" :localidades="localidades" :escuelasNivel="escuelasNivel"
            :legajo="legajo" @message="messageToast" />

        <GabineteComponent :estadosGabinete="estadosGabinete" :espacioGabinete="espacioGabinete" :legajo="legajo"
            @message="messageToast" />

        <EmprendedorComponent v-if="legajo[0].tipo_legajo?.id === 2" :legajo="legajo" @message="messageToast" />

        <!-- Datos PEdagogia -->
        <!-- <div class="px-4 mt-6">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="sm:flex sm:justify-between sm:items-center">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Pedagogía</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles Pedagogía</p>
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
        </div> -->
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
    estadosGabinete: Object,
    espacioGabinete: Object,
    tipoDocumento: Object,

});

const legajo = props.legajo;
const emit = defineEmits(['message']);

function messageToast(data) {
    emit('message', data);
}

</script>
