<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(315deg, 
                #e91e63 0%,     /* Violet */
                #9c27b0 10%,    /* Indigo */
                #2196f3 20%,    /* Blue */
                #4caf50 40%,    /* Green */
                #ffc107 60%,    /* Yellow */
                #9c27b0 80%,    /* Orange */
                #e91e63 100%    /* Red */
            );
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 0%;
            }
            50% {
                background-position: 100% 100%;
            }
            80% {
                background-position: 10% 0%;
            }
        }

        .content {
            position: relative;
            padding: 20px;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Mewar') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="/img/favicon.ico">
    <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />
    <link href="/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />
    <link href="/css/icons.min.css" rel="stylesheet" type="text/css" />
    @stack('datepicker')    
    @stack('multiselect')
    @stack('dropzone')
</head>

<body class="loading" data-layout-mode="horizontal" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>

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

    <!-- Script to display Live Chat button for non-admin users -->
    <script>
        @if(Auth::check() && !Auth::user()->hasRole('admin'))
            document.addEventListener("DOMContentLoaded", function() {
                var chatButton = document.createElement("div");
                chatButton.style.position = "fixed";
                chatButton.style.bottom = "20px";
                chatButton.style.right = "20px";
                chatButton.style.backgroundColor = "#16BE45";
                chatButton.style.color = "white";
                chatButton.style.padding = "10px 20px";
                chatButton.style.borderRadius = "40px";
                chatButton.style.cursor = "pointer";
                chatButton.style.zIndex = "999999";
                chatButton.textContent = "Chat NBTE Help Desk";
                chatButton.onclick = function() {
                    window.location.href = "{{ route('messages.chat') }}";
                };
                document.body.appendChild(chatButton);
            });
        @endif
    </script>

    <!-- Vendor js -->
    <script src="/js/vendor.min.js"></script>
    <!-- App js -->
    <script src="/js/app.min.js"></script>

    @stack('scripts')

</body>
</html>

