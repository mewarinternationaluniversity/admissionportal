<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mewar') }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="/img/favicon.ico">

    <!-- App css -->
    <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="/css/icons.min.css" rel="stylesheet" type="text/css" />

    @stack('datepickercss')
</head>

<body class="loading auth-fluid-pages pb-0">

    <div class="auth-fluid">
        <div class="auth-fluid-right">
            @include('partials.auth.auth-user-testimonial')
        </div>
        <div class="auth-fluid-form-box">
            <div class="align-items-center d-flex h-100">
                <div class="card-body">
                    <div class="auth-brand text-center text-lg-start">
                        <div class="auth-logo">
                            <a href="{{ route('dashboard') }}" class="logo logo-dark">
                                <span class="logo-lg">
                                    <img src="/img/logo.png" alt="" height="50">
                                </span>
                            </a>

                            <a href="{{ route('dashboard') }}" class="logo logo-light">
                                <span class="logo-lg">
                                    <img src="/img/logo.png" alt="" height="50">
                                </span>
                            </a>
                        </div>
                    </div>

                    @yield('content')

                </div>
            </div>
        </div>
    </div>
    <script src="/js/vendor.min.js"></script>
    <script src="/js/app.min.js"></script>

    @stack('datepickerjs')
</body>
</html>
