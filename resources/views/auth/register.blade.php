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
        <style>
            .login100-form{
                padding-top: 50px;
            }
            .login100-form .logo{
                height:30vh;
            }
            .wrap-input100{
                height: 60px;
            }
            .label-input100{
                top: 20px;
            }
            .input100:focus + .focus-input100 + .label-input100 {
                top: 5px;
                font-size: 13px;
            }
            .has-val + .focus-input100 + .label-input100 {
                top: 5px;
                font-size: 13px;
            }
        </style>
    </head>
    <body class="login-body">

        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <form method="post" class="login100-form validate-form">
                        <h1 class="text-center m-b-8">
                            <a href="{{url('')}}">
                                <img src="{{url('public')}}/front/img/logo200.png" class="logo">
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
                        
                        <div class="wrap-input100 validate-input">
                            <input class="input100 {{old('name')?'has-val':''}}" type="text" id="name" name="name" required="" value="{{old('name')}}">
                            <span class="focus-input100"></span>
                            <span class="label-input100">Full Name</span>
                        </div>

                        <div class="wrap-input100 validate-input">
                            <input class="input100 {{old('email')?'has-val':''}}" type="text" id="email" name="email" required="" value="{{old('email')}}">
                            <span class="focus-input100"></span>
                            <span class="label-input100">Email</span>
                        </div>

                        <div class="wrap-input100 validate-input">
                            <input class="input100 {{old('phone')?'has-val':''}}" type="text" id="phone" name="phone" required="" value="{{old('phone')}}">
                            <span class="focus-input100"></span>
                            <span class="label-input100">Phone</span>
                        </div>

                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="password" id="password" name="password" required="">
                            <span class="focus-input100"></span>
                            <span class="label-input100">Password</span>
                        </div>

                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="password" id="password_confirmation" name="password_confirmation" required="">
                            <span class="focus-input100"></span>
                            <span class="label-input100">Confirm</span>
                        </div>

                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                Register
                            </button>
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
    <script src="{{url('public')}}/front/js/register.js"></script>

</script>
</html>