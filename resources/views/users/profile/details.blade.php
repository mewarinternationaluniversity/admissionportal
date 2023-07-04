<div class="card text-center">
    <div class="card-body">
        @if ($user->avatar)
            <img src="{{ $user->avatar }}" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">            
        @else
            <img src="/img/avatar.png" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">            
        @endif
        <h4 class="mt-3 mb-0">{{ $user->name }}</h4>
        @role('admin')<p class="text-muted">Admin</p>@endrole
        @role('student')<p class="text-muted">Student</p>@endrole
        @role('manager')<p class="text-muted">Manager</p>@endrole

        <div class="text-start mt-3">
            <div class="table-responsive">

                @role('admin')
                    <table class="table table-borderless table-sm">
                        <tbody>
                            <tr>
                                <th scope="row">Full Name :</th>
                                <td class="text-muted">{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Mobile :</th>
                                <td class="text-muted">{{ $user->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email :</th>
                                <td class="text-muted">{{ $user->email }}</td>
                            </tr>
                        </tbody>
                    </table>
                @endrole

                @role('manager')
                    <table class="table table-borderless table-sm">
                        <tbody>
                            <tr>
                                <th scope="row">Full Name :</th>
                                <td class="text-muted">{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Mobile :</th>
                                <td class="text-muted">{{ $user->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email :</th>
                                <td class="text-muted">{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Institute :</th>
                                <td class="text-muted">{{ $user->institute->title ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                @endrole

                @role('student')
                    <table class="table table-borderless table-sm">
                        <tbody>
                            <tr>
                                <th scope="row">Full Name :</th>
                                <td class="text-muted">{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Mobile :</th>
                                <td class="text-muted">{{ $user->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email :</th>
                                <td class="text-muted">{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Matriculation Number :</th>
                                <td class="text-muted">{{ $user->matriculation_no ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th scope="row">Date of birth :</th>
                                <td class="text-muted">{{ $user->dob ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th scope="row">ND Institute :</th>
                                <td class="text-muted">{{ $user->ndinstitute->title ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th scope="row">ND Course :</th>
                                <td class="text-muted">{{ $user->ndcourse->title ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                @endrole                
            </div>
        </div>
    </div>
</div>