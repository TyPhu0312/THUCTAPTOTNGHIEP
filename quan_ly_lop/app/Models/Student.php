<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Student extends Model
{
    use HasFactory;
    protected $table = 'student';
    protected $primaryKey = 'student_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'student_id',
        'student_code', // Duy nhất
        'full_name',
        'school_email', // Duy nhất
        'password',
        'phone', // Duy nhất
    ];
    public $timestamps = true;

    protected $hidden = [
        'password',
    ];
    protected $casts = [
        'password' => 'hashed', // Laravel sẽ tự động hash mật khẩu khi lưu vào DB
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(fn($student) => $student->student_id = (string) Str::uuid());
    }

    public function scores()
    {
        return $this->hasMany(Score::class, 'student_id');
    }

    public function studentClasses()
    {
        return $this->hasMany(StudentClass::class, 'student_id');
    }
}
