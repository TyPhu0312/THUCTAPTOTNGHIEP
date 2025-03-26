<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class Lecturer extends Model
{
    use HasFactory;
    protected $table = 'lecturer';
    protected $primaryKey = 'lecturer_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'lecturer_id',
        'fullname',
        'school_email',
        'personal_email',
        'phone',
        'password',
    ];
    public $timestamps = true;

    protected $hidden = [
        'password',
    ];
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lecturer) {
            $lecturer->lecturer_id = (string) Str::uuid();
        });
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class, 'lecturer_id');
    }

}
