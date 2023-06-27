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
    <div class="row">
        <div class="text-center">
            <h2>NEW APPLICATION</h2>
            <p>List of institutes you are eligible based on your course selection. </p>
        </div>
        @foreach ($institutes as $institute)
            <div class="col-xl-3 col-md-6">
                <div class="widget-simple text-center card">
                    <div class="card-body">
                        <h4 class="header-title mt-0">{{ $institute->title }}</h4>
                        <h4 class="text-success mt-0">
                            <span data-plugin="counterup">{{ $institute->pivot->seats }}</span>
                        </h4>
                        <p class="text-muted mb-0">Seats Available</p>
                        <div class="mt-3">
                            <div class="d-grid gap-2">
                                <a href="#" onclick="return confirm('Are you sure you want to apply for this course')" type="button" class="btn btn-primary waves-effect waves-light">
                                    <i class="mdi mdi-plus-box me-1"></i> Apply
                                </a>
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
