@extends('layouts.page')
@section('css')
<link rel="stylesheet" href="{{url('public')}}/assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
<link href="{{url('public')}}/assets/vendor/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" >
<style>

</style>
@endsection
@section('content')

<div class="row">
    
</div>
    
@section('scripts')
<script src="{{url('public')}}/assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript">
    $.fn.datepicker.defaults.format = "mm.dd.yyyy";
    
    
</script>
@endsection