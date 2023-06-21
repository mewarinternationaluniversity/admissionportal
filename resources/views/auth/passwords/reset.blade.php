@extends('layouts.auth')

@section('content')

    <h4 class="mt-0">{{ __('Reset Password') }}</h4>

    <p class="text-muted mb-4">Reset your password here</p>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-2">

            <label for="email" class="form-label">{{ __('Email Address') }}</label>

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
            
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-2">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <div class="input-group input-group-merge">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
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

        <div class="mb-2">
            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>

            <div class="input-group input-group-merge">

                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                <div class="input-group-text" data-password="false">
                    <span class="password-eye"></span>
                </div>
            </div>

        </div>

        <div class="d-grid text-center">
            <button class="btn btn-primary" type="submit">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
    <footer class="footer footer-alt">
        <p class="text-muted">
            Already have account? <a href="{{ route('login') }}" class="text-primary fw-medium ms-1">Sign In</a>
        </p>
    </footer>

@endsection
