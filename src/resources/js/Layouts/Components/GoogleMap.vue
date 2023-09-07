<template>
    <GoogleMap 
        :key="markerOptions.title"
        api-key="AIzaSyC2ZgKApfK_YBbSnZE6NGGacXCnYqF3zNw" 
        style="width: 100%; height: 300px" 
        :center="markerOptions.position" 
        :zoom="16"
        :getDraggable="true"
        place_changed="geolocateStart"
        @click="mapClicked">
        <Marker :options="markerOptions" />
    </GoogleMap>
</template>

<script>

import { defineComponent } from 'vue'
import { GoogleMap, Marker } from "vue3-google-map";

export default defineComponent({
    props: {
        form_map: Object
    },
    components: {
        GoogleMap,
        Marker
    },
    data() {
        return {
            markerOptions: { 
                position: 
                    { 
                        lat: this.form_map['latitude'], 
                        lng: this.form_map['longitude']
                    }, 
                label: 'C', 
                title: this.form_map['route']
            }
        }
    },
    methods: {
      mapClicked(event) {
        console.log(event)
        this.form_map['latitude'] =  event.latLng.lat()
        this.form_map['longitude'] =  event.latLng.lng()
        this.markerOptions = { 
            position: 
                { 
                    lat: this.form_map['latitude'], 
                    lng: this.form_map['longitude']
                }, 
            label: 'C', 
            title: this.form_map['route'],
        }

        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ location: this.markerOptions.position }, (results, status) => {
            if (status === 'OK' && results[0]) {
               this.markerOptions.address = results[0].formatted_address;
            }
            this.$emit('coordenadas_google',this.markerOptions);
        });
      
      },
    },
   
    watch:{
        form_map:{
            handler:function(newForm_map){
                this.markerOptions.title = newForm_map['route']
                this.markerOptions.position.lat = newForm_map['latitude']
                this.markerOptions.position.lng = newForm_map['longitude']
            },
        }
    }
});

</script>