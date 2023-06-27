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
        <div class="text-center">
            <h2>NEW APPLICATION</h2>
            <p>List of courses you are eligible based on your ND Diploma </p>
        </div>
        @foreach ($courses as $course)
            <div class="col-xl-3 col-md-6">
                <div class="widget-simple text-center card">
                    <div class="card-body">
                        <h4 class="header-title mt-0">{{ $course->title }}</h4>
                        <h4 class="text-success mt-0">
                            <span data-plugin="counterup">{{ $course->institutes()->count() }}</span>
                        </h4>
                        <p class="text-muted mb-0">Number of Institutes</p>
                        <div class="mt-3">
                            <div class="d-grid gap-2">
                                @if ($course->institutes()->count() > 0)
                                    <a href="{{ route('applications.student.steptwo', $course->id) }}" onclick="return confirm('Are you sure you want to apply for this course')" type="button" class="btn btn-primary waves-effect waves-light">
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
        {{ $courses->links() }}
    </div>
</div>
@endsection
