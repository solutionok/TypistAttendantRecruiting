<!DOCTYPE html>
<html lang="en" manifest="/manifest.appcache">
    <head>
        <meta charset="utf-8">
        <title>{{env('APP_NAME')}}</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Favicons -->
        <link href="{{url('public')}}/front/img/logo.w30.png" rel="icon">
        <link href="{{url('public')}}/frontimg/logo.w30.png" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700" rel="stylesheet">

        <!-- Bootstrap CSS File -->
        <link href="{{url('public')}}/front/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Libraries CSS Files -->
        <link href="{{url('public')}}/front/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <!-- Main Stylesheet File -->
        <link href="{{url('public')}}/front/css/style.css" rel="stylesheet">
        @yield('css')
        <script>
            var BASE_URL = '{{url("")}}';
        </script>
    </head>
    <body>
        <div class="page-wrapper">
            <!--==========================
              Top Bar
            ============================-->
            <section id="topbar" class="d-none d-lg-block">
                <div class="container clearfix">
                    <div class="contact-info float-left">
                        <i class="fa fa-envelope-o"></i> <a href="mailto:contact@example.com">support@tasagents.com</a>
                        <i class="fa fa-phone"></i> 833 499 6500
                    </div>
                    <div class="sign-links float-right">
                        @if(Auth::check())
                          @if(isAdmin()||isAssessor())
                          <a href="{{url('')}}/admin/job" class="my-account"><i class="fa fa-tasks"></i> Dashboard</a>&nbsp;&nbsp;&nbsp;&nbsp;
                          @endif
                          <a href="{{url('')}}/logout" class="my-account"><i class="fa fa-sign-out"></i> Logout</a>
                        @else
                          <a href="{{url('')}}/login"><i class="fa fa-sign-in"></i> Log in </a>&nbsp;&nbsp;&nbsp;&nbsp;
                          <!--<a href="{{url('')}}/register"><i class="fa fa-user-plus"></i> Register </a>-->
                        @endif
                    </div>
                </div>
            </section>

            @yield('content')

            <!--==========================
              Footer
            ============================-->
            <footer id="footer" >
                <div class="container">
                    <div class="copyright">
                        @<?php echo date('Y') ?> <strong>TAS Agent</strong>. All Rights Reserved
                    </div>
                    <div class="credits">
                        <!--Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>-->
                    </div>
                </div>
            </footer><!-- #footer -->

            <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

            <!-- JavaScript Libraries -->
            <script src="{{url('public')}}/front/lib//jquery/jquery.min.js"></script>
            <script src="{{url('public')}}/front/lib//jquery/jquery-migrate.min.js"></script>
            <script src="{{url('public')}}/front/lib//bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="{{url('public')}}/front/lib//easing/easing.min.js"></script>
            <script src="{{url('public')}}/front/lib//superfish/hoverIntent.js"></script>
            <script src="{{url('public')}}/front/lib//superfish/superfish.min.js"></script>
            <script src="{{url('public')}}/front/lib//wow/wow.min.js"></script>

            @yield('scripts')
        </div>
    </body>
</html>