<script>
    $(function () {
        $('#feesForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: `{{ url('settings/fees') }}`,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    daily: $('#daily_rental').val(),
                    monthly: $('#monthly_rental').val(),
                },
                success: function(response){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.msg,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Navigate to the desired URL after the alert is closed
                            $('#feesModal').modal('hide');
                            navigate(window.location.href);
                        }
                    });

                },
                error: function(xhr) {
                    // Handle validation errors
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            // Displaying errors on form
                            $('#error_fees').append('<div class="alert alert-danger">'+value+'</div>');
                        });

                    } else {
                        // Handle other errors (if any)
                        console.error(xhr.responseText);
                    }
                }
            })
        });
    });

</script>
