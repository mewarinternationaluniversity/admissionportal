@extends('layouts.l')

@section('content')



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <a href="javascript:void(0)" id="createNewCourse" class="btn btn-danger mb-2">
                            <i class="mdi mdi-plus-circle me-1"></i> Add Course
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <button type="button" class="btn btn-success mb-2 me-1"><i class="mdi mdi-cog"></i></button>
                            <button type="button" class="btn btn-light mb-2 me-1">Import</button>
                            <button type="button" class="btn btn-light mb-2">Export</button>
                        </div>
                    </div><!-- end col-->
                </div>

                <div class="table-responsive px-3">
                    <table class="table table-centered dt-responsive nowrap w-100 dataTable no-footer dtr-inline data-table" style="width: 1010px;">
                        <thead class="table-light">
                            <tr>
                                <th>Id</th>

                                <th>Title</th>

                                <th>Description</th>
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

@include('modals.courses.bachelors')

@push('scripts')
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript">
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('courses.bachelors') }}",
                columns: [
                    {data: 'id',            name: 'id'},

                    {data: 'title',         name: 'title'},

                    {data: 'description',   name: 'description'},
                    {data: 'action',        name: 'action', orderable: false, searchable: false}
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
