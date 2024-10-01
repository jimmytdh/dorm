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
                    <h3 class="font-weight-bold"><span class="text-danger">Update</span> {{ $profile->fname }}</h3>
                </div>
                <div class="card-body">
                    <div id="error_messages"></div>
                    <div id="success_messages"></div>
                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" class="form-control" name="fname" id="fname" value="{{ $profile->fname }}">
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" class="form-control" name="lname" id="lname" value="{{ $profile->lname }}">
                    </div>
                    <div class="form-group">
                        <label for="sex">Sex</label>
                        <select class="form-control" name="sex" id="sex">
                            <option @if($profile->sex=='Female') selected @endif>Female</option>
                            <option @if($profile->sex=='Male') selected @endif>Male</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control" name="dob" id="dob" value="{{ $profile->dob }}">
                    </div>
                    <div class="form-group">
                        <label for="contact">Contact No.</label>
                        <input type="text" class="form-control" name="contact" id="contact" value="{{ $profile->contact }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" rows="4" style="resize: none;" name="address" id="address">{{ $profile->address }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right">
                        <i class="fa fa-check"></i> Update
                    </button>
                    <a href="{{ url('/profiles') }}" class="nav-link handle-link btn btn-default float-right mr-2">
                        <i class="fa fa-arrow-left"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
    @include('profile.list')
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
            var url = `{{ url('profiles/'.$profile->id) }}`;
            $.ajax({
                url: url,
                type: 'PUT',
                data: {
                    _token: "{{ csrf_token() }}",
                    fname: $('#fname').val(),
                    lname: $('#lname').val(),
                    sex: $('#sex').val(),
                    dob: $('#dob').val(),
                    contact: $('#contact').val(),
                    address: $('#address').val(),
                },
                success: function(response){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Profile successfully updated!',
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
                url: `{{ url('profiles/search') }}`,
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
