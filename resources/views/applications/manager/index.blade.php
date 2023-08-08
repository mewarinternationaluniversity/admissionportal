@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [
    'main' => 'All Applications',
    'one' => [
        'title' => 'All applications',
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
                                <th>Submission Date</th>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Application Status</th>
                                <th>Form Fees</th>
                                <th>Admission Letter</th>
                                <th>Details</th>
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
        $ajaxurl = route('applications.manager');
    } else {
        $ajaxurl = route('applications.manager') . '?session=' . $selected;
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
                    {data: 'created_at',                name: 'created_at'},
                    {data: 'student.name',              name: 'student.name'},
                    {data: 'course.title',              name: 'course.title'},
                    {data: 'application_status',        name: 'application_status', orderable: false, searchable: false},
                    {data: 'payment_status',            name: 'payment_status', orderable: false, searchable: false},
                    {data: 'download',                  name: 'download', orderable: false, searchable: false},
                    {data: 'action',                    name: 'action', orderable: false, searchable: false}
                ]
            });
           
            $('#createNewCourse').click(function () {
                $('#savedata').val("create-post");
                $('#id').val('');
                $('#postForm').trigger("reset");
                $('#modelHeading').html("Create New Course");
                $('#ajaxModelexa').modal('show');
            });
          
            $('body').on('click', '.editPost', function () {
                var id = $(this).data('id');
                $.get("{{ route('courses.index') }}" +'/' + id +'/edit', function (data) {
                    $('#modelHeading').html("Edit Post");
                    $('#savedata').val("edit-user");
                    $('#ajaxModelexa').modal('show');
                    $('#id').val(data.id);
                    $('#title').val(data.title);
                    $('#type').val(data.type);
                    $('#description').val(data.description);
                })
            });
          
            $('#savedata').click(function (e) {
                e.preventDefault();
                $(this).html('Sending..');
                $('#saveErrorHere').hide();
            
                $.ajax({
                    data: $('#postForm').serialize(),
                    url: "{{ route('courses.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
            
                        $('#postForm').trigger("reset");
                        $('#ajaxModelexa').modal('hide');
                        table.draw();
                        $('#savedata').html('Save Changes');
                
                    },
                    error: function (xhr, status, error) {
                        $('#saveErrorHere').html(xhr.responseJSON.message).show();
                        $('#savedata').html('Save Changes');
                    }
                });
            });
          
            $('body').on('click', '.deletePost', function () {
            
                var id = $(this).data("id");
                confirm("Are You sure want to delete this Post!");
                
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('courses.store') }}"+'/'+id,
                    success: function (data) {
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });
        });
      </script>
@endpush

@endsection