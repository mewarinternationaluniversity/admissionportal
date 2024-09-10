@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [
    'main' => 'All Payments',
    'one' => [
        'title' => 'All Payments',
        'route' => '#',
    ],
])

{{-- Add Panels for Number of Payments and Total Amount Collected --}}
<div class="row mb-2">
    @php
        $selectedSession = request('session') ?? '';
        
        // Fetch number of payments and total amount dynamically based on selected session
        $paymentsQuery = DB::table('payments')
            ->when($selectedSession, function($query, $selectedSession) {
                return $query->where('session_id', $selectedSession);
            });
        
        $numberOfPayments = $paymentsQuery->count();
        $totalAmountCollected = $paymentsQuery->sum('amount');
    @endphp

    {{-- Panel for Number of Payments --}}
    <div class="col-xl-6 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted fw-normal mt-0 text-truncate" title="Number of Payments">
                            Number of Payments
                        </h5>
                        <h3 class="my-1 py-1"><span data-plugin="counterup">{{ $numberOfPayments }}</span></h3>
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

    {{-- Panel for Total Amount Collected --}}
    <div class="col-xl-6 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted fw-normal mt-0 text-truncate" title="Total Amount Collected">
                            Total Amount Collected (NGN)
                        </h5>
                        <h3 class="my-1 py-1">NGN <span data-plugin="counterup">{{ number_format($totalAmountCollected, 2) }}</span></h3>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-soft-primary rounded">
                            <i class="ri-money-dollar-circle-line font-20 text-primary"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Session Filter and Payments Table --}}
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
                                    @endphp
                                    <select class="form-control" name="session" id="session">
                                        <option value="">All sessions</option>
                                        @foreach ($sessions as $session)
                                            <option @selected($selectedSession == $session->id) value="{{ $session->id }}">{{ $session->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive px-3">
                    <table class="table table-centered dt-responsive nowrap w-100 dataTable no-footer dtr-inline data-table" style="width: 1010px;">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Students</th>
                                <th>Application ID</th>
                                <th>Reference</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    if ($selectedSession == '') {
        $ajaxurl = route('applications.admin.payments');
    } else {
        $ajaxurl = route('applications.admin.payments') . '?session=' . $selectedSession;
    }    
@endphp

@include('modals.courses.bachelors')

@push('scripts')
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/dataTables.bootstrap5.min.js"></script>
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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ $ajaxurl }}",
                columns: [
                    {data: 'created_at',        name: 'created_at'},
                    {data: 'student.name',       name: 'student.name'},
                    {data: 'application_id',    name: 'application_id'},
                    {data: 'reference',         name: 'reference'},
                    {data: 'amount',            name: 'amount'},
                    {data: 'download',          name: 'download'}
                ]
            });
        });
      </script>
@endpush

@endsection

