<form method="POST" action="{{ route('update.profile') }}">
    @csrf

    <input type="hidden" name="id" id="id" value="{{ $user->id }}">

    <h5 class="mb-3 text-uppercase bg-light p-2">
        <i class="mdi mdi-account-circle me-1"></i> {{ __('Admin Info') }}
    </h5>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-2">
                <label for="name" class="form-label">{{ __('Full name') }}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
    
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-2">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" readonly>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">        
        <div class="col-md-6">
            <div class="mb-2">
                <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Enter Phone Number" value="{{ old('phone', $user->phone) }}" required>
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>        
        <div class="col-md-6">
            <div class="mb-2">
                <label for="avatar" class="form-label">{{ __('Profile Picture') }}</label>
                <input type="file" class="form-control" id="avatar" placeholder="Avatar">
            </div>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-success waves-effect waves-light mt-2">
            <i class="mdi mdi-content-save"></i> {{ __('Save') }}
        </button>
    </div>
</form>