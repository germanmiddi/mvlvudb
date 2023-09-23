<template>
    
    <tr class="hover:bg-gray-50">
        <td>
            <div v-if="!editMode" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ item.description }}
            </div>
            <div v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <input v-model="edit.description" class="border rounded py-1 pl-2" />
            </div>
        </td>
        <td>
            <div v-if="!editMode" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                <div v-if="!editMode" class="flex justify-between w-1/2 mx-auto">
                    <LightBulbIcon :class="item.infante ? 'text-green-400 hover:text-green-600' : ' text-red-400 hover:text-red-600' " class="w-5 h-5"/>
                    <LightBulbIcon :class="item.primaria ? 'text-green-400 hover:text-green-600' : ' text-red-400 hover:text-red-600' " class="w-5 h-5"/>
                    <LightBulbIcon :class="item.secundaria ? 'text-green-400 hover:text-green-600' : ' text-red-400 hover:text-red-600' " class="w-5 h-5"/>
                    <LightBulbIcon :class="item.nocturna ? 'text-green-400 hover:text-green-600' : ' text-red-400 hover:text-red-600' " class="w-5 h-5"/>
                </div>
            </div>
            <div v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                <input v-model="edit.infante" id="turnos_infante" type="checkbox" value="2" class="m-3 w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <input v-model="edit.primaria" id="turnos_primaria" type="checkbox" value="2" class="m-3 w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <input v-model="edit.secundaria" id="turnos_secundaria" type="checkbox" value="2" class="m-3 w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <input v-model="edit.nocturna" id="turnos_nocturna" type="checkbox" value="2" class="m-3 w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            </div>
        </td>
        <!-- <td>
            <div v-if="!editMode" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ item.nocturna }}
            </div>
            <div v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <input v-model="edit.nocturna" id="turnos_primaria" type="checkbox" value="2" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            </div>
        </td>
        <td>
            <div v-if="!editMode" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ item.secundaria }}
            </div>
            <div v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <input v-model="edit.secudnaria" id="turnos_secundaria" type="checkbox" value="2" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            </div>
        </td> -->
        <td>
            <div v-if="!editMode" class="flex justify-between w-1/5 mx-auto">
                <div >
                    <EyeIcon v-if="item.activo == true" 
                             @click="hideItem(item.id)"
                             class="w-5 h-5 text-green-400 hover:text-green-600"/> 
                    <EyeSlashIcon v-else 
                             @click="hideItem(item.id)"
                             class="w-5 h-5 text-yellow-700 hover:text-yellow-900" />
                </div>
                <PencilSquareIcon @click="editMode = true" class="w-5 h-5 hover:text-blue-600  "/>
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
    EyeSlashIcon,
    LightBulbIcon
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
        LightBulbIcon
    },
    data() {
        return {
            edit: {},
            editMode: false
        }
    },
    methods: {
        deleteItem() {
            this.$emit('delete-item', this.item)
        },
        editItem() {
            this.item.description = this.edit.description
            this.item.infante = this.edit.infante
            this.item.primaria = this.edit.primaria
            this.item.secundaria = this.edit.secundaria
            this.item.nocturna = this.edit.nocturna
            this.$emit('edit-item', this.item)
            this.editMode = false
        },
        hideItem(id){
            this.item.activo = !this.item.activo
            this.$emit('hide-item',id)
        }

    },
    created() {
        this.edit.description = this.item.description
        this.edit.infante = this.item.infante === 1 ? true : false
        this.edit.primaria = this.item.primaria === 1 ? true : false
        this.edit.secundaria = this.item.secundaria === 1 ? true : false
        this.edit.nocturna = this.item.nocturna === 1 ? true : false
    }
}
</script>

<style>

</style>