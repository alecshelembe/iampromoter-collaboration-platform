// Initialize Google Maps Places Autocomplete properly
function initializeAutocomplete() {
  const input = document.getElementById('floating_address');

  if (!input) {
      console.error("Input element with id 'floating_address' not found.");
      return;
  }

  const autocomplete = new google.maps.places.Autocomplete(input, {
      types: ['geocode'],
      componentRestrictions: { country: 'ZA' }
  });

  autocomplete.addListener('place_changed', function () {
      const place = autocomplete.getPlace();

      if (!place.geometry) {
          console.error('No geometry data found for this place.');
          return;
      }

      // Populate form fields with place data
      document.getElementById('google_location').value = place.formatted_address || '';
      document.getElementById('google_latitude').value = place.geometry.location.lat();
      document.getElementById('google_longitude').value = place.geometry.location.lng();
      document.getElementById('google_location_type').value = (place.types && place.types[0]) || '';
      document.getElementById('location_id').value = place.place_id || '';

      // Extract postal code and city
      let postalCode = '';
      let city = '';

      if (place.address_components) {
          place.address_components.forEach(component => {
              if (component.types.includes('postal_code')) {
                  postalCode = component.long_name;
              }
              if (component.types.includes('locality')) {
                  city = component.long_name;
              }
          });
      }

      document.getElementById('google_postal_code').value = postalCode;
      document.getElementById('google_city').value = city;

      // Static/demo values
      document.getElementById('package_selected').value = "package_value";
      document.getElementById('web_source').value = "web_source_value";

      console.log('Place selected:', place);
  });

  console.log('Autocomplete initialized');
}

// Compress and preview image before upload
async function handleImageUpload(inputId) {
  const fileInput = document.getElementById(inputId);

  if (!fileInput) {
      console.error(`Input element with id '${inputId}' not found.`);
      return;
  }

  fileInput.addEventListener("change", async (event) => {
      const file = event.target.files[0];

      if (!file) {
          console.warn('No file selected.');
          return;
      }

      try {
          // Ensure imageCompression library is available
          if (typeof imageCompression === 'undefined') {
              console.error('imageCompression library not loaded.');
              return;
          }

          const compressedBlob = await imageCompression(file, {
              maxSizeMB: 1,
              maxWidthOrHeight: 1920,
              useWebWorker: true,
          });

          const compressedFile = new File([compressedBlob], file.name, {
              type: file.type,
          });

          const reader = new FileReader();
          reader.onload = (e) => {
              const previewImage = document.getElementById("image-preview");
              if (previewImage) {
                  previewImage.src = e.target.result;
                  previewImage.classList.remove("hidden");
              }
          };
          reader.readAsDataURL(compressedFile);

          // Inject compressed file back into file input
          const dataTransfer = new DataTransfer();
          dataTransfer.items.add(compressedFile);
          fileInput.files = dataTransfer.files;
      } catch (error) {
          console.error("Image compression failed:", error);
      }
  });
}

// Listen for DOM ready + Google Maps API ready
function initWhenReady() {
  // Check again for google maps api
  if (typeof google !== 'undefined' && google.maps && google.maps.places) {
      initializeAutocomplete();
  } else {
      // Retry if Maps API loads later
      const interval = setInterval(() => {
          if (typeof google !== 'undefined' && google.maps && google.maps.places) {
              initializeAutocomplete();
              clearInterval(interval);
          }
      }, 500);
  }
}

// DOM Ready
document.addEventListener('DOMContentLoaded', function () {
  handleImageUpload("image-upload");
  initWhenReady();
});
