
<script>
    // Function to navigate and update history
    function navigate(route) {
        // Update the URL without reloading the page
        history.pushState(null, null, route);
        handleRoute(route);
    }

    function handleRoute(path) {
        $('a[href="'+path+'"]').addClass('active');
        $.ajax({
            url: `${path}`,
            type: 'GET',
            success: function(response){
                $('title').text(response.title);
                $('#content').html(response.content);
            },
            error: function(xhr) {
                // Handle validation errors
                if (xhr.status === 401) {
                    window.location.href = `{{ url('/logout') }}`;
                } else {
                    // Handle other errors (if any)
                    console.error(xhr.responseText);
                }
            }
        })
    }
</script>
