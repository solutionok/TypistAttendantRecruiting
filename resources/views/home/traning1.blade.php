@extends('home._page')
@section('css')
    <link href="{{url('public')}}/front/css/typing.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    
    <style>
        .watch-bar{
            padding-bottom: 20px;
            font-size: 20px;
        }
        
        .typing-trigger{
            font-weight: bold;
            margin-right:20px;
        }
        
        .marker{
            display: inline-block;
            padding: 8px 20px;
            background-color: #fffccc;
            border-radius: 10px;
            border: solid 1px #50a22b;
                margin-right: 20px;
        }
        
        .record-trigger{
            font-weight: bold;
            margin-left:20px;
        }
        
        .text-container{
            height: 350px;
            overflow: auto;
            border: solid 1px #50a22b;
            padding: 10px;
            font-size: 22px;
            border-radius: 10px;
            margin-bottom: 20px;
            user-select: none; /* supported by Chrome and Opera */
            -webkit-user-select: none; /* Safari */
            -khtml-user-select: none; /* Konqueror HTML */
            -moz-user-select: none; /* Firefox */
            -ms-user-select: none; /* Internet Explorer/Edge */
        }
        #type-box{
            padding: 10px 100px;
            font-size: 26px;
            display: none;
        }
    </style>
@endsection
@section('content')
    <!--========================== Typing Section============================-->
    <div class="divider">&nbsp;</div>
    <div class="container job-apply">
        <div class="row">
            <div class="col-sm-12 col-md-7">
                <h2 class="mt-lg text-info">{{$job->name}}</h2>
                <div class="alert alert-info">Please complete typing test and recording. use <i class="fa fa-play"></i> / <i class="fa fa-stop"></i> buttons for start/stop</div>
            </div>
            <div class="col-sm-12 col-md-5 text-right">
                <video id="record-cam" autoplay  muted="muted" style="height:100px"></video>
                <a href="#chatModal" class="btn btn-info " data-backdrop="false" data-toggle="modal" style="margin-bottom:20px;">Chart View</a>
            </div>
        </div>
        
        <hr style="margin-bottom: 40px;">
        
        <div class="typing-body">
        @foreach($quizs as $q)
        
            <div class="row caller">
                <div class="col-sm-12">
                    <div class="watch-bar">
                        <a href="javascript:;" class="typing-trigger">1. Typing Test <i class="fa fa-play"></i></a>
                        Time <span class="marker time">00:00</span>
                        Typo <span class="marker typo">0</span>
                        Accuracy <span class="marker accuracy">0</span>
                        
                        <a href="javascript:;" class="record-trigger">2. Recording Text <i class="fa fa-play"></i></a>
                    </div>
                    <div class="text-container">
                        {{$q->recording_text}}
                    </div>
                    <input type="text" id="type-box" class="form-control text-center" placeholder="Type here...">
                    <input type="hidden" id="correct-text" value="{{$q->recording_text}}">
                </div>
            </div>
            
        @endforeach
        <div class="row sender-row">
            <div class="col-sm-12 text-center">
                <button onclick="history.back()" class="btn btn-default btn-lg goback">Back <i class="fa fa-backward"></i></button>
                <button class="btn btn-success btn-lg evaluate">Evaulate <i class="fa fa-check"></i></button>
            </div>
        </div>
        </div>
    </div>
    
    <hr>
        
    <div id="chatModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="cursor:move;">
                    <h4 class="modal-title">Captured Video</h4>  
                    <i class="fa fa-arrows-alt"></i>
                </div>
                <div class="modal-body">
                    <canvas id="myChart" style="width:100%;height:400px;"></canvas>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @csrf
