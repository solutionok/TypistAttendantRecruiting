<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = "test";
    const UPDATED_AT = null;
    const CREATED_AT = null;
    
    
    public function assessors(){
        return $this->hasMany('App\Models\testAssessor');
    }
}
