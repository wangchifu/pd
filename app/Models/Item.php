<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'order_by',
        'type',
        'year_id',        
        'user_id',        
    ];

    public function year()
    {
        return $this->belongsTo(Year::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
