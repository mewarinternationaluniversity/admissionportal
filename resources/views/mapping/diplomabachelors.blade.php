@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [    
    'main' => 'Bachelors/Diploma Mapping'
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
                                <th>Bachelors Courses</th>
                                <th>Number of Mapped Diploma Courses</th>
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

@include('modals.selectcourseall')

@push('multiselect')
    <!-- Plugins css -->
@endpush

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
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" value="`+ selectedText +`" disabled>
                    <input type="hidden" name="courses[]" value="`+ selectedVal +`">
                </div>
                <div class="col-sm-4">
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
                ajax: "{{ route('mapping.diploma.bachelors') }}",
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
                $.get('/mapping/courses/' + id + '/courses', function (data) {
                    $('#modelHeading').html("Bachelor/DIploma Course mapping for (" + data.title +  " Course)");
                    $('#selectCourse').modal('show');

                    data.mappings.forEach(map => {
                        $("#listCourses").append(`<div id="thecourseId_`+ map.id +`" class="mb-1 row">
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="course" value="`+ map.title +`" readonly>
                                <input type="hidden" name="courses[]" value="`+ map.id +`">
                            </div>
                            <div class="col-sm-4">
                                <div class="button-list float-end">
                                    <a href="javascript:void(0)" id="removeCourse" data-id="`+ map.id +`" type="button" class="btn btn-xs btn-danger waves-effect waves-light"><i class="mdi mdi-close"></i></a>
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
               url: "{{ route('mapping.course.courses') }}",
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