@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [    
    'main' => 'Bachelors Mapping'
])

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
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

@include('modals.selectcoursedip')

@push('multiselect')
    <!-- Plugins css -->
@endpush

@push('scripts')

<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/dataTables.bootstrap5.min.js"></script>
<script src="/js/dataTables.responsive.min.js"></script>
<script src="/js/responsive.bootstrap5.min.js"></script>
<script src="/js/dataTables.checkboxes.min.js"></script>

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
                <div class="col-sm-6">
                    <input type="text" class="form-control form-control-sm" value="`+ selectedText +`" disabled>
                    <input type="hidden" name="courses[]" value="`+ selectedVal +`">
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control form-control-sm" name="fees[`+ selectedVal +`]" required placeholder="Fees" required>
                </div>
                <div class="col-sm-2">
                    <div class="button-list float-end">
                        <a href="javascript:void(0)" id="removeCourse" data-id="`+ selectedVal +`" type="button" class="btn btn-xs btn-danger waves-effect waves-light"><i class="mdi mdi-close"></i></a>
                    </div>
                </div>
            </div>`);
        }
    })
</script>

    <script>
        $(function () {
           
            $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            });
            
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('mapping.diploma') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'coursescount', name: 'coursescount'},                    
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
         
            $('body').on('click', '#selectCourseShow', function () {
                var id = $(this).data('id');
                $("#listCourses").empty();
                $.get('/mapping/get/' + id + '/courses', function (data) {
                    $('#modelHeading').html("Course mapping for (" + data.title +  " Institute)");
                    $('#selectCourse').modal('show');

                    data.courses.forEach(course => {
                        $("#listCourses").append(`<div id="thecourseId_`+ course.id +`" class="mb-1 row">
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-sm" id="course" value="`+ course.title +`" readonly>
                                <input type="hidden" name="courses[]" value="`+ course.id +`">
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="form-control form-control-sm" name="fees[`+ course.id +`]" value="`+ course.pivot.fees +`" required placeholder="Fees">
                            </div>
                            <div class="col-sm-2">
                                <div class="button-list float-end">
                                    <a href="javascript:void(0)" id="removeCourse" data-id="`+ course.id +`" type="button" class="btn btn-xs btn-danger waves-effect waves-light"><i class="mdi mdi-close"></i></a>
                                </div>
                            </div>
                        </div>`);                        
                    });
                    $('#id').val(data.id);
                })
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