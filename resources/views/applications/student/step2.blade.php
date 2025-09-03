@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [    
    'main' => 'Step 2 Application',
    'one' => [
        'title' => 'Application',
        'route' => route('dashboard'),
    ],
])

<div class="row">
    <div class="col-sm-12 col-md-4"></div>
    <div class="col-sm-12 col-md-4">
        <div class="text-center text-white mb-3">
            <h2 class="text-white">NEW APPLICATION</h2>
            <p>List of institutes you are eligible based on your course selection. </p>
            <form class="form py-2">
                <div class="form-group mb-2">
                    <input type="text" placeholder="Institute name" class="form-control" id="instituteSearch" name="institute">
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-12 col-md-4"></div>

    <div class="row" id="instituteList">
        @php
            $institutes = $institutes->unique('id');
        @endphp

        @foreach ($institutes as $institute)
            @php
                $course = App\Models\Course::where('id', $course->id)->first();
                $user = Auth::user();
                // Check if the user has already applied to this course in this institute
                $hasApplied = App\Models\Application::where('student_id', $user->id)
                                        ->where('course_id', $course->id)
                                        ->where('institute_id', $institute->id)
                                        ->exists();
            @endphp
            <div class="col-xl-3 col-md-6 institute-panel" data-institute-name="{{ strtolower($institute->title) }}">
                <div class="widget-simple text-center card">
                    <div class="card-body">
                        <div class="mb-2">
                            @if ($institute->logo)
                                <div class="avatar-lg mx-auto">
                                    <img src="{{ $institute->logo }}" class="img-fluid rounded-circle" alt="Institute Logo">
                                </div>
                            @else
                                <div class="avatar-lg mx-auto">
                                    <div class="avatar-title rounded-circle bg-soft-primary fw-medium text-primary">{{ substr($institute->title, 0, 1) }}</div>
                                </div>
                            @endif                            
                        </div>
                        <h4 class="header-title mt-0">{{ $institute->title }}</h4>
                        @php
                            // Determine the active session for this institute
                            $activeSession = null;
                            if(isset($institute->session->session->id)) {
                                $activeSession = $institute->session->session->id;
                            } else {
                                $activeSession = getCurrentSession()->id;
                            }
                            
                            // Count approved applications filtered by the active session
                            $applicationscount = App\Models\Application::where('institute_id', $institute->id)
                                                        ->where('status', 'APPROVED')
                                                        ->where('course_id', $course->id)
                                                        ->where('session_id', $activeSession)
                                                        ->count();
                        
                            $remaining = $institute->pivot->seats - $applicationscount;
                        @endphp
                        <h5 class="text-success mt-0">
                            Seats Available : <small>{{ $remaining }} /{{ $institute->pivot->seats }}</small>
                        </h5>
                        <h5 class="text-warning mt-0">
                            Form Fees : NGN {{ $institute->ngnappamount }} 
                        </h5>
                        <h5 class="text-info mt-0">
                            Course Name : {{ $course->title }}
                        </h5>
                        @if(isset($institute->session->session->name))
                            <p>Session: {{ $institute->session->session->name }}</p>
                        @else
                            <p>Session: {{ getCurrentSession()->name }}</p>
                        @endif

                        <div class="mt-3">
                     @php
    // Check if the user has applied and whether the payment is made
    $application = App\Models\Application::where('student_id', $user->id)
        ->where('course_id', $course->id)
        ->where('institute_id', $institute->id)
        ->first();

    $hasPaid = false;
    if ($application && $application->payment) {
        $hasPaid = true; // Check if the application has a confirmed payment
    }
@endphp

<div class="d-grid gap-2">
    @if($application)
        @if($hasPaid)
            <button type="button" class="btn btn-success">Already Applied and Paid</button>
        @else
            <button type="button" class="btn btn-danger" onclick="showErrorPopup()">Already Applied (Payment Pending)</button>
        @endif
    @else
        <a href="{{ route('applications.student.stepthree', [$course->id, $institute->id]) }}" type="button" class="btn btn-primary waves-effect waves-light">
            <i class="mdi mdi-plus-box me-1"></i> Apply
        </a>
    @endif
</div>

                        </div>
                    </div>
                </div>
            </div>            
        @endforeach   
    </div>
</div>

<!-- Ensure jQuery is included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function showErrorPopup() {
        alert("You have already applied for this course in this institute.");
    }

    // Dynamic search function
    $(document).ready(function() {
        $('#instituteSearch').on('keyup', function() {
            var searchTerm = $(this).val().toLowerCase();
            $('.institute-panel').each(function() {
                var instituteName = $(this).data('institute-name');
                if (instituteName.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>

@endsection


