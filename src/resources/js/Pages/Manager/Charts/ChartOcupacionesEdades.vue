<script setup>
import { ref, onMounted } from "vue";
import { VueUiStackbar } from "vue-data-ui";
import "vue-data-ui/style.css";

const dataset = ref([]);
const loading = ref(true);
const error = ref(null);
const categories = ref([]);

const config = ref({
    table: {
        th: {
            backgroundColor: '#FFFFFF',
            color: '#374151'
        },
        td: {
            backgroundColor: '#FFFFFF',
            color: '#374151'
        }
    },
    style: {
        chart: {
            backgroundColor: '#FFFFFF',
            color: '#374151',
            grid: {
                x: {
                    axisColor: '#D1D5DB',
                    axisName: {
                        text: 'Ocupaciones',
                        color: '#374151'
                    },
                    timeLabels: {
                        color: '#374151',
                        values: []
                    }
                },
                y: {
                    axisColor: '#D1D5DB',
                    axisName: {
                        text: 'Cantidad de Personas',
                        color: '#374151'
                    },
                    axisLabels: {
                        color: '#374151'
                    }
                }
            },
            highlighter: {
                color: '#1F2937',
                opacity: 5
            },
            legend: {
                backgroundColor: '#FFFFFF',
                color: '#374151'
            },
            title: {
                text: 'Ocupaciones por Rangos de Edad',
                color: '#1F2937',
                textAlign: 'left',
                paddingLeft: 24,
                subtitle: {
                    text: 'Distribución de personas ocupadas según grupo etario',
                    color: '#6B7280'
                }
            },
            tooltip: {
                backgroundColor: '#FFFFFF',
                color: '#374151',
                borderColor: '#D1D5DB',
                backgroundOpacity: 95
            },
            bars: {
                totalValues: {
                    color: '#374151'
                }
            }
        }
    }
});

const fetchData = async () => {
    try {
        loading.value = true;
        error.value = null;

        const response = await fetch('/charts/getChartOcupacionesPorEdadData');

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if (!data || !data.categories || !data.series) {
            throw new Error('Datos inválidos recibidos del servidor');
        }

        // Actualizar categorías para los labels del eje X
        categories.value = data.categories;
        config.value.style.chart.grid.x.timeLabels.values = data.categories;

        // Transformar datos al formato esperado por VueUiStackbar
        dataset.value = data.series.map(serie => ({
            name: serie.name,
            series: serie.data,
            color: serie.color
        }));

    } catch (err) {
        console.error('Error fetching chart data:', err);
        error.value = err.message || 'Error al cargar los datos del gráfico';
        dataset.value = [];
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchData();
});
</script>

<template>
    <div class="col-span-2 px-4">
        <!-- Estado de carga -->
        <div v-if="loading" class="flex items-center justify-center p-8">
            <div class="text-gray-600">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto mb-2"></div>
                Cargando datos del gráfico...
            </div>
        </div>

        <!-- Estado de error -->
        <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
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

        <!-- Estado vacío -->
        <div v-else-if="!dataset.length" class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="text-yellow-800">
                <p class="font-medium">No hay datos disponibles</p>
                <p class="text-sm mt-1">No se encontraron personas con ocupaciones registradas para mostrar en el gráfico.</p>
            </div>
        </div>

        <!-- Gráfico -->
        <div v-else>
            <VueUiStackbar :config="config" :dataset="dataset" />

            <!-- Información adicional -->
            <div class="mt-4 text-sm text-gray-600">
                <p>
                    <strong>Total de ocupaciones:</strong> {{ categories.length }}
                </p>
                <p>
                    <strong>Rangos de edad:</strong> 18-24, 25-34, 35-49, 50-59, 60-64, 65+ años
                </p>
            </div>
        </div>
    </div>
</template>
