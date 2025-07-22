<script setup>
import { ref, onMounted } from "vue";

// Aquí puedes definir props para recibir el número y otros datos
const totalPersons = ref(null); // Ejemplo de número

const loadChartData = async () => {
    const response = await fetch('/charts/getCantPersonsData');
    const data = await response.json();
    totalPersons.value = data;
}

onMounted(async () => {
    await loadChartData();
});



</script>

<template>
    <div class="col-span-2">
        <div class="max-w-md  bg-white rounded-lg border border-gray-200 shadow-sm p-6 ">
            <div class="flex items-center">
                <!-- Icono - 1/3 del ancho -->
                <div class="flex-none w-1/3 flex justify-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                </div>

                <!-- Contenido - 2/3 del ancho -->
                <div class="flex-1 w-2/3 pl-4">
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">
                        {{ totalPersons }}
                    </h1>
                    <p class="text-sm text-gray-600">
                        Cantidad de personas ingresadas al sistema
                    </p>
                </div>
            </div>
        </div>

    </div>
</template>
