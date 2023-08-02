@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [    
    'main' => 'Students',
    'one' => [
        'title' => 'Users',
        'route' => '#',
    ],
])

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <a href="javascript:void(0)" id="createNewStudent" class="btn btn-danger mb-2">
                            <i class="mdi mdi-plus-circle me-1"></i> Add student user
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">                            
                            <button type="button" class="btn btn-success mb-2 me-1"><i class="mdi mdi-cog"></i></button>
                        </div>
                    </div><!-- end col-->
                </div>

                <div class="table-responsive px-3">
                    <table class="table table-centered dt-responsive nowrap w-100 dataTable no-footer dtr-inline data-table" style="width: 1010px;">
                        <thead class="table-light">
                            <tr>
                                <th>Avatarc</th>
                                <th>Name</th>
                                <th>Matric number</th>
                                <th>Date of birth</th>
                                <th>Gender</th>
                                <th>Graduation</th>
                                <th>Program</th>
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

@include('institute.students.modals.student')

@push('datepicker')
    <link href="/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')

    <!-- Plugins js-->
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script src="/js/moment.min.js"></script>

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
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
          });          
          var table = $('.data-table').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('manager.students.list') }}",
              columns: [
                  {data: 'avatar', name: 'avatar'},
                  {data: 'name', name: 'name'},
                  {data: 'matriculation_no', name: 'matriculation_no'},
                  {data: 'dob', name: 'dob'},
                  {data: 'gender', name: 'gender'},
                  {data: 'yearofgraduation', name: 'yearofgraduation'},
                  {data: 'program', name: 'program'},
                  {data: 'action', name: 'action'}
              ]
          });
           
          $('#createNewStudent').click(function () {
              $('#savedata').val("create-post");
              $('#id').val('');
              $('#postForm').trigger("reset");
              $('#modelHeading').html("Create New Student");
              $('#ajaxModelexa').modal('show');
          });
          
          $('body').on('click', '.editAdmin', function () {
            var id = $(this).data('id');
            $.get('/students/' + id +'/edit', function (data) {
                $('#modelHeading').html("Edit User");
                $('#savedata').val("edit-user");
                $('#ajaxModelexa').modal('show');
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#phone').val(data.phone);
                $('#matriculation_no').val(data.matriculation_no);
                $('#dob').val(data.dob);
                $('#nd_institute').val(data.nd_institute);
                $('#nd_course').val(data.nd_course);
            })
         });
          
          $('#savedata').click(function (e) {
              e.preventDefault();
              $(this).html('Sending..');
              $('#saveErrorHere').hide();
          
              $.ajax({
                data: $('#postForm').serialize(),
                url: "{{ route('manager.students.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {           
                    $('#postForm').trigger("reset");
                    $('#ajaxModelexa').modal('hide');
                    table.draw();
                    $('#savedata').html('Save Changes');               
                },
                error: function (xhr, status, error) {
                    console.log('Error:', xhr.responseJSON);
                    
                    $('#saveErrorHere').html(xhr.responseJSON.message).show();
                    $('#savedata').html('Save Changes');
                }
            });
          });
          
          $('body').on('click', '.deleteAdmin', function () {
           
              var id = $(this).data("id");
              confirm("Are You sure want to delete!");
            
              $.ajax({
                  type: "DELETE",
                  url: '/students/delete/' + id,
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