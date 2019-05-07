 @extends('layouts.page')
@section('css')
<style>
    @media only screen and (max-width: 1000px){
        .panel-actions {
            float: none;
            margin-bottom: 15px;
            position: static;
            text-align: right;
        }
    }
    .panel-header .toolbar{
        padding-top:15px;
        font-size: 18px;
    }
    .panel-header .toolbar span{
        color:#fa7a50;font-weight: bold;margin-right: 15px;
    }
    .panel-header .toolbar progress{
        height: 18px;
    }
    .candidate-box .panel-body img{
        width: 100px;height:100px;float:left;margin:0 10px 10px 0;
    }
    .step-box table td a{
        color: #888;
    }

    .quiz-box .panel-body h5{
        border-bottom:solid 1px #fa7a50;position:relative;
    }
    .quiz-box .panel-body h5 div{
        position:absolute;right:5px;top: -18px;text-align: right;
    }
    .quiz-box #record-cam{
        width: 100%;height:auto;
    }
    .quiz-box .problem-list{
        list-style: none;
    }
    .quiz-box .quiz h5{
        border-bottom:solid 1px #fa7a50;margin-top:10px;
    }
    td.active-step a{
        color: #f96332!important;
        font-weight: bold!important;
    }
    progress {
        padding-top: 5px;
        background-color: #fff;
        border: 0;
        height: 18px;
        border-radius: 9px;
        -webkit-appearance: none;
        appearance: none;
        background:none;
    }
    progress[value]::-webkit-progress-bar {
        background-color: #fff;
        border: 0;
        height: 18px;
        border-radius: 9px;
        background-color: #eee;
        border-radius: 2px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.25) inset;
    }

    progress[value]::-webkit-progress-value {background-image: linear-gradient(to top, #30cfd0 0%, #330867 100%)}
    .evaulated_answer{
        color: #2baab1!important;
        font-size: 18px!important;
        line-height: 24px!important;
    }
    .evaulated_answer strike{
        color:#e36159;
        font-weight: bold;
    }
</style>
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row" >
                    <div class="col-sm-12">
                        <h4 class="panel-title">
                            {{empty($test)?'test damaged':$test->name}}
                        </h4>
                    </div>
                    <div class="col-sm-12 text-right" style="font-size:18px;">
                        Total Score :  {{$history->grade}} / {{$history->availgrade}}</span>
                        <progress value="{{$history->grade}}" max="{{$history->availgrade}}"></progress>

                        <button onclick="location.href = '{{url("")}}/admin/review';" class="btn btn-sm btn-primary" style="margin-top:-1px;margin-left: 10px;"><i class="fa fa-arrow-circle-left"></i> test List</button>
                        @if(auth()->user()->isadmin==2 && deadlineCheck($test->att))
                        <button class="btn btn-sm btn-primary total-review" _history="{{$history->id}}" style="margin-top:-1px;margin-left: 10px;">Set test Review</button>
                        @endif

                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="panel candidate-box">
                            <div class="panel-body">
                                <img src="{{url('public')}}/{{!empty($candidate->photo)?$candidate->photo:'app/candidate/user.jpg'}}">
                                <div class="text-left">
                                    <p><span style="font-weight:bold; font-size:16px">Name: </span>
                                <span style="font-size:16px">{{$candidate->name}}</span></p></div>
                                
                                <div class="text-left"><p><span style="font-weight:bold; font-size:16px">test Date: </span>
                                <span style="font-size:16px">{{date('m.d.Y', strtotime($history->rundate))}}</span></p></div>
                                
                                <div class="text-left"><p><span style="font-weight:bold; font-size:16px">Evaluation: </span>
                                <span style="font-size:16px">{{empty($hasReview)?'Not Reviewed':'Reviewed'}}</span></p></div>
                            </div>
                        </div>
                        <div class="panel step-box">
                            <div class="panel-body">
                                <table class="table">
                                    <thead style="font-weight:bold; font-size:16px">
                                    <th>
                                        Questions 
                                    </th>
                                    </thead>
                                    <tbody>
                                        @foreach($steps as $i=>$q)
                                        <tr>
                                            <td class='{{$step==($i+1)?'active-step':''}}'><a href="{{url('')}}/admin/review/{{$history->id}}/{{$i+1}}">{{substr($q->description,0, 60)}}</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="panel quiz-box">
                            <div class="panel-body">
                                @if($step)
                                <!--Answer Head-->
                                <h5>
                                    <span style="font-size:18px; font-weight:bold;">Answer</span>
                                    <div>
                                        <span style="font-weight:bold">Score : {{empty($quiz->mark)?'0':$quiz->mark}} / {{empty($quiz->grade)?'0':$quiz->grade}}</span></span>
                                        @if(auth()->user()->isadmin==2 && deadlineCheck($test->att))
                                        &nbsp;&nbsp;&nbsp;
                                        <button class="btn btn-primary btn-sm set-mark-trigger" 
                                                _id="{{$quiz->id}}" 
                                                _history="{{$history->id}}" 
                                                _avail_grade="{{$quiz->grade}}" 
                                                {{$quiz->qtype=='3' || $quiz->qtype=='4'?'isrecord':''}}>Set Quiz Review</button>
                                        @endif
                                    </div>
                                </h5>

                                <!--Answer Body-->
                                @if($quiz->qtype=='3' || $quiz->qtype=='4')
                                    @if(isset($quiz->record))
                                    <video id="record-cam" src="{{url('public')}}/{{$quiz->record}}" controls=""></video>
                                    @else
                                    <img src="{{url('public')}}/assets/images/no-answer.jpg" style="width:100%;">
                                    @endif
                                
                                @elseif($quiz->qtype=='5')
                                    <div style="margin-bottom:10px;">
                                        <button class="btn btn-sm btn-info">WPM: {{$quiz->detail->wpm*1}}</button>
                                        <button class="btn btn-sm btn-success">ACCURATE: {{$quiz->detail->accurate*1}}%</button>
                                        <button class="btn btn-sm btn-primary">TIME: {{$quiz->detail->overtime}}s</button>
                                        <button class="btn btn-sm btn-danger">TYPO: {{$quiz->detail->typo}}</button>
                                    </div>
                                    <div class="form-control evaulated_answer"><?php echo $quiz->detail->evaluated?></div>
                                @else
                                    <?php $qdetail = json_decode($quiz->qdetail)?>
                                    @if(count($qdetail->txt))
                                    <ul class="problem-list">
                                    @foreach($qdetail->txt as $i=>$txt)
                                    <li>
                                        <input type="{{$quiz->qtype=='1'?'checkbox':'radio'}}" name="check-items" disabled {{$qdetail->ch[$i]==1?'checked':''}}>
                                        {{$txt}}
                                    </li>
                                    @endforeach
                                    </ul>
                                    @else
                                    <img src="{{url('public')}}/assets/images/no-answer.jpg" style="width:100%;">
                                    @endif
                                @endif

                                <!--Quiz--> 
                                <div class="quiz">
                                    <h5 style="font-size:16px; font-weight:bold;">Question</h5>
                                    <p style="font-size:14px;">{{$quiz->description}}</p>
                                    @if($quiz->attach_media)
                                    <?php $ext = pathinfo($quiz->attach_media)['extension'] ?>
                                    @if($ext=='mp3'||$ext=='mp4')
                                    <video controls="" name="media" style="{{$ext=='mp3'?'width:100%;height:50px':'max-height:300px;'}}">
                                        <source src="{{url('public')}}/{{$quiz->attach_media}}" type="{{$ext=='mp3'?'audio/mp3':'video/mp4'}}">
                                    </video>
                                    @else
                                    <img class="attached-media" src="{{url('public')}}/{{$quiz->attach_media}}">
                                    @endif
                                    @endif
                                </div>
                                @endif 


                                <h5 style="font-weight:bold; font-size:16px">Review</h5>
                                @if(count($reviews))
                                @foreach($reviews as $re)
                                <p class="blockquote blockquote-warning">
                                    <span style="color:#000000;">
                                        <?php echo nl2br($re->comment) ?>
                                    </span>
                                    <br>
								
                                    <span style="font-size:14px; text-align:right"><b>{{$re->assessorn}}</b></span>
                                </p>

                                @endforeach
                                @else
                                <p class="text-center blockquote blockquote-primary" style="">Not Reviewed</p>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade review-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Question Score/Review</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Score</label>
                            <input type="number" name="quiz-grade" step="{{isset($quiz->grade)?($quiz->grade/100):0.1}}" class="form-control" placeholder="" required="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Standard Score</label>
                            <input type="number" value="{{isset($quiz->grade)?($quiz->grade):''}}" class="form-control maxscore" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Review</label>
                            <textarea name="quiz-review" placeholder="" rows="10" required="" style="width:100%;"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary set-grade-review" value="Save"> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade total-review-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">test Review</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Review</label>
                            <textarea name="test-review" placeholder="" rows="10" required="" style="width:100%;"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary set-test-review" value="Save">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@csrf
@endsection

@section('scripts')
<script type="text/javascript">

    @if (auth() -> user() -> isadmin != 2)
    $('.set-test-review,.set-grade-review').hide();
    $('input,textarea').prop('readonly', true);
    @endif

    $('.total-review').click(function () {
        var review = '';
        $.ajax({
        url:'{{url("")}}/admin/review/historyinfo',
                async:false,
                type:'post',
                data:'history_id=' + $('.total-review').attr('_history') + '&_token=' + $('input[name=_token]').val(),
                success:function(r){
                    $('textarea[name=test-review]').val(r);
                    $('.total-review-modal').modal();
                }
        })
    })

    $('.set-test-review').click(function () {
        var param = {
            '_token': $('input[name=_token]').val(),
            'historyId': $('.total-review').attr('_history'),
            'review': $('textarea[name=test-review]').val(),
        };
        $.post('{{url("")}}/admin/review/evaluate', param, function (r) {
            location.reload();
        })
    })

    $('.set-mark-trigger').click(function () {
        $.ajax({
            url: '{{url("")}}/admin/review/historyinfo',
            async: false,
            dataType: 'json',
            type: 'post',
            data: 'history_id=' + $(this).attr('_history') + '&quiz_id=' + $(this).attr('_id') + '&_token=' + $('input[name=_token]').val(),
            success: function (r) {
                if (r['qtype'] * 1 > 2) {
                    $('input[name=quiz-grade]').attr('max', r['grade']).val(r['mark'] ? r['mark'] : r['grade']).prop('readonly', false);
                } else {
                    $('input[name=quiz-grade]').attr('max', r['grade']).val(r['mark'] ? r['mark'] : '0').prop('readonly', true);
                }
                $('.maxscore').val(r['grade']);
                $('textarea[name=quiz-review]').val(r['comment'] ? r['comment'] : '');
                $('.review-modal').modal();
            }
        })

        return;
    });

    $('.set-grade-review').click(function () {
        if ($('input[name=quiz-grade]').val() * 1 > $('input[name=quiz-grade]').attr('max') * 1) {
            swal('This Question grade is maximium ' + $('input[name=quiz-grade]').attr('max'));
            setTimeout(function () {
                $('input[name=quiz-grade]').val($('input[name=quiz-grade]').attr('max')).focus();
            }, 300);
            return false;
        }

        var param = {
            '_token': $('input[name=_token]').val(),
            'historyId': $('.set-mark-trigger').attr('_history'),
            'quiz_id': $('.set-mark-trigger').attr('_id'),
            'grade': $('input[name=quiz-grade]').val(),
            'review': $('textarea[name=quiz-review]').val(),
        };
        $.post('{{url("")}}/admin/review/evaluate', param, function (r) {
            location.reload();
        })
    })

</script>
@endsection