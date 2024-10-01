<div class="col-md-4">
    <div class="card">
        <form class="form-horizontal" id="formSubmit">
            <div class="card-header">
                <h3 class="font-weight-bold"><span class="text-danger">New</span></h3>
            </div>
            <div class="card-body">
                <div id="error_messages"></div>
                <div id="success_messages"></div>
                <div class="form-group">
                    <label for="fname">First Name</label>
                    <input type="text" class="form-control" name="fname" id="fname" value="">
                </div>
                <div class="form-group">
                    <label for="lname">Last Name</label>
                    <input type="text" class="form-control" name="lname" id="lname" value="">
                </div>
                <div class="form-group">
                    <label for="sex">Sex</label>
                    <select class="form-control" name="sex" id="sex">
                        <option>Female</option>
                        <option>Male</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" class="form-control" name="dob" id="dob" value="">
                </div>
                <div class="form-group">
                    <label for="contact">Contact No.</label>
                    <input type="text" class="form-control" name="contact" id="contact" value="">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" rows="4" style="resize: none;" name="address" id="address"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success float-right">
                    <i class="fa fa-check"></i> Submit
                </button>
            </div>
        </form>
    </div>
</div>
