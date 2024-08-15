@extends('layouts.l')
@section('content')

    @include('partials.body.breadcrumb', [
        'main' => 'Student Profile'
    ])

<div class="row">
        <div class="col-lg-4 col-xl-4">
            <div class="card text-center">
                <div class="card-body">
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                    @else
                        <img src="/img/avatar.png" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                    @endif
                    <h4 class="mt-3 mb-0">{{ $user->name }}</h4>

                    <p class="text-muted">Student</p>

                    <div class="text-start mt-3">
                        <div class="table-responsive">
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
                                        <th scope="row">ND Matriculation Number :</th>
                                        <td class="text-muted">{{ $user->matriculation_no ?? 'N/A' }}</td>
                                    </tr>
        
                                    <tr>
                                        <th scope="row">Date of birth:</th>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="edit-profile">
                            @include('users.profile.student.edit')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
