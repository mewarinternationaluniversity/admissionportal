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

    @php
        $sessions = \App\Models\Session::get();
    @endphp

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
                        @hasanyrole('manager|admin')
                            <li class="nav-item">
                                <a href="#manage-password" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                    <i class="mdi mdi-cog me-1"></i>Manage Password
                                </a>
                            </li>
                        @endhasanyrole
                        @role('admin')
                            <li class="nav-item">
                                <a href="#session-manager" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                    <i class="mdi mdi-alarm-light me-1"></i>Session Manager
                                </a>
                            </li>
                        @endrole                        
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

                        @role('admin')
                            <div class="tab-pane" id="session-manager">
                                
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <h3>Session manager</h3>                                        
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="text-sm-end">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#addSession" class="btn btn-danger mb-2">
                                                <i class="mdi mdi-plus-circle me-1"></i> Add Session
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Session name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($sessions as $session)
                                                <tr>
                                                    <th scope="row">{{ $session->id }}</th>
                                                    <td>{{ $session->name }}</td>
                                                    <td>
                                                        @if ($session->status == 1)
                                                            <span class="badge badge-outline-success rounded-pill">Active</span>                                                        
                                                        @else
                                                            <span class="badge badge-outline-warning rounded-pill">Inactive</span>                                                        
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="button-list">
                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#editSession_{{ $session->id }}" class="btn btn-xs btn-success waves-effect waves-light"><i class="mdi mdi-lead-pencil"></i></button>
                                                            <a href="{{ route('admin.sessions.delete', $session->id) }}" onclick="return confirm('Are you sure?')" type="button" class="btn btn-xs btn-danger waves-effect waves-light"><i class="mdi mdi-close"></i></a>                                                        
                                                        </div>
                                                    </td>

                                                    <!-- Modal -->
                                                    <div class="modal fade" data-bs-backdrop="static" id="editSession_{{ $session->id }}" tabindex="-1" aria-labelledby="editSession_{{ $session->id }}Label" aria-hidden="true">

                                                        <div class="modal-dialog">
                                                            <div class="modal-content">                                                
                                                                <div class="modal-body">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="editSession_{{ $session->id }}Label">Edit Session ({{ $session->name }})</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>

                                                                    <form method="post" action="{{ route('admin.sessions.store') }}" class="px-3" id="editsessionform" name="editsessionform">
                                                                        @csrf
                                                                        <input type="hidden" name="id" id="id" value="{{ $session->id }}">
                                                            
                                                                        <div class="mb-3">
                                                                            <label for="name" class="form-label">Name</label>
                                                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Session" value="{{ $session->name }}" required>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label for="status" class="form-label">Institute </label>
                                                                            <select class="form-control" name="status" required>
                                                                                <option @selected($session->status == 1) value="1">Active</option>
                                                                                <option @selected($session->status == 0) value="0">Inactive</option>
                                                                            </select>
                                                                        </div>                                                                        
                                                                        <div class="mb-3">
                                                                            <button class="btn btn-primary" type="submit">Edit Session</button>
                                                                        </div>
                                                            
                                                                    </form>        
                                                                </div>
                                                            </div>                                                
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Add Session Modal -->
                                <div class="modal fade" data-bs-backdrop="static" id="addSession" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addSessionLabel">Add Session</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="post" action="{{ route('admin.sessions.store') }}" class="px-3" id="addsessionform" name="addsessionform">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Session name" required>
                                                    </div>                                
                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">Session Status</label>
                                                        <select name="status" class="form-control" required>
                                                            <option value="">Please select</option>
                                                            <option value="1">Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                                    </div>                                                    
                                                    <div class="mb-3">
                                                        <button class="btn btn-primary" type="submit">Add Session</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endrole                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection