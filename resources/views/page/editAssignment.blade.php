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
                    <h3 class="font-weight-bold"><span class="text-danger">Update </span> Assignment</h3>
                </div>
                <div class="card-body">
                    <div id="error_messages"></div>
                    <div id="success_messages"></div>
                    <input type="hidden" name="selected_bed" id="selected_bed" value="{{ $info->bed_id }}" />
                    <div class="form-group">
                        <label for="bed_id">Select Bed</label>
                        <select class="form-control" name="bed_id" id="bed_id">
                            <option value="{{ $info->bed_id }}">{{ $info->bed->code }}</option>
                            @foreach($beds as $bed)
                                <option value="{{ $bed->id }}">{{ $bed->code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="profile_id">Select Occupant</label>
                        <select class="form-control" name="profile_id" id="profile_id">
                            <option value="{{ $info->profile_id }}">{{ $info->profile->lname.", ".$info->profile->fname }}</option>
                            @foreach($profiles as $profile)
                                <option value="{{ $profile->id }}">{{ $profile->lname.", ".$profile->fname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="term">Terms</label>
                        <select class="form-control" name="term" id="term">
                            <option @if($info->term=='Daily') selected @endif>Daily</option>
                            <option @if($info->term=='Monthly') selected @endif>Monthly</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="process_by">Process By</label>
                        <input type="text" disabled class="form-control" value="{{ auth()->user()->lname }}, {{ auth()->user()->fname }}">
                    </div>
                    <div class="form-group">
                        <label for="check_in">Check-In Date</label>
                        <input type="date" class="form-control" name="check_in" id="check_in" value="{{ $info->check_in }}">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success float-right">
                        <i class="fa fa-check"></i> Update
                    </button>
                    <a href="{{ url('/beds/assignment') }}" class="nav-link handle-link btn btn-default float-right mr-2">
                        <i class="fa fa-arrow-left"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="font-weight-bold">
                    <span class="text-danger"></span>
                    <form class="form-inline float-right" id="searchForm">
                        @csrf
                        <div class="form-group row">
                            <input type="text" class="form-control mr-1 mb-1" id="search" value="{{ session('searchRoomAssignment') }}"
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
                            <th class="nowrap">Bed Code</th>
                            <th class="nowrap">Occupant</th>
                            <th class="nowrap">Term</th>
                            <th class="nowrap">Check-In</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data as $row)
                            <tr>
                                <td>
                                    <a href="{{ url('beds/assignment/'.$row->id.'/edit') }}" class="handle-link">
                                        {{ $row->bed->code }}
                                    </a>
                                </td>
                                <td>{{ $row->profile->lname.", ".$row->profile->fname }}</td>
                                <td>
                                    @if($row->term=='Daily')
                                        <span class="text-danger">Daily</span>
                                    @else
                                        <span class="text-success">Monthly</span>
                                    @endif
                                </td>
                                <td>{{ date("M d, Y",strtotime($row->check_in)) }}</td>
                            </tr>
                        @empty
                            <div class="alert alert-warning">
                                No data found. Please try different keyword.
                            </div>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{--                {{ $data->links() }}--}}
            </div>
        </div>
    </div>
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
            var url = `{{ url('beds/assignment/'.$info->id.'/edit') }}`;
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    bed_id: $('#bed_id').val(),
                    profile_id: $('#profile_id').val(),
                    term: $('#term').val(),
                    check_in: $('#check_in').val(),
                    selected_bed: $('#selected_bed').val(),
                },
                success: function(response){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Successfully updated!',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Navigate to the desired URL after the alert is closed
                            navigate(url);
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
                url: `{{ url('beds/assignment/search') }}`,
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
