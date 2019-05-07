@extends('home._page')

@section('css')
<link href="{{url('public')}}/front/css/register.css" rel="stylesheet">
<!--vue cdn link-->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
@endsection
@section('content')
<!--========================== Typing Section============================-->
<div class="wow fadeInUp">
    <div class="container">
        <div class="col-lg-12">
            <h1 class="mt-lg welcome-title">Welcome to TAS Agents!</h1>

            <h3 class="block-title">TAS Agents Employment Requirements</h3>
            <h6>
                We are a full service answering service operating 24 hours a day,
                365 days a year. The position for which you are applying will include weekends and holidays.
                We are strict on spelling, verifying names, phone numbers, and addresses as required for our client's tickets.
            </h6>
        </div>
    </div>
    
    <div id="apply_online" class="container">
        <div method="POST" action="" class="form container">
<!--            <div class="form-check">
                <input v-model="offerinfo.acceptment" class="form-check-input" type="checkbox">
                <label class="form-check-label">
                    I accept requirements
                </label>
            </div>-->

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
            <div class="form-group row">
                <label class="col-sm-6 col-lg-2 col-form-label">Password</label>
                <div class="col-sm-6 col-lg-3">
                    <input v-model="personal.password" class="form-control" type="password">
                </div>
                <label class="col-sm-6 col-lg-2 col-form-label">Password Confirm</label>
                <div class="col-sm-6 col-lg-3">
                    <input v-model="personal.password_confirm" class="form-control" type="password">
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
                            <label class="col-sm-2 col-form-label">Maiden Name</label>
                            <div class="col-sm-3">
                                <input v-model="offerinfo.main.maidenname" type="text" class="form-control">
                            </div>
                            <label class="col-sm-1 col-form-label">Date</label>
                            <div class="col-sm-2">
                                <input v-model="offerinfo.main.date" type="text" class="form-control">
                            </div>
                            <label class="col-sm-1 col-form-label">SSN</label>
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
                            <label class="col-sm-6 col-form-label">If age is under 18, please write the age</label>
                            <div class="col-sm-2">
                                <input v-model="offerinfo.main.age18" type="number" class="form-control" min="5" max="80">
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
                            <label class="col-sm-2 col-form-label">Desired Payment (hourly)</label>
                            <div class="col-sm-4">
                                <input v-model="offerinfo.main.desired_payment" type="text" class="form-control">
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
                            <label class="col-sm-2 col-form-label">Date you are available to start</label>
                            <div class="col-sm-4">
                                <input v-model="offerinfo.main.date_start" type="text" class="form-control">
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
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">What is you means of transportation to and from work?</label>
                            <div class="col-sm-7">
                                <input v-model="offerinfo.main.transportation" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Your driver's license number</label>
                            <div class="col-sm-2">
                                <input v-model="offerinfo.main.driver_licence_number" class="form-control">
                            </div>
                            <label class="col-sm-2 col-form-label">State of issue</label>
                            <div class="col-sm-2">
                                <select v-model="offerinfo.main.state_of_issue" class="form-control">
                                    <option disabled value="">Please select</option>
                                    <option>A</option>
                                </select>
                            </div>
                            <label class="col-sm-2 col-form-label">Expiration Date</label>
                            <div class="col-sm-2">
                                <input v-model="offerinfo.main.expiration_date" class="form-control">
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

                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">If Yes, how many?</label>
                            <div class="col-sm-7">
                                <input v-model="offerinfo.main.accident_violation_count" class="form-control" type="number" min="0">
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <h3 class="block-title">Background </h3>

            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>Degree</th>
                        <th>Name of school</th>
                        <th>Location(Mailing Address)</th>
                        <th>No. of years Completed</th>
                        <th>Major</th>
                        <th><button v-on:click="offerinfo.background.push(backgroundArray)" onclick="return false;"><i class="fa fa-plus-circle"></i></button></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(rr, ind) of offerinfo.background">
                        <td><input v-model="rr.degree" class="form-control"></td>
                        <td><input v-model="rr.school" class="form-control"></td>
                        <td><input v-model="rr.location" class="form-control"></td>
                        <td><input v-model="rr.years" class="form-control"></td>
                        <td><input v-model="rr.major" class="form-control"></td>
                        <td><button v-on:click="offerinfo.background.splice(index,1)"><i class="fa fa-remove"></i></button></td>
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
            <h5 class="block-title">Notes <button v-on:click="addNewNote()"><i class="fa fa-plus-circle"></i></button></h5>
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
            <h3>Attach Resume</h3>
            <div class="form-group row">
                <div class="col-sm-12">
                    <input type="file" id="resume-file" accept="application/pdf">
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-sm-12 text-center">
                    <button v-on:click="doRegister()" class="btn btn-info">Register</button>
                </div>
            </div>
            
        </div>
    </div>
    @csrf
    @endsection

    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="{{url('public')}}/front/js/register.js"></script>
@endsection