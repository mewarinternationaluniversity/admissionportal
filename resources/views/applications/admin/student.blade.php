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
                        {{-- <a href="{{ route('applications.admin.changestatus', [$application->id, 'processing']) }}" class="btn btn-primary waves-effect waves-light">Start Processing</a> --}}

                        @if ($application->payment)
                            <a href="{{ route('applications.admin.changestatus', [$application->id, 'approve']) }}" class="btn btn-success waves-effect waves-light">Approve</a>                            
                        @else
                            <a onclick="return confirm('Are you sure you want to approve this without payment?')" href="{{ route('applications.admin.changestatus', [$application->id, 'approve']) }}" class="btn btn-success waves-effect waves-light">Approve</a>                            
                        @endif                        
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>ID Proof</td>
                                            <td>
                                                @if($application->student->idproof)
                                                    @php
                                                        $ext = pathinfo(url($application->student->idproof), PATHINFO_EXTENSION);
                                                        if ($ext == 'pdf') {
                                                            $type = 'pdf';
                                                        }else {
                                                            $type = 'image';
                                                        }
                                                    @endphp
                                                    @if ($type == 'pdf')
                                                        <a href="{{ url($application->student->idproof) }}" target="_blank" class="btn btn-sm btn-success">Download PDF</a>
                                                    @else
                                                        <a href="{{ url($application->student->idproof) }}" target="_blank">
                                                            <img src="{{ $application->student->idproof }}" alt="image" class="img-fluid img-thumbnail" width="100">
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>HND Transcript</td>
                                            <td>
                                                @if($application->student->ndtranscript)
                                                    @php
                                                        $ext = pathinfo(url($application->student->ndtranscript), PATHINFO_EXTENSION);
                                                        if ($ext == 'pdf') {
                                                            $type = 'pdf';
                                                        }else {
                                                            $type = 'image';
                                                        }
                                                    @endphp
                                                    @if ($type == 'pdf')
                                                        <a href="{{ url($application->student->ndtranscript) }}" target="_blank" class="btn btn-sm btn-success">Download PDF</a>
                                                    @else
                                                        <a href="{{ url($application->student->ndtranscript) }}" target="_blank">
                                                            <img src="{{ $application->student->ndtranscript }}" alt="image" class="img-fluid img-thumbnail" width="100">
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>HND Graduation Certificate</td>
                                            <td>
                                                @if($application->student->ndgraduationcert)
                                                    @php
                                                        $ext = pathinfo(url($application->student->ndgraduationcert), PATHINFO_EXTENSION);
                                                        if ($ext == 'pdf') {
                                                            $type = 'pdf';
                                                        }else {
                                                            $type = 'image';
                                                        }
                                                    @endphp
                                                    @if ($type == 'pdf')
                                                        <a href="{{ url($application->student->ndgraduationcert) }}" target="_blank" class="btn btn-sm btn-success">Download PDF</a>
                                                    @else
                                                        <a href="{{ url($application->student->ndgraduationcert) }}" target="_blank">
                                                            <img src="{{ $application->student->ndgraduationcert }}" alt="image" class="img-fluid img-thumbnail" width="100">
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td>Additional Document</td>
                                            <td>
                                                @if($application->student->otheruploads)
                                                    @php
                                                        $ext = pathinfo(url($application->student->otheruploads), PATHINFO_EXTENSION);
                                                        if ($ext == 'pdf') {
                                                            $type = 'pdf';
                                                        }else {
                                                            $type = 'image';
                                                        }
                                                    @endphp
                                                    @if ($type == 'pdf')
                                                        <a href="{{ url($application->student->otheruploads) }}" target="_blank" class="btn btn-sm btn-success">Download PDF</a>
                                                    @else
                                                        <a href="{{ url($application->student->otheruploads) }}" target="_blank">
                                                            <img src="{{ $application->student->otheruploads }}" alt="image" class="img-fluid img-thumbnail" width="100">
                                                        </a>
                                                    @endif
                                                @endif
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
