@extends('home._page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-white bg-info" style="    margin-top: 200px;">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" style="color: #fff;font-weight: bold;text-decoration: underline;">{{ __('click here to request another') }}</a>.
                    {{ __(' Or not ') }} <a href="{{ url('/') }}" style="color: #fff;font-weight: bold;text-decoration: underline;">{{ __('Go to Home') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    document.getElementById('footer').style.display = 'none';
</script>
@endsection
