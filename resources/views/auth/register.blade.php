@extends('layouts.auth')

@section('content')

    @push('datepickercss')
        <link href="/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    @endpush

    @push('datepickerjs')
        <script src="/js/bootstrap-datepicker.min.js"></script>
        <script src="/js/moment.min.js"></script>
    @endpush

    <!-- title-->
    <h4 class="mt-0">{{ __('Register as a Student') }}</h4>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <label for="name" class="form-label">{{ __('Full name') }}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
    
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-12 col-sm-6">
                <label for="matriculation_no" class="form-label">{{ __('ND Matriculation Number') }}</label>
                <input id="matriculation_no" type="text" class="form-control @error('matriculation_no') is-invalid @enderror" name="matriculation_no" value="{{ old('matriculation_no') }}" required autocomplete="matriculation_no">

                @error('matriculation_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-2">            
            <div class="col-12 col-sm-6">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-sm-6">
                <label for="dob" class="form-label">Date of birth</label>
                <div class="input-group position-relative" id="datepicker1">
                    <input type="text" id="dob" name="dob" value="{{ old('dob') }}" class="form-control @error('dob') is-invalid @enderror" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-container="#datepicker1">
                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                    @error('dob')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <label for="nd_institute" class="form-label">ND Institute</label>
                <select class="form-control @error('nd_institute') is-invalid @enderror" name="nd_institute" id="nd_institute">
                    <option value="">Select Institute</option>
                    @foreach (\App\Models\Institute::where('type', 'DIPLOMA')->get() as $institute)
                        <option value="{{ $institute->id }}" @selected(old('nd_institute') == $institute->id)>{{ $institute->title }}</option>
                    @endforeach
                </select>

                @error('nd_institute')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-sm-6">
                <label for="nd_course" class="form-label">ND Course</label>
                <select class="form-control @error('nd_course') is-invalid @enderror" name="nd_course" id="nd_course">
                    <option value="">Select Course</option>
                    @foreach (\App\Models\Course::where('type', 'DIPLOMA')->get() as $course)
                        <option value="{{ $course->id }}" @selected(old('nd_course') == $course->id)>{{ $course->title }}</option>
                    @endforeach
                </select>
                @error('nd_course')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-control @error('gender') is-invalid @enderror" name="gender" id="gender">
                    <option value="">Select Gender</option>
                    <option @selected(old('gender') == "Male") value="Male">Male</option>
                    <option @selected(old('gender') == "Female") value="Female">Female</option>
                </select>
                @error('gender')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-12 col-sm-6">
                <label for="yearofgraduation" class="form-label">Year of graduation</label>
                <input type="text" class="form-control @error('yearofgraduation') is-invalid @enderror" id="yearofgraduation" name="yearofgraduation" placeholder="Year of graduation" required>
                @error('yearofgraduation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-2">            
            <div class="col-12 col-sm-12">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Enter Phone Number" value="{{ old('phone') }}" required>
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="d-grid text-center">
            <button class="btn btn-primary" type="submit"> {{ __('Register') }} </button>
        </div>
    </form>

    <!-- Footer-->
    <footer class="footer footer-alt">
        <p class="text-muted">
            Already have account? <a href="{{ route('login') }}" class="text-primary fw-medium ms-1">{{ __('Sign In') }} </a>
        </p>
    </footer>

    @push('scripts')
        <script type="text/javascript">
            $(function () {            
                // $('#nd_institute').change(function () {
                //     var id = $(this).val();
                //     $("#nd_course").empty();
                //     $.get('/get/courses/' + id, function (data) {
                //         $('<option/>')
                //             .val('')
                //             .text('Select Course')
                //             .appendTo('#nd_course')
                //         $.each(data, function (i, item) {
                //             $('#nd_course').append($('<option>', { 
                //                 value: i,
                //                 text : item 
                //             }));
                //         });
                //     })
                // });
            });
        </script>
    @endpush

@endsection


