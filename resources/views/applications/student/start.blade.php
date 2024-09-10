@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [    
    'main' => 'Start Application',
    'one' => [
        'title' => 'Application',
        'route' => route('dashboard'),
    ],
])

<div class="row">
    <div class="row">
        <div class="text-center text-white mb-3">
            <h2 class="text-white">NEW APPLICATION</h2>
            <p>List of courses you are eligible based on your <b>({{ Auth::user()->ndcourse->title }})</b> </p>
        </div>
        @foreach ($courses as $course)
            @php
                // Get the count of institutes that are activated based on the active sessions in the institute_sessions table
                $activeInstitutesCount = DB::table('institutes')
                    ->join('institute_sessions', 'institutes.id', '=', 'institute_sessions.institute_id')
                    ->where('institute_sessions.session_id', getCurrentSession()->id) // Replace getCurrentSession()->id with your session fetching logic if necessary
                    ->where('institutes.type', 'BACHELORS')
                    ->whereExists(function ($query) use ($course) {
                        $query->select(DB::raw(1))
                              ->from('institutes_courses')
                              ->whereColumn('institutes_courses.institute_id', 'institutes.id')
                              ->where('institutes_courses.course_id', $course->id);
                    })
                    ->count();
            @endphp

            <div class="col-xl-3 col-md-6">
                <div class="widget-simple text-center card">
                    <div class="card-body">
                        <h4 class="header-title mt-0">{{ $course->title }}</h4>
                        <h4 class="text-success mt-0">
                            <span data-plugin="counterup">{{ $activeInstitutesCount }}</span>
                        </h4>
                        <p class="text-muted mb-0">Number of Institutes</p>
                        <div class="mt-3">
                            <div class="d-grid gap-2">
                                @if ($activeInstitutesCount > 0)
                                    <a href="{{ route('applications.student.steptwo', $course->id) }}" type="button" class="btn btn-primary waves-effect waves-light">
                                        <i class="mdi mdi-plus-box me-1"></i> Apply
                                    </a>
                                @else
                                    <a href="#" type="button" disabled class="btn btn-primary waves-effect waves-light">
                                        <i class="mdi mdi-plus-box me-1"></i> Apply
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $courses->links() }} <!-- Pagination links -->
    </div>
</div>
@endsection

