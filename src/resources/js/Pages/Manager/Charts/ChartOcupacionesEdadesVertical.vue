<script setup>
import { ref, onMounted } from "vue";
import { VueUiStackbar } from "vue-data-ui";
import "vue-data-ui/style.css";

const loading = ref(true);
const error = ref(null);

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
            zoom:{
                show: false
            },
            backgroundColor: '#FFFFFF',
            color: '#374151',
            padding: {
                top: 24,
                right: 48,
                bottom: 48,
                left: 200  // Más espacio para los nombres largos
            },
            grid: {
                x: {
                    axisColor: '#D1D5DB',
                    axisName: {
                        text: 'Cantidad de Personas',
                        color: '#374151'
                    },
                    timeLabels: {
                        color: '#374151',
                        fontSize: 11,
                        bold: false,
                        values: []  // Aquí pondremos las ocupaciones
                    }
                },
                y: {
                    axisColor: '#D1D5DB',
                    axisName: {
                        show: false,
                        text: 'Ocupaciones',
                        color: '#374151'
                    },
                    axisLabels: {
                        color: '#374151',
                        fontSize: 11
                    }
                }
            },
            highlighter: {
                color: '#1F2937',
                opacity: 5
            },
            legend: {
                show: false,
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
                gapRatio: 0.5,
                borderRadius: 4,
                showDistributedPercentage: true,
                distributed: true,
                totalValues: {
                    color: '#374151',
                    fontSize: 11,
                    bold: false
                },
                dataLabels: {
                    color: '#374151',
                    fontSize: 12,
                    bold: false,
                    hideEmptyValues: true,
                    hideEmptyPercentage: true
                }
            }
        }
    },
    orientation: 'horizontal',
    userOptions:{
        buttonTitles:{
            open: 'Abrir opciones',
            close: 'Cerrar opciones',
            tooltip: 'Mostrar tooltip',
            pdf: 'Descargar PDF',
            csv: 'Descargar CSV',
            img: 'Descargar PNG',
            table: 'Mostrar tabla',
            labels: 'Mostrar etiquetas',
            fullscreen: 'Pantalla completa',
            annotator: 'Mostrar anotador'
        }
    }
});

const dataset = ref([]);

const truncateOccupationName = (name) => {
    if (!name) return '';
    // Truncar nombres muy largos para mejorar la visualización
    if (name.length > 22) {
        return name.substring(0, 19) + '...';
    }
    return name;
};

const fetchData = async () => {
    try {
        loading.value = true;
        error.value = null;

        const response = await fetch('/charts/getChartOcupacionesPorEdadData');

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log('Data received:', data);

        if (!data || !data.categories || !data.series) {
            throw new Error('Datos inválidos recibidos del servidor');
        }

        // Establecer las ocupaciones como timeLabels del eje X
        const truncatedCategories = data.categories.map(category => truncateOccupationName(category));
        config.value.style.chart.grid.x.timeLabels.values = truncatedCategories;
        console.log('Setting timeLabels to:', truncatedCategories);

        // Configurar el dataset directamente
        const colors = ['#3B82F6', '#EF4444', '#10B981', '#F59E0B', '#8B5CF6', '#EC4899'];
        dataset.value = data.series.map((serie, index) => ({
            name: serie.name,
            series: serie.data,
            color: colors[index % colors.length]
        }));
        console.log('Dataset configured:', dataset.value);

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
    <div class="col-span-2 border border-gray-200 rounded-md p-4">
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

        <!-- Gráfico -->
        <div v-else style="width: 100%; min-height: 700px;">
            <VueUiStackbar :config="config" :dataset="dataset" />

            <!-- Información adicional -->
            <div class="mt-4 text-sm text-gray-600 bg-gray-50 p-4 rounded-lg">
                <p class="mb-2 text-center">
                    <strong>Rangos de edad:</strong>
                    <span class="inline-flex items-center gap-3 ml-2">
                        <span class="flex items-center"><span class="w-3 h-3 bg-blue-500 rounded mr-1"></span>18-24</span>
                        <span class="flex items-center"><span class="w-3 h-3 bg-red-500 rounded mr-1"></span>25-34</span>
                        <span class="flex items-center"><span class="w-3 h-3 bg-green-500 rounded mr-1"></span>35-49</span>
                        <span class="flex items-center"><span class="w-3 h-3 bg-yellow-500 rounded mr-1"></span>50-59</span>
                        <span class="flex items-center"><span class="w-3 h-3 bg-purple-500 rounded mr-1"></span>60-64</span>
                        <span class="flex items-center"><span class="w-3 h-3 bg-pink-500 rounded mr-1"></span>65+</span>
                    </span>
                </p>
            </div>
        </div>
    </div>
</template>
