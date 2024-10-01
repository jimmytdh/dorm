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
                    <label for="code">Code</label>
                    <input type="text" class="form-control" name="code" id="code" value="">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" name="description" id="description" value="">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option>Available</option>
                        <option>Damage</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" rows="5" style="resize: none;" name="remarks" id="remarks"></textarea>
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
