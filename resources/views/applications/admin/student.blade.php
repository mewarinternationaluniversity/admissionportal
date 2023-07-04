@extends('layouts.l')
@section('content')

    @include('partials.body.breadcrumb', [
        'main' => 'Student Application',
        'one' => [
            'title' => 'All Applications',
            'route' => route('applications.admin'),
        ],
    ])

    <div class="row">
        <div class="col-lg-4 col-xl-4">        
            @include('applications.admin.student.details')
        </div>
        <div class="col-lg-8 col-xl-8">
            <div class="card">
                <div class="card-body">
                    @include('status.index')
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('applications.admin.changestatus', [$application->id, 'processing']) }}" class="btn btn-primary waves-effect waves-light">Start Processing</a>
                        <a href="{{ route('applications.admin.changestatus', [$application->id, 'approve']) }}" class="btn btn-success waves-effect waves-light">Approve</a>
                        <a href="{{ route('applications.admin.changestatus', [$application->id, 'reject']) }}" class="btn btn-danger waves-effect waves-light">Reject</a>
                    </div>

                    <div class="tab-content">                    
                        <div class="tab-pane active" id="edit-profile">
                            <h5 class="mb-3 text-uppercase bg-light p-2">
                                <i class="mdi mdi-file me-1"></i> Application Details
                            </h5>

                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Institute</th>
                                            <th>Course</th>
                                            <th>Submitted Date</th>
                                            <th>Paid Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $application->institute->title }}</td>
                                            <td>{{ $application->course->title }}</td>
                                            <td>{{ \Carbon\Carbon::parse($application->created_at)->format('Y-m-d H:i') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($application->created_at)->format('Y-m-d H:i') }}</td>
                                            <td>
                                                @switch($application->status)
                                                    @case(App\Enums\ApplicationStatusEnum::SUBMITTED())
                                                        <button class="btn btn-xs btn-primary waves-effect waves-light">Submitted</button>
                                                        @break
                                                    @case(App\Enums\ApplicationStatusEnum::PROCESSING())
                                                        <button class="btn btn-xs btn-secondary waves-effect waves-light">Processing</button> 
                                                        @break
                                                    @case(App\Enums\ApplicationStatusEnum::APPROVED())
                                                        <button class="btn btn-xs btn-success waves-effect waves-light">Approved</button> 
                                                        @break
                                                    @case(App\Enums\ApplicationStatusEnum::ACCEPTED())
                                                        <button class="btn btn-xs btn-success waves-effect waves-light">Accepted</button> 
                                                        @break
                                                    @case(App\Enums\ApplicationStatusEnum::REJECTED())
                                                        <button class="btn btn-xs btn-danger waves-effect waves-light">Rejected</button> 
                                                        @break
                                                    @default
                                                        <button class="btn btn-xs btn-primary waves-effect waves-light">Submitted</button>
                                                @endswitch
                                                
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h5 class="mb-3 text-uppercase bg-light p-2">
                                <i class="mdi mdi-file me-1"></i> Payment Details
                            </h5>

                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Reference</th>
                                            <th>Amount</th>
                                            <th>Paid Date</th>
                                        </tr>
                                    </thead>
                                    @if ($application->payment)
                                        <tbody>
                                            <tr>
                                                <td>{{ $application->payment->reference }}</td>
                                                <td>{{ $application->payment->currency }} {{ $application->payment->amount }}</td>
                                                <td>{{ $application->created_at }}</td>
                                            </tr>
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                            
                            <h5 class="mb-3 text-uppercase bg-light p-2">
                                <i class="mdi mdi-file me-1"></i> Uploads
                            </h5>
                        
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Document Title</th>
                                            <th>Preview Thumbnail</th>
                                            <th>Replace</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>ID Proof</td>
                                            <td>
                                                @if($application->student->idproof)
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary">View files</a>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="file" class="form-control" name="idproof[]" id="idproof" multiple>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>ND Transcript</td>
                                            <td>
                                                @if($application->student->ndtranscript)
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary">View files</a>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="file" class="form-control" name="ndtranscript[]" id="ndtranscript" multiple>                        
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>ND Graduation Certificate</td>
                                            <td>
                                                @if($application->student->ndgraduationcert)
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary">View files</a>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="file" class="form-control" name="ndgraduationcert[]" id="ndgraduationcert" multiple>                        
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td>Additional Document</td>
                                            <td>
                                                @if($application->student->otheruploads)
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary">View files</a>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="file" class="form-control" name="otheruploads[]" id="otheruploads" multiple>                        
                                            </td>
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
@endsection