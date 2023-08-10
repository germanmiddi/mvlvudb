<template>

</template>

<script>
import { defineComponent } from 'vue'
import Toast from "@/Layouts/Components/Toast.vue"
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

export default ({
    props: {

    },
    components: {
        Toast,
        Datepicker
    },
    data() {
        return {
            form_familiar: {},
            form_temp: {},
			familiares: [],
            /* MENSAJERIA */
			toastMessage: "",
			labelType: "info",
			message: "",
			showToast: false
        };
    },
    setup() {
        const format = (date) => {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            return `${day}/${month}/${year}`;
        }

        return {
            format,
        }
    },
    methods: {
        clearMessage() {
			this.toastMessage = "";
		},

        async getPerson() {
            this.form_temp.num_documento = this.form_familiar.num_documento;
            this.form_temp.tipo_documento_id = this.form_familiar.tipo_documento_id;

            const get = `${route('persons.getPersonDni', this.form_familiar.num_documento)}`
            const response = await fetch(get, { method: 'GET' })
            let data = await response.json()
            if (!data.data.length == 0) {
                data = data.data[0].person
                /// Recuperar datos.
                this.form_familiar.id = data.id 
                this.form_familiar.tipo_documento_id = data.tipo_documento_id
                this.form_familiar.fecha_nac = data.fecha_nac
                this.form_familiar.fecha_nac = new Date(this.form_familiar.fecha_nac + "T00:00:00.000-03:00")
                this.form_familiar.name = data.name
                this.form_familiar.lastname = data.lastname
                this.form_familiar.email = data.contact[0].email
                this.form_familiar.phone = data.contact[0].phone
                if(data.cud && this.showCud){
					this.form_familiar.codigo = data.cud.codigo
					this.form_familiar.diagnostico = data.cud.diagnostico
				}
            } else {
                this.labelType = "info";
                this.toastMessage = "El DNI indicado no se encuentra registrado";
                this.form_familiar = {}
                this.form_familiar = this.form_temp
                this.form_temp = {}
            }
        },
        
        /* ***************************
		** * MANEJO DE FAMILIARES
		*/
		addFamiliar() {
			if (this.familiares.find(familiar => familiar.num_documento === this.form_familiar.num_documento)) {
				this.labelType = "danger";
				this.toastMessage = "La persona ya se ha ingresado previamente";
			} else {
				if (this.form_familiar.name && this.form_familiar.lastname  && this.form_familiar.num_documento && this.form_familiar.fecha_nac && this.form_familiar.parentesco_id) {
					this.familiares.push(
						{
							id: this.form_familiar.id,
							name: this.form_familiar.name,
							lastname: this.form_familiar.lastname,
							num_documento: this.form_familiar.num_documento,
                            tipo_documento_id: this.form_familiar.tipo_documento_id,
							fecha_nac: new Date(this.form_familiar.fecha_nac).toISOString(),
							parentesco_description: this.parentescos.find(parentesco => parentesco.id === this.form_familiar.parentesco_id).description,
							parentesco_id: this.parentescos.find(parentesco => parentesco.id === this.form_familiar.parentesco_id).id,
						}
                    )
                    this.form_familiar = {}
				} else {
					this.labelType = "danger";
					this.toastMessage = "Debe completar todos los datos";
				}
			}
		},
		deleteFamiliar(index) {
			this.familiares.splice(index, 1);
		},
    },
    watch: {
        familiares: {
            deep: true,
            handler(newValue, oldValue) {
            console.log(newValue)
            this.$emit('data_familiares', newValue)
            }
        },
        dni: {
            handler(newValue, oldValue) {
                this.form_familiar.num_documento = newValue;
                this.getPerson()
            }
        }
    },
    /* created() {
        console.log(this.dni);
    }, */

});

</script>