<template>

    <tr class="hover:bg-gray-50">
        <td>
            <div v-if="!editMode"  class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                {{ item.name }}
            </div>
            <div v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                <input v-model="temp.name" class="border rounded py-1 pl-2" />
            </div>
        </td>
        <td>
            <div v-if="!editMode" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                {{ item.description }}
            </div>
            <div v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                <input v-model="temp.description" class="border rounded py-1 pl-2" />
            </div>
        </td>
        <!-- ACCION -->
        <td>
            <div v-if="!this.editMode" class="flex justify-between w-1/2  mx-auto">
                <PencilSquareIcon @click="editMode = true" class="w-5 h-5 hover:text-blue-600  "/>
                <TrashIcon @click="destroyItem(item.id)" class="w-5 h-5 hover:text-red-500"/>
            </div>
            <div v-else class="flex justify-start mx-auto" >
                <button @click="editItem" class="bg-blue-400 text-white px-2 py-1 rounded text-sm mr-3 hover:bg-blue-800"> Guardar</button>
                <button @click="cancelEdit" class="py-1 rounded text-sm "> <XCircleIcon class="w-5 h-5 text-red-400 hover:text-red-800"/></button>
            </div>
        </td>
    </tr>

</template>

<script>

import {
    TrashIcon,
    PencilSquareIcon,
    EyeIcon,
    EyeSlashIcon,
    XCircleIcon
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
        XCircleIcon
    },
    data() {
        return {
            edit: "",
            editMode: false,
            temp:{}
        }
    },
    methods: {

        editItem() {
            this.item.name = this.temp.name
            this.item.description = this.temp.description
            this.$emit('edit-item', this.item)
            this.editMode = false
        },
        destroyItem(id){
            this.$emit('destroy-item',id)
        },
        cancelEdit() {
            this.editMode = false
            this.temp.name = this.item.name
            this.temp.description = this.item.description
        }
    },
    created() {
        this.temp.name = this.item.name
        this.temp.description = this.item.description
    }
}
</script>
