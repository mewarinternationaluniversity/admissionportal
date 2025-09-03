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

                    <input type="hidden" name="role" id="role" value="manager">
        
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Institute </label>
                        <select class="form-control" name="institute_id" id="institute_id">
                            <option value=""></option>
                     @php use Illuminate\Support\Str; @endphp

@foreach (\App\Models\Institute::get() as $institute)
    @php
        $type = Str::upper($institute->type);
        $displayType = $type === 'BACHELORS' ? 'HND Institute' : ($type === 'DIPLOMA' ? 'ND Institute' : $type);
    @endphp
    <option value="{{ $institute->id }}">{{ $institute->title }} ({{ $displayType }})</option>
@endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" value="" required>
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary" id="savedata" type="submit">Add Manager</button>
                    </div>        
                </form>        
            </div>
        </div>       

    </div>
</div>
