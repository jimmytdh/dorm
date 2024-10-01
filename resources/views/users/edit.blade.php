<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <form class="form-horizontal" id="formSubmit">
                <div class="card-header">
                    <h2 class="font-weight-bold">
                        <span class="text-danger">Update</span> User</h2>
                </div>
                <div class="card-body">
                    <div id="error_messages"></div>
                    <div id="success_messages"></div>
                    <br>
                    <div class="form-group row">
                        <label for="fname" class="col-sm-2 col-form-label">First Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="fname" id="fname" value="{{ $user->fname }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lname" class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="lname" id="lname" value="{{ $user->lname }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="role" id="role">
                                <option @if($user->role=='standard') selected @endif>Standard</option>
                                <option @if($user->role=='admin') selected @endif>Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" id="password" value="" placeholder="<Optional>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="">
                        </div>
                    </div>
                    <div class="form-group">

                        <button type="submit" class="btn btn-success float-right">
                            <i class="fa fa-check"></i> Update
                        </button>
                        <button type="button" class="btn btn-danger float-right mr-2 btn-delete" data-id="{{ $user->id }}">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                        <a href="{{ url('/users') }}" class="nav-link handle-link btn btn-default float-right mr-2">
                            <i class="fa fa-arrow-left"></i> User List
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('js.customUrl')
<script>
    $(function (){
        function resetForm(){
            resetAlert();
            $('#fname').val('');
            $('#lname').val('');
            $('#role').val('Standard');
            $('#username').val('');
            $('#password').val('');
            $('#password_confirmation').val('');

        }
        function resetAlert(){
            $('#error_messages').empty();
            $('#success_messages').empty();
        }

        $('#formSubmit').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: `{{ url('users/'.$user->id) }}`,
                type: 'PUT',
                data: {
                    _token: "{{ csrf_token() }}",
                    fname: $('#fname').val(),
                    lname: $('#lname').val(),
                    role: $('#role').val(),
                    username: $('#username').val(),
                    password: $('#password').val(),
                    password_confirmation: $('#password_confirmation').val(),
                },
                success: function(response){
                    console.log(response)
                    resetAlert();
                    $('#success_messages').append('<div class="alert alert-success">User successfully updated!</div>');
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

        $('.btn-delete').on('click', function() {
            var userId = $(this).data('id');
            console.log(userId)

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('users') }}/` + userId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            navigate("{{ url('users') }}");
                        },
                        error: function(xhr) {
                            console.log(xhr.responseJSON.message)
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON.message,
                                'error'
                            );
                        }
                    });
                }
            });
        });
    })
</script>
