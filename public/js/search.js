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
                        <a href="/search-for-posts?query=${encodeURIComponent(item.address)}" class="block">
                            <button class="w-full p-2 border border-gray-300 rounded-lg bg-gray-50 shadow-sm mb-4 text-gray-700 font-medium hover:bg-gray-200 transition ease-in-out duration-150">
                                ${item.address}
                            </button>
                        </a>
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
