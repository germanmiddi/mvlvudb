<template>
    <main class="flex-1">
        <!-- Page title & actions -->
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0 flex items-center">
				<a class="btn-blue" :href="route('persons')">
					<ArrowLeftCircleIcon class="w-5 h-5 text-purple-700 mr-2" />
				</a>
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                    Historial de Comentarios
                </h1>
			</div>
        </div>

        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

        <div class="flex flex-col mt-8 mx-4 sm:mx-6 lg:mx-8">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <div class="m-4">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-base font-semibold leading-7 text-gray-900">Datos Persona</h3>
                                <div class="grid grid-cols-12 gap-6 mt-4">
                                    <div class="col-span-12 md:col-span-4 sm:col-span:6">
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"><b>Nombre:</b> {{person.lastname}}, {{person.name}}</dd>
                                    </div>
                                    <div class="col-span-12 md:col-span-4 sm:col-span:6">
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"><b>DNI:</b> {{person.num_documento}}</dd>
                                    </div>
                                    <div class="col-span-12 md:col-span-4 sm:col-span:6">
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"><b>Contacto:</b> {{person.contact[0]['phone'] ?? '-'}} | {{person.contact[0]['email'] ?? '-'}}</dd>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div v-for="tramite in person.tramites" v-key="tramite.id" class="flex flex-col mt-4 mx-4 sm:mx-6 lg:mx-8">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <div class="m-4">
                            <h3 class="text-base font-semibold leading-7 text-gray-900">Tramite N°. {{tramite.id}}</h3>
                            <div class="mt-6 border-t border-gray-100">
                                <div class="grid grid-cols-12 gap-6 mt-4">
                                    <div class="col-span-12 md:col-span-4 sm:col-span:6">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Dependencia</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{tramite.dependencia.description}}</dd>
                                    </div>
                                    <div class="col-span-12 md:col-span-4 sm:col-span:6">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Fecha</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{tramite.fecha}}</dd>
                                    </div>
                                    <div class="col-span-12 md:col-span-4 sm:col-span:6">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Responsable Asignado</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{tramite.assigned ? tramite.assigned.name : '-'}}</dd>
                                    </div>
                                </div>

                                <hr class="mt-2">

                                <div class="grid grid-cols-12 gap-6 mt-4" v-if="tramite.comments != ''">
                                    <div class="col-span-12">
                                        <div class="flex-1 min-w-0 flex items-center">
                                                <ChatBubbleLeftEllipsisIcon class="h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                                <h3 class="ml-2 text-sm font-medium leading-6 text-gray-900">
                                                    Comentarios
                                                </h3>
                                            </div>  
                                        <div v-for="comment in tramite.comments"  v-key="comment.id">
                                            
                                            <Comment v-if="store.userCan(comment.dependencia.rol_prefix, $page.props.userGroups) && comment.activo === 1"
                                                        :comment=comment 
                                                        @message="handleMessage"
                                                        @deleteComment="handleDeleteComment" >
                                            </Comment>
                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-12 gap-6 mt-6" v-else>
                                    <div class="col-span-12">
                                        <div class="flex">
                                            <div class="flex-1 min-w-0 flex items-center">
                                                <ChatBubbleLeftEllipsisIcon class="h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                                <h3 class="ml-2 text-sm font-medium leading-6 text-gray-400">
                                                    No posee comentarios
                                                </h3>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-12 gap-6 mt-6" v-if="tramite.archivos != ''">
                                    <div class="col-span-12">
                                        <div class="flex-1 min-w-0 flex items-center">
                                            <PaperClipIcon class="h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                            <h3 class="ml-2 text-sm font-medium leading-6 text-gray-900">
                                                Adjuntos
                                            </h3>
                                        </div>
                                        <div class="flex flex-col mt-4 col-span-12 bg-gray-100 rounded-lg">
                                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                                        <li v-for="archivo in tramite.archivos" v-key="archivo.id" class="flex items-center justify-between py-2 pr-5 text-sm leading-6 ml-4">
                                                            <div class="flex w-0 flex-1 items-center">
                                                                <DocumentIcon class="h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                                                <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                                                    <span class="truncate font-medium">{{archivo.description}}.{{archivo.ext}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="ml-4 flex-shrink-0">
                                                                <a class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-blue-200 text-blue-900 hover:bg-blue-600 hover:text-white"
                                                                    :href="'/file/download/' + archivo.id" target="_blank"
                                                                    title="Descargar Archivo">
                                                                    Descargar
                                                                </a>
                                                            </div>
                                                        </li>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-12 gap-6 mt-6" v-else>
                                    <div class="col-span-12">
                                        <div class="flex">
                                            <div class="flex-1 min-w-0 flex items-center">
                                                <PaperClipIcon class="h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                                <h3 class="ml-2 text-sm font-medium leading-6 text-gray-400">
                                                    No posee archivos adjuntos
                                                </h3>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>
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
import { ArrowLeftCircleIcon } from '@heroicons/vue/24/outline';
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

import {
    ChevronRightIcon,
    EllipsisVerticalIcon,
    PencilSquareIcon,
    ArrowsPointingOutIcon,
    UserCircleIcon,
    ArrowPathIcon,
    PaperClipIcon,
    ChatBubbleLeftEllipsisIcon,
    DocumentIcon
} from "@heroicons/vue/24/solid";
import Toast from "@/Layouts/Components/Toast.vue";
import store from '@/store.js'
import Comment from '@/Layouts/Components/Tramites/Comment.vue';

export default {
    props: {
        toast: Object,
        person: Object
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
        UserCircleIcon,
        ArrowPathIcon,
        PaperClipIcon,
        Toast,
        Datepicker,
        ArrowLeftCircleIcon,
        store,
        ChatBubbleLeftEllipsisIcon,
        DocumentIcon,
        Comment
    },
    data() {
        return {
            persons: "",
            toastMessage: "",
            labelType: "info",
            message: "",
            showToast: false,
            filter: {},
            length: 10,
        };
    },
    setup() {
        return {
            store
        }
    },
    methods: {
        clearFilter(){
            this.filter = {}
            this.getPersons()
        },
        clearMessage() {
            this.toastMessage = "";
        },
        handleMessage(data){
            this.labelType = data.labelType;
            this.toastMessage = data.toastMessage;
        },
        handleDeleteComment(id){
            for (const tramite of this.person.tramites) {
                console.log(tramite);
                const comment = tramite.comments.find(comentario => comentario.id === id);
                if (comment) {
                    console.log(comment);
                    comment.activo = 0;
                }
            }
        }
    },
    computed: {
		
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
    }
};
</script>

<style></style>
