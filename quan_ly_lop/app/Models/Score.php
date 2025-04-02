<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Score extends Model
{
    use HasFactory;

    protected $table = 'score';
    protected $primaryKey = 'score_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'score_id',
        'student_id', // Khóa phụ
        'course_id',  // Khóa phụ
        'process_score',
        'midterm_score',
        'final_score',
        'average_score',
    ];
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($score) {
            $score->score_id = (string) Str::uuid();
        });
    }
    // Quan hệ với Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Quan hệ với Course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

}
