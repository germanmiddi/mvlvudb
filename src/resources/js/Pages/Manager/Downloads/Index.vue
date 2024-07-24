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
                        <div class="">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Elige la Dependencia y los campos a
                                Exportar</h3>
                        </div>
                        <div class="mt-4 flex sm:mt-0 sm:ml-4">

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
                        <div class="flex-shrink-0">
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="px-4 mt-6 sm:px-6 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
                        <draggable v-model="myArray" :options="dragOptions" @end="updateOrder">
                            <template #item="{ element }">
                                <div :key="element.id"
                                    :class="{ 'bg-gray-200': !element.is_active, 'bg-white': element.is_active }"
                                    class="shadow rounded-md p-4 mb-4 flex items-center">
                                    <Bars3Icon class="w-6 h-6 text-gray-500 mr-3 cursor-move" />

                                    <div class="block text-sm font-medium text-gray-700 flex-grow">
                                        {{ element.name }}
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
                        <div class="flex-shrink-0"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import { ref } from "vue";
import draggable from "vuedraggable";
import { Switch } from '@headlessui/vue'
import { Bars3Icon, ArrowPathIcon } from '@heroicons/vue/24/outline'


export default {
    props: {
        dependencias: Object,
    },
    components: {
        draggable,
        Bars3Icon,
        ArrowPathIcon,
        Switch,
    },

    data() {
        const myArray = ref([
            { name: "Numero de Documento", index: 0, is_active: true },
            { name: "Canal de Atencion", index: 1, is_active: true },
            { name: "Tipo Tramite", index: 2, is_active: true },
            { name: "Observaciones", index: 3, is_active: true },
            { name: "Nombre", index: 4, is_active: true },
            { name: "Apellido", index: 5, is_active: true },
            { name: "Mail", index: 6, is_active: true },
            { name: "Teléfono", index: 7, is_active: true },
            { name: "Celular", index: 8, is_active: true },
            { name: "Localidad", index: 9, is_active: true },
            { name: "Barrio", index: 10, is_active: true },
            { name: "Calle", index: 11, is_active: true },
            { name: "Número", index: 12, is_active: true },
            { name: "Piso", index: 13, is_active: true },
            { name: "Departamento", index: 14, is_active: true },
            { name: "País de origen", index: 15, is_active: true },
            { name: "Situación Conyugal", index: 16, is_active: true },
            { name: "Cant. Hijos", index: 17, is_active: true },
            { name: "Niv. Ed. en curso", index: 18, is_active: true },
            { name: "Niv. Ed. Alcanzado", index: 19, is_active: true },
            { name: "Ocupación", index: 20, is_active: true },
            { name: "Jubilación/Pensión", index: 21, is_active: true },
            { name: "Cobertura de Salud", index: 22, is_active: true },
            { name: "Recibe Programa Social", index: 23, is_active: true }
        ]);

        const orderedItems = ref([]);

        const dragOptions = {
            handle: ".drag-handle",
            filter: ".drag-handle",
        };

        const updateOrder = () => {
            myArray.value.forEach((item, index) => {
                item.index = index;
            });
            orderedItems.value = [...myArray.value];
            console.log("Nuevo orden almacenado en orderedItems:", orderedItems.value);
        };

        const toggleActive = (element) => {
            element.is_active = !element.is_active;
            updateOrder();
        };

        return {
            dragOptions,
            myArray,
            orderedItems,
            updateOrder,
            toggleActive,
            filter: {},
            processReport: false
            // fieldsItems: [],
            // selectedDependencyId: null,
        };
    },

    methods: {
        // async getFields(){
        //     console.log("Accediendo a getFields");
        //     const response = await axios.get(route('downloads.fieldsItems', this.selectedDependencyId))
        //     this.fieldsItems = response.data
        //     console.log(this.fieldsItems);
        // },

        async generateReport() {
            this.processReport = true
            const updateOrder = this.myArray.map((item, index) => {
                return {
                    name: item.name,
                    index: index,
                    is_active: item.is_active
                };
            });
            let rt = route("report.exportTest");
            try {
                const response = await axios.post(rt, { updateOrder: updateOrder }, {
                    responseType: 'blob', // Especifica que esperamos un archivo binario (Blob)
                });
                // Crear un objeto Blob con la respuesta
                const blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

                // Crear una URL de objeto para el Blob
                const url = window.URL.createObjectURL(blob);

                // Crear un enlace <a> para iniciar la descarga
                const a = document.createElement('a');
                a.href = url;
                a.download = 'Resumen de Tramites.xlsx'; // Nombre del archivo
                a.style.display = 'none';

                // Agregar el enlace al cuerpo del documento y hacer clic en él
                document.body.appendChild(a);
                a.click();

                // Liberar la URL del objeto después de la descarga
                window.URL.revokeObjectURL(url);
            } catch (error) {
                console.log(error);
            }
            this.processReport = false
        }


        // async generateReport() {

        //     this.filter.dependencia_id = 5
        //     this.processReport = true

        //     // this.$http
        //     //     .get('report.exportTest', this.updateOrder)
        //     //     .catch((error) => {
        //     //         console.log(error);
        //     //     })
        //     const activeFields = this.myArray.filter(item => item.is_active).map(item => item.name);
        //     let rt = route("report.exportTest");

        //     try {
        //         const response = await axios.post(rt, this.filter, {
        //             responseType: 'blob', // Especifica que esperamos un archivo binario (Blob)
        //         });

        //         // Crear un objeto Blob con la respuesta
        //         const blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

        //         // Crear una URL de objeto para el Blob
        //         const url = window.URL.createObjectURL(blob);

        //         // Crear un enlace <a> para iniciar la descarga
        //         const a = document.createElement('a');
        //         a.href = url;
        //         a.download = 'Resumen de Tramites.xlsx'; // Nombre del archivo
        //         a.style.display = 'none';

        //         // Agregar el enlace al cuerpo del documento y hacer clic en él
        //         document.body.appendChild(a);
        //         a.click();

        //         // Liberar la URL del objeto después de la descarga
        //         window.URL.revokeObjectURL(url);
        //     } catch (error) {
        //         console.error(error);
        //     }
        //     this.processReport = false
        // }

    },

};
</script>
