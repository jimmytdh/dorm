<style>
    .form-inline {
        display: block;
    }
    @media (max-width: 575px) {
        .btn { width: 100% !important;}
    }
</style>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="font-weight-bold">
                    <span class="text-danger">
                    User
                    </span> List
                </h2>
            </div>
            <div class="card-body">
                <form class="form-inline" id="searchForm">
                    @csrf
                    <div class="form-group row">
                        <input type="text" class="form-control mr-1 mb-1" id="search" value="{{ session('searchKeyword') }}"
                               name="search" placeholder="Search...">
                        <button type="submit" class="btn btn-success mr-1 mb-1">
                            <i class="fa fa-search"></i> Search
                        </button>
                        <a href="{{ url('users/create') }}" class="btn btn-primary handle-link mr-1 mb-1">
                            <i class="fa fa-plus"></i> New User
                        </a>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="bg-dark">
                        <tr>
                            <th class="nowrap">Username</th>
                            <th class="nowrap">First Name</th>
                            <th class="nowrap">Last Name</th>
                            <th class="nowrap">Date Created</th>
                            <th class="nowrap">Role</th>
                            <th class="nowrap">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->fname }}</td>
                                <td>{{ $user->lname }}</td>
                                <td>{{ date('M d, Y h:i A',strtotime($user->created_at)) }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>
                                    <a class="btn btn-xs btn-info handle-link" href="{{ url('/users/'.$user->id.'/edit') }}"><i class="fa fa-user-edit"></i></a>
                                    <a class="btn btn-xs btn-danger btn-delete" data-id="{{ $user->id }}" href="#"><i class="fa fa-user-times"></i></a>
                                </td>
                            </tr>
                        @empty
                            <div class="alert alert-warning">
                                No user found. Please try different keyword.
                            </div>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@include('js.customUrl')
<script>
    $(function () {
        $('.page-link').click(function (e) {
            e.preventDefault();
            var route = $(this).attr('href');
            if (route)
                navigate(route);
        })

        $('#searchForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: `{{ url('users/search') }}`,
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
    });
</script>
