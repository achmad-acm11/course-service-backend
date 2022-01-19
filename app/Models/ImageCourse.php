<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        "image", "course_id"
    ];

    protected $cast = [
        "created_at" => "timestamp:Y-m-d H:m:s",
        "updated_at" => "timestamp:Y-m-d H:m:s"
    ];
}
