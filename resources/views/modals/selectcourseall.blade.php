<div class="modal fade" data-bs-backdrop="static" id="selectCourse" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div style="display: none;" class="alert alert-danger mx-3" id="saveErrorHere"></div>
        
                <form class="px-3" id="postForm" name="postForm">
                    <input type="hidden" name="id" id="id">

                    <div class="mb-3">
                        <label for="name" class="form-label">Select a course</label>
                        <select id="searcForcourse" class="form-control" data-toggle="select2">
                            <option value="">Select Course</option>
                            @foreach (\App\Models\Course::where('type', 'DIPLOMA')->get() as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2" id="listCourses"></div>
                    
                    <div class="mb-2">
                        <button class="btn btn-success waves-effect waves-light float-end" id="savedata" type="submit"><i class="mdi mdi-content-save me-1"></i> Save Mapping</button>
                    </div>  
                </form>        
            </div>
        </div>       

    </div>
</div>