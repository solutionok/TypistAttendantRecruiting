<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Job;
use App\Models\Quiz;
use App\Models\Applicants;
use App\User;

class HomeController extends Controller
{
   
    public function index()
    {   
        if(request('zip')){
            
            $jobs = Job::where('zipcode','LIKE',"%".request('zip')."%")->latest()->paginate(10);
        }else{
            
            $jobs = Job::select('zipcode', DB::raw('count(*) as ct'))->groupBy('zipcode')->get();
        }
        return view('home.index', ['jobs'=>$jobs]);
    }
    
    public function isrtc(Request $request){
        $testid = $request->input('testid');
        if(!$testid)
            die('nothing');
        
        if(!Quiz::where('test_id', $testid)->where('qtype',4)->count()){
            die('nothing');
        }
        
        die('has');
    }

    public function verified(){
        return view('home.verified');
    }
    public function welcome(){
        return view('home.welcome');
    }
}
