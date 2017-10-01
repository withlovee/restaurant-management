var MapHelper = {};

MapHelper.getLocation = () => {

  // default to singapore
  let defaultLocation = {
    lat: 1.2871404,
    lng: 103.844437
  };

  return new Promise((resolve, reject) => {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition((position) => {
        resolve({
          lat: position.coords.latitude,
          lng: position.coords.longitude
        })
      }, (err) => {
        // console.log(err);
        resolve(defaultLocation);
      });
    } else {
      resolve(defaultLocation);
    }
  });
};

MapHelper.openInfo = (self, marker, restaurant) => {
  if (self.infoWindow) self.infoWindow.close();
  self.infoWindow = new google.maps.InfoWindow({
    content: `
    <strong>${restaurant.name}</strong><br>
    ${restaurant.address}<br>
    <a href="#" data-name="${restaurant.name}" data-location="${restaurant.lat},${restaurant.lng}" onclick="window.bus.$emit('get-direction', '${restaurant.name}', ${restaurant.lat}, ${restaurant.lng})">Get direction</a>
    `
  });

  self.infoWindow.open(self.mapElement, marker);
};


MapHelper.createMarker = (map, location, icon) => {

  return new google.maps.Marker({
    position: location,
    icon: {
      url: window.url + '/images/' + icon,
      scaledSize: new google.maps.Size(32, 32),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(16, 16)
    },
    map: map
  });
};

MapHelper.createMarkers = (self, restaurants) => {

  let markers = [];

  for (let restaurant of restaurants) {
    let marker = MapHelper.createMarker(self.mapElement, { lat: restaurant.lat, lng: restaurant.lng }, 'icon_noodles.png');

    marker.addListener('click', function() {
      MapHelper.openInfo(self, marker, restaurant);
    });

    markers.push(marker);
  }

  return markers;
};


module.exports = MapHelper;