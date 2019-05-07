<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class testAssessor extends Model
{
    protected $table = "test_assessor";
    
    protected $fillable = [
        'test_id', 'assessor_id'
    ];
    
    const UPDATED_AT = null;
    const CREATED_AT = null;
    
    public function test(){
        return $this->belongsTo('App\test');
    }
    
    public function user(){
        return $this->hasOne('User','id','assessor_id');
    }
}
