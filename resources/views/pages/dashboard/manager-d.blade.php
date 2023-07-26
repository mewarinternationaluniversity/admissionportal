@extends('layouts.l')

@section('content')

@include('partials.body.breadcrumb', [    
    'main' => 'Dashboard',
    // 'one' => [
    //     'title' => '',
    //     'route' => route('home'),
    // ],
])

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('status.index')
                <div class="row mb-2">
                    <div class="col-sm-8"></div>
                    <div class="col-sm-4">
                        <div class="text-sm-end">

                            <div class="mb-2 row">
                                <label class="col-md-3 col-form-label" for="year">Year</label>
                                <div class="col-md-9">
                                    @php
                                        $selected = '';
                                        if (isset($_GET['year'])) {
                                            $selected = $_GET['year'];
                                        }
                                    @endphp
                                    <select class="form-control" name="year" id="year">
                                        <option value="">All years</option>
                                        @foreach ($years as $year)
                                            <option @selected($selected == $year) value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive px-3">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Matriculation No</th>
                                <th>Date of birth</th>
                                <th>Course</th>
                                <th>Gender</th>
                                <th>Year of graduation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <th>{{ $student->name }}</th>
                                    <td>{{ $student->matriculation_no }}</td>
                                    <td>{{ $student->dob }}</td>
                                    <td>{{ $student->ndcourse->title }}</td>
                                    <td>{{ $student->gender }}</td>
                                    <td>{{ $student->yearofgraduation }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

    <script type="text/javascript">
        $(function () {
            
            $("#year").change(function() {
                var $option = $(this).find(':selected');
                var yearid = $option.val();
                if (yearid != "") {
                    url = "?year=" + yearid;
                    window.location.href = url;
                }else{
                    url = "?";
                    window.location.href = url;
                }
            });

        });
      </script>
@endpush
