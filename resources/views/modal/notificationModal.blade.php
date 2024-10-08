<style>
    .btn {
        margin-bottom: 10px;
    }
</style>
<div class="modal fade" id="notificationModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Send Notification</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <button class="btn btn-lg btn-info btn-notify" id="sms_pending">Reminder: You have a pending balance. Please make the payment at your earliest convenience.</button>

                <button class="btn btn-lg btn-warning btn-notify" id="sms_due">Reminder: Your payment is due. Please settle the amount by the due date to avoid any penalties.</button>

                <button class="btn btn-lg btn-warning btn-notify" id="sms_overdue">Notice: Your payment is overdue. Kindly settle your outstanding balance as soon as possible to avoid further penalties.</button>

                <button class="btn btn-lg btn-danger btn-notify" id="sms_late">Urgent: Your payment is both late and overdue. Please settle the total balance now to avoid additional penalties.</button>
            </div>
        </div>
    </div>
</div>
