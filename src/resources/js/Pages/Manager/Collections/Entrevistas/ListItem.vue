<template>
    <tr>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ item.id }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
            {{ store.dateFormateada(item.fecha) }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            <div> {{ item.person }} </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-right">
            <div> {{ formatNumberWithDots(item.num_documento) }} </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            <div class="flex flex-col">
                <div> {{ item.entrevistador.name }} </div>
                <div> {{ item.puntosEntrega.description }} </div>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            <div v-if="item.padron" class="flex flex-col">
                <div class="font-medium text-gray-900">{{ item.padron.nombre }}</div>
                <!-- <div class="text-xs text-gray-500">{{ item.padron.descripcion }}</div> -->
            </div>
            <div v-else class="text-xs text-gray-400">
                Sin padrón
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            <span :class='estadoClass[status_name]'>{{ status_name }}</span>
        </td>
        <td class="px-6 py-4 text-center text-sm font-medium flex justify-center">
            <Menu as="div" class="inline-node">
                <div>
                    <MenuButton class="btn-blue h-7">
                        <EllipsisVerticalIcon name="options-vertical"
                            class="w-7 h-7 inline-flex items-center bg-blue-100 p-1 rounded-full shadow-sm text-gray-600  hover:bg-blue-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" />
                    </MenuButton>
                </div>
                <transition enter-active-class="transition ease-out duration-100"
                    enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                    <MenuItems
                        class="origin-top-left absolute z-50 right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
                        <div class="px-1 py-1 text-left">
                            <MenuItem v-slot="{ active }" class="hover:bg-gray-100">
                            <a :href="route('collections.entrevistas.view', item.id)" class="block px-4 py-2 text-sm">
                                Detalle</a>
                            </MenuItem>
                            <MenuItem v-slot="{ active }" class="hover:bg-gray-100" v-show="store.userCan('CAJA', $page.props.userGroups)">
                            <a :href="route('collections.entrevistas.edit', item.id)" class="block px-4 py-2 text-sm">
                                Editar</a>
                            </MenuItem>
                        </div>

                        <div class="px-1 py-1 text-left" v-show="store.userCan('PROF-CAJA', $page.props.userGroups)">
                            <p class="text-xs text-gray-500 ml-2 mb-1">Cambiar estado a:</p>

                            <!-- Opción PENDIENTE -->
                            <MenuItem v-if="item.status_id != 1" v-slot="{ active }" class="hover:bg-gray-100"
                                @click="changeStatus(1)">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700">
                                Pendiente</a>
                            </MenuItem>

                            <!-- Opción APROBADA -->
                            <MenuItem v-if="item.status_id != 2" v-slot="{ active }" class="hover:bg-gray-100"
                                @click="changeStatus(2)">
                            <a href="#" class="block px-4 py-2 text-sm text-green-700">
                                Aprobada</a>
                            </MenuItem>

                            <!-- Opción RECHAZADA -->
                            <MenuItem v-if="item.status_id != 3" v-slot="{ active }" class="hover:bg-gray-100"
                                @click="changeStatus(3)">
                            <a href="#" class="block px-4 py-2 text-sm text-red-700">
                                Rechazada</a>
                            </MenuItem>

                            <!-- Opción SUSPENDIDA -->
                            <MenuItem v-if="item.status_id != 4" v-slot="{ active }" class="hover:bg-gray-100"
                                @click="openSuspensionModal">
                            <a href="#" class="block px-4 py-2 text-sm text-orange-600">
                                Suspendida</a>
                            </MenuItem>
                        </div>
                        <div class="px-1 py-1 text-left ">
                            <MenuItem v-slot="{ active }" class="hover:bg-gray-100">
                            <a href="#" class="block px-4 py-2 text-sm">
                                Imprimir</a>
                            </MenuItem>
                        </div>
                    </MenuItems>
                </transition>
            </Menu>
        </td>
    </tr>

    <!-- Modal de Suspensión -->
    <ModalSuspension
        :show="showSuspensionModal"
        :motivos="motivosSuspension"
        @close="showSuspensionModal = false"
        @confirm="confirmSuspension"
    />

</template>

<script>

import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { EllipsisVerticalIcon } from "@heroicons/vue/24/outline";
import store from '@/store.js'
import formatNumberWithDots from "@/composables/formatter";
import ModalSuspension from './ModalSuspension.vue';


export default {

    components: {
        Menu, MenuButton, MenuItems, MenuItem,
        EllipsisVerticalIcon,
        ModalSuspension,
    },

    props: {
        item: {
            type: Object,
            required: true
        }
    },

    setup() {
        return {
            store
        }
    },
    data() {
        return {
            estadoClass: {
                'APROBADA': 'badgeStatus bg-green-600 text-green-100',
                'PENDIENTE': 'badgeStatus bg-gray-200 text-gray-800',
                'RECHAZADA': 'badgeStatus bg-red-600 text-red-100',
                'SUSPENDIDO': 'badgeStatus bg-orange-600 text-orange-100'
            },
            showSuspensionModal: false,
            motivosSuspension: []
        };
    },
    methods: {
        formatNumberWithDots,
        openSuspensionModal() {
            this.showSuspensionModal = true;
        },
        async confirmSuspension(motivoId) {
            let rt = route('collections.entrevistas.update', { id: this.item.id });

            let formData = new FormData();
            formData.append('status_id', 4); // 4 = SUSPENDIDO
            formData.append('motivo_suspension_id', motivoId);
            formData.append('id', this.item.id);

            try {
                const response = await axios.post(rt, formData);
                if (response.status == 200) {
                    this.item.status_id = 4;
                    // Recargar la página para refrescar los datos
                    window.location.reload();
                }
            } catch (error) {
                console.log(error);
            }
        },
        async changeStatus(newEstado) {
            // console.log(this.item.id)
            // return
            let rt = route('collections.entrevistas.update', { id: this.item.id });

            let formData = new FormData();
            formData.append('status_id', newEstado)
            formData.append('id', this.item.id)

            try {
                const response = await axios.post(rt, formData);
                if (response.status == 200) {
                    this.labelType = "success";
                    this.toastMessage = response.data.message;
                    this.item.status_id = newEstado

                } else {
                    this.labelType = "danger";
                    this.toastMessage = response.data.message;
                }
            } catch (error) {
                console.log(error)
            }
        }
    },
    computed: {
        status_name() {
            switch (this.item.status_id) {
                case 1: return 'PENDIENTE';
                case 2: return 'APROBADA';
                case 3: return 'RECHAZADA';
                case 4: return 'SUSPENDIDO';
                default: return '';
            }
        }
    },

    async mounted() {
        // Cargar motivos de suspensión
        try {
            const response = await fetch(route('masterdata.get_motivos_suspension'));
            const motivos = await response.json();
            this.motivosSuspension = motivos.filter(m => m.activo);
        } catch (error) {
            console.error('Error cargando motivos de suspensión:', error);
        }
    }

}
</script>
