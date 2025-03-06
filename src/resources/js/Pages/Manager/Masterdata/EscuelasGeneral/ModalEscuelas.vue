<template>
    <Toast class="fixed top-5 right-5 z-[9999]" :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage">
    </Toast>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div
            class="bg-white rounded-lg shadow-xl sm:max-w-4xl max-w-full w-full sm:mx-8 sm:mt-6 sm:mb-6 max-h-[90vh] overflow-y-auto p-8">
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">Cargar Escuela</h3>
                    <button @click="closeModal" class="text-gray-500 hover:text-gray-700">
                        <svg width="20px" height="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <title>window-close</title>
                            <path fill="currentColor"
                                d="M13.46,12L19,17.54V19H17.54L12,13.46L6.46,19H5V17.54L10.54,12L5,6.46V5H6.46L12,10.54L17.54,5H19V6.46L13.46,12Z" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Numero/Sigla -->
                        <div class="col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Numero o Sigla</dt>
                            <dd class="mt-1">
                                <input type="text" v-model="form.numero_sigla"
                                    class="w-full shadow-sm p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
                            </dd>
                        </div>

                        <!-- Nombre Completo -->
                        <div class="col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
                            <dd class="mt-1">
                                <input type="text" v-model="form.nombre_completo"
                                    :class="{ 'border-red-500': errors.nombre_completo }"
                                    class="w-full shadow-sm p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
                            </dd>
                            <span v-if="errors.nombre_completo" class="text-red-500 text-xs"> {{
                                errors.nombre_completo
                            }}
                            </span>
                        </div>

                        <!-- Dirección -->
                        <div class="col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                            <dd class="mt-1">
                                <input type="text" v-model="form.direccion"
                                    class="w-full shadow-sm p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
                            </dd>
                        </div>

                        <!-- Localidad -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Localidad</dt>
                            <dd class="mt-1">
                                <select v-model="form.localidad_id"
                                    class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Selecciona una Localidad</option>
                                    <option v-for="localidad in this.data.localidades" :key="localidad.id"
                                        :value="localidad.id">
                                        {{ localidad.description }}
                                    </option>
                                </select>
                            </dd>
                        </div>

                        <!-- Jornada -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jornada</dt>
                            <dd class="mt-1">
                                <select v-model="form.jornada_id"
                                    class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Selecciona una Jornada</option>
                                    <option v-for="jornada in this.data.jornadas" :key="jornada.id" :value="jornada.id">
                                        {{ jornada.description }}
                                    </option>
                                </select>
                            </dd>
                        </div>

                        <!-- Telefono -->
                        <div class="col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Telefono:</dt>
                            <dd class="mt-1">
                                <input type="text" v-model="form.telefono"
                                    class="w-full shadow-sm p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
                            </dd>
                        </div>

                        <!-- Mail -->
                        <div class="col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Mail:</dt>
                            <dd class="mt-1">
                                <input type="text" v-model="form.mail"
                                    class="w-full shadow-sm p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
                            </dd>
                        </div>

                        <!-- Dependencia -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Dependencia</dt>
                            <dd class="mt-1">
                                <select v-model="form.dependencia_id"
                                    class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="" disabled>Selecciona una Dependencia</option>
                                    <option v-for="dependencia in this.data.dependencias" :key="dependencia.id"
                                        :value="dependencia.id">
                                        {{ dependencia.description }}
                                    </option>
                                </select>
                            </dd>
                        </div>

                        <!-- Activo -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Activo:</dt>
                            <dd class="mt-1">
                                <select v-model="form.activo" :class="{ 'border-red-500': errors.activo }"
                                    class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="1">Activo</option>
                                    <option value="0">Desactivado</option>
                                </select>
                            </dd>
                            <span v-if="errors.activo" class="text-red-500 text-xs"> {{ errors.activo }}
                            </span>
                        </div>

                        <!-- Niveles Educativos -->
                        <div class="col-span-2">
                            <div class="flex items-center justify-between">
                                <label for="nivel" class="text-sm font-medium text-gray-700">Recibe
                                    Niveles
                                    Educativos</label>
                                <a @click="addNivel"
                                    class="flex items-center space-x-2 shadow-sm bg-blue-500 rounded-md py-1 px-2 hover:bg-blue-800 cursor-pointer">
                                    <PlusIcon class="h-5 w-5 text-white" />
                                    <span class="text-xs text-white">Agregar</span>
                                </a>
                            </div>
                            <select v-model="nivelSelect"
                                class="mt-2 w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="" disabled>Seleccione un nivel</option>
                                <option v-for="nivel in this.data.nivelesEducativos" :key="nivel.id" :value="nivel">
                                    {{ nivel.description }}
                                </option>
                            </select>
                        </div>
                        <div class="col-span-2 mt-2">
                            <label class="text-sm font-medium text-gray-700">Niveles
                                seleccionados</label>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span v-for="(nivel, index) in this.form.nivelesSelected" :key="index"
                                    class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-sm shadow-xs font-medium text-green-700 ring-1 ring-inset ring-green-700/10 mr-2 mb-2">
                                    {{ nivel.description }}
                                    <Icons name="trash" @click="removeNivel(nivel.id)"
                                        class="h-5 w-5 text-red-700 ml-2" />
                                </span>
                            </div>
                        </div>

                        <!-- Turnos -->
                        <div class="col-span-2">
                            <div class="flex items-center justify-between">
                                <label for="turno" class="text-sm font-medium text-gray-700">Turnos</label>
                                <a @click="addTurno"
                                    class="flex items-center space-x-2 shadow-sm bg-blue-500 rounded-md py-1 px-2 hover:bg-blue-800 cursor-pointer">
                                    <PlusIcon class="h-5 w-5 text-white" />
                                    <span class="text-xs text-white">Agregar</span>
                                </a>
                            </div>
                            <select v-model="turnoSelect"
                                class="mt-2 w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="" disabled>Seleccione un turno</option>
                                <option v-for="turno in this.data.turnos" :key="turno.id" :value="turno">
                                    {{ turno.description }}
                                </option>
                            </select>
                        </div>

                        <div class="col-span-2 mt-2">
                            <label class="text-sm font-medium text-gray-700">Turnos
                                seleccionados</label>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span v-for="(turno, index) in this.form.turnosSelected" :key="index"
                                    class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-sm shadow-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10 mr-2 mb-2">
                                    {{ turno.description }}
                                    <Icons name="trash" @click="removeTurno(turno.id)"
                                        class="h-5 w-5 text-red-700 ml-2" />
                                </span>
                            </div>
                        </div>
                    </dl>
                </div>

            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <button @click="closeModal"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Cancelar</button>
                <button @click="handleSubmit" :disabled="loadingSubmit"
                    class="px-6 py-2 rounded-md shadow-sm flex items-center transition text-white bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:outline-none disabled:bg-gray-400 disabled:cursor-not-allowed">
                    <span v-if="loadingSubmit">Guardando...</span>
                    <span v-else>Guardar</span>
                    <svg v-if="loadingSubmit" xmlns="http://www.w3.org/2000/svg" class="text-gray-300 animate-spin ml-1"
                        viewBox="0 0 24 24" width="15" height="15">
                        <path fill="currentColor" d="M12,4V2A10,10 0 0,0 2,12H4A8,8 0 0,1 12,4Z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import Icons from '@/Layouts/Components/Icons.vue'
