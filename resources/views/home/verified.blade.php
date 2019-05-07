@extends('home._page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-white bg-info" style="    margin-top: 200px;">
                <div class="card-header">{{ __('Email Veification') }}</div>

                <div class="card-body">
                    <div class="alert alert-success" role="alert">
                        {{ __('Your account have been verified!') }}
                    </div>

                    <a href="{{ url('/') }}" style="color: #fff;font-weight: bold;text-decoration: underline;">{{ __('Go to the homepage') }}</a>.
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
