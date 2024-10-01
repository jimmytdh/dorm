<style>
    .Available { color: #22c722; }
    .Damage { color: #f74c4cfa; }
    .Unavailable { color: #d3ae56; }
</style>
<div class="col-md-8">
    <div class="card">
        <div class="card-header">
            <h3 class="font-weight-bold">
                <span class="text-danger">List of</span> Bed
                <form class="form-inline float-right" id="searchForm">
                    @csrf
                    <div class="form-group row">
                        <input type="text" class="form-control mr-1 mb-1" id="search" value="{{ session('searchKeyword') }}"
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
                        <th class="nowrap">Code</th>
                        <th class="nowrap">Description</th>
                        <th class="nowrap">Status</th>
                        <th class="nowrap">Remarks</th>
                        <th class="nowrap"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($beds as $bed)
                        <tr>
                            <td class="text-bold">
                                <a href="{{ url('/beds/'.$bed->id.'/edit') }}" class="handle-link {{ $bed->status }}">{{ $bed->code }}</a>
                            </td>
                            <td>{{ $bed->description }}</td>
                            <td class="{{ $bed->status }}">{{ $bed->status }}</td>
                            <td>{!! nl2br($bed->remarks) !!}</td>
                            <td class="text-center">
                                <a class="btn-delete text-danger" data-id="{{ $bed->id }}" href="#"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-warning">
                            No data found. Please try different keyword.
                        </div>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $beds->links() }}
        </div>
    </div>
</div>

<script>
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
                    url: `{{ url('beds') }}/` + dataId,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        navigate("{{ url('beds') }}");
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
