@extends('layouts.l')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-8"></div>
                    <div class="col-sm-4">
                        <div class="text-sm-end">

                            <div class="mb-2 row">
                                <label class="col-md-3 col-form-label" for="session">Session</label>
                                <div class="col-md-9">
                                    @php
                                        $sessions = \App\Models\Session::get();
                                        $selected = getCurrentSession()->id ?? '';
                                        if (isset($_GET['session'])) {
                                            $selected = $_GET['session'];
                                        }
                                    @endphp
                                    <select class="form-control" name="session" id="session">
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
                                <th>#ID</th>
                                <th>Institute</th>
                                <th>Number of Courses</th>
                                <th>Edit Courses</th>
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
        $ajaxurl = route('mapping.bachelors.institute');
    } else {
        $ajaxurl = route('mapping.bachelors.institute') . '?session=' . $selected;
    }
    
    $selectedsession = \App\Models\Session::where('id', $selected)->first()->name;
    $selectedSessionId = \App\Models\Session::where('id', $selected)->first()->id;
@endphp

@include('modals.selectcourse-institute')

@push('scripts')

    <script src="/js/jquery.dataTables.min.js"></script>
    <script src="/js/dataTables.bootstrap5.min.js"></script>

<script>

    $(document).on('click','#removeCourse', function(){
        var selectedVal = $(this).attr('data-id');
        $('#thecourseId_' + selectedVal).remove();
    });

    $('#searcForcourse').change(function() {
        var selectedVal = $(this).val();
        var selectedText = $("#searcForcourse :selected").text();

        if($("#thecourseId_" + selectedVal).length == 0 && selectedVal) {
            $("#listCourses").append(`<div id="thecourseId_`+ selectedVal +`" class="mb-1 row">
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" value="`+ selectedText +`" disabled>
                </div>
                <div class="col-sm-3">
                    <input type="number" readonly class="form-control form-control-sm" name="seats[`+ selectedVal +`]" placeholder="Seats" required>
                </div>
                <div class="col-sm-5">
                    <input type="number" class="form-control form-control-sm" name="fees[`+ selectedVal +`]" placeholder="Fees">
                </div>
            </div>`);
        }
    })
</script>

    <script>
        $(function () {

            var sessionJsId = "{{ $selectedSessionId }}";

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
                    {data: 'id', name: 'id' },
                    {data: 'title', name: 'title' },
                    {data: 'coursescount', name: 'coursescount', orderable: false, searchable: false },
                    {data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
         
            $('body').on('click', '#selectCourseShow', function () {
                var id = $(this).data('id');
                $("#listCourses").empty();
                $.get('/mapping/get/' + id + '/courses/'+ sessionJsId, function (data) {
                    $('#modelHeading').html("Course mapping for session ({{ $selectedsession }})");
                    $('#selectCourse').modal('show');

                    data.courses.forEach(course => {
                        $("#listCourses").append(`<div id="thecourseId_`+ course.id +`" class="mb-1 row">
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" id="course" value="`+ course.title +`" readonly>
                            </div>
                            <div class="col-sm-3">
                                <input type="number" readonly class="form-control form-control-sm" name="seats[`+ course.id +`]" value="`+ course.pivot.seats +`" placeholder="Seats">
                            </div>
                            <div class="col-sm-5">
                                <input type="number" class="form-control form-control-sm" name="fees[`+ course.id +`]" value="`+ course.pivot.fees +`" placeholder="Fees">
                            </div>
                        </div>`);                        
                    });
                    $('#id').val(data.id);
                })
            });

            $('#createNewMapping').click(function () {
                $("#listCourses").empty();
                $('#id').val('');
                $('#modelHeading').html("Course mapping for session ({{ $selectedsession }})");
                $('#selectCourse').modal('show');
            });
         
            $('#savedata').click(function (e) {
                e.preventDefault();
                $(this).html('<i class="mdi mdi-content-save me-1"></i> Sending..');
                $('#saveErrorHere').hide();
            
                $.ajax({
                data: $('#postForm').serialize(),
                url: "{{ route('mapping.attach.courses') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {           
                    $('#postForm').trigger("reset");
                    $('#selectCourse').modal('hide');
                    table.draw();
                    $('#savedata').html('<i class="mdi mdi-content-save me-1"></i> Save Mapping');               
                },
                error: function (xhr, status, error) {
                    console.log('Error:', xhr.responseJSON);
                    
                    $('#saveErrorHere').html(xhr.responseJSON.message).show();
                    $('#savedata').html('<i class="mdi mdi-content-save me-1"></i> Save Mapping');
                }
                });
            });
         
            $('body').on('click', '.deleteAdmin', function () {          
                var id = $(this).data("id");
                confirm("Are You sure want to delete!");
            
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('users.store') }}"+'/'+id,
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
