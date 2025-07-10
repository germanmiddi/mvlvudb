<template>

    <TipoTramite
        :name="this.name"
        :dependencia_id="this.dependencia_id"
        @toast-message="setMessage"
    />
    <Roles

        @toast-message="setMessage"
    />
</template>

<script>
import axios from 'axios'
import ListItem from './ListItem.vue'
import TipoTramite from './Entidades/TipoTramite.vue'
import Roles from './Entidades/Roles.vue'

export default {

    props:{
        name: {
            type: String,
            required: true
        },
        dependencia_id: {
            type: Number,
            required: true
        }
    },
    components:{
        ListItem,
        TipoTramite,
        Roles
    },
    setup(){

    },

    data(){

        return{
            tipoTramite: "",
            showNew: false,
            newDescription: "",
        }
    },
    created(){
        this.getData()
    },
    methods:{
		async getData() {
            let response = await fetch(route('masterdata.get_tipo_tramite',this.dependencia_id ), { method: 'GET' })
            this.tipoTramite = await response.json()
		},

        async newItem(){
            let formData = new FormData();
            formData.append('dependencia_id', this.dependencia_id);
            formData.append('description', this.newDescription);

			try {
				const response = await axios.post(route('masterdata.store_tipo_tramite') , formData  );

				if (response.status == 200) {
                    this.$emit('toast-message',
                                {'message' : response.data.message,
                                 'type' : 'success'} )

                    this.newDescription = ""
                    this.showNew = false
                    this.getData()

				} else {
                    this.$emit('toast-message',
                                {'message' : response.data.message,
                                 'type' : 'danger'} )
				}
			} catch (error) {
				console.log(error)
			}

        },
        async editItem(item){
            let formData = new FormData();
            formData.append('id', item.id);
            formData.append('description', item.description);
            formData.append('activo', item.activo);


			try {
				const response = await axios.post(route('masterdata.update_tipo_tramite') , formData  );

				if (response.status == 200) {
                    this.$emit('toast-message',
                                {'message' : response.data.message,
                                 'type' : 'success'} )

				} else {
                    this.$emit('toast-message',
                                {'message' : response.data.message,
                                 'type' : 'danger'} )
				}
			} catch (error) {
				console.log(error)
			}
        },

        async hideItem(id){

            const response = await axios.post(route('masterdata.hide_tipo_tramite' ), {id : id} );

            if (response.status == 200) {
                this.$emit('toast-message',
                                {'message' : response.data.message,
                                 'type' : 'success'} )

            } else {
                this.$emit('toast-message',
                                {'message' : response.data.message,
                                 'type' : 'danger'} )
            }

        },
        async destroyItem(id){
            const response = await axios.post(route('masterdata.destroy_tipo_tramite' ), {id : id} );

            if (response.status == 200) {
                this.$emit('toast-message',
                                {'message' : response.data.message,
                                 'type' : 'success'} )

                this.tipoTramite = this.tipoTramite.filter( item => item.id != id)

            } else {
                this.$emit('toast-message',
                                {'message' : response.data.message,
                                 'type' : 'danger'} )
            }
        },

        setMessage(message) {
            this.$emit('toast-message', message);
        }

    },
}
</script>
