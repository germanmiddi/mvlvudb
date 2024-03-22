<template>
    <div class="flex flex-col mt-4 col-span-12 bg-gray-50 rounded-lg">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <div class="grid grid-cols-12 gap-6 m-4">
                        <div class="col-span-12 md:col-span-4 sm:col-span:6">
                            <dt class="text-sm font-medium leading-6 text-gray-900">Dependencia</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{comment.dependencia.description}}</dd>
                        </div>
                        <div class="col-span-12 md:col-span-4 sm:col-span:6">
                            <dt class="text-sm font-medium leading-6 text-gray-900">Fecha</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{comment.created_at_comment}}</dd>
                        </div>
                        <div class="col-span-12 md:col-span-4 sm:col-span:6">
                            <dt class="text-sm font-medium leading-6 text-gray-900">Responsable</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{comment.user.name}}</dd>
                        </div>
                    </div>
                    <dl class="grid grid-cols-1 gap-x-8 gap-y-10 lg:pt-2 m-4">
                        <div class="flex flex-col items-start">
                            <dd v-if="!editComment" class="mt-2 leading-7 text-gray-600 text-xs text-justify">{{comment.content}}</dd>
                            <textarea v-else v-model="comment.content" id="observacion" name="observacion" rows="8" 
                                class="p-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm text-justify border border-gray-300 rounded-md" />
                        </div>
                    </dl>
                    <dl class="grid grid-cols-1 gap-x-8 gap-y-10 lg:pt-2 m-4">
                        <div v-if="$page.props.user.id === comment.user.id" class="flex flex-col items-end">
                            <button v-if="!editComment" class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-gray-200 text-gray-900 hover:bg-gray-600 hover:text-white"
                                title="Editar Comentario" @click="editComment = true">
                                Editar Comentario
                            </button>
                            <button v-else class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-green-200 text-green-900 hover:bg-green-600 hover:text-white"
                                title="Editar Comentario" @click="submit()">
                                Guardar Comentario
                            </button>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import store from '@/store.js'

export default {
    props: {
        comment: Object
    },
    components: {
        store
    },
    data() {
        return {
            editComment: false
        };
    },
    setup() {
        return {
            store
        }
    },
    methods: {
        async submit(){
            this.editComment = false
			let rt = route('persons.editComments', this.comment.id);
            try {
				const response = await axios.put(rt, {content: this.comment.content});
				if (response.status == 200) {
                    this.$emit('message', {labelType: 'success', toastMessage: response.data.message});
				} else {
					this.$emit('message', {labelType: 'danger', toastMessage: response.data.message});
				}
			} catch (error) {
				console.log(error)
			}
        }
    }
};
</script>

<style></style>
