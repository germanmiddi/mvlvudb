<script setup>
import { ref, onMounted } from "vue";

const stats = ref({
    totalPersonas: {
        total: 0,
        nuevas: 0
    },
    tramitesMes: {
        cantidad: 0,
        porcentajeCambio: 0,
        tendencia: 'neutral'
    },
    tramitesUltimos30Dias: {
        total: 0,
        abiertos: 0,
        enProceso: 0,
        cerrados: 0
    },
    porcentajeCerrados: 0
});

const loading = ref(true);
const error = ref(null);

const fetchStats = async () => {
    try {
        loading.value = true;
        error.value = null;

        const response = await fetch('/dashboard/getStatsGeneralesData');

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        stats.value = data;

    } catch (err) {
        console.error('Error fetching stats:', err);
        error.value = err.message || 'Error al cargar las estadísticas';
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchStats();
});
</script>

<template>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Tarjeta 1: Total de Personas -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Personas</dt>
                            <dd class="flex items-baseline">
                                <div v-if="loading" class="text-2xl font-semibold text-gray-400">
                                    ...
                                </div>
                                <div v-else class="text-2xl font-semibold text-gray-900">
                                    {{ stats.totalPersonas.total.toLocaleString() }}
                                </div>
                            </dd>
                            <dd v-if="!loading" class="text-xs text-gray-500 mt-1">
                                <span class="text-blue-600 font-medium">+{{ stats.totalPersonas.nuevas }}</span> nuevas (últimos 30 días)
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta 2: Trámites del Mes -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Trámites del Mes</dt>
                            <dd class="flex items-baseline">
                                <div v-if="loading" class="text-2xl font-semibold text-gray-400">
                                    ...
                                </div>
                                <template v-else>
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ stats.tramitesMes.cantidad.toLocaleString() }}
                                    </div>
                                    <div class="ml-2 flex items-baseline text-sm font-semibold"
                                         :class="{
                                             'text-green-600': stats.tramitesMes.tendencia === 'up',
                                             'text-red-600': stats.tramitesMes.tendencia === 'down'
                                         }">
                                        <svg v-if="stats.tramitesMes.tendencia === 'up'" class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <svg v-else-if="stats.tramitesMes.tendencia === 'down'" class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ Math.abs(stats.tramitesMes.porcentajeCambio) }}%</span>
                                    </div>
                                </template>
                            </dd>
                            <dd v-if="!loading" class="text-xs text-gray-500 mt-1">
                                vs mes anterior
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta 3: Estado de Trámites (Últimos 30 días) -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-orange-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Trámites (Últimos 30 días)</dt>
                            <dd class="flex items-baseline">
                                <div v-if="loading" class="text-2xl font-semibold text-gray-400">
                                    ...
                                </div>
                                <div v-else class="text-2xl font-semibold text-gray-900">
                                    {{ stats.tramitesUltimos30Dias.total.toLocaleString() }}
                                </div>
                            </dd>
                            <dd v-if="!loading" class="text-xs text-gray-600 mt-2 space-y-0.5">
                                <div class="flex justify-between">
                                    <span class="text-green-600">● Cerrados:</span>
                                    <span class="font-medium">{{ stats.tramitesUltimos30Dias.cerrados }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-blue-600">● En proceso:</span>
                                    <span class="font-medium">{{ stats.tramitesUltimos30Dias.enProceso }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-yellow-600">● Abiertos:</span>
                                    <span class="font-medium">{{ stats.tramitesUltimos30Dias.abiertos }}</span>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta 4: Tasa de Cierre -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-indigo-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tasa de Cierre</dt>
                            <dd class="flex items-baseline">
                                <div v-if="loading" class="text-2xl font-semibold text-gray-400">
                                    ...
                                </div>
                                <div v-else class="text-2xl font-semibold text-gray-900">
                                    {{ stats.porcentajeCerrados }}%
                                </div>
                            </dd>
                            <dd v-if="!loading" class="text-xs text-gray-500 mt-1">
                                últimos 30 días
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensaje de error global (si es necesario) -->
    <div v-if="error" class="mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex">
            <div class="text-red-600">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Error al cargar estadísticas</h3>
                <p class="text-sm text-red-700 mt-1">{{ error }}</p>
                <button
                    @click="fetchStats"
                    class="mt-2 text-sm text-red-800 underline hover:text-red-900"
                >
                    Intentar nuevamente
                </button>
            </div>
        </div>
    </div>
</template>
