@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [
    'main' => 'Diploma Courses',
    'one' => [
        'title' => 'Courses',
        'route' => '#',
    ],
])

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive px-3">
                    <table class="table table-centered dt-responsive nowrap w-100 dataTable no-footer dtr-inline data-table" style="width: 1010px;">
                        <thead class="table-light">
                            <tr>
                                <th>Id</th>
                                <th>Type</th>
                                <th>Title</th>
                                <th>Description</th>
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
                ajax: "{{ route('courses.diploma') }}",
                columns: [
                    {data: 'id',            name: 'id'},
                    {data: 'type',          name: 'type', orderable: false, searchable: false},
                    {data: 'title',         name: 'title'},
                    {data: 'description',   name: 'description', orderable: false, searchable: false},
                ]
            });

        });
      </script>
@endpush

@endsection