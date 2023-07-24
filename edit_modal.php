<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Bill</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="editForm">
                <div class="form-group">
                    <label for="paidAmount">Paid Amount:</label>
                    <input type="text" id="paidAmount" class="form-control">
                </div>
                <button type="button" id="saveAmountBtn" class="btn btn-primary" data-bid="<?php echo $_POST['bId']; ?>">Save</button>
            </form>
        </div>
    </div>
</div>
