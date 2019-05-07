<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Auth\Request;

class LoginController extends Controller {
    
    use AuthenticatesUsers;
    
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }
    
    public function redirectPath() {
        
        if (!Auth::user()->email_verified_at) {
            return '/email/verify';
        }
        
        if(isAdmin()){
            return '/admin/job';
        }else if(isAssessor()){
            return '/admin/job';
        }else{
            return '/home';
        }
    }
}
