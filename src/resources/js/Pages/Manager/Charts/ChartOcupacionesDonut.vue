<script setup>
import { ref, onMounted } from "vue";
import { VueUiDonut } from "vue-data-ui";
import "vue-data-ui/style.css";

const config = ref({
    "useCssAnimation": true,
    "useBlurOnHover": true,
    "style": {
        "fontFamily": "inherit",
        "chart": {
            "useGradient": true,
            "gradientIntensity": 40,
            "backgroundColor": "#FFFFFF",
            "color": "#1A1A1A",
            "layout": {
                "curvedMarkers": true,
                "labels": {
                    "dataLabels": {
                        "show": true,
                        "hideUnderValue": 3,
                        "prefix": "",
                        "suffix": " personas"
                    },
                    "value": {
                        "show": true,
                        "rounding": 0
                    },
                    "percentage": {
                        "color": "#1A1A1A",
                        "bold": true,
                        "fontSize": 14
                    },
                    "name": {
                        "color": "#1A1A1A",
                        "bold": false,
                        "fontSize": 14
                    },
                    "hollow": {
                        "total": {
                            "show": true,
                            "bold": false,
                            "fontSize": 12,
                            "color": "#1A1A1A",
                            "text": "Total",
                            "offsetY": -14,
                            "value": {
                                "color": "#1A1A1A",
                                "fontSize": 12,
                                "bold": true,
                                "prefix": "",
                                "suffix": " personas",
                                "offsetY": -9,
                                "rounding": 0
                            }
                        },
                        "average": {
                            "show": false
                        }
                    }
                },
                "donut": {
                    "strokeWidth": 64,
                    "borderWidth": 1
                }
            },
            "legend": {
                "show": true,
                "backgroundColor": "#FFFFFF",
                "color": "#1A1A1A",
                "fontSize": 12,
                "bold": false,
                "roundingValue": 0,
                "roundingPercentage": 1
            },
            "title": {
                "text": "Distribución por Ocupación",
                "color": "#1A1A1A",
                "fontSize": 20,
                "bold": true,
                "subtitle": {
                    "text": "Personas ocupadas mayores de 18 años",
                    "color": "#666666",
                    "fontSize": 16,
                    "bold": false
                }
            },
            "tooltip": {
                "show": true,
                "backgroundColor": "#1A1A1A",
                "color": "#FFFFFF",
                "fontSize": 14,
                "showValue": true,
                "roundingValue": 0,
                "showPercentage": true,
                "roundingPercentage": 1
            }
        }
    },
    "userOptions": {
        "show": true
    },
    "table": {
        "show": false,
        "responsiveBreakpoint": 400,
        "columnNames": {
            "series": "Ocupación",
            "value": "Cantidad",
            "percentage": "Porcentaje"
        },
        "th": {
            "backgroundColor": "#F3F4F6",
            "color": "#1A1A1A",
            "outline": "none"
        },
        "td": {
            "backgroundColor": "#FFFFFF",
            "color": "#1A1A1A",
            "outline": "none",
            "roundingValue": 0,
            "roundingPercentage": 1
        }
    }
});

// Dataset por defecto (fallback)
const dataset = ref([
    {
        "name": "Cargando datos...",
        "values": [1],
        "color": "#6B7280"
    }
]);

const isLoading = ref(true);
const error = ref(null);

// Función para cargar datos del backend
const loadChartData = async () => {
    try {
        const response = await fetch('/charts/getChartOcupacionesDonutData');

        if (!response.ok) {
            throw new Error(`Error: ${response.status}`);
        }

        const data = await response.json();

        // Verificar que tenemos datos válidos
        if (data && Array.isArray(data) && data.length > 0) {
            dataset.value = data;
        } else {
            // Si no hay datos, usar un mensaje informativo
            dataset.value = [
                {
                    "name": "Sin datos disponibles",
                    "values": [1],
                    "color": "#9CA3AF"
                }
            ];
        }

        isLoading.value = false;

    } catch (err) {
        console.error('Error loading chart data:', err);
        error.value = err.message;

        // Usar datos de ejemplo en caso de error
        dataset.value = [
            {
                "name": "Error al cargar datos",
                "values": [1],
                "color": "#EF4444"
            }
        ];

        isLoading.value = false;
    }
};

// Cargar datos al montar el componente
onMounted(() => {
    loadChartData();
});
</script>

<template>
    <div class="col-span-1 px-4 mt-6 sm:px-6 lg:px-8 border border-gray-200 rounded-md p-4">
        <div v-if="error" class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md">
            <p class="text-red-800">Error cargando los datos: {{ error }}</p>
            <button
                @click="loadChartData()"
                class="mt-2 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
            >
                Reintentar
            </button>
        </div>

        <div v-if="isLoading" class="flex justify-center items-center h-64">
            <div class="text-gray-500">Cargando datos del gráfico...</div>
        </div>

        <!-- Place the component inside a div with a given width -->
        <div v-if="!isLoading" style="width: 100%">
            <VueUiDonut
                :dataset="dataset"
                :config="config"
            />
        </div>
    </div>
</template>
