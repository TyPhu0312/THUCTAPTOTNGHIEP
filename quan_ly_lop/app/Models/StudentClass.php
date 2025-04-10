<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StudentClass extends Model
{
    use HasFactory;
    protected $table = 'student_class';
    protected $primaryKey = 'student_class_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'student_class_id',
        'student_id',//Khoá phụ
        'class_id',// khoá phụ
        'status',
        'final_score',
    ];
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student_class) {
            $student_class->student_class_id = (string) Str::uuid();
        });
    }
    public static function getAllowedStatus()
    {
        return ['Active', 'Drop', 'Pending'];
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }
}
