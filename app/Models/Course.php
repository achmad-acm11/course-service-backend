<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ["name", "certificate", "thumbnail", "type", "status", "price", "level", "mentor_id", "description"];

    protected $cast = [
        "created_at" => "timestamp:Y-m-d H:m:s",
        "updated_at" => "timestamp:Y-m-d H:m:s"
    ];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class, "mentor_id", "id");
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class, "course_id", "id");
    }

    public function images()
    {
        return $this->hasMany(ImageCourse::class, "course_id", "id");
    }
}
