 @extends('layouts.page')
@section('css')
<link href="{{url('public')}}/plugins/chosen_v1.8.7/chosen.min.css" rel="stylesheet" >
<link rel="stylesheet" href="{{url('public')}}/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
<style>
    .panel img{width: 20px;height:20px; margin-right:10px;}
    
    .header .search{
        width: auto!important;
    }
    @media only screen and (max-width: 900px){
        .header .search {
            display: none;
        }
    }
    .table-responsive {
        margin-top: 10px;
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
</style>
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">Applied applicants</h4>
            </div>
            <div class="panel-body">
                @if(isAssessor())
                <div class="btn-bar">
                    Checked Applicants   
                    <!--<button type="button" onclick="downToCSV()" class="mb-xs mt-xs mr-xs btn btn-success " >Export </button>-->
                    <button onclick="blukInvit()" class="btn btn-info">Invite <i class="fa fa-send"></i></button>
                    <button onclick="blukReject()" class="btn btn-warning">Reject <i class="fa fa-ban"></i></button>
                    <button onclick="blukDelete()" class="btn btn-danger">Delete request <i class="fa fa-trash"></i></button>
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <th><input type="checkbox" class="checked-applicant-all"></th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Phone</th>
                        <th>Job</th>
                        <th>Applied Date</th>
                        <th>Invite/Reject Status</th>
                        <th class="text-center">Action</th>
                        </thead>
                        <tbody>
                            @foreach($list as $i=>$q)
                            <tr>
                                <td style="vertical-align: middle;"><input type="checkbox" class="checked-applicant" value="{{$q->id}}" appid="{{$q->id}}"></td>
                                <td style="min-width: 120px;">
                                    <a href="{{url('')}}/admin/applicant/view?id={{$q->id}}">{{$q->name}}
                                    </a>
                                </td>
                                <td>{{$q->email}}</td>
                                <td>{{$q->phone}}</td>
                                <td>{{$q->jobn}}</td>
                                <td>{{LT2IT($q->created_at)}}</td>
                                <td>
                                    @if($q->passed==1)
                                    <span class="label label-success">Invited</span> {{LT2IT($q->pass_date)}}
                                    @elseif($q->passed==-1)
                                    <span class="label label-default">Rejected</span> {{LT2IT($q->pass_date)}}
                                    @else
                                    --
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <nobr>
                                        <a class="btn btn-default btn-sm" href="{{url('')}}/admin/applicant/view?id={{$q->id}}" title="Review"><i class="fa fa-edit"></i> </a>
                                        
                                        @if(isAssessor())
                                        <button class="btn btn-default btn-sm delete-trigger" _iid="{{$q->id}}" title="Remove"><i class="fa fa-trash"></i> </button>
                                        <button class="btn btn-default btn-sm invitemail-trigger" _iid="{{$q->id}}" title="Invite"><i class="fa fa-send"></i> </button>
                                        <button class="btn btn-default btn-sm rejectemail-trigger" _iid="{{$q->id}}" title="Reject"><i class="fa fa-ban"></i> </button>
                                        @endif
                                        </nobr>
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
<iframe id="hidden-frame" name="hidden-frame" style="display: none"></iframe>
<form id="import-form" name="import-form" method="post" enctype="multipart/form-data" action="{{url('')}}/admin/applicant/bulkadd" target="hidden-frame" style="display:none;">
    @csrf
    <input name="bulkadd" id="bulkadd" type="file" accept=".csv">
</form>
@endsection

@section('scripts')
<script src="{{url('public')}}/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="{{url('public')}}/assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="{{url('public')}}/assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
<script src="{{url('public')}}/plugins/chosen_v1.8.7/chosen.jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">

$('#test_id,#assessor_id').chosen()
var Table = $('.table').dataTable({
    "columnDefs": [
        { "orderable": false, "targets": 0 },
        { "orderable": false, "targets": 4 },
        { "orderable": false, "targets": 5 },
      ]
    ,  
    "dom": '<"top"lf>t<"bottom"pi><"clear">',
    select: true,
    language: {
        searchPlaceholder: "Search "
    }
});
$('.delete-trigger').click(function () {
    var id = $(this).attr('_iid');
    Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to delete this applicant?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value && result.value===true) {
            $.post('{{url("")}}/admin/applicant/delete', {'id': id, _token: $('input[name=_token]').val()}, function (r) {
                Swal.fire(
                  'Deleted!',
                  'The applicant has been deleted.',
                  'success'
                ).then(()=>{
                    location.reload();
                })
            })
        }
    })
});

function bulkResult(re) {
    swal(re, function(){
        location.reload();
    });
}
$('.checked-applicant-all').click(function(){
    $('.checked-applicant').prop('checked', this.checked)
})

function downToCSV(){
    if(!$('.checked-applicant:checked').length){
        swal('Please check the applicants you want to donwload');
        return;
    }
    
    var ids = [];
    $('.checked-applicant:checked').each(function(i, el){
        ids.push(el.value);
    });
    $('#hidden-frame').attr('src', '{{url("")}}/admin/applicant/downcsv?ids=' + ids);
}

function blukDelete(){
    if(!$('.checked-applicant:checked').length){
        swal('Please check the applicants you want to delete','','warning');
        return;
    }
    
    Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to delete checked applicants?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value && result.value===true) {
            var ids = [];
            $('.checked-applicant:checked').each(function(i, el){
                ids.push(el.value);
            });
            
            $.post('{{url("")}}/admin/applicant/delete', {_token:$('input[name=_token]').val(),id:ids}, function(r){
                Swal.fire(
                  'Deleted!',
                  'The recording has been deleted.',
                  'success'
                ).then(()=>{
                    location.reload();
                })
            })
        }
      })
    
}

function blukInvit(){
    var ids = [];
    $('.checked-applicant:checked').each(function(i, el){
        ids.push($(el).attr('appid'));
    });
    
    if(!ids.length){
        swal('Please check the applicants you want to invite','','warning');
        return;
    }
    $.get('{{url("")}}/admin/applicant/invitmailbluk?ids=' + ids.join(','), function(r){
        Swal.fire(
          'Invited!',
          '',
          'success'
        )
    })
}

function blukReject(){
    var ids = [];
    $('.checked-applicant:checked').each(function(i, el){
        ids.push($(el).attr('appid'));
    });
    if(!ids.length){
        swal('Please check the applicants you want to reject','','warning');
        return;
    }
    
    $.get('{{url("")}}/admin/applicant/rejectmailbluk?ids=' + ids.join(','), function(r){
        Swal.fire(
          'Rejected!',
          '',
          'success'
        )
    })
}

$('.invitemail-trigger').click(function(){
    var applicantId = $(this).attr('_iid')
    $.get('{{url("")}}/admin/applicant/invitmail/' + applicantId, function(r){
        Swal.fire(
          'Invited!',
          '',
          'success'
        )
    })
})
$('.rejectemail-trigger').click(function(){
    var applicantId = $(this).attr('_iid')
    $.get('{{url("")}}/admin/applicant/rejectmail/' + applicantId, function(r){
        Swal.fire(
          'Rejected!',
          '',
          'success'
        )
    })
})
</script>
@endsection