<style>
    .form-inline {
        display: block;
    }
    @media (max-width: 575px) {
        .btn { width: 100% !important;}
    }
</style>
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <form class="form-horizontal" id="formSubmit">
                <div class="card-header">
                    <h3 class="font-weight-bold"><span class="text-danger">Update</span> {{ $bed->code }}</h3>
                </div>
                <div class="card-body">
                    <div id="error_messages"></div>
                    <div id="success_messages"></div>
                    <div class="form-group">
                        <label for="code">Code</label>
                        <input type="text" class="form-control" name="code" id="code" value="{{ $bed->code }}">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" name="description" id="description" value="{{ $bed->description }}">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" @if($bed->status =='Occupied') disabled @endif name="status" id="status">
                            @if($bed->status =='Occupied') <option>Occupied</option> @endif
                            <option @if($bed->status=='Available') selected @endif>Available</option>
                            <option @if($bed->status=='Damage') selected @endif>Damage</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" rows="5" style="resize: none;" name="remarks" id="remarks">{!! nl2br($bed->remarks) !!}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right">
                        <i class="fa fa-check"></i> Update
                    </button>
                    <a href="{{ url('/beds') }}" class="nav-link handle-link btn btn-default float-right mr-2">
                        <i class="fa fa-arrow-left"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
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
            var url = `{{ url('beds/'.$bed->id) }}`;
            $.ajax({
                url: url,
                type: 'PUT',
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
                        text: 'Bed info successfully updated!',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Navigate to the desired URL after the alert is closed
                            navigate(url+"/edit");
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

        $('#searchForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: `{{ url('beds/search') }}`,
                type: 'POST',
                data: {
                    search: $('#search').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: (response)=> {
                    navigate(window.location.href)
                }
            })
        })
    });
</script>
