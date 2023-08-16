<div class="card text-center">
    <div class="card-body">
        @if ($application->student->avatar)
            <img src="{{ $application->student->avatar }}" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">            
        @else
            <img src="/img/avatar.png" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">            
        @endif
        <h4 class="mt-3 mb-0">{{ $application->student->name }}</h4>
        <p class="text-muted">Student</p>

        <div class="text-start mt-3">
            <div class="table-responsive">
                <table class="table table-borderless table-sm">
                    <tbody>
                        <tr>
                            <th scope="row">Full Name :</th>
                            <td class="text-muted">{{ $application->student->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Mobile :</th>
                            <td class="text-muted">{{ $application->student->phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Email :</th>
                            <td class="text-muted">{{ $application->student->email }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Matriculation Number :</th>
                            <td class="text-muted">{{ $application->student->matriculation_no ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th scope="row">Date of birth :</th>
                            <td class="text-muted">{{ $application->student->dob ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th scope="row">ND Institute :</th>
                            <td class="text-muted">{{ $application->student->ndinstitute->title ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th scope="row">ND Course :</th>
                            <td class="text-muted">{{ $application->student->ndcourse->title ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>               
            </div>
        </div>
    </div>
</div>