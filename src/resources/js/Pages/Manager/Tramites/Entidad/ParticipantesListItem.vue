<script setup>
import { TrashIcon, PencilSquareIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';

defineProps({
    item: {
        type: Object,
        required: true
    }
})

const editMode = ref(false)
</script>

<template>
<tr class="hover:bg-gray-50">
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.role.name }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.person.name }} {{ item.person.lastname }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.person.num_documento }}</td>
    <!-- <td>{{ item.person.name }} {{ item.person.lastname }}</td>
    <td></td> -->
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
