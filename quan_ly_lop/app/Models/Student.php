<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'student';
    protected $primaryKey = 'student_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'student_id',
        'student_code',
        'full_name',
        'school_email',
        'phone',
        'password',
    ];
    public $timestamps = true;

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->student_id) {
                $model->student_id = (string) Str::uuid();
            }
        });
    }

    public function scores()
    {
        return $this->hasMany(Score::class, 'student_id');
    }

    public function studentClasses()
    {
        return $this->hasMany(StudentClass::class, 'student_id');
    }

    // Thêm các phương thức xác thực
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getAuthIdentifierName()
    {
        return 'student_id';
    }

    public function getAuthIdentifier()
    {
        return $this->getAttribute($this->getAuthIdentifierName());
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    // Thêm phương thức này để xác định trường dùng để đăng nhập
    public function username()
    {
        return 'school_email';
    }
}
