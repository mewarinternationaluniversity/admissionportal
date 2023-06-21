<form action="{{ route('update.password') }}" 
        method="post" 
        class="needs-validation" 
        role="form"
        novalidate>
    @csrf
    <h5 class="mb-3 text-uppercase bg-light p-2">
        <i class="mdi mdi-account-circle me-1"></i> Change Password
    </h5>

    <div class="row">
        <div class="col-md-12">
            <div class="mb-2">
                <label for="nameBasic" class="form-label">Current Password</label>
                <input 
                    type="password" 
                    name="old_password" 
                    class="form-control" 
                    placeholder="Current Password"
                    required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-2">
                <label for="nameBasic" class="form-label">New Password</label>
                <input 
                    type="password" 
                    name="new_password" 
                    class="form-control" 
                    placeholder="New Password"
                    required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-2">
                <label for="nameBasic" class="form-label">Confirm Password</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    class="form-control" 
                    placeholder="Confirm Password"
                    required>
            </div>
        </div>
    </div>
    <div class="text-end">
        <button type="submit" class="btn btn-success waves-effect waves-light mt-2">
            <i class="mdi mdi-content-save"></i> Update Password
        </button>
    </div>
</form>