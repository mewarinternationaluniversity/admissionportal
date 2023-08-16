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
        /* z-index: 1; */
        padding: 20px;
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
    <script async src='https://d2mpatx37cqexb.cloudfront.net/delightchat-whatsapp-widget/embeds/embed.min.js'></script>
<script>
  var wa_btnSetting = {
    "btnColor": "#16BE45",
    "ctaText": "NBTE HND Help Desk",
    "cornerRadius": 40,
    "marginBottom": 20,
    "marginLeft": 20,
    "marginRight": 20,
    "btnPosition": "right",
    "whatsAppNumber": "2348055945547",
    "welcomeMessage": "If you need further assistance kindly chat with us or drop an email at hnd@nbte.gov.ng",
    "zIndex": 999999,
    "btnColorScheme": "light",
    "btnType": "floating"  // Add this line to set the button as floating
  };
  window.onload = () => {
    _waEmbed(wa_btnSetting);
  };
</script>
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
