$('#searchQuery').on('input', function () {
    const query = $(this).val();
    
    // Trigger AJAX request only if query is not empty
    if (query.trim() !== '') {
        console.log("Sending request with query:", query); // Debugging request data
        
        $.ajax({
            url: '/search', // Laravel route
            type: 'GET',
            data: { query: query },
            success: function (response) {
                console.log("Server response:", response); // Debugging successful response
                
                let results = '';
                if (response.data.length > 0) {
                    response.data.forEach(item => {
                        results += `
                        <div class="flex justify-center items-center">
                            <a href="/search-for-posts?query=${encodeURIComponent(item.address)}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                <i class="fa-solid fa-location-dot"></i> ${item.address}
                            </a>
                        </div>
                    `;

                                          });
                } else {
                    results = '<div class="text-gray-500">No results found.</div>';
                }
                $('#searchResults').html(results);
            },
            error: function (xhr, status, error) {
                // Debugging error details
                console.log("Error occurred:", error);
                console.log("XHR response:", xhr.responseText);
                
                $('#searchResults').html('<div class="text-red-500">An error occurred. Please try again.</div>');
            }
        });
    } else {
        $('#searchResults').html(''); // Clear results if query is empty
    }
});
