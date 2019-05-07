<?php

namespace App\Http\Controllers;

use Storage;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Job;
use App\Models\Quiz;
use App\Models\Applicants;
use App\Models\Traning;
use App\User;

class JobsController extends Controller
{
    public function index()
    {
        if(request('checking_apply')){
            
            if(!Job::find(request('checking_apply'))->quizs->count())
                die( json_encode(['res'=>0]) );
            
            if(!Auth::check()){
                die( json_encode(['res'=>-1]) );
            }else if(!auth()->user()->email_verified_at){
                die( json_encode(['res'=>-2]) );
            }else if(!auth()->user()->orderinfo){
                die( json_encode(['res'=>-3]) );
            }
            
            die(json_encode(['res'=>'ok']));
        }else if(request('id')){
            
            $job = Job::find(request('id'));
            $job->poster = $job->owner;

            if(Auth::check()){

                $applicant = $job->myapplication;
                if($applicant){
                    $job->myapplication = $applicant;
                }   
            }
            die($job->toJson());
        }else if(request('zip')){
            
            $jobs = Job::where('zipcode','LIKE',"%".request('zip')."%")->latest()->paginate(10);
        }else{
            
            $jobs = Job::latest()->paginate(10);
        }
        
        return view('home.jobindex', ['jobs'=>$jobs]);
    }
    
    public function apply(Request $request){
        $id = $request->input('j');
        $job = Job::find($id);
        if($job->myapplication){
            return Redirect::back();
        }
        $quizs = $job->quizs;
        return view($job->test_type == 1 ? 'home.apply1' : 'home.apply2', ['job'=>$job, 'quizs'=>$quizs]);
    }
    
    public function traning(Request $request){
        $id = $request->input('j');
        $job = Job::find($id);
        $quizs = $job->quizs;
        
        $histories = Traning::where('applicant_id', auth()->user()->id)
                ->where('job_id', $job->id)
                ->orderBy('created_at')
                ->get();
        $logs = ['typos'=>[], 'accuracy'=>[], 'dates'=>[]];
        foreach($histories as $h){
            
            $typo = 0;
            $accuracy = 0;
            
            $tpc = $h->apply_result == '{}' ? [] : json_decode($h->apply_result, true);
            
            if($job->test_type == 1){
                $typo = $tpc['typo'];
                $accuracy = $tpc['accuracy'];
            }else{
                
                foreach($tpc as $hh){
                    $typo += $hh['typo'];
                    $accuracy += $hh['accuracy'];
                }
            }
            
            
            $logs['dates'][] = date('m/d', strtotime($h->created_at));
            $logs['typos'][] = $typo;
            $logs['accuracy'][] = count($tpc) ? round($accuracy / count($tpc)) : '';
        }
        
        return view($job->test_type == 1 ? 'home.traning1' : 'home.traning2', ['job'=>$job, 'quizs'=>$quizs, 'logs'=>$logs]);
    }
    
    public function savetraning(){
        $jobId = request('jobid');
        $recordFile = request('recordFile');
        $typingResult = request('typingResult');
    
        $row = new Traning;
        $row->applicant_id = auth()->user()->id;
        $row->job_id = $jobId;
        $row->apply_result = $typingResult;
        
        if($recordFile){
            $savePath = 'app/traning_recording/'. uniqid().'.webm';
            @unlink(public_path($savePath));
            @rename($recordFile->path(), public_path($savePath));
            @chmod(public_path($savePath), 0644);
            
            $row->capture_file = $savePath; 
        }
        $row->save();
        echo $row->id; exit();
    }
    
    public function saveapply(){
        $jobId = request('jobid');
        $recordFile = request('recordFile');
        $typingResult = request('typingResult');
        
        $row = new Applicants;
        $row->applicant_id = auth()->user()->id;
        $row->job_id = $jobId;
        $row->apply_result = $typingResult;
        $row->passed = 0;
        
        if($recordFile){
            $savePath = 'app/applicant_recording/'. uniqid().'.webm';
            @unlink(public_path($savePath));
            @rename($recordFile->path(), public_path($savePath));
            @chmod(public_path($savePath), 0644);
            
            $row->capture_file = $savePath; 
        }
        $row->save();
        exit('ok');
    }
    
    public function applyresult(Request $request){
        $id = $request->input('j');
        $job = Job::find($id);
        $quizs = $job->quizs;
        $apply = Applicants::where('job_id', $id)->where('applicant_id', auth()->user()->id)->first();
        
        
        return view($job->test_type ==1 ? 'home.viewapply1' : 'home.viewapply2', ['job'=>$job, 'quizs'=>$quizs, 'apply'=>$apply]);
    }
    public function traningresult(Request $request){
        $id = $request->input('id');
        $apply = Traning::find($id);
        
        $job = Job::find($apply->job_id);
        $quizs = $job->quizs;
        
        $histories = Traning::where('applicant_id', auth()->user()->id)
                ->where('job_id', $job->id)
                ->orderBy('created_at')
                ->get();
        $logs = ['typos'=>[], 'accuracy'=>[], 'dates'=>[]];
        foreach($histories as $h){
            
            $typo = 0;
            $accuracy = 0;
            $tpc = json_decode($h->apply_result, true);
            
            if($job->test_type == 1){
                $typo = $tpc['typo'];
                $accuracy = $tpc['accuracy'];
            }else{
                
                foreach($tpc as $hh){
                    $typo += $hh['typo'];
                    $accuracy += $hh['accuracy'];
                }
            }
            
            $logs['dates'][] = date('m/d', strtotime($h->created_at));
            $logs['typos'][] = $typo;
            $logs['accuracy'][] = round($accuracy / count($tpc));
        }
        
        return view($job->test_type == 1 ? 'home.viewtraning1' : 'home.viewtraning2', ['job'=>$job, 'quizs'=>$quizs, 'apply'=>$apply, 'logs'=>$logs]);
    }
    
    public function offerinfo(Request $request){
        $user = User::find(auth()->user()->id);
        $user->orderinfo = $request['offerinfo'];

        if (isset($_FILES['resumeFile'])) {
            $ext = strtolower(pathinfo($_FILES['resumeFile']['name'])['extension']);
            $file = '/app/resume/'.uniqid().'.'.$ext;
            $savePath = public_path().$file;
            @chmod(dirname($savePath), 0777);
            @unlink($savePath);
            rename($_FILES['resumeFile']['tmp_name'], $savePath);
            @chmod($savePath,0644);
            $user->resume_file = $file;
        }

        $user->save();
        die('ok');
    }
}
