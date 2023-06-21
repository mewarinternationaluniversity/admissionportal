@extends('layouts.auth')

@section('content')

    <h4 class="mt-0">{{ __('Reset Password') }}</h4>

    <p class="text-muted mb-4">
        Enter your email address and we'll send you an email with instructions to reset your password.
    </p>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email Address') }}</label>

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="d-grid text-center">
            <button class="btn btn-primary waves-effect waves-light" type="submit">
                {{ __('Send Password Reset Link') }}
            </button>
        </div>

    </form>
    <footer class="footer footer-alt">
        <p class="text-muted">
            Back to <a href="{{ route('login') }}" class="text-primary fw-medium ms-1">{{ __('Login') }} </a>
        </p>
    </footer>

@endsection
