<style>
    .form-inline {
        display: block;
    }
    .table td {
        vertical-align: middle;
        white-space: nowrap;
    }
    .Monthly { color: #2742e7; }
    .Daily { color: #ff0000; }
    @media (max-width: 507px) {
        .float-right {
            float: left !important;
            margin-top: 15px;
        }
        .form-inline { width: 100%; }
        .form-inline button { width: 100%; }
    }
</style>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="font-weight-bold">
                    <span class="text-danger">Payment </span> History
                    <form class="form-inline float-right" id="searchForm">
                        @csrf
                        <div class="form-group row">
                            <input type="text" class="form-control mr-1 mb-1" id="search" value="{{ session('searchPayment') }}"
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
                            <th class="nowrap">Occupant</th>
                            <th class="nowrap">Term of Stay</th>
                            <th class="nowrap">Amount Paid</th>
                            <th class="nowrap">Date Received</th>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data as $row)
                        <tr>
                            <td>{{ $row->lname }}, {{ $row->fname }}</td>
                            <td class="{{ $row->term }}">{{ $row->term }}</td>
                            <td>₱{{ number_format($row->amount,2) }}</td>
                            <td>{{ date('M d, Y h:i A',strtotime($row->date_paid)) }}</td>
                            <td>
                                <div class="dropdown">
                                    <!-- Font Awesome ellipsis-v as the dropdown trigger -->
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                        Action
                                    </a>
                                    <!-- Dropdown menu -->
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item handle-link" href="{{ url('report/payment/history/'.$row->payment_id) }}"><i class="fa fa-file-invoice"></i> Invoice</a>
                                        <a class="dropdown-item" href="#"><i class="fa fa-cogs"></i> Update</a>
                                    </div>
                                </div>
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
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>
@include('js.customUrl')
<script>
    $(function () {
        let assignment_id = 0;

        $('.payment_menu').click(function(){
            assignment_id = $(this).data('assignment_id');
        })
        function resetAlert(){
            $('#error_messages').empty();
            $('#success_messages').empty();
        }

        $('#searchForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: `{{ url('report/payment/history/search') }}`,
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
