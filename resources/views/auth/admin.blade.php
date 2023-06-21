<h4 class="mt-0">{{ __('Admin / Institute Login') }}</h4>

<p class="text-muted mb-1">Enter your email address and password to access admin panel.</p>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <input type="hidden" name="loginby" id="loginby" value="admin">

    <div class="mb-2">
        <label for="email" class="form-label">{{ __('Email Address') }}</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

        @error('email')
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
</form>