<template>
	<TransitionRoot as="template">
		<Dialog as="div" class="relative z-10">
			<TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
				leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
				<div class="fixed inset-0 hidden bg-gray-500 bg-opacity-75 transition-opacity md:block" />
			</TransitionChild>

			<div class="fixed inset-0 z-10 overflow-y-auto ">
				<div class="flex items-stretch justify-center text-center md:items-center md:px-2 lg:px-4 h-full md:max-h-7xl lg:max-h-7xl">
					<TransitionChild as="template" enter="ease-out duration-300"
						enter-from="opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
						enter-to="opacity-100 translate-y-0 md:scale-100" leave="ease-in duration-200"
						leave-from="opacity-100 translate-y-0 md:scale-100"
						leave-to="opacity-0 translate-y-4 md:translate-y-0 md:scale-95">
						<DialogPanel class="flex w-full transform text-left text-base transition md:my-8 md:max-w-7xl md:px-4 lg:max-w-7xl ">
							
							<div class="relative flex w-full items-center overflow-hidden bg-white px-4 pt-14 pb-8 shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8  rounded-md">

								<button type="button"
									class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 sm:top-8 sm:right-6 md:top-6 md:right-6 lg:top-8 lg:right-8"
									@click="closeModal">
									<span class="sr-only">Close</span>
									<XIcon class="h-6 w-6 " aria-hidden="true" />
								</button>

								<div class="grid w-full grid-cols-1 items-start gap-y-8 gap-x-2 sm:grid-cols-8 lg:gap-2">

									<div class="sm:col-span-8 lg:col-span-8">
										<h1 class="text-2xl font-bold text-gray-900">Vista Previa</h1>
									</div>

									<div class="sm:col-span-8 lg:col-span-8">
										<section aria-labelledby="options-heading" class="mt-10">
											<iframe :src="file" width="100%" height="350px" allowFullScreen frameborder="0"></iframe>
											<div class="content-start mt-4">
												<button @click="closeModal"
													class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-red-200 text-red-900 hover:bg-red-600 hover:text-white">
													Cerrar
												</button>
											</div>
										</section>
									</div>
								</div>
							</div>
						</DialogPanel>
					</TransitionChild>
				</div>
			</div>
		</Dialog>
	</TransitionRoot>
</template>

<script>

import { defineComponent, ref } from 'vue'
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'


import Icons from '@/Layouts/Components/Icons.vue'

import {
	Menu, MenuButton, MenuItem, MenuItems, Dialog,
	DialogPanel,
	RadioGroup,
	RadioGroupLabel,
	RadioGroupOption,
	TransitionChild,
	TransitionRoot,
} from '@headlessui/vue'
import VueGoogleAutocomplete from "vue-google-autocomplete"

export default {

	props: {
		file: Object
	},

	components: {
		Datepicker,
		
		Icons,
		Menu,
		MenuButton,
		MenuItem,
		MenuItems,
		Dialog,
		DialogPanel,
		RadioGroup,
		RadioGroupLabel,
		RadioGroupOption,
		TransitionChild,
		TransitionRoot,
		
		
		VueGoogleAutocomplete
	},
	data() {
		return {
			newClient: false,
			btnTextNewClient: "Nuevo Cliente",
			form_google: "",
			form: {},
		}
	},
	setup() {
		const format = (date) => {
			const day = date.getDate();
			const month = date.getMonth() + 1;
			const year = date.getFullYear();

			return `${day}/${month}/${year}`;
		}

		const startTime = ref({ hours: 9, minutes: 0 });

		const open = ref(false)

		return {
			format,
			startTime,
			open
		}
	},

	methods: {
		
		closeModal(){
			this.$emit('closeModal', false)
			
		}

	},
	watch: {
		newClient: function (value) {
			if(value){
				this.btnTextNewClient = 'Cancelar'
				this.cleanNewUser()
				this.form.newClient = true
				
			}else{
				this.btnTextNewClient = 'Nuevo Cliente'
				this.cleanNewUser()
				this.form.newClient = false
			}
		}
	},
	created() {
		this.form.newClient = false
	}

}
</script>