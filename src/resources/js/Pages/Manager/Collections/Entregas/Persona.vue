<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div class="px-4 mt-6 sm:px-6 lg:px-8">

    <div class="text-sm font-medium text-gray-500 mb-4 hover:cursor-pointer hover:text-green-600 hover:underline"
      @click="clearPerson">Nueva busqueda</div>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
      <!-- <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Resultado</h3>
          </div> -->
      <div class="">
        <dl>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
            <dd class="mt-1 text-base  text-gray-900 sm:mt-0 sm:col-span-2">{{ person.name }} {{ person.lastname }}</dd>
          </div>
          <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Documento</dt>
            <dd class="mt-1 text-base text-gray-900 sm:mt-0 sm:col-span-2">{{ person.num_documento }}</dd>
          </div>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Dirección</dt>
            <dd class="mt-1 text-base text-gray-900 sm:mt-0 sm:col-span-2 capitalize">
              {{ person?.address?.[0]?.calle || '' }} {{ person?.address?.[0]?.number || '' }} - {{
                person?.address?.[0]?.localidad?.description || '' }}
            </dd>
          </div>
        </dl>
      </div>
    </div>

    <div v-if="puntosEntrega.length == 0"
      class="font-bold text-xl text-red-500/70 bg-gray-100 shadow-lg p-4 rounded-md text-center mt-10">
      No se encuentran asociados puntos de entrega con tu usuario
    </div>

    <div class="mt-5 bg-white shadow overflow-hidden sm:rounded-lg">
      <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">Realizar entrega</h3>
      </div>
      <div class="">
        <dl>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Punto de entrega</dt>
            <dd v-if="puntosEntrega.length == 0" class="mt-1 text-base  text-gray-900 sm:mt-0 sm:col-span-2">
              No hay puntos de entrega disponibles</dd>
            <dd v-else class="mt-1 text-base  text-gray-900 sm:mt-0 sm:col-span-2">
              <select v-model="form.puntoEntrega" class="w-full border-gray-300 rounded-md">
                <option v-for="punto in puntosEntrega" :key="punto.id" :value="punto.id">{{ punto.description }}
                </option>
              </select>
            </dd>
          </div>
          <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Entregado por</dt>
            <dd class="mt-1 text-base text-gray-900 sm:mt-0 sm:col-span-2">{{ user.name }}</dd>
          </div>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Producto</dt>
            <dd v-if="products.length == 0" class="mt-1 text-base  text-gray-900 sm:mt-0 sm:col-span-2">
              No hay productos disponibles</dd>
            <dd v-else class="mt-1 text-base text-gray-900 sm:mt-0 sm:col-span-2 capitalize">
              <select v-model="form.product" class="w-full border-gray-300 rounded-md">
                <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }}</option>
              </select>
            </dd>
          </div>
        </dl>
      </div>
    </div>

    <div v-if="puntosEntrega.length !== 0" class="mt-6">
      <button @click="submitCollection" :disabled="!canGetBox.status"
        class="px-6 py-3 w-full flex items-center justify-center rounded-md font-semibold transition duration-200"
        :class="canGetBox.status
          ? 'bg-green-600 hover:bg-green-700 text-white shadow-md'
          : 'bg-gray-400 text-gray-200 shadow-sm'">
        <CheckCircleIcon class="h-5 w-5 mr-3" />
        Entregar
      </button>

      <p v-if="!canGetBox.status" class="mt-3 text-sm text-red-500 text-center">
        Última entrega realizada hace {{ canGetBox.daysLeft == 0 ? 'unas horas' : canGetBox.daysLeft + ' días' }}.
        Deben pasar 30 días desde la última entrega para activar esta opción.
      </p>
    </div>
  </div>
</template>

<script>
import { CheckCircleIcon } from '@heroicons/vue/24/solid'

export default {
  props: {
    person: {
      type: Object,
      required: true
    },
    puntosEntrega: {
      type: Array,
      required: true
    },
    products: {
      type: Array,
      required: true
    },
    user: {
      type: Object,
      required: true
    },
    canGetBox: {
      type: Object,
    },
  },
  components: {
    CheckCircleIcon,
  },
  data() {
    return {
      form: {
        puntoEntrega: this.puntosEntrega.length > 0 ? this.puntosEntrega[0].id : null,
        product: this.products.length > 0 ? this.products[0].id : null
      },
    }
  },
  methods: {
    async submitCollection() {

      //format the address, if any value is null, it will not be included
      let address = this.person.address[0].calle ? `calle:${this.person.address[0].calle} ` : ''
      address += this.person.address[0].number ? `num:${this.person.address[0].number} ` : ''
      address += this.person.address[0].piso ? `piso:${this.person.address[0].piso} ` : ''
      address += this.person.address[0].dpto ? `dpto:${this.person.address[0].dpto} ` : ''
      address += this.person.address[0].localidad_id ? `localidad:${this.person.address[0].localidad_id} ` : ''
      address += this.person.address[0].barrio_id ? `barrio:${this.person.address[0].barrio_id} ` : ''

      address = address.replace(/ /g, '');

      const response = await axios.post(route('collections.storeCollection'), {
        person_id: this.person.id,
        punto_entrega_id: this.form.puntoEntrega,
        product_id: this.form.product,
        address: address
      })

      if (response.status == 200) {
        alert('Entrega realizada correctamente')
        this.$emit('clearPerson')
      }
    },
    clearPerson() {
      this.$emit('clearPerson')
    }
  },
}
</script>