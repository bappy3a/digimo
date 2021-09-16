<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Login - {{get_static_option('site_'.get_user_lang().'_title')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('assets/uploads/site-favicon.'.get_static_option('site_favicon'))}}" type="image/png">
    <link rel="stylesheet" href="{{asset('assets/common/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/css/themify-icons.css')}}">
    <!-- others css -->
    <link rel="stylesheet" href="{{asset('assets/backend/css/typography.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/default-css.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/responsive.css')}}">
    <!-- modernizr css -->
    <script src="{{asset('assets/common/vendor/modernizr-2.8.3.min.js')}}"></script>
</head>

<body>
    @yield('content')

    <!-- jquery latest version -->
    <script src="{{asset('assets/common/vendor/jquery-2.2.4.min.js')}}"></script>
    <!-- bootstrap 4 js -->
    <script src="{{asset('assets/common/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/common/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/jquery.slicknav.min.js')}}"></script>

    <!-- others plugins -->
    <script src="{{asset('assets/backend/js/plugins.js')}}"></script>
    <script src="{{asset('assets/backend/js/scripts.js')}}"></script>
    @yield('scripts')
</body>
</html>
