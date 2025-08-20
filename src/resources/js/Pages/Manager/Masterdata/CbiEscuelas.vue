<template lang="">
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div>
                <div class="flex justify-between items-center">
                    <h2 id="" class="text-lg leading-6 font-medium text-gray-900">Escuelas</h2>
                    <input v-model="searchText" type="text" placeholder="Buscar escuela..." class="border rounded px-2 py-1 text-sm w-1/3 mr-4" />
                    <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-blue-200 text-blue-900 hover:bg-blue-600 hover:text-white mr-2"
                            @click="exportCSV">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        Descargar XLSX
                    </button>
                    <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-purple-200 text-purple-900 hover:bg-purple-600 hover:text-white mr-2"
                            @click="$refs.fileInput.click()">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Importar XLSX
                    </button>
                    <input ref="fileInput" type="file" accept=".xlsx,.xls" @change="handleFileUpload" class="hidden" />
                    <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                            @click="showNew = !showNew">Crear</button>
                </div>
                <div v-if="showNew" class="my-5">
                    <input v-model="newDescription" class="w-10/12 border rounded mr-2 font-base py-2 text-sm pl-2" />

                    <div class="flex mt-4">
                        <div class="flex items-center mr-4">
                            <input v-model="turnos.infante" id="turnos_infante" type="checkbox" value="1" class="w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="red-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Jardin de Infantes</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input v-model="turnos.primaria" id="turnos_primaria" type="checkbox" value="1" class="w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="red-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Primaria</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input v-model="turnos.secundaria" id="turnos_secundaria" type="checkbox" value="2" class="w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="green-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Secundaria</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input v-model="turnos.nocturna" id="turnos_nocturna" type="checkbox" value="3" class="w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="purple-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Nocturna</label>
                        </div>
                    </div>

                    <button class="mt-4 relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                            @click="newItem">Guardar</button>
                </div>
            </div>
            <div class="">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="border-b-1 border-indigo-600 ">
                        <tr>
                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-2/6  text-left">Descripción</th>
                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-2/6  text-center">Turnos (Jar-Prim-Sec-Noc)</th>
                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-2/6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                           <ListEscuela v-for="t in filteredEscuelas" :key="t.id" :item=t
                                      @edit-item="editItem"
                                      @hide-item="hideItem"
                                      />

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de resultados de importación -->
    <div v-if="showImportResults" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click="closeImportModal">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white" @click.stop>
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        Resultados de Importación
                    </h3>
                    <button @click="closeImportModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="text-center p-3 bg-blue-100 rounded">
                            <div class="text-2xl font-bold text-blue-600">{{ importStats.totalProcessed }}</div>
                            <div class="text-sm text-blue-800">Registros Procesados</div>
                        </div>
                        <div class="text-center p-3 bg-green-100 rounded">
                            <div class="text-2xl font-bold text-green-600">{{ importStats.totalSuccess }}</div>
                            <div class="text-sm text-green-800">Exitosos</div>
                        </div>
                        <div class="text-center p-3 bg-yellow-100 rounded">
                            <div class="text-2xl font-bold text-yellow-600">{{ importStats.created }}</div>
                            <div class="text-sm text-yellow-800">Creados</div>
                        </div>
                        <div class="text-center p-3 bg-purple-100 rounded">
                            <div class="text-2xl font-bold text-purple-600">{{ importStats.updated }}</div>
                            <div class="text-sm text-purple-800">Actualizados</div>
                        </div>
                    </div>

                    <div v-if="importStats.errors > 0" class="bg-red-50 border border-red-200 rounded p-3 mb-4">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium text-red-800">{{ importStats.errors }} Errores Encontrados</span>
                        </div>
                        <div v-if="importStats.errorDetails" class="text-sm text-red-700 max-h-32 overflow-y-auto">
                            <div v-html="importStats.errorDetails"></div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button @click="closeImportModal" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import ListEscuela from './ListEscuela.vue'

