@extends('home._page')
@section('css')
<link href="{{url('public/front/css/index.css')}}" rel="stylesheet"/>
@endsection
@section('content')
    <section class="search-section">
        <div class="container">
            <div class="row">
                
                <div class="col-sm-12 col-lg-8 offset-lg-2">

                    <form action="{{url('jobs')}}" class="form form-inline jobs-location">
                        <div id="logo" style="margin-right:30px;">
                            <h1><a href="{{url('/')}}" class="scrollto"><img src="{{url('public')}}/front/img/logo.h80.png"></a></h1>
                        </div>
                        <div class="inner-addon left-addon">
                            <i class="fa fa-map-marker map-icon"></i>
                            <input type="text" name="zip" value="{{request('zip')}}" class="form-control" placeholder="Location"/>
                        </div>
                        <button type="submit" id="doQuickSearch2" class="btn">Find Jobs</button>
                        <!--<label><i class="fa fa-tasks"></i>&nbsp; {{$jobs->count()?$jobs->count():'No'}} Jobs</label>-->
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    
                    <p class="text-center">
                        TAS agent can help you locate, train, and apply for the best jobs in the Telephone Answering Business.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="wow fadeInUp jobs-section">
        <div class="container">

            <div class="col-sm-12 col-lg-8 offset-lg-2 job-list">
                <h5>Search by zipcode</h4>  
                @foreach($jobs as $job)
                <div class="job">
                    <div class="row">
                        <div class="col-lg-10">
                            <h5 class="font-weight-bold mb-0">
                                <a href="{{url('jobs?zip=' . $job->zipcode)}}">
                                    <i class="fa fa-map-marker" style="font-size: 22px;"></i> {{$job->zipcode}}
                                </a>
                            </h5>
                        </div>
                        <div class="col-lg-2 text-right">
                            <i class="fa fa-desktop text-info"></i> {{$job->ct}} 
                            <!--<i class="fa fa-arrow-right"></i>--> 
                        </div>
                    </div>
                    
                </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
    </script>
@endsection