<script setup>
import { ref, onMounted, computed, watch } from "vue";
import { VueUiStackbar } from "vue-data-ui";
import "vue-data-ui/style.css";

const dataset = ref([]);
const originalData = ref(null);
const loading = ref(true);
const error = ref(null);
const categories = ref([]);
const visibleOccupations = ref([]);

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
                        text: 'Cantidad de Personas',
                        color: '#374151'
                    },
                    axisLabels: {
                        color: '#374151'
                    }
                },
                y: {
                    axisColor: '#D1D5DB',
                    axisName: {
                        text: 'Ocupaciones',
                        color: '#374151'
                    },
                    timeLabels: {
                        color: '#374151',
                        values: []
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
                text: 'Ocupaciones por Rangos de Edad (Barras Verticales)',
                color: '#1F2937',
                textAlign: 'left',
                paddingLeft: 24,
                subtitle: {
                    text: 'Distribución de personas ocupadas según grupo etario - Filtrable',
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
    },
    orientation: 'horizontal'
});

// Watcher para actualizar el gráfico cuando cambien las ocupaciones visibles
watch([visibleOccupations, originalData], () => {
    updateChart();
}, { deep: true });

const updateChart = () => {
    if (!originalData.value) {
        return;
    }

    if (visibleOccupations.value.length === 0) {
        // Cuando no hay ocupaciones seleccionadas, crear un dataset válido pero vacío
        dataset.value = originalData.value.series.map(serie => ({
            name: serie.name,
            series: [],
            color: serie.color
        }));
        config.value.style.chart.grid.y.timeLabels.values = [];
        return;
    }

    const filteredCategories = originalData.value.categories.filter((category, index) =>
        visibleOccupations.value.includes(index)
    );

    const filteredSeries = originalData.value.series.map(serie => ({
        name: serie.name,
        series: serie.data.filter((value, index) => visibleOccupations.value.includes(index)),
        color: serie.color
    }));

    // Actualizar categorías en la configuración
    config.value.style.chart.grid.y.timeLabels.values = filteredCategories;

    // Actualizar dataset
    dataset.value = filteredSeries;
};

const toggleOccupation = (index, isVisible) => {
    if (isVisible) {
        if (!visibleOccupations.value.includes(index)) {
            visibleOccupations.value.push(index);
        }
    } else {
        const indexPos = visibleOccupations.value.indexOf(index);
        if (indexPos > -1) {
            visibleOccupations.value.splice(indexPos, 1);
        }
    }
};

const toggleAllOccupations = (showAll) => {
    if (showAll) {
        visibleOccupations.value = Array.from({length: categories.value.length}, (_, i) => i);
    } else {
        visibleOccupations.value = [];
    }
};

const allSelected = computed(() =>
    visibleOccupations.value.length === categories.value.length
);

const noneSelected = computed(() =>
    visibleOccupations.value.length === 0
);

const isOccupationVisible = (index) => {
    return visibleOccupations.value.includes(index);
};

const shouldShowChart = computed(() => {
    return !loading.value &&
           !error.value &&
           originalData.value &&
           dataset.value.length > 0 &&
           visibleOccupations.value.length > 0 &&
           dataset.value.every(serie => Array.isArray(serie.series));
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

        // Guardar datos originales
        originalData.value = data;
        categories.value = data.categories;

        // Inicializar todas las ocupaciones como visibles
        visibleOccupations.value = Array.from({length: data.categories.length}, (_, i) => i);

        // El watcher se encargará de actualizar el gráfico

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
    <div class="col-span-2">
        <!-- Controles de filtro -->
        <div v-if="!loading && !error && categories.length > 0" class="mb-4 p-4 bg-gray-50 rounded-lg">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-medium text-gray-700">Filtrar Ocupaciones:</h3>
                <div class="flex gap-2">
                    <button
                        @click="toggleAllOccupations(true)"
                        :disabled="allSelected"
                        class="px-3 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600 disabled:bg-gray-300 disabled:cursor-not-allowed"
                    >
                        Mostrar Todas
                    </button>
                    <button
                        @click="toggleAllOccupations(false)"
                        :disabled="noneSelected"
                        class="px-3 py-1 text-xs bg-gray-500 text-white rounded hover:bg-gray-600 disabled:bg-gray-300 disabled:cursor-not-allowed"
                    >
                        Ocultar Todas
                    </button>
                </div>
            </div>

            <!-- Grid de checkboxes para ocupaciones -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 max-h-48 overflow-y-auto">
                <label
                    v-for="(category, index) in categories"
                    :key="index"
                    class="flex items-center text-xs cursor-pointer hover:bg-gray-100 p-2 rounded"
                >
                    <input
                        type="checkbox"
                        :checked="isOccupationVisible(index)"
                        @change="toggleOccupation(index, $event.target.checked)"
                        class="mr-2 h-3 w-3 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    >
                    <span class="truncate" :title="category">{{ category }}</span>
                </label>
            </div>

            <!-- Contador de ocupaciones visibles -->
            <div class="mt-2 text-xs text-gray-500">
                {{ visibleOccupations.length }} de {{ categories.length }} ocupaciones mostradas
            </div>
        </div>

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
        <div v-else-if="noneSelected || !shouldShowChart" class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="text-yellow-800">
                <p class="font-medium">
                    {{ noneSelected ? 'No hay ocupaciones seleccionadas' : 'No hay datos disponibles' }}
                </p>
                <p class="text-sm mt-1">
                    {{ noneSelected ? 'Selecciona al menos una ocupación para mostrar el gráfico.' : 'No se encontraron personas con ocupaciones registradas para mostrar en el gráfico.' }}
                </p>
            </div>
        </div>

        <!-- Gráfico -->
        <div v-else-if="shouldShowChart" style="width: 100%; min-height: 600px;">
            <VueUiStackbar :config="config" :dataset="dataset" />

            <!-- Información adicional -->
            <div class="mt-4 text-sm text-gray-600">
                <p>
                    <strong>Ocupaciones mostradas:</strong> {{ visibleOccupations.length }} de {{ categories.length }}
                </p>
                <p>
                    <strong>Rangos de edad:</strong> 18-24, 25-34, 35-49, 50-59, 60-64, 65+ años
                </p>
            </div>
        </div>
    </div>
</template>
