<script setup>
import { ref, onMounted } from "vue";
import { VueUi3dBar } from "vue-data-ui";
import "vue-data-ui/style.css";

const config = ref({
    "style": {
        "fontFamily": "inherit",
        "shape": "bar",
        "chart": {
            "animation": {
                "use": true,
                "speed": 1,
                "acceleration": 1
            },
            "backgroundColor": "#FFFFFF",
            "color": "#1A1A1A",
            "bar": {
                "color": "#5f8bee",
                "stroke": "#5f8bee",
                "strokeWidth": 0.7,
                "shadeColor": "#2D353C"
            },
            "box": {
                "stroke": "#1A1A1A",
                "strokeWidth": 0.7,
                "strokeDasharray": 2,
                "dimensions": {
                    "width": 160,
                    "height": 326,
                    "top": 27,
                    "bottom": 9,
                    "left": 24,
                    "right": 24,
                    "perspective": 18
                }
            },
            "title": {
                "text": "Ocupación por Género",
                "color": "#1A1A1A",
                "fontSize": 20,
                "bold": true,
                "subtitle": {
                    "color": "#666666",
                    "text": "Mayores de 18 años y ocupados",
                    "fontSize": 16,
                    "bold": false
                }
            },
            "legend": {
                "showDefault": true,
                "fontSize": 10,
                "color": "#1A1A1A",
                "bold": false,
                "roundingValue": 0,
                "roundingPercentage": 0,
                "prefix": "",
                "suffix": " personas",
                "hideUnderPercentage": 3
            },
            "dataLabel": {
                "show": true,
                "bold": true,
                "color": "#1A1A1A",
                "fontSize": 12,
                "rounding": 0
            }
        }
    },
    "userOptions": {
        "show": true
    },
    "table": {
        "show": false,
        "responsiveBreakpoint": 300,
        "columnNames": {
            "series": "Categoría",
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
            "roundingPercentage": 0
        }
    }
});

// Dataset por defecto (fallback)
const dataset = ref({
    "series": [
        {
            "name": "Cargando datos...",
            "value": 1,
            "color": "#6B7280",
            "breakdown": [
                {
                    "name": "Procesando...",
                    "value": 1
                }
            ]
        }
    ]
});

const isLoading = ref(true);
const error = ref(null);

// Función para cargar datos del backend
const loadChartData = async () => {
    try {
        const response = await fetch('/charts/getChartAdultosOcupadosData');

        if (!response.ok) {
            throw new Error(`Error: ${response.status}`);
        }

        const data = await response.json();

        // Verificar que tenemos datos válidos
        if (data && data.series && Array.isArray(data.series) && data.series.length > 0) {
            dataset.value = data;
        } else {
            // Si no hay datos, usar un mensaje informativo
            dataset.value = {
                "series": [
                    {
                        "name": "Sin datos disponibles",
                        "value": 1,
                        "color": "#9CA3AF",
                        "breakdown": [
                            {
                                "name": "No hay información",
                                "value": 1
                            }
                        ]
                    }
                ]
            };
        }

        isLoading.value = false;

    } catch (err) {
        console.error('Error loading chart data:', err);
        error.value = err.message;

        // Usar datos de ejemplo en caso de error
        dataset.value = {
            "series": [
                {
                    "name": "Error al cargar datos",
                    "value": 1,
                    "color": "#EF4444",
                    "breakdown": [
                        {
                            "name": "Intente más tarde",
                            "value": 1
                        }
                    ]
                }
            ]
        };

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

        <VueUi3dBar
            v-if="!isLoading"
            :dataset="dataset"
            :config="config"
        />
    </div>
</template>
