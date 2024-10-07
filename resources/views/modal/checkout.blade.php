<div class="modal fade" id="checkoutModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Check-Out</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="checkoutForm">
                <div class="modal-body">
                    <div id="error_messages"></div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" rows="3"
                                  name="remarks" id="remarks"
                                  placeholder="Please enter remarks (Optional)"
                                  style="resize:none;"></textarea>
                    </div>
                    <button type="submit" class="btn btn-block btn-flat btn-primary btn-lg">Checkout</button>
                </div>
            </form>
        </div>
    </div>
</div>
