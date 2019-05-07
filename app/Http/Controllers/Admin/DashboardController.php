<?php

namespace App\Http\Controllers\Admin;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Test;
use App\Models\TestHistory;
use App\Models\Review;
use App\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        
        if(isAdmin()) $this->adminDashboard ();
        else if(isAssessor()) $this->assessorDashboard ();
    }
    
    public function adminDashboard(){
        
        return view('dashboard.admin',[
            'pageName'=>'dashboard', 
            'tests'=>$tests, 
            'intTemplates'=>$intTemplates,
            'testCount'=>$testCount,
            'reviewCount'=>$reviewCount,
            'assessorCount'=>$assessorCount,
            'candidateCount'=>$candidateCount,
        ]);
    }
    public function assessorDashboard(){
        
        return view('dashboard.assessor',[
            'pageName'=>'dashboard', 
            'tests'=>$tests, 
            'intTemplates'=>$intTemplates,
            'testCount'=>$testCount,
            'reviewCount'=>$reviewCount,
            'assessorCount'=>$assessorCount,
            'candidateCount'=>$candidateCount,
        ]);
    }
}
