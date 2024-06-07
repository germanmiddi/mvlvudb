<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Autorizaciones
                    </h3>
                </div>
                <div class="flex-shrink-0">
                    
                </div>
            </div>
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
                    <label for="programa_social_id" class="block text-sm font-medium text-gray-700">Apoyo Escolar</label>
                        <Switch v-model="localData.apoyo_escolar" :disabled="input_disable"
                                @click="localData.apoyo_escolar = !localData.apoyo_escolar"
                                :class="localData.apoyo_escolar ? 'bg-blue-600' : 'bg-gray-200'"
                                class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
                                <span :class="localData.apoyo_escolar ? 'translate-x-6' : 'translate-x-1'"
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
                        </Switch>   
                </div>

                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
                    <label for="programa_social_id" class="block text-sm font-medium text-gray-700">Act. por Area Empleo</label>
                        <Switch v-model="localData.actividad_empleo" :disabled="input_disable"
                                @click="localData.actividad_empleo = !localData.actividad_empleo"
                                :class="localData.actividad_empleo ? 'bg-blue-600' : 'bg-gray-200'"
                                class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
                                <span :class="localData.actividad_empleo ? 'translate-x-6' : 'translate-x-1'"
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
                        </Switch>   
                </div>

                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
                    <label for="programa_social_id" class="block text-sm font-medium text-gray-700">Aut. Firmada</label>
                        <Switch v-model="localData.autorizacion_firmada" :disabled="input_disable"
                                @click="localData.autorizacion_firmada = !localData.autorizacion_firmada"
                                :class="localData.autorizacion_firmada ? 'bg-blue-600' : 'bg-gray-200'"
                                class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
                                <span :class="localData.autorizacion_firmada ? 'translate-x-6' : 'translate-x-1'"
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
                        </Switch>   
                </div>

                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
                    <label for="programa_social_id" class="block text-sm font-medium text-gray-700">Aut. Retirarse</label>
                        <Switch v-model="localData.autorizacion_retirarse" :disabled="input_disable"
                                @click="localData.autorizacion_retirarse = !localData.autorizacion_retirarse"
                                :class="localData.autorizacion_retirarse ? 'bg-blue-600' : 'bg-gray-200'"
                                class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
                                <span :class="localData.autorizacion_retirarse ? 'translate-x-6' : 'translate-x-1'"
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
                        </Switch>   
                </div>

                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
                    <label for="programa_social_id" class="block text-sm font-medium text-gray-700">Aut. Uso Imagen</label>
                        <Switch v-model="localData.autorizacion_uso_imagen" :disabled="input_disable"
                                @click="localData.autorizacion_uso_imagen = !localData.autorizacion_uso_imagen"
                                :class="localData.autorizacion_uso_imagen ? 'bg-blue-600' : 'bg-gray-200'"
                                class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
                                <span :class="localData.autorizacion_uso_imagen ? 'translate-x-6' : 'translate-x-1'"
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
                        </Switch>   
                </div>

                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-2">
                    <label for="programa_social_id" class="block text-sm font-medium text-gray-700">Inscripcion Comedor</label>
                        <Switch v-model="localData.inscripcion_comedor" :disabled="input_disable"
                                @click="localData.inscripcion_comedor = !localData.inscripcion_comedor"
                                :class="localData.inscripcion_comedor ? 'bg-blue-600' : 'bg-gray-200'"
                                class="relative inline-flex h-6 w-11 mt-3 items-center rounded-full">
                                <span :class="localData.inscripcion_comedor ? 'translate-x-6' : 'translate-x-1'"
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
                        </Switch>   
                </div>

                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
                    <label for="comedor_id" class="block text-sm font-medium text-gray-700">Comedor</label>
                    <select v-model="localData.comedor_id" id="comedor_id" name="comedor_id"
                        autocomplete="off"
                        :disabled="input_disable"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" disabled>
                            Seleccione un comedor
                        </option>
                        <option v-for="comedor in comedores" :key="comedor.id" :value="comedor.id">{{
                            comedor.description
                        }}</option>
                    </select>
                </div>

                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
                    <label for="actividad_cbj" class="block text-sm font-medium text-gray-700">Actividad CBJ</label>
                    <div class="flex items-center mb-2">
                        <select v-model="actividadSelect" id="actividad_cbj" name="actividad_cbj"
                            autocomplete="off"
                            :disabled="input_disable"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione un tipo de documento
                            </option>
                            <option v-for="actividad in actividadesCbj" :key="actividad.id"
                                :value="actividad ">
                                {{ actividad.description }}
                            </option>
                        </select>
                        <a class="ml-2 items-center" @click="addActividad"><PlusCircleIcon class="h-8 w-8 text-green-700"></PlusCircleIcon></a>
                    </div>
                    <span  v-for="(act, index) in this.actividadesSelected" :key="index" 
                        class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-700/10 mr-2 mt-2">
                        {{act.description}} <TrashIcon @click="removeActividad(act)" class="h-5 w-5 text-red-700 ml-2"></TrashIcon>
                    </span>
                </div>

                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
                    <label for="aconpanamiento_id" class="block text-sm font-medium text-gray-700">Acompañamiento CBJ</label>
                    <div class="flex items-center mb-2">
                        <select v-model="acompanamientoSelect" id="aconpanamiento_id" name="aconpanamiento_id"
                            autocomplete="off"
                            
                            :disabled="input_disable"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione un tipo de documento
                            </option>
                            <option v-for="acompanamiento in acompanamientosCbj" :key="acompanamiento.id"
                                :value="acompanamiento">
                                {{ acompanamiento.description }}
                            </option>
                        </select>
                        <a class="ml-2 items-center" @click="addAcompanamiento"><PlusCircleIcon class="h-8 w-8 text-green-700"></PlusCircleIcon></a>
                    </div>
                    <span  v-for="(act, index) in this.acompanamientosSelected" :key="index" 
                        class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-700/10 mr-2 mt-2">
                        {{act.description}} <TrashIcon @click="removeAcompanamiento(act)" class="h-5 w-5 text-red-700 ml-2"></TrashIcon>
                    </span>
                </div>

                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
                    <label for="taller_id" class="block text-sm font-medium text-gray-700">Talleres</label>
                    <div class="flex items-center mb-2">
                        <select v-model="tallerSelect" id="taller_id" name="taller_id"
                            autocomplete="off"
                            
                            :disabled="input_disable"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none inline-flex focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled>
                                Seleccione un taller
                            </option>
                            <option value="Ajedrez">Ajedrez</option>
                            <option value="Arte">Arte</option>
                            <option value="Huerta">Huerta</option>
                            <option value="Ensamble_musical">Ensamble musical</option>
                            <option value="Indumentaria">Indumentaria</option>
                            <option value="Futbol">Futbol</option>
                            <option value="Percusion">Percusion</option>
                            <option value="Tecnologia">Tecnologia</option>
                            <option value="Artesanias">Artesanias</option>
                            <option value="Carpinteria">Carpinteria</option>
                            <option value="Manicuria">Manicuria</option>
                            <option value="Programacion">Programacion</option>
                            <option value="Panaderia">Panaderia</option>
                            <option value="Coreografia">Coreografia</option>
                            <option value="Cocina">Cocina</option>
                            <option value="Barberia">Barberia</option>
                            <option value="Karate">Karate</option>
                            <option value="Ping_Pong">Ping Pong</option>
                            <option value="Musica">Musica</option>
                            <option value="Reparacion_de_PC">Reparacion de PC</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <a class="ml-2 items-center" @click="addTaller"><PlusCircleIcon class="h-8 w-8 text-green-700"></PlusCircleIcon></a>
                    </div>
                    <span  v-for="(act, index) in this.talleresSelected" :key="index" 
                        class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-700/10 mr-2 mt-2">
                        {{act}} <TrashIcon @click="removeTaller(act)" class="h-5 w-5 text-red-700 ml-2"></TrashIcon>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  props: {
    form: Object,
    input_disable: Boolean,
    comedores: Object
  },
  data() {
    return {
      localData: this.data,
      //input_disable: this.disabled
    };
  },
  watch: {
    value(newValue) {
      this.localData = newValue;
    }
  },
  created() {
    // Inicializar localForm con los valores del form prop si existen
    this.localData = this.form;
    //if (this.form.email) this.localForm.email = this.form.email;
  },
  methods: {
    updateParent() {
      this.$emit('data_autorizaciones', this.localData);
    }
  }
};
</script>