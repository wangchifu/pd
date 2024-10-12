<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'order_by',
        'score',
        'report_id',
        'user_id',
        'standard',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
