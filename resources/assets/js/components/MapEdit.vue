<template>
  <div>
    <div ref="map" style="width: 100%; height: 200px;"></div>
    <input id="lng" type="hidden" name="lng" v-model="displayLng">
    <input id="lat" type="hidden" name="lat" v-model="displayLat">
  </div>
</template>
 
<script>
  export default {
    props: [
      'lat', 
      'lng'
    ],
    mounted() {
      window.initMap = () => {

        let self = this;
        let initLocation = {lat: this.lat, lng: this.lng};

        this.mapElement = new google.maps.Map(this.$refs.map, {
          zoom: 14,
          center: initLocation
        });

        this.marker = new google.maps.Marker({
          position: initLocation,
          map: this.mapElement
        });

        this.location = initLocation;

        google.maps.event.addListener(this.mapElement, 'click', (event) => {
          let newObj = {lat: event.latLng.lat(), lng: event.latLng.lng()};
          self.location = newObj;
        });
      }

    },
    data() {
      return {
        mapElement: null,
        marker: null,
        location: {lat: 0, lng: 0},
        displayLat: 0,
        displayLng: 0,
      }
    },
    watch: {
      location: function(newLocation) {
        this.marker.setPosition({lat: this.location.lat, lng: this.location.lng});
        this.displayLat = this.location.lat;
        this.displayLng = this.location.lng;
      },
    }
  }
</script> 