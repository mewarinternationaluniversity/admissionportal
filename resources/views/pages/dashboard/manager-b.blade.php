@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [    
    'main' => 'Dashboard',
    // 'one' => [
    //     'title' => '',
    //     'route' => route('home'),
    // ],
])

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('status.index')
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
                <div class="table-responsive px-3">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Admissions Confirmed</th>
                                <th>Vacant seats</th>
                                <th>Approved seats</th>
                                <th>Male applications</th>
                                <th>Female applications</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
    // Retrieve the institute ID of the logged-in user
    $institute_id = Auth::user()->institute_id; // Modify this line based on your authentication setup

    // Rest of your code
@endphp

                           @foreach ($courses as $course)
    @php
        $male = $course->applications()
            ->where('institute_id', $institute_id) // Filter by selected institute
            ->with('student')
            ->whereHas('student', function($q) {
                $q->where('gender', 'Male');
            })->count();

        $female = $course->applications()
            ->where('institute_id', $institute_id) // Filter by selected institute
            ->with('student')
            ->whereHas('student', function($q) {
                $q->where('gender', 'Female');
            })->count();

        $allpplications = $course->applications()
            ->where('institute_id', $institute_id) // Filter by selected institute
            ->where('status', 'APPROVED')->count();

        $available = $course->pivot->seats - $allpplications;
    @endphp
    <tr>
        <th>{{ $course->title }}</th>
                <th>{{ $allpplications }}</th>
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

        });
      </script>
@endpush
