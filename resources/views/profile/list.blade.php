<style>
    .Male { color: #1b3eba; }
    .Female { color: #f74c4cfa; }
    @media (max-width: 507px) {
        .float-right {
            float: left !important;
            margin-top: 15px;
        }
        .form-inline { width: 100%; }
    }
</style>
<div class="col-md-8">
    <div class="card">
        <div class="card-header">
            <h3 class="font-weight-bold">
                <span class="text-danger">List of</span> Residents
                <form class="form-inline float-right" id="searchForm">
                    @csrf
                    <div class="form-group row">
                        <input type="text" class="form-control mr-1 mb-1" id="search" value="{{ session('searchProfile') }}"
                               name="search" placeholder="Search...">
                        <button type="submit" class="btn btn-success mr-1 mb-1">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover">
                    <thead class="bg-dark">
                    <tr>
                        <th class="nowrap">Last Name</th>
                        <th class="nowrap">First Name</th>
                        <th class="nowrap">Sex</th>
                        <th class="nowrap">Age</th>
                        <th class="nowrap">Contact</th>
                        <th class="nowrap"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($profiles as $profile)
                        <tr>
                            <td class="text-bold">
                                <a href="{{ url('/profiles/'.$profile->id.'/edit') }}" class="handle-link {{ $profile->sex }}">{{ $profile->lname }}</a>
                            </td>
                            <td>{{ $profile->fname }}</td>
                            <td>{{ $profile->sex }}</td>
                            <td>{{ calculateAge($profile->dob) }}</td>
                            <td>{{ $profile->contact }}</td>
                            <td class="text-center">
                                <a class="btn-delete text-danger" data-id="{{ $profile->id }}" href="#"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-warning">
                            No data found. Please try again.
                        </div>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $profiles->links() }}
        </div>
    </div>
</div>

<script>
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

    $('.btn-delete').on('click', function() {
        var dataId = $(this).data('id');

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
                    url: `{{ url('profiles') }}/` + dataId,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        navigate("{{ url('profiles') }}");
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
</script>
