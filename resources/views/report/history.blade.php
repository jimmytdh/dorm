<style>
    .form-inline {
        display: block;
    }
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
        let assignment_id = 0;

        $('.payment_menu').click(function(){
            assignment_id = $(this).data('assignment_id');
        })
        function resetAlert(){
            $('#error_messages').empty();
            $('#success_messages').empty();
        }



        $('.page-link').click(function (e) {
            e.preventDefault();
            var route = $(this).attr('href');
            if (route)
                navigate(route);
        })

    });
</script>
