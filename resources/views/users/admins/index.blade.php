@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [    
    'main' => 'Admins',
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
                        <a href="javascript:void(0)" id="createNewAdmin" class="btn btn-danger mb-2">
                            <i class="mdi mdi-plus-circle me-1"></i> Add admin user
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
                                <th>Avatar</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
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

@include('modals.users.admin')

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
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
          });          
          var table = $('.data-table').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('users.admins') }}",
              columns: [
                  {data: 'avatar', name: 'avatar'},
                  {data: 'name', name: 'name'},
                  {data: 'email', name: 'email'},
                  {data: 'phone', name: 'phone'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
          });
           
          $('#createNewAdmin').click(function () {
              $('#savedata').val("create-post");
              $('#id').val('');
              $('#postForm').trigger("reset");
              $('#modelHeading').html("Create New Course");
              $('#ajaxModelexa').modal('show');
          });
          
          $('body').on('click', '.editAdmin', function () {
            var id = $(this).data('id');
            $.get("{{ route('users.index') }}" +'/' + id +'/edit', function (data) {
                $('#modelHeading').html("Edit User");
                $('#savedata').val("edit-user");
                $('#ajaxModelexa').modal('show');
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#phone').val(data.phone);
            })
         });
          
          $('#savedata').click(function (e) {
              e.preventDefault();
              $(this).html('Sending..');
              $('#saveErrorHere').hide();
          
              $.ajax({
                data: $('#postForm').serialize(),
                url: "{{ route('users.store') }}",
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