<script setup>
import { ref, computed, toRef, watch } from 'vue'
import {
  Combobox,
  ComboboxInput,
  ComboboxButton,
  ComboboxOptions,
  ComboboxOption,
  TransitionRoot,
} from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'

const emit = defineEmits(['update'])

// Recibe el listado de escuelas como prop
const props = defineProps({
  escuelas: {
    type: Array,
    required: true,
    default: () => []
  },
  modelValue: {
    type: [Number, String, null],
    default: null
  }
})

let selected = ref(props.escuelas.find(e => e.id === props.modelValue) || null)
let query = ref('')

watch(() => props.modelValue, (newVal) => {
  selected.value = props.escuelas.find(e => e.id === newVal) || null
})

watch(selected, (newVal) => {
  emit('update', newVal ? newVal.id : null)
})

let filteredEscuelas = computed(() =>
  query.value === ''
    ? props.escuelas
    : props.escuelas.filter((escuela) =>
        escuela.description
          .toLowerCase()
          .replace(/\s+/g, '')
          .includes(query.value.toLowerCase().replace(/\s+/g, ''))
      )
)
</script>
<template>
  <div class="w-full">
    <!-- <label for="select-escuela" class="block text-sm font-medium text-gray-700 mb-1">Escuela</label> -->
    <Combobox v-model="selected">
      <div class="relative">
        <div
          class="relative w-full cursor-default overflow-hidden rounded-md bg-white text-left shadow-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        >
          <ComboboxInput
            id="select-escuela"
            class="w-full border-none py-2 pl-3 pr-10 text-sm leading-5 text-gray-900 focus:ring-0"
            :displayValue="(escuela) => escuela ? escuela.description : ''"
            @change="query = $event.target.value"
          />
          <ComboboxButton
            class="absolute inset-y-0 right-0 flex items-center pr-2"
          >
            <ChevronUpDownIcon
              class="h-5 w-5 text-gray-400"
              aria-hidden="true"
            />
          </ComboboxButton>
        </div>
        <TransitionRoot
          leave="transition ease-in duration-100"
          leaveFrom="opacity-100"
          leaveTo="opacity-0"
          @after-leave="query = ''"
        >
          <ComboboxOptions
            class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm z-10"
          >
            <div
              v-if="filteredEscuelas.length === 0 && query !== ''"
              class="relative cursor-default select-none px-4 py-2 text-gray-700"
            >
              No se encontro un resultado
            </div>

            <ComboboxOption
              v-for="escuela in filteredEscuelas"
              as="template"
              :key="escuela.id"
              :value="escuela"
              v-slot="{ selected, active }"
            >
              <li
                class="relative cursor-default select-none py-2 pl-10 pr-4"
                :class="{
                  'bg-indigo-500 text-white': active,
                  'text-gray-900': !active,
                }"
              >
                <span
                  class="block truncate"
                  :class="{ 'font-medium': selected, 'font-normal': !selected }"
                >
                  {{ escuela.description }}
                </span>
                <span
                  v-if="selected"
                  class="absolute inset-y-0 left-0 flex items-center pl-3"
                  :class="{ 'text-white': active, 'text-indigo-500': !active }"
                >
                  <CheckIcon class="h-5 w-5" aria-hidden="true" />
                </span>
              </li>
            </ComboboxOption>
          </ComboboxOptions>
        </TransitionRoot>
      </div>
    </Combobox>
  </div>
</template>


