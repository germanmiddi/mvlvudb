<template>
    <main>
        <div class="border-b border-gray-200 px-4 py-6 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Descargas
                </h1>
            </div>
            <div class="mt-4 flex sm:mt-0 sm:ml-4"></div>
        </div>


        <div class="px-4 mt-6 sm:px-6 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
                        <div class="flex">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Crea tu template para exportar</h3>
                        </div>
                        <div class="ml-auto">
                            <a @click="generateReport()" v-if="!processReport"
                                class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Exportar</a>

                            <a v-else
                                class="border-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">
                                <ArrowPathIcon class="h-5 w-5 text-red-500 animate-spin mr-2" /> Procesando...
                            </a> 
                        </div>
                        <!-- <div class="col-span-12 sm:col-span-3">
                            <label for="dependencia_id"
                                class="block text-sm font-medium text-gray-700">Dependencia</label>
                            <select id="dependencia_id" name="dependencia_id" autocomplete="off" @change="getFields" v-model="selectedDependencyId"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled>
                                    Seleccione una dependencia
                                </option>
                                <option v-for="dependencia in dependencias" :key="dependencia.id"
                                    :value="dependencia.id">
                                    {{ dependencia.description }}
                                </option>
                            </select>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>


        <!-- OPCION DE PONER LOS INACTIVOS EN UNA COLUMNA CON EL SWICH -->
        <div class="px-4 mt-6 sm:px-6 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 sm:p-6 grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div class="col-span-2">
                        <draggable v-model="activeItems" :options="dragOptions" @end="updateOrder" :item-key="'id'"
                            class="grid grid-cols-3 gap-4">
                            <template #item="{ element, index }">
                                <div :key="element.id"
                                    :class="{ 'bg-gray-200': !element.is_active, 'bg-white': element.is_active }"
                                    class="shadow rounded-md p-4 mb-4 flex items-center justify-between w-full">
                                    <span class="mr-4 text-gray-500">{{ index + 1 }}.</span>
                                    <div class="flex-1">
                                        <Bars3Icon class="w-6 h-6 text-gray-500 mr-3 cursor-move inline-block" />
                                        <span class="block text-sm font-medium text-gray-700 inline-block">
                                            {{ element.label }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <Switch v-model="element.is_active" @click="toggleActive(element)"
                                            :class="element.is_active ? 'bg-green-600' : 'bg-gray-400'"
                                            class="relative inline-flex h-6 w-11 items-center rounded-full">
                                            <span :class="element.is_active ? 'translate-x-6' : 'translate-x-1'"
                                                class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                                        </Switch>
                                    </div>
                                </div>
                            </template>
                        </draggable>
                    </div>

                    <div class="bg-gray-100 py-6 sm:p-6 w-full">
                        <div class="flex">
                            <div class="w-1/2 py-3 px-4" v-if="inactiveItems.length > 0">
                                <h4 class="text-lg font-medium leading-6 text-gray-900 mb-4">Campos Inactivos</h4>
                                <draggable v-model="inactiveItems" :options="{ disabled: true }" @end="updateOrder"
                                    :item-key="'id'" class="flex flex-col">
                                    <template #item="{ element, index }">
                                        <div :key="element.id"
                                            :class="{ 'bg-gray-200': !element.is_active, 'bg-white': element.is_active }"
                                            class="shadow rounded-md p-4 mb-4 flex items-center justify-between w-full">
                                            <div class="flex-1">
                                                <span class="block text-sm font-medium text-gray-700 inline-block">
                                                    {{ element.label }}
                                                </span>
                                            </div>
                                            <div class="ml-4">
                                                <Switch v-model="element.is_active" @click="toggleActive(element)"
                                                    :class="element.is_active ? 'bg-green-600' : 'bg-gray-400'"
                                                    class="relative inline-flex h-6 w-11 items-center rounded-full">
                                                    <span :class="element.is_active ? 'translate-x-6' : 'translate-x-1'"
                                                        class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                                                </Switch>
                                            </div>
                                        </div>
                                    </template>
                                </draggable>
                            </div>

                            <ul class="space-y-2 py-3 px-4 w-1/2">
                                <h4 class="text-lg font-medium leading-6 text-gray-900">Campos a Exportar</h4>
                                <li v-for="(element, index) in localColumnsExport.filter(item => item.is_active)"
                                    :key="element.id" class="flex items-center">
                                    <span class="mr-4 text-gray-500">{{ index + 1 }}.</span>
                                    <span class="text-sm font-medium text-gray-700">{{ element.label }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- OPCION DE LISTA DE CAMPOS EXPORTADOS A LA DERECHA -->
        <!-- <div class="px-4 mt-6 sm:px-6 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 sm:p-6 grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div class="col-span-2">
                        <draggable v-model="localColumnsExport" :options="dragOptions" @end="updateOrder"
                            class="grid grid-cols-3 gap-4">
                            <template #item="{ element, index }">
                                <div :key="element.id"
                                    :class="{ 'bg-gray-200': !element.is_active, 'bg-white': element.is_active }"
                                    class="shadow rounded-md p-4 mb-4 flex items-center justify-between w-full">
                                    <span class="mr-4 text-gray-500">{{ index + 1 }}.</span>
                                    <div class="flex-1">
                                        <Bars3Icon class="w-6 h-6 text-gray-500 mr-3 cursor-move inline-block" />
                                        <span class="block text-sm font-medium text-gray-700 inline-block">
                                            {{ element.label }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <Switch v-model="element.is_active" @click="toggleActive(element)"
                                            :class="element.is_active ? 'bg-green-600' : 'bg-gray-400'"
                                            class="relative inline-flex h-6 w-11 items-center rounded-full">
                                            <span :class="element.is_active ? 'translate-x-6' : 'translate-x-1'"
                                                class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                                        </Switch>
                                    </div>
                                </div>
                            </template>
                        </draggable>
                    </div>


                    <div class="bg-gray-100 py-6 px-4 sm:p-6 w-full rounded-lg">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-medium leading-6 text-gray-900">Campos Exportados</h4>
                            <div class="mt-4 flex sm:mt-0 sm:ml-4">

                                <a @click="generateReport()" v-if="!processReport"
                                    class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">Exportar</a>

                                <a v-else
                                    class="border-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md bg-yellow-200 text-yellow-900 hover:bg-yellow-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:order-1 sm:ml-3">
                                    <ArrowPathIcon class="h-5 w-5 text-red-500 animate-spin mr-2" /> Procesando...
                                </a>
                            </div>
                        </div>
                        <ul class="space-y-2 py-3 px-4">

                            <li v-for="(element, index) in localColumnsExport.filter(item => item.is_active)"
                                :key="element.id" class="flex items-center">
                                <span class="mr-4 text-gray-500">{{ index + 1 }}.</span>
                                <span class="text-sm font-medium text-gray-700">{{ element.label }}</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div> -->
    </main>
</template>

<script>
import draggable from "vuedraggable";
import { Switch } from '@headlessui/vue'
import { Bars3Icon, ArrowPathIcon } from '@heroicons/vue/24/outline'


export default {
    components: {
        draggable,
        Bars3Icon,
        ArrowPathIcon,
        Switch,
    },

    props: {
        dependencias: Object,
        columnsExport: Object,
    },

    data() {
        return {
            localColumnsExport: [],
            activeItems: [],
            inactiveItems: [],
            orderedItems: [],
            dragOptions: {
                handle: ".drag-handle",
                filter: ".drag-handle",
            },
            processReport: false
        };
    },

    created() {
        this.localColumnsExport = this.columnsExport.map(column => ({
            ...column,
            is_active: true
        }));

        setTimeout(() => {
            this.activeItems = this.localColumnsExport.filter(item => item.is_active);
            // this.inactiveItems = this.localColumnsExport.filter(item => !item.is_active);
        }, 300);
    },

    // watch: {
    //     localColumnsExport: {
    //         immediate: true,
    //         handler() {
    //             this.activeItems = this.activeColumnsExport;
    //             this.inactiveItems = this.inactiveColumnsExport;
    //         }
    //     }
    // },
    computed: {
        // activeColumnsExport() {
        //     return this.localColumnsExport.filter(item => item.is_active);
        // },
        // inactiveColumnsExport() {
        //     return this.localColumnsExport.filter(item => !item.is_active);
        // }
    },
    methods: {
        updateOrder() {
            this.localColumnsExport.forEach((item, index) => {
                item.order = index;
            });
            this.orderedItems = [...this.localColumnsExport];
            setTimeout(() => {
                this.inactiveItems = this.localColumnsExport.filter(item => !item.is_active);
                this.activeItems = this.localColumnsExport.filter(item => item.is_active);
            }, 150);
            // this.activeItems = this.activeColumnsExport; // Actualiza activeItems
            // this.inactiveItems = this.inactiveColumnsExport; // Actualiza inactiveItems
            console.log("Nuevo orden almacenado en orderedItems:", this.orderedItems);
        },
        toggleActive(element) {
            element.is_active = !element.is_active;
            this.updateOrder();
        },
        async generateReport() {
            this.processReport = true;

            const updateOrder = this.localColumnsExport
                .filter(item => item.is_active)
                .map((item, index) => {
                    return {
                        id: item.id,
                        table: item.table,
                        column: item.column,
                        label: item.label,
                        order: index,
                        is_active: item.is_active
                    };
                });
            let rt = route("report.exportTest");
            try {
                const response = await axios.post(rt, { updateOrder: updateOrder }, {
                    responseType: 'blob',
                });

                const blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'Resumen de Tramites.xlsx';
                a.style.display = 'none';

                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            } catch (error) {
                console.log(error);
            }
            this.processReport = false;
        },
        // async getFields(){
        //     console.log("Accediendo a getFields");
        //     const response = await axios.get(route('downloads.fieldsItems', this.selectedDependencyId))
        //     this.fieldsItems = response.data
        //     console.log(this.fieldsItems);
        // },
    },

};

</script>