<div class="modal fade" id="ajaxModelexa" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div style="display: none;" class="alert alert-danger" id="saveErrorHere"></div>
        
                <form class="px-3" id="postForm" name="postForm">
                    <input type="hidden" name="id" id="id">

                    <input type="hidden" name="role" id="role" value="admin">
                    <div class="my-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Amount" value="" required>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary" id="savedata" type="submit">Pay Fees</button>
                    </div>        
                </form>        
            </div>
        </div>       

    </div>
</div>