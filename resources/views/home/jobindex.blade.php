@extends('home._page')
@section('css')
<link href="{{url('public/front/css/jobs.css')}}" rel="stylesheet"/>
@endsection
@section('content')
<form action="{{url('jobs')}}" class="search-jobs">
    <div class="container">
        <div class="row">
            <div class="col-sm-0 col-lg-2">
                <h1 class="text-right mb-0"><a href="{{url('/')}}" class="scrollto"><img src="{{url('public')}}/front/img/logo.h80.png" style="height:60px;"></a></h1>
            </div>
            <div class="col-sm-12 col-lg-8">

                <input type="search" name="zip" value="{{request('zip')}}" class="form-control" placeholder="Location"/>
            </div>
            <div class="col-sm-0 col-lg-2">
                <button type="submit" id="doQuickSearch2" class="btn btn-info">Find Jobs</button>
            </div>
        </div>
    </div>
</form>

<main id="main">

    <section id="jobs" class="wow fadeInUp">
        <div class="container">
            <div class="row">
                
                <div class="col-sm-8 offset-sm-2">

                    <div class="job-list" >
                        @foreach($jobs as $job)
                        <div class="job" iid='{{$job->id}}'>
                            <div class="row">
                                <div class="col-md-10">
                                    <h5 class="font-weight-bold text-tasagent"><i class="fa fa-desktop"></i> {{$job->name}}</h5>
                                </div>
                                <div class="col-md-2 text-right">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="job-body">
                                        <?php echo substr(strip_tags($job->description), 0, 150) ?>
                                    </div>
                                    <div class="job-label">
                                        <i class="fa fa-map-marker" style="font-size: 22px;"></i> {{$job->zipcode}}
                                        &nbsp;&nbsp;&nbsp;
                                        <i class="fa fa-users"></i> {{$job->applicants->count()?($job->applicants->count().' applicants applied') : 'no applicants applied'}}

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{ $jobs->withPath('jobs?zip='.request('zip'))->onEachSide(5)->links() }}
                </div>
                
                <div class="col-sm-6 hide">
                    <div class="job-detail-view">
                        <div class="card" iid="">
                            <div class="card-body">
                              <h4 class="card-title text-center job-title"></h4>
                              <div class="row">
                                    <div class="col-md-12 col-lg-8">
                                        <button class="btn btn-danger btn-sm do-apply">Apply</button>
                                        <button class="btn btn-info btn-sm view-apply">Result</button>
                                        <button class="btn btn-success btn-sm do-train">Training</button>
                                        <button class="btn btn-danger btn-sm view-calendar">Employer Schedule</button>
                                    </div>
                                    <div class="col-md-12 col-lg-4 text-right">
                                        <small class="text-muted job-date"></small>
                                        <small class="text-muted location"></small>
                                    </div>
                              </div>
                              <hr>
                              <p class="card-text job-detail-content"></p>
                              <p class="card-text">
                                  <!--<a href="#" class="btn btn-info mailto-employer">Contact to Employer</a>-->
                              </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

</main>

<div class="modal fade schedule-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-bold">Emplyer Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="calendar-frame" src="about:blank;" style="border: 0;width:100%;height:700px;"  frameborder="0" scrolling="no"></iframe>
            </div>
        </div>
    </div>
</div>
            
<div class="modal fade personal-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="apply_online">
            <div class="modal-header">
                <h5 class="modal-title text-bold" id="exampleModalLongTitle">Welcome to TAS Agents!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="col-lg-12">
                        <h5 class="block-title text-bold">TAS Agents Employment Requirements</h5>
                        <p>
                            We are a full service answering service operating 24 hours a day,
                            365 days a year. The position for which you are applying will include weekends and holidays.
                            We are strict on spelling, verifying names, phone numbers, and addresses as required for our client's tickets.
                        </p>
                    </div>
                </div>

                <div class="container">
                    <div class="form container">
                        <h5 class="block-title text-bold">Applicants may be tested for illegal drugs</h5>
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
                                            <Datepcker_date_start v-model="offerinfo.main.date_start"></Datepcker_date_start>
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
                                    <th><button v-on:click="addNewBackground()" onclick="return false;"><i class="fa fa-plus-circle"></i></button></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(rrx, ind) of offerinfo.background">
                                    <td><input v-model="rrx.degree" class="form-control"></td>
                                    <td><input v-model="rrx.school" class="form-control"></td>
                                    <td><input v-model="rrx.location" class="form-control"></td>
                                    <td><input v-model="rrx.years" class="form-control"></td>
                                    <td><input v-model="rrx.major" class="form-control"></td>
                                    <td><button v-on:click="offerinfo.background.splice(ind,1)"><i class="fa fa-remove"></i></button></td>
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
                                    <Datepcker_personal_entered></datepcker_personal_entered>
                                </div>
                                <label class="col-sm-2 col-form-label">Discharge Date</label>
                                <div class="col-sm-2">
                                    <Datepcker_personal_discharge></Datepcker_personal_discharge>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h5 class="block-title text-bold">Notes <button v-on:click="addNewNote()"><i class="fa fa-plus-circle"></i></button></h5>
                        <label>Your work experience for the past five years beginning with you most recent job held, if you were self employed, write the company name and details, attach additional sheets if necessary.</label>

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

                        <hr>
                        <h5>Attach Resume</h5>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="file" id="resume-file" accept="application/pdf">
                            </div>
                        </div>
                    </div>
                </div>
                @csrf
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" v-on:click="doRegister()">Send</button>
            </div>
        </div>
    </div>
</div>


@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vuejs-datepicker/1.5.4/vuejs-datepicker.min.js" type="text/javascript"></script> 
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script> 
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="{{url('public')}}/front/js/jobs.js?v1"></script>

@endsection