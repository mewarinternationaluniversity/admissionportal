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
                  <input type="text" placeholder="institute name" class="form-control" id="institute" name="institute">
                </div>
                <button type="submit" class="btn btn-primary mb-2">Search Institute</button>
            </form>
        </div>
    </div>
    <div class="col-sm-12 col-md-4"></div>

    <div class="row">        
        @foreach ($institutes as $institute)
            <div class="col-xl-3 col-md-6">
                <div class="widget-simple text-center card">
                    <div class="card-body">
                        <div class="mb-2">
                            @if ($institute->logo)
                                <div class="avatar-lg mx-auto">
                                    <img src="{{ $institute->logo }}" class="img-fluid rounded-circle" alt="user">
                                </div>
                            @else
                                <div class="avatar-lg mx-auto">
                                    <div class="avatar-title rounded-circle bg-soft-primary fw-medium text-primary">{{ substr($institute->title, 0, 1) }}</div>
                                </div>
                            @endif                            
                        </div>
                        <h4 class="header-title mt-0">{{ $institute->title }}</h4>

                        @php
                            $seatsavailable = 0;

                            $applicationscount = App\Models\Application::where('institute_id', $institute->id)
                                                        ->where('status', 'APPROVED')
                                                        ->where('course_id', $course->id)->count();

                            $remaining = $institute->pivot->seats - $applicationscount;

                        @endphp

                        <h5 class="text-success mt-0">
                            Seats Available : <small>{{ $remaining }} /{{ $institute->pivot->seats }}</small>
                        </h5>
                        <h5 class="text-warning mt-0">
                            School Fees : USD {{ $institute->pivot->fees }}
                        </h5>
                        <div class="mt-3">
                            <div class="d-grid gap-2 mb-2">
                                <a target="_blank" href="{{ route('institute.public.profile', $institute->id) }}" type="button" class="btn btn-warning waves-effect waves-light">
                                    <i class="mdi mdi-database-alert me-1"></i> Institute Profile Page
                                </a>
                            </div>
                            <div class="d-grid gap-2">
                                @if ($remaining > 0)
                                    <a href="{{ route('applications.student.stepthree', [$course->id, $institute->id]) }}" type="button" class="btn btn-primary waves-effect waves-light">
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
        {{ $institutes->links() }}       
    </div>
</div>
@endsection
