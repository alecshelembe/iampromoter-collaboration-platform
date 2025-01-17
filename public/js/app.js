// import './bootstrap';

// function previewImage(event) {
//     const file = event.target.files[0];
//     const preview = document.getElementById('image-preview');

//     if (file) {
//         const reader = new FileReader();
//         reader.onload = function(e) {
//             preview.src = e.target.result;
//             preview.classList.remove('hidden');
//         }
//         reader.readAsDataURL(file);
//     } else {
//         preview.classList.add('hidden');
//     } 
// }
 // Function to initialize the Google Maps Places Autocomplete
 function initializeAutocomplete() {
    var input = document.getElementById('floating_address');

    var autocomplete = new google.maps.places.Autocomplete(input, {
        types: ['geocode'],
        componentRestrictions: { country: 'ZA' }
    });

    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();

        // Update address
        if (place.formatted_address) {
            document.getElementById('google_location').value = place.formatted_address;
        }

        // Update latitude and longitude
        if (place.geometry) {
            document.getElementById('google_latitude').value = place.geometry.location.lat();
            document.getElementById('google_longitude').value = place.geometry.location.lng();
        }

        // Update location type
        if (place.types.length > 0) {
            document.getElementById('google_location_type').value = place.types[0];
        }

        // Update postal code
        var postalCode = place.address_components.find(component => component.types.includes("postal_code"));
        if (postalCode) {
            document.getElementById('google_postal_code').value = postalCode.long_name;
        }

        // Update city
        var city = place.address_components.find(component => component.types.includes("locality"));
        if (city) {
            document.getElementById('google_city').value = city.long_name;
        }

        // Update additional fields
        document.getElementById('package_selected').value = "package_value"; // Update as needed
        document.getElementById('web_source').value = "web_source_value";   // Update as needed

        // Update location ID
        if (place.place_id) {
            document.getElementById('location_id').value = place.place_id;
        }
    });

    console.log('Autocomplete initialized');
}

  // Function to compress and preview image before uploading
  async function handleImageUpload(inputId) {
    const fileInput = document.getElementById(inputId);

    fileInput.addEventListener("change", async (event) => {
      const file = event.target.files[0];
      if (file) {
        try {
          // Compress the image
          const compressedBlob = await imageCompression(file, {
            maxSizeMB: 1, // Max size 1MB
            maxWidthOrHeight: 1920, // Resize to max width/height 1920px
            useWebWorker: true,
          });

          // Convert the Blob back to a File object
          const compressedFile = new File([compressedBlob], file.name, {
            type: file.type,
          });

          // Preview the compressed image
          const reader = new FileReader();
          reader.onload = (e) => {
            // Update the preview image element
            const previewImage = document.getElementById("image-preview");
            previewImage.src = e.target.result; // Set preview image source
            previewImage.classList.remove("hidden"); // Make the preview visible
          };
          reader.readAsDataURL(compressedFile); // Use the compressed file

          // Update the file input with the compressed file
          const dataTransfer = new DataTransfer();
          dataTransfer.items.add(compressedFile);
          fileInput.files = dataTransfer.files;
        } catch (error) {
          console.error("Image compression failed:", error);
        }
      }
    });
  }


// Ensure the script runs after the Google Maps API is loaded
document.addEventListener('DOMContentLoaded', function() {
    
     // Initialize the function for your file input
    handleImageUpload("image-upload");
    // Check if the Google Maps API and Places library are available
    if (typeof google !== 'undefined' && google.maps && google.maps.places) {
        initializeAutocomplete(); // Initialize the autocomplete functionality
    } else {
        console.error('Google Maps API or Places library is not available.'); // Debugging: Error if API is not loaded
    }
    
});

// // Function to initialize the map
// function initMap() {
//     var map = new google.maps.Map(document.getElementById('map'), {
//         center: { lat: -34.397, lng: 150.644 }, // Default location
//         zoom: 8
//     });
// }

// // Initialize the map after the API script is loaded
// document.addEventListener('DOMContentLoaded', function() {
//     if (typeof google !== 'undefined') {
//         initMap();
//     } else {
//         console.error('Google Maps API is not loaded.');
//     }
// });



