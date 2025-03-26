<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;
    protected $table = 'course';
    protected $primaryKey = 'course_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'course_id',
        'course_name',
        'process_ratio',
        'midterm_ratio',
        'final_ratio',
    ];

    public $timestamps = true;

    protected $casts = [
        'process_ratio' => 'float',
        'midterm_ratio' => 'float',
        'final_ratio' => 'float',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            $course->course_id = (string) Str::uuid();
        });
    }

}
