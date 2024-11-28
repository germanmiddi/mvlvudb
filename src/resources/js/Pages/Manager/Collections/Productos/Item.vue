<template>
    
    <tr class="hover:bg-gray-50">
        <td>
            <div class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                {{ item.name }}
            </div>
        </td>
        <td>
            <div class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                {{ item.description }}
            </div>
        </td>
        <td>
            <div class="flex justify-between w-1/2 mx-auto" >
                <PencilSquareIcon @click="editMode = true" class="w-5 h-5 hover:text-blue-600  "/>
                <TrashIcon @click="destroyItem(item.id)" class="w-5 h-5 hover:text-red-500"/>                
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