<div class="card text-center">
    <div class="card-body">
        @if ($institute->logo)
            <img src="{{ $institute->logo }}" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">            
        @else
            <img src="/img/avatar.png" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">            
        @endif
        <h4 class="mt-3 mb-0">{{ $institute->title }}</h4>
        <p class="text-muted">{{ $institute->type }}</p>

        <div class="text-start mt-3">
            <div class="table-responsive">
                <table class="table table-borderless table-sm">
                    <tbody>
                        <tr>
                            <th scope="row">Institute name :</th>
                            <td class="text-muted">{{ $institute->title }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Institute phone :</th>
                            <td class="text-muted">{{ $institute->phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Officer name :</th>
                            <td class="text-muted">{{ $institute->officername ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Officer Email :</th>
                            <td class="text-muted">{{ $institute->officeremail ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
