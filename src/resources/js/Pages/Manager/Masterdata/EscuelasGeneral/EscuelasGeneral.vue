<template lang="">
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div>
                <div class="flex justify-between">
                    <h2 id="" class="text-lg leading-6 font-medium text-gray-900">Escuelas</h2>
                    <button class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white" 
                            @click="openModalForm('create')">Crear</button>
                </div>
            </div>
            <div class="">
                <table class="min-w-full divide-y divide-gray-200">    
                    <thead class="border-b-1 border-indigo-600 ">
                        <tr>
                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-4/6  text-left">Descripción</th>
                            <th class="px-6 py-4 text-sm font-medium text-gray-700 tracking-wider w-2/6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <ListEscuelasGeneral :data="formData" v-for="t in this.escuelas" :key="t.id" :item=t 
                                      @hide-item="hideItem" 
                                      @destroy-item="destroyItem"
                                      @getUpdatedData="getData"/>

                         <ModalEscuelas v-if="showFormModal" :escuela=null :type="type" :data="formData" :show="showFormModal"
                                      @closeModal="closeModalForm"/>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import ListEscuelasGeneral from './ListEscuelasGeneral.vue'
import ModalEscuelas from './ModalEscuelas.vue';
import { ref, watch, computed } from 'vue';

export default {
    props: {
        dependencia_id: {
            type: Number,
            required: true
        }
    },
    components: {
        ListEscuelasGeneral,
        ModalEscuelas,
    },
    setup() {

    },

    data() {

        return {
            escuelas: {},
            newDescription: "",
            showFormModal: false,
            formData: [],
        }
    },
    created() {
        this.getData();
        this.getFormData();
    },
    methods: {
        async getData() {
            let response = await fetch(route('masterdata.escuelas.get_escuelas'), { method: 'GET' })
            this.escuelas = await response.json()
        },

        async getFormData() {
            try {
                let response = await fetch(route('masterdata.escuelas.get_escuelasData'), { method: 'GET' })
                this.formData = await response.json();
            } catch (error) {
                console.log(error)
            }
        },

        async hideItem(id) {

            const response = await axios.post(route('masterdata.escuelas.hide_escuela'), { id: id });

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

        async destroyItem(id) {
            const response = await axios.post(route('masterdata.escuelas.destroy_escuela'), { id: id });

            if (response.status == 200) {
                this.$emit('toast-message',
                    {
                        'message': response.data.message,
                        'type': 'success'
                    })

                this.escuelas = this.escuelas.filter(item => item.id != id)

            } else {
                this.$emit('toast-message',
                    {
                        'message': response.data.message,
                        'type': 'danger'
                    })
            }
        },
        openModalForm(type) {
            this.disableScroll();
            this.type = type
            this.showFormModal = true;
        },

        closeModalForm() {
            this.getData();
            this.enableScroll();
            this.showFormModal = false;
        },

        toastMessage(message, type) {
            this.$emit('toast-message',
                {
                    'message': this.message,
                    'type': this.type
                })
        },

        enableScroll() {
            document.body.classList.remove('no-scroll');
        },

        disableScroll() {
            document.body.classList.add('no-scroll');
        },
    },


}
</script>

<style>
.no-scroll {
    overflow: hidden;
}
</style>
