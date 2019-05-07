<?php

namespace App\Http\Controllers\Admin;

use Storage;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\AgentMail;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Job;
use App\Models\Applicants;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    
    public function index(Request $request){
        $ds = getTestPageSearchDate($request);
        
        $selector = Job::whereBetween('created_at', $ds)->latest();
        
        if(isAssessor()){
            $selector->where('owner_id', auth()->user()->id);
        }
        
        $re = $selector->get();
        
        return view('job.index',['pageName'=>'job', 'jobList'=>$re, 'searchDateRange'=>$ds]);
    }
    
    public function getJob($id){
        $job = Job::find($id);
        echo $job->toJson();
    }
    
    public function saveJob(Request $request){
        if($request->input('job_id')){
            $id = $request->input('job_id');
            $job = Job::find($id);
        }else{
            $job = new Job;
            $job->owner_id = auth()->user()->id;
        }
        
        $job->name = $request->input('name');
        $job->description = $request->input('description');
        $job->zipcode = $request->input('zipcode');
        if($request->input('test_type'))
            $job->test_type = $request->input('test_type');
        $job->save();
        
        exit('<script>top.swal("'.('Test ' . ($request->input('job_id')?'Updated':'Created')).'").then(function(){top.location.reload();});</script>');
    }
    
    public function deleteJob(Request $request){
        Job::destroy($request->input('id'));
        
        foreach(Applicants::where('job_id', $request->input('id'))->get() as $applicant){
            $userId = $applicant->applicant_id;
            $applicant->delete();
            
            if(!Applicants::where('applicant_id', $userId)->count()){
                User::destroy($userId);
            }
        }
        die('ok');
    }
    
    public function toggle(Request $request){
        $id = $request->input('it');
        $active = DB::table('job')->where('id', $id)->value('active_status');
        DB::table('job')->where('id', $id)->update(['active_status'=>$active?0:1]);
        return redirect('admin/job');
    }
    
}
