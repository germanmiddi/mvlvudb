<template>
<tr>
        <td>
            <div class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ item.person.num_documento }}
            </div>
        </td>
        <td>
            <div v-if="!editMode" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ item.person.name }}
            </div>
            <div v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <input v-model="temp.name" class="border rounded py-1 pl-2" />
            </div>
        </td>
        <td>
            <div v-if="!editMode" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ item.person.lastname }}
            </div>
            <div v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <input v-model="temp.lastname" class="border rounded py-1 pl-2" />
            </div>
        </td>
        <td>
            <div v-if="!editMode" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ item.parentesco.description }}
            </div>
            <div v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <select v-model="temp.parentesco_id" id="parentesco_id" name="parentesco_id"
                    autocomplete="parentesco_id-name"
                    class="px-6 whitespace-nowrap text-sm text-gray-500 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" disabled>
                        Seleccione un tipo de documento
                    </option>
                    <option v-for="parentesco in parentescos" :key="parentesco.id" :value="parentesco.id">
                        {{ parentesco.description }}
                    </option>
                </select>
            </div>
        </td>

        <!-- ACCION -->
        <td>
            <div v-if="!this.editMode" class="flex justify-between w-1/2  mx-auto">
                <PencilSquareIcon @click="editMode = true" class="w-5 h-5 hover:text-blue-600  "/>
                <TrashIcon @click="destroyItem(item.id)" class="w-5 h-5 hover:text-red-500"/>
            </div>
            <div v-else class="flex justify-between mx-auto" >
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
        },
        parentescos: Object
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
            editMode: false,
            temp: {}
        }
    },
    methods: {
        deleteItem() {
            this.$emit('delete-item', this.item)
        },
        editItem() {
            this.item.person.name = this.temp.name
            this.item.person.lastname = this.temp.lastname
            this.item.parentesco.id = this.temp.parentesco_id
            this.$emit('edit-item', this.item)
            this.editMode = false
        },
        destroyItem(id){
            this.$emit('destroy-item',id)
        }
    },
    created() {
        this.temp.name = this.item.person.name
        this.temp.lastname = this.item.person.lastname
        this.temp.parentesco_id = this.item.parentesco.id
    }
}
</script>

<style>

</style>