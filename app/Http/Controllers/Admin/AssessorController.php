<?php

namespace App\Http\Controllers\Admin;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Job;

class AssessorController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    

    public function index(Request $request){
        $testId = $request->input('search-select','');
        $assessorWhat = $request->input('search-what','');

        $re = DB::table('users as a')
                ->where('a.isadmin', 2)
                ->whereRaw($assessorWhat
                        ? ('(a.name like "%'.$assessorWhat.'%" OR a.email like "%'.$assessorWhat.'%" OR a.phone like "%'.$assessorWhat.'%")')
                        : ('a.id>0'))
                ->groupBy('a.id')
                ->orderBy('created_at','desc')
                ->get();
        
        $searchSelect = '<select name="search-select" class="form-control" style="width:300px;" onchange="this.form.submit()">';
        $searchSelect .= '<option value="">Select Job</option>';
        foreach(Job::all() as $it){
            $searchSelect .= '<option value="'.$it->id.'" '.($testId==$it->id?'selected':'').'>'.$it->name.'</option>';
        }
        $searchSelect .= '</select>';
        
        return view('assessor.index',[
            'pageName'=>'assessor', 
            'searchFormAction'=>url('/admin/assessor'), 
            'searchWhat'=>$request->input('search-what'), 
            'searchPlaceholder'=>'Search by name, email, phone', 
            'searchSelect'=>$searchSelect, 
            'list'=>$re]);
    }
    
    public function saveAssessor(Request $request){
        if($request->input('assessor_id')){
            $id = $request->input('assessor_id');
            DB::table('users')
                    ->where('id', $id)
                    ->update([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'phone' => $request->input('phone'),
                        'orderinfo' => $request->input('orderinfo'),
                        'updated_at' => now(),
                    ]);
        }else{
            $id = DB::table('users')->insertGetId([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'orderinfo' => $request->input('orderinfo'),
                'created_at' => now(),
                'updated_at' => now(),
                'isadmin' => 2,
            ]);
        }
        
        if($request->input('new_password') || !$request->input('assessor_id')){
            $password = $request->input('new_password') ? $request->input('new_password') : $request->input('phone');
            
            /////////////////////
            $title = env('APP_NAME');
            $content = "Welcome ".$request->input('name')."! Your password was reseted with " . $password;

            sendMail($request->input('email'), $title, $content);
            /////////////////////////////
            
            DB::table('users')
                    ->where('id', $id)
                    ->update([
                        'password' => Hash::make($password),
                    ]);
        }
        
        
        if ($request->hasFile('preview_image')) {
            if($request->input('assessor_id')){
                $oldImage = DB::table('users')->where('id', $id)->value('photo');
                if($oldImage){
                    @unlink($oldImage);
                }
            }
            
            $savePath = $request->preview_image->store('app/assessor');
            if(!is_dir(dirname($savePath))){
                @mkdir(dirname($savePath));
                @chmod(dirname($savePath), 0777);
            }
            @unlink($savePath);
            @chmod(dirname($savePath), 0777);
            @rename($request->preview_image->path(), $savePath);
            DB::table('users')->where('id', $id)->update(['photo'=>$savePath]);
        }
        return redirect('admin/assessor');
    }
    public function remove(Request $request){
        $id = $request->input('id');
        $user = DB::table('users')->where('id', $id)->first();
        
        if(isset($user->photo)){
            @unlink(public_path().'/'.$user->photo);
        }
        
        DB::table('users')->where('id', $id)->delete();
        die('ok');
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
}
