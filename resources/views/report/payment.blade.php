<style>
    .form-inline {
        display: block;
    }
    .Monthly { color: #2742e7; }
    .Daily { color: #ff0000; }
    .table td {
        vertical-align: middle;
    }
</style>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="font-weight-bold">
                    <span class="text-danger">Payment </span> Status
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
                            <th class="nowrap">Bed Code</th>
                            <th class="nowrap">Occupant</th>
                            <th class="nowrap">Term of Stay</th>
                            <th class="nowrap">Status</th>
                            <th class="nowrap">Last Pay</th>
                            <th class="nowrap">Amount Due</th>
                            <th class="nowrap"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data as $row)
                        <tr>
                            <td>{{ $row->bed->code }}</td>
                            <td>
                                {{ $row->profile->lname.", ".$row->profile->fname }}
                                <br><small class="text-danger">({{ date('M d, Y',strtotime($row->check_in)) }})</small>
                            </td>
                            <td class="{{ $row->term }}">{{ $row->term }}</td>
                            <td>
                                @if($row->term == 'Daily')
                                    <alert class="badge badge-warning">Pending</alert>
                                @else
                                    <?php $status = checkRentStatus($row->id); ?>
                                    @if($status == 'Settled')
                                        <alert class="badge badge-success">Settled</alert>
                                    @elseif($status == 'Pending')
                                        <alert class="badge badge-warning">Pending Payment</alert>
                                    @else
                                        <alert class="badge badge-danger">{{ $status }}</alert>
                                    @endif
                                @endif
                            </td>
                            <td>
                                <?php $lastPay = lastPay($row->id); ?>
                                @if($lastPay['date'])
                                    <span class="text-success">₱ {{ number_format($lastPay['amount'],2) }}</span><br>
                                    <small class="text-danger font-italic">({{ date('M d, Y',strtotime($lastPay['date'])) }})</small>
                                @else
                                    <span class="text-danger">₱ 0.00</span>
                                @endif
                            </td>
                            <td>
                                <?php $balance = calculateRemainingBalance($row->id); ?>
                                @if($balance>0)
                                    <span class="text-danger">₱ {{ number_format($balance,2) }}</span>
                                @else
                                    <span class="text-success">₱ ({{ number_format(($balance*-1),2) }})</span>
                                @endif

                            </td>
                            <td>
                                <div class="dropdown">
                                    <!-- Font Awesome ellipsis-v as the dropdown trigger -->
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                        Action
                                    </a>
                                    <!-- Dropdown menu -->
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item payment_menu" href="#paymentModal" data-assignment_id="{{ $row->id }}" data-toggle="modal"><i class="fa fa-dollar-sign"></i> Payment</a>
                                        <a class="dropdown-item" href="#"><i class="fa fa-bullhorn"></i> Notify</a>
                                        <a class="dropdown-item" href="#"><i class="fa fa-sign-out-alt"></i> Check Out</a>
                                    </div>
                                </div>
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
{{--                {{ $profiles->links() }}--}}
            </div>
        </div>
    </div>
</div>
@include('modal.pay')
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

        $('#payForm').submit(function(e){
            e.preventDefault();
            $('#paymentModal').modal('hide');
            $.ajax({
                url: `{{ url('report/payment') }}`,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    amount: $('#amount').val(),
                    assignment_id: assignment_id,
                    remarks: $('#remarks').val(),
                },
                success: function(response){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Payment successfully updated!',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Navigate to the desired URL after the alert is closed
                            $('#paymentModal').modal('hide');
                            navigate("{{ url('report/payment') }}");
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

    });
</script>
