@extends('layouts.app')

@section('content')
    <h4 class="mt-0">{{ __('Confirm Password') }}</h4>
    <p class="text-muted mb-4">{{ __('Please confirm your password before continuing.') }}</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

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
        
        <div class="d-grid text-center">
            <button class="btn btn-primary" type="submit">
                {{ __('Confirm Password') }}
            </button>
        </div>

    </form>

    <footer class="footer footer-alt">
        <p class="text-muted">
            Already have account? <a href="{{ route('login') }}" class="text-primary fw-medium ms-1">Sign In</a>
        </p>
    </footer>
    
@endsection