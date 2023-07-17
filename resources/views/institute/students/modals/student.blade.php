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

                    <input type="hidden" name="role" id="role" value="student">

                    <input type="hidden" name="nd_institute" id="nd_institute" value="{{ Auth::user()->id }}">

                    <div class="row mb-3">
                        <div class="col-12 col-sm-6">
                            <label for="name" class="form-label">Student name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-6">
                            <label for="matriculation_no" class="form-label">Matric number</label>
                            <input type="text" class="form-control" id="matriculation_no" name="matriculation_no" placeholder="Matric number" value="" required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="dob" class="form-label">Date of birth</label>
                            <div class="input-group position-relative" id="datepicker1">
                                <input type="text" id="dob" name="dob" class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-container="#datepicker1">
                                <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-6">
                            <label for="nd_course" class="form-label">ND Course</label>
                            <select class="form-control" name="nd_course" id="nd_course">
                                <option value="">Select Course</option>
                                @foreach (\App\Models\Course::where('type', 'DIPLOMA')->get() as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" value="" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary" id="savedata" type="submit">Add Student</button>
                    </div>
                </form>
            </div>
        </div>       

    </div>
</div>