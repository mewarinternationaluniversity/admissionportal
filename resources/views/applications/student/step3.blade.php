@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [    
    'main' => 'Step 3 Application',
    'one' => [
        'title' => 'Application',
        'route' => route('dashboard'),
    ],
])

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <div class="row">                   

                    <div class="col-lg-7">
                        <div>
                            <h2 class="mb-1">Institute Name: {{ $institute->title }}</h2>
                            
                            <div class="mt-3">
                                <h4 class="my-4">Institute Selected : <b>{{ $institute->title }}</b></h4>
                                <h4 class="my-4">Course Selected : <b>{{ $course->title }}</b></h4>
                                 <h4 class="my-4">Form fees : <b>NGN {{ $institute->ngnappamount }}</b></h4>
                              <!---  <h4 class="my-4">Total Program fees : <b>NGN {{ $courseinstitute->pivot->fees }}</b></h4> --->
                                <h4 class="my-4">Other disclaimer text paragraph : <b>{{ $institute->description }}</b></h4>
                            </div>

                            <div class="d-flex gap-2 flex-wrap">
                                 <a href="{{ route('applications.student.final', [$course->id, $institute->id, 'pay']) }}" onclick="return confirm('Do you want to proceed')" type="button" class="btn btn-warning waves-effect waves-light">
                                    <span class="btn-label"><i class="mdi mdi-account-cash"></i></span>SAVE APPLICATION & SUBMIT WITH FEES LATER
                                </a> 
                             {{--   <a href="{{ route('applications.student.final', [$course->id, $institute->id, 'nopay']) }}" type="button" class="btn btn-success waves-effect waves-light">
                                    <span class="btn-label"><i class="mdi mdi-account-cash"></i></span>SUBMIT APPLICATION
                                </a>--}}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        {{-- Display Log here if not placeholder --}}
                        @if ($institute->logo)
                            <div class="row justify-content-center">
                                <div class="col-xl-8 text-center">
                                    <div class="mx-auto">
                                        <img src="{{ $institute->logo }}" alt="image" class="img-fluid rounded-circle img-thumbnail">                                        
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row justify-content-center">
                                <div class="col-xl-8 text-center">
                                    <div class="">
                                        <div class="avatar-xl mx-auto">
                                            <span class="avatar-title bg-soft-primary text-primary font-24 rounded-circle">
                                                {{ substr($institute->title, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- If all sliders are present --}}
                        @if ($institute->sliderone && $institute->slidertwo && $institute->sliderthree)
                            <div class="row justify-content-center">
                                <div class="col-xl-8">
                                    <div id="institute-carousel" class="carousel slide product-detail-carousel" data-bs-ride="carousel">

                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <div>
                                                    <img src="{{ $institute->sliderone }}" alt="product-img" class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="carousel-item">
                                                <div>
                                                    <img src="{{ $institute->slidertwo }}" alt="product-img" class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="carousel-item">
                                                <div>
                                                    <img src="{{ $institute->sliderthree }}" alt="product-img" class="img-fluid">
                                                </div>
                                            </div>
                                        </div>

                                        <ol class="carousel-indicators institute-carousel-indicators mt-2">
                                            <li data-bs-target="#institute-carousel" data-bs-slide-to="0" class="active" aria-current="true">
                                                <img src="{{ $institute->sliderone }}" alt="product-img" class="img-fluid product-nav-img">
                                            </li>
                                            <li data-bs-target="#institute-carousel" data-bs-slide-to="1" class="">
                                                <img src="{{ $institute->slidertwo }}" alt="product-img" class="img-fluid product-nav-img">
                                            </li>
                                            <li data-bs-target="#institute-carousel" data-bs-slide-to="2" class="">
                                                <img src="{{ $institute->sliderthree }}" alt="product-img" class="img-fluid product-nav-img">
                                            </li>
                                        </ol>
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
