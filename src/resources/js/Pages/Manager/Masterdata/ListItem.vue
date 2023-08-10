<template>
    
    <tr class="hover:bg-gray-50">
        <td>
            <div v-if="!editMode" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ item.description }}
            </div>
            <div v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <input v-model="edit" class="border rounded py-1 pl-2" />
            </div>

            
            
        </td>
        <td>
            <div v-if="!editMode" class="flex justify-between w-1/2 mx-auto">
                <div >
                    <EyeIcon v-if="item.activo == true" 
                             @click="hideItem(item.id)"
                             class="w-5 h-5 text-green-400 hover:text-green-600"/> 
                    <EyeSlashIcon v-else 
                             @click="hideItem(item.id)"
                             class="w-5 h-5 text-yellow-700 hover:text-yellow-900" />
                </div>
                <PencilSquareIcon @click="editMode = true" class="w-5 h-5 hover:text-blue-600  "/>
                <TrashIcon @click="destroyItem(item.id)" class="w-5 h-5 hover:text-red-500"/>
            </div>
            <div v-else class="flex justify-between w-1/2 mx-auto" >
                <button @click="editItem" class="bg-blue-400 text-white px-2 py-1 rounded text-sm mr-3"> Guardar</button>
                <button @click="editMode = !editMode" class="bg-red-400 text-white px-2 py-1 rounded text-sm "> Cancelar</button>
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
        deleteItem() {
            this.$emit('delete-item', this.item)
        },
        editItem() {
            this.item.description = this.edit
            this.$emit('edit-item', this.item)
            this.editMode = false
        },
        hideItem(id){
            this.item.activo = !this.item.activo
            this.$emit('hide-item',id)
        },
        destroyItem(id){
            this.$emit('destroy-item',id)
        }
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