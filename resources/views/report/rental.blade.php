<style>
    .form-inline {
        display: block;
    }
    .table td {
        vertical-align: middle;
    }
    .Monthly { color: #2742e7; }
    .Daily { color: #ff0000; }
</style>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="font-weight-bold">
                    <span class="text-danger">Rental </span> Logs
                    <form class="form-inline float-right" id="searchForm">
                        @csrf
                        <div class="form-group row">
                            <input type="text" class="form-control mr-1 mb-1" id="search" value="{{ session('searchRentalLogs') }}"
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
                    <div id="error_messages"></div>
                    <div id="success_messages"></div>
                    <table class="table table-sm table-striped table-hover">
                        <thead class="bg-dark">
                        <tr>
                            <th class="nowrap">Bed Code</th>
                            <th class="nowrap">Occupant</th>
                            <th class="nowrap">Term of Stay</th>
                            <th class="nowrap">Check-In</th>
                            <th class="nowrap">Check-Out</th>
                            <th class="nowrap">Total Paid</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data as $row)
                            <tr>
                                <td>{{ $row->bed->code }}</td>
                                <td>{{ $row->profile->lname }}, {{ $row->profile->fname }}</td>
                                <td>
                                    @if($row->term == 'Daily')
                                        <span class="badge badge-warning">Daily</span>
                                    @else
                                        <span class="badge badge-success">Monthly</span>
                                    @endif
                                </td>
                                <td>{{ date('M d, Y',strtotime($row->check_in)) }}</td>
                                <td>{{ date('M d, Y',strtotime($row->check_out)) }}</td>
                                <td>₱{{ number_format(totalPaid($row->id),2) }}</td>
                            </tr>
                        @empty
                            <div class="alert alert-warning">
                                No data found. Please try different keyword.
                            </div>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $data->links() }}
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

        $('#searchForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: `{{ url('report/rental/search') }}`,
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

        $('.page-link').click(function (e) {
            e.preventDefault();
            var route = $(this).attr('href');
            if (route)
                navigate(route);
        })

    });
</script>
