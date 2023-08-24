@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [    
    'main' => 'Diploma',
    'one' => [
        'title' => 'Institute',
        'route' => route('dashboard'),
    ],
])

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <a href="javascript:void(0)" id="createNewInstitute" class="btn btn-danger mb-2">
                            <i class="mdi mdi-plus-circle me-1"></i> Add Diploma Institute
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <button type="button" class="btn btn-success mb-2 me-1"><i class="mdi mdi-cog"></i></button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive px-3">
                    <table class="table table-centered dt-responsive nowrap w-100 dataTable no-footer dtr-inline data-table" style="width: 1010px;">
                        <thead class="table-light">
                            <tr>
                                <th>Institute</th>
                                <th>Name</th>
                                <th>Type</th>
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

@include('modals.institutes.diploma')

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
              ajax: "{{ route('institutes.diploma') }}",
              columns: [
                  {data: 'institute', name: 'institute'},
                  {data: 'title', name: 'title'},
                  {data: 'type', name: 'type'},
                  {data: 'phone', name: 'phone'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
          });
           
          $('#createNewInstitute').click(function () {
              $('#savedata').val("create-post");
              $('#id').val('');
              $('#postForm').trigger("reset");
              $('#modelHeading').html("Create New Institute");
              $('#ajaxModelexa').modal('show');
          });
          
          $('body').on('click', '.editPost', function () {
            var id = $(this).data('id');
            $.get("{{ route('institutes.index') }}" +'/' + id +'/edit', function (data) {
                $('#modelHeading').html("Edit Institute");
                $('#savedata').val("edit-user");
                $('#ajaxModelexa').modal('show');
                $('#id').val(data.id);
                $('#title').val(data.title);
                $('#type').val(data.type);
                $('#phone').val(data.phone);
                $('#description').val(data.description);
            })
         });
          
          $('#savedata').click(function (e) {
              e.preventDefault();
              $(this).html('Sending..');
              $('#saveErrorHere').hide();

              var form = $("#postForm").closest("form");
          
              $.ajax({
                data: new FormData(form[0]),
                processData: false,
                contentType: false,
                url: "{{ route('institutes.store') }}",
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
                  url: "{{ route('institutes.store') }}"+'/'+id,
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