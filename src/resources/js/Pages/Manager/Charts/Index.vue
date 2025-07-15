<script setup>
import ChartAdultosOcupados from "./ChartAdultosOcupados.vue";
import ChartOcupacionesDonut from "./ChartOcupacionesDonut.vue";
import ChartSinOcupacionHeatMap from "./ChartSinOcupacionHeatMap.vue";
</script>

<template>

    <main class="flex-1">
        <!-- Page title & actions -->
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Gráficos de Ocupación
                </h1>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
            <ChartAdultosOcupados />
            <ChartOcupacionesDonut />
            <ChartSinOcupacionHeatMap />
        </div>
    </main>

</template>