import { PlusIcon, CheckCircleIcon } from '@heroicons/vue/24/outline'
import Toast from "@/Layouts/Components/Toast.vue"
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'

export default {
    props: {
        escuela: Object,
        type: String,
        data: Object,
        show: Object,
    },
    components: {
        Icons,
        PlusIcon,
        CheckCircleIcon,
        Toast,
        Dialog,
        DialogPanel,
        TransitionChild,
        TransitionRoot,
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
                jornada_id: this.escuela?.jornada_id ?? '',
                activo: this.escuela?.activo ?? 1,
                nivelesSelected: this.escuela?.niveles?.map(({ pivot, ...rest }) => rest) ?? [],
                turnosSelected: this.escuela?.turnos?.map(({ pivot, ...rest }) => rest) ?? [],
            },
            nivelSelect: '',
            turnoSelect: '',
            loadingSubmit: false,
            showToast: false,
            toastMessage: "",
            errors: {},
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

        addTurno() {
            let existe_turno = this.form.turnosSelected.find(turno => turno.id === this.turnoSelect.id);
            if (this.turnoSelect === '') {
                this.turnoType = "info";
                this.toastMessage = "Debe ingresar un Turno";
            } else {
                if (!existe_turno) {
                    this.form.turnosSelected.push(this.turnoSelect);
                } else {
                    this.labelType = "info";
                    this.toastMessage = "El Turno ya se encuentra asignado";
                }
            }
            this.turnoSelect = '';
        },
        removeTurno(id) {
            const index = this.form.turnosSelected.findIndex(item => item.id === id);
            this.form.turnosSelected.splice(index, 1);
            this.labelType = "success";
            this.toastMessage = "Se ha eliminado correctamente el Turno";
        },

        validate() {
            this.errors = {};

            if (!this.form.nombre_completo) this.errors.nombre_completo = "El nombre de la Escuela es obligatoria";
            if (!this.form.activo) this.errors.activo = "El estado de la Escuela es obligatoria";

            return Object.keys(this.errors).length === 0;
        },

        async newItem() {
            const isValid = await this.validate();
            if (isValid) {

                this.loadingSubmit = true;
                const nivelesIds = this.form.nivelesSelected.map(nivel => nivel.id);
                const turnosIds = this.form.turnosSelected.map(nivel => nivel.id);
                const formData = { ...this.form, nivelesSelected: nivelesIds, turnosSelected: turnosIds };

                try {
                    const response = await axios.post(route('masterdata.escuelas.store_escuela'), formData);

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
                    this.loadingSubmit = false;
                    this.closeModal();
                }
            }
        },

        async editItem() {
            const isValid = await this.validate();
            if (isValid) {
                this.loadingSubmit = true;
                const nivelesIds = this.form.nivelesSelected.map(nivel => nivel.id);
                const turnosIds = this.form.turnosSelected.map(nivel => nivel.id);
                const formData = { ...this.form, nivelesSelected: nivelesIds, turnosSelected: turnosIds };
                try {
                    const response = await axios.post(route('masterdata.escuelas.update_escuela'), formData);

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
                    //settimeout
                    this.loadingSubmit = false;
                    this.closeModal();
                }
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

        beforeEnter(el) {
            el.style.opacity = 0;
        },
        enter(el, done) {
            el.offsetHeight; // Trigger reflow to restart animation
            el.style.transition = 'opacity 0.5s, transform 0.5s';
            el.style.opacity = 1;
            el.style.transform = 'scale(1)';
            done();
        },
        leave(el, done) {
            el.style.transition = 'opacity 0.5s, transform 0.5s';
            el.style.opacity = 0;
            el.style.transform = 'scale(0.9)';
            done();
        }

    },
    mounted() {
        document.addEventListener('keydown', this.handleKeydown);
    },
    unmounted() {
        document.removeEventListener('keydown', this.handleKeydown);
    },
};
</script>