<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    protected $fillable = [  
        'school_name',
        'school_code',
        'score',
        'report_id',
        'comment_id',      
        'user_id',             
    ];    

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }    
}
