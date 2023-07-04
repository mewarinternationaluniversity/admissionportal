<form method="POST" action="{{ route('update.profile') }}" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="id" id="id" value="{{ $user->id }}">

    <h5 class="mb-3 text-uppercase bg-light p-2">
        <i class="mdi mdi-account-circle me-1"></i> {{ __('Student Info') }}</h5>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-2">
                <label for="name" class="form-label">{{ __('Full name') }}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
    
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-2">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" readonly>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-2">
                <label for="matriculation_no" class="form-label">{{ __('Matriculation Number') }}</label>
                <input id="matriculation_no" type="text" class="form-control" name="matriculation_no" value="{{ $user->matriculation_no }}" readonly>
        
                @error('matriculation_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-2">
                <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Enter Phone Number" value="{{ old('phone', $user->phone) }}" required>
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-2">
                <label for="dob" class="form-label">{{ __('Date of birth') }}</label>
                <div class="input-group position-relative" id="datepicker1">
                    <input type="text" id="dob" name="dob" value="{{ old('dob', $user->dob) }}" class="form-control @error('dob') is-invalid @enderror" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-container="#datepicker1">
                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                    @error('dob')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-2">
                <label for="avatar" class="form-label">{{ __('Profile Picture') }}</label>
                <input type="file" class="form-control" id="avatar" name="avatar">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-2">
                <label for="nd_institute" class="form-label">{{ __('ND Institute') }}</label>
                <select class="form-control @error('nd_institute') is-invalid @enderror" name="nd_institute" id="nd_institute">
                    <option value="">Select Institute</option>
                    @foreach (\App\Models\Institute::get() as $institute)
                        <option value="{{ $institute->id }}" @selected(old('nd_institute', $user->nd_institute) == $institute->id)>{{ $institute->title }}</option>
                    @endforeach
                </select>

                @error('nd_institute')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-2">
                <label for="nd_course" class="form-label">{{ __('ND Course') }}</label>
                <select class="form-control @error('nd_course') is-invalid @enderror" name="nd_course" id="nd_course">
                    <option value="">Select Course</option>
                    @foreach (\App\Models\Course::get() as $course)
                        <option value="{{ $course->id }}" @selected(old('nd_course', $user->nd_course) == $course->id)>{{ $course->title }}</option>
                    @endforeach
                </select>
                @error('nd_course')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <h5 class="mb-3 text-uppercase bg-light p-2">
        <i class="mdi mdi-file me-1"></i> Uploads
    </h5>

    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Document Title</th>
                    <th>Preview Thumbnail</th>
                    <th>Replace</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>ID Proof</td>
                    <td>
                        @if($user->idproof)
                            @php
                                $ext = pathinfo(url($user->idproof), PATHINFO_EXTENSION);
                                if ($ext == 'pdf') {
                                    $type = 'pdf';
                                }else {
                                    $type = 'image';
                                }
                            @endphp
                            @if ($type == 'pdf')
                                <a href="{{ url($user->idproof) }}" target="_blank" class="btn btn-sm btn-success">Download PDF</a>
                            @else
                                <a href="{{ url($user->idproof) }}" target="_blank">
                                    <img src="{{ $user->idproof }}" alt="image" class="img-fluid img-thumbnail" width="100">
                                </a>
                            @endif
                        @endif
                    </td>
                    <td>
                        <input type="file" class="form-control" name="idproof" id="idproof">
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>ND Transcript</td>
                    <td>
                        @if($user->ndtranscript)
                            @php
                                $ext = pathinfo(url($user->ndtranscript), PATHINFO_EXTENSION);
                                if ($ext == 'pdf') {
                                    $type = 'pdf';
                                }else {
                                    $type = 'image';
                                }
                            @endphp
                            @if ($type == 'pdf')
                                <a href="{{ url($user->ndtranscript) }}" target="_blank" class="btn btn-sm btn-success">Download PDF</a>
                            @else
                                <a href="{{ url($user->ndtranscript) }}" target="_blank">
                                    <img src="{{ $user->ndtranscript }}" alt="image" class="img-fluid img-thumbnail" width="100">
                                </a>
                            @endif
                        @endif
                    </td>
                    <td>
                        <input type="file" class="form-control" name="ndtranscript" id="ndtranscript">                        
                    </td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>ND Graduation Certificate</td>
                    <td>
                        @if($user->ndgraduationcert)
                            @php
                                $ext = pathinfo(url($user->ndgraduationcert), PATHINFO_EXTENSION);
                                if ($ext == 'pdf') {
                                    $type = 'pdf';
                                }else {
                                    $type = 'image';
                                }
                            @endphp
                            @if ($type == 'pdf')
                                <a href="{{ url($user->ndgraduationcert) }}" target="_blank" class="btn btn-sm btn-success">Download PDF</a>
                            @else
                                <a href="{{ url($user->ndgraduationcert) }}" target="_blank">
                                    <img src="{{ $user->ndgraduationcert }}" alt="image" class="img-fluid img-thumbnail" width="100">
                                </a>
                            @endif
                        @endif
                    </td>
                    <td>
                        <input type="file" class="form-control" name="ndgraduationcert" id="ndgraduationcert">                        
                    </td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td>Additional Document</td>
                    <td>
                        @if($user->otheruploads)
                            @php
                                $ext = pathinfo(url($user->otheruploads), PATHINFO_EXTENSION);
                                if ($ext == 'pdf') {
                                    $type = 'pdf';
                                }else {
                                    $type = 'image';
                                }
                            @endphp
                            @if ($type == 'pdf')
                                <a href="{{ url($user->otheruploads) }}" target="_blank" class="btn btn-sm btn-success">Download PDF</a>
                            @else
                                <a href="{{ url($user->otheruploads) }}" target="_blank">
                                    <img src="{{ $user->otheruploads }}" alt="image" class="img-fluid img-thumbnail" width="100">
                                </a>
                            @endif
                        @endif
                    </td>
                    <td>
                        <input type="file" class="form-control" name="otheruploads" id="otheruploads">                        
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-success waves-effect waves-light mt-2">
            <i class="mdi mdi-content-save"></i> {{ __('Save') }}
        </button>
    </div>
</form>