@extends('layouts.page')
@section('css')
<link rel="stylesheet" href="{{url('public')}}/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
<style>
    .dataTables_length select{
        padding: 2px!important;
            height: 30px!important;
    }
</style>
@endsection
@section('content')

@if(auth()->user()->isadmin==1)
<div class="row">
    <div class="col-md-6">
        <section class="panel panel-featured-left panel-featured-primary">
            <div class="panel-body">
                <div class="widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-primary">
                            <img src="{{url('public')}}/assets/images/test.png" aria-hidden="true">
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title" style="font-weight:bold; font-size:24px">Tests</h4>
                            <div class="info">
                                <strong class="amount">{{$testCount}}</strong>
                            </div>
                        </div>
                        <div class="summary-footer">
                            <a href="{{url('public')}}/admin/test" class="text-uppercase" style="font-weight:bold; font-size:12px">view all</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-6">
        <section class="panel panel-featured-left panel-featured-secondary">
            <div class="panel-body">
                <div class="widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-secondary">
                            <img src="{{url('public')}}/assets/images/review.png" aria-hidden="true">
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title" style="font-weight:bold; font-size:24px">Reviews</h4>
                            <div class="info">
                                <strong class="amount">{{$reviewCount}}</strong>
                            </div>
                        </div>
                        <div class="summary-footer">
                            <a href="{{url('public')}}/admin/review" class="text-uppercase" style="font-weight:bold; font-size:12px">view all</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-6">
        <section class="panel panel-featured-left panel-featured-tertiary">
            <div class="panel-body">
                <div class="widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-tertiary">
                            <img src="{{url('public')}}/assets/images/assessor.png" aria-hidden="true">
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title" style="font-weight:bold; font-size:24px">Assessors</h4>
                            <div class="info">
                                <strong class="amount">{{$assessorCount}}</strong>
                            </div>
                        </div>
                        <div class="summary-footer">
                            <a href="{{url('public')}}/admin/assessor" class="text-uppercase" style="font-weight:bold; font-size:12px">view all</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-6">
        <section class="panel panel-featured-left panel-featured-quartenary">
            <div class="panel-body">
                <div class="widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-quartenary">
                            <img src="{{url('public')}}/assets/images/candidate.png" aria-hidden="true">
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title" style="font-weight:bold; font-size:24px">Candidates</h4>
                            <div class="info">
                                <strong class="amount">{{$candidateCount}}</strong>
                            </div>
                        </div>
                        <div class="summary-footer">
                            <a href="{{url('public')}}/admin/candidate" class="text-uppercase" style="font-weight:bold; font-size:12px">view all</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endif
<div class="row">
    <div class="{{auth()->user()->isadmin==1?'col-md-6 col-sm-12':'col-md-12 col-sm-12'}}">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">
                    Not Reviewed tests
                </h2>
            </header>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table mb-none non-review-table">
                        <thead class="">
                        <th>S.No</th>
                        <th>Candidate</th>
                        <th>test</th>
                        <th>test Date</th>
                        </thead>
                        <tbody>
                            @foreach($tests as $i=>$q)
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>
                                    <a href="{{url('public')}}/admin/review/{{$q->id}}">
                                        <img src="{{url('public')}}/{{!empty($q->photo)?$q->photo:'app/candidate/user.jpg'}}" style="width:30px;height:30px;"> <nobr>{{$q->candidaten}}</nobr>
                                    </a>
                                </td>
                                <td>{{$q->testn}}</td>
                                <td>{{LT2IT($q->rundate)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    @if(auth()->user()->isadmin==1)
    <div class="col-md-6 col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">
                    Not Appeared Candidates
                </h2>
            </header>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table mb-none non-appear-table">
                        <thead class="">
                        <th>S.No</th>
                        <th>Candidate</th>
                        <th>test</th>
                        </thead>
                        <tbody>
                            @foreach($intTemplates as $i=>$q)
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>
                                    <a href="{{url('public')}}/admin/candidate/view?id={{$q->candidate_id}}">
                                        <img src="{{url('public')}}/{{!empty($q->photo)?$q->photo:'app/candidate/user.jpg'}}" style="width:30px;height:30px;"> <nobr>{{$q->candidaten}}</nobr>
                                    </a>
                                </td>
                                <td>
                                    <?php echo $q->testn?>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script src="{{url('public')}}/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="{{url('public')}}/assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="{{url('public')}}/assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
<script type="text/javascript" >
    $('.non-review-table,.non-appear-table').DataTable({
        "dom": '<"top"lf>t<"bottom"pi><"clear">',
        select: true,
        language: {
            searchPlaceholder: "Search "
        }
    });
</script>
@endsection