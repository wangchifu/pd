<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_code',
        'school_name',        
        'suggestion',
        'upload_id',      
        'report_id',
        'user_id',        
    ]; 
}
