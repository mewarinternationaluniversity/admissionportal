@extends('layouts.l')
@section('content')

    @push('datepicker')
        <link href="/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    @endpush

    @push('scripts')
        <script src="/js/bootstrap-datepicker.min.js"></script>
        <script src="/js/moment.min.js"></script>
    @endpush

    @include('partials.body.breadcrumb', [
        'main' => 'Profile'
    ])
    <div class="row">
        <div class="col-lg-4 col-xl-4">
            @include('users.profile.details')
        </div>
        <div class="col-lg-8 col-xl-8">
            <div class="card">
                <div class="card-body">
                    @include('status.index')
                    <ul class="nav nav-pills navtab-bg">
                        <li class="nav-item">
                            <a href="#edit-profile" data-bs-toggle="tab" aria-expanded="true" class="nav-link ms-0 active">
                                <i class="mdi mdi-face-profile me-1"></i>Edit Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#manage-password" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="mdi mdi-cog me-1"></i>Manage Password
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">                    
                        <div class="tab-pane active" id="edit-profile">
                            @role('admin')
                                @include('users.profile.admin.edit')
                            @endrole

                            @role('manager')
                                @include('users.profile.manager.edit')
                            @endrole

                            @role('student')
                                @include('users.profile.student.edit')
                            @endrole                        
                        </div>
                        <div class="tab-pane" id="manage-password">
                            @include('users.profile.change-password')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection