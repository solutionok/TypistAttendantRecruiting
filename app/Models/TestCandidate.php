<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class testCandidate extends Model
{
    protected $table = "test_candidate";
    
    protected $fillable = [
        'test_id', 'candidate_id', 'assessor_id'
    ];
    
    const UPDATED_AT = null;
    const CREATED_AT = null;
    
}
