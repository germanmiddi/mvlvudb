<template>
  <div class="col-span-2 w-full p-6">
    <h3 class="text-lg font-semibold mb-4">Mapa de Calor - Personas Sin Ocupación</h3>

    <div v-if="isLoading" class="flex justify-center items-center h-96">
      <div class="text-lg">Cargando datos del mapa de calor...</div>
    </div>

    <!-- Contenedor para el mapa -->
    <div
      v-show="!isLoading"
      ref="mapContainer"
      id="deck-map"
      style="width: 100%; height: 500px; position: relative;"
    >
    </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import { Deck } from '@deck.gl/core'
import { HeatmapLayer } from '@deck.gl/aggregation-layers'
import { GoogleMapsOverlay } from '@deck.gl/google-maps'
import axios from 'axios'

export default defineComponent({
  name: 'ChartSinOcupacionHeatMap',
  data() {
    return {
      map: null,
      deck: null,
      center: { lat: -34.5167, lng: -58.4833 }, // Vicente López
      data: [], // Se cargará dinámicamente
      isLoading: true
    }
  },
  mounted() {
    console.log('ChartSinOcupacionHeatMap component mounted with Deck.gl');
    this.loadHeatmapData();
  },
  beforeUnmount() {
    if (this.deck) {
      this.deck.finalize();
    }
  },
  methods: {
    async loadHeatmapData() {
      try {
        console.log('Loading heatmap data from API...');

        const response = await axios.get('/charts/getHeatmapSinOcupacionData');
        const heatmapData = response.data;

        console.log('Heatmap data received:', heatmapData);

        if (heatmapData.length === 0) {
          console.log('No data available from API, using example data');
          alert('Sin datos disponibles para el mapa de calor');
        } else {
          // Convertir datos del backend al formato esperado por HeatmapLayer
          // Cada punto representa una persona individual con peso 1
          this.data = heatmapData.map(item => {
            return {
              position: [item.coordenadas.lng, item.coordenadas.lat],
              weight: 1, // Cada persona tiene peso 1
              localidad: item.localidad_nombre,
              person_name: item.person_name,
              person_id: item.person_id
            };
          });
        }

        this.isLoading = false;
        await this.$nextTick(); // Esperar a que el DOM se actualice
        this.initializeMap();

      } catch (error) {
        console.error('Error loading heatmap data:', error);
        this.isLoading = false;
        // Usar datos de ejemplo en caso de error
        // this.useExampleData();
        await this.$nextTick();
        this.initializeMap();
      }
    },

    useExampleData() {
      console.log('Using example data');
      this.data = [
        { position: [-58.4833, -34.5167], weight: 1, localidad: 'OLIVOS', person_name: 'Juan Pérez', person_id: 1 },
        { position: [-58.4850, -34.5150], weight: 1, localidad: 'OLIVOS', person_name: 'María García', person_id: 2 },
        { position: [-58.4800, -34.5180], weight: 1, localidad: 'FLORIDA', person_name: 'Carlos López', person_id: 3 },
        { position: [-58.4870, -34.5200], weight: 1, localidad: 'FLORIDA', person_name: 'Ana Martínez', person_id: 4 },
        { position: [-58.4750, -34.5140], weight: 1, localidad: 'LA LUCILA', person_name: 'Pedro Rodríguez', person_id: 5 },
        { position: [-58.4840, -34.5160], weight: 1, localidad: 'OLIVOS', person_name: 'Laura Fernández', person_id: 6 },
        { position: [-58.4820, -34.5175], weight: 1, localidad: 'FLORIDA', person_name: 'Miguel Torres', person_id: 7 },
        { position: [-58.4860, -34.5185], weight: 1, localidad: 'FLORIDA', person_name: 'Sofía Ruiz', person_id: 8 }
      ];
    },

    initializeMap() {
      if (this.data.length === 0) {
        console.log('No data available for heatmap');
        return;
      }

      if (!this.$refs.mapContainer) {
        console.error('Map container not found');
        return;
      }

      // Crear el mapa base de Google Maps
      this.map = new google.maps.Map(this.$refs.mapContainer, {
        center: this.center,
        zoom: 13,
        mapTypeId: 'roadmap',
        // Ocultar puntos de interés (places)
        styles: [
          {
            featureType: 'poi',
            stylers: [{ visibility: 'off' }]
          },
          {
            featureType: 'poi.business',
            stylers: [{ visibility: 'off' }]
          },
          {
            featureType: 'poi.park',
            stylers: [{ visibility: 'off' }]
          },
          {
            featureType: 'poi.place_of_worship',
            stylers: [{ visibility: 'off' }]
          },
          {
            featureType: 'poi.school',
            stylers: [{ visibility: 'off' }]
          },
          {
            featureType: 'poi.medical',
            stylers: [{ visibility: 'off' }]
          },
          {
            featureType: 'poi.government',
            stylers: [{ visibility: 'off' }]
          }
        ]
      });

      console.log('Google Maps created:', this.map);

      // Crear la capa de mapa de calor con Deck.gl
      const heatmapLayer = new HeatmapLayer({
        id: 'heatmap-layer',
        data: this.data,
        aggregation: 'SUM',
        getPosition: d => d.position,
        getWeight: d => d.weight,
        radiusPixels: 25,
        intensity: 1,
        threshold: 0.03,
        colorRange: [
          [255, 255, 178, 255],
          [254, 217, 118, 255],
          [254, 178, 76, 255],
          [253, 141, 60, 255],
          [252, 78, 42, 255],
          [227, 26, 28, 255],
          [189, 0, 38, 255],
          [128, 0, 38, 255]
        ]
      });

      // Crear el overlay de Deck.gl sobre Google Maps
      this.deck = new GoogleMapsOverlay({
        layers: [heatmapLayer]
      });

      // Agregar Deck.gl al mapa
      this.deck.setMap(this.map);

      console.log('Deck.gl overlay created and added to map');
      console.log(`Loaded ${this.data.length} data points`);
    }
  }
})
</script>

<style scoped>
#deck-map {
  border: 1px solid #ddd;
  border-radius: 8px;
}
</style>
