@extends('layouts.page')
@section('css')
<link rel="stylesheet" href="{{url('public')}}/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
<style>
    .table-responsive {
        overflow-x: hidden;
    }
    div.dataTables_length select {
        padding: 5px 10px!important;
        text-align: center;
        width: auto;
        height: auto;
    }
    .dataTables_wrapper .dataTables_filter label{width:100%;}
    .dataTables_wrapper .dataTables_filter input {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555555;
        background-color: #ffffff;
        background-image: none;
        border: 1px solid #cccccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }
    .dataTables_wrapper .dataTables_filter input{
        background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PHN2ZyAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgICB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIiAgIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyIgICB4bWxuczpzdmc9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgICB2ZXJzaW9uPSIxLjEiICAgaWQ9InN2ZzQ0ODUiICAgdmlld0JveD0iMCAwIDIxLjk5OTk5OSAyMS45OTk5OTkiICAgaGVpZ2h0PSIyMiIgICB3aWR0aD0iMjIiPiAgPGRlZnMgICAgIGlkPSJkZWZzNDQ4NyIgLz4gIDxtZXRhZGF0YSAgICAgaWQ9Im1ldGFkYXRhNDQ5MCI+ICAgIDxyZGY6UkRGPiAgICAgIDxjYzpXb3JrICAgICAgICAgcmRmOmFib3V0PSIiPiAgICAgICAgPGRjOmZvcm1hdD5pbWFnZS9zdmcreG1sPC9kYzpmb3JtYXQ+ICAgICAgICA8ZGM6dHlwZSAgICAgICAgICAgcmRmOnJlc291cmNlPSJodHRwOi8vcHVybC5vcmcvZGMvZGNtaXR5cGUvU3RpbGxJbWFnZSIgLz4gICAgICAgIDxkYzp0aXRsZT48L2RjOnRpdGxlPiAgICAgIDwvY2M6V29yaz4gICAgPC9yZGY6UkRGPiAgPC9tZXRhZGF0YT4gIDxnICAgICB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLC0xMDMwLjM2MjIpIiAgICAgaWQ9ImxheWVyMSI+ICAgIDxnICAgICAgIHN0eWxlPSJvcGFjaXR5OjAuNSIgICAgICAgaWQ9ImcxNyIgICAgICAgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjAuNCw4NjYuMjQxMzQpIj4gICAgICA8cGF0aCAgICAgICAgIGlkPSJwYXRoMTkiICAgICAgICAgZD0ibSAtNTAuNSwxNzkuMSBjIC0yLjcsMCAtNC45LC0yLjIgLTQuOSwtNC45IDAsLTIuNyAyLjIsLTQuOSA0LjksLTQuOSAyLjcsMCA0LjksMi4yIDQuOSw0LjkgMCwyLjcgLTIuMiw0LjkgLTQuOSw0LjkgeiBtIDAsLTguOCBjIC0yLjIsMCAtMy45LDEuNyAtMy45LDMuOSAwLDIuMiAxLjcsMy45IDMuOSwzLjkgMi4yLDAgMy45LC0xLjcgMy45LC0zLjkgMCwtMi4yIC0xLjcsLTMuOSAtMy45LC0zLjkgeiIgICAgICAgICBjbGFzcz0ic3Q0IiAvPiAgICAgIDxyZWN0ICAgICAgICAgaWQ9InJlY3QyMSIgICAgICAgICBoZWlnaHQ9IjUiICAgICAgICAgd2lkdGg9IjAuODk5OTk5OTgiICAgICAgICAgY2xhc3M9InN0NCIgICAgICAgICB0cmFuc2Zvcm09Im1hdHJpeCgwLjY5NjQsLTAuNzE3NiwwLjcxNzYsMC42OTY0LC0xNDIuMzkzOCwyMS41MDE1KSIgICAgICAgICB5PSIxNzYuNjAwMDEiICAgICAgICAgeD0iLTQ2LjIwMDAwMSIgLz4gICAgPC9nPiAgPC9nPjwvc3ZnPg==);
        background-repeat: no-repeat;
        background-color: #fff;
        background-position: 3px 6px !important;
        padding-left: 25px;    
    }
    .text-contents{
        height:50px;
        overflow: hidden;
        position:relative;
    }
    .text-contents:before {
        content:'';
        width:100%;
        height:100%;    
        position:absolute;
        left:0;
        top:0;
        background:linear-gradient(transparent 20px, #fff);
    }

</style>
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">{{$job->name}} {{$job->test_type==1?'Test Text':'Recordings and Texts'}}</h4>
            </div>
            <div class="panel-body">
                <p class="btn-bar">
                    <button onclick="javascript:location.href = '{{url("")}}/admin/job';" class="btn btn-primary"> <i class="fa fa-arrow-left"></i> Back</button>
                    <?php if($job->test_type==1): ?>
                    <button class="btn btn-success create-quiz-trigger <?php if(count($quizList)) echo 'hide'?>" _type="typing_text">Add Text <i class="fa fa-plus"></i></button>
                    <?php elseif ($job->test_type==2): ?>
                    <button class="btn btn-success create-quiz-trigger" _type="operator">Add Operator Text <i class="fa fa-plus"></i></button>
                    <button class="btn btn-danger create-quiz-trigger" _type="caller">Add Caller Text <i class="fa fa-plus"></i></button>
                    <?php endif; ?>
                </p>

                <div class="table-responsive">
                    <table class="Text-table table table-bordered table-striped mb-none dataTable no-footer">
                        <thead>
                        <th class="text-center" style="width:100px;text-align: center">S. No.</th>
                        <th class="text-center" style="padding:0;">Text</th>
                        </thead>
                        <tbody>
                            
                            @foreach($quizList as $i=>$q)
                            <tr>
                                <td class="text-center">{{$i+1}}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if($q->qtype == 3)
                                            <span class="label label-info">Text</span>
                                            @elseif($q->qtype == 1)
                                            <span class="label label-success">Operator</span>
                                            @elseif($q->qtype == 2)
                                            <span class="label label-danger" style="vertical-align: top;display: inline-block;margin-top: 10px;">Caller</span>
                                            <audio controls src="{{url('public/'.$q->recording_audio)}}" style="height:30px;"></audio>
                                            @endif
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <div class="btn-group">
                                                <nobr>
                                                <a class="btn btn-default btn-sm update-quiz-trigger" _iid="{{$q->id}}" title="Edit Text"><i class="fa fas fa-edit"></i> </a>
                                                <a class="btn btn-default btn-sm delete-quiz-trigger" _iid="{{$q->id}}" title="Remove this Text"><i class="fa fa-trash"></i> </a>
                                                <a class="btn btn-default btn-sm" href="{{url('')}}/admin/quiz/moveq/{{$q->id}}" title="Move up"><i class="fa fa-arrow-up"></i> </a>
                                                <a class="btn btn-default btn-sm" href="{{url('')}}/admin/quiz/moveq/-{{$q->id}}" title="Move down"><i class="fa fa-arrow-down"></i> </a>
                                                </nobr>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="text-contents">
                                            {{mb_substr($q->recording_text,0,500)}}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade quiz-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:90%;max-width:1200px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Question</h5>
            </div>
            <div class="modal-body">
                <form id="create-quiz-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="quiz_id">
                    <input type="hidden" name="job_id" value="{{$job->id}}">
                    <input type="hidden" name="qtype" value="">
                    
                    <div class="row available-in-caller">
                        <div class="col-md-6">
                            <label class="font-weight-bold text-capitalize">upload recording</label>
                            <input name="recording_audio" type="file" accept="audio/mp3">
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold text-capitalize">uploaded recording</label>
                            <audio id="recording_audio_player" src="" controls="" style="display:block;"></audio>
                        </div>
                    </div>
                    
                    <hr class="choice-hr available-in-caller">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold text-capitalize">Text</label>
                                <textarea class="form-control" name="recording_text" rows="8" required=""></textarea>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Create" form="create-quiz-form">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{url('public')}}/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="{{url('public')}}/assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="{{url('public')}}/assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
<script type="text/javascript" src="{{url('public')}}/plugins/timepicker/timepicker.js"></script>
<script type="text/javascript">
    @if(!isAssessor())
        $('.create-quiz-trigger, .Text-table td:last-child, .Text-table th:last-child').hide( )
    @endif
    var Table = $('.Text-table').dataTable({
        "dom": '<"top"lf>t<"bottom"pi><"clear">',
        sort: false,
    });

    $('input[name="recording_audio"]').change(function(){
        console.log(this.files[0])
        $('#recording_audio_player').attr('src', window.URL.createObjectURL(this.files[0]));
 
    })
    
    $('#create-quiz-form').submit(function () {
        //if caller text and never recording
        if(!$('input[name=quiz_id]').val() && $('.quiz-modal input[name="qtype"]').val()=='2' && !$('input[name="recording_audio"]').val()){
            Swal.fire(
                'Choose a recording audio!',
                '',
                'error'
            );
            return false;
        }
        var txt = $('textarea[name=recording_text]').val().replace(/[\s]{2,}/gi,' ').replace(/[\n]/gi,' ').trim()
        $('textarea[name=recording_text]').val(txt)
        $('.quiz-modal').hide()
        return true;
    })
    
    $('.update-quiz-trigger').click(function () {
        $.get(BASE_URL + '/admin/quiz/getquiz/' + $(this).attr('_iid'), function (r) {
            $('textarea[name=recording_text]').val(r['recording_text']);
            $('#recording_audio_player').attr('src', BASE_URL + '/public/' + r['recording_audio']);
            
            $('input[name=recording_audio]').val('')
            $('.quiz-modal .modal-title').text('Update Text');
            $('.quiz-modal input[type="submit"]').val('Update');
            $('#create-quiz-form input[name="quiz_id"]').val(r['id']);

            $('.quiz-modal').modal();
            
            if(r['qtype']==3){
                $('.quiz-modal .modal-title').text('Update Text');
                $('.quiz-modal .available-in-caller').hide();
            }else if(r['qtype']==1){
                $('.quiz-modal .modal-title').text('Update Operator Text');
                $('.quiz-modal .available-in-caller').hide();
            }else if(r['qtype']==2){
                $('.quiz-modal .modal-title').text('Update Caller Recording And Text');
                $('.quiz-modal .available-in-caller').show();
            }
        })

    })

    $('.delete-quiz-trigger').click(function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you want to delete this text?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value && result.value===true) {
                $.get(BASE_URL + '/admin/quiz/delete', {id: $(this).attr('_iid')}, function (id) {
                    Swal.fire(
                      'Deleted!',
                      'The text has been deleted.',
                      'success'
                    ).then(()=>{
                        location.reload();
                    })
                })
            }
          })
    })

    $('.create-quiz-trigger').click(function () {
        $('#create-quiz-form').trigger('reset');
        $('.quiz-modal input[type="submit"]').val('Save');
        $('#create-quiz-form input[name="quiz_id"]').val('');
        $('#recording_audio_player').attr('src','');
        $('.quiz-modal').modal();

        if($(this).attr('_type') == 'typing_text'){
            $('.quiz-modal input[name="qtype"]').val('3');
            $('.quiz-modal .modal-title').text('New Text');
            $('.quiz-modal .available-in-caller').hide();
        }else if($(this).attr('_type') == 'operator'){
            $('.quiz-modal input[name="qtype"]').val('1');
            $('.quiz-modal .modal-title').text('New Operator Text');
            $('.quiz-modal .available-in-caller').hide();
        }else if($(this).attr('_type') == 'caller'){
            $('.quiz-modal input[name="qtype"]').val('2');
            $('.quiz-modal .modal-title').text('New Caller Recording And Text');
            $('.quiz-modal .available-in-caller').show();
        }

    })

</script>
@endsection