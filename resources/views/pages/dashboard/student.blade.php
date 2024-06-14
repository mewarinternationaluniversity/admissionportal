@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [    
    'main' => 'Home'
])

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <div class="row">                   

                    <div class="col-lg-7">
                        <div>
                            <h2 class="mb-1">Name: {{ $user->name }}</h2>
                            
                            <div class="mt-3">
                                <h4 class="my-4">Email Address : <b>{{ $user->email }}</b></h4>
                                <h4 class="my-4">Phone Number : <b>{{ $user->phone }}</b></h4>
                                <h4 class="my-4">HND Institute : <b>{{ $user->ndinstitute->title }}</b></h4>
                                <h4 class="my-4">HND Course : <b>{{ $user->ndcourse->title }}</b></h4>

                                <h4 class="my-4">Applications Submitted : <b>{{ $user->applications()->count() }}</b></h4>
                                <h4 class="my-4">Applications Approved : <b>{{ $user->applications()->where('status', 'APPROVED')->count() }}</b></h4>
                                <h4 class="my-4">Applications Accepted : <b>{{ $user->applications()->where('status', 'ACCEPTED')->count() }}</b></h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        {{-- Display Log here if not placeholder --}}
                        @if ($user->avatar)
                            <div class="row justify-content-center">
                                <div class="col-xl-8 text-center">
                                    <div class="mx-auto">
                                        <img src="{{ $user->avatar }}" alt="image" class="img-fluid rounded-circle img-thumbnail">                                        
                                    </div>                                    
                                </div>
                            </div>                            
                        @else
                            <div class="row justify-content-center">
                                <div class="col-xl-8 text-center">
                                    <div class="">
                                        <div class="avatar-xl mx-auto">
                                            <span class="avatar-title bg-soft-primary text-primary font-24 rounded-circle">
                                                {{ substr($user->name, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>                            
                        @endif
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>
</div>


@endsection
