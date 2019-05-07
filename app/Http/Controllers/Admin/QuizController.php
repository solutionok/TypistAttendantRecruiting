<?php

namespace App\Http\Controllers\Admin;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Job;
class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    
    public function index(Request $request){
        $job = Job::find($request->input('it'));
        $re = Quiz::where('job_id', $request->input('it'))->orderBy('order_val')->get();
        return view('quiz.index',['pageName'=>'job', 'quizList'=>$re, 'job'=>$job]);
    }
    
    public function saveQuiz(Request $request){
        $id = $request->input('quiz_id');
        if($id){
            $job = Quiz::find($id);
        }else{
            $job = new Quiz;
            $job->job_id = $request->input('job_id');
            $job->qtype = $request->input('qtype');
            $job->order_val = Quiz::where('job_id', $request->input('job_id'))->max('order_val') + 1;
        }
        
        $job->recording_text = $request->input('recording_text');
        
        if ($request->hasFile('recording_audio')) {
            if($id){
                $quiz = Quiz::find($id);
                if($quiz && $quiz->recording_audio){
                    @unlink(public_path($quiz->recording_audio));
                }
            }
            
            $ext = strtolower(pathinfo($request->recording_audio->getClientOriginalName())['extension']);
            $savePath = 'app/quiz_media/'. uniqid().'.'.$ext;
            
            if(!is_dir(dirname(public_path($savePath)))){
                @mkdir(dirname(public_path($savePath)));
                @chmod(dirname(public_path($savePath)), 0777);
            }
            
            @chmod(dirname(public_path($savePath)), 0777);
            @unlink(public_path($savePath));
            @rename($request->recording_audio->path(), public_path($savePath));
            @chmod(public_path($savePath), 0644);
            
            $job->recording_audio = $savePath;
        }
        
        $job->save();
        return redirect('admin/quiz?it='.$request->input('it'));
    }
    
    public function getQuiz($quizid){
        return (array) DB::table('quiz')->where('id', $quizid)->first(); 
    }
    
    public function deleteQuiz(Request $request){
        $id = $request->input('id');
        $attachMedia = Quiz::where('id', $id)->value('recording_audio');
        if($attachMedia){
            @unlink($attachMedia);
        }
        Quiz::where('id', $id)->delete();
        die('ok');
    }
    
    public function moveq($id,  Request $request){
        $moveArrow = $id>0 ? -1 : 1;
        $id = abs($id);
        
        $question = Quiz::find($id);
        
        $questionList = Quiz::where('job_id', $question->job_id)->orderBy('order_val')->get();
        
        foreach($questionList as $i=>$q){
            $q->order_val = $i+1;
            $q->save();
        }
        
        if(($moveArrow>0&&$question->order_val == count($questionList)) || ($moveArrow<0&&$question->order_val == 1)){
            return redirect()->back();
        }
        
        $questionList = Quiz::where('job_id', $question->job_id)->orderBy('order_val')->get();
        
        $question = Quiz::find($id);
        $swap = $questionList[$moveArrow>0 ? $question->order_val : ($question->order_val-2)];
        
        $swap->order_val = $moveArrow>0 ? ($swap->order_val-1) : ($swap->order_val+1);
        $question->order_val = $moveArrow>0 ? ($question->order_val+1) : ($question->order_val-1);
        
        $swap->save();
        $question->save();
        
        return redirect()->back();
    }
}
