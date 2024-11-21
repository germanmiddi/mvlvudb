<template>
    <div class="relative w-full mx-auto">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="ageRange">
        Rango de Edad: {{ ageRange[0] }} - {{ ageRange[1] }} años
      </label>
      <div class="relative flex items-center">
        <!-- Línea de fondo del rango -->
        <div class="absolute w-full h-2 bg-gray-300 rounded"></div>
  
        <!-- Rango seleccionado -->
        <div
          class="absolute h-2 bg-gray-600 rounded"
          :style="{ left: `${((ageRange[0] - min) / (max - min)) * 100}%`, right: `${100 - ((ageRange[1] - min) / (max - min)) * 100}%` }"
        ></div>
  
        <!-- Slider izquierdo -->
        <input
          type="range"
          v-model="ageRange[0]"
          :min="min"
          :max="ageRange[1] - 1"
          class="absolute w-full appearance-none bg-transparent pointer-events-none"
          @input="updateRange(0)"
        />
        <!-- Slider derecho -->
        <input
          type="range"
          v-model="ageRange[1]"
          :min="ageRange[0] + 1"
          :max="max"
          class="absolute w-full appearance-none bg-transparent pointer-events-none"
          @input="updateRange(1)"
        />
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'RangeSlider',
    data() {
      return {
        min: 18,
        max: 100,
        ageRange: [25, 65], // Valores de inicio y fin del rango
      };
    },
    methods: {
      updateRange(index) {
        // Asegurar que los valores no se crucen
        if (index === 0 && this.ageRange[0] >= this.ageRange[1]) {
          this.ageRange[0] = this.ageRange[1] - 1;
        } else if (index === 1 && this.ageRange[1] <= this.ageRange[0]) {
          this.ageRange[1] = this.ageRange[0] + 1;
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Estilos para los thumbs de los sliders */
  input[type="range"] {
    -webkit-appearance: none;
    appearance: none;
  }
  input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 16px;
    height: 16px;
    background-color: #333;
    border-radius: 50%;
    pointer-events: auto;
  }
  input[type="range"]::-moz-range-thumb {
    width: 16px;
    height: 16px;
    background-color: #333;
    border-radius: 50%;
    pointer-events: auto;
  }
  </style>
  