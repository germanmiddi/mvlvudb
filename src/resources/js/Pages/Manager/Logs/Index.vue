<template>
    <main class="flex-1">
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Vista Logs
                </h1>
            </div>
        </div>
        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>
        <div class="px-4 mt-6 sm:px-6 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
                        <div class="">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Filtro</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <button type="button"
                                class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white" @click="getLogs()">Aplicar
                                Filtro</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 sm:col-span-3">
                            <label for="length" class="block text-sm font-medium text-gray-700">Cantidad de lineas</label>
                            <select v-model="length" id="length" name="length"
                                autocomplete="off"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="100" selected>100</option>
                                <option value="200" selected>200</option>
                                <option value="300" selected>300</option>
                                <option value="400" selected>400</option>
                                <option value="500" selected>500</option>
                                <option value="1000" selected>1000</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col mt-8 mx-4 sm:mx-6 lg:mx-8">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <div class="m-4 min-w-full divide-y divide-gray-200 text-xs leading-6" v-html="logs.data">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import { ref } from "vue";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

import {
    ChevronRightIcon,
    EllipsisVerticalIcon,
    PencilSquareIcon,
    ArrowsPointingOutIcon
} from "@heroicons/vue/24/solid";
import Toast from "@/Layouts/Components/Toast.vue";

export default {
    props: {
        toast: Object,
        tiposTramite: Object
    },
    components: {
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        EllipsisVerticalIcon,
        ChevronRightIcon,
        PencilSquareIcon,
        ArrowsPointingOutIcon,
        Toast,
        Datepicker
    },
    data() {
        return {
            logs: "",
            toastMessage: "",
            labelType: "info",
            message: "",
            showToast: false,
            length: 100,
        };
    },
    setup() {
    },
    methods: {
        clearMessage() {
            this.toastMessage = "";
        },
        async getLogs() {
            this.logs = ''
            let filter = `&length=${this.length}`

            const get = `${route('logs.listLast')}?${filter}`

            const response = await fetch(get, { method: "GET" });
            this.logs = await response.json();
        }
    },
    mounted() {
        if (this.toast) {
            if (this.toast["status"] == 200) {
                this.labelType = "success";
                this.toastMessage = this.toast["message"];
            } else {
                this.labelType = "danger";
                this.toastMessage = this.toast["message"];
            }
        }
        this.getLogs();
    }
};
</script>

<style></style>
