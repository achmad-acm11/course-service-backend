<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'profession', 'email', 'profile'];
    
    protected $casts = [
        "created_at" => "timestamp:Y-m-d H:m:s",
        "update_at" => "timestamp:Y-m-d H:m:s"
    ];
}
