document.getElementById("geo-locate-btn").addEventListener("click", function() {
  const locationResult = document.getElementById("location-result");
  locationResult.innerHTML = `<p>We need access to your location to show the closest address. Please allow location access in the prompt.</p>`;

  if (navigator.geolocation) {
    console.log("Geolocation is supported.");
    navigator.geolocation.getCurrentPosition(
      position => geocodePosition(position.coords.latitude, position.coords.longitude),
      error => handleGeoError(error)
    );
  } else {
    locationResult.innerHTML = "<p>Geolocation is not supported by this browser.</p>";
  }
});

function geocodePosition(lat, lng) {
  console.log(`Location: Latitude: ${lat}, Longitude: ${lng}`);
  const geocoder = new google.maps.Geocoder();
  const latLng = { lat: parseFloat(lat), lng: parseFloat(lng) };

  geocoder.geocode({ location: latLng }, (results, status) => {
    const addressResult = document.getElementById("address-result");
    if (status === google.maps.GeocoderStatus.OK && results[0]) {
      document.getElementById("floating_address").value = results[0].formatted_address;
    } else {
      addressResult.innerHTML = `<p>${status === google.maps.GeocoderStatus.OK ? 'No address found' : 'Geocoder failed: ' + status}</p>`;
    }
  });
}

function handleGeoError(error) {
  console.error("Error code: " + error.code + " - " + error.message);
  document.getElementById("location-result").innerHTML = "<p>Unable to retrieve location. Please allow access to your location.</p>";
}