@extends('layouts.page')
@section('css')
<link rel="stylesheet" href="{{url('public/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />
<style>
    .panel img{
        width: 35px;
        height:35px; 
        margin-right:10px;}
    .image-trigger{ 
        position:relative;
        cursor: pointer;
        color:#fff;
        margin: 10px auto;
        width: 100px;
        padding: 5px 20px;
        display: inline-block;
        background: #f96332;
        border-radius: 5px;}
    #preview_image{
        width: 100%;
        visibility: hidden;
        position: absolute;
        left:0;
        top:0;}

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
        padding-left: 25px;    }
</style>
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">Assessors</h4>
            </div>
            <div class="panel-body">
                <div class="btn-bar">
                    <button class="btn btn-primary create-assessor" data-toggle="modal" data-target=".assessor-modal">Create New Assessor <i class="fa fa-plus"></i></button>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="">
                        <th>S.No</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Phone</th>
                        <th class="text-center">Action</th>
                        </thead>
                        <tbody>
                            @foreach($list as $i=>$q)
                            <tr>
                                <td>{{$i+1}}</td>
                                <td><img src="{{url('public')}}/{{!empty($q->photo)?$q->photo:'app/assessor/user.jpg'}}"><nobr>{{$q->name}}</nobr></td>
                                <td>{{$q->email}}</td>
                                <td>{{$q->phone}}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <nobr>
                                        <button class="btn btn-sm btn-default update-trigger" _iid="{{$q->id}}"  data-toggle="modal" data-target=".assessor-modal"><i class="fa fa-edit"></i> </button>
                                        <button class="btn btn-sm btn-default delete-trigger" _iid="{{$q->id}}"><i class="fa fa-trash"></i> </button>
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

<div class="modal fade assessor-modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Assessor</h5>
            </div>
            <div class="modal-body">
                <form id="create-assessor-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="assessor_id">

                    <div class="row">
                        <div class="col-sm-12 col-md-3 text-center">
                            <img id="userimg" src="{{url('public')}}/app/assessor/user.jpg" style="width:100%;">
                            <label class="image-trigger">
                                Image
                                <input id="preview_image" name="preview_image" type="file" accept="image/*">
                                <!--<code>Choose an assessor preview image.(300 X 200 pixel)</code>-->
                            </label>
                        </div>
                        <div class="col-sm-12 col-md-9">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input type="email" name="email" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="orderinfo" class="form-control" placeholder="" required=""></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="new_password" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Create" form="create-assessor-form">
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
<script type="text/javascript">
var Table = $('.table').dataTable({
    "dom": '<"top"lf>t<"bottom"pi><"clear">',
    select: true,
    language: {
        searchPlaceholder: "Search "
    }
});
$('.update-trigger').click(function (e) {
    $('#create-assessor-form').trigger('reset');
    $('.assessor-modal .modal-title').text('Update Assessor');
    $('.assessor-modal input[type="submit"]').val('Update');
    $('#create-assessor-form img').attr('src', $('img', $(this).parent().parent()).attr('src'));
    $('#create-assessor-form input[name="assessor_id"]').val($(this).attr('_iid'));
    $('#create-assessor-form input[name="name"]').val($(this).closest('tr').children('td:nth-child(2)').text());
    $('#create-assessor-form input[name="email"]').val($(this).closest('tr').children('td:nth-child(3)').text());
    $('#create-assessor-form input[name="phone"]').val($(this).closest('tr').children('td:nth-child(4)').text());
    $('#create-assessor-form textarea[name="orderinfo"]').val($('textarea[_iid=' + $(this).attr('_iid') + ']').val());
});

$('.create-assessor').click(function (e) {
    $('.assessor-modal .modal-title').text('Create Assessor');
    $('.assessor-modal input[type="submit"]').val('Create');
    $('#create-assessor-form input[name="assessor_id"]').val('');
    $('#userimg').attr('src', '{{url("public")}}/app/assessor/user.jpg');
    $('#create-assessor-form').trigger('reset');
});

$('#preview_image').change(function () {
    var input = this;
    var url = $(this).val();
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
    {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#userimg').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    } else
    {
        $('#userimg').attr('src', '{{url("public")}}/app/assessor/user.jpg');
    }
});
$('.delete-trigger').click(function () {
    var id = $(this).attr('_iid');
    Swal.fire({
        title: 'Are you sure?',
        text: "Are you want to delete this assessor?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value && result.value===true) {
            $.post('{{url("")}}/admin/assessor/remove', {'id': id, _token: $('input[name=_token]').val()}, function (r) {
                Swal.fire(
                  'Deleted!',
                  'The assessor has been deleted.',
                  'success'
                ).then(()=>{
                    location.reload();
                    
                })
            })
        }
      })
})

$('#create-assessor-form').submit(function () {
    if ($('input[name=new_password]').val() != $('input[name=confirm_password]').val()) {
        swal('Password Mismatch');
        return false;
    }

    if (!validateEmail($('input[name=email]').val())) {
        swal('Invalid Email Address!');
        return false;
    }
    if (!validatePhone($('input[name=phone]').val())) {
        swal('Invalid Phone Number!');
        return false;
    }
    var re = true;
        $.ajax({
            'url': '{{url("")}}/admin/assessor/emailcheck',
            'async': false,
            'type': 'post',
            'data':'email=' + $('input[name=email]').val()+'&id='+$('input[name=assessor_id]').val()+'&_token='+$('input[name=_token]').val(),
            'success': function (r) {
                if (r != 'ok') {
                    swal('An equal email registered aleady!');
                    $('input[name=email]').prop('focus');
                    re = false;
                }
            },
            'error': function (r) {
                re = false;
            }
        })
      return re;

    return true;
})
</script>
@endsection