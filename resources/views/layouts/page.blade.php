<!doctype html>
<html class="fixed" manifest="/manifest.appcache">
    <head>
        <meta charset="utf-8" />
        <meta name="keywords" content="smart test" />
        <meta name="description" content="Automatedhiring system">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <title>{{env('APP_NAME')}}</title>

        @include('layouts.css')
        <script>
            var BASE_URL = '{{url("")}}';
        </script>
    </head>
    <body>

        <section class="body">
            <!-- start: header -->
            @include('layouts.headbar')
            <!-- end: header -->

            <div class="inner-wrapper">
                <!-- start: sidebar -->
                @include('layouts.sidebar')
                <!-- end: sidebar -->


                <section role="main" class="content-body {{$pageName}}-page">
                    <header class="page-header">
                        <h2>{{ucfirst($pageName)}}</h2>

<!--                        <div class="right-wrapper pull-right">
                            <ol class="breadcrumbs">
                                <li>
                                    <a href="index.html">
                                        <i class="fa fa-home"></i>
                                    </a>
                                </li>
                                <li><span>{{ucfirst($pageName)}}</span></li>
                            </ol>
                        </div>-->
                    </header>
                    @yield('content')
                    <!--@include('layouts.footer')-->
                </section>
            </div>
        </section>
        @include('layouts.scripts')
    </body>
</html>