<?php

namespace App\Http\Controllers\Admin;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    
    public function index(){
        
        $admin = DB::table('users')->where('id',auth()->user()->id)->first();
        return view('settings.index',['pageName'=>'settings', 'admin'=>$admin]);
    }
    public function account(Request $request){
        $d = $request->input();
        if(!empty($d['name'])&&!empty($d['email'])&&!empty($d['phone'])){
            DB::table('users')->where('id',auth()->user()->id)->update([
                'name' => $d['name'],
                'email' => $d['email'],
                'phone' => $d['phone'],
            ]);
        }
        
        return redirect('/admin/settings');
    }
    public function password(Request $request){
        $d = $request->input();
        
        $currentPasswordHash = DB::table('users')->where('id',auth()->user()->id)->first()->password;
        
        if(!Hash::check($request->current_password, $currentPasswordHash)){
            return redirect('/admin/settings');
        }
        
        $request->user()->fill([
            'password' => Hash::make($request->new_password)
        ])->save();
        
        return redirect('/admin/settings');
    }
    
    public function checkpass(Request $request){
        
        $currentPasswordHash = DB::table('users')->where('id',auth()->user()->id)->first()->password;
        
        if(!Hash::check($request->password, $currentPasswordHash)){
            exit('no');
        }
        exit('ok');
    }
}
