@push('datepickercss')
    <link href="/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
@endpush

@push('datepickerjs')
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script src="/js/moment.min.js"></script>
@endpush

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
        <label for="password" class="form-label">{{ __('Date of birth') }}</label>

        <div class="input-group input-group-merge">

            <div class="input-group position-relative" id="datepicker1">
                <input type="text" id="password" name="password" class="form-control @error('password') is-invalid @enderror" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-container="#datepicker1">
                <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
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