@extends('layouts.l')
@section('content')

    @include('partials.body.breadcrumb', [
        'main' => 'Institute profile'
    ])
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-5">
                            <div class="row justify-content-center">
                                <div class="col-xl-8">

                                    <div id="product-carousel" class="carousel slide product-detail-carousel" data-bs-ride="carousel">

                                        <div class="carousel-inner">
                                            <div class="carousel-item">
                                                <div>
                                                    <img src="{{ $institute->sliderone }}" alt="slider one" class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="carousel-item active">
                                                <div>
                                                    <img src="{{ $institute->slidertwo }}" alt="slider two" class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="carousel-item">
                                                <div>
                                                    <img src="{{ $institute->sliderthree }}" alt="slider three" class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                        <ol class="carousel-indicators product-carousel-indicators mt-2">
                                            <li data-bs-target="#product-carousel" data-bs-slide-to="0" class="">
                                                <img src="{{ $institute->sliderone }}" alt="slider one" class="img-fluid product-nav-img">
                                            </li>
                                            <li data-bs-target="#product-carousel" data-bs-slide-to="1" class="active" aria-current="true">
                                                <img src="{{ $institute->slidertwo }}" alt="slider two" class="img-fluid product-nav-img">
                                            </li>
                                            <li data-bs-target="#product-carousel" data-bs-slide-to="2" class="">
                                                <img src="{{ $institute->sliderthree }}" alt="slider three" class="img-fluid product-nav-img">
                                            </li>
                                        </ol>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div>
                                
                                <h2 class="mb-1">{{ $institute->title }}</h2>
                                <hr>
                                <p>{{ $institute->description }}</p>
                                <div>
                                    <img src="{{ $institute->banner }}" alt="Banner" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <h5 class="mt-5 mb-3">Institute Courses</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-centered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sr. No</th>
                                    <th>HND Programs Available</th>
                                    <th>Eligible ND List</th>
                                    <th>Course Fees (NGN) </th>
                                    <th>Available seats</th>
                                    <th>Apply Now</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($institute->courses()->get() as $key => $course)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $course->title }}</td>
                                        <td>
                                            @foreach ($course->dmappings as $mapping)
                                                - {{ $mapping->title }} <br>
                                            @endforeach
                                        </td>
                                        <td>NGN {{ $course->pivot->fees }}</td>
                                        <td>{{ $course->pivot->seats }}</td>
                                        <td>
                                            <div class="d-grid gap-2">
                                                <a href="{{ route('applications.student.stepthree', [$course->id, $institute->id]) }}" type="button" class="btn btn-xs btn-primary waves-effect waves-light">
                                                    <i class="mdi mdi-plus-box me-1"></i> Apply
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
