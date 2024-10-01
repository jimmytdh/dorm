<script>
    $(document).ready(function() {
        $.ajaxSetup({ cache: false });
        // Ensure the page content is loaded via AJAX when accessing directly
        if (window.location.pathname !== "/") {
            navigate(window.location.pathname);
        }

        // Handle initial route
        //handleRoute(window.location.href);


        setTimeout(function(){
            $('#loader-wrapper').fadeOut(300);
        },500);
        // Handle click events on links
        $('body').on('click','.handle-link', function(event){
            $('.nav-link').removeClass('active');
            event.preventDefault();
            var route = $(this).attr('href');
            navigate(route);

            if ($(window).width() < 768) {
                $('body').removeClass('sidebar-open').addClass('sidebar-collapse');
            }
        });

        // Function to handle routing based on path
        function handleRoute(path) {
            if(path === `{{ url('/logout') }}`){
                window.location.href = path;
            }
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
                    }else if (xhr.status === 403) {
                        handleRoute(`{{ url('/unauthorized') }}`);
                    } else {
                        // Handle other errors (if any)
                        console.error(xhr.responseText);
                    }
                }
            })
        }

        // Function to navigate and update history
        function navigate(route) {
            // Update the URL without reloading the page
            history.pushState(null, null, route);
            handleRoute(route);
        }

        // Handle popstate event (back/forward navigation)
        $(window).on('popstate', function() {
            handleRoute(window.location.pathname);
        });
    });
</script>
