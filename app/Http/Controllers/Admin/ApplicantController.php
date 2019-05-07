<?php

namespace App\Http\Controllers\Admin;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Applicants;
use App\Models\Job;
use App\Models\Quiz;
use App\User;
use Response;

use App\Mail\AgentMail;
 

class ApplicantController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    
    public function invitmail($id){
        $applicant = Applicants::find($id);
        $user = User::find($applicant->applicant_id);
        
        $comment = "
        <h3>Hello, ".$user->name."!.</h3> 
        <p>You are invited from ".env('APP_NAME')."<br>Please contact us with below information</p>
        <p>
        <di><strong>Phone: ".env('SITE_PHONE')."</strong></div>
        <div><strong>Email: <a href='mailto:'>".env('SITE_ADMIN_MAIL')."</a>
        </strong>
        </div>
        </p>
               
        <p>Regards<br>".env('APP_NAME')."</p>
        ";
        $toEmail = $user->email;
        Mail::to($toEmail)->send(new AgentMail($comment));
        
        $applicant->passed=1;
        $applicant->pass_date=date('Y-m-d');
        $applicant->save();
        return 'ok';
    }
    
    public function invitmailbluk(Request $request){
        $ids = explode(',', $request->input('ids'));
        
        foreach($ids as $id){
            $this->invitmail($id);
        }

        return 'OK';
    }
    
    public function rejectmail($id){
        $applicant = Applicants::find($id);
        $user = User::find($applicant->applicant_id);
        
        $comment = "
        <h3>Hello, ".$user->name."!.</h3> 
        <p>Thank you for apply.<br>So we had decided as to refuse for your apply</p>
               
        <p>Best Regards<br>".env('APP_NAME')."</p>
        ";
        $toEmail = $user->email;
        Mail::to($toEmail)->send(new AgentMail($comment));
        
        $applicant->passed=-1;
        $applicant->pass_date=date('Y-m-d');
        $applicant->save();
        return 'Email has been sent to '. $toEmail;
    }
    
    public function rejectmailbluk(Request $request){
        
        $ids = explode(',', $request->input('ids'));
        
        foreach($ids as $id){
            $this->rejectmail($id);
        }

        return 'OK';
    }
    
    public function index(Request $request){
        $job_id = $request->input('search-select', '');
        
        $select = DB::table('applicants')
                ->join('users', 'users.id','=','applicants.applicant_id')
                ->join('job', 'job.id','=','applicants.job_id')
                ->select('applicants.*', 'users.name', 'users.phone', 'users.email', 'job.name as jobn')
                ->orderBy('applicants.created_at', 'desc')
                ;
        
        if(isAssessor()){
            $select->where('job.owner_id', auth()->user()->id);
            $jobs = Job::where('owner_id', auth()->user()->id)->latest()->get();
        }else{
            $jobs = Job::latest()->get();
        }
        
        if($job_id){
            $select->where('applicants.job_id', $job_id);
        }
        
        if($request->input('search-what','')){
            $select->whereRaw(('(users.name like "%'.$request->input('search-what').'%" OR users.email like "%'.$request->input('search-what').'%" OR users.phone like "%'.$request->input('search-what').'%")'));
        }
        $re = $select->get();
        $searchSelect = '<select name="search-select" class="form-control" style="width:300px;" onchange="this.form.submit()">';
        $searchSelect .= '<option value=""> -- Search by test -- </option>';
        foreach($jobs as $it){
            $searchSelect .= '<option value="'.$it->id.'" '.($job_id==$it->id?'selected':'').'>'.$it->name.'</option>';
        }
        $searchSelect .= '</select>';
        return view('applicant.index',[
            'pageName'=>'applicant', 
            'searchFormAction'=>url('/admin/applicant'), 
            'searchWhat'=>$request->input('search-what'), 
            'searchPlaceholder'=>'Search by name, email, phone', 
            'searchSelect'=>$searchSelect, 
            'list'=>$re, 
            'jobs'=>$jobs, 
            'test_id'=>$job_id]);
    }
    
    public function view(Request $request){
        $id= $request->input('id', false); 
        $apply = Applicants::find($id);
        $job = Job::find($apply->job_id);
        $quizs = Quiz::where('job_id', $apply->job_id)->get();
        $applicantInfo = User::find($apply->applicant_id);
        return view('applicant.view',['pageName'=>'applicant', 'apply'=>$apply, 'job'=>$job, 'quizs'=>$quizs, 'applicantInfo'=>$applicantInfo]);
    }
    
    public function remove(Request $request){
        $ids = $request->input('id');
        if(!is_array($ids)){
            $ids = (array)$ids;
        }
        foreach($ids as $id){
            if(!$id)continue;
            $applicant = Applicants::find($id);
            $userId = $applicant->applicant_id;
            $applicant->delete();
            
            if(!Applicants::where('applicant_id', $userId)->count()){
//                User::destroy($userId);
            }
        }
        die('ok');
    }
    
    public function save(Request $request){
        $employee_history = [];
        $education_history = [];
        $skill_grade = [];
        $data = $request->input();
        if(isset($data['emp-job'])){
            foreach($data['emp-job'] as $i=>$e){
                if(empty($data['emp-job'][$i]))continue;
                $employee_history[] = [$data['emp-job'][$i], $data['emp-from'][$i], $data['emp-to'][$i]];
            }
        }
        
        if(isset($data['edu-job'])){
            foreach($data['edu-job'] as $i=>$e){
                if(empty($data['edu-job'][$i]))continue;
                $education_history[] = [$data['edu-job'][$i], $data['edu-from'][$i], $data['edu-to'][$i]];
            }
        }
        
        if(isset($data['skill-label'])){
            foreach($data['skill-label'] as $i=>$e){
                if(empty($data['skill-label'][$i]))continue;
                $skill_grade[] = [$data['skill-label'][$i], $data['skill-level'][$i]];
            }
        }
        
        $user = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'created_at' => now(),
            'updated_at' => now(),
            'isadmin' => 0,
            'summary' => $data['summary'],
            'employee_history' => json_encode($employee_history),
            'education_history' => json_encode($education_history),
            'skill_grade' => json_encode($skill_grade),
        ];
        
        if($data['new_password']||!$request->input('candidate_id')){
            $setPassword = $data['new_password']?$data['new_password']:($user['phone']);
            $user['password'] = Hash::make($setPassword);
            
            /////////////////////
            $title = env('APP_NAME');
            $content = "Hello, ".$user['name']."! Your password is " . $setPassword;

            sendMail($user['email'], $title, $content);
            /////////////////////////////
        }
        
        if (isset($_FILES['preview_image'])&&!$_FILES['preview_image']['error']) {
            $ext = strtolower(pathinfo($_FILES['preview_image']['name'])['extension']);
            $file = 'app/candidate/'.uniqid().'.'.$ext;
            
            
            $savePath = public_path().'/'.$file;
            
            if(!is_dir(dirname($savePath))){
                @mkdir(dirname($savePath));
                @chmod(dirname($savePath), 0777);
            }
            @chmod(dirname($savePath), 0777);
            @unlink($savePath);
            rename($_FILES['preview_image']['tmp_name'], $savePath);
            $user['photo'] = $file;
        }
        
        
        if($request->input('candidate_id')){
            $id = $request->input('candidate_id');
            DB::table('users')
                    ->where('id', $id)
                    ->update($user);
        }else{
            $id = DB::table('users')->insertGetId($user);
        }
        
        //test candidate
        $assignedtestIds = array_filter(array_unique(explode(',', $request->input('assigned_test_ids', ''))));
        if(count($assignedtestIds)){
            
            DB::table('test_candidate')->where('candidate_id', $id)->whereNotIn('test_id',$assignedtestIds)->delete();

            /////////////////////
            $title = env('APP_NAME');
            $content = "Welcome ".$user['name']."! You are invited the " . $title . " test.";

            sendMail($user['email'], $title, $content);
            /////////////////////////////
            foreach($assignedtestIds as $it){
                $row = testCandidate::firstOrNew(['test_id'=>$it, 'candidate_id'=>$id]);
                $row->save();
            }
        }
        
        return redirect('admin/candidate');
    }
    
    public function emailcheck(Request $request){
        $email = $request->input('email');
        if(!$email)die;
        $id = $request->input('id');
        
        if($id && DB::table('users')->where('id','<>',$id)->where('email', 'like', $email)->count()){
            die('exists');
        }
        
        if(!$id && DB::table('users')->where('email', 'like', $email)->count()){
            die('exists');
        }
        
        die('ok');
    }
    
    public function bulkadd(Request $request){
        if($request->hasFile('bulkadd')&&$request->file('bulkadd')->isValid()){
            $csv = @array_map('str_getcsv', file($request->bulkadd->path()));
            if(empty($csv)){
                die('<script>top.bulkResult("Invalid template!")</script>');
            }
            
            $count = 0;
            $bads = [];
            $status = 'ok';
            
            foreach($csv as $i=>$f){
                filter_var($f);
                if($i==0 || empty($f) || count($f)<3) continue;
                
                if(!filter_var($f[2],FILTER_VALIDATE_EMAIL)){
                    $bads[] = 'Incorrect email (' . $f[2] . ')';
                    $status = 'error';
                    continue;
                }
                
                if(DB::table('users')->where('email',$f[2])->count()){
                    $bads[] = 'Exists aleady (' . $f[2] . ')';
                    $status = 'error';
                    continue;
                }
                
                $password = ($f[3]);
                
                $userId = DB::table('users')->insertGetId([
                    'name' => $f[1],
                    'email' => $f[2],
                    'phone' => $f[3],
                    'password' => Hash::make($password),
                    'summary' => @$f[4],
                    'created_at' => now(),
                    'updated_at' => now(),
                    'isadmin' => 0,
                ]);
                
                if($request->input('test_id')){
                    
                    DB::table('test_candidate')->insert(['test_id'=>$request->input('test_id'), 'candidate_id'=>$userId]);
                }
                
                $count++;
                
                $user = ['email' => $f[2],'name' => $f[1]];
                
                /////////////////////
                $setPassword = base64_encode($user['email']);
                $title = env('APP_NAME');
                $content = "Hello, ".$user['name']."! Your password is " . $setPassword;

                sendMail($user['email'], $title, $content);
                /////////////////////////////
            }
            
            $msg = !$count
                    ?('Occurred some errors<br>'.implode('<br>', $bads))
                    :($count.' candidates imported successfully!');
            
            die('<script>top.bulkResult("'.($msg).'")</script>');
        }
        
        die('<script>top.bulkResult("Failed upload!")</script>');
    }
    
    public function assigntest(Request $request){
        $testId = $request->testId;
        $assessorId = $request->assessorId;
        
        testAssessor::firstOrNew(['test_id'=>$testId, 'assessor_id'=>$assessorId])->save();
        
        foreach($request->candidateIds as $cid){
            testCandidate::where(['test_id'=>$testId, 'candidate_id'=>$cid])->delete();
            testCandidate::insert(['test_id'=>$testId, 'candidate_id'=>$cid, 'assessor_id'=>$assessorId]);
            
            /////////////////////
            $user = DB::table('users')->where('id',$cid)->first();
            $testN = DB::table('test')->where('id',$testId)->value('name');
            $title = env('APP_NAME');
            $content = "Welcome ".$user->name."! You are invited the " . $testN . " test.";

            sendMail($user->email, $title, $content);
            /////////////////////////////
        }
        die;
    }
    
    public function uploadcv(Request $request){
        if (isset($_FILES['cv-file'])&&!$_FILES['cv-file']['error']) {
            $ext = strtolower(pathinfo($_FILES['cv-file']['name'])['extension']);
            $file = 'app/cv/'.uniqid().'.'.$ext;
            $savePath = public_path().'/'.$file;
            
            if(!is_dir(dirname($savePath))){
                @mkdir(dirname($savePath));
                @chmod(dirname($savePath), 0777);
            }
            
            @chmod(dirname($savePath), 0777);
            @unlink($savePath);
            @rename($_FILES['cv-file']['tmp_name'], $savePath);
            DB::table('users')
                    ->where('id', $request->input('candidate_id'))
                    ->update(['cv'=>$file]);
            die('<script>top.alert("CV saved!");top.location.reload();</script>');
        }
    }
    
    public function assessors($testId, Request $request){
        if(!$testId)echo '[]';
        $assessorIds = Test::find($testId)->assessors->pluck('assessor_id');
        $assessorIds[]=-1;
        $assessors = User::find($assessorIds)->toArray();
        echo json_encode($assessors);
    }
    
    public function downcsv(Request $request){
        $ids = explode(',', $request->input('ids','-1'));
        
        $select = DB::table('users as a')
                ->leftJoin('test_candidate as b', 'b.candidate_id','=','a.id')
                ->where('isadmin',0)
                ->whereIn('a.id', $ids)
                ->groupBy('a.id')
                ;
        
        $filename = "Candidates.csv";
        @unlink($filename);
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('S.No', 'Name', 'E-mail', 'Phone'));

        foreach($select->get() as $i=>$row) {
            fputcsv($handle, array($i+1, $row->name, $row->email, $row->phone));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download(public_path().'/'. $filename, $filename, $headers);
    }
}
