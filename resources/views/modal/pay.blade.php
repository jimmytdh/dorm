<div class="modal fade" id="paymentModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Payment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="payForm">
                <div class="modal-body">
                    <div id="error_messages"></div>
                    <div class="form-group">
                        <label for="remarks">Amount</label>
                        <input type="number" min="100" class="form-control" value="100" id="amount" name="amount">
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" rows="3"
                                  name="remarks" id="remarks"
                                  placeholder="Please enter remarks (Optional)"
                                  style="resize:none;"></textarea>
                    </div>
                    <button type="submit" class="btn btn-block btn-flat btn-primary btn-lg">Accept</button>
                </div>
            </form>
        </div>
    </div>
</div>
