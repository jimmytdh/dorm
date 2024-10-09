<style>
    .form-inline {
        display: block;
    }
    @media print {
        footer { display: none;}
        .process_by { padding-top: 60px !important; }
    }
</style>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="invoice p-3 mb-3">

            <div class="row">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-globe"></i> NONESCOST Multi - Purpose Cooperative Dormitory Management System
                        <small class="float-right">Date: {{ date('M d, Y',strtotime($data->updated_at)) }}</small>
                    </h4>
                </div>

            </div>

            <div class="row invoice-info">
                <div class="col-sm-12 invoice-col">
                    <strong>Invoice No.: {{ str_pad($data->id,4,0,STR_PAD_LEFT) }}-{{ date('Y') }}</strong><br><br>
                    <address>
                        <strong>Received from:</strong><br>
                        Name: {{ $data->bedAssignment->profile->fname }} {{ $data->bedAssignment->profile->lname }}<br>
                        Contact No.: {{ $data->bedAssignment->profile->contact }}<br>
                        Address: {{ $data->bedAssignment->profile->address }}
                    </address>
                </div>
            </div>


            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Particulars</th>
                            <th>Remarks</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $data->bedAssignment->term }} Rent</td>
                            <td>{{ ($data->remarks) ? $data->remarks: 'Payment' }}</td>
                            <td>₱{{ number_format($data->amount,2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="pt-lg-5 process_by">
                                Processed by: <strong>{{ $data->processBy->fname }} {{ $data->processBy->lname }}</strong>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <hr class="no-print">
            <div class="row no-print">
                <div class="col-12">
                    <button type="button" class="btn btn-primary btn-print float-right" style="margin-right: 5px;">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <a href="{{ url('report/payment/history') }}" class="handle-link btn btn-default" style="margin-right: 5px;">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('js.customUrl')

<script>
    $(function (){
        $('.btn-print').click(function(){
            window.print()
        })
    })
</script>
