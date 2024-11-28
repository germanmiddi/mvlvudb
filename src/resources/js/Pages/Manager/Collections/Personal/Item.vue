<template>
    
    <tr class="hover:bg-gray-50">
        <td>
            <div class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ item.name }}
            </div>
        </td>
        <td>
            <div v-for="punto in item.puntos_entrega" :key="punto.id" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ punto.description }}
            </div>
        </td>
        <td>
            <div class="flex justify-between w-1/2 mx-auto" >
                <button @click="eliminarItem" class="bg-blue-400 text-white px-2 py-1 rounded text-sm mr-3"> Eliminar</button>
            </div>
        </td> 
    </tr>

</template>

<script>

import {
    TrashIcon,
    PencilSquareIcon,
    EyeIcon,
    EyeSlashIcon
} from '@heroicons/vue/24/outline'


export default {

    props: {
        item: {
            type: Object,
            required: true
        }

    },
    components: {
        TrashIcon,
        PencilSquareIcon,
        EyeIcon,
        EyeSlashIcon,
    },
    data() {
        return {
            edit: "",
            editMode: false
        }
    },
    methods: {
        // deleteItem() {
        //     this.$emit('delete-item', this.item)
        // },
        // editItem() {
        //     this.item.description = this.edit
        //     this.$emit('edit-item', this.item)
        //     this.editMode = false
        // },
        // hideItem(id){
        //     this.item.activo = !this.item.activo
        //     this.$emit('hide-item',id)
        // },
        // destroyItem(id){
        //     this.$emit('destroy-item',id)
        // }
        // viewItem() {
        //     this.edit = this.item.description
        // }

    },
    created() {
        this.edit = this.item.description
    }
}
</script>

<style>

</style>