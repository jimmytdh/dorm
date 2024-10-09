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
                            <input type="text" class="form-control" name="fname" id="fname" value="{{ $profile->fname }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lname" class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="lname" id="lname" value="{{ $profile->lname }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="role" id="role" disabled>
                                <option @if($profile->role=='standard') selected @endif>Standard</option>
                                <option @if($profile->role=='admin') selected @endif>Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" id="username" value="{{ $profile->username }}">
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
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('js.customUrl')
<script>
    $(function (){
        function resetAlert(){
            $('#error_messages').empty();
            $('#success_messages').empty();
        }

        $('#formSubmit').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: `{{ url('settings/account') }}`,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    fname: $('#fname').val(),
                    lname: $('#lname').val(),
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
    })
</script>
