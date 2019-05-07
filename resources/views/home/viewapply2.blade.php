@extends('home._page')

@section('css')
    <link href="{{url('public')}}/front/css/typing.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" />
    <style>
        #myModal .modal-content{
            width: 565px;
        }
        .caller .result{
            position: absolute;
            right:0;
            top:-30px;
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
                <!--<p class="">{{$job->description}}</p>-->
            </div>
            <div class="col-sm-12 col-md-5 text-right">
                <a href="#myModal" class="btn btn-info " data-backdrop="false" data-toggle="modal">Captured Video</a>
            </div>
        </div>
        
        <hr style="margin-bottom: 40px;">
        
        <div class="typing-body">
        <?php $typingResult = json_decode($apply->apply_result, true);?>
        @foreach($quizs as $q)
        
            @if($q->qtype == 1)<!--operator text: speaking-->
            
            <div class="row operator completed" iid="{{$q->id}}">
                <div class="flag text-warning">
                    <span class="fa fa-microphone"></span>
                    <span class="label label-success">Operator&nbsp;</span>
                </div>
                <div class="col-sm-12">
                    
                    <div class="text">
                        {{$q->recording_text}}
                    </div>
                </div>
            </div>
            
            @else<!--caller text: typing-->
            
            <div class="row caller completed" iid="{{$q->id}}">
                <div class="flag text-success">
                    <span class="fa fa-keyboard-o"></span>
                    <span class="label label-danger">Caller&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <a class="typing-start"><i class="fa fa-play"></i></a>
                    <audio src="{{url('public/'.$q->recording_audio)}}"></audio>
                </div>
                <label class="result">
                    <span class="alert alert-warning" style="padding:2px 5px;">
                    <?php echo $typingResult[$q->id]?('Typo: '. $typingResult[$q->id]['typo']):''?>, 
                    <?php echo $typingResult[$q->id]?('Accuracy: '. $typingResult[$q->id]['accuracy']*1):''?>
                    </span>
                </label>
                <div class="col-sm-12">
                    <div class="text form-control" ><?php echo $typingResult[$q->id]?$typingResult[$q->id]['evaluated']:''?></div>
                </div>
            </div>
            
            @endif
        @endforeach
        </div>
        <hr>
        
        <div class="text-center">
            <button onclick="history.back()" class="btn btn-default btn-lg"><i class="fa fa-backward"></i> Back</button>
        </div>
        
        <div id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="cursor:move;">
                        <h4 class="modal-title">Captured Video</h4>  
                        <i class="fa fa-arrows-alt"></i>
                    </div>
                    <div class="modal-body">
                      <div class="comment">
                        <video id="record-cam" controls src="{{url('public/' . $apply->capture_file)}}" style="height:400px;width:100%;"></video>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        
    </div>    
    @csrf
@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script>
    $('a.typing-start').click(function(){
        var audio = $(this).next('audio').get(0);

        if($('i', this).hasClass('fa-play')){

            $('i', this).removeClass('fa-play')
                        .addClass('fa-stop');

            audio.play();
        }else if($('i', this).hasClass('fa-stop')){

            $('i', this).removeClass('fa-stop')
                        .addClass('fa-play');

            audio.pause();
        }
    })
        $("#myModal,#chatModal").draggable({
        handle: ".modal-header"
    });
</script>
@endsection