@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [
    'main' => 'Fee collection',
    'one' => [
        'title' => 'Fee collection',
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
                                <th>Application</th>
                                <th>Name</th>
                                                                <th>Email</th>
<th>Phone</th>                                
<th>Institute</th>
                                <th>Payments</th>
                                <th>Due</th>
                                <th>Course</th>
                                <th>Download</th>
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
        $ajaxurl = route('fees.admin');
    } else {
        $ajaxurl = route('fees.admin') . '?session=' . $selected;
    }    
@endphp

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
                    {data: 'created_at',                name: 'created_at'},
                    {data: 'application.id',            name: 'application.id'},
                                        {data: 'student.name',              name: 'student.name'},
                    {data: 'student.email',              name: 'student.email'},
 {data: 'student.phone',              name: 'student.phone'},
                    {data: 'institute.title',           name: 'institute.title'},
                    {data: 'feepayments',               name: 'feepayments'},
                    {data: 'feeamount',               name: 'feeamount', orderable: false, searchable: false},
                    {data: 'course.title',              name: 'course.title'},
                    {data: 'download',                  name: 'download', orderable: false, searchable: false}
                ]
            });          
        });
      </script>
@endpush

@endsection
