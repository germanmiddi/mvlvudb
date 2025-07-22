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
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            <div> {{ item.num_documento }} </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            <div class="flex flex-col">
                <div> {{ item.entrevistador.name }} </div>
                <div> {{ item.puntosEntrega.description }} </div>
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
                        </div>

                        <div v-if="item.status_id == 1" class="px-1 py-1 text-left" v-show="store.userCan('PROF-CAJA', $page.props.userGroups)">
                            <MenuItem v-slot="{ active }" class="hover:bg-gray-100" @click="changeStatus(2)">
                            <a href="#" class="block px-4 py-2 text-sm">
                                Aprobar</a>
                            </MenuItem>

                            <MenuItem v-slot="{ active }" class="hover:bg-gray-100" @click="changeStatus(3)">
                            <a href="#" class="block px-4 py-2 text-sm">
                                Rechazar</a>
                            </MenuItem>
                        </div>
                        <div v-else class="px-1 py-1 text-left" v-show="store.userCan('PROF-CAJA', $page.props.userGroups)">
                            <p class="text-xs text-gray-500 ml-2">Pasar a:</p>
                            <MenuItem v-if="item.status_id == 3" v-slot="{ active }" class="hover:bg-gray-100"
                                @click="changeStatus(2)">
                            <a href="#" class="block px-4 py-2 text-sm">
                                Aprobar</a>
                            </MenuItem>

                            <MenuItem v-else-if="item.status_id == 2" v-slot="{ active }" class="hover:bg-gray-100"
                                @click="changeStatus(3)">
                            <a href="#" class="block px-4 py-2 text-sm">
                                Rechazar</a>
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

</template>

<script>

import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { EllipsisVerticalIcon } from "@heroicons/vue/24/outline";
import store from '@/store.js'


export default {

    components: {
        Menu, MenuButton, MenuItems, MenuItem,
        EllipsisVerticalIcon,
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
                'RECHAZADA': 'badgeStatus bg-red-600 text-red-100'
            }
        };
    },
    methods: {
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
                default: return '';
            }
        }
    }

}
</script>
