<?php

namespace App\Http\Controllers\Admin;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Response;
use App\Models\Job;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    
    

    public function index(Request $request){
        
        $ds = getReviewPageSearchDate($request);
        return view('review.index',[
            'pageName'=>'review', 
            'searchDateRange'=>$ds
        ]);
    }
    
    public function viewtest($id, $step = 0){
        $history = DB::table('test_history')->where('id', $id)->first();
        $steps = (array)json_decode($history->test_result);
        
        if(count($steps)<$step){
            return redirect('/admin/review/'.$id);
        }
        
        $test = DB::table('test')->where('id', $history->test_id)->first();
        $candidate = DB::table('users')->where('id', $history->candidate_id)->first();
        
        $quiz = $step ? $steps[$step-1] : false;
        
        $reviews = DB::table('review as a')
                ->select('a.*','b.name as assessorn','b.photo')
                ->join('users as b', 'b.id', '=', 'a.assessor_id')
                ->where('a.test_history_id', $id)
                ->where('a.quiz_id', $quiz ? $quiz->id : 0)
                ->get();
        
        $hasReview = DB::table('review as a')
                ->where('a.test_history_id', $id)
                ->get()->count();
        return view('review.view',[
            'pageName'=>'review', 
            'reviews'=>$reviews, 
            'step'=>$step, 
            'hasReview'=>$hasReview, 
            'steps'=>$steps, 
            'quiz'=>$quiz, 
            'history'=>$history, 
            'test'=>$test, 
            'candidate'=>$candidate, 
            'qtypes'=>self::$quizTypes]);
    }
    
    public function setGrade(Request $request){
        $historyId = $request->input('historyId');
        $quiz_id = $request->input('quiz_id', 0);
        $mark = $request->input('grade', 0);
        $comment = $request->input('review', '');

        $review = Db::table('review')
                ->where('test_history_id', $historyId)
                ->where('assessor_id', auth()->user()->id)
                ->where('quiz_id', $quiz_id)
                ->first();

        if(!$review){
            Db::table('review')->insert([
                'comment' => $comment,
                'grade' => $mark,
                'test_history_id' => $historyId,
                'assessor_id' => auth()->user()->id,
                'quiz_id' => $quiz_id,
                'review_time' => now(),
            ]);
        }else{
            Db::table('review')
                ->where('test_history_id', $historyId)
                ->where('assessor_id', auth()->user()->id)
                ->where('quiz_id', $quiz_id)
                ->update([
                    'comment' => $comment,
                    'grade' => $mark,
                    'review_time' => now(),
                ]);
        }

        if($quiz_id){
            $history = Db::table('test_history')->where('id', $historyId)->first();
            $history = (array) $history;
            $steps = (array)json_decode($history['test_result']);
            
            $avgGrade = Db::table('review')
                ->where('test_history_id', $historyId)
                ->where('quiz_id', $quiz_id)
                ->sum('grade');
            
            $totalmark = 0;
            foreach($steps as $i=>&$sp){
                $sp = (array)$sp;
                if($sp['id']==$quiz_id && intval($sp['qtype'])>2){
                    $sp['mark'] = $avgGrade;
                }
                $totalmark += empty($sp['mark']) ? 0 : $sp['mark'];
            }

            $history['grade'] = $totalmark;
            $history['test_result'] = json_encode($steps);
            $history = Db::table('test_history')->where('id', $historyId)->update($history);
        }
        
        
        die();
    }
    
    public function historyinfo(Request $request){
        $review = DB::table('review')
                ->where('test_history_id', $request->input('history_id'))
                ->where('assessor_id', auth()->user()->id)
                ->where('quiz_id', $request->input('quiz_id', 0))
                ->first();
        
        if($request->input('quiz_id', 0)){
            $history = DB::table('test_history')->where('id', $request->input('history_id'))->first();
            $re = ['comment'=>$review?$review->comment:''];
            
            foreach(json_decode($history->test_result) as $quiz){
                
                if($quiz->id == $request->input('quiz_id')){
                    $re['qtype'] = $quiz->qtype;
                    $re['grade'] = $quiz->grade;
                    $re['mark'] = intval($quiz->qtype)>2?($review?$review->grade:0):(isset($quiz->mark)?$quiz->mark:0);
                }
            }
            
            echo json_encode($re);
        }else{
            echo $review?$review->comment:'';
        }
        
        die;
    }
    
    public function exportcsv(Request $request){
        $testId = $request->input('it');
        $range = explode('/', $request->input('range'));
        $test = DB::table('test')->where('id', $testId)->first();
        $totalScore = DB::table('quiz')->where('test_id', $testId)->sum('grade');
        $minScore = $totalScore * $range[0]/100;
        $maxScore = $totalScore * $range[1]/100;
        
        $rows = DB::table('test_history as a')
                    ->join('users as b', 'b.id', '=', 'a.candidate_id')
                    ->where('a.test_id', $testId)
                    ->whereRaw('a.grade between ' . $minScore . ' and ' . $maxScore)
                    ->orderBy('a.grade', 'desc')
                    ->get()
                ;
        
        $filename = $test->name . "_Score_From_".$minScore."_TO_".$maxScore.".csv";
        @unlink($filename);
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('#', 'Name', 'E-mail', 'Phone', 'Date', 'Score'));

        foreach($rows as $i=>$row) {
            fputcsv($handle, array($i+1, $row->name, $row->email, $row->phone, $row->grade));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download(public_path().'/'. $filename, $filename, $headers);
    }
}
