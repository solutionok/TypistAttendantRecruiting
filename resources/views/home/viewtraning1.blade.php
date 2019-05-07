@extends('home._page')

@section('css')
    <link href="{{url('public')}}/front/css/typing.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" />
    <style>
        #myModal .modal-content{
            width: 565px;
        }
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
            </div>
            <div class="col-sm-12 col-md-5 text-right">
                <a href="#myModal" class="btn btn-info " data-backdrop="false" data-toggle="modal">Captured Video</a>
                <a href="#chatModal" class="btn btn-info " data-backdrop="false" data-toggle="modal">Chart View</a>
            </div>
        </div>
        
        <hr style="margin-bottom: 40px;">
        
        <div class="typing-body">
        <?php $q = json_decode($apply->apply_result, true);?>
        <div class="row caller">
            <div class="col-sm-12">
                <div class="watch-bar">
                    <a href="javascript:;" class="typing-trigger">1. Typing Test <i class="fa fa-play"></i></a>
                    Time <span class="marker time">{{!empty($q['time'])?$q['time']:'00:00'}}</span>
                    Typo <span class="marker typo">{{!empty($q['typo'])?$q['typo']:'0'}}</span>
                    Accuracy <span class="marker accuracy">{{!empty($q['accuracy'])?$q['accuracy']:'0'}}</span>

                    <a href="javascript:;" class="record-trigger">2. Recording Text <i class="fa fa-check"></i></a>
                </div>
                <div class="text-container">
                    <?php echo !empty($q['evaluated']) ? $q['evaluated'] : ''?>
                </div>
            </div>
        </div>
        </div>
        <hr>
        
        <div class="text-center">
            <button onclick="location.href='{{url('/jobs')}}'" class="btn btn-info"><i class="fa fa-search"></i> Search job</button>
            <button onclick="location.href='{{url('/jobs/traning?j=' . $job->id)}}'" class="btn btn-danger"><i class="fa fa-repeat"></i> Try again</button>
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
                        <button type="button" class="btn btn-default video-close" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<script>
    $('.video-close').click(function(){
        $('#record-cam').get(0).pause()
    })
    
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