<?php

function isAdmin(){
    return auth()->user() && auth()->user()->isadmin == 1;
}

function isAssessor(){
    return auth()->user() && auth()->user()->isadmin == 2;
}

function isApplicant(){
    return auth()->user() && auth()->user()->isadmin == 0;
}

function checkTestDeadline($test, $isCandidate = true){
    
    if($isCandidate){
        $f = strtotime($test->ctf);
        $t = strtotime($test->ctt);
        $now = strtotime('now');
        
        if(!$f && !$t){
            return 1;
        }else if(!$f && !$t){
            return 1;
        }
    }
}
function testNames($ids){
    if(!$ids)$ids = '-1';
    $ids = explode(',', $ids);
    return implode(', ', DB::table('test')->whereIn('id', $ids)->pluck('name')->toArray());
}
function getTestPageSearchDate($request){
    $ds = [date('Y-m-d', strtotime('-2 months')), date('Y-m-d', strtotime('+1 months'))];
    $settingName = 'admin_test_page_search_date';
    
    if(empty($request->input('startd', false)) && empty($request->input('endd', false))){
        
        $dds = DB::table('settings')->where('setting_name', $settingName)->value('setting_value');
        if($dds){
            $ds = explode(',', $dds);
        }
    }else{
        
        $ds = [IT2LT($request->input('startd','')), IT2LT($request->input('endd',''))];
        $row = ['setting_name'=>$settingName, 'setting_value'=>implode(',', $ds)];
        
        if(DB::table('settings')->where('setting_name', $settingName)->count()){
            DB::table('settings')->where('setting_name', $settingName)->update($row);
        }else{
            DB::table('settings')->insert($row);
        }
    }
    return $ds;
}

function IT2LT($IT){
    $s = preg_split("/[\.\/\-\,]/",$IT);
    if(count($s)!=3||$s[2]<1001)return $IT;
    return sprintf('%04d-%02d-%02d', $s[2], $s[0], $s[1]);
}
function LT2IT($LT){
    $s = preg_split("/[\.\/\-\,]/",$LT);
    if(count($s)!=3||$s[0]<1001)return $LT;
    return sprintf('%02d.%02d.%04d', $s[1], $s[2], $s[0]);
}

/* for IST
function IT2LT($IT){
    $s = preg_split("/[\.\/\-\,]/",$IT);
    if(count($s)!=3||$s[2]<1001)return $IT;
    return sprintf('%04d-%02d-%02d', $s[2], $s[1], $s[0]);
}
function LT2IT($LT){
    $s = preg_split("/[\.\/\-\,]/",$LT);
    if(count($s)!=3||$s[0]<1001)return $LT;
    return sprintf('%02d.%02d.%04d', $s[2], $s[1], $s[0]);
}
*/
function getReviewPageSearchDate($request){
    $ds = [date('Y-m-d', strtotime('-1 months')), date('Y-m-d', strtotime('now'))];
    $settingName = 'review_page_search_date_'.auth()->user()->id;
    if(empty($request->input('startd', false)) && empty($request->input('endd', false))){
        $dds = DB::table('settings')->where('setting_name', $settingName)->value('setting_value');
        if($dds){
            $ds = explode(',', $dds);
        }
    }else{
        $ds = [IT2LT($request->input('startd','')), IT2LT($request->input('endd',''))];
        $row = ['setting_name'=>$settingName, 'setting_value'=>implode(',', $ds)];
        
        if(DB::table('settings')->where('setting_name', $settingName)->count()){
            DB::table('settings')->where('setting_name', $settingName)->update($row);
        }else{
            DB::table('settings')->insert($row);
        }
    }
    return $ds;
}
function getAssesorNames($ids, $ass, $getAll = false){
    if(empty($ids)||empty($ass)){
        return '';
    }
    
    $re = [];
    foreach(explode(',', $ids) as $id){
        $re[] = $ass[$id]->name;
    }
    
    if($getAll){
        return implode(', ', $re);
    }else{
        return count($re)>1 ? ($re[0].' and ' . (count($re)-1) . ' peoples') : $re[0];
    }
}

function deadlineCheck($deadline){
    return strtotime(IT2LT($deadline).' 23:59:59')>=strtotime('now');
}

function _df_($e){
    if(!$e)return '';
    $e = explode('/', $e);
    return sprintf('%04d-%02d-%02d', $e[2], $e[1], $e[0]);
}

function sendMail($to, $title, $content){
    try{
        Mail::send('emailtmp', ['title' => $title, 'content' => $content], function ($message) use ($to)
        {

            $message->from(env('MAIL_USERNAME'), env('APP_NAME'));

            $message->to($to);

        });
        return true;
    }catch(Exception $e){
        return false;
    }
}