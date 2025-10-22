<script setup>
import { ref, onMounted } from "vue";
import { VueUiDonut } from "vue-data-ui";
import "vue-data-ui/style.css";

const loading = ref(true);
const error = ref(null);

const config = ref({
    style: {
        fontFamily: "inherit",
        chart: {
            backgroundColor: "#FFFFFF",
            color: "#374151",
            layout: {
                labels: {
                    dataLabels: {
                        show: true,
                        fontSize: 10,
                        color: "#FFFFFF"
                    },
                    name: {
                        show: true,
                        fontSize: 11,
                        color: "#374151",
                        bold: true,
                        offsetY: 0
                    },
                    value: {
                        show: true,
                        fontSize: 13,
                        color: "#374151",
                        bold: true,
                        offsetY: 18
                    },
                    percentage: {
                        show: true,
                        fontSize: 9,
                        color: "#6B7280",
                        bold: false,
                        offsetY: 32
                    }
                },
                donut: {
                    strokeWidth: 60,
                    borderWidth: 1,
                    useForeignObject: true
                }
            },
            legend: {
                show: false,
                backgroundColor: "#FFFFFF",
                color: "#374151",
                fontSize: 12,
                bold: false,
                roundingValue: 0,
                roundingPercentage: 1
            },
            title: {
                text: "Trámites por Dependencia",
                color: "#1F2937",
                fontSize: 18,
                bold: true,
                textAlign: "left",
                paddingLeft: 0,
                paddingTop: 0,
                paddingBottom: 12,
                subtitle: {
                    text: "Últimos 30 días",
                    color: "#6B7280",
                    fontSize: 14,
                    bold: false
                }
            },
            tooltip: {
                show: true,
                backgroundColor: "#2D3748",
                color: "#FFFFFF",
                fontSize: 12,
                showValue: true,
                showPercentage: true,
                roundingValue: 0,
                roundingPercentage: 1
            }
        }
    },
    userOptions: {
        show: true,
        buttons: {
            pdf: true,
            img: true,
            csv: true,
            table: true,
            fullscreen: true
        },
        buttonTitles: {
            open: "Abrir opciones",
            close: "Cerrar opciones",
            tooltip: "Mostrar tooltip",
            pdf: "Descargar PDF",
            csv: "Descargar CSV",
            img: "Descargar PNG",
            table: "Mostrar tabla",
            fullscreen: "Pantalla completa"
        }
    },
    table: {
        show: false,
        th: {
            backgroundColor: "#F3F4F6",
            color: "#374151"
        },
        td: {
            backgroundColor: "#FFFFFF",
            color: "#374151"
        }
    }
});

const dataset = ref([]);

const fetchData = async () => {
    try {
        loading.value = true;
        error.value = null;

        const response = await fetch('/dashboard/getTramitesPorDependenciaData');

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if (!data || data.length === 0) {
            throw new Error('No hay datos disponibles');
        }

        dataset.value = data;

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
        <div v-else style="width: 100%; min-height: 400px;">
            <VueUiDonut :config="config" :dataset="dataset" />
        </div>
    </div>
</template>