export default {

    props: {
        dependencia_id: {
            type: Number,
            required: true
        }
    },
    components: {
        ListEscuela
    },
    setup() {

    },

    data() {

        return {
            escuelas: "",
            showNew: false,
            newDescription: "",
            turnos: {},
            searchText: "",
            showImportResults: false,
            importStats: {
                totalProcessed: 0,
                totalSuccess: 0,
                created: 0,
                updated: 0,
                errors: 0,
                errorDetails: ''
            }
        }
    },
    created() {
        this.getData()
    },
    methods: {
        async getData() {
            let response = await fetch(route('masterdata.get_escuela', this.dependencia_id), { method: 'GET' })
            this.escuelas = await response.json()
        },

        async newItem() {
            let formData = new FormData();
            formData.append('dependencia_id', this.dependencia_id);
            formData.append('description', this.newDescription);
            formData.append('infante', this.turnos.infante ?? false);
            formData.append('primaria', this.turnos.primaria ?? false);
            formData.append('secundaria', this.turnos.secundaria ?? false);
            formData.append('nocturna', this.turnos.nocturna ?? false);

            try {
                const response = await axios.post(route('masterdata.store_escuela'), formData);

                if (response.status == 200) {
                    this.$emit('toast-message',
                        {
                            'message': response.data.message,
                            'type': 'success'
                        })

                    this.newDescription = ""
                    this.turnos = {}
                    this.showNew = false
                    this.getData()

                } else {
                    this.$emit('toast-message',
                        {
                            'message': response.data.message,
                            'type': 'danger'
                        })
                }
            } catch (error) {
                console.log(error)
            }

        },
        async editItem(item) {
            let formData = new FormData();
            formData.append('id', item.id);
            formData.append('description', item.description);
            formData.append('infante', item.infante);
            formData.append('primaria', item.primaria);
            formData.append('secundaria', item.secundaria);
            formData.append('nocturna', item.nocturna);

            formData.append('activo', item.activo);


            try {
                const response = await axios.post(route('masterdata.update_escuela'), formData);

                if (response.status == 200) {
                    this.$emit('toast-message',
                        {
                            'message': response.data.message,
                            'type': 'success'
                        })

                } else {
                    this.$emit('toast-message',
                        {
                            'message': response.data.message,
                            'type': 'danger'
                        })
                }
            } catch (error) {
                console.log(error)
            }
        },

        async hideItem(id) {

            const response = await axios.post(route('masterdata.hide_escuela'), { id: id });

            if (response.status == 200) {
                this.$emit('toast-message',
                    {
                        'message': response.data.message,
                        'type': 'success'
                    })

            } else {
                this.$emit('toast-message',
                    {
                        'message': response.data.message,
                        'type': 'danger'
                    })
            }

        },

        async exportCSV() {
            try {
                const response = await axios.post(route('masterdata.export_escuelas'), {
                    dependencia_id: this.dependencia_id
                }, {
                    responseType: 'blob'
                });

                // Crear un enlace de descarga
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'escuelas.xlsx');
                document.body.appendChild(link);
                link.click();
                link.remove();
                window.URL.revokeObjectURL(url);

                this.$emit('toast-message', {
                    'message': 'Archivo XLSX descargado exitosamente',
                    'type': 'success'
                });

            } catch (error) {
                console.error('Error al descargar XLSX:', error);
                this.$emit('toast-message', {
                    'message': 'Error al descargar el archivo XLSX',
                    'type': 'danger'
                });
            }
        },

        async handleFileUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            // Validar formato de archivo
            const allowedTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];
            if (!allowedTypes.includes(file.type)) {
                this.$emit('toast-message', {
                    'message': 'Por favor selecciona un archivo Excel válido (.xlsx o .xls)',
                    'type': 'danger'
                });
                return;
            }

            // Validar tamaño (máximo 10MB)
            if (file.size > 10 * 1024 * 1024) {
                this.$emit('toast-message', {
                    'message': 'El archivo es demasiado grande. Máximo 10MB permitido.',
                    'type': 'danger'
                });
                return;
            }

            try {
                const formData = new FormData();
                formData.append('file', file);
                formData.append('dependencia_id', this.dependencia_id);

                this.$emit('toast-message', {
                    'message': 'Procesando archivo, por favor espera...',
                    'type': 'info'
                });

                const response = await axios.post(route('masterdata.import_escuelas'), formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                                if (response.status === 200) {
                    this.$emit('toast-message', {
                        'message': response.data.message,
                        'type': 'success'
                    });

                    // Parsear los resultados del status
                    if (response.data.status) {
                        this.parseImportResults(response.data.status);
                        this.showImportResults = true;
                    }

                    // Recargar los datos
                    await this.getData();
                } else {
                    this.$emit('toast-message', {
                        'message': response.data.message || 'Error al procesar el archivo',
                        'type': 'danger'
                    });
                }

            } catch (error) {
                console.error('Error al importar archivo:', error);

                let errorMessage = 'Error al procesar el archivo';
                if (error.response && error.response.data && error.response.data.message) {
                    errorMessage = error.response.data.message;
                }

                this.$emit('toast-message', {
                    'message': errorMessage,
                    'type': 'danger'
                });
            } finally {
                // Limpiar el input file
                event.target.value = '';
            }
        },

        parseImportResults(statusHtml) {
            // Crear un div temporal para parsear el HTML
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = statusHtml;
            const textContent = tempDiv.textContent || tempDiv.innerText || '';

            // Resetear stats
            this.importStats = {
                totalProcessed: 0,
                totalSuccess: 0,
                created: 0,
                updated: 0,
                errors: 0,
                errorDetails: ''
            };

            // Extraer números usando regex
            const totalMatch = textContent.match(/Se han procesado un total de (\d+) registros/);
            const successMatch = textContent.match(/Se han procesado exitosamente (\d+) registros/);
            const createdMatch = textContent.match(/Se han creado (\d+) escuelas nuevas/);
            const updatedMatch = textContent.match(/Se han actualizado (\d+) escuelas existentes/);
            const errorsMatch = textContent.match(/Se han registrado (\d+) errores/);

            if (totalMatch) this.importStats.totalProcessed = parseInt(totalMatch[1]);
            if (successMatch) this.importStats.totalSuccess = parseInt(successMatch[1]);
            if (createdMatch) this.importStats.created = parseInt(createdMatch[1]);
            if (updatedMatch) this.importStats.updated = parseInt(updatedMatch[1]);
            if (errorsMatch) this.importStats.errors = parseInt(errorsMatch[1]);

            // Extraer detalles de errores si existen
            if (statusHtml.includes('Detalles de Errores:')) {
                const errorSplit = statusHtml.split('Detalles de Errores:<br>=====================<br>');
                if (errorSplit.length > 1) {
                    this.importStats.errorDetails = errorSplit[1];
                }
            }
        },

        closeImportModal() {
            this.showImportResults = false;
        }

    },
    computed: {
        filteredEscuelas() {
            if (!this.searchText) return this.escuelas;
            if (!this.escuelas) return [];
            return this.escuelas.filter(e =>
                e.description && e.description.toLowerCase().includes(this.searchText.toLowerCase())
            );
        }
    },
}
</script>
