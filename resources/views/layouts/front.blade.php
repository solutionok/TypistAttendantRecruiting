 <!DOCTYPE html>
<html lang="en" manifest="/manifest.appcache">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>{{env('APP_NAME')}}</title>

        <!-- Bootstrap core CSS -->
        <link href="{{url('public')}}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom fonts for this template -->
        <link href="{{url('public')}}/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

        <!-- Custom styles for this template -->
        <link href="{{url('public')}}/assets/stylesheets/front.css?190115" rel="stylesheet">

        @yield('css')
    </head>

    <body class="{{isset($pageClass)?$pageClass:''}}">
        <!-- Navigation -->
        <nav class="navbar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 col-xs-12">
                        <a href="{{url('public')}}/" class="logo">
                            <img src="{{url('public')}}/assets/images/logo.png">
                        </a>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <ul class="text-right">
                            <li>
                                <a href="{{url('public')}}/home/about">ABOUT US</a>
                            </li>
                            <li>
                                <a href="{{url('public')}}/home/product">PRODUCT</a>
                            </li>
                            <li>
                                <a href="#">SUPPORT</a>
                            </li>
                            <li>
                                <a href="{{url('public')}}/home/contact">CONTACT</a>
                            </li>
                            <li>
                                @if(!isset(auth()->user()->isadmin))
                                <a href="{{url('public')}}/login" class="my-account">SIGN IN</a>
                                @elseif(auth()->user()->isadmin==0)
                                <a href="{{url('public')}}/home/mypage" class="my-account">MY ACCOUNT</a>
                                @else
                                <a href="{{url('public')}}/admin" class="my-account">MY ACCOUNT</a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        
        @yield('content')
        
        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-8">
                        <h4>© Pixxy Studio. All Right Reserved 2019.</h4>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <ul class="list-inline text-right">
                            <li class="item">
                                <a href="#" class="fa fa-facebook"></a>
                            </li>
                            <li class="item">
                                <a href="#" class="fa fa-twitter"></a>
                            </li>
                            <li class="item">
                                <a href="#" class="fa fa-google-plus"></a>
                            </li>
                            <li class="item">
                                <a href="#" class="fa fa-instagram"></a>
                            </li>
                            <li class="item">
                                <a href="#" class="fa fa-youtube"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap core JavaScript -->
        <script src="{{url('public')}}/assets/vendor/jquery/jquery.min.js"></script>
        <script src="{{url('public')}}/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        @yield('js')
    </body>
</html>