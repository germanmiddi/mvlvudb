<template>
    <Toast class="fixed top-5 right-5 z-[9999]" :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage">
    </Toast>

    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Cargar Escuela</h3>
                <button @click="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <svg width="20px" height="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>window-close</title>
                        <path fill="currentColor"
                            d="M13.46,12L19,17.54V19H17.54L12,13.46L6.46,19H5V17.54L10.54,12L5,6.46V5H6.46L12,10.54L17.54,5H19V6.46L13.46,12Z" />
                    </svg>
                </button>
            </div>

            <div class="p-4">
                <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Numero/Sigñla -->
                    <div class="col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Número o Sigla</dt>
                        <dd class="mt-1">
                            <input type="text" v-model="form.numero_sigla"
                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
                            <!-- <p v-if="errors.address" class="text-red-500 text-sm mt-1">{{ errors.address }}</p> -->
                        </dd>
                    </div>

                    <!-- Nombre Completo -->
                    <div class="col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
                        <dd class="mt-1">
                            <input type="text" v-model="form.nombre_completo"
                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
                            <!-- <p v-if="errors.address" class="text-red-500 text-sm mt-1">{{ errors.address }}</p> -->
                        </dd>
                    </div>

                    <!-- Dirección -->
                    <div class="col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                        <dd class="mt-1">
                            <input type="text" v-model="form.direccion"
                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
                            <!-- <p v-if="errors.address" class="text-red-500 text-sm mt-1">{{ errors.address }}</p> -->
                        </dd>
                    </div>

                    <!-- Localidad -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Localidad</dt>
                        <dd class="mt-1">
                            <select v-model="form.localidad_id"
                                class="w-full border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Selecciona una Localidad</option>
                                <option v-for="localidad in this.data.localidades" :key="localidad.id"
                                    :value="localidad.id">
                                    {{ localidad.description }}
                                </option>
                            </select>
                            <!-- <p v-if="errors.user" class="text-red-500 text-sm mt-1">{{ errors.user }}</p> -->
                        </dd>
                    </div>

                    <!-- Telefono -->
                    <div class="col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Telefono:</dt>
                        <dd class="mt-1">
                            <input type="text" v-model="form.telefono"
                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
                            <!-- <p v-if="errors.address" class="text-red-500 text-sm mt-1">{{ errors.address }}</p> -->
                        </dd>
                    </div>


                    <!-- Mail -->
                    <div class="col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Mail:</dt>
                        <dd class="mt-1">
                            <input type="text" v-model="form.mail"
                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
                            <!-- <p v-if="errors.mail" class="text-red-500 text-sm mt-1">{{ errors.mail }}</p> -->
                        </dd>
                    </div>

                    <!-- Dependencia -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Dependencia</dt>
                        <dd class="mt-1">
                            <select v-model="form.dependencia_id"
                                class="w-full border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="" disabled>Selecciona una Dependencia</option>
                                <option v-for="dependencia in this.data.dependencias" :key="dependencia.id"
                                    :value="dependencia.id">
                                    {{ dependencia.description }}
                                </option>
                            </select>
                            <!-- <p v-if="errors.user" class="text-red-500 text-sm mt-1">{{ errors.user }}</p> -->
                        </dd>
                    </div>

                    <!-- Activo -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Activo:</dt>
                        <dd class="mt-1">
                            <select v-model="form.activo"
                                class="w-full border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="1">Activo</option>
                                <option value="0">Desactivado</option>
                            </select>
                            <!-- <p v-if="errors.product" class="text-red-500 text-sm mt-1">{{ errors.product }}</p> -->
                        </dd>
                    </div>

                    <!-- Niveles Educativos -->
                    <div>
                        <div class="col-span-12 sm:col-span-3">
                            <div class="flex items-center">
                                <label for="name" class="block text-sm font-medium text-gray-700">Recibe
                                    Niveles Educativos</label>
                                <a class="ml-2 flex items-center space-x-2 bg-blue-500 rounded-md py-1 px-2 hover:bg-blue-800 hover:cursor-pointer"
                                    @click="addNivel">
                                    <PlusIcon class="h-5 w-5 text-white" />
                                    <span class="text-xs text-white text-bold">Agregar</span>
                                </a>
                            </div>
                            <div>
                                <select v-model="nivelSelect" id="label_id" name="label_id" autocomplete="off"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="" disabled>
                                        Seleccione un nivel
                                    </option>
                                    <option v-for="nivel in this.data.nivelesEducativos" :key="nivel.id" :value="nivel">
                                        {{ nivel.description }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 mt-2">
                            <label for="message"
                                class="block text-sm font-semibold leading-6 text-gray-900 mb-2">Niveles
                                seleccionados</label>
                            <span v-for="(nivel, index) in this.form.nivelesSelected" :key="index"
                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-700/10 mr-2 mb-2">
                                {{ nivel.description }} <Icons name="trash" @click="removeNivel(nivel.id)"
                                    class="h-5 w-5 text-red-700 ml-2"></Icons>
                            </span>
                        </div>
                    </div>
                </dl>

                <!-- Botón deGuardado -->
                <div class="mt-6 flex justify-end">
                    <button @click="handleSubmit" :disabled="loadingSubmit" class="px-6 py-2 rounded-md shadow-sm flex items-center transition 
            text-white bg-green-600 hover:bg-green-700 
            focus:ring-2 focus:ring-green-500 focus:outline-none
            disabled:bg-gray-400 disabled:cursor-not-allowed">
                        <span v-if="loadingSubmit">Guardando...</span>
                        <span v-else>Guardar</span>
                        <svg v-if="loadingSubmit" xmlns="http://www.w3.org/2000/svg"
                            class="text-gray-300 animate-spin ml-1" viewBox="0 0 24 24" width="15" height="15">
                            <path fill="currentColor" d="M12,4V2A10,10 0 0,0 2,12H4A8,8 0 0,1 12,4Z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Icons from '@/Layouts/Components/Icons.vue'
import { PlusIcon, CheckCircleIcon } from '@heroicons/vue/24/outline'
import Toast from "@/Layouts/Components/Toast.vue"


export default {
    props: {
        escuela: Object,
        type: String,
        data: Object,
    },
    components: {
        Icons,
        PlusIcon,
        CheckCircleIcon,
        Toast,
    },
    data() {
        return {
            form: {
                id: this.escuela?.id ?? '',
                numero_sigla: this.escuela?.numero_sigla ?? '',
                nombre_completo: this.escuela?.nombre_completo ?? '',
                direccion: this.escuela?.direccion ?? '',
                localidad_id: this.escuela?.localidad_id ?? '',
                telefono: this.escuela?.telefono ?? '',
                mail: this.escuela?.mail ?? '',
                dependencia_id: this.escuela?.dependencia_id ?? '',
                activo: this.escuela?.activo ?? 1,
                nivelesSelected: this.escuela?.niveles?.map(({ pivot, ...rest }) => rest) ?? [],
            },
            nivelSelect: '',
            loadingSubmit: false,
            showToast: false,
            toastMessage: "",
        };
    },
    watch: {
    },
    methods: {
        handleSubmit() {
            this.type == 'edit' ? this.editItem() : this.newItem(this.escuela);
        },
        closeModal() {
            this.$emit("closeModal");
        },

        addNivel() {
            let existe_nivel = this.form.nivelesSelected.find(nivel => nivel.id === this.nivelSelect.id);
            if (this.nivelSelect === '') {
                this.nivelType = "info";
                this.toastMessage = "Debe ingresar un Nivel";
            } else {
                if (!existe_nivel) {
                    this.form.nivelesSelected.push(this.nivelSelect);
                } else {
                    this.labelType = "info";
                    this.toastMessage = "El Nivel ya se encuentra asignado";
                }
            }
            this.nivelSelect = '';
        },
        removeNivel(id) {
            const index = this.form.nivelesSelected.findIndex(item => item.id === id);
            this.form.nivelesSelected.splice(index, 1);
            this.labelType = "success";
            this.toastMessage = "Se ha eliminado correctamente el Nivel";
        },

        async newItem() {
            this.loadingSubmit = true;
            const nivelesIds = this.form.nivelesSelected.map(nivel => nivel.id);
            const formData = { ...this.form, nivelesSelected: nivelesIds };

            try {
                const response = await axios.post(route('masterdata.escuelas.store_escuela'), formData);

                if (response.status == 200) {
                    this.labelType = "success";
                    this.toastMessage = response.data.message;

                    this.$emit('getUpdatedData');

                } else {
                    this.labelType = "danger";
                    this.toastMessage = response.data.message;
                }
            } catch (error) {
                console.log(error)
            }
            finally {
                this.loadingSubmit = false;
                this.closeModal();
            }

        },

        async editItem() {
            this.loadingSubmit = true;
            const nivelesIds = this.form.nivelesSelected.map(nivel => nivel.id);
            const formData = { ...this.form, nivelesSelected: nivelesIds };
            try {
                const response = await axios.post(route('masterdata.escuelas.update_escuela'), formData);

                if (response.status == 200) {
                    this.labelType = "success";
                    this.toastMessage = response.data.message;

                } else {
                    this.labelType = "danger";
                    this.toastMessage = response.data.message;
                }
            } catch (error) {
                console.log(error)
            }
            finally {
                //settimeout
                this.loadingSubmit = false;
                this.closeModal();
            }
        },

        handleKeydown(event) {
            if (event.key === 'Escape') {
                this.closeModal();
            }
        },

        clearMessage() {
            this.toastMessage = "";
        },

    },
    mounted() {
        document.addEventListener('keydown', this.handleKeydown);
    },
    unmounted() {
        document.removeEventListener('keydown', this.handleKeydown);
    },
};
</script>