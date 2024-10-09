<?php
    $daily = \App\Models\Fee::where('particulars','Daily')->first()->amount;
    $monthly = \App\Models\Fee::where('particulars','Monthly')->first()->amount;
?>
<div class="modal fade" id="feesModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Rental Fees</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="feesForm">
                <div class="modal-body">
                    <div id="error_fees"></div>
                    <div class="form-group">
                        <label for="remarks">Daily Rental</label>
                        <input type="number" min="50" class="form-control" value="{{ $daily }}" id="daily_rental" name="daily_rental">
                    </div>
                    <div class="form-group">
                        <label for="remarks">Monthly Rental</label>
                        <input type="number" min="100" class="form-control" value="{{ $monthly }}" id="monthly_rental" name="monthly_rental">
                    </div>
                    <button type="submit" class="btn btn-block btn-flat btn-primary btn-lg">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
