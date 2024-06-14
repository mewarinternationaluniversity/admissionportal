@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [
    'main' => 'Fees Payments',
    'one' => [
        'title' => 'Fees Payments',
        'route' => '#',
    ],
])

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('status.index')
                <div class="table-responsive px-3">
                    <table class="table table-centered dt-responsive nowrap w-100 dataTable no-footer dtr-inline data-table" style="width: 1010px;">
                        <thead class="table-light">
                            <tr>
                                <th>Payment Date</th>
                                <th>Application ID</th>
                                <th>Reference</th>
                                <th>Amount</th>
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
                ajax: "{{ route('fees.admin.payments') }}",
                columns: [
                    {data: 'created_at',            name: 'created_at'},
                    {data: 'fee.application_id',    name: 'fee.application_id'},
                    {data: 'reference',             name: 'reference'},
                    {data: 'amount',                name: 'amount'},
                    {data: 'download',              name: 'download'}
                ]
            });
        });
      </script>
@endpush

@endsection