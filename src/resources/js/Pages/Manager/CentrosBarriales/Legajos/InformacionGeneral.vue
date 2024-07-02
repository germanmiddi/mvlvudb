<template>
<!-- <h1>soy el informacion general</h1> -->
<div>
    <div class="px-4 mt-10">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Legajo N°: {{legajo[0].id}}</h3>
            </div>

            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fecha de Inscripcion:</dt>
                        <!-- <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{ store.dateFormateada(legajo[0].fecha_inscripcion) }}</dd> -->
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fecha de Inicio:</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{legajo[0].fecha_inicio }}</dd>
                    </div>
                    
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fecha de Ingreso:</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{ store.fechaFormateada(legajo[0].created_at) }}</dd>
                    </div>
                    
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Última actualización</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ store.fechaFormateada(legajo[0].updated_at) }}</dd>
                    </div>
                    
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Estado Actual</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ legajo[0].estadocbj?.description ?? '-' }}</dd>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Canal de Atención:</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ legajo[0].canal_atencion?.description ?? '-' }}</dd>
                    </div>
                    
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Sede</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ legajo[0].sede?.description ?? '-' }}</dd>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Observación</dt>
                        <dd class="mt-1 text-sm text-justify text-gray-900 sm:mt-0 sm:col-span-2">{{ legajo[0].observacion ?? '-' }}</dd>
                    </div>
                    
                </dl>
            </div>

        </div>
	</div>	

    <!-- Datos Responsale -->
    <div class="px-4 mt-6" v-if="legajo[0].responsable">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Datos del Adulto Responsable</h3>
            </div>

            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
        
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{legajo[0].responsable.lastname}}, {{ legajo[0].responsable.name }}</dd>
                    </div>
        
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Documento</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{legajo[0].responsable.num_documento}}</dd>
                    </div>
        
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
                        <!-- <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ store.dateFormateada(legajo[0].responsable.fecha_nac)}}</dd> -->
                    </div>

                </dl>
            </div>
        </div>
    </div>	
    <!-- Fin  Datos Titular -->

    <!-- Datos Autorizaciones -->
    <div class="px-4 mt-6">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Autorizaciones</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles de las autorizaciones Vigentes.</p>
            </div>

            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
        
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Apoyo Escolar</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{legajo[0].autorizacion.apoyo_escolar ? 'SI' : 'NO'}}</dd>
                    </div>
        
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Actividad por Area Empleo</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{legajo[0].autorizacion.actividad_empleo ? 'SI' : 'NO'}}</dd>
                    </div>
        
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Autoriazción Firmada</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{legajo[0].autorizacion.autorizacion_firmada ? 'SI' : 'NO'}}</dd>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Autorización para Retirarse</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{legajo[0].autorizacion.autorizacion_retirarse ? 'SI' : 'NO'}}</dd>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Autorización Uso de Imagen</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{legajo[0].autorizacion.autorizacion_uso_imagen ? 'SI' : 'NO'}}</dd>
                    </div>
                </dl>
            </div>
            
        </div>
    </div>	
    <!-- Fin  Autorizaciones -->

    <!-- Datos Salud -->
    <div class="px-4 mt-6">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Salud/Educacion</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles Salud y Educación.</p>
            </div>

            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
        
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Apto Medico</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{legajo[0].person?.salud.apto_medico ? 'SI' : 'NO'}}</dd>
                    </div>
        
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fecha Apto Médico</dt>
                        <!-- <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ store.dateFormateada(legajo[0].person?.salud.fecha_apto_medico ) ?? '-' }}</dd> -->
                    </div>
        
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Electrocardiograma</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{legajo[0].person?.salud.electrocardiograma ? 'SI' : 'NO'}}</dd>
                    </div>
        
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fecha Electrocardiograma</dt>
                        <!-- <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ store.dateFormateada(legajo[0].person?.salud.fecha_electrocardiograma ) ?? '-' }}</dd> -->
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Posee CUD</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{legajo[0].person?.cud.posee_cud ? 'SI' : 'NO'}}</dd>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Presento CUD</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{legajo[0].person?.cud.presento_cud ? 'SI' : 'NO'}}</dd>
                    </div>

                    <hr>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Nivel Educativo</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{legajo[0].person?.education[0]?.nivel_educativo?.description ?? '-'}}</dd>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Estado Educativo</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{legajo[0].person?.education[0]?.estado_educativo?.description ?? '-'}}</dd>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Turno</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > {{legajo[0].person?.education[0]?.escuela_turno?.description ?? '-'}}</dd>
                    </div>
                </dl>
            </div>
            
        </div>
    </div>	
    <!-- Fin  Salud -->

    <!-- Datos Beneficiario -->
    <div class="px-4 mt-6">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Programas Sociales</h3>
            </div>

            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
        
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Programa Social</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" > <ul><li>- Vivienda</li><li>- Progresar</li></ul></dd>
                    </div>
                </dl>
            </div>
            
        </div>
    </div>			
    <!-- Fin Datos Beneficiario -->    




</div>
  
</template>

<script setup>
import store from '@/store.js'

const props = defineProps({
	legajo: Object,
});

const legajo = props.legajo;

</script>

<style>

</style>