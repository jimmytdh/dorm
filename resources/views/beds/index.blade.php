<style>
    .form-inline {
        display: block;
    }
    @media (max-width: 575px) {
        .btn { width: 100% !important;}
    }
</style>
<div class="row justify-content-center">
    @include('beds.create')
    @include('beds.list')
</div>
@include('js.customUrl')
<script>
    $(function () {
        function resetAlert(){
            $('#error_messages').empty();
            $('#success_messages').empty();
        }

        $('#formSubmit').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: `{{ url('beds') }}`,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    code: $('#code').val(),
                    description: $('#description').val(),
                    status: $('#status').val(),
                    remarks: $('#remarks').val(),
                },
                success: function(response){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'User account successfully created!',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Navigate to the desired URL after the alert is closed
                            navigate("{{ url('beds') }}");
                        }
                    });
                },
                error: function(xhr) {
                    // Handle validation errors
                    if (xhr.status === 422) {
                        resetAlert();
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            // Displaying errors on form
                            $('#error_messages').append('<div class="alert alert-danger">'+value+'</div>');
                        });

                    } else {
                        // Handle other errors (if any)
                        console.error(xhr.responseText);
                    }
                }
            })
        });

        $('.page-link').click(function (e) {
            e.preventDefault();
            var route = $(this).attr('href');
            if (route)
                navigate(route);
        })

    });
</script>
