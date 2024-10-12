<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',        
        'start_date',
        'stop_date',
        'user_id',        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class)->orderBy('order_by', 'asc');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('order_by', 'asc');
    }
}
