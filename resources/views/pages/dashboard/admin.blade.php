

@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [    
    'main' => 'Dashboard',
    // 'one' => [
    //     'title' => '',
    //     'route' => route('home'),
    // ],
])

<div class="row mb-2">
    <div class="col-sm-8"></div>
    <div class="col-sm-4">
        <div class="text-sm-end">

            <div class="mb-2 row">
                <label class="col-md-3 col-form-label" for="session">Session</label>
                <div class="col-md-9">
                    @php
                        $sessions = \App\Models\Session::get();
                        $selected = '';
                        if (isset($_GET['session'])) {
                            $selected = $_GET['session'];
                        }
                    @endphp
                    <select class="form-control" name="session" id="session">
                        <option value="">All sessions</option>
                        @foreach ($sessions as $session)
                            <option @selected($selected == $session->id) value="{{ $session->id }}">{{ $session->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted fw-normal mt-0 text-truncate" title="All Applications">
                            All Applications
                        </h5>
                        <h3 class="my-1 py-1"><span data-plugin="counterup">{{ $data['all_applications'] }}</span></h3>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-soft-primary rounded">
                            <i class="ri-stack-line font-20 text-primary"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted fw-normal mt-0 text-truncate" title="Number of students">
                            Number of students
                        </h5>
                        <h3 class="my-1 py-1"><span data-plugin="counterup">{{ $data['no_students'] }}</span></h3>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-soft-primary rounded">
                            <i class="ri-slideshow-2-line font-20 text-primary"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted fw-normal mt-0 text-truncate" title="Number of institutes">
                            Number of institutes
                        </h5>
                        <h3 class="my-1 py-1"><span data-plugin="counterup">{{ $data['institutes'] }}</span></h3>                        
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-soft-primary rounded">
                            <i class="ri-hand-heart-line font-20 text-primary"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted fw-normal mt-0 text-truncate" title="Number of cleared payments">
                            Number of cleared payments
                        </h5>
                        <h3 class="my-1 py-1"><span data-plugin="counterup">{{ $data['clearedpayments'] }}</span></h3>                        
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-soft-primary rounded">
                            <i class="ri-hand-heart-line font-20 text-primary"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted fw-normal mt-0 text-truncate" title="Funds from cleared payments">
                            Funds from cleared payments
                        </h5>
                        <h3 class="my-1 py-1"> NGN <span data-plugin="counterup">{{ $data['totalpayments'] }}</span></h3>                        
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-soft-primary rounded">
                            <i class="ri-hand-heart-line font-20 text-primary"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted fw-normal mt-0 text-truncate" title="Number of pending payments">
                            Number of pending approvals
                        </h5>
                        <h3 class="my-1 py-1"><span data-plugin="counterup">{{ $data['pendingpayments'] }}</span></h3>                        
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-soft-primary rounded">
                            <i class="ri-hand-heart-line font-20 text-primary"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('status.index')
                <div class="row mb-2">
                    <div class="col-sm-8">
                        <h4 class="page-title">Institute Course Mapping</h4>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-sm-end">

                            <div class="mb-2 row">
                                <label class="col-md-3 col-form-label" for="institute">Institute</label>
                                <div class="col-md-9">
                                    @php
                                        $institutes = \App\Models\Institute::where('type', 'BACHELORS')->get();
                                        $selectedinstitute = \App\Models\Institute::first()->id ?? 0;
                                        if (isset($_GET['institute'])) {
                                            $selectedinstitute = $_GET['institute'];
                                        }
                                    @endphp
                                    <select class="form-control" name="institute" id="institute">
                                        @foreach ($institutes as $institute)
                                            <option @selected($selectedinstitute == $institute->id) value="{{ $institute->id }}">{{ $institute->title }} ({{ $institute->type }}) </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive px-3">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Vacant seats</th>
                                <th>Approved seats</th>
                                <th>Male applications</th>
                                <th>Female applications</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $theinstitute = \App\Models\Institute::with('courses')->where('id', $selectedinstitute)->first();                                
                            @endphp

                           @foreach ($theinstitute->courses as $course)
    @php
        $male = $course->applications()
            ->whereHas('student', function($q) {
                $q->where('gender', 'Male');
            })
            ->whereHas('institute', function($q) use ($theinstitute) {
                $q->where('id', $theinstitute->id);
            })
            ->count();

        $female = $course->applications()
            ->whereHas('student', function($q) {
                $q->where('gender', 'Female');
            })
            ->whereHas('institute', function($q) use ($theinstitute) {
                $q->where('id', $theinstitute->id);
            })
            ->count();

        $allApplications = $course->applications()
            ->whereHas('institute', function($q) use ($theinstitute) {
                $q->where('id', $theinstitute->id);
            })
            ->where('status', 'APPROVED')
            ->count();

        $available = $course->pivot->seats - $allApplications;
    @endphp
    <tr>
        <th>{{ $course->title }}</th>
        <td>{{ $available }}</td>
        <td>{{ $course->pivot->seats }}</td>
        <td>{{ $male }}</td>
        <td>{{ $female }}</td>
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

@push('scripts')
    <script type="text/javascript">
        $(function () {
            $("#session").change(function() {
                var $option = $(this).find(':selected');
                var sessionid = $option.val();
                if (sessionid != "") {
                    url = "?session=" + sessionid;
                    window.location.href = url;
                }else{
                    url = "?";
                    window.location.href = url;
                }
            });
            $("#institute").change(function() {
                var $option = $(this).find(':selected');
                var instituteid = $option.val();
                if (instituteid != "") {
                    url = "?institute=" + instituteid;
                    window.location.href = url;
                }else{
                    url = "?";
                    window.location.href = url;
                }
            });
        });
    </script>
@endpush
