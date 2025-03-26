<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Submission extends Model
{
    use HasFactory;

    protected $table = 'submission';
    protected $primaryKey = 'submission_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'submission_id',
        'student_id',
        'exam_id',
        'assignment_id',
        'answer_file',
        'is_late',
        'temporary_score',
    ];

    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($submission) {
            $submission->submission_id = (string) Str::uuid();

            // Kiểm tra nếu cả `exam_id` và `assignment_id` cùng tồn tại hoặc cùng NULL
            if (!empty($submission->exam_id) && !empty($submission->assignment_id)) {
                throw ValidationException::withMessages([
                    'exam_id' => 'Bài nộp chỉ có thể thuộc về Exam hoặc Assignment, không thể cả hai.',
                    'assignment_id' => 'Bài nộp chỉ có thể thuộc về Exam hoặc Assignment, không thể cả hai.'
                ]);
            }

            if (empty($submission->exam_id) && empty($submission->assignment_id)) {
                throw ValidationException::withMessages([
                    'exam_id' => 'Bài nộp phải thuộc về một Exam hoặc Assignment.',
                    'assignment_id' => 'Bài nộp phải thuộc về một Exam hoặc Assignment.'
                ]);
            }
        });
    }


    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }
}
