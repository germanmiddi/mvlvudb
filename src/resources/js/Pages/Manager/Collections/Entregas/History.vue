<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="px-4 my-6 sm:px-6 lg:px-8">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">
            Historial de entregas
        </h3>
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
          <ul role="list" class="divide-y divide-gray-200">
            <li v-for="item in history" :key="item.id">
              <a href="#" class="block hover:bg-gray-50">
                <div class="px-4 py-4 flex items-center sm:px-6">
                  <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                    <div class="truncate">
                      <p  v-if="item.person" class="font-sm text-gray-900 mb-2">Entregado a {{ item.person.name }} {{ item.person.lastname }}</p>
                      <div class="flex text-sm">
                        <div class="flex items-center text-indigo-600 font-medium">
                          
                        
                          <!-- <component :is="position.icon" class="h-5 w-5 text-indigo-800 mr-2" aria-hidden="true" /> -->
                          <component :is="icons[item.product.id]" class="h-5 w-5 text-indigo-800 mr-2" aria-hidden="true" />
                          {{ item.product.name }}
                        </div>
                        <p class="font-normal truncate ml-2"> {{ item.punto_entrega.description }}</p>
                        <p class="ml-1 flex-shrink-0 font-normal text-gray-500">por {{ item.user.name }}</p>
                      </div>
                      <div class="mt-2 flex">
                        <div class="flex items-center text-sm text-gray-500">
                          <CalendarIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                          <p>
                            Entregado el
                            {{ ' ' }}
                            <span>{{ fulldate(item.date) }}</span>
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="mt-4 flex-shrink-0 sm:mt-0 sm:ml-5">
                      <div class="flex overflow-hidden -space-x-1">
                        
                      </div>
                    </div>
                  </div>
                  <div class="ml-5 flex-shrink-0">
                    <!-- <ChevronRightIcon class="h-5 w-5 text-gray-400" aria-hidden="true" /> -->
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </div>
    </div>
  </template>
  
  <script>
  import { CalendarIcon, ChevronRightIcon, ArchiveBoxIcon, SparklesIcon } from '@heroicons/vue/24/solid'
  
  const icons = {
    1: ArchiveBoxIcon,
    2: SparklesIcon
  }
  
  export default {
    props: {
        history: {
            type: Object,
            required: true
        }
    },
    components: {
      CalendarIcon,
      ChevronRightIcon,
      ArchiveBoxIcon,
      SparklesIcon,
    },
    setup() {

      const fulldate = (date) => {
        return new Date(date).toLocaleDateString('es-ES', { day: '2-digit', month: 'long', year: 'numeric' });
      }
      return {
        icons,
        fulldate
      }
    },
  }
  </script>