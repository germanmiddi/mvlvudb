<template>
    <div class="col-span-1 bg-white rounded-lg shadow divide-y divide-gray-200">
          <div class="w-full flex items-center justify-between p-6 space-x-6">
              <div class="flex-1 truncate">
                  <div class="flex items-center space-x-3">
                      <h3 class="text-gray-900 text-base font-medium truncate">{{ programa.programa_social?.description ?? '-' }}</h3>
                      <span v-if="programa.estado.id === 1" class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 text-xs font-medium bg-green-100 rounded-full">
                          {{programa.estado.description}}</span>
                        <span v-else class="flex-shrink-0 inline-block px-2 py-0.5 text-red-800 text-xs font-medium bg-red-100 rounded-full">
                            {{programa.estado.description}}</span>
                  </div>
                  <p class="mt-1 text-gray-500 text-xs truncate">{{ programa.programa_social?.description ?? '-' }}</p>
                  <div class="mt-3">
                      <div class="flex text-sm">
                          <UserCircleIcon class="w-5 text-gray-300"/> <span class="ml-2">{{ store.capitalize(programa.profesional?.name ?? '-') }}</span>
                      </div>
                      <div class="flex text-sm mt-1">
                          <CalendarIcon class="w-5 text-gray-300"/><span class="ml-2">{{store.dateTimeFormateada(programa.fecha_inscripcion)}}</span>
                      </div>
                  </div>
              </div>
              <!-- <img class="w-10 h-10 bg-gray-300 rounded-full flex-shrink-0" :src="programa.imageUrl" alt="" /> -->
          </div>
          <div>
              <div class="-mt-px flex divide-x divide-gray-200">
                  <div class="w-0 flex-1 flex">
                      <button @click="fnDetails(programa)"
                          class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                          <!-- <MailIcon class="w-5 h-5 text-gray-400" aria-hidden="true" /> -->
                          <span  class="ml-3">Detalle</span>
                      </button>
                  </div>
                  <div class="-ml-px w-0 flex-1 flex">
                      <button  @click="fnIntervencion(programa)"
                          class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                          <!-- <PhoneIcon class="w-5 h-5 text-gray-400" aria-hidden="true" /> -->
                          <span class="ml-3">Interveción</span>
                      </button>
                  </div>
              </div>
          </div>
      </div>
</template>

<script>

import {UserCircleIcon,
   CalendarIcon } from '@heroicons/vue/24/solid'
   import store from '@/store.js'

export default {

    props: {
        programa: Object
    },
    components: {
        UserCircleIcon,
        CalendarIcon
    },
    data() {
        return {
            showDetail: Boolean,
            showEditor: Boolean
        }
    },
    setup() {
        return {
            store
        }
    },
    methods: {
        fnIntervencion(data){
            this.$emit('fnEditor', {'action':'new_intervencion', 'data': data})
        },
        fnDetails(data){
            this.$emit('fnEditor', {'action':'detail', 'data': data})
        }
    },
}

</script>

<style>

</style>
