<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Classroom extends Model
{
    use HasFactory;
    protected $table = 'classroom';
    protected $primaryKey = 'class_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'class_id',
        'course_id',  // Khóa phụ
        'lecturer_id',//khoá phụ
        'class_code',
        'class_description',
        'class_duration',
    ];

    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($class) {
            $class->class_id = (string) Str::uuid();
        });
    }
    protected $casts = [
        'class_duration' => 'integer',
    ];

    // Quan hệ với StudentClass
    public function studentClasses()
    {
        return $this->hasMany(StudentClass::class, 'class_id');
    }

    // Quan hệ với Course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
     // Quan hệ với Lecturer
     public function lecturer()
     {
         return $this->belongsTo(Lecturer::class, 'lecturer_id');
     }
}
