<template>
  <div class="map-view">
    <div ref="map" class="map">
      <img src="/images/icon_globe.svg" class="globe" alt=""><br>
      Loading map...
    </div>
    <direction-guide v-bind:routes="selectedRestaurant"></direction-guide>
  </div>
</template>
 
<script>

  const MapHelper = require('./../helpers/maps');
  const Restaurant = require('./../models/restaurant');

  export default {
    created() {

      let self = this;
      
      window.bus.$on('get-direction', function (name, lat, lng) {

        let request = {
          origin: self.location,
          destination: {lat: lat, lng: lng},
          travelMode: 'DRIVING'
        };

        self.directionsService.route(request, function(result, status) {
          if (status == 'OK') {
            self.directionsDisplay.setDirections(result);
            self.selectedRestaurant = result.routes;
          }
        });
      });

      window.bus.$on('remove-direction', function (route) {
        self.directionsDisplay.setDirections({routes: []});
      });

    },
    mounted() {

      window.initMap = () => {
        let self = this;
        let restaurantRepo = new Restaurant();

        Promise.all([MapHelper.getLocation(), restaurantRepo.getAll()]).then(results => { 
          let restaurants = 'restaurants' in results[1] ? results[1].restaurants : [];
          let initLocation = results[0];

          self.mapElement = new google.maps.Map(self.$refs.map, {
            zoom: 12,
            center: initLocation,
            fullscreenControl: true,
            fullscreenControlOptions: {
                position: google.maps.ControlPosition.RIGHT_BOTTOM
            },
            mapTypeControl: false,
          });

          self.location = initLocation;

          self.directionsDisplay = new google.maps.DirectionsRenderer();
          self.directionsService = new google.maps.DirectionsService();
          self.directionsDisplay.setMap(self.mapElement);

          // marker for user's location
          MapHelper.createMarker(self.mapElement, self.location, '/images/icon_happy.png');

          // marker for restaurants
          self.markers = MapHelper.createMarkers(self, restaurants);
        });
      }

    },
    data() {
      return {
        mapElement: null,
        markers: [],
        infoWindow: null,
        location: {lat: 0, lng: 0},
        selectedRestaurant: null,
        directionsDisplay: null,
        directionsService: null,
      }
    }
  }
</script> 
<style>
  .map {
    text-align: center;
    height: 100vh;
    width: 100%;

    /* flex override */
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
  }
  .map-view {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
  }
  .globe {
    width: 50px;
    height: 50px;
  }
</style>