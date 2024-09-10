@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [    
    'main' => 'Dashboard',
])

{{-- Top section with session filter --}}
<div class="row mb-2">
    <div class="col-sm-8"></div>
    <div class="col-sm-4">
        <div class="text-sm-end">
            {{-- New Session Filter for Top Panels --}}
            <form method="GET" action="{{ url()->current() }}">
                <div class="mb-2 row">
                    <label class="col-md-3 col-form-label" for="session_top">Session</label>
                    <div class="col-md-9">
                        @php
                            $sessions = DB::table('sessions')->orderBy('name', 'asc')->get();  // Fetching the data
                            $selectedSessionTop = request('session_top') ?? '';
                        @endphp
                        <select class="form-control" name="session_top" id="session_top">
                            <option value="">Select session</option>
                            @foreach ($sessions as $session)
                                <option @selected($selectedSessionTop == $session->id) value="{{ $session->id }}">{{ $session->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="text-sm-end">
                    <button type="submit" class="btn btn-primary">Show</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Panels for All Applications, Number of Students, etc. --}}
<div class="row mb-2">
    @php
        $sessionId = request('session_top') ?? null;

        // Fetch the actual data, not the query builder
        $allApplications = DB::table('applications')
            ->when($sessionId, function($query, $sessionId) {
                return $query->where('session_id', $sessionId);
            })
            ->count();

       

        $institutes = DB::table('institutes')
            ->when($sessionId, function($query, $sessionId) {
                return $query->whereIn('id', function($subQuery) use ($sessionId) {
                    $subQuery->select('institute_id')
                             ->from('applications')
                             ->where('session_id', $sessionId);
                });
            })
            ->count();

       

      

        $pendingApprovals = DB::table('applications')
            ->where('status', 'PROCESSING')
            ->when($sessionId, function($query, $sessionId) {
                return $query->where('session_id', $sessionId);
            })
            ->count();
    @endphp

    {{-- All Applications --}}
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted fw-normal mt-0 text-truncate" title="All Applications">
                            All Applications
                        </h5>
                        <h3 class="my-1 py-1"><span data-plugin="counterup">{{ $allApplications }}</span></h3>
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

    

    {{-- Number of Institutes --}}
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted fw-normal mt-0 text-truncate" title="Number of institutes">
                            Number of Institutes
                        </h5>
                        <h3 class="my-1 py-1"><span data-plugin="counterup">{{ $institutes }}</span></h3>                        
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
    
  

    {{-- Pending Approvals --}}
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted fw-normal mt-0 text-truncate" title="Number of pending payments">
                            Number of Pending Approvals
                        </h5>
                        <h3 class="my-1 py-1"><span data-plugin="counterup">{{ $pendingApprovals }}</span></h3>                        
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

{{-- Institute Course Mapping --}}
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
                            <form method="GET" action="{{ url()->current() }}">
                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label" for="session_mapping">Session</label>
                                    <div class="col-md-9">
                                        @php
                                            $sessions = DB::table('sessions')->orderBy('name', 'asc')->get(); // Fetching actual data
                                            $selectedSession = request('session_mapping') ?? '';
                                        @endphp
                                        <select class="form-control" name="session_mapping" id="session_mapping">
                                            <option value="">Select session</option>
                                            @foreach ($sessions as $session)
                                                <option @selected($selectedSession == $session->id) value="{{ $session->id }}">{{ $session->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label" for="institute_mapping">Institute</label>
                                    <div class="col-md-9">
                                        @php
                                            $institutes = DB::table('institutes')
                                                ->where('type', 'BACHELORS')
                                                ->orderBy('title', 'asc')
                                                ->get();  // Fetching actual data
                                            $selectedInstitute = request('institute_mapping') ?? '';
                                        @endphp
                                        <select class="form-control" name="institute_mapping" id="institute_mapping">
                                            <option value="">Select institute</option>
                                            @foreach ($institutes as $institute)
                                                <option @selected($selectedInstitute == $institute->id) value="{{ $institute->id }}">{{ $institute->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="text-sm-end">
                                    <button type="submit" class="btn btn-primary">Show</button>
                                </div>
                            </form>
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
                            @if(request()->has('session_mapping') && request()->has('institute_mapping'))
                                @php
                                    $mappedCourses = DB::table('institutes_courses as ic')
                                        ->join('courses as c', 'c.id', '=', 'ic.course_id')
                                        ->where('ic.session_id', request('session_mapping'))
                                        ->where('ic.institute_id', request('institute_mapping'))
                                        ->select('c.title', 'ic.seats', 'ic.course_id')
                                        ->orderBy('c.title', 'asc')
                                        ->get();  // Fetching actual data
                                @endphp

                                @if($mappedCourses->isNotEmpty())
                                    @foreach ($mappedCourses as $mappedCourse)
                                        @php
                                            $approvedSeats = $mappedCourse->seats;

                                            $male = DB::table('applications as a')
                                                ->join('users as u', 'u.id', '=', 'a.student_id')
                                                ->where('a.course_id', $mappedCourse->course_id)
                                                ->where('a.institute_id', request('institute_mapping'))
                                                ->where('a.session_id', request('session_mapping'))
                                                ->where('u.gender', 'Male')
                                                ->count();

                                            $female = DB::table('applications as a')
                                                ->join('users as u', 'u.id', '=', 'a.student_id')
                                                ->where('a.course_id', $mappedCourse->course_id)
                                                ->where('a.institute_id', request('institute_mapping'))
                                                ->where('a.session_id', request('session_mapping'))
                                                ->where('u.gender', 'Female')
                                                ->count();

                                            $approvedMale = DB::table('applications as a')
                                                ->join('users as u', 'u.id', '=', 'a.student_id')
                                                ->where('a.course_id', $mappedCourse->course_id)
                                                ->where('a.institute_id', request('institute_mapping'))
                                                ->where('a.session_id', request('session_mapping'))
                                                ->where('a.status', 'APPROVED')
                                                ->where('u.gender', 'Male')
                                                ->count();

                                            $approvedFemale = DB::table('applications as a')
                                                ->join('users as u', 'u.id', '=', 'a.student_id')
                                                ->where('a.course_id', $mappedCourse->course_id)
                                                ->where('a.institute_id', request('institute_mapping'))
                                                ->where('a.session_id', request('session_mapping'))
                                                ->where('a.status', 'APPROVED')
                                                ->where('u.gender', 'Female')
                                                ->count();

                                            $vacantSeats = $approvedSeats - ($approvedMale + $approvedFemale);
                                        @endphp
                                        <tr>
                                            <th>{{ $mappedCourse->title }}</th>
                                            <td>{{ $vacantSeats }}</td>
                                            <td>{{ $approvedSeats }}</td>
                                            <td>{{ $male }}</td>
                                            <td>{{ $female }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No mapped courses found for this institute and session.</td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Please select session and institute to see data.</td>
                                </tr>
                            @endif
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
        $("#session_top, #session_mapping, #institute_mapping").change(function() {
            // Just form submits on selection change is handled with the "Show" button.
        });
    });
</script>
@endpush

