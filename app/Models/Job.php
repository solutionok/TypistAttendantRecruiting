<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    
    protected $table = "job";
    
    public function owner(){
        return $this->hasOne('App\User', 'id', 'owner_id');
    }
    
    public function applicants(){
        return $this->hasMany('App\Models\Applicants', 'job_id', 'id');
    }
    
    public function quizs(){
        return $this->hasMany('App\Models\Quiz', 'job_id', 'id');
    }
    
    public function myapplication(){
        return $this->hasOne('App\Models\Applicants', 'job_id', 'id')->where('applicant_id', auth()->user()->id?auth()->user()->id:-1);
    }
}
