@extends('home._page')

@section('css')
    <link href="{{url('public')}}/front/css/typing.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
@endsection
@section('content')
    <!--========================== Typing Section============================-->
    <div class="divider">&nbsp;</div>
    <div class="container job-apply">
        <div class="row">
            <div class="col-sm-12 col-md-7">
                
                <h2 class="mt-lg text-info">{{$job->name}}</h2>
                <!-- <p class="">{{$job->description}}</p> -->
                <div class="alert alert-info">Please start/stop pressing <i class="fa fa-play"></i> / <i class="fa fa-stop"></i> button in each paragraph.</div>
            </div>
            <div class="col-sm-12 col-md-5 text-right">
                
                <video id="record-cam" autoplay  muted="muted" style="height:100px"></video>
            </div>
        </div>
        
        <hr style="margin-bottom: 40px;">
        
        <div class="typing-body">
        @foreach($quizs as $q)
        
            @if($q->qtype == 1)<!--operator text: speaking-->
            
            <div class="row operator " iid="{{$q->id}}">
                <div class="flag text-warning">
                    <span class="fa fa-microphone"></span>
                    <span class="label label-success">Operator&nbsp;</span>
                    <a class="recording-start"><i class="fa fa-play"></i></a>
                </div>
                <div class="col-sm-12">
                    
                    <div class="text">
                        {{$q->recording_text}}
                    </div>
                </div>
            </div>
            
            @else<!--caller text: typing-->
            
            <div class="row caller" iid="{{$q->id}}">
                <div class="flag text-success">
                    <span class="fa fa-keyboard-o"></span>
                    <span class="label label-danger">Caller&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <a class="typing-start"><i class="fa fa-play"></i></a>
                    <audio src="{{url('public/'.$q->recording_audio)}}"></audio>
                </div>
                <div class="col-sm-12">
                    <textarea class="text form-control" text="{{$q->recording_text}}" style="height:100px;" readonly=""></textarea>
                </div>
            </div>
            
            @endif
        @endforeach
        <div class="row sender-row">
            <div class="col-sm-12 text-center">
                <button onclick="" class="btn btn-default btn-lg goback">Back <i class="fa fa-backward"></i></button>
                <button class="btn btn-success btn-lg sender">Send <i class="fa fa-send"></i></button>
            </div>
        </div>
        </div>
    </div>
    <hr>
    @csrf
@endsection

@section('scripts')
<script src="{{url('public/front/lib/jqueryoverlay/loadingoverlay.min.js')}}"></script>
<script src="{{url('public/front/js/apply.js?v1')}}"></script>
<script>
    var recordingStatus = false;
    var typingResult = {};
    $('a.recording-start').click(function(){
        var rootdiv = $(this).closest('.row');
        if($('.operator.actived,.caller.actived').not('.row[iid='+rootdiv.attr('iid')+']').length){
            Swal.fire('Please complete current things in progress!', '', 'warning');
            return false;
        }
        if(recordingStatus === false){//not initialized yet.
            showOveray("Would start after appeared your camera on the screen!");
            startRecord();
            hideOveray();
            recordingStatus = true
        }
        
        if($('i', this).hasClass('fa-play')){
            
            $('i', this).removeClass('fa-play')
                        .addClass('fa-stop');
            
            $(this).closest('.row.operator').addClass('actived');
        }else if($('i', this).hasClass('fa-stop')){
            
            $('i', this).removeClass('fa-stop')
                        .addClass('fa-check');
            
            $(this).closest('.row.operator').removeClass('actived').addClass('completed');
        }
        
    })
    
    $('a.typing-start').click(function(){
        var audio = $(this).next('audio').get(0),
            textarea = $(this).parent().next().children('.text'),
            rootdiv = $(this).closest('.row');
            
        if($('.operator.actived,.caller.actived').not('.row[iid='+rootdiv.attr('iid')+']').length){
            Swal.fire('Please complete current things in progress!', '', 'warning');
            return false;
        }
            
        if($('i', this).hasClass('fa-play')){
            
            $('i', this).removeClass('fa-play')
                        .addClass('fa-stop');
            
            audio.play();
            rootdiv.addClass('actived');
            textarea.removeAttr('readonly').focus()
        }else if($('i', this).hasClass('fa-stop')){
            
            $('i', this).removeClass('fa-stop')
                        .addClass('fa-check');

            audio.pause();
            rootdiv.removeClass('actived').addClass('completed');
            
            var re = typingEvaluate(textarea.attr('text'), textarea.val())
            
            textarea.remove();
            
            $('div.col-sm-12', rootdiv).append('<div class="form-control">' + re.evaluated + '</div>');
            
            typingResult[rootdiv.attr('iid')] = re;
        }
    })
    
    $('.sender').click(function(){
        var ok = true;
        $('.operator,.caller').each(function(i,obj){
            if(!$(obj).hasClass('completed')){
                ok = false;
            }
        })
        
        if(!ok){
            Swal.fire('There are incomplete things. Please complete them.','','warning');
            return false;
        }
        
        showOveray("Sending result. Please wait...");
        stopAll();
        
        $('.sender').hide();
        const blob = recordedBlobs ? new Blob(recordedBlobs, {type: 'video/webm'}) : '';

        var formData = new FormData();
        formData.append('jobid', _jobid);
        formData.append('recordFile', blob);
        formData.append('typingResult', JSON.stringify(typingResult));
        formData.append('_token', $('input[name="_token"').val());

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            hideOveray();
            if (request.readyState == 4) {
                if(request.status == 200){
                    Swal.fire('Successfully sent!', 'we will send a message for your request.', 'success');
                }else{
                    Swal.fire('Sending failed!', 'Occurred some errors in sending data. please retry after a while.', 'error');
                }
            }
        };
        request.open('POST', BASE_URL + '/jobs/saveapply');
        request.send(formData);
    })
    
    function typingEvaluate(valid, typed){
        var valid = parseWords(valid);
        var typed = parseWords(typed);
        var _evaluated = [];
        var correctCount = 0;
        var typoCount = 0;
        var a = {};
        
        valid.map(function (tx, i) {
            if (typed[i]) {

                if (tx == typed[i]) {
                    _evaluated.push(typed[i]);
                    correctCount++
                } else {
                    _evaluated.push('<strike style="color:red">' + typed[i] + '</strike>');
                    typoCount++
                }
            }
        })
        
        a.text = typed.join(' ')
        a.evaluated = _evaluated.join(' ')
        a.typo = typoCount
        a.accuracy = Number(correctCount / valid.length * 100).toFixed(1)
        
        return a;
    }
    function parseWords(s){
        return s.replace(/(^\s*)|(\s*$)/gi,"")
                .replace(/[ ]{2,}/gi," ")
                .replace(/\n /,"\n")
                .split(' ')
    }
    
    function showOveray(msg){
        $.LoadingOverlay("show");
    }

    function hideOveray(){
        $.LoadingOverlay("hide");
    }

    var _jobid = {{$job->id}}
    
    
</script>
@endsection