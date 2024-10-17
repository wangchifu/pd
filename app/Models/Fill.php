<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fill extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_code',
        'school_name',
        'filename',
        'upload_id',      
        'report_id',
        'user_id',             
    ];    

    public function upload()
    {
        return $this->belongsTo(Upload::class);
    }
    public function report()
    {
        return $this->belongsTo(Report::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function review_user()
    {
        return $this->belongsTo(User::class,'review_user_id','id');
    }
}
