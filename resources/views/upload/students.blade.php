@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [
    'main' => 'Legacy Students Upload'
])

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-7">
                        <div class="tab-pane active" id="product-img">
                            @include('status.index')
                            <h4 class="header-title">Add students by importing a csv files</h4>
                            <p class="sub-header">See the data placement on the right</p>

                            <form action="{{ route('applications.students.upload') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="dropzone dz-clickable fileupload">
                                    <div class="dz-message needsclick">
                                        <div class="mb-3">
                                            <i class="h1 text-muted ri-upload-cloud-2-line"></i>
                                        </div>
                                        <h3>Drop csv here or click to upload.</h3>
                                        <span class="text-muted font-13">
                                            (Click the sample csv file button bellow to fill in the data)
                                        </span>
                                        <input type="file" name="csvfile" id="csvfile" required>
                                    </div>                                    
                                </div>
                                <ul class="pager wizard mb-0 list-inline text-end mt-3">
                                    <li class="previous list-inline-item">
                                        <a type="button" class="btn btn-secondary">
                                            <i class="mdi mdi-file-excel"></i> Sample csv file
                                        </a>
                                    </li>
                                    <li class="next list-inline-item">
                                        <button type="submit" class="btn btn-success">
                                            Upload data <i class="mdi mdi-file-upload ms-1"></i>
                                        </button>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="card mt-4 mt-xl-0">
                            <div class="card-body">
                                <h4 class="header-title mb-3">Instructions for columns</h4>

                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0">
                                        <tbody>                                            
                                            <tr>
                                                <td class="fw-bold">Name <span class="text-danger">*</span></td>
                                                <td class="text-end">The Student name</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Email Address <span class="text-danger">*</span></td>
                                                <td class="text-end">Student email address</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Matric number <span class="text-danger">*</span></td>
                                                <td class="text-end">Student Matric number</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Date of birth <span class="text-danger">*</span></td>
                                                <td class="text-end">Date of birth format (<b>20/07/2020</b>)</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Institute ID <span class="text-danger">*</span></td>
                                                <td class="text-end">The diploma institute id</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Course ID <span class="text-danger">*</span></td>
                                                <td class="text-end">The diploma course id</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Phone number</td>
                                                <td class="text-end">Student Phone number</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('dropzone')
    <style>
        #csvfile {    
            margin-top: -334px;
            margin-bottom: -100px;
            font-size: 254px;
            opacity: 0;
        }
    </style>
@endpush

@push('scripts')
@endpush

@endsection