<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">

body {
    margin: auto;
    font-family: -apple-system, BlinkMacSystemFont, sans-serif;
    overflow: auto;
    background: linear-gradient(315deg, 
        #e91e63 0%,     /* Violet */
        #9c27b0 10%,    /* Indigo */
        #2196f3 20%,    /* Blue */
        #4caf50 40%,    /* Green */
        #ffc107 60%,    /* Yellow */
        #ff5722 80%,    /* Orange */
        #f44336 100%    /* Red */
    );
    animation: gradient 15s ease infinite;
    background-size: 400% 400%;
    background-attachment: fixed;
}

@keyframes gradient {
    0% {
        background-position: 0% 0%;
    }
    50% {
        background-position: 100% 100%;
    }
    100% {
        background-position: 0% 0%;
    }
}

.wave {
    background: rgb(255 255 255 / 25%);
    border-radius: 1000% 1000% 0 0;
    position: fixed;
    width: 200%;
    height: 12em;
    animation: wave 1s -3s linear infinite;
    transform: translate3d(0, 0, 0);
    opacity: 0.8;
    bottom: 0;
    left: 0;
    z-index: -1;
}

.wave:nth-of-type(2) {
    bottom: -1.25em;
    animation: wave 1s linear reverse infinite;
    opacity: 0.8;
}

.wave:nth-of-type(3) {
    bottom: -2.5em;
    animation: wave 20s -1s reverse infinite;
    opacity: 0.9;
}

@keyframes wave {
    2% {
        transform: translateX(1);
    }

    25% {
        transform: translateX(-25%);
    }

    50% {
        transform: translateX(-50%);
    }

    75% {
        transform: translateX(-25%);
    }

    100% {
        transform: translateX(1);
    }
}
     /* Watermark styles */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.5);
            transform: translate(-50%, -50%);
            white-space: nowrap;
            pointer-events: none;
            z-index: 999;
            opacity: 0.5;
            animation: scrollWatermark 20s linear infinite;
        }

        @keyframes scrollWatermark {
            0% {
                transform: translate(-50%, -50%) translateX(100%);
            }
            100% {
                transform: translate(-50%, -50%) translateX(-100%);
            }
        }
body {
 font-size:11px;
 font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif, "Geeza Pro", "Nadeem", "Al Bayan", "DecoType Naskh", "DejaVu Serif", "STFangsong", "STHeiti", "STKaiti", "STSong", "AB AlBayan", "AB Geeza", "AB Kufi", "DecoType Naskh", "Aldhabi", "Andalus", "Sakkal Majalla", "Simplified Arabic", "Traditional Arabic", "Arabic Typesetting", "Urdu Typesetting", "Droid Naskh", "Droid Kufi", "Roboto", "Tahoma", "Times New Roman", "Arial", serif , "adobe arabic"
 ;
}
@page { margin: 0px; }
body { margin: 0px; }
@media print {
    html, body {
        height: 99%;    
    }
}
</style>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mewar') }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="/img/favicon.ico">

    @stack('datepicker')    

    <!-- App css -->
    <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="/css/icons.min.css" rel="stylesheet" type="text/css" />

    @stack('multiselect')

    @stack('dropzone')
</head>

<body class="loading" data-layout-mode="horizontal"
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        @include('partials.layout.nav')
        <!-- end Topbar -->

        @include('partials.layout.topnav')
        
        <!-- end topnav-->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">
                    @yield('content')
                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            
            @include('partials.layout.footer')
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- Vendor js -->
    <script src="/js/vendor.min.js"></script>
    <!-- App js -->
    <script src="/js/app.min.js"></script>

    @stack('scripts')

</body>

</html>
