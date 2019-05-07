<!doctype html>
<html class="fixed">
    <head>
        <meta charset="utf-8" />
        <meta name="keywords" content="smart test" />
        <meta name="description" content="Automatedhiring system">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>{{env('APP_NAME')}}</title>
        <link rel="icon" type="image/png" href="{{url('public')}}/images/icons/favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="{{url('public')}}/front/login/vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="{{url('public')}}/front/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="{{url('public')}}/front/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
        <link rel="stylesheet" type="text/css" href="{{url('public')}}/front/login/vendor/animate/animate.css">
        <link rel="stylesheet" type="text/css" href="{{url('public')}}/front/login/css/util.css">
        <link rel="stylesheet" type="text/css" href="{{url('public')}}/front/login/css/main.css">
        <link rel="stylesheet" type="text/css" href="{{url('public')}}/front/css/style.css">
    </head>
    <body class="login-body">

        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <form method="post" class="login100-form validate-form">
                        <h1 class="text-center m-b-8">
                            <a href="{{url('')}}">
                            <img src="{{url('public')}}/front/img/logo200.png">
                            </a>
                        </h1>
                        @csrf
                        
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif
                        @if (session('warning'))
                            <div class="alert alert-warning">
                                {{ session('warning') }}
                            </div>
                        @endif
                        
                        <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                            <input class="input100 {{old('email')?'has-val':''}}" type="text" name="email" value="{{old('email')}}">
                            <span class="focus-input100"></span>
                            <span class="label-input100">Email</span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Password is required">
                            <input class="input100" type="password" name="password">
                            <span class="focus-input100"></span>
                            <span class="label-input100">Password</span>
                        </div>

                        <div class="flex-sb-m w-full p-t-3 p-b-32">
                            <div class="contact100-form-checkbox">
                                <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember_me">
                                <label class="label-checkbox100" for="ckb1">
                                    Remember me
                                </label>
                            </div>

                            <div>
                            <a href="{{url('password/reset')}}" class="text-tasagent">
                                Forgot Password?
                            </a>
                            </div>
                        </div>


                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                Login
                            </button>
                        </div>

                        <div class="text-center p-t-46 p-b-20">
                            <a href="{{url('register')}}">
                                <span class="text-tasagent">
                                    Don't have an account? Register
                                </span>
                            </a>
                        </div>


                    </form>

                    <div class="login100-more" style="background-image: url('{{url("/public/front/login/images/bg-01.jpg")}}');">
                    </div>
                </div>
            </div>
        </div>

    </body>

    <script src="{{url('public')}}/front/login/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="{{url('public')}}/front/login/vendor/animsition/js/animsition.min.js"></script>
    <script src="{{url('public')}}/front/login/vendor/bootstrap/js/popper.js"></script>
    <script src="{{url('public')}}/front/login/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{url('public')}}/front/login/js/main.js"></script>

</script>
</html>