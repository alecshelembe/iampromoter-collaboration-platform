<!DOCTYPE html>
<html>
<head>
  <title>Google Places API with jQuery</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
</head>
<body>

  <input type="text" id="address-input" placeholder="Enter address">
  <button id="search-button">Search</button>
  <div id="results"></div>

  <script>
    $(document).ready(function() {
      $("#search-button").click(function() {
        var address = $("#address-input").val();

        // Geocode the address to get latitude and longitude
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({ address: address }, function(results, status) {
          if (status === 'OK') {
            var lat = results[0].geometry.location.lat();
            var lng = results[0].geometry.location.lng();

            // Make Places API request for nearby restaurants
            var request = {
              location: { lat: lat, lng: lng },
              radius: '500',
              type: ['restaurant']
            };

            var service = new google.maps.places.PlacesService(document.createElement('div'));
            service.nearbySearch(request, function(results, status) {
              if (status === google.maps.places.PlacesServiceStatus.OK) {
                $("#results").empty(); // Clear previous results

                for (var i = 0; i < results.length; i++) {
                  var result = results[i];
                  $("#results").append("<p>" + result.name + "</p>");
                }
              }
            });
          } else {
            alert("Geocode was not successful: " + status);
          }
        });
      });
    });
  </script>

</body>
</html>