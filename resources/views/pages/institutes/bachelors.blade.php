@extends('layouts.l')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <a href="javascript:void(0)" id="createNewInstitute" class="btn btn-danger mb-2">
                            <i class="mdi mdi-plus-circle me-1"></i> Add HND Institute
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
                                <th>Seal</th>
                                                                <th>Signature</th>
                                                                <th>Letterhead</th>
                                                                                                                                <th>Form Fees (NGN)</th>
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

@include('modals.institutes.bachelors')

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
            ajax: "{{ route('institutes.bachelors') }}",
            columns: [
                {data: 'institute', name: 'institute'},
                {data: 'title', name: 'title'},
               {
    data: 'seal',
    name: 'seal',
    render: function (data, type, full, meta) {
        return "<img src='" + data + "' alt='Seal' width='50' height='50' onerror=\"this.onerror=null;this.src='/path/to/error-icon.png';this.alt='no image uploaded';\">";
    }
}
,

{
    data: 'signature',
    name: 'signature',
    render: function (data, type, full, meta) {
        return "<img src='" + data + "' alt='signature' width='50' height='50' onerror=\"this.onerror=null;this.src='/path/to/error-icon.png';this.alt='no image uploaded';\">";
    }
}
,


  {
    data: 'letterhead',
    name: 'letterhead',
    render: function (data, type, full, meta) {
        return "<img src='" + data + "' alt='Letterhead' width='50' height='50' onerror=\"this.onerror=null;this.src='/path/to/error-icon.png';this.alt='no image uploaded';\">";
    }
}
,


                {data: 'ngnappamount', name: 'ngnappamount'},



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
        $('#ngnappamount').val(data.ngnappamount);
        $('#description').val(data.description);
        $('#session').val(data.session.session_id);

        // Set the file input values for logo, letterhead, seal, and signature to empty
        $('#logo').val(''); // Clear the logo input
        $('#letterhead').val(''); // Clear the letterhead input
        $('#seal').val(''); // Clear the seal input
        $('#signature').val(''); // Clear the signature input

        // Update the image previews for logo, letterhead, seal, and signature if URLs are available in the data
        if (data.logo_url) {
            $('#logoPreview').attr('src', data.logo_url);
        } else {
            $('#logoPreview').attr('src', ''); // Clear the image preview
        }
        if (data.letterhead_url) {
            $('#letterheadPreview').attr('src', data.letterhead_url);
        } else {
            $('#letterheadPreview').attr('src', ''); // Clear the image preview
        }
        if (data.seal_url) {
            $('#sealPreview').attr('src', data.seal_url);
        } else {
            $('#sealPreview').attr('src', ''); // Clear the image preview
        }
        if (data.signature_url) {
            $('#signaturePreview').attr('src', data.signature_url);
        } else {
            $('#signaturePreview').attr('src', ''); // Clear the image preview
        }
    });
});

          
          $('#savedata').click(function (e) {
              e.preventDefault();
              e.stopImmediatePropagation();
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

