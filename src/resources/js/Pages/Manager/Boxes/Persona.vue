<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="px-4 mt-6 sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
          <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Resultado</h3>
          </div>
          <div class="border-t border-gray-200">
            <dl>
              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
                <dd class="mt-1 text-base  text-gray-900 sm:mt-0 sm:col-span-2">Juan Perez</dd>
              </div>
              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Documento</dt>
                <dd class="mt-1 text-base text-gray-900 sm:mt-0 sm:col-span-2">12.345.678</dd>
              </div>
              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                <dd class="mt-1 text-base text-gray-900 sm:mt-0 sm:col-span-2">Av. Manuel Bellet 1234 - Olivos</dd>
              </div>
              <!-- <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Salary expectation</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">$120,000</dd>
              </div>
              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">About</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Fugiat ipsum ipsum deserunt culpa aute sint do nostrud anim incididunt cillum culpa consequat. Excepteur qui ipsum aliquip consequat sint. Sit id mollit nulla mollit nostrud in ea officia proident. Irure nostrud pariatur mollit ad adipisicing reprehenderit deserunt qui eu.</dd>
              </div> -->
            </dl>
          </div>
        </div>
        <div class="mt-6">
            <button class="bg-green-600 text-white px-4 rounded-md py-4 flex items-center w-full justify-center">
                <CheckCircleIcon class="h-5 w-5 text-white mr-3" aria-hidden="true" />
                Entregar
            </button>
        </div>
    </div>
  </template>
  
  <script>
  import { CheckCircleIcon } from '@heroicons/vue/24/solid'
  
  export default {
    components: {
        CheckCircleIcon,
    },
  }
  </script>