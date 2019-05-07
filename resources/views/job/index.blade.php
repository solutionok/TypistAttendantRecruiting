@extends('layouts.page')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
<link href="{{url('public')}}/assets/vendor/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" >

<style>
    #search-form input{background: #fff;width: 150px;text-align:center;}
    .input-daterange{border-left: solid 1px #ddd;border-top-left-radius: 8px;border-bottom-left-radius: 8px;}
</style>
@endsection

@section('content')

<div class="row">
    <div class="col-sm-6">
        <form id="search-form">
            <div class="form-group">
                <label class="col-md-3 control-label text-center"><h5 style="font-weight:bold; color:black;">Date Range</h5></label>
                <div class="col-md-6">
                    <div class="input-daterange input-group" data-plugin-datepicker="">
                        <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control" name="startd" readonly="" value="{{LT2IT($searchDateRange[0])}}" style="cursor:initial; ">
                        <span class="input-group-addon">To</span>
                        <input type="text" class="form-control" name="endd" readonly="" value="{{LT2IT($searchDateRange[1])}}" style="cursor:initial;">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-6 text-right">
        @if(isAssessor())
        <button class="btn btn-primary create-trigger" data-toggle="modal" data-target=".job-modal">
            Add New Job
            <i class="fa fa-plus"></i>
        </button>
        @endif
    </div>
</div>

@foreach  ($jobList as $i=>$v)
<?php if($i%3==0){echo ($i?'</div>':'').'<div class="row">';}?>
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <div class="job-list ">
        <div class="job-head">
            
            <h3 class="text-center job-{{$v->id}}" title="{{$v->name}}">
            @if(!$v->quizs->count())
            <span class="fa fa-warning" title="no quizes"></span>
            @endif
            {{$v->name}}
            </h3>
        </div>
        <div class="job-body" >
            <div class="row mb-lg">
                <div class="col-sm-12 col-md-5 text-right text-capitalize">Owner : </div>
                <div class="col-sm-12 col-md-7 font-weight-bold">{{$v->owner->name}}</div>
                
                <div class="col-sm-12 col-md-5 text-right text-capitalize">Zip code : </div>
                <div class="col-sm-12 col-md-7 font-weight-bold">{{$v->zipcode}}</div>
                
                <div class="col-sm-12 col-md-5 text-right text-capitalize">Test type : </div>
                <div class="col-sm-12 col-md-7 font-weight-bold">{{$v->test_type == 1 ? 'Typing test and Voice recording' : 'Operator and Caller Training'}}</div>

                <div class="col-sm-12 col-md-5 text-right text-capitalize">Created At : </div>
                <div class="col-sm-12 col-md-7 font-weight-bold">{{LT2IT($v->created_at)}}</div>
                
                <div class="col-sm-12 col-md-5 text-right text-capitalize">Applied Applicants : </div>
                <div class="col-sm-12 col-md-7 font-weight-bold">{{$v->applicants->count()}}</div>
            </div>
            <div class="text-center">
                @if(isAssessor())
                <button class="btn btn-warning update-trigger btn-sm" _iid="{{$v->id}}" title="Edit job name, description, zip code">Edit</button>
                @endif
                <a class="btn btn-success btn-sm" href="{{url('')}}/admin/quiz?it={{$v->id}}" title="Manage recordings, texts for typing test">Quiz</a>
                @if(isAssessor())
                <button class="btn btn-danger delete-trigger btn-sm" _iid="{{$v->id}}" title="Delete job">Delete</button>
                @endif
                <a class="btn btn-info btn-sm" href="{{url('')}}/admin/applicant?search-select={{$v->id}}" title="View job Result/Reviews">Result</a>
                <!--<a class="btn btn-danger" href="{{url('public')}}/admin/job/toggle?it={{$v->id}}" title="{{intval($v->active_status)?'Currently actived':'Currently inactived'}}">{{intval($v->active_status)?'Inactive':'Active'}}</a>-->
            </div>
        </div>
    </div>
</div>
@endforeach

<?php if(isset($i)){echo '</div>';}?>

<div class="modal job-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New job</h5>
            </div>
            <div class="modal-body">
                <form id="create-job-form" method="post" enctype="multipart/form-data" target="save-frame">
                    @csrf
                    <input type="hidden" name="job_id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="color:black; font-weight:bold;">job Name <span style="color:red">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="color:black; font-weight:bold;">Instruction <span style="color:red">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="15" required style="height:300px;"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="color:black; font-weight:bold;">Required Zip Code <span style="color:red">*</span></label>
                                <input class="form-control" name="zipcode" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="color:black; font-weight:bold;">Test type <span style="color:red">*</span></label>
                                <select name="test_type" class="form-control" required>
                                    <option value="1" selected>Typing test and Voice recording</option>
                                    <option value="2">Operator and Caller Training</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Create" form="create-job-form">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
<iframe name="save-frame" style="display:none;"></iframe>

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
<script src="{{url('public')}}/plugins/chosen_v1.8.7/chosen.jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var currentDate = '{{date('Ymd')}}';
    $.fn.datepicker.defaults.format = "mm.dd.yyyy";
    $('select[name="assessor[]"]').chosen({width: "95%"})
    $('#description').summernote({height: 400});
    $('.update-trigger').click(function (e) {
        $.get(BASE_URL + '/admin/job/' + $(this).attr('_iid'), function(r){
            
            $('.job-modal .modal-title').text('Update Job');
            $('.job-modal input[type="submit"]').val('Update');
            $('#create-job-form input[name="job_id"]').val(r.id);
            $('#create-job-form input[name="name"]').val(r.name);
            $('#create-job-form textarea[name="description"]').summernote('code', r.description);
            $('#create-job-form input[name="zipcode"]').val(r.zipcode);
            $('#create-job-form select[name="test_type"]').val(r.test_type).prop('disabled', true);
            
            $('.job-modal').modal()
        }, 'json')
    });
    
    $('.create-trigger').click(function (e) {
        $('.job-modal .modal-title').text('Create job');
        $('.job-modal input[type="submit"]').val('Create');
        $('#create-job-form input[name="job_id"]').val('');
        $('#create-job-form').trigger('reset');
        $('#create-job-form textarea[name="description"]').summernote('code', '');
            $('#create-job-form select[name="test_type"]').prop('disabled', false);
        $('select[name="assessor[]"]').chosen().trigger("chosen:updated");
    });

    $('.delete-trigger').click(function (e) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you want to delete this job?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value && result.value===true) {
                $.get(BASE_URL + '/admin/job/delete', {id: $(this).attr('_iid')}, function (id) {
                    Swal.fire(
                      'Deleted!',
                      'The job has been deleted.',
                      'success'
                    ).then(()=>{
                        location.reload();
                    })
                })
            }
          })
    });

    $('input[name=startd],input[name=endd]').change(function(){
        $('#search-form').submit();
    })
    
    function periodCheck(v){
        return v.split('.').reverse().join('')>=currentDate;
    }
</script>
@endsection