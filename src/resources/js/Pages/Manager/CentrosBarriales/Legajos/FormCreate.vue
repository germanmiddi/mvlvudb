<template>
<div class="min-w-0 flex-1 h-full flex flex-col overflow-hidden xl:order-last mt-10 px-4">
    <div class="min-h-0 flex-1 overflow-y-auto">
        <div class="shadow mt-2 rounded-lg">
            <div class="bg-white pt-5 pb-6 mt-2  px-4">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Nueva Inscripción</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum, odit magnam.</p>
                </div>            
            
                <div class="grid grid-cols-3 gap-4 pt-5">
                    <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Fecha: </label>
                    <div class="mt-1 col-span-2">
                        <input type="text" name="first-name" id="first-name" autocomplete="given-name" 
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-lg sm:text-sm border-gray-300 rounded-md" />
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4 pt-5">
                    <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Fecha: </label>
                    <div class="mt-1 col-span-2">
                        <input type="text" name="first-name" id="first-name" autocomplete="given-name" 
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-lg sm:text-sm border-gray-300 rounded-md" />
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4 pt-5">
                    <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Fecha: </label>
                    <div class="mt-1 col-span-2">
                        <input type="text" name="first-name" id="first-name" autocomplete="given-name" 
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-lg sm:text-sm border-gray-300 rounded-md" />
                    </div>
                </div>
                
                <div class="grid grid-cols-3 gap-4 py-5">
                    <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Profesional: </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <input type="text" name="first-name" id="first-name" autocomplete="given-name" 
                            class="w-full block shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-lg sm:text-sm border-gray-300 rounded-md" />
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-end">
                <button type="submit" @click="$emit('closeForm')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
            </div>

        </div>

    </div>
</div>
</template>

<script>
export default {

}
</script>

<style>

</style>