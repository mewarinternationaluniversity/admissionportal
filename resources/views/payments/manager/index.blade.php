@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [
    'main' => 'All Payments',
    'one' => [
        'title' => 'All Payments',
        'route' => '#',
    ],
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
                    <table class="table table-centered dt-responsive nowrap w-100 dataTable no-footer dtr-inline data-table" style="width: 1010px;">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Student</th>
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
        <!-- end row -->
    </div>
</div>

@php
    if ($selected == '') {
        $ajaxurl = route('applications.manager.payments');
    } else {
        $ajaxurl = route('applications.manager.payments') . '?session=' . $selected;
    }    
@endphp

@include('modals.courses.bachelors')

@push('scripts')
    <!-- third party js -->
    <script src="/js/jquery.dataTables.min.js"></script>
    <script src="/js/dataTables.bootstrap5.min.js"></script>
    <script src="/js/dataTables.responsive.min.js"></script>
    <script src="/js/responsive.bootstrap5.min.js"></script>
    <script src="/js/dataTables.checkboxes.min.js"></script>
    <!-- third party js ends -->
    <!-- Datatables init -->
    {{-- <script src="/js/customers.init.js"></script> --}}

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
                    {data: 'studentname',       name: 'studentname', orderable: false, searchable: false},
                    {data: 'application_id',    name: 'application_id'},
                    {data: 'reference',         name: 'reference'},
                    {data: 'amount',            name: 'amount'},
                    {data: 'download',            name: 'download'}
                ]
            });
        });
      </script>
@endpush

@endsection