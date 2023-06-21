<h4 class="mt-0">{{ __('Student Login') }}</h4>

<p class="text-muted mb-1">Enter your <b class="text-danger">Matriculation Number</b> and password to access portal.</p>

<form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="hidden" name="loginby" id="loginby" value="student">

    <div class="mb-2">
        <label for="matriculation_no" class="form-label">{{ __('Matriculation Number') }}</label>
        <input id="matriculation_no" type="text" class="form-control @error('matriculation_no') is-invalid @enderror" name="matriculation_no" value="{{ old('matriculation_no') }}" required autocomplete="matriculation_no" autofocus>

        @error('matriculation_no')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-2">
        @if (Route::has('password.request'))
            <a class="text-muted float-end" href="{{ route('password.request') }}">
                <small>{{ __('Forgot Your Password?') }}</small>
            </a>
        @endif
        <label for="password" class="form-label">{{ __('Password') }}</label>

        <div class="input-group input-group-merge">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            <div class="input-group-text" data-password="false">
                <span class="password-eye"></span>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
            </label>
        </div>
    </div>
    <div class="d-grid text-center">
        <button class="btn btn-primary" type="submit">{{ __('Login') }} </button>
    </div>

    <div class="d-grid mt-2 text-center">
        <a href="{{ route('register') }}" class="btn btn-warning" type="button">{{ __('Register as a student') }} </a>
    </div>
</form>