<script setup>
import { ref, onMounted, computed } from "vue";
import { Line } from 'vue-chartjs';
import { Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend, Filler } from 'chart.js';

// Registrar componentes de Chart.js
ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend, Filler);

const loading = ref(true);
const error = ref(null);

const chartData = ref({
    labels: [],
    datasets: []
});

const chartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        title: {
            display: true,
            text: 'Evolución de Trámites',
            font: {
                size: 18,
                weight: 'bold'
            },
            color: '#1F2937',
            padding: {
                top: 10,
                bottom: 20
            }
        },
        subtitle: {
            display: true,
            text: 'Cantidad de trámites registrados por mes',
            font: {
                size: 14
            },
            color: '#6B7280',
            padding: {
                bottom: 20
            }
        },
        legend: {
            display: true,
            position: 'bottom',
            labels: {
                color: '#374151',
                padding: 15,
                font: {
                    size: 12
                }
            }
        },
        tooltip: {
            backgroundColor: '#2D3748',
            titleColor: '#FFFFFF',
            bodyColor: '#FFFFFF',
            borderColor: '#4B5563',
            borderWidth: 1,
            padding: 12,
            displayColors: true,
            callbacks: {
                label: function(context) {
                    return context.dataset.label + ': ' + context.parsed.y.toLocaleString() + ' trámites';
                }
            }
        }
    },
    scales: {
        x: {
            grid: {
                display: true,
                color: '#E5E7EB'
            },
            ticks: {
                color: '#6B7280',
                font: {
                    size: 11
                }
            }
        },
        y: {
            beginAtZero: true,
            grid: {
                display: true,
                color: '#E5E7EB'
            },
            ticks: {
                color: '#6B7280',
                font: {
                    size: 11
                },
                callback: function(value) {
                    return value.toLocaleString();
                }
            }
        }
    }
});

const fetchData = async () => {
    try {
        loading.value = true;
        error.value = null;

        const response = await fetch('/dashboard/getEvolucionTramitesData');

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if (!data || !data.categories || !data.series) {
            throw new Error('No hay datos disponibles');
        }

        // Transformar al formato de Chart.js
        chartData.value = {
            labels: data.categories,
            datasets: data.series.map(serie => ({
                label: serie.name,
                data: serie.values,
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 4,
                pointBackgroundColor: '#3B82F6',
                pointBorderColor: '#FFFFFF',
                pointBorderWidth: 2,
                pointHoverRadius: 6
            }))
        };

    } catch (err) {
        console.error('Error fetching chart data:', err);
        error.value = err.message || 'Error al cargar los datos del gráfico';
        chartData.value = {
            labels: [],
            datasets: []
        };
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchData();
});
</script>

<template>
    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
        <!-- Estado de carga -->
        <div v-if="loading" class="flex items-center justify-center p-8">
            <div class="text-gray-600">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto mb-2"></div>
                Cargando datos del gráfico...
            </div>
        </div>

        <!-- Estado de error -->
        <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <div class="text-red-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Error al cargar el gráfico</h3>
                    <p class="text-sm text-red-700 mt-1">{{ error }}</p>
                    <button
                        @click="fetchData"
                        class="mt-2 text-sm text-red-800 underline hover:text-red-900"
                    >
                        Intentar nuevamente
                    </button>
                </div>
            </div>
        </div>

        <!-- Gráfico -->
        <div v-else style="width: 100%; height: 400px;">
            <Line :data="chartData" :options="chartOptions" />
        </div>
    </div>
</template>
