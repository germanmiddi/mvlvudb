<template>
    <div>
        <!-- Tira de botones para scrollear -->
        <div class="flex space-x-2 mb-4">
            <button
                class="px-3 py-1 rounded bg-blue-200 hover:bg-blue-400"
                @click="scrollTo('configuracion')">
                Configuración
            </button>
            <button
                class="px-3 py-1 rounded bg-blue-200 hover:bg-blue-400"
                @click="scrollTo('padrones')">
                Padrones
            </button>
            <button
                class="px-3 py-1 rounded bg-blue-200 hover:bg-blue-400"
                @click="scrollTo('motivos-suspension')">
                Motivos de Suspensión
            </button>
        </div>

        <!-- Componentes con IDs para scroll -->
        <ConfiguracionCajas
            id="configuracion"
            @toast-message="setMessage"
            class="my-4"
        />

        <CajasPadrones
            id="padrones"
            @toast-message="setMessage"
            class="my-4"
        />

        <MotivosSuspension
            id="motivos-suspension"
            @toast-message="setMessage"
            class="my-4"
        />
    </div>
</template>

<script>
import ConfiguracionCajas from './ConfiguracionCajas.vue'
import CajasPadrones from '../CajasPadrones.vue'
import MotivosSuspension from '../MotivosSuspension.vue'

export default {
    components: {
        ConfiguracionCajas,
        CajasPadrones,
        MotivosSuspension,
    },

    methods: {
        setMessage(message) {
            this.$emit('toast-message', message)
        },
        scrollTo(id) {
            const el = document.getElementById(id);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },
    },
}
</script>