@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="{{url('public/front/lib/jqueryoverlay/loadingoverlay.min.js')}}"></script>
<script src="{{url('public/front/js/apply.js?v1')}}"></script>
<script>
    var recordingStatus = false;
    var typingResult = {};
    var timeTracker = null;
    var timeCount = 0;
    
    $('.typing-trigger').click(function(){
        if(undefined == typingResult['started']){
            $('#type-box').show().focus();
            typingResult.recording_text = $('#correct-text').val()
            timeTracker = setInterval(function(){
                $('.time').text(tf(timeCount++))
                typingResult.time = $('.time').text()
            }, 1000)
        }
        typingResult.started = true;
    })
    
    document.getElementById('type-box').onpaste = function(e) {
        e.preventDefault();
    }
    document.getElementById('type-box').oncopy = function(e) {
        e.preventDefault();
    }
    
    $('#type-box').keypress(function(e){
        typeEvent(e)
    }).keydown((e)=>{
        typeEvent(e)
    }).keyup((e)=>{
        typeEvent(e)
    })
    
    $('a.record-trigger').click(function(){
        if(undefined == typingResult['finished']){
            Swal.fire('Please complete typing test!', '', 'warning');
            return false;
        }
        
        if(recordingStatus === false){//not initialized yet.
            showOveray("Would start after appeared your camera on the screen!");
            startRecord();
            hideOveray();
            recordingStatus = true
            
            $('i', this)
                    .removeClass('fa-play')
                    .addClass('fa-stop');
            
            typingResult.recordingStarted = true;
        }else if(recordingStatus === true){//recording now. should be finish recording
            $('i', this)
                    .removeClass('fa-stop')
                    .addClass('fa-check');
            
            $(this)
                    .css('color', '#28a745')
                    .css('cursor', 'text');
            
            typingResult.recordingCompleted = true;
            stopAll();
        }
    })
    
    $('.evaluate').click(function(){
        if(undefined == typingResult['finished']){
            Swal.fire('Please complete typing test!', '', 'warning');
            return false;
        }
        
        if(undefined == typingResult['recordingStarted']){
            Swal.fire('Please complete recording!', '', 'warning');
            return false;
        }
        
        $('.typing-trigger, .record-trigger')
                .css('color', '#28a745')
                .css('cursor', 'text');

        $('.typing-trigger i, .record-trigger i')
                .removeClass('fa-play')
                .removeClass('fa-stop')
                .addClass('fa-check');
        
        showOveray("Sending result. Please wait...");
        stopAll();
        
        $('.evaluate').hide();
        
        const blob = recordedBlobs ? new Blob(recordedBlobs, {type: 'video/webm'}) : '';
        
        var formData = new FormData();
        formData.append('jobid', _jobid);
        formData.append('recordFile', blob);
        formData.append('typingResult', JSON.stringify(typingResult));
        formData.append('_token', $('input[name="_token"').val());

        var request = new XMLHttpRequest();
        request.onreadystatechange = function (res) {
            hideOveray();
            if (request.readyState == 4) {
                if(request.status == 200){
                    location.href = BASE_URL + '/jobs/traningresult?id=' + this.responseText;
                }else{
                    Swal.fire('Evaluating failed!', 'Occurred some errors in evaluating.', 'error');
                }
            }
        };
        request.open('POST', BASE_URL + '/jobs/savetraning');
        request.send(formData);
    })
    
    function typeEvent(e){
        var re = typingEvaluate(e, $('#correct-text').val(), $('#type-box').val())

        $('.text-container').html(re.evaluated)
        $('.watch-bar .accuracy').text(re.accuracy)
        $('.watch-bar .typo').text(re.typo)
        
        if(re.finished){
            $('#type-box').hide();
            
            $('.typing-trigger')
                    .css('color', '#28a745')
                    .css('cursor', 'text');
            
            $('.typing-trigger i')
                    .removeClass('fa-play')
                    .addClass('fa-check');
            
            typingResult = Object.assign(typingResult, re);
            clearInterval(timeTracker);
            Swal.fire('Typing test finished! Please start recording.', '', 'success');
        }
    }
        
    function typingEvaluate(e, valid, typed){
        
        var valid = parseWords(valid);
        var typed = parseWords(typed);
        var _evaluated = [];
        var correctCount = 0;
        var typoCount = 0;
        var a = {};
        
        valid.map(function (tx, i) {
            if (typed[i]) {

                if (tx == typed[i]) {
                    _evaluated.push('<span style="color:#28a745">' + typed[i] + '</span>');
                    correctCount++
                } else {
                    _evaluated.push('<strike style="color:red">' + typed[i] + '</strike>');
                    typoCount++
                }
            }else{
                _evaluated.push(tx);
            }
        })
        
        a.text = typed.join(' ')
        a.evaluated = _evaluated.join(' ')
        a.typo = typoCount
        a.accuracy = Number(correctCount / valid.length * 100).toFixed(1)
        
        if(typed.length == valid.length && (valid.pop() == typed.pop() || $('#type-box').val().substr(-1)==' ' || e.keyCode == 13)){
            a.finished = typed.length == valid.length;
        }
        
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
    
    function tf(s){
        if (s > 59){
            return Math.floor(s / 60) + ' : ' + (s % 60 > 9 ? s % 60:('0' + s % 60));
        }

        return '00 : ' + (s % 60 > 9?s % 60:('0' + s % 60));
    }
    var _jobid = {{$job->id}}
    
    
    $("#myModal,#chatModal").draggable({
        handle: ".modal-header"
    });
    window.chartColors = {
	red: 'rgb(255, 99, 132)',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: 'rgb(75, 192, 192)',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)'
    };
    var color = Chart.helpers.color;
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',

        data: {
            datasets: [{
                label: 'Accuracy',
                data: <?php echo json_encode($logs['accuracy']) ;?>,
                backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString()
            }, {
                label: 'Typo',
                data: <?php echo json_encode($logs['typos']) ;?>,
                type: 'line',
                backgroundColor: color(window.chartColors.orange).alpha(0.5).rgbString()
            }],
            labels: <?php echo json_encode($logs['dates']) ;?>
        },
        options:{
            color:'#DF367C'
        }
    });

</script>
@endsection