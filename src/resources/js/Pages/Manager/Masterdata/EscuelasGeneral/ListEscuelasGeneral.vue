<template>

    <tr class="hover:bg-gray-50">
        <td>
            <div class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ item.nombre_completo }}
            </div>
        </td>
        <td>
            <div class="flex justify-between w-1/2 mx-auto">
                <div>
                    <EyeIcon v-if="item.activo == true" @click="hideItem(item.id)"
                        class="w-5 h-5 text-green-400 hover:text-green-600" />
                    <EyeSlashIcon v-else @click="hideItem(item.id)"
                        class="w-5 h-5 text-yellow-700 hover:text-yellow-900" />
                </div>
                <PencilSquareIcon @click="openModalForm('edit')" class="w-5 h-5 hover:text-blue-600  " />
                <TrashIcon @click="openModalDelete(item.id)" class="w-5 h-5 hover:text-red-500" />
            </div>
        </td>
    </tr>

    <DeleteModal v-if="showModalDelete" :id="selectedItemId" :show="showModalDelete"
        :title="'¿Estás seguro de que deseas eliminar esta escuela?'" @responseDeleted="destroyItem"
        @viewDeleted="closeModalDelete" />

    <ModalEscuelas v-if="showFormModal" :escuela="item" :type="type" :data="data" :show="showFormModal"
        @closeModal="closeModalForm" />
</template>

<script>

import {
    TrashIcon,
    PencilSquareIcon,
    EyeIcon,
    EyeSlashIcon
} from '@heroicons/vue/24/outline'
import DeleteModal from '@/Layouts/Components/DeleteModal.vue';
import ModalEscuelas from './ModalEscuelas.vue';


export default {

    props: {
        item: {
            type: Object,
            required: true
        },
        data: Object
    },
    components: {
        TrashIcon,
        PencilSquareIcon,
        EyeIcon,
        EyeSlashIcon,
        DeleteModal,
        ModalEscuelas,
    },
    data() {
        return {
            edit: "",
            showFormModal: false,
            showModalDelete: false,
            selectedItemId: null,
            type: 'edit',
        }
    },
    methods: {

        hideItem(id) {
            this.item.activo = !this.item.activo
            this.$emit('hide-item', id)
        },
        destroyItem(id) {
            this.showModal = false;
            this.$emit('destroy-item', id);
        },
        openModalDelete(id) {
            this.selectedItemId = id;
            this.showModalDelete = true;
        },
        openModalForm(type) {
            this.type = type
            this.showFormModal = true;
        },
        closeModalForm() {
            this.$emit('getUpdatedData');
            this.showFormModal = false;
        },
        closeModalDelete() {
            this.$emit('getUpdatedData');
            this.showModalDelete = false;
        },
        // viewItem() {
        //     this.edit = this.item.description
        // }

    },
    created() {
        this.edit = this.item.nombre_completo;
    }
}
</script>

<style></style>