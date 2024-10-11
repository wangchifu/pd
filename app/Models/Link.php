<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',        
        'url',
        'side',
        'user_id',        
        'order_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
