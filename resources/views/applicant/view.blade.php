@extends('layouts.page')
<link href="{{url('public')}}/assets/stylesheets/applicant.css" rel="stylesheet">
<style>
    #myModal .modal-content{
        width: 565px;
    }
    
    .text{height: auto!important;}
    .caller .result{
        position: absolute;
        right:0;
        top:-30px;
    }

    .button-box{
        position: absolute;
        top: 0px;
        right: 15px;
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
@section('css')
<!--vue cdn link-->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
@endsection
@section('content')
<!--========================== Typing Section============================-->
<div class="wow fadeInUp">
    <div class="panel">
        <div class="panel-heading">
            @csrf
            <h4 class="panel-title">{{$job->name}}</h4>
        </div>

        <div id="apply_online" class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="tabs tabs-primary">
                        <ul class="nav nav-tabs info ">
                            <li class="active">
                                <a href="#applicant_infomation" data-toggle="tab" aria-expanded="true"><i class="fa fa-star"></i> Applicant Infomation</a>
                            </li>
                            <li class="">
                                <a href="#applied_test" data-toggle="tab" aria-expanded="false">Applied Test</a>
                            </li>
                            <li class="">
                                <a href="{{url('public'.$applicantInfo->resume_file)}}" target="_blank">Resume</a>
                            </li>
                        </ul>
                        @if(isAssessor())
                        <div class="button-box">
                            <button class="btn btn-info btn-sm invitemail-trigger" _iid="{{$apply->id}}" title="Invite"><i class="fa fa-send"></i> Invite</button>
                            <button class="btn btn-warning btn-sm rejectemail-trigger" _iid="{{$apply->id}}" title="Reject"><i class="fa fa-ban"></i> Reject</button>
                            <button class="btn btn-danger btn-sm delete-trigger" _iid="{{$apply->id}}" title="Remove"><i class="fa fa-trash"></i> Remove</button>
                        </div>
                        @endif
                        <div class="tab-content">
                            <div id="applicant_infomation" class="tab-pane active">
                                <h3 class="block-title">Account Information</h3>
                                <hr>
                                <div class="form-group row">

                                    <label class="col-sm-6 col-lg-2 col-form-label">Email Address</label>
                                    <div class="col-sm-6 col-lg-3">
                                        <input v-model="personal.email" class="form-control">
                                    </div>

                                    <label class="col-sm-6 col-lg-2 col-form-label">Phone Number</label>
                                    <div class="col-sm-6 col-lg-3">
                                        <input v-model="personal.phone" class="form-control">
                                    </div>
                                </div>
                                <hr>

                                <h3 class="block-title">Applicants may be tested for illegal drugs</h3>
                                <table class="table table-bordered ">
                                    <tr>
                                        <td>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">First Name</label>
                                                <div class="col-sm-2">
                                                    <input v-model="offerinfo.main.firstname" type="text" class="form-control">
                                                </div>
                                                <label class="col-sm-2 col-form-label">Middle Name</label>
                                                <div class="col-sm-2">
                                                    <input v-model="offerinfo.main.middlename" type="text" class="form-control">
                                                </div>
                                                <label class="col-sm-2 col-form-label">Last Name</label>
                                                <div class="col-sm-2">
                                                    <input v-model="offerinfo.main.lastname" type="text" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Date</label>
                                                <div class="col-sm-3">
                                                    <input v-model="offerinfo.main.date" type="text" class="form-control">
                                                </div>
                                                <label class="col-sm-2 col-form-label">SSN</label>
                                                <div class="col-sm-3">
                                                    <input v-model="offerinfo.main.ssn" type="text" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Present Address</label>
                                                <div class="col-sm-3">
                                                    <input v-model="offerinfo.main.present_address" type="text" class="form-control">
                                                </div>
                                                <label class="col-sm-1 col-form-label">Apt</label>
                                                <div class="col-sm-2">
                                                    <input v-model="offerinfo.main.apt" type="text" class="form-control">
                                                </div>
                                                <label class="col-sm-1 col-form-label">City</label>
                                                <div class="col-sm-3">
                                                    <input v-model="offerinfo.main.city" type="text" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Telephone No</label>
                                                <div class="col-sm-4">
                                                    <input v-model="offerinfo.main.telephone_no" type="text" class="form-control">
                                                </div>
                                                <label class="col-sm-4 col-form-label">How long at present address</label>
                                                <div class="col-sm-2">
                                                    <input v-model="offerinfo.main.howlong_addr" type="text" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">If age is under 18, please write the age</label>

                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input v-model="offerinfo.main.age18" value="1" type="radio"> 
                                                            Yes
                                                        </label>
                                                        <label class="form-check-label" style="margin-left:20px;padding-top: 8px;">
                                                            <input v-model="offerinfo.main.age18" value="0" type="radio"> 
                                                            No
                                                        </label>
                                                    </div>
                                                </div>


                                                <label class="col-sm-2 col-form-label" v-if="offerinfo.main.age18==1">Age</label>
                                                <div class="col-sm-2" v-if="offerinfo.main.age18==1">
                                                    <input v-model="offerinfo.main.detail_age" type="number" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Position Applied for</label>
                                                <div class="col-sm-4">
                                                    <input v-model="offerinfo.main.position_for" type="text" class="form-control">
                                                </div>

                                                <label class="col-sm-2 col-form-label">Full time</label>

                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input v-model="offerinfo.main.is_fulltime" value="1" type="radio"> 
                                                            Yes
                                                        </label>
                                                        <label class="form-check-label" style="margin-left:20px;padding-top: 8px;">
                                                            <input v-model="offerinfo.main.is_fulltime" value="0" type="radio"> 
                                                            No
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Date you are available to start</label>
                                                <div class="col-sm-4">
                                                    <input v-model="offerinfo.main.date_start"  class="form-control">
                                                </div>

                                                <label class="col-sm-2 col-form-label">Part time</label>

                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input v-model="offerinfo.main.is_parttime" value="1" type="radio"> 
                                                            Yes
                                                        </label>
                                                        <label class="form-check-label" style="margin-left:20px;padding-top: 8px;">
                                                            <input v-model="offerinfo.main.is_parttime" value="0" type="radio"> 
                                                            No
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Have you ever been arrested</label>

                                                <div class="col-sm-2">
                                                    <label class="form-check-label">
                                                        <input v-model="offerinfo.main.arrested" value="1" type="radio"> 
                                                        Yes
                                                    </label>
                                                    <label class="form-check-label" style="margin-left:20px;padding-top: 8px;">
                                                        <input v-model="offerinfo.main.arrested" value="0" type="radio"> 
                                                        No
                                                    </label>
                                                </div>

                                                <label class="col-sm-4 col-form-label">Have you ever been convicted of a crime?</label>

                                                <div class="col-sm-2">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input v-model="offerinfo.main.crime" value="1" type="radio"> 
                                                            Yes
                                                        </label>
                                                        <label class="form-check-label" style="margin-left:20px;padding-top: 8px;">
                                                            <input v-model="offerinfo.main.crime" value="0" type="radio"> 
                                                            No
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label">If yes either of the above, explain the number of covictins/arrests and the nature of each offense, include dates of each and the sentence imposed</label>
                                                <div class="col-sm-12">
                                                    <textarea v-model="offerinfo.main.crime_detail" class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Do yo have a driver's license?</label>

                                                <div class="col-sm-2">
                                                    <label class="form-check-label">
                                                        <input v-model="offerinfo.main.driver_license" value="1" type="radio"> 
                                                        Yes
                                                    </label>
                                                    <label class="form-check-label" style="margin-left:20px;padding-top: 8px;">
                                                        <input v-model="offerinfo.main.driver_license" value="0" type="radio"> 
                                                        No
                                                    </label>
                                                </div>

                                                <label class="col-sm-2 col-form-label">State of issue</label>
                                                <div class="col-sm-5">
                                                    <select v-model="offerinfo.main.state_of_issue" class="form-control">
                                                        <option value="">Please select</option>
                                                        <option>A</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label">What is you means of transportation to and from work?</label>
                                                <div class="col-sm-7">
                                                    <select v-model="offerinfo.main.transportation" class="form-control">
                                                        <option>Own car</option>
                                                        <option>Friend/relative</option>
                                                        <option>Taxi/Uber/Lyft</option>
                                                        <option>Bus</option>
                                                        <option>Horse</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-6 col-form-label">Have you had any accidents or moving vioations in the past 3 years?</label>

                                                <div class="col-sm-2">
                                                    <label class="form-check-label">
                                                        <input v-model="offerinfo.main.accident_violation" value="1" type="radio"> 
                                                        Yes
                                                    </label>
                                                    <label class="form-check-label" style="margin-left:20px;padding-top: 8px;">
                                                        <input v-model="offerinfo.main.accident_violation" value="0" type="radio"> 
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                                <h5 class="block-title text-bold">Background </h5>

                                <table class="table table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>Degree</th>
                                            <th>Name of school</th>
                                            <th>Location(Mailing Address)</th>
                                            <th>No. of years Completed</th>
                                            <th>Major</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(rrx, ind) of offerinfo.background">
                                            <td><input v-model="rrx.degree" class="form-control"></td>
                                            <td><input v-model="rrx.school" class="form-control"></td>
                                            <td><input v-model="rrx.location" class="form-control"></td>
                                            <td><input v-model="rrx.years" class="form-control"></td>
                                            <td><input v-model="rrx.major" class="form-control"></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="">
                                    <div class="form-group row">
                                        <label class="col-sm-8 col-form-label">Have you ever been in the armed forces?</label>

                                        <div class="col-sm-4">
                                            <label class="form-check-label">
                                                <input v-model="offerinfo.personal_specified.armed_force" value="1" type="radio"> 
                                                Yes
                                            </label>
                                            <label class="form-check-label" style="margin-left:20px;padding-top: 8px;">
                                                <input v-model="offerinfo.personal_specified.armed_force" value="0" type="radio"> 
                                                No
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-8 col-form-label">Are you now a member of the National Guard?</label>

                                        <div class="col-sm-4">
                                            <label class="form-check-label">
                                                <input v-model="offerinfo.personal_specified.national_guard" value="1" type="radio"> 
                                                Yes
                                            </label>
                                            <label class="form-check-label" style="margin-left:20px;padding-top: 8px;">
                                                <input v-model="offerinfo.personal_specified.national_guard" value="0" type="radio"> 
                                                No
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Specialty</label>
                                        <div class="col-sm-2">
                                            <input v-model="offerinfo.personal_specified.speciality" class="form-control">
                                        </div>
                                        <label class="col-sm-2 col-form-label">Date Entered</label>
                                        <div class="col-sm-2">
                                            <input v-model="offerinfo.personal_specified.enterdate" class="form-control">
                                        </div>
                                        <label class="col-sm-2 col-form-label">Discharge Date</label>
                                        <div class="col-sm-2">
                                            <input v-model="offerinfo.personal_specified.dischargedate" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h5 class="block-title text-bold" v-if="offerinfo.notes.length">Notes</h5>
                                <label v-if="offerinfo.notes.length">Your work experience for the past five years beginning with you most recent job held, if you were self employed, write the company name and details, attach additional sheets if necessary.</label>

                                <div v-for="(note,nind) in offerinfo.notes" style="border:solid 1px #aaa;padding:10px;position:relative;margin-bottom: 30px;">
                                    <button v-on:click="removeNote(nind)" style="position:absolute;right:0;top:0;"><i class="fa fa-minus-circle"></i></button>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Name of employer</label>

                                        <div class="col-sm-4">
                                            <input v-model="note.empname" class="form-control"> 
                                        </div>
                                        <label class="col-sm-2 col-form-label">Name of Last Supervisor</label>

                                        <div class="col-sm-3">
                                            <input v-model="note.supervisor" class="form-control"> 
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Full Address</label>

                                        <div class="col-sm-3">
                                            <input v-model="note.fulladdress" class="form-control"> 
                                        </div>
                                        <label class="col-sm-4 col-form-label">Start and Stop Dates of Employment</label>

                                        <div class="col-sm-3">
                                            <input v-model="note.emp_start_end" class="form-control"> 
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">City</label>

                                        <div class="col-sm-2">
                                            <input v-model="note.city" class="form-control"> 
                                        </div>
                                        <label class="col-sm-1 col-form-label">State</label>

                                        <div class="col-sm-2">
                                            <input v-model="note.state" class="form-control"> 
                                        </div>
                                        <label class="col-sm-1 col-form-label">Zip code</label>

                                        <div class="col-sm-2">
                                            <input v-model="note.zipcode" class="form-control"> 
                                        </div>
                                        <label class="col-sm-1 col-form-label">Salary</label>

                                        <div class="col-sm-2">
                                            <input v-model="note.pay_salary" class="form-control"> 
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Phone No</label>

                                        <div class="col-sm-2">
                                            <input v-model="note.phone_no" class="form-control"> 
                                        </div>
                                        <label class="col-sm-1 col-form-label">Last Job</label>

                                        <div class="col-sm-2">
                                            <input v-model="note.lastjob" class="form-control"> 
                                        </div>
                                        <label class="col-sm-2 col-form-label">Reason of Leaving</label>

                                        <div class="col-sm-4">
                                            <input v-model="note.reason_leaving" class="form-control"> 
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label">
                                            List the jobs you held, duties performed, skills used, learned advancements or promotions while you worked at this company.
                                        </label>

                                        <div class="col-sm-7">
                                            <textarea v-model="note.lastjob_detail" class="form-control" rows="3"></textarea> 
                                        </div>
                                    </div>

                                </div>

                                <hr>

                                <div class="">
                                    <div class="form-group row">
                                        <label class="col-sm-8 col-form-label">Can we contact you present emplyoer?</label>

                                        <div class="col-sm-4">
                                            <label class="form-check-label">
                                                <input v-model="offerinfo.contactable_to_employer" value="1" type="radio"> 
                                                Yes
                                            </label>
                                            <label class="form-check-label" style="margin-left:20px;padding-top: 8px;">
                                                <input v-model="offerinfo.contactable_to_employer" value="0" type="radio"> 
                                                No
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-8 col-form-label">Did you complete this application by yourself?</label>

                                        <div class="col-sm-4">
                                            <label class="form-check-label">
                                                <input v-model="offerinfo.completed_self" value="1" type="radio"> 
                                                Yes
                                            </label>
                                            <label class="form-check-label" style="margin-left:20px;padding-top: 8px;">
                                                <input v-model="offerinfo.completed_self" value="0" type="radio"> 
                                                No
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label">If no, who completed the application?</label>
                                        <div class="col-sm-7">
                                            <input v-model="offerinfo.completed_who" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        Application from sometime make it difficult for an individual to adequately summarize a complete background. In the space below, summarize any additional information necessary to describe you full qualifications for the position for which you are applying.
                                    </label>
                                    <div class="col-sm-12">
                                        <textarea v-model="offerinfo.addition_info" class="form-control" rows="5"></textarea>
                                    </div>
                                </div>

                            </div>

                            <div id="applied_test" class="tab-pane ">
                                <div class="job-apply">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-7">

                                            <h2 class="mt-lg text-info">{{$job->name}}</h2>
                                            <!--<p class="">{{$job->description}}</p>-->
                                        </div>
                                        <div class="col-sm-12 col-md-5 text-right">
                                            <a href="#myModal" class="btn btn-info btn-lg" data-backdrop="false" data-toggle="modal">Captured Video</a>
                                        </div>
                                    </div>

                                    <hr style="margin-bottom: 40px;">

                                    <div class="typing-body">
                                        @if($job->test_type == 1)
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
                                        @else
                                            <?php $typingResult = json_decode($apply->apply_result, true); ?>
                                            @foreach($quizs as $q)

                                                @if($q->qtype == 1)<!--operator text: speaking-->

                                                <div class="row operator completed" iid="{{$q->id}}">
                                                    <div class="flag text-warning">
                                                        <span class="fa fa-microphone"></span>
                                                        <span class="a">Operator&nbsp;</span>
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
                                                        <span class="a">Caller&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                        <a class="typing-start"><i class="fa fa-play"></i></a>
                                                        <audio src="{{url('public/'.$q->recording_audio)}}"></audio>
                                                    </div>
                                                    <label class="result">
                                                        <span class="alert alert-warning" style="padding:2px 5px;">
                                                            <?php echo $typingResult[$q->id] ? ('Typo: ' . $typingResult[$q->id]['typo']) : '' ?>, 
                                                            <?php echo $typingResult[$q->id] ? ('Accuracy: ' . $typingResult[$q->id]['accuracy'] * 1) : '' ?>
                                                        </span>
                                                    </label>
                                                    <div class="col-sm-12">
                                                        <div class="text form-control" ><?php echo $typingResult[$q->id] ? $typingResult[$q->id]['evaluated'] : '' ?></div>
                                                    </div>
                                                </div>

                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <hr>

                                    <div id="myModal" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="cursor:move;">
                                                    <h4 class="modal-title">
                                                        <i class="fa fa-arrows-alt"></i> Captured Video
                                                    </h4>  
                                                    <div class="modal-actions">

                                                    </div>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection

@section('scripts')

<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script>

var _jobid = {{$job -> id}}

new Vue({
el: "#apply_online",
        data: {
        personal: {phone: '{{$applicantInfo->phone}}', email: '{{$applicantInfo->email}}'},
                offerinfo: <?php echo $applicantInfo->orderinfo ? $applicantInfo->orderinfo : '{}' ?>,
        },
});
$('a.typing-start').click(function(){
var audio = $(this).next('audio').get(0);
if ($('i', this).hasClass('fa-play')){

$('i', this).removeClass('fa-play')
        .addClass('fa-stop');
audio.play();
} else if ($('i', this).hasClass('fa-stop')){

$('i', this).removeClass('fa-stop')
        .addClass('fa-play');
audio.pause();
}
})

        $("#myModal").draggable({
handle: ".modal-header"
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
if (result.value && result.value === true) {
$.post('{{url("")}}/admin/applicant/delete', {'id': id, _token: $('input[name=_token]').val()}, function (r) {
Swal.fire(
        'Deleted!',
        'The applicant has been deleted.',
        'success'
        ).then(() => {
location.reload();
})
})
}
})
});
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
<script>

</script>
@endsection