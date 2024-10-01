<div class="modal fade" id="optionModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Options</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="forwardForm">
                <div class="modal-body">
                    <div id="error_messages"></div>
                    <div class="form-group">
                        <label for="division">Select Division</label>
                        <select class="form-control" name="division" id="division">
                            <option value="">...</option>
                            @foreach($divisions as $division)
                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sections">Select Section</label>
                        <select class="form-control" name="sections" id="sections">
                            <option value="">...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" rows="3"
                                  name="remarks" id="remarks"
                                  placeholder="Please enter remarks (Optional)"
                                  style="resize:none;"></textarea>
                    </div>
                    <button type="submit" class="btn btn-block btn-flat btn-primary btn-lg">Forward</button>
                    <button type="button" class="btn btn-block btn-flat btn-danger btn-lg btn-end">Cycle End</button>
                </div>
            </form>
        </div>
    </div>
</div>
