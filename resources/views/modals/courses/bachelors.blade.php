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
                    
                    <input type="hidden" name="type" id="type" value="BACHELORS">                    
        
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="fees" class="form-label">Course Fee</label>
                        <input type="text" class="form-control" id="fees" name="fees" placeholder="Course Fee" value="" required>
                    </div>
        
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input class="form-control" id="description" name="description" required placeholder="Enter Description">
                    </div>
        
                    <div class="mb-3">
                        <button class="btn btn-primary" id="savedata" type="submit">Add bachelors course</button>
                    </div>
        
                </form>        
            </div>
        </div>       

    </div>
</div>