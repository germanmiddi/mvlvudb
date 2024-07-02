<template>
      <ul v-if="!showDetail" role="list" class="grid gap-6 grid-cols-2 mt-10 px-4">
        <li v-for="programa in programas" :key="programa.email"
            class="col-span-1 bg-white rounded-lg shadow divide-y divide-gray-200">
            <div class="w-full flex items-center justify-between p-6 space-x-6">
                <div class="flex-1 truncate">
                    <div class="flex items-center space-x-3">
                        <h3 class="text-gray-900 text-base font-medium truncate">{{ programa.name }}</h3>
                        <span v-if="programa.role"
                            class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 text-xs font-medium bg-green-100 rounded-full">
                            {{ programa.role }}</span>
                    </div>
                    <p class="mt-1 text-gray-500 text-sm truncate">{{ programa.title }}</p>
                    <div class="mt-3">
                        <div class="flex text-sm">
                            <UserCircleIcon class="w-5 text-gray-300"/> <span class="ml-2">Valeria Perez</span>
                        </div>
                        <div class="flex text-sm mt-1">
                            <CalendarIcon class="w-5 text-gray-300"/><span class="ml-2">01/06/2024</span>
                        </div>
                    </div>
                </div>
                <!-- <img class="w-10 h-10 bg-gray-300 rounded-full flex-shrink-0" :src="programa.imageUrl" alt="" /> -->
            </div>
            <div>
                <div class="-mt-px flex divide-x divide-gray-200">
                    <div class="w-0 flex-1 flex">
                        <button @click="showDetail = !showDetail, showEditor = false"
                            class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                            <!-- <MailIcon class="w-5 h-5 text-gray-400" aria-hidden="true" /> -->
                            <span  class="ml-3">Detalle</span>
                        </button>
                    </div>
                    <div class="-ml-px w-0 flex-1 flex">
                        <button
                            class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                            <!-- <PhoneIcon class="w-5 h-5 text-gray-400" aria-hidden="true" /> -->
                            <span class="ml-3">Interveción</span>
                        </button>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</template>

<script>


export default {
    data() {
        return {
            programas,
            showDetail: false,
            showEditor: false,
        }
    }
}

</script>

<style>

</style>