<div class="modal  fade" id="ajaxModelexa" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div style="display: none;" class="alert alert-danger" id="saveErrorHere"></div>
        
                <form class="px-3" id="postForm" name="postForm" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">

                    <input type="hidden" name="type" id="type" value="BACHELORS">

                    <div class="row mb-3">
                        <div class="col-12 col-sm-6">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="" required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" value="" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-4">
                            <label for="logo" class="form-label">Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo">
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="banner" class="form-label">Banner</label>
                            <input type="file" class="form-control" id="banner" name="banner" value="">
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="letterhead" class="form-label">Letterhead</label>
                            <input type="file" class="form-control" id="letterhead" name="letterhead" value="">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-4">
                            <label for="sliderone" class="form-label">Slider 1</label>
                            <input type="file" class="form-control" id="sliderone" name="sliderone">
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="slidertwo" class="form-label">Slider 2</label>
                            <input type="file" class="form-control" id="slidertwo" name="slidertwo">
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="sliderthree" class="form-label">Slider 3</label>
                            <input type="file" class="form-control" id="sliderthree" name="sliderthree">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="5"></textarea>
                    </div>
        
                    <div class="mb-3">
                        <button class="btn btn-primary" id="savedata" type="submit">Add Bachelors Institute</button>
                    </div>

                </form>
            </div>
        </div>       

    </div>
</div>